<?php

if (!function_exists('create_matrix')) {
    function create_matrix($col,$row) {
    	if ($col == ''){
    		$col = 8;
    	}
    	if ($row == ''){
    		$row = 8;
    	}

    	$matrix = array();
	    for( $i=1; $i<=$col; $i++ ) {
	        $matrix[$i] = array();
	        for( $j=1; $j<=$row; $j++ ) {
	            $matrix[$i][$j] = '';
	        }
	    }
	   return $matrix; 
    }
}

if (!function_exists('create_mines')) {
    function create_mines($number_mines,$matrix) {
    	
    	if ($number_mines == ''){
    		$number_mines = 10;
    	}

    	$matrix = array();
	    
	    for( $i=1; $i<=$col; $i++ ) {
	        $matrix[$i] = array();
	        for( $j=1; $j<=$row; $j++ ) {
	            $matrix[$i][$j] = '';
	        }
	    }

	   return $matrix; 
    }
}