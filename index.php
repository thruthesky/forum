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
 * @warning We don't do ajax now. Maybe we do it later.
 */
if ( isset( $_REQUEST['ajax'] ) ) include 'ajax.php';


/**
 * 'do' codes.
 */
if ( isset( $_REQUEST['do'] ) ) include 'do.php';


/**
 * The code below should print out get_header(), get_footer()
 */
if ( is_single() ) {
    include 'single-basic.php';
}
else {
    include 'category-basic.php';
}



return 1;
