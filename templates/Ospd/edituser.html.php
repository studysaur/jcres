<?php if (!empty($errors)): ?>
    <div class="errors">
        <p>The changes can not be saved, check the following:</p>
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<?= $_GET['uid'] . ' is the UID<br>'; ?>
<?= $deputy->uid . ' is the deputy->uid<br>'; ?>
<?php/* print_r($deputy);
    echo '<br>';
    if(isset($user)){
    print_r($user);
    } */
    ?>

<form action="" method="post">
    <input type="hidden" name="user[uid]" value="<?=$_GET['uid'] ?>">
    <label for="username">Username must match county email</label>
    <input type="text" id="username" name="user[username]" value="<?=$deputy->username ?? ''?>" />
 
    <label for="unit_num">Deputies Unit number</label>
    <input type="text" id="unit_num" name="user[unit_num]" value="<?=$deputy->unit_num ?? ''?>" />

    <label for="rank">Rank</label>
    <select name="user[rank]" id="rank">
        <?php if($ranks != null) {
            $count = count($ranks);
            $rank = (isset($deputy->rank) ? $deputy->rank : '');
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
        <option value="" disabled selected hidden>Choose the division from the Roster</option>
        <?php   if($divisions != null){
            $count = count($divisions);
            $division = (isset($deputy->division) ? $deputy->division : '');
              echo $division . ' is the division';
           for ($i =0; $i < $count; $i++){
               if ($divisions[$i]->division == $division) {
                echo '<option value="' . $divisions[$i]->division . '" selected>' . $divisions[$i]->division . '</option>';
               } else {
                echo '<option value="' . $divisions[$i]->division . '">' . $divisions[$i]->division . '</option>';
               }
            }
        }?>
    </select>
    <label for="phone_home">Home Phone</label>
    <input type="text" id="phone_home" name="user[phone_home]" value="<?=$deputy->phone_home ?? ''?>" />

    <label for="phone_cell">Cell Phone</label>
    <input type="text" id="phone_cell" name="user[phone_cell]" value="<?=$deputy->phone_cell ?? ''?>" />

    <label for="code">This is the code on the Aux Roster</label>
    <input type="text" id="code" name="user[code]" value="<?=$deputy->code?>" />

    <label for="squad">Squad Currently used to make Aux Roster</label>
    <select name="user[squad]" id="squad">
        <?php if($squads != null) {
            $count = count($squads);
            $squad = (isset($deputy->squad) ? $deputy->squad : '');
            for ($i =0; $i < $count; $i++){
                if ($squads[$i]->squad == $squad) {
                 echo '<option value="' . $squads[$i]->squad . '" selected>' . $squads[$i]->squad . '</option>';
                } else {
                 echo '<option value="' . $squads[$i]->squad . '">' . $squads[$i]->squad . '</option>';
                }
             }
         }?>
    </select><br>
    <label for="f_name">First Name</label>
    <input type="text" id="f_name" name="user[f_name]" value="<?=$deputy->f_name ?? ''?>" />

    <label for="m_name">Middle name</label>
    <input type="text" id="m_name" name="user[m_name]" value="<?=$deputy->m_name ?? ''?>" />
    
    <label for="l_name">Last name</label>
    <input type="text" id="l_name" name="user[l_name]" value="<?=$deputy->l_name ?? ''?>" />
    <input type="submit" value="submit" />
</form>