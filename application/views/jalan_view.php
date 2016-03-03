<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Angkutan Umum</title>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.jqGrid.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/i18n/grid.locale-en.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery-ui-1.8.11.custom.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/ui.jqgrid.css" type="text/css" />
	<script>
	$(function() {
		var winWidth = $(window).innerWidth();
		var winHeight = $(window).innerHeight() - 120;
        jQuery("#crud").jqGrid({
        	height: winHeight,
			autowidth: true,
			multiselect:true,
		   	url: '<?php echo base_url().index_page();?>/jalan/read',
		   	mtype:'POST',
			datatype: "json",
		   	colNames:['Id','Name'],
		   	colModel:[
		   		{name:'JL_ID',index:'JL_ID', width:55, editable:false, editoptions:{readonly:true}, sorttype:'int', hidden : true},
		   		{name:'JL_NAME',index:'JL_NAME', width:100,editable:true}
		   	],
		   	rowNum:10,
		   	rowList:[10,20,30],
		   	pager: '#pcrud',
		   	sortname: 'JL_NAME',
		   	rownumbers: true,
			rownumWidth: 40,
		    viewrecords: true,
		    sortorder: "asc",
		    editurl: '<?php echo base_url().index_page();?>/jalan/action',
		    caption:"Jalan"
		});

		jQuery("#crud").jqGrid('navGrid','#pcrud',{del:true,add:true,edit:true,search:false},{closeAfterEdit: true},{closeAfterAdd: true});
		jQuery("#crud").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
    });

    
	</script>
</head>
<body>
	<div id="pcrud"></div>
  	<table id="crud" width="100%"></table>
</body>
</html>