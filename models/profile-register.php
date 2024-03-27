<?php
require_once '../libraries/Database.php';

class profileRegister {

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

public function enterDetails($data)
    {
        $this->db->query('UPDATE users SET first_name = :firstname, last_name = :lastname, mobile_number = :mobilenumber, address_line1 = :addressline1, postcode = :postcode, state = :state, email = :email');
        $this->db->bind(':firstname', $data['first_name']);
        $this->db->bind(':lastname', $data['last_name']);
        $this->db->bind(':lastname', $data['last_name']);
        $this->db->bind(':lastname', $data['last_name']);
        $this->db->bind(':lastname', $data['last_name']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}