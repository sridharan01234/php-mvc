<?php
require_once "../Helper/SessionHelper.php";
require_once '../Model/UserModel.php';

class AdminController
{
    private $adminModel;
    public function __construct()
    {
        $this->adminModel = new UserModel();
    }

    public function delete(): void
    {
        $this->adminModel->delete($_POST['email']);
        $this->print();
    }

    public function modify(): void
    {
        $status = 0;
        if ($_POST['status'] == 'inactive') {
            $status = '1';
        }

        $this->adminModel->modify($_POST['email'], $status);
        $this->print();

    }

    public function print(): void
    {
        $data = (array) $this->adminModel->listAllUser();
        foreach ($data as $key => $value) {
            $data[$key] = (array) $value;
        }
        $_SESSION['details'] = $data;
        header('location: ../View/admin.php');
        exit;
    }
}

$init = new AdminController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'delete':
            $init->delete();
            break;
        case 'modify':
            $init->modify();
            break;
        case 'print':
            $init->print();
            break;
        default:
            header("location: ../index.php");
            exit;
    }

}
