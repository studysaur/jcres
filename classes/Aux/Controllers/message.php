<?php //message.php
$user['l_name'] = 'Fred_Ruble';
$message = $user['l_name'] . ' has submitted an application to the website.';
$subject = 'New user application';
$headers = 'From: Webmaster@jcres.us' . "\r\n" . 'Reply-To: Do not reply' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
mail('2148835555@vtext.com', $subject, $message, $headers);