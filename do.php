<?php
/**
 *
 */
/**
 *
 */
$url = $_REQUEST['do']();
exit;


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

    $url = get_permalink( $post_ID );
    wp_redirect( $url ); // redirect to view the newly created post.
}


/**
 *
 *
 *
 * @WARNING
 *
 *      1. It uses md5() to avoid of replacing same file name.
 *          Since it does not add 'tag' like '(1)', '(2) for files which has same file name.
 *
 *      2. It uses md5() to avoid character set problems. like some server does not support utf-8 nor ... Most of servers do not support spanish chars. some servers do not support Korean characters.
 *
 *      3. It uses md5() to avoid possible matters due to lack of developmemnt time.
 *
 */
function file_upload() {

    $file = $_FILES["file"];

    // Sanitize filename.
    $filename = $file["name"];
    $filetype = wp_check_filetype( basename( $filename ), null );
    $sanitized_filename = sanitize_special_chars( $filename );

    // Get WordPress upload folder.
    $wp_upload_dir = wp_upload_dir();

    // Get URL and Path of uploaded file.
    $path_upload = $wp_upload_dir['path'] . "/$sanitized_filename";
    $url_upload = $wp_upload_dir['url'] . "/$sanitized_filename";

    if ( $file['error'] ) wp_send_json_error( get_upload_error_message($file['error']) );

    // Move the uploaded file into WordPress uploaded path.
    if ( ! move_uploaded_file( $file['tmp_name'], $path_upload ) ) wp_send_json_error( "Failed on moving uploaded file." );

    // Create a post of attachment.
    $attachment = array(
        'guid'           => $url_upload,
        'post_mime_type' => $filetype['type'],
        'post_title'     => $filename,
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    /**
     * This does not upload a file but creates a 'attachment' post type in wp_posts.
     *
     * @todo You uploaded an image, but "HOW WILL YOU DELETE IT when the upload does not belongs to any post?"
     */
    $attach_id = wp_insert_attachment( $attachment, $filename );

    // Update post_meta for the attachment.
    // You do it and you can use get_attached_file() and get_attachment_url()
    // update_attached_file will update the post meta of '_wp_attached_file' which is the source of "get_attached_file() and get_attachment_url()"
    update_attached_file( $attach_id, $path_upload );

    wp_send_json_success([
        'attach_id' => $attach_id,
        'url' => $url_upload,
        'type' => current(explode('/',$filetype['type'])),
        'file' => $file,
    ]);

}


function file_delete() {
    $id = $_REQUEST['id'];
    $path = get_attached_file( $id );
    if ( ! file_exists( $path ) ) {
        wp_send_json_error( new WP_Error('file_not_found', "File of ID $id does not exists. path: $path") );
    }

    // wp_delete_attachment() 는 attachment post 와 업로드 된 파일을 같이 삭제한다.
    if ( wp_delete_attachment( $id ) === false ) {
        wp_send_json_error( new WP_Error('failed_on_delete', "File of ID $id does not exists. path: $path") );
    }

    else {
        wp_send_json_success();
    }

}
