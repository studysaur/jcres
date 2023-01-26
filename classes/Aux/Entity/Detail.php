<?php
namespace Aux\Entity;
use \Gen\DatabaseTable;

class Detail {
    public $detailNum;
    public $date;
    public $detailType;
    public $detailLocation;
    public $startTime;
    public $endTime;
    public $contact;
    public $contactPh;
    public $numOfficers;
    public $sheetPosted;
    public $paidDetail;
    public $officer_1;
    public $officer_2;
    public $officer_3;
    public $officer_4;
    public $officer_5;
    public $officer_6;
    public $officer_7;
    public $officer_8;
    public $officer_9;
    public $officer_10;
    public $officer;
    private $usersTable;
    private $user;

    public function __construct(DatabaseTable $usersTable) {}


    public function getUser() {
        if (empty($this->user)) {
            $this->user = $this->usersTable->findById($this->uid);
        }

        return $this->user;
    } 
    public function aofficers() {
        $officer[0]=$this->officer_1;
        $officer[1]=$this->officer_2;
        $officer[2]=$this->officer_3;
        $officer[3]=$this->officer_4;
        $officer[4]=$this->officer_5;
        $officer[5]=$this->officer_6;
        $officer[6]=$this->officer_7;
        $officer[7]=$this->officer_8;
        $officer[8]=$this->officer_9;
        $officer[9]=$this->officer_10;
          
        return $officer;
    }
    public function numVols() {
        
        return count($this->officer);
       
    }
 /*   public function getDetails() {
        return $this->detailsTable->find('sheetPosted', '0', 'date');
    } */
}