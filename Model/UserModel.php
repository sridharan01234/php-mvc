<?php
require_once '../libraries/Database.php';

class UserModel
{

    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM user WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
    public function register($data)
    {
        $this->db->query('INSERT INTO user (user_name, email, user_password, role, status)
        VALUES (:name, :email, :password, :role, :status)');
        $this->db->bind(':name', $data['user_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['user_pass']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':status', $data['status']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($nameOrEmail, $password)
    {
        $row = $this->findUserByEmail($nameOrEmail);

        if ($row == false) {
            return false;
        }

        $hashedPassword = $row->user_password;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    public function enterDetails($data): bool
    {
        $this->db->query('UPDATE user SET first_name = :firstname, last_name = :lastname, mobile_number= :mobile_number, address_line1= :address_line1, postcode= :postcode, state= :state, email= :email, education= :education, country= :country, profile_picture= :profile_path WHERE email = :email');
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
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($data): bool
    {
        $this->db->query('DELETE FROM user WHERE email = :email');
        $this->db->bind(':email', $data);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function modify($data, $status): bool
    {
        $this->db->query('UPDATE user SET status = :status WHERE email = :email');
        $this->db->bind(':status', $status);
        $this->db->bind(':email', $data);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function listAllUser()
    {
        $this->db->query('SELECT * FROM user WHERE role =:admin');
        $this->db->bind(':admin', "user");
        $row = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }
    public function resetPassword($password): bool
    {

        $this->db->query('UPDATE user SET user_password = :password');
        $this->db->bind(':password', $password);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
