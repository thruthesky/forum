<?php

class Post {
    public function get_post() {
        $re = get_post( $_REQUEST['id'], ARRAY_A );
        $re['comments'] = get_comments([
            'post_id' => $re['ID'],
            'status' => 'approve',
        ]);
        return $re;
    }
    public function the_date() {
        $Ymd = get_the_time("Ymd");
        if ( $Ymd == date('Ymd') ) echo get_the_date('H:i');
        else echo get_the_date('m-d');
    }

    public function increaseNoOfView( $postID )
    {
        $count_key = 'no_of_views';
        $count = get_post_meta($postID, $count_key, true);
        if( empty($count) ) {
            $count = 1;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, $count);
        }
        else{
            $count ++;
            update_post_meta($postID, $count_key, $count);
        }
        return $count;
    }
    public function getNoOfView($post_ID)
    {
        $count_key = 'no_of_views';
        $count = get_post_meta($post_ID, $count_key, true);
        return $count ? $count : 0;
    }

    /**
     * @param $post_ID
     * @return int
     *
     * @code
     * <?php echo post()->getNoOfAttachment( get_the_ID() ) ?>
     * @endcode
     */
    public function getNoOfAttachment($post_ID)
    {
        $images = get_attached_media( 'image', $post_ID );
        $count = count($images);
        return $count;
    }

    /**
     * @warning It cannot count 'gallery'.
     * @param $content
     * @return int
     * @code
     * <?php echo post()->getNoOfImg( get_the_content() ) ?>
     * @endcode
     */
    public function getNoOfImg($content) {
        return preg_match_all('/<img[^>]+>/i', $content);
    }

} // eo class


function post() {
    return new Post();
}