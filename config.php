<?php
// DIR
$path = dirname(__FILE__);
define('DIR_ADMIN', $path.'/admin/');
define('DIR_CUSTOMER', $path.'/');
define('DIR_ENGINE', $path.'/engine/');
define('DIR_IMAGES', $path.'/images/');

// DB
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_DATABASE', 'auction');
define('DB_PORT', '3306');
define('DB_PREFIX', 'vf_');

// Languages
define('USE_LANGUAGES', ['ru']);

// Users
define('ADMIN_AREA', 'A');
define('CUSTOMER_AREA', 'C');
define('USER_TYPES', ['A' => 'user_type_a', 'C' => 'user_type_c']);
define('USER_STATUS', ['A' => 'status_active', 'D' => 'status_disabled']);

// Auction lots
define('LOT_STEPS', [10, 50, 100, 500, 1000, 5000, 10000, 50000, 100000]);
define('LOT_STATUS', ['N' => 'status_new', 'S' => 'status_sold', 'F' => 'status_failed', 'P' => 'status_paid', 'C' => 'status_canceled']);

// Protect cron script
define('CRON_PASSWORD', 'qwerty');
