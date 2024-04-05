<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="Assets/style/style.css" />
  </head>

  <body>
    <section>
      <div class="container">
        <div class="user signinBx">
          <div class="formBx">
            <form method="post" action="./Controller/UserController.php">
              <input type="hidden" name="type" value="register" />
              <h2>Create an account</h2>
              <input
                type="text"
                id="fname"
                name="user_name"
                placeholder="Enter your Fullname"
                required
              />
              <input
                type="text"
                id="lname"
                name="user_id"
                placeholder="Enter Username"
                required
              />
              <input
                type="email"
                id="Email"
                name="email"
                placeholder="Email Address"
              />
              <p id="Valid-Email" class="glyphicon glyphicon-remove">
                Invalid Email
              </p>
              <div class="form-group has-feedback">
                <input
                  class="form-control"
                  id="NewPassword"
                  placeholder="New Password"
                  type="password"
                  required
                />
                <span
                  class="glyphicon glyphicon-lock form-control-feedback"
                ></span>
              </div>
              <div class="Password-Validation">
                <div>
                  <p>Must Have</p>
                </div>
                <p id="Length" class="glyphicon glyphicon-remove">7 letter</p>
                <p id="UpperCase" class="glyphicon glyphicon-remove">
                  1 upper case
                </p>
                <p id="LowerCase" class="glyphicon glyphicon-remove">
                  1 lower case
                </p>
                <p id="Numbers" class="glyphicon glyphicon-remove">1 numeric</p>
                <p id="Symbols" class="glyphicon glyphicon-remove">1 special</p>
              </div>
              <input
                type="password"
                id="ConfirmPassword"
                name="user_pass"
                placeholder="Confirm Password"
              />
              <p id="Match" class="glyphicon glyphicon-remove">
                Confirm Your Password
              </p>
              <button type="submit" name="submit">Sign Up</button>
              <p class="signup">
                Already have an account ?
                <a href="index.php">Sign in.</a>
              </p>
            </form>
          </div>
          <div class="imgBx">
            <img src="Assets/image.png" alt="Welcome Image" />
          </div>
        </div>
      </div>
    </section>
    <script src="Assets/js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </body>
</html>
