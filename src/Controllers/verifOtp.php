<?php

class verifOtp
{

    public function __construct()
    {
        $otp = $_GET['otp'];
        $user = new user();
        $rep = $user->verifOtp($otp);
        if ($rep === false) {
            header('Location: otp');
        }
        header('Location: login');
    }
}
