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
            'usersName' => $_POST['usersName'],
            'email' => $_POST['email'],
            'usersUid' => $_POST['usersUid'],
            'usersPwd' => $_POST['usersPwd'],
            'role' => 'user',
            'status' => 1,
        ];

        if ($this->userModel->findUserByEmail($data['email'])) {
            header("location: ../index.php");
            exit;
        }

        $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

        if ($this->userModel->register($data)) {
            header("location: ../View/");
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
                    //include '../View/index.php';
                    echo 'Hii';
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
        $_SESSION['usersId'] = $user->user_id;
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
        unset($_SESSION['usersId']);
        unset($_SESSION['usersName']);
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
