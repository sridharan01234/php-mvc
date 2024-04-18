<?php require_once("Helper/SessionHelper.php");


if(isset($_SESSION['full_name'])) {
  header('location: ../php-mvc/View/');
  exit;
}

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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

  </head>

  <body>
    <section>
      <div class="container">
        <div class="user signinBx">
          <div class="formBx">
            <form name="loginForm" onsubmit="return validateLoginForm()" method="post" action="./Controller/RequestHandlingController.php">
              <input type="hidden" name="type" value="login" />
              <h2>Sign In</h2>
              <?php echo"$message"?>
              <input type="text" id = "loginEmail" name="email" placeholder="E-mail"/>
              <input type="password" id = "loginPassword" name="user_pass" placeholder="Password"/>
              <div
                class="g-recaptcha"
                data-sitekey="6Lf1ObQpAAAAANQU4tUwFAmWgBS51GfU4y0pqFAO"
              ></div>
              <input type="submit" value="Click Here">
              <p class="signup">
                Forgot Password
                <a href="View/ResetPass.php">Reset with Email</a>
              </p>
              <p class="signup">
                Don't have an account ?
                <a href="register.php">Sign Up.</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </section>
    <script src="./Assets/js/login.js"></script>
  </body>
</html>
