<?php
defined('AREA') or die('Oops!...');
?>
<h3><?php fn_say('lot_search'); ?> <a href="<?= fn_link('lot.new'); ?>">[+]</a></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <form action="" method="get">
        <input type="hidden" name="dispatch" value="lot.index">
        <tr>
            <td><?php fn_say('search_word'); ?></td>
            <td><?php fn_say('status'); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><input name="q" size=12 value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>"></td>
            <td><select name="status">
                <option value=""><?php fn_say('all'); ?></option>
                <?php 
                    foreach (LOT_STATUS as $status => $lang_var) {

                        echo '<option value="'.$status.'"';
                        echo isset($_GET['status']) && $_GET['status'] == $status ? ' selected' : '';
                        echo '>'; 
                        fn_say($lang_var); 
                        echo '</option>';
                    } 
                ?></select>
            </td>
            <td><input type="submit" value="<?php fn_say('search'); ?>"></td>
        </form>
        <form action="" method="get">
            <input type="hidden" name="dispatch" value="lot.index">
            <td><input type="submit" value="<?php fn_say('cancel'); ?>"></td>
        </tr>
        </form>
</table>

<h3><?php fn_say('heading_title'); ?></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <?php 
    if (!empty($data['lot_list'])) {
        foreach ($data['lot_list'] as $lot) {
            $lot['max_bid'] = isset($data['bids'][$lot['lot_id']]) ? $data['bids'][$lot['lot_id']] : ' - ';
            $status = LOT_STATUS[$lot['status']];
            if (!empty($lot['images'])) {
                $lot_image = reset($lot['images']);
            }
            echo '<tr>
                <td valign="top" rowspan=2><a href="'.fn_link("lot.edit&lot_id=".$lot['lot_id']).'">#'.$lot['lot_id'].'</td>
                <td valign="top" rowspan=2><a href="'.fn_link("lot.edit&lot_id=".$lot['lot_id']).'"><img src="../images/'.$lot_image['file_name'].'" class="lot_icon"></a></td>
                <td valign="top" colspan=2><a href="'.fn_link("lot.edit&lot_id=".$lot['lot_id']).'">'.$lot['lot_name'].'</td>
            </tr>
            <tr>
                <td valign="top" align="right">'.
                    fn_get_time_left($lot['lot_time']).'<br>'.
                    date("Y-m-d H:i:s", $lot['lot_time']).'<br><br>'.
                    __('lot_max_price').'<br>'.
                    __('lot_max_bid').'<br>'.
                    __('lot_min_price').'<br>'.
                '</td>
                <td valign="top">'.__($status).'<br><br><br>'.
                    $lot['max_price'].'<br>'.
                    '<a href="'.fn_link("lot.bids&lot_id=".$lot['lot_id']).'">'.$lot['max_bid'].'</a><br>'.
                    $lot['min_price'].'<br>'.
                '</td>
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
            echo '<a href="'.fn_link('lot.index').$page_link.'">['.$i.']</a> ';
        } else {
            echo '['.$i.'] ';
        }
    }
    echo '</td></tr></table>';
}
?>
    
