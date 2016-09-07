<?php
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$meta_key = isset($_POST['meta_key']) ? strval($_POST['meta_key']) : '';
$meta_value = isset($_POST['meta_value']) ? strval($_POST['meta_value']) : '';

include 'conn.php';

$json = array();

if( $post_id > 0 ) {

	$meta_key = mysql_real_escape_string( $meta_key, $conn );
	
	if( strpos( $meta_key, "-post-") ) {
		
		$field = substr( $meta_key, strpos( $meta_key, "-post-") + 6 );
		$sql = update_post($conn, $post_id, $field, $meta_value);
		
	} elseif( $meta_key == "wpcf-teachers") {
		
		$teacher = array();
		foreach(explode("\n", $meta_value) as $t) {
			$v = trim($t);
			if( $v != "")
				$teacher[] = $v;
		}
		
		$sql = update_meta_multi($conn, $post_id, 'wpcf-teacher', $teacher);
		
	} else {
	
		$sql = insert_or_update_meta($conn, $post_id, $meta_key, $meta_value);
		
	}

	$json["sql"] = $sql;
	
	$json["success"] = true; 
}
echo json_encode($json);

function update_post($conn, $post_id, $field, $value) {
	$value = mysql_real_escape_string( $value, $conn );
	
	$sql = "UPDATE ed_posts SET post_$field = '$value' WHERE ID = $post_id; ";
	$result = @mysql_query($sql);
	return $sql;
}

function insert_or_update_meta($conn, $post_id, $meta_key, $meta_value) {
	$meta_value = mysql_real_escape_string( $meta_value, $conn );
	
	$sql = "UPDATE ed_postmeta SET meta_value = '$meta_value' WHERE post_id = $post_id AND meta_key = '$meta_key';";
	$result = @mysql_query($sql);
	$rc = mysql_affected_rows($conn);
	if( $rc == 0 ) {
		$sql = "INSERT INTO ed_postmeta (post_id, meta_key, meta_value) VALUES ($post_id, '$meta_key', '$meta_value');";
		$result = @mysql_query($sql);
	}
	return $sql;
}

function update_meta_multi($conn, $post_id, $meta_key, $meta_values) {

	$log = array();
	$sql = "DELETE FROM ed_postmeta WHERE post_id = $post_id AND meta_key = '$meta_key';";
	$log[] = $sql;
	$result = @mysql_query($sql);
	
	foreach($meta_values as $meta_value) {
		$meta_value = mysql_real_escape_string( $meta_value, $conn );
		$sql = "INSERT INTO ed_postmeta (post_id, meta_key, meta_value) VALUES ($post_id, '$meta_key', '$meta_value');";
		$log[] = $sql;
		$result = @mysql_query($sql);
	}
	return $log;
}

?>