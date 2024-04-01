<?php
defined('AREA') or die('Oops!...');

restricted();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'update') {
        $lot_id = $model->updateLot($_POST['lot']);
        if ($lot_id) {
            fn_redirect('lot.edit&lot_id='.$lot_id);
        } else {
            fn_redirect('lot.new');
        }
    }
    if ($_POST['action'] == 'delete') {
        $lot_id = isset($_POST['delete_lot']) ? $_POST['delete_lot'] : false;
        $model->deleteLot($lot_id);
        fn_redirect('lot.edit&index');
    }
}

if ($viewer == 'index') {
    $params['q'] = isset($_GET['q']) ? $_GET['q'] : '';
    $params['status'] = isset($_GET['status']) ? $_GET['status'] : '';
    $params['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
    $data['lot_list'] = $model->getLotList($params);
    $data['currency'] = $config->get('currency');
    $data['pagination'] = $model->getLotPagination($params);

    $lot_ids = array_column($data['lot_list'], 'lot_id');
    $data['bids'] = $model->getBids($lot_ids);

}

if ($viewer == 'edit') {
    $lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : false;
    if ($lot_id && $lot = $model->getLot($lot_id)) {
        $data['lot'] = $lot;
    } else {
        fn_redirect('lot.index');
    }
    $data['currency'] = $config->get('currency');
}

if ($viewer == 'new') {
    $data['currency'] = $config->get('currency');
    $data['lot_period_min'] = $config->get('lot_period_min');
    $data['lot_period_max'] = $config->get('lot_period_max');
}

if ($viewer == 'bids') {
    $data['currency'] = $config->get('currency');
    $lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : false;
    if ($lot_id) {
        $data['bids'] = $model->getLotBids($lot_id);
    } else {
        fn_redirect('lot.index');
    }
}
