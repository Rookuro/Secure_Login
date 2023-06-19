<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="src/Views/style/style.css">
  <title>Login</title>
</head>

<body>
  <form id="form" action="" method="post">
    <div class="container">

      <label for="email"><b>Email</b></label><br><br>
      <input type="text" placeholder="Enter Email" name="email" id="email" required><br><br>

      <label for="pass"><b>Password</b></label><br><br>
      <input type="password" placeholder="Enter Password" name="pass" id="pass" required><br><br>

      <input type="submit" value="login" name="sub"><br><br>
    </div>

    <?php if (isset($_SERVER['REQUEST_METHOD']) && isset($error)) { ?>
        <span class="error"><?php echo $error; ?></span><br>
     <?php } ?>

    <div class="container signin">
      <p>Vous n'êtes pas membre ?<a href="register">S'inscrire</a>.</p>
    </div>
  </form>
</body>

</html>

<script src="src/Views/js/hash.js"></script>