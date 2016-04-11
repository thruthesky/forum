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
}

function post() {
    return new Post();
}