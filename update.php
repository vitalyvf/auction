<?php
define('AREA', 'Z');

if (is_file('config.php')) {
	require_once('config.php');
} else {
	die('Config file not found');
}

if (!isset($_GET['cron']) || $_GET['cron'] != CRON_PASSWORD) {
	die(); exit;
}

// Main functionality
require_once(DIR_ENGINE.'language.php');
require_once(DIR_ENGINE.'db.php');
require_once(DIR_ENGINE.'model.php');
require_once(DIR_ENGINE.'settings.php');
require_once(DIR_ENGINE.'functions.php');
require_once(DIR_ENGINE.'mail.php');
$db = new DB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$config = new Config($db);

if ($config->get('php_errors') == 'Y') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$language = new Language(get_current_language(), 'update');

require_once(DIR_ENGINE.'model/'.$config->get('use_mail_model').'.php');
$mail = new Mail($config->get('use_mail_model'));
$mail->smtp_hostname = $config->get('mail_smtp_hostname');
$mail->smtp_username = $config->get('mail_smtp_username');
$mail->smtp_password = $config->get('mail_smtp_password');
$mail->smtp_port = $config->get('mail_smtp_port');
$mail->smtp_timeout = $config->get('mail_smtp_timeout');

require_once(DIR_ENGINE.'model/update.php');

$model = new ModelUpdateLots($db, $config);
$model->setMail($mail);
$model->updateLots();
$model->output();