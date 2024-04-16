<?php
require_once "../Helper/SessionHelper.php";
if (!isset($_SESSION['Otp'])) {
    header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div class="container">
      <form
        action="../Controller/RequestHandlingController.php"
        method="post"
        class="col-lg-6 offset-lg-3"
      >
      <input type="hidden" name="type" value="ResetPassword">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label"
            >New Password</label
          >
          <input
            type="password"
            class="form-control"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            name="Password"
            placeholder="Enter New Password"
          />
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Confirm Your Password</label>
          <input
            type="password"
            class="form-control"
            id="exampleInputPassword1"
            name="confirmPassword"
            placeholder="Re-Enter your Password"
          />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
