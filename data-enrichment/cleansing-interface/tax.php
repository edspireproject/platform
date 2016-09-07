<?php

include 'conn.php';

include 'classes.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Taxonomies</title>
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/demo/demo.css">
	<script type="text/javascript" src="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://cdn.uriit.ru/jquery/jquery-easyui-1.4.1/jquery.easyui.min.js"></script>
	<script>

	</script>
</head>
<body>

  <div>
	<form>
		<b>Categories</b>
	</form>
  </div>

  <div id="edg">
	
	<table id="dg" title="Categories" class="easyui-datagrid" style="width:1800px;height:880px" url="get_tax.php"
			idField="id" toolbar="#toolbar" pagination="true" sortName="term" sortOrder="asc"
			rownumbers="true" fitColumns="true" singleSelect="true" pageSize="50" data-options="
                singleSelect: true,
                remoteSort:false,
                multiSort:true,
                pageList:[50,100,1000,10000]
            ">
		<thead>
			<tr>
			    <th field="id" sortable="true" width="15">ID</th>
				<th field="term" sortable="true" width="100">Term</th>
				<th field="cnt" sortable="true" width="30">Link</th>
			</tr>
		</thead>
	</table>
	
	</div>

</body>
</html>