<?php
require_once "../SessionHelper/SessionHelper.php";
require_once '../Model/User.php';

class Users
{

    private $userModel;
    public function __construct()
    {
        $this->userModel = new User;
    }

    public function register()
    {
        $data = [
            'usersName' => $_POST['usersName'],
            'email' => $_POST['email'],
            'usersUid' => $_POST['usersUid'],
            'usersPwd' => $_POST['usersPwd'],
            'role' => 'user',
        ];

        if ($this->userModel->findUserByEmail($data['email'])) {
            header("location: ../index.php");
            exit;
        }

        $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

        if ($this->userModel->register($data)) {
            header("../index.php");
            exit;
        }
    }

    public function login()
    {
        $data = [
            'name/email' => $_POST['name/email'],
            'usersPwd' => $_POST['usersPwd'],
        ];

        if (empty($data['name/email']) || empty($data['usersPwd'])) {
            header("location: ../index.php");
            exit();
        }

        if ($this->userModel->findUserByEmail($data['name/email'])) {
            $loggedInUser = $this->userModel->login($data['name/email'], $data['usersPwd']);
            if ($loggedInUser) {

                if ($loggedInUser->role == 'admin') {
                    $this->createUserSession($loggedInUser);
                    header("location: ../View/admin.php");
                    exit;
                } else {
                    $this->createUserSession($loggedInUser);
                    header("location: ../View/");
                    exit;
                }
            } else {
                header("location: ../index.php");
                exit;
            }
        } else {
            header("location: ../index.php");
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
        $_SESSION['usersId'] = $user->usersUid;
        $_SESSION['email'] = $user->email;
        $_SESSION['profile_path'] = "../assets/" . $user->profile_picture;
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
        unset($_SESSION['usersId']);
        unset($_SESSION['usersName']);
        unset($_SESSION['email']);
        session_destroy();
        header("location: ../index.php");
        exit;
    }
}

$init = new Users;

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
