<?php
defined('AREA') or die('Oops!...');
if (isset($lot['lot_time']) && isset($lot['winner_user']) && isset($lot['bid']) && isset($lot['lot_step']) && isset($lot['max_price']) && isset($user_id)) {
?>
<table border=0 cellpadding=0 cellspacing=5>
    <tr>
        <td>
            <div class="auction_info">
                <a href="<?= fn_link('index.lot&lot_id='.$lot['lot_id']); ?>"><img src="images/auction_time.jpg" class="small_icon"></a>
                <?php
                if ($lot['status'] == 'N') {
                    fn_say('before_auction');
                    echo '<br><b>'.fn_get_time_left($lot['lot_time']).'</b>';
                } else {
                    fn_say('auction_is_over');
                }
                ?>
            </div>
        </td>
        <td>
            <div class="auction_info">
                <a href="<?= fn_link('index.lot&lot_id='.$lot['lot_id']); ?>"><img src="images/auction_bid.jpg" class="small_icon"></a>
                <?php 
                if ($lot['status'] == 'N') {
                    if ($user_id && $lot['winner_user'] == $user_id) {
                        fn_say('your_bid'); 
                    } else {
                        fn_say('make_bid'); 
                    } 
                    echo '<br><b>'.fn_price_format($lot['bid']).'</b>';
                } else {
                    fn_say('auction_is_over');
                }
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="auction_info">
                <a href="<?= fn_link('index.lot&lot_id='.$lot['lot_id']); ?>"><img src="images/auction_step.jpg" class="small_icon"></a>
                <?php fn_say('price_step'); ?><br>
                <b><?= fn_price_format($lot['lot_step']); ?></b>
            </div>
        </td>
        <td>
            <div class="auction_info">
                <a href="<?= fn_link('index.lot&lot_id='.$lot['lot_id']); ?>"><img src="images/auction_buy.jpg" class="small_icon"></a>
                <?php fn_say('price_buy'); ?><br>
                <b><?= fn_price_format($lot['max_price']); ?></b>
            </div>
        </td>
    </tr>
</table>
<?php
} else {
    echo '<pre>';
    var_dump($lot, $user_id);
    echo '</pre>';
}
?>
