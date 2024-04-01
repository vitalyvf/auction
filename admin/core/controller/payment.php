<?php
defined('AREA') or die('Oops!...');

restricted();

if ($viewer == 'index') {
    $params['payment_date'] = isset($_GET['payment_date']) ? $_GET['payment_date'] : '';
    $params['lot_id'] = isset($_GET['lot_id']) ? $_GET['lot_id'] : '';
    $params['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
    $data['payment_list'] = $model->getPaymentList($params);
    $data['pagination'] = $model->getPaymentPagination($params);
    $data['currency'] = $config->get('currency');
}
