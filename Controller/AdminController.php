<?php
// Including necessary files
require_once "../Helper/SessionHelper.php"; // Including session handling helper
require_once '../Model/UserModel.php'; // Including user model for database operations

/**
 * AdminController class handles the administrative tasks such as deleting, modifying, and printing user details.
 */
class AdminController
{
    private $adminModel; // UserModel object for interacting with user data

    /**
     * Constructor to initialize AdminController object.
     */
    public function __construct()
    {
        $this->adminModel = new UserModel(); // Creating UserModel object
    }

    /**
     * Deletes a user based on the provided email.
     */
    public function delete(): void
    {
        // Deleting user by email
        $this->adminModel->delete($_POST['email']);
        $this->print(); // Redirecting to print method to display updated user list
    }

    /**
     * Modifies the status of a user (active or inactive) based on the provided email.
     */
    public function modify(): void
    {
        $status = 0;
        // Checking and setting status value
        if ($_POST['status'] == 'inactive') {
            $status = '1';
        }

        // Modifying user status
        $this->adminModel->modify($_POST['email'], $status);
        $this->print(); // Redirecting to print method to display updated user list
    }

    /**
     * Retrieves and prints all user details.
     */
    public function print(): void
    {
        // Getting all users and storing in session
        $data = (array) $this->adminModel->listAllUser();
        foreach ($data as $key => $value) {
            $data[$key] = (array) $value;
        }
        $_SESSION['details'] = $data;
        // Redirecting to admin view page to display user details
        header('location: ../View/admin.php');
        exit;
    }
}

/** 
 * Receives request from client and performs according to the request
*/

$init = new AdminController(); // Creating AdminController object

// Handling request based on request type
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'delete':
            $init->delete(); // Deleting user
            break;
        case 'modify':
            $init->modify(); // Modifying user
            break;
        case 'print':
            $init->print(); // Printing user details
            break;
        default:
            header("location: ../index.php"); // Redirecting to index page for invalid request
            exit;
    }
}
