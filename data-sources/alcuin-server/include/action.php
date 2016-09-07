<?php 

/**
 * Workflow of Actions
 */

global $ARR_ACTIONS;
$ARR_ACTIONS = array("crawl", "screenshot");

function parse_actions($unsanitized) {
	global $ARR_ACTIONS;
	$actions = array();
	foreach(explode(',', $unsanitized) as $us) {
		if(in_array($us, $ARR_ACTIONS))
			$actions[] = $us;
	}
	return $actions;
}