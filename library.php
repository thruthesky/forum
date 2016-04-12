<?php
if ( ! function_exists('segments') ) {
    /**
     * @param null $n
     * @return array|null
     */
    function segments($n = NULL) {
        $u = strtolower(site_url());
        $u = str_replace("http://", '', $u);
        $u = str_replace("https://", '', $u);
        $r = strtolower($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $uri = str_replace( "$u/", '', $r);
        $arr = explode('?', $uri);
        $re = [];
        if ( $arr ) {
            $re = explode('/', $arr[0]);
        }
        if ( $n !== NULL ) {
            if ( isset($re[$n]) ) return $re[$n];
            else return NULL;
        }
        else return $re;
    }
    function segment($n) {
        return segments($n);
    }
}

function sanitize_special_chars($filename) {
    $pi = pathinfo($filename);
    $sanitized = md5($pi['filename'] . ' ' . $_SERVER['REMOTE_ADDR'] . ' ' . time());
    if ( isset($pi['extension']) && $pi['extension'] ) return $sanitized . '.' . $pi['extension'];
    else return $sanitized;
}

function get_upload_error_message($code) {
    $errors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    return $errors[ $code ];
}