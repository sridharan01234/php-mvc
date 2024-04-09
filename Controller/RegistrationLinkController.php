<?php
require_once '../Model/UserModel.php';

class RegistrationLinkController
{

    private $tokenModel;
    public function __construct()
    {
        $this->tokenModel = new UserModel();
    }

    /**
     * gets token in get methods and checks with model and return whether it is valid for not
     */
    public function verifyToken(): void
    {
        $token = implode('', array_keys($_GET));
        if($this->tokenModel->verifyToken($token)) {
            $this->tokenModel->updateEmailConfirmation($token);
            $message = "Email Verfication Success";
            header("location: ../index.php?$message");
            exit;
        }
        else {
            var_dump(implode('', array_keys($_GET)));
            echo'UnAuthorized';
        }

    }

}

/** 
 * Receives request from client and performs according to the request
*/

$init = new RegistrationLinkController();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $init->verifyToken();
}
