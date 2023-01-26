<?php if (isset($error)):?> 
	 <div class="errors"><?=$error;?></div>
<?php endif; ?>
<?php 
//    echo $_POST['username'] . ' is the username <br>';
//	echo $_POST['password'] . ' is the password <br>';
    //if (isset($_SESSION['status'])) {
   // echo ($_SESSION['found']) . ' is the found <br>';
	//echo $_SESSION['ppassword'] . ' is the password used in authentication <br>'; 
//	echo $_SESSION['status'] . ' is the status <br>';
	//echo $_SESSION['uid'] . ' is uid <br>';
	//echo $user['status'] . ' is user status';
	
	
?>
<form method="post" action="">

	<label for="username">Your User Name</label>
	<input type="text" id="username" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>" size="30" placeholder="Username"><br>

	<label for="password"><br>Your password</label>
	<input type="password" id="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" size="30" placeholder="Password"><br>

	<input type="submit" name="login" value="Log in">
</form>
