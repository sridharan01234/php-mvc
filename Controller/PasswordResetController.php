<?php
// Importing required classes
use PHPMailer\PHPMailer\PHPMailer;

// Including necessary files
require '../vendor/autoload.php'; // Autoload required files
require_once "../Helper/SessionHelper.php"; // Session handling helper
require_once '../Model/UserModel.php'; // User model containing database operations

/**
 * PasswordResetController class handles the password reset functionality.
 */
class PasswordResetController extends BaseController
{
    private $passwordModel; // UserModel object for interacting with user data

    /**
     * Constructor to initialize PasswordResetController object.
     */
    public function __construct()
    {
        $this->passwordModel = new UserModel(); // Creating UserModel object
    }

    /**
     * Sends OTP for password reset.
     *
     * @return void
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
                $this->logger("Email not send for reseting password for user :".$_POST['email']);
            } else {
                // Setting session variables and updating OTP status
                $_SESSION['Otp'] = $message;
                $_SESSION['email'] = $_POST['email'];
                $this->passwordModel->updateOtp($message, $_POST['email']);
                // Redirecting to enter OTP page
                header('location: ../View/EnterOpt.php');
                exit;
            }
        } else {
            $this->logger("Invalid Email for reseting password :".$_SESSION['email']." is Entered");
            $message = "Email not Registered"; // Error message if user not found
            header("location: ../index.php?$message"); // Redirecting to index page with error message
            exit;
        }
    }

    /**
     * Verifies entered OTP.
     *
     * @return void
     */
    public function verifyOtp(): void
    {
        // Checking if OTP is expired
        // Verifying entered OTP
        if ($_POST['Otp'] == $_SESSION['Otp']) {
            header("location: ../View/NewPassword.php"); // Redirecting to new password page
            exit;
        } else {
            unset($_SESSION); // Unsetting session variables
            echo "Incorrect Otp"; // Error message for incorrect OTP
            $this->logger("user ".$_SESSION['email']." Entered an invalid Otp");
        }
    }

    /**
     * Sets new password.
     *
     * @return void
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
        else {
            $this->logger("user ".$_SESSION['email']." Password is changed");
        }
    }

    /**
     * Error logger
     * 
     * @param string $log
     * @return void
     */
    public function logger(string $log): void
    {
        error_log($log);   
    }
}
