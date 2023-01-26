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

<form action="" method="post">
    <ol>
        <li>
            <label for="username">Username must match county email</label>
            <input type="hidden" name="user[uid]" value="<?=$_GET['uid'] ?>">
            <input type="text" id="username" name="user[username]" value="<?= isset($deputy->username) ? $deputy->username : '' ?>" />
        </li>
        <li>
            <label for="unit_num">Deputies Unit number</label>
            <input type="text" id="unit_num" name="user[unit_num]" value="<?= isset($deputy->unit_num) ? $deputy->unit_num : ''?>" />
        </li>
        <li>
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
        </li>
        <li>
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
    </li>
    <li>
        <label for="phone_home">Home Phone</label>
        <input type="text" id="phone_home" name="user[phone_home]" value="<?= isset($deputy->phone_home) ? $deputy->phone_home : '';?>" />
    </li>
    <li>
        <label for="phone_cell">Cell Phone</label>
        <input type="text" id="phone_cell" name="user[phone_cell]" value="<?= isset($deputy->phone_cell) ? $deputy->phone_cell : '';?>" />
    </li>
    <li>
        <label for="code">This is the code on the Aux Roster</label>
        <input type="text" id="code" name="user[code]" value="<?=$deputy->code?>" />
    </li>
    <li>
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
    <li>
        </select><br>
        <label for="f_name">First Name</label>
    </li>
    <li>
        <input type="text" id="f_name" name="user[f_name]" value="<?= isset($deputy->f_name) ? $deputy->f_name : '';?>" />
        <label for="m_name">Middle name</label>
        <input type="text" id="m_name" name="user[m_name]" value="<?= isset($deputy->m_name) ? $deputy->m_name : '';?>" />
    </li>
    <li>
        <label for="l_name">Last name</label>
        <input type="text" id="l_name" name="user[l_name]" value="<?= isset($deputy->l_name) ? $deputy->l_name : '';?>" />
    </li>
</ol>
    <input type="submit" value="submit" />
</form>