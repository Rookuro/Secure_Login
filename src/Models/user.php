<?php
require_once("./src/Models/control.php");

class user extends control
{

    //create random guid
    private function guid(): string
    {
        return $this->request1("SELECT UUID()")->fetchColumn();
    }

    // current timestamp
    private function timestamp(): string
    {
        return $this->request1("SELECT NOW()")->fetchColumn();
    }

    // random salt
    private function saltPass(): string
    {
        return bin2hex(random_bytes(16));
    }

    // random stretch
    private function stretchPass(): int
    {
        return random_int(5000, 15000);
    }

    //hash password sha512, salt and stretch
    private function hashPass(string $pass, string $salt, string $stretch): string
    {
        for ($i = 0; $i < $stretch; $i++) {
            $pass = hash('sha512', $pass . $salt);
        }
        return $pass;
    }

    //webService function
    // public function setWebService(string $guid, string $arg)
    // {
    //     $webService = JSON::roleExecute($arg);
    //     $this->request2("INSERT INTO `accountautorization`(`guid`, `webService`) VALUES (:guid,:webService)", ['guid' => $guid, 'webService' => $webService]);
    // }

    //register user function
    public function checkEmailExist(string $email): ?string
    {
        $rep = $this->request2("SELECT `email` FROM `user` WHERE email=:email", ['email' => $email])->fetch(PDO::FETCH_ASSOC);
        if (empty($rep)) {
            return null;
        }
        return $rep['email'];
    }

    //create otp date function
    public function otpDate(): string
    {
        $currentTimestamp = $this->timestamp();
        $dateTime = new DateTime($currentTimestamp);

        //add 10 minutes to current timestamp
        $dateTime->add(new DateInterval('PT10M'));
        // format the date
        return $dateTime->format('Y-m-d H:i:s');
    }

    //create otp function
    public function createNewOtp(string $guid): ?string
    {
        $otp = $this->saltPass();
        $validity = $this->otpDate();
        $this->request2("INSERT INTO `accountotp`(`guid`, `otp`, `validity`) VALUES (:guid, :otp, :validity)", ['guid' => $guid, 'otp' => $otp, 'validity' => $validity])->fetch(PDO::FETCH_ASSOC);
        return $otp;
    }

    //check if there is a otp
    public function checkOtp(string $guid)
    {
        $rep = $this->request2("SELECT `guid`, `otp`, `validity` FROM `accountotp` WHERE `guid`=:guid limit 1", ['guid' => $guid])->fetch(PDO::FETCH_ASSOC);
        if ($rep === false) {
            return null;
        }
        return $rep['otp'];
        // $this->request2("INSERT INTO `account` (guid, pwd, salt, stretch) SELECT `guid`, `pwd`, `salt`, `stretch` FROM accounttmp WHERE guid = :guid", array(":guid" => $guid));
        // $this->request2("DELETE FROM `accounttmp` WHERE `guid`=:guid", ['guid' => $rep['guid']]);
    }

    //verify otp function
    public function verifOtp(string $otp): ?bool
    {
        $rep = $this->request2("SELECT `guid`, `otp`, `validity` FROM `accountotp` WHERE `otp`=:otp", ['otp' => $otp])->fetch(PDO::FETCH_ASSOC);
        if ($rep === false) {
            return false;
        }
        $validity = $this->checkOtpDate($rep['validity']);
        if ($validity === false) {
            $this->newoneOtp($rep['guid']);
            return null;
        }
        $this->succeedOtp($rep['guid']);
        return null;
    }

    public function succeedOtp(string $guid)
    {
        $this->request2("INSERT INTO `account` (guid, pwd, salt, stretch) SELECT `guid`, `pwd`, `salt`, `stretch` FROM accounttmp WHERE guid=:guid", array(":guid" => $guid));
        $this->request2("DELETE FROM `accounttmp` WHERE `guid`=:guid", ['guid' => $guid]);
        $this->request2("DELETE FROM `accountotp` WHERE `guid`=:guid", ['guid' => $guid]);
    }
    

    public function newoneOtp(string $guid)
    {
        $otp = $this->saltPass();
        $validity = $this->otpDate();
        $this->request2("DELETE FROM `accountotp` WHERE `guid`=:guid", ['guid' => $guid]);
        $this->request2("INSERT INTO `accountotp`(guid, OTP, validity) VALUES (:guid,:OTP,:validity)", ['guid' => $guid, 'otp' => $otp, 'validity' => $validity]);
    }

    //Function qui regarde si le mail est encore actif
    public function checkOtpDate(string $dateString): bool
    {
        $currentDateTime = $this->timestamp();

        return $dateString >= $currentDateTime;
    }

