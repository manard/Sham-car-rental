<?php
class user {
    private $name;
    private $houseNo;
    private $street;
    private $city;
    private $country;
    private $DOB;
    private $cusID;
    private $cusEmail;
    private $Telephone;
    private $creditCard;
    private $type;

    function __construct($record) {
        if ($record) {
            $this->name = $record['name'];
            $this->houseNo = $record['houseNo'];
            $this->street = $record['street'];
            $this->city = $record['city'];
            $this->country = $record['country'];
            $this->DOB = $record['DOB'];
            $this->cusID = $record['cusID'];
            $this->cusEmail = $record['cusEmail'];
            $this->Telephone = $record['Telephone'];
            $this->creditCard = $record['creditCard'];
            $this->type = $record['type'];
        }
    }

    // Getter methods
    public function getname() {
        return $this->name;
    }


    public function getHouseNo() {
        return $this->houseNo;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getCity() {
        return $this->city;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getDOB() {
        return $this->DOB;
    }

    public function getCusID() {
        return $this->cusID;
    }

    public function getCusEmail() {
        return $this->cusEmail;
    }

    public function getTelephone() {
        return $this->Telephone;
    }

    public function getCreditCard() {
        return $this->creditCard;
    }

    // Setter methods
    public function setname($name) {
        $this->name = $name;
    }
    public function setHouseNo($houseNo) {
        $this->houseNo = $houseNo;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setDOB($DOB) {
        $this->DOB = $DOB;
    }

    public function setCusID($cusID) {
        $this->cusID = $cusID;
    }

    public function setCusEmail($cusEmail) {
        $this->cusEmail = $cusEmail;
    }

    public function setTelephone($Telephone) {
        $this->Telephone = $Telephone;
    }

    public function setCreditCard($creditCard) {
        $this->creditCard = $creditCard;
    }

   
    




}
?>
