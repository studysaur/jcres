<?php
//$dsn = 'mysql:dbname=reserves;host=127.0.0.1';
$pdo = new PDO('mysql:host=localhost;dbname=reserves', 'jcres', 'LetmeinJCRES!');
//$pdo = new PDO('mysql: host=107.180.1.231;dbname=reserves;port=3306', 'jcres', 'LetmeinJCRES!');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);