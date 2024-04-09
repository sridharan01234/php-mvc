<?php
// Including the Database class file
require_once '../libraries/Database.php';

// UserModel class definition
class UserModel
{
    // Private property to hold the database connection
    private $db;

    // Constructor to initialize the database connection
    public function __construct()
    {
        // Creating a new Database instance
        $this->db = new Database;
    }

    /**
     * Method to find a user by email
     *
     * @param string $email The email address of the user
     * @return bool|object Returns user object if found, otherwise returns false
     */
    public function findUserByEmail(string $email): bool | object
    {
        // SQL query to select user by email
        $this->db->query('SELECT * FROM user WHERE email = :email');
        // Binding email parameter
        $this->db->bind(':email', $email);

        // Fetching a single row
        $row = $this->db->single();

        // Checking if user exists
        if ($this->db->rowCount() > 0) {
            return $row; // Returning user object
        } else {
            return false; // Returning false if user does not exist
        }
    }

    /**
     * Method to register a new user
     *
     * @param array $data An array containing user registration data
     * @return bool Returns true if registration is successful, otherwise returns false
     */
    public function register(array $data): bool
    {
        // SQL query to insert user data into database
        $this->db->query('INSERT INTO user (user_name, email, user_password, role, status)
        VALUES (:name, :email, :password, :role, :status)');
        // Binding parameters
        $this->db->bind(':name', $data['user_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['user_pass']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':status', $data['status']);

        // Executing the query
        if ($this->db->execute()) {
            return true; // Returning true if registration is successful
        } else {
            return false; // Returning false if registration fails
        }
    }

    /**
     * Method to authenticate user login
     *
     * @param string $email The email address of the user
     * @param string $password The password of the user
     * @return bool|object Returns user object if login is successful, otherwise returns false
     */
    public function login(string $email, string $password): bool | object
    {
        // Finding user by email
        $row = $this->findUserByEmail($email);

        // Checking if user exists
        if ($row == false) {
            return false; // Returning false if user does not exist
        }

        // Verifying password
        $hashedPassword = $row->user_password;
        if (password_verify($password, $hashedPassword)) {
            return $row; // Returning user object if password is correct
        } else {
            return false; // Returning false if password is incorrect
        }
    }

    /**
     * Method to enter user details
     *
     * @param array $data An array containing user details
     * @return bool Returns true if details are entered successfully, otherwise returns false
     */
    public function enterDetails(array $data): bool
    {
        // SQL query to update user details
        $this->db->query('UPDATE user SET first_name = :firstname, last_name = :lastname, mobile_number= :mobile_number, address_line1= :address_line1, postcode= :postcode, state= :state, email= :email, education= :education, country= :country, profile_picture= :profile_path WHERE email = :email');
        // Binding parameters
        $this->db->bind(':firstname', $data['first_name']);
        $this->db->bind(':lastname', $data['last_name']);
        $this->db->bind(':mobile_number', $data['mobile_number']);
        $this->db->bind(':address_line1', $data['address_line1']);
        $this->db->bind(':postcode', $data['postcode']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':education', $data['education']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':profile_path', $data['profile_path']);

        // Executing the query
        if ($this->db->execute()) {
            return true; // Returning true if details are entered successfully
        } else {
            return false; // Returning false if entering details fails
        }
    }

    /**
     * Method to delete a user
     *
     * @param string $data The email address of the user to be deleted
     * @return bool Returns true if deletion is successful, otherwise returns false
     */
    public function delete(string $data): bool
    {
        // SQL query to delete user by email
        $this->db->query('DELETE FROM user WHERE email = :email');
        // Binding email parameter
        $this->db->bind(':email', $data);

        // Executing the query
        if ($this->db->execute()) {
            return true; // Returning true if deletion is successful
        } else {
            return false; // Returning false if deletion fails
        }
    }

    /**
     * Method to modify user status
     *
     * @param string $data The email address of the user whose status is to be modified
     * @param string $status The new status to be set
     * @return bool Returns true if modification is successful, otherwise returns false
     */
    public function modify(string $data, string $status): bool
    {
        // SQL query to update user status
        $this->db->query('UPDATE user SET status = :status WHERE email = :email');
        // Binding parameters
        $this->db->bind(':status', $status);
        $this->db->bind(':email', $data);

        // Executing the query
        if ($this->db->execute()) {
            return true; // Returning true if modification is successful
        } else {
            return false; // Returning false if modification fails
        }
    }

    /**
     * Method to list all users
     *
     * @return bool|array Returns array of users if found, otherwise returns false
     */
    public function listAllUser(): bool | array
    {
        // SQL query to select all users with role "user"
        $this->db->query('SELECT * FROM user WHERE role = :admin');
        // Binding role parameter
        $this->db->bind(':admin', "user");

        // Fetching multiple rows
        $row = $this->db->resultSet();

        // Checking if users exist
        if ($this->db->rowCount() > 0) {
            return $row; // Returning array of users
        } else {
            return false; // Returning false if no users found
        }
    }

    /**
     * Method to verify token
     *
     * @param string $token The token to be verified
     * @return bool Returns true if token is found, otherwise returns false
     */
    public function verifyToken(string $token): bool
    {
        // SQL query to select token
        $this->db->query('SELECT * FROM token WHERE auth_token = :token');
        // Binding token parameter
        $this->db->bind(':token', $token);

        // Fetching a single row
        $row = $this->db->single();

        // Checking if token exists
        if ($this->db->rowCount() > 0) {
            return true; // Returning true if token is found
        } else {
            return false; // Returning false if token is not found
        }
    }

    /**
     * Method to store token
     *
     * @param string $token The token to be stored
     * @return bool Returns true if token is stored successfully, otherwise returns false
     */
    public function storeToken(string $token, string $email): bool
    {

        $this->db->query('INSERT INTO token (auth_token, email)
        VALUES (:token, :email)');
        $this->db->bind(':token', $token);
        $this->db->bind(':email', $email);
        if ($this->db->execute()) {
            $this->db->query('UPDATE token SET time = NOW() WHERE auth_token =:token');
            $this->db->bind(':token', $token);
            if ($this->db->execute()) {
                return true;
            }
            return false;
        } else {
            return false;
        }

    }

    function updateEmailConfirmation($token)  
    {
        $this->db->query('SELECT * FROM token WHERE auth_token = :token');
        $this->db->bind(':token', $token);
        $row = $this->db->single();
        $email = $row->email;
        $this->db->query('UPDATE user SET email_confirmation =:verfied WHERE email =:email');
        $this->db->bind(':verfied','verfied');
        $this->db->bind(':email',$email);
        $this->db->execute();
    }
}
