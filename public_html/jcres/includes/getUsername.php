<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $q  ='SELECT * FROM users WHERE username = :username';
    $stmt = $pdo->prepare($q);
    $stmt->bindParam(':username', $username);
    $r=$stmt->execute();
    if ($r){
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Aux\Entity\User');
        $user = $stmt->fetch();
   }
}