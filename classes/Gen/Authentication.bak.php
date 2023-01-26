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
 * The Authentication class is to allow users to
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
    private $users;
    private $usernameColumn;
    private $passwordColumn;
    
    public function __construct(DatabaseTable $users, $usernameColumn, $passwordColumn) {
        session_start();
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }
    
    public function login($username, $password) {
        //$_SESSION['username'] = strtolower($username);
        //$_SESSION['password'] = $password;
        //$_SESSION['usersUsernameColumn'] = $this->usernameColumn;
        $user = $this->users->find($this->usernameColumn, strtolower($username));
 //       $_SESSION['user'] = $user;
        
        if (!empty($user) && md5($password) == $user[0]->{$this->passwordColumn}) {
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $user[0]->{$this->passwordColumn};
            $_SESSION['status'] = $user[0]->status;
            return true;
        } else {
            return false;
        }
    }

    public function isLoggedin() {
        if (empty($_SESSION['username'])) {
            return false;
        }

        $user = $this->users->find($this->usernameColumn, strtolower($_SESSION['username']));

        if (!empty($user) && $user[0]->{$this->passwordColumn}  === $_SESSION['password']) {
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
            return $this->users->find($this->usernameColumn, strtolower($_SESSION['username'])[0]);
        }
        else {
            return false;
        }
    }
   
}
