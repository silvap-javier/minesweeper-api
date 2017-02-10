<?php

if (!function_exists('create_matrix')) {
    function create_matrix($row,$col) {
    	if ($col == ''){
    		$col = 8;
    	}
    	if ($row == ''){
    		$row = 8;
    	}

    	$matrix = array();
	    for( $i=1; $i<=$row; $i++ ) {
	        $matrix[$i] = array();
	        for( $j=1; $j<=$col; $j++ ) {
	            $matrix[$i][$j] = array('value' => '0' , 'status' => 'closed' , 'row' => $i , 'col' => $j);
	        }
	    }
	   return $matrix; 
    }
}

if (!function_exists('create_mines')) {
    function create_mines($number_mines,$matrix) {
    	$count_mines = 0;
    	
    	if ($number_mines == ''){
    		$number_mines = 10;
    	}

    	while ($count_mines < $number_mines) {
	    	$row = array_rand($matrix); //here yoy get random first of array(green or red or yellow)
			if ($matrix[$row][array_rand($matrix[$row])]['value'] != 'M'){
				$matrix[$row][array_rand($matrix[$row])]['value'] = 'M';
				$count_mines++;
			} 
    	}
	   return $matrix; 
    }
}

if (!function_exists('create_number_block')) {
    function create_number_block($matrix,$row,$col) {
    	for ($r = 1; $r <= $row; $r++) { 
			for ($c = 1; $c <= $col; $c++) {
				for ($way_r = ($r-1); $way_r <= ($r+1); $way_r++){
					for ($way_c = ($c-1); $way_c <= ($c+1); $way_c++){
						if (($way_c > 0 && $way_r > 0) && ($way_c <= $col && $way_r <= $row)){
							if ($matrix[$way_r][$way_c]['value'] == 'M'){
								//var_dump('$matrix[$way_r][$way_c]');
								//var_dump($matrix[$way_r][$way_c]);
								if ($matrix[$r][$c]['value'] != 'M'){
									$matrix[$r][$c]['value'] = intval($matrix[$r][$c]['value'])+1;
								}
							}
						}
					}
				}
			}
    	}
	   return $matrix; 
    }
}