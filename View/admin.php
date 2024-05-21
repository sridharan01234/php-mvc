<?php require_once "../Helper/SessionHelper.php";
require_once "../Controller/AdminController.php";

if ($_SESSION['role'] === "user") {
    header('location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../Assets/style/admin.css" />
  </head>
  <body>
    <hr />
    <div class="container bootstrap snippets bootdey">
      <div class="row">
        <div class="col-lg-12">
          <div class="main-box no-header clearfix">
            <div class="main-box-body clearfix">
              <div class="table-responsive">
                <table class="table user-list">
                  <thead>
                    <tr>
                      <th><span>User</span></th>
                      <th><span>Created</span></th>
                      <th class="text-center"><span>Status</span></th>
                      <th><span>Email</span></th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <?php foreach ($_SESSION['details'] as $email): ?>
                  <?php if (!isset($email['email'])): { echo "No users found";break;}?>
                  <?php endif?>
                  <?php $email['status'] == '1' ? $email['status'] = "Active" : $email['status'] = "inactive"?>
                  <tbody>
                    <tr>
                      <td>
                        <img class="rounded-circle shadow-4-strong" src="<?php echo "../Assets/ProfilePictures/".$email['profile_picture'] ?>"
                        alt="<?php echo $email['profile_picture'] ?>" />
                        <a href="#" class="user-link"></a>
                        <span class="user-subhead"
                          ><?php echo $email['user_name'] ?></span
                        >
                      </td>
                      <td><?php echo $email['created_at'] ?></td>
                      <td class="text-center">
                        <span class="label label-default"
                          ><?php echo $email['status'] ?></span
                        >
                      </td>
                      <td>
                        <?php echo $email['email'] ?>
                      </td>
                      <td style="width: 20%">
                        <form
                          action="../Controller/RequestHandlingController.php"
                          method="post"
                        >
                          <input type="hidden" name="type" value="modify" />
                          <input
                            type="hidden"
                            name="email"
                            value="<?php echo $email['email'] ?>"
                          />
                          <input
                            type="hidden"
                            name="status"
                            value="<?php echo $email['status'] ?>"
                          />
                          <button type="submit" title="Change Status">
                            <span class="fa-stack">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-pen-fill"
                                viewBox="0 0 16 16"
                              >
                                <path
                                  d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"
                                />
                              </svg>
                            </span>
                          </button>
                        </form>
                        <form
                          action="../Controller/RequestHandlingController.php"
                          method="post"
                        >
                          <input type="hidden" name="type" value="delete" />
                          <input
                            type="hidden"
                            name="email"
                            value="<?php echo $email['email'] ?>"
                          />
                          <button type="submit" title="Delete">
                            <span class="fa-stack">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-trash-fill"
                                viewBox="0 0 16 16"
                              >
                                <path
                                  d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"
                                />
                              </svg>
                            </span>
                          </button>
                        </form>
                      </td>
                    </tr>
                    <?php endforeach?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-auto">
          <form action="../Controller/RequestHandlingController.php" method="post">
            <input type="hidden" name="type" value="print" />
            <button type="submit">List Users</button>
          </form>
        </div>
        <div class="col-auto">
          <a href="index.php"><button>Go to Home</button></a>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script src="../Assets/js/script.js"></script>
  </body>
</html>
