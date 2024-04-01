<?php
defined('AREA') or die('Oops!...');
?>

<h3><?php fn_say('payment_search'); ?> </h3>
<table border=0 cellspacing=10 cellpadding=5>
    <form action="" method="get">
        <input type="hidden" name="dispatch" value="payment.index">
        <tr>
            <td><?php fn_say('payment_date'); ?></td>
            <td><?php fn_say('lot_id'); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><input type="date" name="payment_date" value="<?php echo isset($_GET['payment_date']) ? $_GET['payment_date'] : ''; ?>"></td>
            <td><input name="lot_id" value="<?php echo !empty($_GET['lot_id']) ? $_GET['lot_id'] : ''; ?>" size=8></td>
            <td><input type="submit" value="<?php fn_say('search'); ?>"></td>
        </form>
        <form action="" method="get">
            <input type="hidden" name="dispatch" value="payment.index">
            <td><input type="submit" value="<?php fn_say('cancel'); ?>"></td>
        </tr>
        </form>
</table>


<h3><?php fn_say('heading_title'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <?php 
    if (!empty($data['payment_list'])) {
        foreach ($data['payment_list'] as $p) {
            echo '<tr>
                <td>'.date("Y-m-d H:i", $p['payment_time']).'</td>
                <td><a href="'.fn_link("lot.edit&lot_id=".$p['lot_id']).'">'.$p['lot_name'].'</a></td>
                <td><a href="'.fn_link("user.edit&user_id=".$p['user_id']).'">'.$p['firstname'].' '.$p['lastname'].'</a></td>
                <td>'.$p['price'].' '.$data['currency'].'</td>
            </tr>';
        }
    }
    ?>
</table>

<?php
if ($data['pagination'] > 1) {
    echo '<table border=0 cellspacing=10 cellpadding=5><tr>
    <td>'.__('pages').'</td><td>';
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    for ($i=0; $i<$data['pagination']; $i++) {
        if ($i != $page) {
            $page_link = fn_link_pagination($i);
            echo '<a href="'.fn_link('payment.index').$page_link.'">['.$i.']</a> ';
        } else {
            echo '['.$i.'] ';
        }
    }
    echo '</td></tr></table>';
}
?>
    
