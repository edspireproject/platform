<?php
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$slug = isset($_POST['slug']) ? strval($_POST['slug']) : '';
$todo = isset($_POST['todo']) ? strval($_POST['todo']) : '';


include 'conn.php';

$json = array();

$rs = mysql_query("SELECT t.term_taxonomy_id FROM ed_term_taxonomy t inner join ed_terms m on t.term_id = m.term_id and t.taxonomy = 'post_tag' where m.slug = '" . $slug . "'");

$row = mysql_fetch_row($rs);
$term_id = intval($row[0]);

$json["post_id"] = $post_id;
$json["row"] = $row;
$json["term_id"] = $term_id;
$json["slug"] = $slug;

if($todo == 'remove')
	$term_id = 0 - $term_id;

if( $post_id > 0 && $term_id <> 0 ) {

	if( $term_id > 0 ) {
		
		$sql = "insert ignore into ed_term_relationships (object_id, term_taxonomy_id) select " . $post_id . ", " . $term_id . ";"; 
		
	} else {
		
		$sql = "delete from ed_term_relationships where object_id = " . $post_id . " and term_taxonomy_id = " . (0 - $term_id) . ";";
		
	}
	
	$result = @mysql_query($sql);
	
	$json["sql"] = $sql;
	$json["success"] = true;
}
echo json_encode($json);
?>