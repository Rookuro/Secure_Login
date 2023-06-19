<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<body>
<form id="form" action="" method="post">
    <div class="container">

      <label for="pass"><b>Actual Password</b></label><br><br>
      <input type="password" placeholder="Enter Password" name="pass" id="pass" required><br><br>

      <label for="pass"><b>New Password</b></label><br><br>
      <input type="password" placeholder="Enter Password" name="newPass" id="newPass" required><br><br>

      <label for="pass2"><b>Repeat Password</b></label><br><br>
      <input type="password" placeholder="Repeat Password" name="newPass2" id="newPass2" required><br><br>
      
      <input type="submit" value="changePass" name="sub"><br><br>
    </div>

    <p id="passError"></p><br>

    <?php if (isset($_SERVER['REQUEST_METHOD']) && isset($rep)) { ?>
        <span class="error"><?php echo $rep; ?></span><br>
     <?php } ?>
  </form>
</body>
</html>

<script src="src/Views/js/hash.js"></script>