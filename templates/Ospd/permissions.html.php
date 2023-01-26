<h2>Edit <?=$user->f_name . ' ' . $user->l_name?>'s Permissions</h2>

<form action="" method="post">
    <?php foreach ($status as $name => $value): ?>
    <div>
        <input name="status[]" type="checkbox" value="<?=$value?>" <?php if ($user->hasPermission($value)) echo 'checked'; ?> />
        <label><?=ucwords(strtolower(str_replace('_', ' ', $name)))?></label>
    </div>
    <?php endforeach; ?>

    <input type="submit" value="Submit" />
</form>