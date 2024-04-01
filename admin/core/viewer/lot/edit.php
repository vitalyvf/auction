<?php
defined('AREA') or die('Oops!...');
$lot = $data['lot'];
?>
<script src="../js/verify_form.js"></script>
<h3><?php fn_say('edit_lot'); ?> #<?= $lot['lot_id']; ?> <a href="<?= fn_link('lot.bids&lot_id='.$lot['lot_id']); ?>"><?php fn_say('lot_bids'); echo ' ('.$lot['bids'].')'; ?></a></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <form id="verify_form" action="<?= fn_link('lot.update'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="lot[lot_id]"  value="<?= $lot['lot_id']; ?>">
    <tr>
        <td><?php fn_say('lot_name'); ?></td>
        <td><input name="lot[lot_name]" required  value="<?= $lot['lot_name']; ?>"></td>
    </tr>
    <tr>
        <td><?php fn_say('lot_descr'); ?></td>
        <td><input name="lot[lot_descr]" required value="<?= $lot['lot_descr']; ?>"></td>
    </tr>
    <tr>
        <td><?php fn_say('status'); ?></td>
        <td><select name="lot[status]">
        <?php
            foreach (LOT_STATUS as $status => $lang_var) {
                if ($lot['status'] == $status || $status == 'C') {
                    echo '<option value="'.$status.'"';
                    echo $lot['status'] == $status ? ' selected' : '';
                    echo '>'; 
                    fn_say($lang_var); 
                    echo '</option>';
                }
            }
        ?>
        </select>
        <?php
        if ($lot['status'] == 'P') {
            echo ' <a href="'.fn_link("payment.index&lot_id=".$lot['lot_id']).'">'.__('lot_payment').'</a>';
        }
        ?>
    
    </td>
    </tr>
    <?php
        if (!empty($lot['images'])) {
            foreach ($lot['images'] as $img) {
                echo '<tr>
                    <td><img src="../images/'.$img['file_name'].'" class="lot_icon"></td>
                    <td>'.__('delete_lot_icon').'<input type="checkbox" name="delete_image[]" value="'.$img['image_id'].'"></td>
                </tr>';
            }
        }
    ?>
    <tr>
        <td><?php fn_say('add_lot_icon'); ?></td>
        <td><input id="file" name="upload_icon" type="file"></td>
    </tr>
    <tr>
        <td><?php fn_say('lot_day'); ?></td>
        <td>
            <?= date("Y-m-d", $lot['lot_time']); ?>
        </td>
    </tr>
    <tr>
        <td><?php fn_say('lot_when'); ?></td>
        <td>
            <?= date("H:i", $lot['lot_time']); ?>
        </td>
    </tr>
    <tr>
        <td><?php fn_say('lot_min_price'); ?></td>
        <td>
            <?= $lot['min_price']; ?> <?= $data['currency']; ?>
        </td>
    </tr>
    <tr>
        <td><?php fn_say('lot_max_price'); ?></td>
        <td>
            <?= $lot['max_price']; ?> <?= $data['currency']; ?>
        </td>
    </tr>
    <tr>
        <td><?php fn_say('lot_price_step'); ?></td>
        <td>
            <?= $lot['lot_step']; ?> <?= $data['currency']; ?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td><input type="submit" value="<?php fn_say('update'); ?>"></td>
    </tr>
</form>
</table>

<?php
if ($lot['status'] != 'P') {
?>
    <h3><?php fn_say('delete_lot'); ?></h3>
    <table border=0 cellspacing=10 cellpadding=5>
        <form action="<?= fn_link('lot.update'); ?>" method="post" onSubmit="return confirm('<?php fn_say('delete_lot'); ?>?')">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="delete_lot" value="<?= $lot['lot_id']; ?>">
        <tr>
            <td><input type="submit" value="<?php fn_say('delete_lot'); ?>"></td>
        </tr>
    </form>
    </table>
<?php
}
?>
