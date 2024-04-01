<?php
defined('AREA') or die('Oops!...');
?>
<script src="../js/verify_form.js"></script>
<h3><?php fn_say('user_profile'); ?></h3>
<h2><i><?php echo $data['user']['login']; ?></i></h2>
<table border=0 cellspacing=10 cellpadding=5>
    <form id="verify_form" action="<?php echo fn_link('user.update'); ?>" method="post">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="user[user_id]" value="<?php echo $data['user']['user_id']; ?>">
    <tr>
        <td><?php fn_say('user_type'); ?></td>
        <td><select name="user[user_type]">
            <?php 
            foreach (USER_TYPES as $type => $lang_var) {
                echo '<option value="'.$type.'"';
                echo $data['user']['user_type'] == $type ? ' selected' : '';
                echo '>'; 
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
                echo '<option value="'.$status.'"';
                echo $data['user']['status'] == $status ? ' selected' : '';
                echo '>'; 
                fn_say($lang_var); 
                echo '</option>';
            } 
        ?>
        </select></td>
    </tr>
    <tr>
        <td><?php fn_say('firstname'); ?></td>
        <td><input name="user[firstname]" value="<?php echo $data['user']['firstname']; ?>" required></td>
    </tr>
    <tr>
        <td><?php fn_say('lastname'); ?></td>
        <td><input name="user[lastname]" value="<?php echo $data['user']['lastname']; ?>" required></td>
    </tr>
    <tr>
        <td><?php fn_say('subscribe'); ?></td>
        <td><input name="user[email]" value="<?php echo $data['user']['email']; ?>" type="email"></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="<?php fn_say('update'); ?>"></td>
    </tr>
</form>
</table>

<?php 
if ($_SESSION['auth']['user_id'] == $_GET['user_id']) {
?>

    <h3><?php fn_say('change_password'); ?></h3>
    <table border=0 cellspacing=10 cellpadding=5>
        <form action="<?php echo fn_link('user.update'); ?>" method="post">
        <input type="hidden" name="action" value="password">
        <input type="hidden" name="user_id" value="<?php echo $data['user']['user_id']; ?>">
        <tr>
            <td><?php fn_say('new_password'); ?></td>
            <td><input type="password" name="pass" value=""></td>
            <td><input type="submit" value="<?php fn_say('update'); ?>"></td>
        </tr>
    </form>
    </table>

<?php
} else {
?>

    <h3><?php fn_say('delete_user'); ?></h3>
    <table border=0 cellspacing=10 cellpadding=5>
        <form action="<?php echo fn_link('user.update'); ?>" method="post" onSubmit="return confirm('<?php fn_say('delete_user'); ?>?')">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="delete_user" value="<?php echo $data['user']['user_id']; ?>">
        <tr>
            <td><input type="submit" value="<?php fn_say('delete_user'); ?>"></td>
        </tr>
    </form>
    </table>

<?php
}
?>
