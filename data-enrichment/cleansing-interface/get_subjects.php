<?php

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

include 'conn.php';

include 'classes.php';

$rs = mysql_query("select count(*) from le_posts p " .
		"inner join le_postmeta f on p.id = f.post_id and f.meta_key = 'wpcf-format' " .
		"		where post_type = 'resource'");

$row = mysql_fetch_row($rs);
$result["total"] = $row[0];

$sql = "select p.id, p.post_title, p.post_name, f.meta_value as post_format, d.meta_value as provider, ";

$ix = 0;
foreach($f_subjects as $f_subject) {
	$sql .= "CASE WHEN tr" . $ix . ".object_id IS NULL THEN -" . $f_subject_tax[$ix] . " ELSE " . $f_subject_tax[$ix] . " END as subject_" . $f_subject_tax[$ix] . ", ";
	$ix++;
}

$sql .= "'' as dummy " .
		"from le_posts p " .
		"inner join le_postmeta f on p.id = f.post_id and f.meta_key = 'wpcf-format' " .
		"left outer join le_postmeta d on p.id = d.post_id and d.meta_key = 'wpcf-provider' ";

$ix = 0;
foreach($f_subjects as $f_subject) {
	$sql .= "left outer join le_term_relationships tr" . $ix . " on p.id = tr" . $ix . ".object_id and tr" . $ix . ".term_taxonomy_id = " . $f_subject_tax[$ix] . " ";
	$ix++;
}

$sql .= "where p.post_type = 'resource' " .
		"order by p.id limit $offset,$rows";

$rs = mysql_query( $sql );

$items = array();
while($row = mysql_fetch_object($rs)){
	array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);
?>