<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="src/Views/style/style.css">
  <title>Register</title>
</head>

<body>
  <form id="form" action="" method="post">
    <div class="container">

      <label for="email"><b>Email</b></label><br><br>
      <input type="email" placeholder="Enter Email" name="email" id="email" required><br><br>

      <label for="pass"><b>Password</b></label><br><br>
      <input type="password" placeholder="Enter Password" name="pass" id="pass" required><br><br>

      <label for="pass2"><b>Repeat Password</b></label><br><br>
      <input type="password" placeholder="Repeat Password" name="pass2" id="pass2" required><br><br>

      <input type="submit" value="register" name="sub"><br>
    </div>

    <p id="passError"></p><br>

    <?php if (isset($_SERVER['REQUEST_METHOD']) && isset($error)) { ?>
      <span class="error"><?php echo $error; ?></span><br>
    <?php } ?>

    <div class="container signin">
      <p>Vous avez déjà un compte ? <a href="login">Se connecter</a>.</p>
    </div>
  </form>
  <?php //if (isset($otp)) { ?>
      <!-- <h1>Boite Mail :</h1>
      <span>Veuillez confirmer votre adresse mail en cliquant sur ce bouton</span><br>
      <form action="/Secure_Login/otp" method="post">
        <button name="otp" type="submit" value=<?php //echo $otp; ?> >Envoyer</button>
      </form> -->
    <?php //} ?>
</body>

</html>

<script src="src/Views/js/hash.js"></script>