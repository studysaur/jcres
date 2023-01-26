<?php if (!empty($errors)): ?>
    <div class="errors">
        <p>The account could not be created, please check the following:</p></div>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach;  ?>
        </ul>
    </div>
<?php endif; ?>
<?php // echo ($_POST['user']['username']) . ' is the username'; ?>
<h2>This Web Site is only for Sworn Officers of Jackson County!</h2>
<p>All applications are reviewed before access is granted to the site</p>
<form action="" method="post">
    <label for="username">Enter the username, Must match your county email!</label>
    <input name="user[username]"
        id="username" type="text"
        required
        placeholder="firstname_lastname"
        pattern="(.*_.*)"
        value="<?= isset($_POST['user']['username']) ? ($_POST['user']['username']) : ''; ?>"
    >
   
    <label for="f_name">Deputies first name</label>
    <input name="user[f_name]" 
        id="f_name" type="text" 
        required 
        placeholder="Enter First Name"
        pattern="([A-Z].*)"
        value="<?= isset($_POST['user']['f_name']) ? ($_POST['user']['f_name']) : ''; ?>"
    >
    
    <label for="f_name">Deputies middle name</label>
    <input name="user[m_name]" 
        id="m_name" type="text" 
        placeholder="Enter Middle Name"
        pattern="([A-Z].*)"
        value="<?php isset($_POST['user']['m_name']) ? ($_POST['user']['m_name']) : ''; ?>"
    >
    
    <label for="l_name">Deputies last name</label>
    <input name="user[l_name]" 
        id="l_name" type="text" 
        required 
        pattern="([A-Z].*)"
        placeholder="Enter Last Name" 
        value="<?= isset($_POST['user']['l_name']) ? ($_POST['user']['l_name']) : ''; ?>"
    >

    <label for="unit_num">Badge Number</label>
    <input name="user[unit_num]"
        id="unit_num" 
        type="text" 
        required 
        placeholder="Enter Badge Number"
        value="<?= isset($_POST['user']['unit_num']) ? ($_POST['user']['unit_num']) : ''; ?>"

    <label for="rank">Select Rank</label>
    <select name="user[rank]" id="rank">
        <?php   if($ranks != null){
            $count = count($ranks);
            $rank = (isset($_POST['user']['rank']) ? $_POST['user']['rank'] : 'Deputy');
             // echo $rank . ' is the rank';
            for ($i =0; $i < $count; $i++){
               if ($ranks[$i]->rank == $rank) {
                echo '<option value="' . $ranks[$i]->rank . '" selected>' . $ranks[$i]->rank . '</option>';
               } else {
                echo '<option value="' . $ranks[$i]->rank . '">' . $ranks[$i]->rank . '</option>';
               }
            }
        }?>
    </select><br>
    <label for="rank">Select Division</label>
    <select name="user[division]" id="division" required>
        <option value="" disabled selected hidden>Choose your division from the Roster</option>
        <?php   if($divisions != null){
            $count = count($divisions);
            $division = (isset($user['division']) ? $user['division'] : '');

           for ($i =0; $i < $count; $i++){
               if ($divisions[$i]->division == $division) {
                echo '<option value="' . $divisions[$i]->division . '" selected>' . $divisions[$i]->rank . '</option>';
               } else {
                echo '<option value="' . $divisions[$i]->division . '">' . $divisions[$i]->division . '</option>';
               }
            }
        }?>
    </select><br>
    <label for="phone_cell">Cell Phone</label>
    <input type="tel"
        name="user[phone_cell]" 
        id="phone_cell"
        placeholder="1234567890"
        
        required
        value="<?= isset($_POST['user']['phone_cell']) ? ($_POST['user']['phone_cell']) : ''; ?>" >

    <label for="phone_home">Home Phone</label>
    <input type="tel"
        name="user[phone_home]"
        id="phone_home" 
        placeholder="1234567890"
        pattern="^[0-9]{10}"> 
    <br><input class="right" type="submit" name="submit" value="Add Deputy" ><br>
</form>