<?php
/**
 * PHP version 5.6
 * 
 * @category PHP
 * @package  Jcresus_Build
 * @author   Dean Sellars <dino@sellars.org>
 * @license  no license
 * @link     http://jcres.test
 */
namespace Gen;
/**
 * The Authentication class is to allow user to
 * login to the site and verify login credentials
 * 
 * @category PHP
 * @package  Auxiliary_Package
 * @author   Dean Sellars <dino@sellars.org>
 * @license  no license
 * @link     http://jcres.test
 */
class Authentication
{
    private $user;
    private $usernameColumn;
    private $passwordColumn;
    private $idColumn;
    
    public function __construct(DatabaseTable $user, $usernameColumn, $passwordColumn = null, 
    $idColumn = null) {
        session_start();
        $this->user = $user;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
        $this->idColumn = $idColumn;
    }
    
    public function login($username, $password) {

        $user = $this->user->find($this->usernameColumn, strtolower($username));
        $_SESSION['plength'] = strlen($user[0]->{$this->passwordColumn});
        if ($_SESSION['plength'] == 32) {
            $tpass = $_SESSION['password32'] = $user[0]->{$this->passwordColumn};
            $_SESSION['ppassword'] = $password;
            if (md5($password) == $tpass) {
                $_SESSION['match'] = ' matched<br>';
            } else {
                $_SESSION['match'] = ' not matched<br>';
            }
        }
     /*      if (empty($user)) {
               $_SESSION['found'] = 'empty <br>';
           } else {
               $_SESSION['found'] = 'not empty';
        } */
        if (!empty($user) && md5($password) == $user[0]->{$this->passwordColumn}) {
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $user[0]->{$this->passwordColumn};
            $_SESSION['status'] = $user[0]->status;
            $_SESSION[$this->idColumn] = $user[0]->{$this->idColumn};
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedin() {
        if (empty($_SESSION['username'])) {
            return false;
        }
        
        $user = $this->user->find($this->usernameColumn, strtolower($_SESSION['username']));
     //   if (isset($idColumn)) $_SESSION['uid'] = $user[0]->{$this->idColumn};
        if (isset($user) && $user[0]->{$this->passwordColumn}  === $_SESSION['password']) {
            return true;
        } else {
            return false;
        }
    }

    public function hasPermission($permission) {
        if (empty($_SESSION['status'])) {
            return false;
        }
        if ($_SESSION['status'] & $permission) {
            return true;
        } else {
            return false;
        } 

    }
    
    public function getUser() {
        if ($this->isLoggedin()) {
            return $this->user->find($this->usernameColumn, strtolower($_SESSION['username'])[0]);
        }
        else {
            return false;
        }
    }
    public function generateRandID() {
          return md5($this->generateRandStr(16));
    }
    
    private function generateRandStr($length) {
          $randstr = "";
          for($i=0; $i<$length; $i++){
              $randnum = mt_rand(0,61);
              if($randnum < 10){
                 $randstr .= chr($randnum+48);
              }else if($randnum < 36){
                  $randstr .= chr($randnum+55);
         } else {
            $randstr .= chr($randnum+61);
         }
      }
      return $randstr;
    }
   
}
