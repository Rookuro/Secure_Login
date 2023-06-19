<?php

class changPass extends PostData {

    public function __construct() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pass = PostData::execute("pass");
            $newPass = PostData::execute("newPass");
            $newPass2 = PostData::execute("newPass2");

            if ($pass !== null && $newPass !== null && $newPass2 !== null) {
                $user = new user();
    
                $check = $user->JScheckPassword($newPass, $newPass2);
        
                //Check if the new password are not the same
                if ($check !== null) {
                    $rep = $check;
                }

                $guid = JWT::getGuid();
    
                $verif = $user->verifAccounttmp($guid);
    
                //Check is the user are already
                if ($verif !== null) {
                    $rep = $verif;
                }
    
                $changePass = $user->changePass($guid, $pass, $newPass);
    
                //Check if the password is correct
                if ($changePass !== null){
                    $rep = $changePass;
                } else {
                    $rep = "To save the new password, confirm your identity via email (/mail)";
                }
            }
            $error = "Please fill in all fields!";
            
        }
        require_once("./src/Views/changePass.php");
    }
}