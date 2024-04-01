<?php
defined('AREA') or die('Oops!...');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'login') {
        $model->login($_POST);
        fn_redirect('index.index');
    }
    if ($_POST['action'] == 'logout') {
        $model->logout();
        fn_redirect('auth.index');
    }
}
