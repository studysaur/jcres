
<?php if(!empty($errors)):?>
    <div class="errors">
        <p>Reset request not sent, please check the following:</p>
        <ul>
        <?php foreach($errors as $error): ?>
            <li><?=$error ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<p>Username is the first part of your county email.  Capitilization does not matter, Dean_Sellars or dean_sellars will both work.</p>
<p>If your name is in our system an email will be sent to you county email address. <strong>Note first time users should check the junk folder on their county email.</strong></p>
<p>If you receive an error message, it will advise you what you will need to do to correct the problem</p>
<?php

   if (!empty($deputy)) {
 //   echo $_POST['deputy'] . ' is $deputy name';
//    echo $_SESSION['Deputyname'] . ' is Session Deputyname<br>';
    echo $_SESSION['status'] . ' is Status<br>';
    echo $_SESSION['uid'] . ' is uid<br>';
    echo $_SESSION['code'] . ' is the code<br>';
//    echo $_SESSION['error'] . ' is Session error';
   }

?>
<form method="post" action"">
    <label for="username">Enter your user name.</label>
    <input type="text" name="deputy[username]" 
        id="username" type="text" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>"
        required
        placeholder="firstname_lastname"
        pattern="(.*_.*)"
        size="30" 
        value="<?php if(isset($deputy['username']) ? $deputy['username'] : ''); ?>"
    >
    <input type="submit" name="reset" value="Send Reset">
</form>