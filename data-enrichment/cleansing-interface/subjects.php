<?php

include 'classes.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Subjects</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/demo/demo.css">
	<script type="text/javascript" src="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="edit.js"></script>
	<style>
	.unchecked {
		color: #CCC;
		font-size: 1.6em;
		text-decoration: none;
	}
	.checked {
		color: #090;
		font-size: 1.6em;
		text-decoration: none;
	}
	.rotate {
		/* Safari */
		-webkit-transform: rotate(-90deg);
		/* Firefox */
		-moz-transform: rotate(-90deg);
		/* IE */
		-ms-transform: rotate(-90deg);
		/* Opera */
		-o-transform: rotate(-90deg);
		/* Internet Explorer */
		filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
	}
	</style>
</head>
<body>

	<div>
	<form>
		<b>Subjects</b>
	</form>
	</div>

	<div id="edg">
	
	<table id="dg" title="Subjects" class="easyui-datagrid" style="width:1800px;height:880px"
			url="get_subjects.php" idField="id"
			toolbar="#toolbar" pagination="true" sortName="post_title" sortOrder="asc"
			rownumbers="true" fitColumns="true" singleSelect="true" pageSize="30" data-options="
                singleSelect: true,
                remoteSort:false,
                multiSort:true,
                pageList:[30,100,1000,10000],
                onLoadSuccess:loadSuccess
            ">
		<thead>
			<tr>
				<th field="post_title" sortable="true" width="150">Title</th>
<?php
	$ix = 0;
	foreach($f_subjects as $f_subject) {
		echo '<th class="rotate" field="subject_' . $f_subject_tax[$ix] . '" width="10" formatter="formatTick">' . $f_subject . '</th>';
		echo "\n";
		$ix++;
	}
?>					
				<th field="provider" width="30" sortable="true" editor="text">Provider</th>
				<th field="post_format" width="15" sortable="true" editor="text">Format</th>
			</tr>
		</thead>
	</table>
	
	</div>
</body>
</html>
