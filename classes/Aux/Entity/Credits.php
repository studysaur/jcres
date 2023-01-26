<?php
namespace Aux\Entity;

class Credit {
    public $credit_id;
    public $detail_num;
    public $date_posted;
    public $username;
    public $uid;
    public $date;
    public $location;
    public $type;
    public $startTime;
    public $endTime;
    public $hours_worked;
    public $money_made;
    public $remarks;
    public $checkNum;
    
    private $creditsTable;

    public function __construct(\Gen\DatabaseTable $creditsTable) {
        $this->creditsTable = $creditsTable;
    }

    public function getDetails() {
        return $this->creditsTable->find('checkNum', '0', 'date');
    }
}