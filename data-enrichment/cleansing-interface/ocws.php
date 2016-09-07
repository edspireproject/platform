<?php

include 'classes.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>OpenCourseWare</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/demo/demo.css">
	<script type="text/javascript" src="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="edit.js"></script>
</head>
<body>

	<div>
	<form>
		<b>OpenCourseWare</b> Filter by title <input type="text" name="post_title"/> and <select id="field" name="field">
<?php
	foreach($f_ocws as $f_ocw) {
		echo "<option>" . $f_ocw . "</option>";
	}
?>	
		</select><input type="text" id="custom" name="custom"/> <input type="submit" id="filter" value="Filter"/>
	</form>
	</div>

	<div id="edg">
	
	<table id="dg" title="OpenCourseWare" class="easyui-datagrid" style="width:1800px;height:880px" url="get_ocws.php"
			idField="id" toolbar="#toolbar" pagination="true" sortName="post_title" sortOrder="asc"
			rownumbers="true" fitColumns="true" singleSelect="true" pageSize="30" data-options="
                singleSelect: true,
                onClickRow: onClickRow,
                onAfterEdit: onAfterEdit,
                remoteSort:false,
                multiSort:true,
                pageList:[30,100,1000,10000]
            ">
		<thead>
			<tr>
			    <th field="id" sortable="true" width="15">ID</th>
				<th field="post_title" sortable="true" width="100">Title</th>
				<th field="post_name" formatter="formatEdspireLink" width="10">edspire</th>
				<th field="provider_link" formatter="formatLink" width="10">Link</th>
				<th field="post_content" width="100" editor="textarea">Content</th>
				<th field="availability" width="25" sortable="true" editor="text">Availability</th>
				<th field="teachers" editor="text" width="50">Teachers</th>
				<th field="subjects" editor="text" width="50">Subjects</th>
				<th field="provider" width="30" sortable="true" editor="text">Provider</th>
			</tr>
		</thead>
	</table>
	
	</div>

</body>
</html>
