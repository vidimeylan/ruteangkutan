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
		   	url: '<?php echo base_url().index_page();?>/type_angkutan/read',
		   	mtype:'POST',
			datatype: "json",
		   	colNames:['Id','Name','Jenis Tarif','Tarif'],
		   	colModel:[
		   		{name:'TP_ID',index:'TP_ID', width:55, editable:false, editoptions:{readonly:true}, sorttype:'int', hidden : true},
		   		{name:'TP_NAME',index:'TP_NAME', width:100,editable:true},
		   		{name:'TP_JENIS_TARIF',index:'TP_JENIS_TARIF', width:100,editable:true, hidden:true},
		   		{name:'TP_TARIF',index:'TP_TARIF', width:100,editable:true}
		   	],
		   	rowNum:10,
		   	rowList:[10,20,30],
		   	pager: '#pcrud',
		   	sortname: 'TP_NAME',
		   	rownumbers: true,
			rownumWidth: 40,
		    viewrecords: true,
		    sortorder: "asc",
		    editurl: '<?php echo base_url().index_page();?>/type_angkutan/action',
		    caption:"Type Angkutan"
		});

		// jQuery("#crud").editGridRow( "new", {closeAfterAdd: true,closeAfterEdit: true} );
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