<?php
defined('AREA') or die('Oops!...');

/**
 * Get correct controller and viewer from 'dispatch' get parameter
 * 
 * @param string  $controller_path       Path to controller files
 * @param string  $viewer_path           Path to viewer files
 * 
 * @return array
 */
function dispatch($controller_path, $viewer_path) 
{
    $controller = $viewer ='index';
    if (isset($_GET['dispatch'])) {
        $dispatch = explode('.', $_GET['dispatch']);
        if (isset($dispatch[0]) && isset($dispatch[1])) {
            $controller = $dispatch[0];
            $viewer     = $dispatch[1];
            $controller = is_file($controller_path.$dispatch[0].'.php') ? $dispatch[0] : 'index';

            $viewer = is_file($viewer_path.$dispatch[0].'/'.$dispatch[1].'.php') ? $dispatch[1] : 'index';
        }
    }
    return [$controller, $viewer];
}

/**
 * Display page
 * 
 * @param array   $data         Data sent to viewer
 * @param string  $viewer       Name of viewer
 * @param array   $messages     Messages to display
 * 
 * @return void
 */
function display($data, $viewer, $messages) 
{

    global $controller;
    if (AREA == ADMIN_AREA) {
        require_once(DIR_ADMIN.'core/viewer/head.php');
        if ($controller != 'auth') {
            require_once(DIR_ADMIN.'core/viewer/menu.php');
        }
        if (is_file(DIR_ADMIN.'core/viewer/'.$controller.'/'.$viewer.'.php')) {
            require_once(DIR_ADMIN.'core/viewer/'.$controller.'/'.$viewer.'.php');
        }
        require_once(DIR_ADMIN.'core/viewer/bottom.php');
    } else {
        require_once(DIR_ENGINE.'viewer/head.php');
        require_once(DIR_ENGINE.'viewer/menu.php');
        if (is_file(DIR_ENGINE.'viewer/'.$controller.'/'.$viewer.'.php')) {
            require_once(DIR_ENGINE.'viewer/'.$controller.'/'.$viewer.'.php');
        }
        require_once(DIR_ENGINE.'viewer/bottom.php');
    }
}

/**
 * Get current language
 * 
 * @return string
 */
function get_current_language()
{
    // Fake function
    $all_languages = USE_LANGUAGES;
    return reset($all_languages);
}

/**
 * Get language variable
 * 
 * @param string    $key        Key of labguage variable
 * @param array     $replace    Replacement data
 * 
 * @return string
 */
function __($key, $replace = [])
{
    global $language;
    return $language->get($key, $replace);
}

/**
 * Output language variable
 * 
 * @param string    $key        Key of labguage variable
 * @param array     $replace    Replacement data
 * 
 * @return string
 */
function fn_say($key, $replace = [])
{
    echo __($key, $replace);
}

/**
 * Build url to dispatch
 * 
 * @param string $dispatch Name of viewer
 * 
 * @return string
 */
function fn_link($dispatch)
{
    return 'index.php?dispatch='.$dispatch;
}

/**
 * Build GET parameters for pagination
 * 
 * @param integer   $page   Number of page
 * 
 * @return string
 */
function fn_link_pagination($page)
{
    $result = '';
    if (is_array($_GET)) {
        foreach ($_GET as $key => $value) {
            if ($key != 'page' && $key != 'dispatch') {
                $result .= '&'.$key.'='. $value;
            }
        }
        $result .= '&page='. $page;
    }
    return $result;
}

/**
 * Redirection
 * 
 * @param string    $dispatch    Key of labguage variable
 * 
 * @return void
 */
function fn_redirect($dispatch = '')
{
    $link = fn_link($dispatch);
    header('Location: '.$link);
    exit;
}

/**
 * Protect restricted area
 * 
 * @return void
 */
function restricted()
{
    //echo '<pre>'; var_dump($_SESSION); die;
    $allowed_user = isset($_SESSION['auth']['user_type']) && $_SESSION['auth']['user_type'] == AREA;
    if (!$allowed_user) {
        fn_redirect('auth.index');
    }
}

/**
 * Prepare messages for output
 * 
 * @return void
 */
function fn_get_messages() 
{
    $messages = [];
    $msg_types = ['error', 'success', 'info'];
    foreach ($msg_types as $type) {
        if (isset($_SESSION[$type])) {
            foreach ($_SESSION[$type] as $msg) {
                $messages[$type][] = $msg;
            }
            unset($_SESSION[$type]);
        }
    }
    return $messages;
}

/**
 * Get human readable time left before auction
 * 
 * @param integer   $lot_time     Unbix time of auction
 * 
 * @return string
 */
function fn_get_time_left($lot_time) 
{
    $result = '';
    if ($lot_time) {
        if ($lot_time > time()) {
            $diff=$lot_time-time();
            $temp=$diff/86400; // 60 sec/min*60 min/hr*24 hr/day=86400 sec/day 
            $days=floor($temp); 
            $result .= $days > 0 ? $days.' '.__('left_days').' ' : '';
            $temp=24*($temp-$days); 
            $hours=floor($temp); 
            $result .= $hours > 0 ? $hours.' '.__('left_hours').' ' : '';
            $temp=60*($temp-$hours); 
            $minutes=floor($temp);
            $result .= $minutes.' '.__('left_minutes');
        } else {
            $result .= __('auction_finished');
        }
    }
    return $result;
}

/**
 * Get human readable price
 * 
 * @param float   $price
 * 
 * @return string
 */
function fn_price_format($price) 
{
    global $config;
    $result = '';
    if ($price) {
        $price_string = strval($price);
        $tmp = explode('.', $price_string);
        $result .= $tmp[0].' '.$config->get('currency');
        if (isset($tmp[1]) && $tmp[1] != '00') {
            $result .= ' '.$tmp[1].' '.$config->get('currency_cent');
        }
    }
    return $result;
}

/**
 * Get the list of lots that need to be paid
 * 
 * @param integer   $user_id      Id of current user
 * 
 * @return array
 */
function get_lots_need_payment($user_id) 
{
    global $db;
    $result = [];
    if ($user_id) {
        $query = $db->query("SELECT l.lot_id, l.lot_name, b.user_id, b.price as max_bid FROM `".DB_PREFIX."lot` as l 
            LEFT JOIN `".DB_PREFIX."bid` as b ON b.bid_id = l.winner_bid
            WHERE l.status='S' AND b.user_id='".$user_id."'"
        );
        $result = $query->rows;
    }
    return $result;
}

/**
 * Get web directory
 * 
 * @param string   $uri      Content of $_SERVER['REQUEST_URI'] variable
 * 
 * @return array
 */
function fn_get_web_dir($uri) 
{
    $result = '';
    $uri_parts = explode('/', $uri);
    unset($uri_parts[array_key_last($uri_parts)]);
    foreach ($uri_parts as $part) {
        $result .= $part.'/';
    }
    return $result;
}