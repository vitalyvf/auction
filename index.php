<?php
define('AREA', 'C');

if (is_file('config.php')) {
	require_once('config.php');
} else {
	die('Config file not found');
}

require_once(DIR_CUSTOMER.'/init.php');