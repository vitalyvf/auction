<?php
defined('AREA') or die('Oops!...');
$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : false;
$user_id = isset($auth['user_id']) ? $auth['user_id'] : false;
?>
<div class="customer_menu">

<center>
<a href="index.php"><img src="images/auction_logo.png" class="auction_logo"></a>
</center>
<br>

<?php
if ($auth) {
?>

    <table border=0 cellpadding=0 cellspacing=10 style="margin: auto;">
        <form action="<?php echo fn_link('profile.login'); ?>" method="post">
        <input type="hidden" name="action" value="logout">
        <input type="hidden" name="return_url" value="<?php echo str_replace('dispatch=', '', $_SERVER['QUERY_STRING']); ?>">
        <tr>
            <td align="center">
                <?php echo $auth['firstname'].' '.$auth['lastname']; ?><br>
                <a href="<?php echo fn_link('profile.edit'); ?>"><?php fn_say('edit_profile'); ?></a>
            </td>
        </tr>
        <tr>
            <td align="center"><input type="submit" value="<?php fn_say('logout'); ?>"></td>
        </tr>
        </form>
        <tr>
            <td align="center" colspan=2>
                <?php
                $need_payment = get_lots_need_payment($user_id);
                echo '<a href="'.fn_link('profile.payment').'">';
                if (!empty($need_payment)) {
                    fn_say('payment_needed');
                } else {
                    fn_say('payment_list');
                }
                ?></a>
            </td>
        </tr>
        <tr>
            <td align="center"><a href="<?php echo fn_link('profile.history'); ?>"><?php echo __('bids_history'); ?></a></td>
        </tr>
    </table>
<?php
} else {
?>
    <table border=0 cellpadding=0 cellspacing=10 style="margin: auto;">
        <form action="<?php echo fn_link('profile.login'); ?>" method="post">
            <input type="hidden" name="action" value="login">
            <input type="hidden" name="return_url" value="<?php echo str_replace('dispatch=', '', $_SERVER['QUERY_STRING']); ?>">
            <tr>
                <td align="right"><?php fn_say('login'); ?></td>
                <td><input name="login" size="10"></td>
            </tr>
            <tr>
                <td align="right"><?php fn_say('pass'); ?></td>
                <td><input type="password" name="pass" size="10"></td>
            </tr>
            <tr style="background: #d1edfd">
                <td></td>
                <td><input type="submit" value="<?php fn_say('enter'); ?>"></td>
            </tr>
        </form>
        <?php
        if (isset($_SESSION['login_failed'])) {
            echo '<tr><td colspan=2 align=center class="error">';
            fn_say('incorrect_login');
            echo '</td></tr>';
        }
        ?>
        <tr>
            <td align="center" colspan=2><a href="<?php echo fn_link('profile.index'); ?>"><?php fn_say('registration'); ?></a></td>
        </tr>
    </table>

<?php
}
?>

</div>

</td><td valign="top">
