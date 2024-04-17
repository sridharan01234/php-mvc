<?php
// Including necessary files
require_once "../Helper/SessionHelper.php"; // Including session handling helper
require_once '../Model/UserModel.php'; // Including user model for database operations
require "BaseController.php";
/**
 * AdminController class handles the administrative tasks such as deleting, modifying, and printing user details.
 */
class AdminController extends BaseController
{
    private $adminModel; // UserModel object for interacting with user data

    /**
     * Constructor to initialize AdminController object.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->adminModel = new UserModel(); // Creating UserModel object
    }

    /**
     * Deletes a user based on the provided email.
     *
     * @return void
     */
    public function delete(): void
    {
        // Deleting user by email
        $this->adminModel->delete($_POST['email']);
        $this->print(); // Redirecting to print method to display updated user list
    }

    /**
     * Modifies the status of a user (active or inactive) based on the provided email.
     *
     * @return void
     */
    public function modify(): void
    {
        $status = 0;
        // Checking and setting status value
        if ($_POST['status'] == 'inactive') {
            $status = '1';
        }
        else {
            $this->logger("user ". $_POST["email"] ."Logged in");
        }
        // Modifying user status
        $this->adminModel->modify($_POST['email'], $status);
        $this->print(); // Redirecting to print method to display updated user list
    }

    /**
     * Retrieves and prints all user details.
     *
     * @return void
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
