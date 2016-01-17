/**
 * Created by Karen Araya Milashka on 16/01/2016.
 */

$(document).ready( function( ) {
   $("form").submit( function(evt) {
       evt.preventDefault( );
       $.post( "mail.php", $(this).serializeArray(), function(data) {
           alert( data );
       })
   })
});