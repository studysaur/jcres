<?php // pass_function.inc.php

// Generate random password
// Characters to use for the password

function generatePassword() {
$str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-+=_,!@$#*%<>[]{}";
 
// Desired length of the password
$pwlen = 8;
 
// Length of the string to take characters from
$len = strlen($str);
 
// RANDOM.ORG - We are pulling our list of random numbers as a 
// single request, instead of iterating over each character individually
$uri = "http://www.random.org/integers/?";
$random = file_get_contents(
    $uri ."num=$pwlen&min=0&max=".($len-1)."&col=1&base=10&format=plain&rnd=new");
$indexes = explode("\n", $random);
array_pop($indexes);
 
// We now have an array of random indexes which we will use to build our password
$pw = '';
foreach ($indexes as $int){
    $pw .= substr($str, $int, 1);
// Password is stored in `$pw`    
}  // end of foreach
return $pw;
} // end of function
 
?>

