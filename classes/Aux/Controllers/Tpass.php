<?php
namespace Aux\Controllers;
use Gen\DatabaseTable;

class Tpass {
    private $tpass;

    public function __construct(DatabaseTable $tpass) {
        $this->tpass = $tpass;
    }

    public function sendNum() {
        $num = 123456;
        return $num;
    }

    public function setPass() {
        // get POST data and update database
    }

    
}