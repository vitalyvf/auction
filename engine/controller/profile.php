<?php
defined('AREA') or die('Oops!...');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'login') {
        $model->login($_POST);
        $return_url = isset($_POST['return_url']) && !empty($_POST['return_url']) ? $_POST['return_url'] : 'index.index';
        fn_redirect($return_url);
    }

    if ($_POST['action'] == 'logout') {
        $model->logout($lot_id);
        $return_url = isset($_POST['return_url']) && !empty($_POST['return_url']) ? $_POST['return_url'] : 'index.index';
        fn_redirect($return_url);
    }

    if ($_POST['action'] == 'create') {
        $user_id = $model->createProfile($_POST['user']);
        if ($user_id) {
            fn_redirect('index.index');
        } else {
            fn_redirect('profile.index');
        }
    }

    if ($_POST['action'] == 'update') {
        if ($_POST['user']['login'] == $_SESSION['auth']['login']) {
            $model->updateProfile($_POST['user']);
        }
        fn_redirect('profile.edit');
    }

    if ($_POST['action'] == 'password') {
        if ($_POST['user']['login'] == $_SESSION['auth']['login']) {
            $model->changePassword($_POST['user']);
        }
        fn_redirect('profile.edit');
    }

    if ($_POST['action'] == 'pay') {
        $lot_id = isset($_POST['lot_id']) ? $_POST['lot_id'] : 0;
        $model->makePayment($lot_id);
        fn_redirect('profile.payment');
    }
}

if ($viewer == 'index') {
    if (!empty($_SESSION['auth'])) {
        fn_redirect('profile.edit');
    }
    $data['title'] = $config->get('site_title').' - '.__('registration');
}

if ($viewer == 'edit') {
    if (empty($_SESSION['auth'])) {
        fn_redirect('profile.index');
    }
    $data['title'] = $config->get('site_title').' - '.__('my_profile');
}

if ($viewer == 'payment') {
    $user_id = isset($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : false;
    if (!$user_id) {
        fn_redirect('profile.index');
    } else {
        $data['need_payment'] = get_lots_need_payment($user_id);
        $data['title'] = $config->get('site_title').' - '.__('payment_list');
        $data['payment_list'] = $model->getPaymentList($user_id);
        $data['currency'] = $config->get('currency');
    }
}

if ($viewer == 'history') {
    if (empty($_SESSION['auth'])) {
        fn_redirect('profile.index');
    }
    $data['history'] = $model->getBidsHistory();
    $data['title'] = $config->get('site_title').' - '.__('my_profile');
    $data['currency'] = $config->get('currency');
}