<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once "../Helper/SessionHelper.php";
require_once '../Model/UserModel.php';
require '../vendor/autoload.php';

/**
 * Controller class for managing user-related operations.
 */
class UserController
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
     */
    public function captchaVerify()
    {
        if (isset($_POST['submit_btn'])) {
            $recaptcha = $_POST['g-recaptcha-response'];
            $secret_key = '6Lf1ObQpAAAAAMhWS2MXfHq44PxEhOQn9xlbxGOp';
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha;
            $response = file_get_contents($url);
            $response = json_decode($response);

            if ($response->success == true) {
                $this->login();
            } else {
                $message = "Invalid Captcha";
                header("location: ../index.php?$message");
                exit;
            }
        }
    }

    /**
     * Handles user login process.
     */
    public function login(): void
    {
        $data = [
            'name/email' => $_POST['name/email'],
            'user_pass' => $_POST['user_pass'],
        ];

        // Check for empty fields
        if (empty($data['name/email']) || empty($data['user_pass'])) {
            header("location: ../index.php");
            exit();
        }

        if ($this->userModel->findUserByEmail($data['name/email'])) {
            $loggedInUser = $this->userModel->login($data['name/email'], $data['user_pass']);
            if ($loggedInUser) {
                if ($loggedInUser->role == 'admin') {
                    $_SESSION['details'] = [];
                    $this->createUserSession($loggedInUser);
                    header("location: ../View/admin.php");
                    exit;
                } else {
                    if ($loggedInUser->status == 0) {
                        $message = "You are blocked. Please contact your administrator.";
                        header("location: ../index.php?$message");
                        exit;
                    }
                    $this->createUserSession($loggedInUser);
                    header("location: ../View/admin.php");
                    exit;
                }
            } else {
                $message = "Incorrect Password";
                header("location: ../index.php?$message");
                exit;
            }
        } else {
            $message = "Email is not registered";
            header("location: ../index.php?$message");
            exit;
        }
    }

    /**
     * Redirects user to home page.
     */
    public function home(): void
    {
        header("location: ../View/");
        exit;
    }

    /**
     * Creates session for logged-in user.
     */
    public function createUserSession($user): void
    {
        $_SESSION['user_name'] = $user->user_name;
        $_SESSION['role'] = $user->role;
        $_SESSION['email'] = $user->email;
        // Other user details...
    }

    /**
     * Logs out user.
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
     */
    public function registrationLink(string $email): bool
    {
        $message = md5(uniqid() . rand(1000000, 9999999));
        $this->userModel->storeToken($message);
        $message = 'http://localhost/php-mvc/Controller/RegistrationLinkController.php?' . $message;
        $mail = new PHPMailer(true);
        // Mail configuration...
        if ($mail->Send()) {
            return true;
        }
        return false;
    }
}

// Initiate UserController based on request method
$init = new UserController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        default:
            header("location: ../index.php");
            exit;
    }
} else {
    switch ($_GET['q']) {
        case 'logout':
            $init->logout();
            break;
        case 'home':
            $init->home();
            break; // Missing break statement added
        default:
            header("location: ../index.php");
            exit;
    }
}
?>
