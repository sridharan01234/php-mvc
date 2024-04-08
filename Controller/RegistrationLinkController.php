<?php
require_once '../Model/UserModel.php';

class RegistrationLinkController
{

    private $tokenModel;
    public function __construct()
    {
        $this->tokenModel = new UserModel();
    }

    public function verifyToken()
    {
        if($this->tokenModel->verifyToken(implode('', array_keys($_GET)))) {
            echo'Token Okay';
        }
        else {
            var_dump(implode('', array_keys($_GET)));
            echo'UnAuthorized';
        }

    }

}

$init = new RegistrationLinkController();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $init->verifyToken();
}
