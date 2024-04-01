<?php
defined('AREA') or die('Oops!...');
if ($lot['status'] == 'N' && $lot['lot_time'] > time()) {
?>

<table border=0 cellpaddong=0 cellspacing=2 id="buttons">
    <form action="<?php echo fn_link('index.lot'); ?>" method="post" id="bid_form">
        <tr>
        <input type="hidden" name="action" value="make_bid">
        <input type="hidden" name="price" value="<?= $lot['bid']; ?>" id="price">
        <input type="hidden" name="lot_id" value="<?= $lot['lot_id']; ?>">
        <input type="hidden" name="lot_step" value="<?= $lot['lot_step']; ?>" id="lot_step">
        <input type="hidden" name="bid_price" value="<?= $lot['bid']; ?>" id="bid_price">
        <input type="hidden" name="max_price" value="<?= $lot['max_price']; ?>" id="max_price">
        
            <?php
            if ($lot['winner_user'] == $user_id) { 
                $hide_my_bid = '';
                $hide_bid_buttons = ' style="display:none"';
            } else {
                $hide_my_bid = ' style="display:none"';
                $hide_bid_buttons = '';
            }
            echo '<td'.$hide_my_bid.'>'.__('your_bid').' '.fn_price_format($lot['bid']).'</td>';
            echo '<td'.$hide_bid_buttons.'><div id="decrease_bid" class="bid_button"><b>-</b></div></td>';
            echo '<td'.$hide_bid_buttons.' nowrap><div id="make_bid" class="bid_button big_button">'.__('txt_bid').' <span id="show_price">'.$lot['bid'].'</span> '.$data['currency'].'</div></td>';
            echo '<td'.$hide_bid_buttons.'><div id="increase_bid" class="bid_button"><big>+</big></div></td>';

            ?>
            <td width=2></td>
        </form>
        <form action="<?= fn_link('index.lot'); ?>" method="post" id="buy_form">
            <input type="hidden" name="action" value="make_buy">
            <input type="hidden" name="lot_id" value="<?= $lot['lot_id']; ?>">
            <td nowrap><div id="make_buy" class="bid_button big_button"><?php fn_say('txt_buy'); echo ' '.fn_price_format($lot['max_price']); ?></td></td>
        </tr>
    </form>
</table>

<div id="no_web_socket" style="display:none">
    <p align="center"><?php fn_say('no_web_socket'); ?></p>
</div>

<div id="container">
    <div id="chat_log">
    </div><!-- #chat_log -->
</div><!-- #container -->


<script>
    $(document).ready(function() {
        if (!("WebSocket" in window)) {
            $('#buttons').css("display", "none");
            $('#no_web_socket').css("display", "");
        } else {
            //The user has WebSockets 
            var max_price = parseFloat(<?= $lot['max_price']; ?>);
            var lot_step = parseFloat(<?= $lot['lot_step']; ?>);

            connect();
            function connect(){
                var socket;
                var host = "ws://<?admin $_SERVER['HTTP_HOST']; ?>:8089";
                try{
                    var socket = new WebSocket(host);
                    //message('<p class="event">Socket Status: '+socket.readyState);
                    socket.onopen = function(){
                        //message('<p class="event">Socket Status: '+socket.readyState+' (open)');
                    }
                    socket.onmessage = function(msg){
                        var recieved = msg.data;
                        if (recieved == '<?= $lot['lot_id']; ?>') {
                            message('<meta http-equiv="refresh" content="1">');    
                        }
                    }
                    socket.onclose = function(){
                        //message('<p class="event">Socket Status: '+socket.readyState+' (Closed)');
                    }
                } catch(exception){
                    message('<p>Error: '+exception);
                }
                function send(){
                    var text = '<?= $lot['lot_id']; ?>';
                    try{
                        socket.send(text);
                        //message('<p class="event">Sent: '+text)
                    } catch(exception){
                        //message('<p class="warning">');
                    }
                    $('#text').val("");
                }
                function message(msg){
                    $('#chat_log').append(msg+'</p>');
                }
                $('#make_bid').click(function(event) {
                    send();
                    $('#bid_form').submit();
                });	
                $('#make_buy').click(function(event) {
                    send();
                    $('#buy_form').submit();
                });	
                $('#decrease_bid').click(function(event) {
                    var current_price = parseFloat($('#price').val());
                    var min_price = parseFloat($('#bid_price').val());
                    var lot_step = parseFloat($('#lot_step').val());
                    var new_price = (+current_price) - (+lot_step);
                    if (new_price >= min_price) {
                        new_price = new_price.toFixed(2);
                        $('#price').val(new_price);
                        $('#show_price').html(new_price);
                    }
                });	
                $('#increase_bid').click(function(event) {
                    var current_price = parseFloat($('#price').val());
                    var max_price = parseFloat($('#max_price').val());
                    var lot_step = parseFloat($('#lot_step').val());
                    var new_price = (+current_price) + (+lot_step);
                    if (new_price < max_price) {
                        new_price = new_price.toFixed(2);
                        $('#price').val(new_price);
                        $('#show_price').html(new_price);
                    }
                });	

                
            }//End connect 
        }//End else 
    });
</script>

<?php
} else {
    echo '<p align="center"><b>'.__('auction_is_over').'</b></p>';
}
?>
