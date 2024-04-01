$( '#verify_form' ).submit( function( event ) {
    event.preventDefault();

    //validate fields
    var fail = false;
    var fail_log = '';
    var name;
    $( '#form_id' ).find( 'select, textarea, input' ).each(function(){
        if( ! $( this ).prop( 'required' )){

        } else {
            if ( ! $( this ).val() ) {
                fail = true;
                name = $( this ).attr( 'name' );
                fail_log += name + " is required \n";
            }

        }
    });

    //submit if fail never got set to true
    if ( ! fail ) {
        //process form here.
    } else {
        alert( fail_log );
    }

});
