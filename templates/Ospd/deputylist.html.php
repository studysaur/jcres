<h2>Deputy List</h2>
<?php $check = \Aux\Controllers\Login::CHK;
//echo dechex($check) . ' is check <br>'; 
//echo $_SESSION['query'] . ' is the query<br>';
//echo $_SESSION['primaryKey'] . ' is the primaryKey<br>';
/*if(isset($_SESSION['entity'])) {
    print_r($_SESSION['entity']);
    echo '<br>';
    print_r($_SESSION['puser']) . ' is the puser<br>';
}else {
    echo 'entity not set<br>';
}*/
/*if (isset($_SESSION['exp'])) {
    echo $_SESSION['exp'] . ' is the SESSION[exp]<br>';
} else {
    echo '<br>session exception not set<br>';
} */
// echo $_SESSION['fields'] . ' is the SESSION[fields]<br>';
/*if (isset($_SESSION['user'])) {
    $user =  $_SESSION['user'];
    if(is_object($user)){

        echo 'user is object<br>';
    }else {
      //  echo 'user is not object<br>';
        if(is_array($user)) {
            echo 'user is an array<br>';
                print_r($user);
                echo '<br>';
                }  
        }
       // echo is_string($user) ? 'user is string<br>' : 'user is not string<br>';
    } */
   // echo $user['uid'] . ' is the user[uid]<br>';
  //  echo dechex($user['status']) . ' is the user[status]<br>';

/*if(isset($_SESSION['spstatus'])) {
    $status = $_SESSION['spstatus'];
    echo dechex($status) . ' is the new status! <br>';
    }
if(isset($_SESSION['suid'])) {
    echo $_SESSION['suid'] . ' is suid<br>';
} */?>

<table>
    <thead>
        <th>Perm  </th>
        <th>Edit  </th>
        <th>Rank</th>
        <th>First Name  </th>
        <th>Last Name  </th>
        <th>Unit </th>
        <th>Division </th>

    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><a href="/user/permissions?uid=<?=$user->uid;?>"><img src="/images/checkmark.jpg"</a></td>
            <td><a href="/user/edit?uid=<?=$user->uid;?>"><img src="/images/edit.jpg"</a></td>
            <td><?=$user->rank;?></td>
            <td><?=$user->f_name;?></td>
            <td><?=$user->l_name;?></td>
            <td><?=$user->unit_num;?></td>
            <td><?=$user->division;?></td>

        </tr>
        <?php endforeach; ?>
    </tbody>

</table>