<?php

$url = $_REQUEST['do']();

wp_redirect( $url ); // redirect to view the newly created post.


function post_create() {


    $my_post = array(
        'post_title'    => $_REQUEST['title'],
        'post_content'  => $_REQUEST['content'],
        'post_status'   => 'publish',
        'post_author'   => wp_get_current_user()->ID,
        'post_category' => array( $_REQUEST['category_id'] )
    );

    // Insert the post into the database
    $post_ID = wp_insert_post( $my_post );

    if ( is_wp_error( $post_ID ) ) {
        echo $post_ID->get_error_message();
        exit;
    }


    return get_permalink( $post_ID );
}