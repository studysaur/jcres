<?php

namespace Aux\Controllers;
use \Gen\DatabaseTable;

class Register {
   // private $user;
    private $usersTable;
    private $ranksTable;
    private $divisionsTable;
    private $squadsTable;


    public function __construct(DatabaseTable $usersTable, DatabaseTable $ranksTable, DatabaseTable $divisionsTable, $squadsTable){
        $this->usersTable = $usersTable;
        $this->ranksTable = $ranksTable;
        $this->divisionsTable = $divisionsTable;
        $this->squadsTable = $squadsTable;
    }

    public function registrationForm() {
        $ranks = $this->ranksTable->findAll('rankNo desc');
        $divisions =$this->divisionsTable->findAll('divNo');
        return ['template' => 'Aux/register.html.php',
                    'title' => 'Add New Deputy',
                    'variables' => [
                        'ranks' => $ranks,
                        'divisions' => $divisions
                    ]
                ];

    }

    public function success() {
     //   $first_name = (isset($_POST['f_name']) ? $_POST['f_name'] : 'Not set ');
     //   $last_name = (isset($_POST['l_name']) ? $_POST['l_name'] : 'Not set ');
        $to = 'Jeff_Mattison@co.jackson.ms.us';
        $sub = 'An application from ' .$_SESSION['name']. ' Has been received!';
        $msg = $_SESSION['name'] . ' has applied to be added to Auxiliary Web';
        $header = "From: jcres.us" . "\r\n" . 
            "CC: dean_sellars@co.jackson.ms.us";

        return ['template' => 'Aux/registersuccess.html.php',
                    'title' => 'Deputy Added',
                    'variables' => [                      
                        'to' => $to,
                        'sub' => $sub,
                        'msg' => $msg,
                        'header' => $header
                    ]
        ];
    }

