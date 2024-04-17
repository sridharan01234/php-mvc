<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once "../Helper/SessionHelper.php";
require_once '../Model/UserModel.php';
require '../vendor/autoload.php';
require "../Interfaces/UserInterface.php";

/**
 * Controller class for managing user-related operations.
 */
class UserController extends BaseController implements UserInterface

{
    private $userModel;

    /**
     * Constructor to initialize UserModel instance.
     */
    public function __construct()
    {
        $this->userModel = new UserModel;
    }
    /**
     * Handles user registration process.
     *
     * @return void
     */
    public function register(): void
    {
        // Extract data from POST request
        $data = [
            'user_name' => $_POST['user_name'],
            'email' => $_POST['email'],
            'user_pass' => $_POST['user_pass'],
            'role' => 'user',
            'status' => 1,
        ];

        // Check if email already exists
        if ($this->userModel->findUserByEmail($data['email'])) {
            $message = "Email already exists";
            header("location: ../index.php?$message");
            exit;
        }

        // Hash the password
        $data['user_pass'] = password_hash($data['user_pass'], PASSWORD_DEFAULT);

        // Send registration link
        if ($this->registrationLink($data['email'])) {
            if ($this->userModel->register($data)) {
                header("location: ../View/");
                exit;
            }
        }
    }

    /**
     * Verifies Google reCAPTCHA.
     *
     * @return void
     */
    public function captchaVerify(): void
    {
        $recaptcha = $_POST['g-recaptcha-response'];
        $secret_key = '6Lf1ObQpAAAAAMhWS2MXfHq44PxEhOQn9xlbxGOp';
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha;
        $response = file_get_contents($url);
        $response = json_decode($response);

        if ($response->success == false) {
            $message = "Please complete captcha";
            header("location: ../index.php?$message");
            exit;
        }
    }

    /**
     * Handles user login process.
     *
     * @return void
     */
    public function login(): void
    {
        if ($_POST['email'] == "") {
            $message = "Please Enter Your Email Address";
            header("location: ../index.php?$message");
            exit;
        }
        if ($_POST['user_pass'] == "") {
            print_r($_POST['user_pass']);
            $message = "Please Enter Your Password";
            header("location: ../index.php?$message");
            exit;
        }
        $this->captchaVerify();
        $data = [
            'email' => $_POST['email'],
            'user_pass' => $_POST['user_pass'],
        ];

        if ($this->userModel->findUserByEmail($data['email'])) {
            $loggedInUser = $this->userModel->login($data['email'], $data['user_pass']);
            if ($loggedInUser) {
                if ($loggedInUser->email_confirmation == 'Not Verfied' || $loggedInUser->email_confirmation == '') {
                    header('location: ../View/EmailVerification.php');
                    exit;
                } else {
                    if ($loggedInUser->role == 'admin') {
                        $_SESSION['details'] = [];
                        $this->createUserSession($loggedInUser);
                        header("location: ../View/admin.php");
                        exit;
                    } else {
                        if ($loggedInUser->status == 0) {
                            $this->logger($_POST['email']." blocked user tried to log in");
                            $message = "You are blocked. Please contact your administrator.";
                            header("location: ../index.php?$message");
                            exit;
                        }
                        $this->createUserSession($loggedInUser);
                        header("location: ../View/admin.php");
                        exit;
                    }
                }

            } else {
                $this->logger($_POST["email"]." entered a incorrect password");
                $message = "Incorrect Password";
                header("location: ../index.php?$message");
                exit;
            }
        } else {
            $this->logger($_POST['email']." is not registered is tried to log in ");
            $message = "Email is not registered";
            header("location: ../index.php?$message");
            exit;
        }
    }

    /**
     * Redirects user to home page.
     *
     * @return void
     */
    public function home(): void
    {
        header("location: ../View/");
        exit;
    }

    /**
     * Creates session for logged-in user.
     *
     * @param object $user user object
     *
     * @return void
     */
    public function createUserSession(object $user): void
    {
        $_SESSION['user_name'] = $user->user_name;
        $_SESSION['role'] = $user->role;
        $_SESSION['email'] = $user->email;
        if ($user->profile_picture == null) {
            $_SESSION['profile_path'] = "default.png";
        } else {
            $_SESSION['profile_path'] = $user->profile_picture;
        }
        $_SESSION['email_confirmation'] = $user->email_confirmation;
        $_SESSION['address_line1'] = $user->address_line1;
        $_SESSION['mobile_number'] = $user->mobile_number;
        $_SESSION['postcode'] = $user->postcode;
        $_SESSION['state'] = $user->state;
        $_SESSION['country'] = $user->country;
        $_SESSION['first_name'] = $user->first_name;
        $_SESSION['last_name'] = $user->last_name;
        $_SESSION['full_name'] = $user->first_name . $user->last_name;
        $_SESSION['education'] = $user->education;
    }

    /**
     * Logs out user.
     *
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user_name']);
        unset($_SESSION['email']);
        session_destroy();
        header("location: ../");
        exit;
    }

    /**
     * Sends registration confirmation link to user's email.
     *
     * @return void
     * @param string $email
     */
    public function registrationLink(string $email): bool
    {
        try {
            $message = md5(uniqid() . rand(1000000, 9999999));
            $this->userModel->storeToken($message, $email);
            $message = 'http://localhost/php-mvc/Controller/BaseController.php?token=' . $message;
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
            $mail->Subject = "Email Confirm";
            $mail->Body = "<a href='$message'>Click Here</a> to Confirm you Registration  <br> <b>This valid Only for 60Minutes</b>";
            $mail->AddAddress($email, "");
    
            $headers = "From: Sender\n";
            $headers .= 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
            $headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n";
            if($mail->Send()) 
            {
                return true;
            }
        }
        catch (Exception $e) {
            $this->logger($e->getMessage());
          }
    }

    /**
     * for users without email confirmation to send confirm link
     *
     * @return void
     * @param string $email
     */
    public function emailConfirmation(string $email): void
    {
        if ($this->registrationLink($email)) {
            $message = "Registration Link Sent Successfull open you mail to Confirm";
            header("location: ../index.php?$message");
            exit;
        }
        else {
            $this->logger("Registration link send failed for user :".$email);
        }
    }
}
