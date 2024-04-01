<?php
defined('AREA') or die('Oops!...');

$auth = isset($_SESSION['auth']) ? $_SESSION['auth'] : [];
?>
<table border=0 width=180 cellspacing=10 cellpadding=0>
    <tr>
        <td><a href="../index.php" target="_blank"><img src="../images/auction_logo.png" width="64" border="0"></a></td>
    </tr>
    <tr>
        <td><a href="?"><?php fn_say('link_index'); ?></a></td>
    </tr>
    <tr>
        <td><a href="?dispatch=user.index"><?php fn_say('link_user'); ?></a></td>
    </tr>
    <tr>
        <td><a href="?dispatch=lot.index"><?php fn_say('link_lot'); ?></a></td>
    </tr>
    <tr>
        <td><a href="?dispatch=payment.index"><?php fn_say('link_payment'); ?></a></td>
    </tr>
    <tr>
        <td><a href="?dispatch=setting.index"><?php fn_say('link_setting'); ?></a></td>
    </tr>
        <tr>
        <td><br><br>
            <table border=0 cellpadding=0 cellspacing=10>
            <form action="<?= fn_link('auth.index'); ?>" method="post">
                <input type="hidden" name="action" value="logout">
                <tr>
                    <td align="center"><?= $auth['firstname'].' '.$auth['lastname']; ?></td>
                </tr>
                <tr>
                    <td align="center"><input type="submit" value="<?php fn_say('logout'); ?>"></td>
                </tr>
            </form>
            </table>
        
        </td>
    </tr>

</table>

</td><td valign="top">
