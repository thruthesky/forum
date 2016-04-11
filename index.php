<?php
/**
 * @file k-forum.php
 * @description
 *
 *
 *
 */


if ( 0 ) return 0; // Return if it is not category of forum page.


include 'class-post.php'; // load library



if ( isset($_REQUEST['no_theme']) ) { // see if it's a test connection.
    include 'test.php';
    return 1;
}


/**
 * This code will be deprecated.
 */
if ( isset( $_REQUEST['ajax'] ) ) include 'ajax.php';




include 'list-basic.php';

return 1;
