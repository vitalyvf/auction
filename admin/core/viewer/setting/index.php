<?php
defined('AREA') or die('Oops!...');
?>

<h3><?php fn_say('txt_create_setting'); ?></h3>

<table border=0 cellspacing=10 cellpadding=5>
    <form action="<?= fn_link('setting.save'); ?>" method="post">
    <input type="hidden" name="action" value="save">
    <td colspan=2></td>
    <tr>
        <td><?php fn_say('txt_descr'); ?></td>
        <td><input name="new_setting[description]" size=16></td>
    </tr>
    <tr>
        <td><?php fn_say('txt_code'); ?></td>
        <td><input name="new_setting[code]" size=16></td>
    </tr>
    <tr>
        <td><?php fn_say('txt_input_type'); ?></td>
        <td>
            <select name="new_setting[setting_type]">
                <option value="input">input</option>
                <option value="select">select</option>
                <option value="checkbox">checkbox</option>
            </select>
        </td>
    </tr>
    <tr id="value_input">
        <td><?php fn_say('txt_value'); ?></td>
        <td><input name="new_setting[value_input]" size=16></td>
    </tr>
    <tr id="value_select">
        <td valign="top"><?php fn_say('txt_value_select'); ?></td>
        <td><textarea name="new_setting[value_select]" cols=16 rows=5>value1,descr1;
value2,descr2;
value3,descr3;</textarea></td>
    </tr>
    <tr id="value_checkbox">
        <td><?php fn_say('txt_value_checkbox'); ?></td>
        <td>
            <input type="hidden" name="new_setting[value_checkbox]" value="N">
            <input type="checkbox" name="new_setting[value_checkbox]" value="Y">
        </td>
    </tr>
</table>
<h3><?php fn_say('heading_title'); ?></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <?php if (!empty($data['settings'])) {
        foreach ($data['settings'] as $s) {
            echo '<tr>
                <td width="200" valign="top">' . $s['description'] . '</td>
                <td valign="top">';
                if ($s['setting_type'] == 'checkbox') {
                    echo '<input type="hidden" name="settings['.$s['setting_id'].']" value="N">';
                    echo '<input type="checkbox" name="settings['.$s['setting_id'].']" value="Y"';
                    if ($s['value'] == 'Y') {
                        echo ' checked';
                    }
                    echo '>';
                } else if ($s['setting_type'] == 'select') {
                    echo '<select name="settings['.$s['setting_id'].']">';
                    $variants = json_decode($s['variants'], true);
                    if (is_array($variants)) {
                        foreach ($variants as $value => $descr) {
                            echo '<option value="'.$value.'"';
                            if ($s['value'] == $value) {
                                echo ' selected';
                            }
                            echo '>'.$descr.'</option>';
                        }
                    }
                    echo '</select>';
                } else {
                    echo '<input name="settings['.$s['setting_id'].']" value="'.$s['value'].'" size=16>';
                }
                echo '</td>
            </tr>';
        }
    }
    ?>
    <tr>
        <td colspan=2 align="center"><input type="submit" value="<?php fn_say('txt_save'); ?>"></td>
    </tr>
    </form>
</table>
