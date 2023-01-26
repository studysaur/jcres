<?php
namespace Aux\Entity;

class Deputy
{

    const CHECK  = 0x8081100;
    const CCHECK = 0x5a5d5b83;
    const PROBATION = 0x4;
    const REGULAR  = 0x8;
    const EXPLORER = 0x10;
    const AUXILIARY  = 0x20;
    const FTO_COMPLETE  = 0x40;
    const EDIT_DETAILS = 0x400;
    const OC = 0x8000;
    const TASER = 0x2000;
    const POST_DETAILS = 0x200000;
    const LEAVE_OF_ABSENCE = 0x800000;
    const ADMIN = 0x1000000;
    const FIELD_TRAINING_OFFICER = 0x4000000;
    const FIREARM = 0x20000000;
    const DISABLE = 0x100000000;

    public $uid;
    public $username;
    public $password;
    public $userlevel;
    public $status;
    public $unit_num;
    public $rank;
    public $division;
    public $phone_cell;
    public $cellcarrier;
    public $code;
    public $squad;
    public $f_name;
    public $l_name;
    private $_detailsTable;

    public function __construct(\Gen\DatabaseTable $_detailsTable)
    {
        $this->$_detailsTable = $_detailsTable;
    }

    public function getDetails()
    {
        return $this->_detailsTable->find('detailNum', $this->uid);
    }
    public function takeDetail($detail)
    {
        $detail['detailNum'] = $this->uid;
        return $this->_detailsTable->save($detail);
    }
    public function hasPermission($permission)
    {
        return $this->permissions & permissions;
    }
}