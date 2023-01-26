<?php # user.
namespace Aux\Entity;

class User {
    const CERTIFIED = 0X2;
    const PROBATION = 0x4;
    const REGULAR  = 0x8;
    const ACADEMY = 0X10;
    const AUXILIARY  = 0x20;
    const FTE  = 0x40;
    const CHAPLIN = 0X80;
    const EDIT_DETAILS = 0x400;
    const POST_DETAILS = 0x800;
    const FIELD_TRAINING_OFFICER = 0x10000;
    const LEAVE_OF_ABSENCE = 0x4000;
    const ADMIN = 0x8000;
    const DISABLE = 0x20000;
    const TEST = 0X40000;
 
/*  Class user.
 *  The class contains six attributes:  id, userType, username, email, pass, and dateAdded.
 *  The attributes match the corresponding database columns.
 *  The class contains four methods: 
 *  - setFlag($flag, $value)
 *  - FLAGS -> PROB, EXPLORER, FTE, EDET, FTED, OC, TASER, PDET, LOA, ADM, FIREARM, DIS
 *  - isUser($flag)
 *	- isValidUser()
 */

    // All attributes correspond to database columns.
    // All attributes are public.

    public $username;
    public $password;
    public $uid;
    public $status; // this will be the new way to store status int 2^31
    public $unit_num;
    public $rank;
    public $division;
    public $phone_home;
    public $phone_cell;
    public $cellcarrier;
    public $email;
    public $timestamp;
    public $code;  //this is a varchar
    public $squad;
    public $f_name;
    public $m_name;
    public $l_name;

    public function __construct() {
    }
    
	function setFlag($flag, $value) {
		if($value) {
			$this->status |= $flag;
		} else {
			$this->status &= ~$flag;
		}
	}
    
    public function hasPermission($permission) {
        return $this->status & $permission;
    }

} // End of User class.