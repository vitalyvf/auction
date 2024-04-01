<?php
defined('AREA') or die('Oops!...');
?>

<h3><?php fn_say('heading_title'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <tr>
        <td><?php fn_say('users_total'); ?></td>
        <td><?= $data['users']['total']; ?></td>
    </tr>
    <tr>
        <td><a href="<?= fn_link('user.index&q=&status=A&user_type=C'); ?>"><?php fn_say('users_active'); ?></a></td>
        <td><?php echo $data['users']['active']; ?></td>
    </tr>
    <tr>
        <td><a href="<?= fn_link('user.index&q=&status=&user_type=A'); ?>"><?php fn_say('users_admin'); ?></a></td>
        <td><?php echo $data['users']['admin']; ?></td>
    </tr>
</table>

<table border=0 cellspacing=10 cellpadding=5>
    <?php
    if (is_array($data['lots'])) {
        foreach ($data['lots'] as $status => $count) {
            if ($status == 'total') {
                echo '<tr>
                    <td>'.__('lots_'.$status).'</a></td>
                    <td>'.$count.'</td>
                </tr>';
            } else {
                echo '<tr>
                    <td><a href="'.fn_link("lot.index&q=&status=".$status).'">'.__('lots_'.$status).'</a></td>
                    <td>'.$count.'</td>
                </tr>';
            }
        }
    }
    ?>
</table>
