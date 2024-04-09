<?php
// Importing required classes
use PHPMailer\PHPMailer\PHPMailer;

// Autoload required files
require '../vendor/autoload.php';

// Including necessary files
require_once "../Helper/SessionHelper.php"; // Session handling helper
require_once '../Model/UserModel.php'; // User model containing database operations

/**
 * PasswordResetController class handles the password reset functionality.
 */
class PasswordResetController
{
    private $passwordModel; // UserModel object for interacting with user data
    private $message; // Variable to store message

    /**
     * Constructor to initialize PasswordResetController object.
     */
    public function __construct()
    {
        $this->passwordModel = new UserModel(); // Creating UserModel object
    }
    
    /**
     * Sends OTP for password reset.
     */
    public function sendOtp(): void
    {
        // Checking if user exists with provided email
        if ($this->passwordModel->findUserByEmail($_POST['email'])) {
            // Generating OTP
            $message = rand(100000, 999999);
            $_SESSION['Otp'] = $message; // Storing OTP in session

            // Sending OTP via email
            $mail = new PHPMailer(true); // Creating PHPMailer instance
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->Username = "sridharan01234@gmail.com"; // Sender email
            $mail->Password = "lhvlpsjsnlszulfz"; // Sender password
            $mail->SetFrom("sridharan01234@gmail.com", "Sridharan"); // Sender details
            $mail->Subject = "Password Reset"; // Email subject
            $mail->Body = "This your OTP for password reset: " . $message; // Email body
            $mail->AddAddress($_POST['email'], "HR"); // Recipient email

            // Sending email
            if (!$mail->Send()) {
                echo "Mail Not sent"; // Error message if email sending fails
            } else {
                // Setting session variables and updating OTP status
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['OTP'] = "sent";
                $this->passwordModel->updateOtpStatus($_SESSION['email']);
                // Redirecting to enter OTP page
                header('location: ../View/EnterOpt.php');
                exit;
            }
        } else {
            $message = "Email not Registered"; // Error message if user not found
            header("location: ../index.php?$message"); // Redirecting to index page with error message
            exit;
        }
    }

    /**
     * Verifies entered OTP.
     */
    public function verifyOtp(): void
    {
        // Checking if OTP is expired
        if($this->passwordModel->checkExpiry()) {
            // Verifying entered OTP
            if ($_POST['Otp'] == $_SESSION['Otp']) {
                header("location: ../View/NewPassword.php"); // Redirecting to new password page
                exit;
            } else {
                unset($_SESSION); // Unsetting session variables
                echo "Incorrect Otp"; // Error message for incorrect OTP
            }
        }
        else {
            $message = ""; // Initializing message variable
            header("location: ../ResetPass.php?$message=>'Your Otp is Expired Please Send Again'"); // Redirecting with expired OTP message
            exit;
        }
    }

    /**
     * Sets new password.
     */
    public function newPassword(): void
    {
        // Hashing new password
        $password = password_hash($_POST['confirmPassword'], PASSWORD_DEFAULT);
        // Resetting password in database
        if ($this->passwordModel->resetPassword($password, $_SESSION['email'])) {
            $message = "Password Reset Successfull"; // Success message
            header("location: ../index.php"); // Redirecting to index page
            exit;
        }
    }
}

/** 
 * Receives request from client and performs according to the request.
 */
$init = new PasswordResetController(); // Creating PasswordResetController object

// Handling request based on request type
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'SendOtp':
            $init->sendOtp(); // Sending OTP
            break;
        case 'checkOtp':
            $init->verifyOtp(); // Verifying OTP
            break;
        case 'ResetPassword':
            $init->newPassword(); // Setting new password
            break;
        default:
            header("location: ../index.php"); // Redirecting to index page for invalid request
            exit;
    }
}
