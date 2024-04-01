<?php
defined('AREA') or die('Oops!...');
$user_id = isset($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : 0;
?>

<h3><?php fn_say('auction_list'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
<?php
if (!empty($data['lots'])) {
    $click_me = true;
    foreach ($data['lots'] as $lot) {
        ?>
        <tr>
            <td valign="top"><a href="<?= fn_link('index.lot&lot_id='.$lot['lot_id']); ?>"><img src="images/<?= $lot['image']; ?>" class="lot_icon"></a></td>
            <td valign="top">
                <a href="<?= fn_link('index.lot&lot_id='.$lot['lot_id']); ?>"><?= $lot['lot_name']; ?></a><br><br>
                <?= $lot['lot_descr']; ?>
                <br>
                <br>
                <?php
                include('include.lot_breif.php');
                ?>
            </td>
        </tr>
<?php
    }
} else {
    echo '<tr><td>'.__('no_current_lots').'<td></tr>';
}
?>
</table>
