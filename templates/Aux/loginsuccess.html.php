<h2>Login Successful</h2>
<p>You are now logged in.</p>
<p>

<?php if (isset($_SESSION['jscrpt'])):?>
   <p> <?=$_SESSION['jscrpt'] . ' is the jscrpt<br> ' ?></-p>
        <?php else:?>
   <p> jscrpt is not set </p>
<?php endif;?>

<p>Yes I know it use to go to the details page, and I am working on getting to do that again, but right now it cannot.</p>