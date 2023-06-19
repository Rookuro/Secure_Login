<?php

// require_once("./src/Models/user.php");
// require_once('./src/Models/token.php');
// require_once("./src/Models/postData.php");

// $uri = explode('/', $_SERVER['REQUEST_URI']);
// $firstURI = $uri[1];
// $secondURI = $uri[2];


// // user part
// if (JWT::getAuthorization() == true) {
//     if ($firstURI === "Secure_Login" && $secondURI === "home" || $secondURI === "") {
//         require_once('./src/Controllers/home.php');
//         new home();
//     } else if ($firstURI === "Secure_Login" && $secondURI === "logout") {
//         require_once('./src/Controllers/logout.php');
//         new logout();
//     } else if ($firstURI === "Secure_Login" && $secondURI === "changePass") {
//         require_once('./src/Controllers/changePass.php');
//         new changePass();
//     } else if ($firstURI === "Secure_Login" && $secondURI === "otp") {
//         require_once('./src/Controllers/otp.php');
//         new otp();
//     } else {
//         require_once('./src/Views/erreur404.php');
//         new erreur404();
//     }
// }
// // visitor part
// else  {
//     if ($firstURI === "Secure_Login" && $secondURI === "login" || $secondURI === "") {
//         require_once('./src/Controllers/login.php');
//         new login();
//     } else if ($firstURI === "Secure_Login" && $secondURI === "register") {
//         require_once('./src/Controllers/register.php');
//         new register();
//     } else if ($firstURI === "Secure_Login" && $secondURI === "otp") {
//         require_once('./src/Controllers/otp.php');
//         new otp();
//     } else if (isset($_GET['otp'])) {
//         if ($firstURI === "Secure_Login" && $secondURI === "verif?otp=" . $_GET['otp']) {
//             require_once('./src/Controllers/verifOtp.php');
//             new verifOtp();
//         }
//     } else {
//         require_once('./src/Views/erreur404.php');
//         new erreur404();
//     }
// } 





require_once("./src/Models/user.php");
require_once "./src/Models/json.php";
require_once("./src/Models/postData.php");
require_once('./src/Models/token.php');

$uri = explode('/', $_SERVER['REQUEST_URI']);
$firstURI = $uri[1];
$secondURI = $uri[2];

// user part
if (JWT::getAuthorization() == true) {
    if ($firstURI === "Secure_Login" && $secondURI === "home" || $secondURI === "") {
        require_once('./src/Controllers/home.php');
        new home();
    } else if ($firstURI === "Secure_Login" && $secondURI === "logout") {
        require_once('./src/Controllers/logout.php');
        new logout();
    } else if ($firstURI === "Secure_Login" && $secondURI === "changePass") {
        require_once('./src/Controllers/changePass.php');
        new changePass();
    } else if ($firstURI === "Secure_Login" && $secondURI === "otp") {
        require_once('./src/Controllers/otp.php');
        new otp();
    } else {
        require_once('./src/Views/erreur404.php');
        new erreur404();
    }
}
// visitor part
else  {
    if ($firstURI === "Secure_Login" && $secondURI === "login" || $secondURI === "") {
        require_once('./src/Controllers/login.php');
        new login();
    } else if ($firstURI === "Secure_Login" && $secondURI === "register") {
        require_once('./src/Controllers/register.php');
        new register();
    } else if ($firstURI === "Secure_Login" && $secondURI === "otp") {
        require_once('./src/Controllers/otp.php');
        new otp();
    } else if (isset($_GET['otp'])) {
        if ($firstURI === "Secure_Login" && $secondURI === "verif?otp=" . $_GET['otp']) {
            require_once('./src/Controllers/verifOtp.php');
            new verifOtp();
        }
    } else {
        require_once('./src/Views/erreur404.php');
        new erreur404();
    }
} 
