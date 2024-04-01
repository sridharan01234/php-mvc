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
    <title>Profile edit</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../style/style.min.css">
  </head>
  <body>
    <div class="container">
      <div class="main-body">
        <div class="row">
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
          <div class="col-lg-8">
            <div class="card">
              <form
                method="post"
                action="../Controller/ProfileEntry.php"
                enctype="multipart/form-data"
              >
              <div class="row mt-2">
                  <div class="col-md-12">
                    <label class="labels">Profile Picture</label>
                    <input type="hidden" name="username" value="" />
                    <input
                      type="file"
                      name="profile_picture"
                      class="form-control-file"
                    />
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">First Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="first_name"
                        value="<?php echo $_SESSION['first_name'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Last Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="last_name"
                        value="<?php echo $_SESSION['last_name'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        value="<?php echo $_SESSION['usersEmail'] ?>"
                        disabled/>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="mobile_number"
                        value="<?php echo $_SESSION['mobile_number'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="address_line1"
                        value="<?php echo $_SESSION['address_line1'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Postcode</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        name="postcode"
                        type="text"
                        class="form-control"
                        name="address_line1"
                        value="<?php echo $_SESSION['postcode'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">State</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="state"
                        value="<?php echo $_SESSION['state'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Education</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="education"
                        value="<?php echo $_SESSION['education'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Country</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="country"
                        value="<?php echo $_SESSION['country'] ?>"
                      />
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-3">
                      <h6 class="mb-0">State/Region</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        type="text"
                        class="form-control"
                        name="state_region"
                        value=""
                      />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                    <button class="button-82-pushable" role="button">
                  <span class="button-82-shadow"></span>
                  <span class="button-82-edge"></span>
                  <span class="button-82-front text"> Save Profile </span>
                </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
