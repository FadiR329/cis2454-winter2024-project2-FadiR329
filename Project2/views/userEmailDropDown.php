<select name="email_address">
    <?php foreach ($users as $user) : ?>
        <option value="<?php echo $user->get_email_address() ?>"><?php echo $user->get_name() ?></option>
    <?php endforeach; ?>
    
</select>



