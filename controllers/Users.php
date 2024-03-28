<?php
require_once '../session-helper/session-helper.php';
require_once '../models/User.php';

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
            'usersEmail' => $_POST['usersEmail'],
            'usersUid' => $_POST['usersUid'],
            'usersPwd' => $_POST['usersPwd'],
        ];

        if ($this->userModel->findUserByEmailOrUsername($data['usersEmail'])) {
            header("location: ../index.php");
            exit;
        }

        $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

        if ($this->userModel->register($data)) {
            header("../Views/dashboard.php");
            exit;
        }
    }

    public function login()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $data = [
            'name/email' => trim($_POST['name/email']),
            'usersPwd' => trim($_POST['usersPwd']),
        ];

        if (empty($data['name/email']) || empty($data['usersPwd'])) {
            header("location: ../index.php");
            exit();
        }

        if ($this->userModel->findUserByEmailOrUsername($data['name/email'])) {
            $loggedInUser = $this->userModel->login($data['name/email'], $data['usersPwd']);
            if ($loggedInUser) {
                $this->createUserSession($loggedInUser);
            } else {
                header("location: ../index.php");
                exit;
            }
        } else {
            header("location: ../index.php");
            exit;
        }
    }

    public function home() {
        header("location: ../Views/");
        exit;
    }

    public function createUserSession($user)
    {
        $_SESSION['usersId'] = $user->usersUid;
        $_SESSION['usersEmail'] = $user->usersEmail;
        $_SESSION['profile_path'] = $user->profile_picture;
        $_SESSION['address_line1'] = $user->address_line1;
        $_SESSION['mobile_number'] = $user->mobile_number;
        $_SESSION['email'] = $user->email;
        header("location: ../Views/");
        exit;
    }

    public function logout()
    {
        unset($_SESSION['usersId']);
        unset($_SESSION['usersName']);
        unset($_SESSION['usersEmail']);
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
