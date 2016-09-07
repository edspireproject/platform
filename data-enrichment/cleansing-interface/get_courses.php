<?php

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

$field = isset($_GET['field']) ? strval($_GET['field']) : '';
$s = isset($_GET['s']) ? strval($_GET['s']) : '';

include 'conn.php';

include 'classes.php';

$where = "";
if($field != '' && $s != '' ) {
	// find the field
	$ix = 0;
	foreach($f_courses as $f_course) {
		if($f_course == $field) {
			$where = " AND m" . $ix . ".meta_value = '" . $s . "' ";
		}
		$ix++;
	}
}

$rs = mysql_query("select count(*) from le_posts p " .
"inner join le_postmeta f on p.id = f.post_id and f.meta_key = 'wpcf-format' and f.meta_value = 'course' " .
"		where post_type = 'resource' " . $where );
$row = mysql_fetch_row($rs);
$result["total"] = $row[0];

$sql = "select p.id, p.post_title, p.post_name, p.post_content, ";

$ix = 0;
foreach($f_courses as $f_course) {
	$sql .= "m" . $ix . ".meta_value as " . $f_course . ", ";
	$ix++;
}
$sql .= "'' as dummy " .
	"from le_posts p " .
	"inner join le_postmeta f on p.id = f.post_id and f.meta_key = 'wpcf-format' and f.meta_value = 'course' ";
	
$ix = 0;
foreach($f_courses as $f_course) {
	$sql .= "left outer join le_postmeta m" . $ix . " on p.id = m" . $ix . ".post_id and m" . $ix . ".meta_key = 'wpcf-" . str_replace('_', '-', $f_course) . "' ";
	$ix++;
}
	
$sql .= "where p.post_type = 'resource' " .  $where .
	"order by p.id limit $offset,$rows";

$rs = mysql_query( $sql );

$items = array();
while($row = mysql_fetch_object($rs)){
	array_push($items, $row);
}
//$result["sql"] = $sql;
$result["rows"] = $items;
 
echo json_encode($result);
?>
