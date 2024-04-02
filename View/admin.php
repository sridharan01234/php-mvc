<?php require_once "../SessionHelper/SessionHelper.php";
require_once "../Controller/Admin.php";


if (!$_SESSION['role'] == "admin") {
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
    <link rel="stylesheet" href="../style/admin.css" />
    <link
      rel="stylesheet"
      type="text/css"
      href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"
    />
  </head>
  <body>
    <form action="../Controller/Admin.php" method="post">
      <input type="hidden" name="type" value="print" />
      <button type="submit">List Users</button>
    </form>

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
                  <tbody>
                    <?php if(!isset($_SESSION['details'])) { echo "No users Found"; exit; }?>
                    <?php foreach ($_SESSION['details'] as $email): ?>

                    <?php $email['status'] == '1' ? $email['status'] = "Active" : $email['status'] = "inactive" ?>
                    <tr>
                      <td>
                        <img
                          src="../assets/.<?php echo $email['profile_picture']?>"
                          alt="<?php echo $email['profile_picture']?>"
                        />
                        <a href="#" class="user-link"></a>
                        <span class="user-subhead"
                          ><?php echo $email['usersName']?></span
                        >
                      </td>
                      <td><?php echo $email['created_at']?></td>
                      <td class="text-center">
                        <span class="label label-default"
                          ><?php echo $email['status']?></span
                        >
                      </td>
                      <td>
                        <a href="#"><?php echo $email['email']?></a>
                      </td>
                      <td style="width: 20%">
                        <form action="../Controller/Admin.php" method="post">
                          <input type="hidden" name="type" value="modify" />
                          <input
                            type="hidden"
                            name="email"
                            value="<?php echo $email['email']?>"
                          />
                          <input
                            type="hidden"
                            name="status"
                            value="<?php echo $email['status']?>"
                          />
                          <button type="submit">
                            <a href="#" class="table-link text-warning">
                              <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x"></i>
                                <i
                                  class="fa fa-search-plus fa-stack-1x fa-inverse"
                                ></i>
                              </span>
                            </a>
                          </button>
                        </form>
                        <form action="../Controller/Admin.php" method="post">
                          <input type="hidden" name="type" value="delete" />
                          <input
                            type="hidden"
                            name="email"
                            value="<?php echo $email['email']?>"
                          />
                          <button type="submit">
                            <a href="#" class="table-link danger">
                              <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x"></i>
                                <i
                                  class="fa fa-trash-o fa-stack-1x fa-inverse"
                                ></i>
                              </span>
                            </a>
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
  </body>
</html>
