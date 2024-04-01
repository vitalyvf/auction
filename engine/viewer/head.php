<?php
defined('AREA') or die('Oops!...');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <title><?php echo $data['title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
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
        <table border=0 cellpadding=0 cellspacing=20>
            <tr>
                <td width=240>
