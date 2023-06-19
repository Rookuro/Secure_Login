<?php

class otp
{

    public function __construct()
    {
        //Check if the token already exist
        $token = JWT::getTokenFromCookie();
        $auth = JWT::getAuthorization();
        //Check if the token are connected or not
        if ($token === null || $auth === null) {
            header('Location: login');
            exit();
        }
        //See the path change pass 
        if ($auth === true) {
            $guid = JWT::getGuid();
            $user = new user();
            $otp = $user->checkOtp($guid);
            if ($otp !== null) {
                $rep = "Voici l'OTP si vous voulez changer de MDP cliquez ici : " . $otp;
            } else {
                $rep = "pas d'otp en cours";
            }
        }
        // route otp
        else {
            $guid = JWT::getGuid();
            $user = new user();
            $otp = $user->checkOtp($guid);
            if ($otp !== null) {
                $rep = "Voici l'OTP si vous voulez valider votre compte cliquez ici : " . $otp;
            } else {
                $rep = "pas d'otp en cours";
            }
        }
        require_once('./src/Views/otp.php');
    }
}
