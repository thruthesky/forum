<?php

if ( !isset($_REQUEST['f']) || !$_REQUEST['f']) return _error('no function.');

$_REQUEST['f']();


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

function _insert_test_posts() {

    $my_post = array(
        'post_title'    => "1. 질문과 답변 게시판 글.",
        'post_content'  => "자, 빠리 빠릴 빨리 합니다.<br>돈 욕심이 많아 사업을 많이 한다?? 사업을 하면 다 잘되나?",
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_category' => array( get_cat_ID('질문과 답변') )
    );

    // Insert the post into the database
    wp_insert_post( $my_post );

}

function _count_comment() {
    $obj = wp_count_comments( $_REQUEST['_id'] );
    print_r($obj);
}


