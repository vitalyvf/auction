<?php
defined('AREA') or die('Oops!...');
?>

<?php
if (!empty($data['need_payment'])) {
?>
<h3><?php fn_say('payment_needed'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <?php
    foreach ($data['need_payment'] as $need) {
        echo '<form action="'.fn_link('profile.index').'" method="post">';
        echo '<input type="hidden" name="action" value="pay">';
        echo '<input type="hidden" name="lot_id" value="'.$need['lot_id'].'">';
        echo '<tr>';
        echo '<td valign="top" width="300">'.__('txt_pay').' <a href="'.fn_link('index.lot&lot_id='.$need['lot_id']).'">'.$need['lot_name'].'</a></td>';
        echo '<td valign="top">'.$need['max_bid'].' '.$data['currency'].'</td>';
        echo '<td valign="top"><input type="submit" value="'.__('txt_pay').'"></td>';
        echo '</tr>';
        echo '</form>';
    }
    ?>
</table>

<?php
}
?>
<h3><?php fn_say('payment_list'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <?php
    if (!empty($data['payment_list'])) {
        foreach ($data['payment_list'] as $p) {
            echo '<tr>';
            echo '<td>'.date("Y-m-d H:i", $p['payment_time']).'</td>';
            echo '<td valign="top" width="300">'.__('txt_paid').' <a href="'.fn_link('index.lot&lot_id='.$p['lot_id']).'">'.$p['lot_name'].'</a></td>';
            echo '<td>'.$p['price'].' '.$data['currency'].'</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td>'.__('no_payments_found').'</td></tr>';
    }
    ?>
</table>