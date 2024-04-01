<?php
require_once("../SessionHelper/SessionHelper.php");
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
            header("../View/dashboard.php");
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
        header("location: ../View/");
        exit;
    }

    public function createUserSession($user)
    {
        $_SESSION['usersId'] = $user->usersUid;
        $_SESSION['usersEmail'] = $user->usersEmail;
        $_SESSION['profile_path'] = "../assets/".$user->profile_picture;
        $_SESSION['address_line1'] = $user->address_line1;
        $_SESSION['mobile_number'] = $user->mobile_number;
        $_SESSION['postcode'] = $user->postcode;
        $_SESSION['state'] = $user->state;
        $_SESSION['country'] = $user->country;
        $_SESSION['first_name'] = $user->first_name;
        $_SESSION['last_name'] = $user->last_name;
        $_SESSION['full_name'] = $user->first_name.$user->last_name;
        $_SESSION['education'] = $user->education;
        $_SESSION['state/region'] = $user->state_region;
        header("location: ../View/");
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
