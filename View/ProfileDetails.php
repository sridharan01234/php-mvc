<?php require_once "../SessionHelper/SessionHelper.php";

if(!isset($_SESSION['usersId'])) {
  header('location: ../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>profile details</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../style/style.min.css">
  </head>
  <body>
    <div class="container">
      <div class="main-body">
        <div class="row gutters-sm">
          <div class="col-md-4 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                  <img
                    src="<?php echo $_SESSION['profile_path'] ?>"
                    alt="Profile Picture"
                  />
                  <div class="mt-3">
                    <h4><?php echo $_SESSION['usersId'] ?></h4>
                    <p class="text-secondary mb-1">Full Stack Developer</p>
                    <p class="text-muted font-size-sm">
                      <?php echo $_SESSION['address_line1'] ?>
                    </p>
                  </div>
                </div>
              </div>
              <button class="button-23" role="button"><a href="index.php">Go to home</a></button>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card mb-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Full Name</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['full_name'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['usersEmail'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Mobile</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['mobile_number'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Address</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['address_line1'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Postcode</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['postcode'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">State</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['state'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Education</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['education'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Country</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <?php echo $_SESSION['country'] ?>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-sm-12">
                    <a class="btn btn-info" href="ProfileEdit.php">Edit</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
