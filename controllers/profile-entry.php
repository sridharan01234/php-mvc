<?php 
require_once '../models/profile-register.php';
class ProfileEntry {
    private $id;

    public function __construct() {
        $this->id = new profileRegister();
    }
    public function profile_entry()
    {

        //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
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
        ];
        
        
        if ($this->id->enterDetails($data)) {
            $_SESSION['firstname'] = $_POST['first_name'];
            header("location: ../Views/dashboard.php");
            exit;
        }
        else {
            var_dump($data);
        }

    }
    
}

$init = new ProfileEntry;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $init->profile_entry();
}