
<?php
    echo $_SESSION['uid'] . ' is the SESSION uid<br>';
    echo $_SESSION['username'] . ' is the username<br>';
//    echo $code . ' is the code passed by $code<br>';
//    echo $deputy . '  is the deputy<br>';
    echo $_SESSION['code'] . ' is the SESSION code<br>';
    echo $uid . ' is the uid passed as $uid';

?>
<?php if (!empty($errors)): ?>
    <div class="errors">
        <p>Wrong code</p>
        <ul>
            <?php foreach  ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>   
<form method="post" action="set/password">
    <label for="code">Enter the 6 digit code from your county email</label>
    <input type="text" id="code" name="code" size="6"><br>

    <input type="submit" name="submit" value="Submit Code">
</form>