<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once "../Helper/SessionHelper.php";
require_once '../Model/UserModel.php';
require '../vendor/autoload.php';

class UserController
{

    private $userModel;

    /**
     *
     * This is the method which creates a instance for UserModel
     *
     * Which is used for database operations
     *
     */
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    /**
     * resgister method is called after user clicking submit in registration page
     *
     * after that is get all the details user entered in the register form
     *
     * then verifies weather the user is already registered or not
     *
     * after confirming new user it call userModel->register() method
     *
     * which operated DB queries to add row in users table with details with hashed password
     */

    public function register(): void
    {
        $data = [
            'user_name' => $_POST['user_name'],
            'email' => $_POST['email'],
            'user_pass' => $_POST['user_pass'],
            'role' => 'user',
            'status' => 1,
        ];
        if ($this->userModel->findUserByEmail($data['email'])) {
            $message = "Email already exist";
            header("location: ../index.php?$message");
            exit;
        }

        $data['user_pass'] = password_hash($data['user_pass'], PASSWORD_DEFAULT);

        if ($this->registrationLink($data['email'])) {
            if ($this->userModel->register($data)) {
                header("location: ../View/");
                exit;
            }
        }

    }

    /**
     * In this method it verifies captcha with google  whether it is robot or not
     */
    public function captchaVerify()
    {
        if (isset($_POST['submit_btn'])) {

            $recaptcha = $_POST['g-recaptcha-response'];

            $secret_key = '6Lf1ObQpAAAAAMhWS2MXfHq44PxEhOQn9xlbxGOp';

            $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
                . $secret_key . '&response=' . $recaptcha;

            $response = file_get_contents($url);

            $response = json_decode($response);

            if ($response->success == true) {
                $this->login();
            } else {
                $message = "InValid Captcha";
                header("location: ../index.php?$message");
                exit;
            }
        }
    }

    /**
     *After verfiying captcha this is called inside that
     *
     * This gets all data from post method and stores in array as $data
     *
     * when the email or password is empty it return to login login page
     *
     * it checks whether ther user is registered or not
     *
     * if not it returns to login page with a message "User is not Registered"
     *
     * and then verfiying the user it checks password in DB with hashing the user entered password
     *
     * And then checks if the user is blocked or not by admin
     *
     * and redirects to respeccting pages by roles admin or normal user by role in DB
     */

    public function login(): void
    {

        $data = [
            'name/email' => $_POST['name/email'],
            'user_pass' => $_POST['user_pass'],
        ];

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
                        $message = "You are blocked please Contact you Administrator";
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
     * It redirects user to home page it is admin dashboard and profile details page
     */

    public function home(): void
    {
        header("location: ../View/");
        exit;
    }

    /**
     * After performing login method it is called to create session for
     */

    public function createUserSession($user): void
    {
        $_SESSION['user_name'] = $user->user_name;
        $_SESSION['role'] = $user->role;
        $_SESSION['email'] = $user->email;
        if ($user->profile_picture == null) {
            $_SESSION['profile_path'] = "../Assets/ProfilePicture/default.jpg";
        } else {
            $_SESSION['profile_path'] = "../Assets/ProfilePictures/" . $user->profile_picture;
        }
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

    public function logout(): void
    {
        unset($_SESSION['user_name']);
        unset($_SESSION['email']);
        session_destroy();
        header("location: ../");
        exit;
    }

    public function registrationLink($email)
    {
        $message = md5(uniqid() . rand(1000000, 9999999));
        $this->userModel->storeToken($message);
        $message = 'http://localhost/php-mvc/Controller/RegistrationLinkController.php?' . $message;
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
        $mail->Body = "Click this link to Confirm you Registration ". $message;
        $mail->AddAddress($email, "");

        $headers = "From: Sender\n";
        $headers .= 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
        $headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n";

        if ($mail->Send()) {
            return true;
        }
        return false;

    }
}
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
        default:
            header("location: ../index.php");
            exit;
    }
}
