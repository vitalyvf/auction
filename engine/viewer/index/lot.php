<?php
defined('AREA') or die('Oops!...');
$lot = $data['lot'];
$user_id = isset($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : 0;
?>
<script>
    function show_big(i) {
        <?php foreach ($lot['images'] as $k => $img) { ?>
            document.getElementById('big_image_<?php echo $k; ?>').style.display = 'none';
        <?php } ?>
        document.getElementById('big_image_'+i).style.display = '';
    }
</script>

<h3><?php fn_say('auction_lot'); ?>: <?= $lot['lot_name']; ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <tr>
        <?php if (count($lot['images']) > 1) { ?>
        <td valign="top">
            <?php
            foreach ($lot['images'] as $k => $img) {
                echo '<img src="images/'.$img['file_name'].'" class="small_icon" onclick="javascript:show_big('.$k.')" style="margin-bottom: 5px"><br>';
            }
            ?>
        </td>
        <?php } ?>
        <td valign="top" width="240">
            <?php
            foreach ($lot['images'] as $k => $img) {
                echo '<div id="big_image_'.$k.'"';
                if ($k) {
                    echo ' style="display:none"';
                }
                echo '><img src="images/'.$img['file_name'].'" class="lot_icon"></div>';
            }
            ?>
        </td>

        <td valign="top">
            <?php echo $lot['lot_descr'];
            echo '<br>';
            echo '<br>';
            include('include.lot_breif.php');
            echo '<br>';
            if ($user_id) {
                include('include.lot_buttons.php');
            } else {
                echo '<p align="center">'.__('login_or_register1').'<a href="'.fn_link('profile.index').'">'.__('login_or_register2').'</a></p>';
            }
            ?>
        </td>
    </tr>
</table>
