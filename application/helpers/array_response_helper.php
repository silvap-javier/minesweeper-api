<?php
if (!function_exists('get_default_array_response_json')) {
    function get_default_array_response_json() {
    	$response = array();
    	$response['status'] = true;
    	$response['message'] = "";
    	$response['code'] = "";
    	$response['path'] = "";
    	$response['data'] = "";
    }
}