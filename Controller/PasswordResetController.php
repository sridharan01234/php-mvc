<?php
require_once("../Helper/SessionHelper.php");
require_once '../Model/UserModel.php';

class PasswordResetController {
    private $PasswordModel;

    public function __construct()  {
        $this->passwordModel = new UserModel();
    }

    public function sentOtp()  {
        
    }
}

$init = new PasswordResetController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'SendOtp':
            $init->sendOtp();
            break;
        case 'PasswordReset':
            $init->passwordReset();
            break;
        default:
            header("location: ../index.php");
            exit;
    }
?>