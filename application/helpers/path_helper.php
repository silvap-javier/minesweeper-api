<?php

if (!function_exists('asset_url')) {

    function asset_url() {
        $CI = & get_instance();
        return base_url() . $CI->config->item('asset_path');
    }

}

if (!function_exists('real_path_upload')) {

    function real_path_upload() {
        $CI = & get_instance();
        return $CI->config->item('real_path_upload');
    }
}

if (!function_exists('css_url')) {

    function css_url() {
        $CI = & get_instance();
        return base_url() . $CI->config->item('css_path');
    }

}
if (!function_exists('themes_url')) {

    function themes_url() {
        $CI = & get_instance();
        return base_url() . $CI->config->item('themes_path');
    }

}
if (!function_exists('js_url')) {

    function js_url() {
        $CI = & get_instance();
        return base_url() . $CI->config->item('js_path');
    }

}
if (!function_exists('img_url')) {

    function img_url() {
        $CI = & get_instance();
        return base_url() . $CI->config->item('img_path');
    }

}
if (!function_exists('plugins_url')) {

    function plugins_url() {
        $CI = & get_instance();
        return base_url() . $CI->config->item('plugins_path');
    }

}
?>
