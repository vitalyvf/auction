<?php
defined('AREA') or die('Oops!...');

restricted();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'save') {
    $new_setting = isset($_POST['new_setting']) ? $_POST['new_setting'] : [];
    if (!empty($new_setting['description']) && !empty($new_setting['code'])) {
        $model->addSetting($new_setting);
    }

    $settings = isset($_POST['settings']) ? $_POST['settings'] : [];
    $model->update($settings);
    fn_redirect('setting.index');

}

if ($viewer == 'index') {
    $data['settings'] = $model->getSettingList();
}
