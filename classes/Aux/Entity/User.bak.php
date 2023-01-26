<?php # user.
namespace Aux\Entity;

class User {
    const CHECK = 0X8081100;
    const CCHECK = 0x5a5d5b83;
    const PROBATION = 0x4;
    const REGULAR  = 0x8;
    const EXPLORER = 0x10;
    const AUXILIARY  = 0x20;
    const FTO_COMPLETE  = 0x40;
    const EDIT_DETAILS = 0x400;
    const POST_DETAILS = 0x200000;
    const LEAVE_OF_ABSENCE = 0x800000;
    const ADMIN = 0x1000000;
    const FIELD_TRAINING_OFFICER = 0x4000000;
    const FIREARM = 0x20000000;
    const DISABLE = 0x10000000;


/*  Class user.
 *  The class contains six attributes:  id, userType, username, email, pass, and dateAdded.
 *  The attributes match the corresponding database columns.
 *  The class contains four methods: 
 *  - setFlag($flag, $value)
 *  - FLAGS -> PROB, EXPLORER, FTE, EDET, FTED, OC, TASER, PDET, LOA, ADM, FIREARM, DIS
 *  - isUser($flag)
 *	- isValidUser()
 *	- getUsername()
 *	- getBadgeNo()
 *	- getRank()
 *	- showRank()
 * 	- getPhHome()
 * 	- getPhCell()
 *	- getCellCarrier()
 *	- getFname()
 * 	- getMname()
 *	- getLname()
 *	- getID() */

    // All attributes correspond to database columns.
    // All attributes are public.

    public $username;
    public $password;
    public $userid;
    public $userlevel;// this will store the current admin status
    public $status; // this will be the new way to store status int 2^31
    public $dsort;  // this is not used but stays until new programs are written to ignore it
    public $unit_num;
    public $dbadge_no;
    public $rank;
    public $dname;
    public $phone_home;
    public $phone_work;
    public $phone_cell;
    public $cellcarrier;
    public $email;
    public $timestamp;
    public $probationary;
    public $code;  //this is a varchar
    public $squad;
    public $f_name;
    public $m_name;
    public $l_name;
    public $uid;
    public $division;
    public $divNo;
    public $rankNo;

	//$chk = CHK;
	//$cchk = CCHK;    

public static function userExist(PDO $pdo, $username) {
	$num = 0;
	$q= 'SELECT uid FROM users WHERE username = :username';
	$stm = $pdo->prepare($q);
	$stm->bindparam(':username', $username);
	$stm->execute();
	$stm->setFetchMode(PDO::FETCH_NUM);
	$row = $stm->fetch();
	$num = $row[0];
	//echo $num;
	if(!$num){
		$num = 0;
		}
	return $num;
}
    
	function setFlag($flag, $value) {
		if($value) {
			$this->status |= $flag;
		} else {
			$this->status &= ~$flag;
		}
	}
    
    // Method returns if the user is valid:
   public function isValidUser() {
    	return (($this->status & CCHK) == CHK);
    }
    
    // Method returns a Boolean indicating if the user is one of the set flags:
    function isUser($flag) {
        return (($this->status & $flag) == $flag);
    }
    
   function getUsername() {
    	return ($this->username);
    }
    
    function getBadgeNo() {
    	return ($this->unit_num);
    }
    
    function getRank() {
    	return ($this->rank);
    }
    function showRank($rNo) {
         $rankArray = array(' ','Sheriff', 'Chief', 'Deputy Chief', 'Chaplin', 'Major', 'Captain', 'Lieutenant', 'Sergeant', 'investigator', 'Corporal', 'Deputy', 'Explorer');
    	return ($rankArray[$rNo]);
    
    }
    function getRankNo() {
    	return ($this->rankNo);
    }
    function getPhHome() {
    	return ($this->phone_home);
    }
    function getCode() {
    	return ($this->code);
    }
    function getSquad() {
    	return ($this->squad);
    }
    function getPhCell() {
    	return ($this->phone_cell);
    }
    
    function getCellCarrier() {
    	return ($this->cellcarrier);
    }
    
    function getFname() {
    	return ($this->f_name);
    }
    
    function getMname() {
    	return ($this->m_name);
    }
    
    function getLname() {
    	return ($this->l_name);
    }
    
    public function getId() {
    	return ($this->uid);
    }
    function getts() {
    	return ($this->timestamp);
    }
    function getDiv() {
    	return ($this->division);
    }
    function getDivNo() {
    	return ($this->divNo);
    }
} // End of User class.