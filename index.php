<?php require_once("SessionHelper/SessionHelper.php");
if(isset($_SESSION['usersId'])) {
  header('location: ../php-mvc/View/index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/admin.css">
  </head>

  <body>
    <section>
      <div class="container">
        <div class="user signinBx">
          <div class="imgBx"><img src="assets/image.png" alt /></div>
          <div class="formBx">
            <form method="post" action="./Controller/Users.php">
              <input type="hidden" name="type" value="login" />
              <h2>Sign In</h2>
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
    <script src="js/script.js"></script>
  </body>
</html>
