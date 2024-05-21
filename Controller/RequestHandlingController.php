<?php
// Including necessary files
require_once "../Helper/SessionHelper.php"; // Including session handling helper
require_once "../Controller/AdminController.php";
require_once "../Controller/PasswordResetController.php";
require_once "../Controller/ProfileEntryController.php";
require_once "../Controller/RegistrationLinkController.php";
require_once "../Controller/UserController.php";

class RequestHandlingController
{
    private $baseModel;

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function delete(): void
    {
        $this->baseModel = new AdminController();
        $this->baseModel->delete();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function modify(): void
    {
        $this->baseModel = new AdminController();
        $this->baseModel->modify();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function print(): void
    {
        $this->baseModel = new AdminController();
        $this->baseModel->print();
    }

    public function sendOtp(): void
    {
        $this->baseModel = new PasswordResetController();
        $this->baseModel->sendOtp();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function verifyOtp(): void
    {
        $this->baseModel = new PasswordResetController();
        $this->baseModel->verifyOtp();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function newPassword(): void
    {
        $this->baseModel = new PasswordResetController();
        $this->baseModel->newPassword();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function register(): void
    {
        $this->baseModel = new UserController();
        $this->baseModel->register();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function login(): void
    {
        $this->baseModel = new UserController();
        $this->baseModel->login();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function emailConfirmation(string $email): void
    {
        $this->baseModel = new UserController();
        $this->baseModel->emailConfirmation($email);
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function profileEntry(): void
    {
        $this->baseModel = new ProfileEntryController();
        $this->baseModel->profileEntry();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function logout(): void
    {
        $this->baseModel = new UserController();
        $this->baseModel->logout();
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function verifyToken(): void
    {
        $this->baseModel = new RegistrationLinkController();
        $this->baseModel->verifyToken();
    }
}

$init = new RequestHandlingController;

// Handling request based on request type
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'delete':
            $init->delete(); // Deleting user
            break;
        case 'modify':
            $init->modify(); // Modifying user
            break;
        case 'print':
            $init->print(); // Printing user details
            break;
        case 'SendOtp':
            $init->sendOtp(); // Sending OTP
            break;
        case 'checkOtp':
            $init->verifyOtp(); // Verifying OTP
            break;
        case 'ResetPassword':
            $init->newPassword(); // Setting new password
            break;
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        case 'emailVerify':
            $init->emailConfirmation($_POST['email']);
            break;
        case 'profileEntry':
            $init->profileEntry();
        default:
            header("location: ../index.php"); // Redirecting to index page for invalid request
            exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['token'])) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $init->verifyToken();
        }
    }

    if (isset($_GET['type'])) {
        switch ($_GET['type']) {
            case 'logout':
                $init->logout();
                break;
            default:
                header("location: ../index.php");
                exit;
        }
    }

}
