<?php
defined('AREA') or die('Oops!...');

session_start();

// Main functionality
require_once(DIR_ENGINE.'language.php');
require_once(DIR_ENGINE.'db.php');
require_once(DIR_ENGINE.'model.php');
require_once(DIR_ENGINE.'settings.php');
require_once(DIR_ENGINE.'functions.php');
$db = new DB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$config = new Config($db);

if ($config->get('php_errors') == 'Y') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Use dispatcher to get controller name and viewer name
if (AREA == ADMIN_AREA) {
    $model_path = DIR_ADMIN.'core/model/';
    $controller_path = DIR_ADMIN.'core/controller/';
    $viewer_path = DIR_ADMIN.'core/viewer/';
} else {
    $model_path = DIR_ENGINE.'model/';
    $controller_path = DIR_ENGINE.'controller/';
    $viewer_path = DIR_ENGINE.'viewer/';
}
list($controller, $viewer) = dispatch($controller_path, $viewer_path);
$language = new Language(get_current_language(), $controller);

// Init output data
$data = [];

// Load model
if (is_file($model_path.$controller.'.php')) {
    require_once($model_path.$controller.'.php');
    $model_name = 'Model'.ucfirst($controller);
    if (class_exists($model_name)) {
        $model = new $model_name($db, $config);
    }
}

// Launch controller
require_once($controller_path.$controller.'.php');

// Use viewer
$messages = fn_get_messages();
display($data, $viewer, $messages);
