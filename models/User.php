<?php
require_once '../libraries/Database.php';

class User
{

    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function findUserByEmailOrUsername($email)
    {
        $this->db->query('SELECT * FROM users WHERE usersEmail = :email');
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
        $this->db->query('INSERT INTO users (usersName, usersEmail, usersUid, usersPwd)
        VALUES (:name, :email, :Uid, :password)');
        $this->db->bind(':name', $data['usersName']);
        $this->db->bind(':email', $data['usersEmail']);
        $this->db->bind(':Uid', $data['usersUid']);
        $this->db->bind(':password', $data['usersPwd']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($nameOrEmail, $password)
    {
        $row = $this->findUserByEmailOrUsername($nameOrEmail);

        if ($row == false) {
            return false;
        }

        $hashedPassword = $row->usersPwd;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }
}
