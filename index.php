<?php require_once("Helper/SessionHelper.php");


// if(isset($_SESSION['usersId'])) {
//   header('location: ../php-mvc/View/');
//   exit;
// }

if(isset($_GET)) {
  $message = implode(",",array_keys($_GET));
}
else {
  $message = "";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="Assets/style/style.css" />
    <link rel="stylesheet" href="Assets/style/admin.css">
  </head>

  <body>
    <section>
      <div class="container">
        <div class="user signinBx">
          <div class="imgBx"><img src="Assets/image.png" alt /></div>
          <div class="formBx">
            <form method="post" action="./Controller/UserController.php">
              <input type="hidden" name="type" value="login" />
              <h2>Sign In</h2>
              <?php echo"$message"?>
              <input type="text" name="name/email" placeholder="E-mail" />
              <input type="password" name="usersPwd" placeholder="Password" />
              <input type="submit" name value="Login" />
              <p class="signup">
                Don't have an account ?
                <a href="register.php">Sign Up.</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </section>
    <script src="Assets/js/script.js"></script>
  </body>
</html>
