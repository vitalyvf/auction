<?php
defined('AREA') or die('Oops!...');
?>

    <table border=0 cellpadding=10 cellspacing=0 style="margin: auto;">
        <form action="<?= fn_link('auth.index'); ?>" method="post">
        <input type="hidden" name="action" value="login">
        <tr style="background: #d1edfd">
            <td align="right"><?php fn_say('login'); ?></td>
            <td><input name="login" size="10"></td>
        </tr>
        <tr style="background: #d1edfd">
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
            echo '<tr style="background: #d1edfd"><td colspan=2 align=center class="error">';
            fn_say('incorrect_login');
            echo '</td></tr>';
        }
        ?>
        <tr>
            <td align="center" colspan=2><a href="../"><?php fn_say('customer_zone'); ?></a></td>
        </tr>
    </table>
    
