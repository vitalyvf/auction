<?php
defined('AREA') or die('Oops!...');

$seconds_in_day = 24*3600;
?>
<script src="../js/verify_form.js"></script>
<h3><?php fn_say('create_lot'); ?></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <form id="verify_form" action="<?= fn_link('lot.update'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="lot[lot_id]" value="">
    <tr>
        <td><?php fn_say('lot_name'); ?></td>
        <td><input name="lot[lot_name]" value="" required></td>
    </tr>
    <tr>
        <td><?php fn_say('lot_descr'); ?></td>
        <td><input name="lot[lot_descr]" value="" required></td>
    </tr>
    <tr>
        <td><?php fn_say('lot_icon'); ?></td>
        <td><input id="file" name="upload_icon" type="file"  required></td>
    </tr>
    <tr>
        <td><?php fn_say('lot_day'); ?></td>
        <td><input type="date" name="lot[date]" required 
            value="<?= date("Y-m-d", time() + $data['lot_period_min'] * $seconds_in_day); ?>" 
            min="<?= date("Y-m-d", time() + $data['lot_period_min'] * $seconds_in_day); ?>" 
            max="<?= date("Y-m-d", time() + $data['lot_period_max'] * $seconds_in_day); ?>">
        </td>
    </tr>
    <tr>
        <td><?php fn_say('lot_when'); ?></td>
        <td><select name="lot[hour]">
            <?php 
            for ($i=1; $i<25; $i++) {
                echo '<option value="'.$i.'"';
                if ($i==date("g")) {
                    echo ' selected';
                }
                echo '>'.$i.'</option>';
            } 
        ?>
        </select>

        <select name="lot[minutes]">
            <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
            
        
        </td>
    </tr>
    <tr>
        <td><?php fn_say('lot_min_price'); ?></td>
        <td><input name="lot[min_price]" value="" required> <?= $data['currency']; ?></td>
    </tr>
    <tr>
        <td><?php fn_say('lot_max_price'); ?></td>
        <td><input name="lot[max_price]" value="" required> <?= $data['currency']; ?></td>
    </tr>
    <tr>
        <td><?php fn_say('lot_price_step'); ?></td>
        <td><select name="lot[lot_step]">
            <?php 
            foreach (LOT_STEPS as $step) {
                echo '<option value="'.$step.'">'.$step.'</option>';
            } 
        ?>
        </select> <?= $data['currency']; ?></td>
    </tr>

    <tr>
        <td></td>
        <td><input type="submit" value="<?php fn_say('create'); ?>"></td>
    </tr>
</form>
</table>
