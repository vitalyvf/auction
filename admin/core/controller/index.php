<?php
defined('AREA') or die('Oops!...');

restricted();

if ($viewer == 'index') {
    $data['users'] = $model->getUserStatistics();
    $data['lots'] = $model->getLotStatistics();
}
