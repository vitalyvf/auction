<?php
defined('AREA') or die('Oops!...');
?>

<script src="./js/verify_form.js"></script>
<script src="./js/verify_phone_number.js"></script>
<script>
    function use_as_login(a) {
        document.getElementById('tr_login').style.display = 'none';
        document.getElementById('tr_email').style.display = 'none';
        document.getElementById('tr_phone').style.display = 'none';
        document.getElementById('input_login').required = false;
        document.getElementById('input_email').required = false;
        document.getElementById('input_phone').required = false;
        document.getElementById('tr_'+a).style.display = '';
        document.getElementById('input_'+a).required = true;
    }
</script>
<h3><?php fn_say('registration'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <form id="verify_form" action="<?php echo fn_link('profile.index'); ?>" method="post">
    <input type="hidden" name="action" value="create">
    <tr>
        <td valign="top"><?php fn_say('use_as_login'); ?></td>
        <td>
            <input id="use_login" type="radio" name="user[use_as_login]" value="login" checked onchange="javascript:use_as_login('login')"><label for="use_login"><?php fn_say('login'); ?></label><br>
            <input id="use_email" type="radio" name="user[use_as_login]" value="email" onchange="javascript:use_as_login('email')"><label for="use_email"><?php fn_say('email'); ?></label><br>
            <input id="use_phone" type="radio" name="user[use_as_login]" value="phone" onchange="javascript:use_as_login('phone')"><label for="use_phone"><?php fn_say('phone'); ?></label>
        </td>
    </tr>
    <tr id="tr_login">
        <td><?php fn_say('login'); ?></td>
        <td><input id="input_login" name="user[login]" value="" required></td>
    </tr>
    <tr id="tr_email" style="display:none">
        <td><?php fn_say('email'); ?></td>
        <td><input id="input_email" name="user[email]" value="" type="email"></td>
    </tr>
    <tr id="tr_phone" style="display:none">
        <td><?php fn_say('phone'); ?></td>
        <td><input id="input_phone" name="user[phone]" value="" placeholder="+7(000)000 0000" class="phone_number"></td>
    </tr>
    <tr>
        <td><?php fn_say('pass'); ?></td>
        <td><input name="user[password]" value="" required></td>
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
