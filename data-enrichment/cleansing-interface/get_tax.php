<?php

$result = array();

include 'conn.php';

include 'classes.php';

$sql = "select t.term_id, t.name as term, count(p.id) as cnt from le_terms t inner join le_term_taxonomy y on t.term_id = y.term_id and y.taxonomy = 'post_tag' and t.term_group = 1 " .
		"left outer join le_term_relationships r on y.term_taxonomy_id = r.term_taxonomy_id left outer join " .
		"le_posts p on r.object_id = p.ID and p.post_type = 'resource' and p.post_status = 'publish' " .
		"group by t.name, t.term_id " .
		"union select 0 as term_id, '(none)' as term, count(*) as cnt from le_posts " .
		"where ID not in ( select tr.object_id from le_term_relationships tr inner join le_term_taxonomy tt on tr.term_taxonomy_id = tt.term_taxonomy_id where tt.taxonomy = 'post_tag') and post_status = 'publish' and post_type = 'resource' " .
		"order by term_id ";

$rs = mysql_query( $sql );

$items = array();
while($row = mysql_fetch_object($rs)){
	array_push($items, $row);
}
//$result["sql"] = $sql;
$result["rows"] = $items;
 
echo json_encode($result);
?>
