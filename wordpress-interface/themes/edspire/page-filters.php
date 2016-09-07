<?php 

// generate counts for each of the filters that aren't set, return as JSON

$fields = array('subject','style','price','platform','availability','university','teacher','provider','echelon');

$qargs = array();

global $field_args, $field_meta_key;

foreach($fields as $field) :
	$qargs[$field] = sanitize_text_field( $_POST[$field_args[$field]] );
endforeach;

if($_POST['s-ft'])
	$qargs['freetext'] = sanitize_text_field( $_POST['s-ft'] );

$qargs['paged'] = 1;

$equery = ed_query( $qargs, 1000 );

$ids = '';

$cTotal = 0;
if ( $equery->have_posts() ) :
	while ( $equery->have_posts()) :
		$the_post = $equery->next_post();
		$ids .= ',' . $the_post->ID;
		$cTotal++;
	endwhile;
endif;

$filters = array();

$filters['total'] = $cTotal;

if($ids) {

	$ids = substr($ids, 1);
	
	foreach($fields as $field) :
		if(! $qargs[$field] ) {
			
			if($field == 'price')
				$filters[$field] = get_cost_filters($ids);
			elseif($field == 'availability')
				$filters[$field] = get_schedule_filters($ids);
			elseif($field == 'subject')
				$filters[$field] = get_tag_filters($ids);
			elseif($field == 'style')
				$filters[$field] = get_style_filters($ids);
			else
				$filters[$field] = get_search_filters($ids, $field_meta_key[$field]);
		}
	endforeach;
	
}

$filters["id"] = $ids;

echo json_encode( $filters );

function get_schedule_filters($ids) {
	global $availability_labels;
	$schedule_names = array_values($availability_labels);
	$sql = "SELECT 1 as id, '" . $schedule_names[0] . "' as meta_value, count(distinct post_id) as cnt FROM ed_postmeta WHERE post_id in (" . $ids . ") and meta_key = 'wpcf-schedule' and meta_value = 'a' ";
 	$sql .= "union SELECT 2 as id, '" . $schedule_names[1] . "' as meta_value, count(distinct s.post_id) as cnt FROM ed_postmeta s INNER JOIN ed_postmeta n on s.post_id = n.post_id AND s.meta_key = 'wpcf-schedule' and n.meta_key = 'wpcf-next-start' WHERE s.post_id in (" . $ids . ") and s.meta_value = 's' and n.meta_value > '" . date("Y-m-d", time() - (14*60*60*24)) . "' AND n.meta_value < '" . date("Y-m-d", time() + (60*60*24)) . "' ";
 	$sql .= "union SELECT 3 as id, '" . $schedule_names[2] . "' as meta_value, count(distinct s.post_id) as cnt FROM ed_postmeta s INNER JOIN ed_postmeta n on s.post_id = n.post_id AND s.meta_key = 'wpcf-schedule' and n.meta_key = 'wpcf-next-start' WHERE s.post_id in (" . $ids . ") and s.meta_value = 's' and n.meta_value > '" . date("Y-m-d", time() - (60*60*24)) . "' AND n.meta_value < '" . date("Y-m-d", time() + (14*60*60*24)) . "' ";
 	$sql .= "union SELECT 4 as id, '" . $schedule_names[3] . "' as meta_value, count(distinct s.post_id) as cnt FROM ed_postmeta s INNER JOIN ed_postmeta n on s.post_id = n.post_id AND s.meta_key = 'wpcf-schedule' and n.meta_key = 'wpcf-next-start' WHERE s.post_id in (" . $ids . ") and s.meta_value = 's' and n.meta_value > '" . date("Y-m-d", time() + (14*60*60*24)) . "' ";
 	$sql .= "union SELECT 5 as id, '" . $schedule_names[4] . "' as meta_value, count(distinct post_id) as cnt FROM ed_postmeta WHERE post_id in (" . $ids . ") and meta_key = 'wpcf-schedule' and meta_value = 'w' ";
 	
 	global $wpdb;
 	return $wpdb->get_results( $sql );
}

function get_cost_filters($ids) {
	global $price_labels;
	$cost_names = array_values($price_labels);
	$sql = "SELECT 1 as id, '" . $cost_names[0] . "' as meta_value, count(distinct post_id) as cnt FROM ed_postmeta WHERE post_id in (" . $ids . ") and meta_key = 'wpcf-cost-val' and CAST(meta_value AS decimal(10,2)) = 0 ";
	$sql .= "union SELECT 2 as id, '" . $cost_names[1] . "' as meta_value, count(distinct post_id) as cnt FROM ed_postmeta WHERE post_id in (" . $ids . ") and meta_key = 'wpcf-cost-val' and CAST(meta_value AS decimal(10,2)) BETWEEN 0.01 AND 50 ";
	$sql .= "union SELECT 3 as id, '" . $cost_names[2] . "' as meta_value, count(distinct post_id) as cnt FROM ed_postmeta WHERE post_id in (" . $ids . ") and meta_key = 'wpcf-cost-val' and CAST(meta_value AS decimal(10,2)) > 50 ";
	$sql .= "union SELECT 4 as id, '" . $cost_names[3] . "' as meta_value, count(distinct post_id) as cnt FROM ed_postmeta WHERE post_id in (" . $ids . ") and meta_key = 'wpcf-cost-sub' and meta_value = 'm' ";

	global $wpdb;
	return $wpdb->get_results( $sql );
}

function get_search_filters($ids, $wpcf) {

	global $wpdb;

	$sql = "SELECT meta_value, count(distinct post_id) as cnt FROM ed_postmeta where post_id in (" . $ids . ") and meta_key = 'wpcf-" . $wpcf . "' GROUP BY meta_value";
	return $wpdb->get_results( $sql );
}

function get_style_filters($ids, $wpcf) {

	global $wpdb, $style_singular;

	$sql = "SELECT meta_value as id, count(distinct post_id) as cnt FROM ed_postmeta where post_id in (" . $ids . ") and meta_key = 'edspire-style' GROUP BY meta_value";
	$res = $wpdb->get_results( $sql );
	foreach($res as $row) {
		$row->meta_value = $style_singular[$row->id];
	}
	return $res;
}


function get_tag_filters($ids) {

	global $wpdb;

	$sql = "SELECT t.slug as id, t.name as meta_value, count(distinct tr.object_id) as cnt FROM ed_term_taxonomy tt inner join ed_terms t on t.term_id = tt.term_id inner join ed_term_relationships tr on tt.term_taxonomy_id = tr.term_taxonomy_id where tr.object_id in (" . $ids . ") AND taxonomy = 'post_tag' GROUP BY t.name, t.slug";
	
	return $wpdb->get_results( $sql );
}

?>