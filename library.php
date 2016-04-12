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
