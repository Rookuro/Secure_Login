<?php

class register extends PostData
{

    public function __construct()
    {
        //Verify the form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = PostData::execute("email");
            $pass = PostData::execute("pass");
            $pass2 = PostData::execute("pass2");

            if ($email !== null && $pass !== null && $pass2 !== null) {
                $user = new user();
                $checkEmailExist = $user->checkEmailExist($email);
                //check if user exist
                if ($checkEmailExist) {
                    $error = "Cette adresse email existe déjà !";
                } else {
                    
                    $JScheckPassword = $user->JScheckPassword($pass, $pass2);
                    
                    if ($JScheckPassword === null) {
                        $user->register($email, $pass);
                
                    } else {
                        $error = $JScheckPassword;
                    }
                }
            } else {
                $error = "Veuillez remplir tous les champs !";
            }
        }
    }
}

require_once('./src/Views/register.php');
