<?php

class logout {

    public function __construct() {

        if (isset($_POST['logout'])) {
            $user = new user();
            $user->logout();
            header('Location: login');
        }

        require_once("./src/Views/logout.php");
    }


}
