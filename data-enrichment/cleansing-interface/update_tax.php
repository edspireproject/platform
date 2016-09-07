<?php
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$term_id = isset($_GET['term_id']) ? intval($_GET['term_id']) : 0;

include 'conn.php';

$json = array();

if( $post_id > 0 && $term_id <> 0 ) {

	if( $term_id < 0 ) {
		
		$sql = "insert ignore into ed_term_relationships (object_id, term_taxonomy_id) select " . $post_id . ", " . (0 - $term_id) . ";"; 
		
	} else {
		
		$sql = "delete from ed_term_relationships where object_id = " . $post_id . " and term_taxonomy_id = " . (0 - $term_id) . ";";
		
	}
	
	$result = @mysql_query($sql);
	
	// $json["sql"] = $sql;
	$json["success"] = true;
}
echo json_encode($json);
?>