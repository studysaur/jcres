<?php if (isset($error)):?> 
	 <div class="errors"><?=$error;?></div>
<?php endif; ?>
<div class="login">
<form method="post" action="">

	<label for="username">Your User Name</label>
	<input type="text" id="username" name="username" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>" size="30" placeholder="Username"><br>

	<label for="password"><br>Your password</label>
	<input type="password" id="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" size="30" placeholder="Password"><br>

	<input type="submit" name="login" value="Log in">
</form>
</div>