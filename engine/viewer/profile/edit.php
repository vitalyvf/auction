<?php
defined('AREA') or die('Oops!...');
?>

<script src="./js/verify_form.js"></script>
<h3><?php fn_say('my_profile'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <form id="verify_form" action="<?php echo fn_link('profile.index'); ?>" method="post">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="user[login]" value="<?php echo $auth['login']; ?>">
    <tr>
        <td><?php fn_say('your_login'); ?></td>
        <td><b><?php echo $auth['login']; ?></b></td>
    </tr>
    <tr>
        <td><?php fn_say('firstname'); ?></td>
        <td><input name="user[firstname]" value="<?php echo $auth['firstname']; ?>" required></td>
    </tr>
    <tr>
        <td><?php fn_say('lastname'); ?></td>
        <td><input name="user[lastname]" value="<?php echo $auth['lastname']; ?>" required></td>
    </tr>
    <tr>
        <td><?php fn_say('subscribe'); ?></td>
        <td><input name="user[email]" value="<?php echo $auth['email']; ?>" required></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="<?php fn_say('update'); ?>"></td>
    </tr>
</form>
</table>

<h3><?php fn_say('change_password'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <form id="verify_form" action="<?php echo fn_link('profile.index'); ?>" method="post">
    <input type="hidden" name="action" value="password">
    <input type="hidden" name="user[login]" value="<?php echo $auth['login']; ?>">
    <tr>
        <td><?php fn_say('pass'); ?></td>
        <td><input name="user[password]" value="" type="password" required></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="<?php fn_say('update'); ?>"></td>
    </tr>
</form>
</table>
