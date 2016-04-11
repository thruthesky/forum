<?php
/**
 * @file k-forum.php
 * @description
 *
 *
 *
 */


if ( 0 ) return 0; // k-forum 및 하위 카테고리가 아니면,


include 'class-post.php';



if ( isset($_REQUEST['no_theme']) ) {
    include 'test.php';
    return 1;
}


if ( isset( $_REQUEST['ajax'] ) ) include 'ajax.php';


include 'list-basic.php';

return 1;
