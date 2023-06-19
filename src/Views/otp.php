<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
</head>
<body>
    <h1>Vos Mail</h1>
    <!-- <p>Les demandes d'otps sont supprimés automatiquement au bout de 10 min, pour régénerer une demande, connecter vous</p> -->
    <?php if (isset($otp)) { ?>
        <p>OTP : pour vérifier votre compte, cliquez ici :</p><a href="verif?otp=<?php echo $otp; ?>"><?php echo $otp; ?></a><br>
     <?php } ?>
</body>
</html>