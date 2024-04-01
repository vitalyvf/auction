<?php
defined('AREA') or die('Oops!...');
?>
<script src="../js/verify_form.js"></script>
<h3><?php fn_say('user_profile_new'); ?></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <form id="verify_form" action="<?php echo fn_link('user.update'); ?>" method="post">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="user[user_id]" value="">
    <tr>
        <td><?php fn_say('login'); ?></td>
        <td><input name="user[login]" value="" required></td>
    </tr>
    <tr>
        <td><?php fn_say('password'); ?></td>
        <td><input name="user[password]" value="" required></td>
    </tr>
    <tr>
        <td><?php fn_say('user_type'); ?></td>
        <td><select name="user[user_type]">
            <?php 
            foreach (USER_TYPES as $type => $lang_var) {
                echo '<option value="'.$type.'">'; 
                fn_say($lang_var); 
                echo '</option>';

            } 
        ?>
        </select></td>
    </tr>
    <tr>
        <td><?php fn_say('status'); ?></td>
        <td><select name="user[status]">

        <?php 
            foreach (USER_STATUS as $status => $lang_var) {
                echo '<option value="'.$status.'">'; 
                fn_say($lang_var); 
                echo '</option>';
            } 
        ?>
        </select></td>
    </tr>
    <tr>
        <td><?php fn_say('firstname'); ?></td>
        <td><input name="user[firstname]" value="" required></td>
    </tr>
    <tr>
        <td><?php fn_say('lastname'); ?></td>
        <td><input name="user[lastname]" value="" required></td>
    </tr>
        <tr>
        <td><?php fn_say('subscribe'); ?></td>
        <td><input name="user[email]" value="" type="email"></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="<?php fn_say('create'); ?>"></td>
    </tr>
</form>
</table>
