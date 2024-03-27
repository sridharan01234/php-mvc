<?php 
require_once '../models/profile-register.php';
class ProfileEntry {
    private $id;

    public function __construct() {
        $this->id = new profileRegister();
    }
    public function profile_entry()
    {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $data = [
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'mobile_number' => trim($_POST['mobile_number']),
            'address_line1' => trim($_POST['address_line1']),
            'postcode' => trim($_POST['postcode']),
            'state' => trim($_POST['state']),
            'email' => trim($_POST['email']),
            'education' => trim($_POST['education']),
            'country' => trim($_POST['country']),
            'state_region' => trim($_POST['state_region']),
        ];
        
        
        if ($this->id->enterDetails($data)) {
            header("location: ../dashboard.php");
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