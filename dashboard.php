<?php
require_once("session-helper/session-helper.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="nav-container">
        <div>
            <h1>Hi, <?php echo $_SESSION['usersId'] ?></h1>
        </div>
        <div>
        <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture">
        </div>
        <div>
        <form action="./controllers/Users.php" method="GET">
        <input type="hidden" name="q" value="logout">
        <button type="submit" class="logout-btn"><span class="text">Logout</span><span>Thanks!</span></button>
        </form>
        </div>
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>

                    <form method="post" action="controllers/profile-entry.php" enctype="multipart/form-data">
                        <input type="hidden" name="username" value="">
                        <div class="row mt-2">
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Profile Picture</label>
                                    <input type="file" name="profile_picture" class="form-control-file">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="labels">First Name</label>
                                <input name="first_name" type="text" class="form-control" placeholder="First Name">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">Last Name</label>
                                <input name="last_name" type="text" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Mobile Number</label>
                                <input name="mobile_number" type="text" class="form-control"
                                    placeholder="Mobile Number">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Address Line 1</label>
                                <input name="address_line1" type="text" class="form-control"
                                    placeholder="Address Line 1">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Postcode</label>
                                <input name="postcode" type="text" class="form-control" placeholder="Postcode">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">State</label>
                                <input name="state" type="text" class="form-control" placeholder="State">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                <input name="email" type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="labels">Education</label>
                                <input name="education" type="text" class="form-control" placeholder="Education">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="labels">Country</label>
                                <input id="Country" name="country" type="text" class="form-control"
                                    placeholder="Country">
                            </div>
                            <div class="col-md-6">
                                <label class="labels">State/Region</label>
                                <input name="state_region" type="text" class="form-control" placeholder="State/Region">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="button-82-pushable" role="button"> <span class="button-82-shadow"></span>
                                <span class="button-82-edge"></span> <span class="button-82-front text">
                                    Save Profile </span>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://bossanova.uk/jsuites/v3/jsuites.js"></script>

</body>

</html>