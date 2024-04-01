<?php
defined('AREA') or die('Oops!...');
?>
<h3><?php fn_say('user_search'); ?> <a href="<?php echo fn_link('user.new'); ?>">[+]</a></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <form action="" method="get">
        <input type="hidden" name="dispatch" value="user.index">
        <tr>
            <td><?php fn_say('search_word'); ?></td>
            <td><?php fn_say('status'); ?></td>
            <td><?php fn_say('user_type'); ?></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td><input name="q" size=12 value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>"></td>
            <td><select name="status">
                <option value=""><?php fn_say('all'); ?></option>
                <?php 
                    foreach (USER_STATUS as $status => $lang_var) {

                        echo '<option value="'.$status.'"';
                        echo isset($_GET['status']) && $_GET['status'] == $status ? ' selected' : '';
                        echo '>'; 
                        fn_say($lang_var); 
                        echo '</option>';
                    } 
                ?></select>
            </td>
            <td><select name="user_type">
                <option value=""><?php fn_say('all'); ?></option>
                <?php 
                foreach (USER_TYPES as $type => $lang_var) {
                    echo '<option value="'.$type.'"';
                    echo isset($_GET['user_type']) && $_GET['user_type'] == $type ? ' selected' : '';
                    echo '>'; 
                    fn_say($lang_var); 
                    echo '</option>';

                } 
                ?></select>
            </td>
            <td><input type="submit" value="<?php fn_say('search'); ?>"></td>
        </form>
        <form action="" method="get">
            <input type="hidden" name="dispatch" value="user.index">
            <td><input type="submit" value="<?php fn_say('cancel'); ?>"></td>
        </tr>
        </form>
</table>

<h3><?php fn_say('heading_title'); ?></h3>
<table border=0 cellspacing=10 cellpadding=5>
    <?php 
    if (!empty($data['user_list'])) {
        foreach ($data['user_list'] as $u) {
            echo '<tr>
                <td><a href="'.fn_link("user.edit&user_id=".$u['user_id']).'">#'.$u['user_id'].'</td>
                <td><a href="'.fn_link("user.edit&user_id=".$u['user_id']).'">'.$u['login'].'</td>
                <td><a href="'.fn_link("user.edit&user_id=".$u['user_id']).'">'.$u['firstname'].' '.$u['lastname'].'</td>
                <td valign="top">';
            echo $u['user_type'] == 'A' ? __('user_type_a') : __('user_type_c');
            echo '</td><td>';
            echo $u['status'] == 'A' ? __('status_active') : __('status_disabled');
            echo '<td></tr>';
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
            echo '<a href="'.fn_link('user.index').$page_link.'">['.$i.']</a> ';
        } else {
            echo '['.$i.'] ';
        }
    }
    echo '</td></tr></table>';
}
?>
    