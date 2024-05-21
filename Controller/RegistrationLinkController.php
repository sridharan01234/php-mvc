<?php
require_once "../Helper/SessionHelper.php";
require_once '../Model/UserModel.php';

class RegistrationLinkController extends BaseController
{

    private $tokenModel;
    public function __construct()
    {
        $this->tokenModel = new UserModel();
    }

    /**
     * Gets token in get methods and checks with model and return whether it is valid for not
     *
     * @return void
     */
    public function verifyToken(): void
    {
        $token = $_GET['token'];
        if ($this->tokenModel->verifyToken($token)) {
            $this->tokenModel->updateEmailConfirmation($token);
            $message = "Email Verfication Success";
            header("location: ../index.php?$message");
            exit;
        } else {
            $this->logger("Invalid Token Entered");
            echo 'UnAuthorized';
        }

    }
}
