<?php if (isset($error)):?> 
	 <div class="errors"><?=$error;?></div>
<?php endif; ?>
<?php 
    echo $_POST['code'] . ' is the code from _POST <br>';
	echo $_POST['password'] . ' is the password <br>';
    if (isset($_SESSION['uid'])) {
    echo ($_SESSION['code']) . ' is the code <br>';
	echo $_SESSION['cpassword'] . ' is the cpassword used in authentication <br>'; 
	echo $_SESSION['status'] . ' is the status <br>';
	echo $_SESSION['uid'] . ' is uid <br>';
	echo $user['status'] . ' is user status';
    }
	
?>
<form method="post" action="">

	<label for="password">Enter your password</label>
	<input type="password" id="password" name="password" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>" size="30" placeholder="Username"><br>

	<label for="password"><br>Confirm Your password</label>
	<input type="password" id="cpassword" name="cpassword" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" size="30" placeholder="Password"><br>

	<input type="submit" name="Password" value="Set Password">
</form>
