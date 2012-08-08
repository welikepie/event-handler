<?php

function mergesort(&$array, $cmp_function = 'strcmp') { 
    // Arrays of size < 2 require no action. 
    if (count($array) < 2) return; 
    // Split the array in half 
    $halfway = count($array) / 2; 
    $array1 = array_slice($array, 0, $halfway); 
    $array2 = array_slice($array, $halfway); 
    // Recurse to sort the two halves 
    mergesort($array1, $cmp_function); 
    mergesort($array2, $cmp_function); 
    // If all of $array1 is <= all of $array2, just append them. 
    if (call_user_func($cmp_function, end($array1), $array2[0]) < 1) { 
        $array = array_merge($array1, $array2); 
        return; 
    } 
    // Merge the two sorted arrays into a single sorted array 
    $array = array(); 
    $ptr1 = $ptr2 = 0; 
    while ($ptr1 < count($array1) && $ptr2 < count($array2)) { 
        if (call_user_func($cmp_function, $array1[$ptr1], $array2[$ptr2]) < 1) { 
            $array[] = $array1[$ptr1++]; 
        } 
        else { 
            $array[] = $array2[$ptr2++]; 
        } 
    } 
    // Merge the remainder 
    while ($ptr1 < count($array1)) $array[] = $array1[$ptr1++]; 
    while ($ptr2 < count($array2)) $array[] = $array2[$ptr2++]; 
    return; 
}

function page_sort($pages, $func) {

	if (!is_array($func)) {
		$func = array($func);
	}

	$page_values = array_values($pages->_);
	foreach($func as &$ref) { mergesort($page_values, $ref); }
	
	$new_sorting = array();
	foreach($page_values as &$row) {
	
		foreach($pages as $key => $value) {
			if ($value === $row) {
				$new_sorting[$key] = $row;
				break;
			}
		}
	
	}
	
	$pages->_ = $new_sorting;

}

function date_sort ($a, $b) {

	if (is_object($a)) {
		$a_sort = $a->date();
		if ($a_sort) {
			$a_sort = intval((string) $a_sort, 10);
		} else {
			$a_sort = 0;
		}
	} else {
		$a_sort = 0;
	}
	
	if (is_object($b)) {
		$b_sort = $b->date();
		if ($b_sort) {
			$b_sort = intval((string) $b_sort, 10);
		} else {
			$b_sort = 0;
		}
	} else {
		$b_sort = 0;
	}
	
	    if ($a_sort < $b_sort) { return -1; }
	elseif ($a_sort > $b_sort) { return 1; }
	else { return 0; }

}

function priority_sort ($a, $b) {

	if (is_object($a)) {
		$a_sort = $a->priority();
		if ($a_sort) {
			$a_sort = intval((string) $a_sort, 10);
		} else {
			$a_sort = 0;
		}
	} else {
		$a_sort = 0;
	}
	
	if (is_object($b)) {
		$b_sort = $b->priority();
		if ($b_sort) {
			$b_sort = intval((string) $b_sort, 10);
		} else {
			$b_sort = 0;
		}
	} else {
		$b_sort = 0;
	}
	
	    if ($a_sort < $b_sort) { return 1; }
	elseif ($a_sort > $b_sort) { return -1; }
	else { return 0; }

}

?>