<?php
defined('AREA') or die('Oops!...');
$lot_status = LOT_STATUS;
?>

<h3><?php fn_say('bids_history'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <?php
    foreach ($data['history'] as $lot_id => $h) {
        echo '<tr>';
        echo '<td colspan=4><a href="'.fn_link('index.lot&lot_id='.$lot_id).'">'.$h['lot_name'].'</a> ('.__($lot_status[$h['status']]).')</td>';
        echo '</tr>';
        foreach ($h['bids'] as $b) {
            echo '<tr>';
            echo '<td>'.date("Y-m-d", $b['bid_time']).'</td>';
            echo '<td>'.date("H:i", $b['bid_time']).'</td>';
            echo '<td>'.$b['price'].' '.$data['currency'].'</td>';
            echo '<td>';
            if ($b['winner_bid'] == $b['bid_id']) {
                fn_say('bid_wins');
            }
            echo '</td>';
            echo '</tr>';
   
        }
    }
    ?>
</table>
