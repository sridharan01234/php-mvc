<?php
require_once '../session-helper/session-helper.php';
require_once '../models/profile-register.php';
class ProfileEntry
{
    private $id;

    public function __construct()
    {
        $this->id = new profileRegister();
    }
    public function profile_entry()
    {
        $target_file = "";
        if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            $file_name = $_SESSION['usersEmail'] . "." . $file_extension;
            $target_dir = '../assets/';
            $target_file = $target_dir . $file_name;
            if(!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo"File is not uploaded";
                exit;
            }
    }
        $data = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'mobile_number' => $_POST['mobile_number'],
            'address_line1' => $_POST['address_line1'],
            'postcode' => trim($_POST['postcode']),
            'state' => $_POST['state'],
            'email' => $_POST['email'],
            'education' => $_POST['education'],
            'country' => $_POST['country'],
            'state_region' => $_POST['state_region'],
            'profile_path' => $target_file,
        ];

        if ($this->id->enterDetails($data)) {
            $_SESSION['profile_path'] = $target_file;
            header("location: ../Views/dashboard.php");
            exit;
        } else {
            var_dump($data);
        }

    }

}

$init = new ProfileEntry;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init->profile_entry();
}