    public function registerUser() {
        $ranks = $this->ranksTable->findAll('rankNo');
        $divisions = $this->divisionsTable->findAll('divNo');
        $user = $_POST['user'];
        // assume data valid
        $valid = true;
        $errors = [];
        // if any fields left blank, set $valid to false
        if (empty($user['f_name'])) {
            $valid = false;
            $errors[] = 'First name cannot be blank';
        }
        if (empty($user['l_name'])) {
            $valid = false;
            $errors[] = 'Last name cannot be blank';
        }
        if (empty($user['username'])) {
                    $valid = false;
                    $errors[] = 'User name cannot be blank';
                }  else {  // check to see if username is already in use
                    $user['username'] = strtolower($user['username']);
                    //search for the lowercase version of the username
                    if (count($this->usersTable->find('username', $user['username']))) {
                       $valid = false;
                        $errors[] = 'That User name is already in use';
                    }
                }
        if(!preg_match("/^[a-zA-Z_]{6,}$/", $user['username'])){
            $valid = false;
            $errors[] = 'Only the First and Last name for the username';
        }

        if (empty($user['rank'])) {
            $valid = false;
            $errors[] = 'Rank cannot be blank';
        }
        if (empty($user['unit_num'])) {
            $valid = false;
            $errors[] = 'Unit number cannot be blank';
        }
        if (!preg_match("/^[0-9]{1,3}$/", $user['unit_num'])){
            $valid = false;
            $errors[] = 'Unit number too long';
        }
        if (intval($user['unit_num']) > '510') {
            $valid = false;
            $errors[] = "Number too large";
        }
        if (empty($user['division'])) {
            $valid = false;
            $errors[] = 'Division cannot be blank';
        } 
        if (empty($user['phone_cell'])) {
            $valid = false;
            $errors[] = 'Cell phone number cannot be blank';
        }
        if (preg_match("/^[0-9]{10}$/", $user['phone_cell'])) {
            $num = $user['phone_cell'];
            $user['phone_cell'] = substr($num,0,3) . "-" . substr($num,3,3) . '-' . substr($num, 6);
        }
        if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $user['phone_cell'])){
            $valid = false;
            $errors[] = 'Must use either 1234567890 or 123-456-7890 format';
        }

        if ($valid == true) {
            $_SESSION['name'] = $user['f_name'] . ' ' . $user['l_name'];
            $this->usersTable->save($user);
            header('Location: /user/success');
        } else {
            // data not valid, show form again
            return ['template' => 'Aux/register.html.php',
                         'title' => 'Register a Deputy',
                         'variables' => [
                             'errors' => $errors,
                             'user' => $user,
                             'ranks' => $ranks,
                             'divisions' => $divisions
                        ]
                      ];
        } // end else
    }

    /**
     * The list function will display a list of 
     * all deputies
     * 
     * @return Array with data for Deputies list
     */
    public function ulist() { //rename this to list after upgrading to 7.1
        $orderBy = 'l_name';
        $users = $this->usersTable->findAll($orderBy);
        return ['template' => 'Aux/deputylist.html.php',
                    'title' => 'Deputies',
                    'variables' => ['users' => $users ]
            ];
    }
    /**
     * The list function will allow editing permissions 
     * for a deputy.  It will be called from the Deputy
     * list
     * 
     * @return Array with template for form for a Deputy
     */
    public function permissions() {
        $user = $this->usersTable->findById($_GET['uid']);
        $reflected = new \ReflectionClass('\Aux\Entity\User');
        $constants = $reflected->getConstants();
        return ['template' => 'Aux/permissions.html.php',
                'title' => 'Edit Permissions',
                'variables' => [
                    'user' => $user,
                    'status' => $constants
                    ]
                ];
    }
    /**
     * The list function saves the permissions set
     * by the editPermissions.  chk and cchk were moved to 
     * Login controller!  Permissions 
     * return uses ?: instead of ?? operator.  Change 
     * when used with php 7.++
     * 
     * @return Array deputy id and permissions to be 
     * submitted to the database
     */
    public function savePermissions() {
        $status = array_sum($_POST['status']) + \Aux\Controllers\Login::CHK;
        $user = [
            'uid' => $_GET['uid'],
            'status' => $status
        ];
        $this->usersTable->save($user);

        header('location: /user/ulist');
    }
    public function editUserForm() {
        $deputy = $this->usersTable->findById($_GET['uid']);
        $ranks = $this->ranksTable->findAll('rankNo');
        $divisions = $this->divisionsTable->findAll('divNo');
        $squads = $this->squadsTable->findAll('sid');
        return ['template' => 'Aux/edituser.html.php',
                    'title' => 'Edit Deputy',
                    'variables' => [
                        'ranks' => $ranks,
                        'divisions' => $divisions,
                        'deputy' => $deputy,
                        'squads' => $squads
                    ]
                ];
    }

    public function editUser() {
        $ranks = $this->ranksTable->findAll('rankNo');
        $divisions = $this->divisionsTable->findAll('divNo');
        $deputy = $this->usersTable->findById($_GET['uid']);
        $squads = $this->squadsTable->findAll('sid');
        $user = $_POST['user'];
           //assume valid data to start
        $valid = true;
        $errors =[];

        if(empty($user['username'])) {
            $valid = false;
            $errors[] = 'Username can not be blank';
        }
        if  (empty($user['phone_cell'])){
            $valid = false;
            $errors[] = 'Must have Cell Phone';
        }
        if  (empty($user['f_name'])){
            $valid = false;
            $errors[] = 'Must have First Name';
        }
        if  (empty($user['l_name'])){
            $valid = false;
            $errors[] = 'Must have last name';
        } 
        // if still valid, and all required fields are complete data will be saved
        if ($valid == true) {
            $this->usersTable->save($user);
            $message = $user['l_name'] . ' has submitted an application to the website.';
            mail('2148835555@vtext.com','New User',$user['l_name'] . $message);
            header('Location: /user/ulist');
        } else {
            return ['template' => 'Aux/edituser.html.php',
                    'title' => 'Edit User',
                    'variables' => [
                        'errors' => $errors,
                        'user' => $user,
                        'ranks' => $ranks,
                        'squads' => $squads,
                        'divisions' => $divisions,
                        'deputy' => $deputy
                    ]
                ];
        }
    }

}  // end class