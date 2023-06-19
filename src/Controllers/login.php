<?php

class login extends PostData {

    public function __construct() {
        $email = null;
        $password = null;
        //Check if the form look at the information and if is send
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = PostData::execute("email");
            $password = PostData::execute("pass");

            if ($email !== null && $password !== null) {
                $user = new user();
                $resp = $user->login($email, $password);
    
                if ($resp === null) {
                    header('Location: home');
                } else {
                    $error = "Echec de l'authentification, l'email ou le mot de passe invalide !";
                }
            } else {
                $error = "Veuillez remplir tous les champs !";
            }
        }
        

        require_once('./src/Views/login.php');
    }
}