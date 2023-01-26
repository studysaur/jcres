<?php
namespace Aux\Controllers;
use \Gen\DatabaseTable;
    
class Reset 
{
    private $usersTable;
   
    public function __construct(DatabaseTable $usersTable) {
        $this->usersTable = $usersTable;
    }

    public function resetForm() {
        return ['template' => '/Aux/reset.html.php', 'title' => 'Reset Password'];
    }
    public function success() {
        return ['template' => '/Aux/resetsuccess.html.php',
                'title' => 'Reset Successful'];
    }

    public function processReset() {
        $deputy = $_POST['deputy'];
        //assume data is valid
        $valid = true;
        $errors = [];
        //check for blank username

        if (empty($deputy['username'])) {
            $valid = false;
            $errors[] = 'User name can not be blank';
        }
        if ($valid)  { //start looking for username
            $user = $this->usersTable->find('username', $deputy['username']);
            if (!empty($user)) {
                //$_SESSION['status'] = $deputy[0]->status;
                $username = $user[0]->username;
                $status = $user[0]->status;
                $uid = $_SESSION['uid'] = $user[0]->uid;
                $valid = true;
            } else {    
                $valid = false;
                $errors[] = 'That user name is not found';
            }
            if ((isset($status) & \Aux\Entity\User::DISABLE) == \Aux\Entity\User::DISABLE) {
                session_destroy();
                header('Location: /disable');
            }
            if ((isset($status) & \Aux\Entity\User::LEAVE_OF_ABSENCE) == \Aux\Entity\User::LEAVE_OF_ABSENCE) {
                session_destroy();
                header('location: /login/loa');
            } 
        }
        if ($valid) {
            $_SESSION['code'] = mt_rand(100000, 999999);
            $_SESSION['uid'] = $user[0]->uid;
            $_SESSION['status'] = $user[0]->status;
            $_SESSION['username'] = $user[0]->username;
            $to = $user[0]->username . '@co.jackson.ms.us';
            $subject = "Password Reset Code";
            $message = "Your reset code is " . $code . "!";
            $headers = "From: doNotReply@jcres.us" . "\r\n" . "MIME-Version: 1.0 \r\n";
            //mail($to,$subject,$message,$headers);
            return ['template' => 'Aux/getcode.html.php',
                        'title' => 'Enter your code'
                    ];
        } else {
            return ['template' => '/Aux/reset.html.php',
                        'title' => 'Request Reset',
                        'variables' => [
                            'errors' => $errors,
                            'deputy' => $deputy
                    ]
                ];
        }
    }
    public function checkCode() {
        $valid = true;
        $errors = [];
        if ($_POST['code'] == $_SESSION['code']){
            return ['template' => 'Aux/setPassword.html.php',
                    'title' => 'Set Password',
                    'variables' => [
                        'code' => $_POST['code']
                    ]
                ];
        } else {
            $valid = false;
            $errors[] = 'Wrong Code';
            return ['template' => 'Aux/getcode.html.php',
                    'title' => 'Enter your Code',
                ];
        }
    }
 }