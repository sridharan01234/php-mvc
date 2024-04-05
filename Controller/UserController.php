<?php
require_once "../Helper/SessionHelper.php";
require_once '../Model/UserModel.php';

class UserController
{

    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function register()
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

        if ($this->userModel->register($data)) {
            header("location: ../View/");
            exit;
        }
    }

    public function login()
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

    public function home()
    {
        header("location: ../View/");
        exit;
    }

    public function createUserSession($user)
    {
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

    public function logout()
    {
        unset($_SESSION['user_name']);
        unset($_SESSION['email']);
        session_destroy();
        header("location: ../");
        exit;
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
