<?php
/**
 * The ifState File Doc Comment
 * 
 * PHP version 5.6
 * 
 * @category IfState.php
 * @package  JCRES
 * @author   Display name <dean@sellars.org>
 * @license  no license
 * @version  CVS:<cvs_id>1</cvs_id>
 * @link     http://jcres.test
 */

session_start();
$SESSION['user'] = 'Dino';

if (isset($SESSION['user']) ) : ?>
We have <?php echo $SESSION['user'] . ', </br>'; ?>
<?php else: ?>
no session </br>
<?php endif; ?>
more stuff
<?php 
echo date(DATE_RFC2822);
phpinfo();