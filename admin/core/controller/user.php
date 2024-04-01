<?php
defined('AREA') or die('Oops!...');

restricted();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'update') {
        $user_id = $model->updateUser($_POST['user']);
        if ($user_id) {
            fn_redirect('user.edit&user_id='.$user_id);
        } else {
            fn_redirect('user.new');
        }
    }
    if ($_POST['action'] == 'delete') {
        $user_id = isset($_POST['delete_user']) ? $_POST['delete_user'] : false;
        if ($user_id) {
            $model->deleteUser($user_id);
        }
        fn_redirect('user.index');
    }
    if ($_POST['action'] == 'password') {
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : false;
        $pass = isset($_POST['pass']) ? $_POST['pass'] : false;
        if ($user_id && $pass) {
            $model->changePassword($user_id, $pass);
            fn_redirect('user.edit&user_id='.$user_id);
        } else {
            fn_redirect('user.index');
        }
    }
}

if ($viewer == 'index') {
    $params['q'] = isset($_GET['q']) ? $_GET['q'] : '';
    $params['status'] = isset($_GET['status']) ? $_GET['status'] : '';
    $params['user_type'] = isset($_GET['user_type']) ? $_GET['user_type'] : '';
    $params['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
    $data['user_list'] = $model->getUserList($params);
    $data['pagination'] = $model->getUserPagination($params);
}

if ($viewer == 'edit') {

    $user_id = isset($_GET['user_id']) && $_GET['user_id'] == strval(intval($_GET['user_id'])) ? $_GET['user_id'] : false;
    if ($user_id && $user = $model->getUser($user_id)) {
        $data['user'] = $user;
    } else {
        fn_redirect('user.index');
    }
}
