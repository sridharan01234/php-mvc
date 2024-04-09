<?php
// Including required files
require_once "../Helper/SessionHelper.php"; // Session handling helper
require_once '../Model/UserModel.php'; // User model containing database operations

// ProfileEntryController class definition
class ProfileEntryController
{
    private $userModel; // UserModel object for interacting with the user data

    // Constructor to initialize UserModel object
    public function __construct()
    {
        $this->userModel = new UserModel(); // Creating UserModel object
    }

    /**
     * Handles the profile entry process
     */
    public function profileEntry(): void
    {
        $file_name = ""; // Variable to store the profile picture file name

        // Checking if a profile picture is uploaded
        if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            // Extracting file extension
            $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            // Generating file name using user's email and extension
            $file_name = $_SESSION['email'] . "." . $file_extension;
            // Setting target file path
            $target_file = "../Assets/ProfilePictures" . $file_name;
            // Moving uploaded file to target location
            if (!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo "File is not uploaded"; // Error message if file upload fails
                exit;
            }
        } else {
            $file_name = $_SESSION['profile_path']; // Using existing profile picture if no new picture uploaded
        }

        // Creating user data array
        $user = [
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'mobile_number' => $_POST['mobile_number'],
            'address_line1' => $_POST['address_line1'],
            'email' => $_SESSION['email'],
            'postcode' => $_POST['postcode'],
            'state' => $_POST['state'],
            'education' => $_POST['education'],
            'country' => $_POST['country'],
            'profile_path' => $file_name,
        ];

        // Entering user details into the database
        if ($this->userModel->enterDetails($user)) {
            // Updating session variables with new user details
            $_SESSION['profile_path'] = "../Assets/ProfilePictures/" . $user['profile_path'];
            $_SESSION['address_line1'] = $user['address_line1'];
            $_SESSION['mobile_number'] = $user['mobile_number'];
            $_SESSION['postcode'] = $user['postcode'];
            $_SESSION['state'] = $user['state'];
            $_SESSION['country'] = $user['country'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['full_name'] = $user['first_name'] . $user['last_name'];
            $_SESSION['education'] = $user['education'];
            // Redirecting to profile details page
            header("location: ../View/ProfileDetails.php");
            exit;
        } else {
            var_dump($user); // Outputting user data for debugging if insertion fails
        }
    }
}

/** 
 * Receives request from client and performs according to the request
 * Initiates ProfileEntryController object and handles profile entry process if POST request is received
 */

$init = new ProfileEntryController(); // Creating ProfileEntryController object

// Handling POST request for profile entry
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init->profileEntry(); // Calling profileEntry method
}
