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
        $this->db->query('UPDATE users SET first_name = :firstname, last_name = :lastname, mobile_number= :mobile_number, address_line1= :address_line1, postcode= :postcode, state= :state, email= :email, education= :education, country= :country, state_region= :state_region');
        $this->db->bind(':firstname', $data['first_name']);
        $this->db->bind(':lastname', $data['last_name']);
        $this->db->bind(':mobile_number', $data['mobile_number']);
        $this->db->bind(':address_line1', $data['address_line1']);
        $this->db->bind(':postcode', $data['postcode']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':education', $data['education']);
        $this->db->bind(':country', $data['country']);
        $this->db->bind(':state_region', $data['state_region']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}