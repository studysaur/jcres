<?php
namespace Aux\Entity;

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

    private $usersTable;
    private $user;

    public function __construct(\Gen\DatabaseTable $usersTable) {
        $this->usersTable = $usersTable;
    }

    public function getUser() {
        if (empty($this->user)) {
            $this->user = $this->usersTable->findById($this->uid);
        }

        return $this->user;
    }
}