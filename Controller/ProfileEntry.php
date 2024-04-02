<?php
require_once("../SessionHelper/SessionHelper.php");
require_once '../Model/User.php';
class ProfileEntry
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function profileEntry()
    {
        $file_name = "";

        if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            $file_name = $_SESSION['email'] . "." . $file_extension;
            $target_file = "../assets/".$file_name;
            if(!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo"File is not uploaded";
                exit;
            }
    }
    else {
        $file_name = $_SESSION['profile_path'];
    }
        $user = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'mobile_number' => $_POST['mobile_number'],
            'address_line1' => $_POST['address_line1'],
            'email' => $_SESSION['email'],
            'postcode' => $_POST['postcode'],
            'state' => $_POST['state'],
            'education' => $_POST['education'],
            'country' => $_POST['country'],
            'profile_path' => $file_name,
        ];

        if ($this->userModel->enterDetails($user)) {
            $_SESSION['profile_path'] = "../assets/".$user['profile_path'];
            $_SESSION['address_line1'] = $user['address_line1'];
            $_SESSION['mobile_number'] = $user['mobile_number'];
            $_SESSION['postcode'] = $user['postcode'];
            $_SESSION['state'] = $user['state'];
            $_SESSION['country'] = $user['country'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['full_name'] = $user['first_name'].$user['last_name'];
            $_SESSION['education'] = $user['education'];
            header("location: ../View/ProfileDetails.php");
            exit;
        } else {
            var_dump($user);
        }

    }

}

$init = new ProfileEntry;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init->profileEntry();
}
