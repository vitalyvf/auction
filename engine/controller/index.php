<?php
defined('AREA') or die('Oops!...');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'make_bid') {
        $model->makeBid($_POST['lot_id'], $_POST['price']);
        fn_redirect('index.lot&lot_id='.$_POST['lot_id']);
    }
    if ($_POST['action'] == 'make_buy') {
        $model->makeBuy($_POST['lot_id']);
        fn_redirect('index.lot&lot_id='.$_POST['lot_id']);
    }
}

if ($viewer == 'index') {
    $data['lots'] = $model->getAuctionList();
    $data['title'] = $config->get('site_title').' - '.__('auction_list');
}

if ($viewer == 'lot') {
    $lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : '';
    $lot = $model->getLot($lot_id);
    if ($lot) {
        $data['lot'] = $model->getLot($lot_id);
        $data['title'] = $config->get('site_title').' - '.__('auction_lot');
        $data['currency'] = $config->get('currency');
    } else {
        fn_redirect('index.index');        
    }
}
