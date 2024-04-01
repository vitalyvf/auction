<?php
defined('AREA') or die('Oops!...');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <title><?php fn_say('heading_title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
    </head>
    <body>
        <div class="messages">
            <?php 
            if (!empty($messages)) {
                foreach ($messages as $type => $msg_list) {
                    foreach ($msg_list as $msg) {
                        echo '<div class="messages_' . $type . '">' . $msg . '</div>';
                    }
                }
            } 
            ?>
        </div>
        <table style="height: 100vh; width: 100%;" border=0 cellpadding=0 cellspacing=20>
            <tr>
                <td <?php if ($controller != 'auth') { echo ' valign="top" width=180'; } ?>>
