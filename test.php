<?php
if ( !isset($_REQUEST['test']) || !$_REQUEST['test']) return _error('no function.');
$_REQUEST['test']();
exit;


function _error( $msg ) {
    echo $msg . "\n";
    return null;
}

/**
 *
 * 카테고리 아이디를 출력
 *
 *
 * curl "http://work.org/wordpress/category/k-forum/?no_theme=1&f=_category_id"
 *
 *
 * curl "http://work.org/wordpress/category/k-forum/?no_theme=1&f=_category_id&_name=질문과%20답변"
 *
 */
function _category_id() {
    $name = isset($_REQUEST['_name']) ? $_REQUEST['_name'] : '자유게시판';
    echo "$name : ";
    echo get_cat_ID( $name );
}

function input_posts() {

    $category = get_category_by_slug( $_REQUEST['slug'] );
    if ( is_wp_error($category) ) {
        $category->get_error_message();
        exit;
    }
    $category_id = $category->term_id;


    for ( $i = 1; $i < 100; $i ++ ) {

        $my_post = array(
            'post_title'    => "$i : post",
            'post_content'  => "This is $i nth content.<br>That's why I do...",
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( $category_id )
        );

        // Insert the post into the database
        wp_insert_post( $my_post );
    }

}

function _count_comment() {
    $obj = wp_count_comments( $_REQUEST['_id'] );
    print_r($obj);
}