    //Function Check the password user for register
    public function JScheckPassword(string $pass, string $pass2): ?string
    {
        if ($pass !== $pass2) {
            return "Les mots de passe ne sont pas les mêmes !";
        }
        if (strlen($pass) !== 128) {
            return "Le mot de passe à changé !";
        }
        return null;
    }

    //Function for change password
    public function verifAccounttmp($guid): ?string
    {
        $req = $this->request2("SELECT `guid` FROM `accounttmp` WHERE `guid`=:guid", ['guid' => $guid])->fetch();

        if ($req !== null) {
            return "Vous avez déjà une demande en cours !";
        }
        return null;
    }

    //Function for change password
    public function changePass(string $guid, string $pass, string $newPass): ?string
    {
        $req = $this->request2("SELECT `guid`, `pwd`, `salt`, `stretch` FROM `user` NATURAL JOIN `account` WHERE `guid`=:guid", ['guid' => $guid])->fetch();

        if ($req === null) {
            return "Une erreur est survenue ! Essayer de vous reconnecter.";
        }

        $hashedPass = $this->hashPass($pass, $req['salt'], $req['stretch']);
        if ($hashedPass !== $req['pwd']) {
            return "Le mot de passe actuel que vous avez entré est incorrect !";
        }

        $salt = $this->saltPass();
        $stretch = $this->stretchPass();
        $pwd = $this->hashPass($newPass, $salt, $stretch);
        $this->request2("INSERT INTO `accounttmp`(`guid`, `pwd`, `salt`, `stretch`) VALUES (:guid,:pwd,:salt,:stretch)", ['guid' => $req['guid'], 'pwd' => $pwd, 'salt' => $salt, 'stretch' => $stretch]);
        $this->createNewOtp($guid);
        return null;
    }

    //Make date and hours for function checkAttemptsAndTime
    public function TimeDate(): string
    {
        $currentTimestamp = $this->timestamp();
        $dateTime = new DateTime($currentTimestamp);

        // format the date
        return $dateTime->format('Y-m-d H:i:s');
    }

    //Anti brute force for login
    public function checkAttemptsAndTime($guid): bool
    {
        $stmt = $this->request2("SELECT COUNT(*) AS num_attempts, MAX(TIMESTAMPDIFF(SECOND, `time`, NOW())) AS time_difference FROM accountattemps WHERE guid = :guid", ['guid' => $guid]);

        $result = $stmt->fetch();

        if ($result !== false) {
            $numAttempts = (int) $result['num_attempts'];
            $timeDifference = (int) $result['time_difference'];

            if ($numAttempts >= 3 && $timeDifference > 180) {
                // Réinitialiser le compteur de tentatives
                $this->request2("REPLACE INTO accountattemps (guid, time) VALUES (:guid, :time)", ['guid' => $guid, 'time' => $this->TimeDate()]);
                return true;
            } elseif ($numAttempts < 3) {
                $time = $this->TimeDate();
                $this->request2("INSERT INTO accountattemps (guid, time) VALUES (:guid, :time)", ['guid' => $guid, 'time' => $time]);
            }
        }

        return false;
    }

    //Function register for user connection
    public function register(string $email, string $pass)
    {
        //try expept ou pas ?
        $guid = $this->guid();
        $salt = $this->saltPass();
        $stretch = $this->stretchPass();
        $pwd = $this->hashPass($pass, $salt, $stretch);
        $this->request2("INSERT INTO `user`(`guid`, `email`) VALUES (:guid,:email)", ['guid' => $guid, 'email' => $email]);
        $this->request2("INSERT INTO `accounttmp`(`guid`, `pwd`, `salt`, `stretch`) VALUES (:guid,:pwd,:salt,:stretch)", ['guid' => $guid, 'pwd' => $pwd, 'salt' => $salt, 'stretch' => $stretch]);
        $this->createNewOtp($guid);

        //Creation of token
        JWT::chiffre($guid, $email, "unvalidate",);
    }

    //Function login for user connection
    public function login(string $email, string $pass): ?string
    {
        $rep = $this->request2("SELECT `guid`, `pwd`, `salt`, `stretch` FROM `user` NATURAL JOIN `account` WHERE `email`=:email", ['email' => $email])->fetch();

        if (empty($rep)) {
            return "L'email ou le mot de passe est incorrect !";
        }

        $pass = $this->hashPass($pass, $rep['salt'], $rep['stretch']);

        if ($rep['pwd'] === $pass) {
            JWT::chiffre($rep['guid'], $email, "validate");
            return null;
        }
        return "L'email ou le mot de passe est incorrect !";
    }

    //Function disconnect account
    public function logout()
    {
        setcookie("Accreditation", "", time() - 3600);
    }
}
