<?php
defined('AREA') or die('Oops!...');
?>

<h3><?php fn_say('lot_bids'); ?> <a href="<?= fn_link('lot.edit&lot_id='.$_GET['lot_id']).'">'.__('lot_number').$_GET['lot_id']; ?></a></h3>

<table border=0 cellspacing=10 cellpadding=5>
<?php
if (!empty($data['bids'])) {
    foreach ($data['bids'] as $b) {
        echo '<tr>
            <td>'.date("Y-m-d",$b['bid_time']).'</td>
            <td>'.date("H:i", $b['bid_time']).'</td>
            <td><a href="'.fn_link('user.edit&user_id='.$b['user_id']).'">'.$b['firstname'].' '.$b['lastname'].'</a></td>
            <td align="right" nowrap>'.$b['price'].' '.$data['currency'].'</td>
        </tr>';
    }
} else {
    echo '<tr><td>'.__('no_bids').'</td></tr>';
}
?>
</table>
