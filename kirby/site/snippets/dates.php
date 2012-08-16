<?php

/**
 * This function can be used to parse the dates specified in the event page
 * into a managable format. Given a $page argument (and optionally a list of
 * templates to use for generating text version of dates and times), it
 * queries "Date" and "End_Date" properties and returns an array of dates,
 * times and timestamps, based on what fields are available in the page and
 * whether it's just the date or date with time specified.
 */
function dates($page, $templates = NULL) {

	// Provide default templates if none were specified.
	if (!$templates) {
		$templates = array(
			'date' => 'jS F Y',
			'time' => 'H:i',
			'datetime' => 'jS F Y (H:i)'
		);
	}
	
	$dates = array();
	
	// Parse both fields with one bit of code, to save some space
	foreach(array('start' => 'date', 'end' => 'end_date') as $key => $field) {
	
		// Note how we're checking the fields raw, without any possible
		// processing (that's to avoid any additional Kirby functionality, such
		// as automatic date processing on "Date" fields).
		if (isset($page->_[$field])) {
		
			$matches = array();
			
			// Attempt to match the field on date & time format (YYYY-MM-DD HH:MM)
			if (preg_match('/^\s*([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2})\s*$/', $page->_[$field], $matches)) {
			
				$temp = mktime(
					intval($matches[4], 10),
					intval($matches[5], 10),
					0,
					intval($matches[2], 10),
					intval($matches[3], 10),
					intval($matches[1], 10)
				);
				$dates[$key] = array(
					'date' => date($templates['date'], $temp),
					'time' => date($templates['time'], $temp),
					'datetime' => date($templates['datetime'], $temp),
					'timestamp' => $temp
				);
			
			// Attempt to match the field on date only format (YYYY-MM-DD)
			} elseif (preg_match('/^([0-9]{4})-([0-3][0-9])-([0-3][0-9])$/', $page->_[$field], $matches)) {
			
				$temp = mktime(
					0,
					0,
					0,
					intval($matches[2], 10),
					intval($matches[3], 10),
					intval($matches[1], 10)
				);
				$dates[$key] = array(
					'date' => date($templates['date'], $temp),
					'time' => NULL,
					'datetime' => NULL,
					'timestamp' => $temp
				);
			
			// If no match found, consider date malformed
			} else {
				$dates[$key] = NULL;
			}
		
		// If field not found, just put a NULL to indicate it
		} else {
			$dates[$key] = NULL;
		}
	
	}
	
	return $dates;

}

/**
 * This function is a shorthand for generating date range strings.
 * Appropriately to data available in event page, it will generate
 * different date string for when only starting date is specified,
 * the ending date is different or only the starting and ending
 * times are differing.
 */
function daterange($page, $templates = NULL) {

	$dates = dates($page, $templates);
	$result = '';
	
	// Process for both dates
	if ($dates['start'] and $dates['end']) {
	
		$both_times = ($dates['start']['time'] and $dates['end']['time']);
		
		// Different dates
		if ($dates['start']['date'] !== $dates['end']['date']) {
		
			if ($both_times) {
				$result = sprintf(
					'%s (%s) - %s (%s)',
					$dates['start']['date'],
					$dates['start']['time'],
					$dates['end']['date'],
					$dates['end']['time']
				);
			} else {
				$result = sprintf(
					'%s - %s',
					$dates['start']['date'],
					$dates['end']['date']
				);
			}
		
		// Same dates, different times
		} elseif ($both_times and ($dates['start']['time'] !== $dates['end']['time'])) {
		
			$result = sprintf(
				'%s (%s - %s)',
				$dates['start']['date'],
				$dates['start']['time'],
				$dates['end']['time']
			);
		
		// Same time, single print
		} else {
		
			if ($dates['start']['time']) {
				$result = sprintf(
					'%s (%s)',
					$dates['start']['date'],
					$dates['start']['time']
				);
			} else {
				$result = $dates['start']['date'];
			}
		
		}
	
	// Process for starting date only
	} elseif ($dates['start']) {
	
		if ($dates['start']['time']) {
			$result = sprintf(
				'%s (%s)',
				$dates['start']['date'],
				$dates['start']['time']
			);
		} else {
			$result = $dates['start']['date'];
		}
	
	}
	
	return $result;

}

?>