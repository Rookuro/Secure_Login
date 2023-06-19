<?php

class JWT
{

    //Function main dechif
    public static function chiffre(string $guid, string $email, string $authorization)
    {
        $privateKey = JSON::keyExecute('privateKey');

        $date = self::timeStamp();

        // generate token
        $token = self::generateJWT($privateKey, $guid, $email, $authorization, $date);

        // set token
        header('Accreditation:' . $token);
        setcookie("Accreditation", $token);
    }

    //Check encoder bit64
    public static function base64UrlEncode($data)
    {
        $urlSafeData = strtr(base64_encode($data), '+/', '-_');
        return rtrim($urlSafeData, '=');
    }

    //Check current date + time
    public static function timeStamp()
    {
        date_default_timezone_set('Europe/Paris');
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $dateActuelle = date('d/m/Y');
        $heureActuelle = date('H:i');

        return $dateActuelle . ' ' . $heureActuelle;
    }

    //Generation token JWT
    public static function generateJWT($privateKey, $guid, $email, $authorization, $date)
    {
        // En-tête du token
        $header = array(
            'alg' => 'HS512',
            'typ' => 'JWT'
        );
        $encodedHeader = self::base64UrlEncode(json_encode($header));

        //Data of token
        $payload = array(
            'guid' => $guid,
            'email' => $email,
            'authorization' => $authorization,
            'date' => $date
        );
        $encodedPayload = self::base64UrlEncode(json_encode($payload));

        //Sign by a token
        $signature = hash_hmac('sha512', $encodedHeader . '.' . $encodedPayload, $privateKey, true);
        $encodedSignature = self::base64UrlEncode($signature);

        //Assembly all of token
        $token = $encodedHeader . '.' . $encodedPayload . '.' . $encodedSignature;

        return $token;
    }

    //Big function main dechif
    public static function dechiffre()
    {
        $privateKey = JSON::keyExecute('privateKey');

        //Verif Token
        $token = self::getTokenFromCookie();

        //Verif token a take it data of this
        $decodedToken = self::reverseJWT($token, $privateKey);
        return $decodedToken;
    }

    //Encoder in 64 bit
    public static function base64UrlDecode($data)
    {
        $base64Data = strtr($data, '-_', '+/');
        $parseData = str_pad($base64Data, strlen($base64Data) % 4, '=', STR_PAD_RIGHT);
        return base64_decode($parseData);
    }


    //Big reverse token JWT
    public static function reverseJWT($token, $privateKey)
    {
        //Big token part
        $tokenParts = explode('.', $token);
        if (count($tokenParts) !== 3) {
            return false;
        }

        //Decod
        $header = json_decode(self::base64UrlDecode($tokenParts[0]), true);
        $payload = json_decode(self::base64UrlDecode($tokenParts[1]), true);
        $signature = self::base64UrlDecode($tokenParts[2]);

        //Verify
        if (!isset($header['alg']) || $header['alg'] !== 'HS512' || !isset($header['typ']) || $header['typ'] !== 'JWT') {
            return false;
        }

        //Signature VERIFY
        $expectedSignature = hash_hmac('sha512', $tokenParts[0] . '.' . $tokenParts[1], $privateKey, true);
        if (!hash_equals($signature, $expectedSignature)) {
            return false;
        }

        //Big token data
        return $payload;
    }

    //Big get cookie
    public static function getTokenFromCookie(): ?string
    {
        if (isset($_COOKIE['Accreditation'])) {
            return $_COOKIE['Accreditation'];
        } 
        return null;
    }

    public static function getAuthorization(): ?bool {
        $auth = self::dechiffre();
        if (isset($auth["authorization"])) {
            if ($auth["authorization"] === "validate") {
                return true;
            } else if ($auth["authorization"] === "unvalidate") {
                return false;
            }
        }
        return null;
    }

    public static function getGuid() {
        $auth = self::dechiffre();
        return $auth["guid"];
    }
}
