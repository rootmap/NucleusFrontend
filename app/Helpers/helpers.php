<?php 

if (! function_exists('formatDate')) {
    function formatDate($date = '', $format = 'M/d/Y'){
        if($date == '' || $date == null)
            return;

        return date($format,strtotime($date));
    }
}

if (! function_exists('formatDateTime')) {
    function formatDateTime($date = '', $format = 'm/d/Y H:i:s'){
        if($date == '' || $date == null)
            return;

        return date($format,strtotime($date));
    }
}

if (! function_exists('db_esc_like_raw')) {
    /**
     * @param string $str
     * @return string
     */
    function db_esc_like_raw($str)
    {
        $ret = str_replace([ '%', '_' ], [ '\%', '\_' ], DB::getPdo()->quote($str));
        return $ret && strlen($ret) >= 2 ? substr($ret, 1, count($ret)-2) : $ret;
    }
}

set_time_limit(300);