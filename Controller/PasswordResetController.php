<?php
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';
require_once "../Helper/SessionHelper.php";
require_once '../Model/UserModel.php';

class PasswordResetController
{
    private $PasswordModel;
    private $message;
    public function __construct()
    {
        $this->passwordModel = new UserModel();
    }
    
    public function sendOtp(): void
    {
        if ($this->passwordModel->findUserByEmail($_POST['email'])) {
            $email = $_POST['email'];
            $message = rand(100000, 999999);
            $_SESSION['Otp'] = $message;
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->Username = "sridharan01234@gmail.com";
            $mail->Password = "lhvlpsjsnlszulfz";
            $mail->SetFrom("sridharan01234@gmail.com", "Sridharan");
            $mail->Subject = "Password Reset";
            $mail->Body = "This your Otp for password Reset  : " . $message;
            $mail->AddAddress($_POST['email'], "HR");

            $headers = "From: Sender\n";
            $headers .= 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
            $headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n";

            if (!$mail->Send()) {
                echo "Mail Not sent";
            } else {
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['OTP'] = "sent";
                $this->passwordModel->updateOtpStatus($_SESSION['email']);
                header('location: ../View/EnterOpt.php');
                exit;
            }
        } else {
            $message = "Email not Registered";
            header("location: ../index.php?$message");
            exit;
        }
    }

    public function verifyOtp(): void
    {

        if($this->passwordModel->checkExpiry()) {
            if ($_POST['Otp'] == $_SESSION['Otp']) {
                header("location: ../View/NewPassword.php");
                exit;
            } else {
                unset($_SESSION);
                echo "Incorrect Otp";
            }
        }
        else {
            $message = "";
            header("location: ../ResetPass.php?$message=>'Your Otp is Expired Please Send Again'");
            exit;
        }
    }

    public function newPassword(): void
    {
        $password = password_hash($_POST['confirmPassword'], PASSWORD_DEFAULT);
        if ($this->passwordModel->resetPassword($password, $_SESSION['email'])) {
            $message = "Password Reset Successfull";
            header("location: ../index.php");
            exit;
        }
    }

}

$init = new PasswordResetController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'SendOtp':
            $init->sendOtp();
            break;
        case 'checkOtp':
            $init->verifyOtp();
            break;
        case 'ResetPassword':
            $init->newPassword();
            break;
        default:
            header("location: ../index.php");
            exit;
    }
}