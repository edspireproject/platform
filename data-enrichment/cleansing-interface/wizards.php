<?php

include 'classes.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Courses</title>
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
		<b>Wizards</b> 
	</form>
	</div>

	<div id="edg">
	
	<table id="dg" title="Wizards" class="easyui-datagrid" style="width:1800px;height:880px" url="get_wizards.php"
			idField="id" toolbar="#toolbar" pagination="true" sortName="post_title" sortOrder="asc"
			rownumbers="true" fitColumns="true" singleSelect="true" pageSize="30" data-options="
                singleSelect: true,
                remoteSort:false,
                multiSort:true,
                pageList:[30,100,1000,10000]
            ">
		<thead>
			<tr>
			    <th field="id" sortable="true" width="15">ID</th>
				<th field="post_title" sortable="true" width="100">Title</th>
				<th field="provider_link" formatter="formatLink" width="10">Link</th>
				<th field="cost" width="20" sortable="true" editor="text" align="right">Cost</th>
				<th field="cost_cur" width="8" sortable="true" editor="text" align="right">Cur</th>
				<th field="cost_val" width="14" sortable="true" editor="text" align="right">Val</th>
				<th field="cost_sub" width="8" sortable="true" editor="text" align="right">Sub</th>
				<th field="post_content" width="100" editor="textarea">Content</th>
				<th field="availability" width="25" sortable="true" editor="text">Availability</th>
				<th field="schedule" width="8" sortable="true" editor="text" align="right">Sch</th>
				<th field="next_start" width="25" sortable="true" editor="text">Next</th>
				<th field="duration" width="25" sortable="true" editor="text">Duration</th>
				<th field="workload" editor="text" sortable="true" width="20">Workload</th>
				<th field="workload_min" editor="text" sortable="true" width="10">Min</th>
				<th field="workload_max" editor="text" sortable="true" width="10">Max</th>
				<th field="provider_difficulty" sortable="true" width="25" editor="text">P difficulty</th>
				<th field="teachers" editor="text" width="50">Teachers</th>
				<th field="subjects" editor="text" width="50">Subjects</th>
				<th field="university" editor="text" sortable="true" width="50">University</th>
				<th field="provider" width="30" sortable="true" editor="text">Provider</th>
				<th field="style" width="20" sortable="true" editor="text">Style</th>				
			</tr>
		</thead>
	</table>
	
	</div>
	
</body>
</html>
