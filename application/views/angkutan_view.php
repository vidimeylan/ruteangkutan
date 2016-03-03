<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Angkutan Umum</title>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.jqGrid.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/i18n/grid.locale-en.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/ajaxfileupload.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery-ui-1.8.11.custom.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/ui.jqgrid.css" type="text/css" /
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/ajaxfileupload.css" type="text/css" />
	<script>
	$(function() {
		var ang_type = <?php echo $ang_type;?>;
		var jalan = <?php echo $jalan;?>;
		var winWidth = $(window).innerWidth();
		var winHeight = $(window).innerHeight() - 120;
        jQuery("#crud").jqGrid({
        	height: winHeight,
			autowidth: true,
			multiselect:true,
		   	url: '<?php echo base_url().index_page();?>/angkutan/read',
		   	mtype:'POST',
			datatype: "json",
		   	colNames:['Id','Type','Name','Trayek','Image','Action'],
		   	colModel:[
		   		{name:'ANG_ID',index:'ANG_ID', width:55, editable:false, editoptions:{readonly:true}, sorttype:'int', hidden : true},
		   		{name:'ANG_TYPE',index:'TP_NAME', width:100,editable:true, edittype:'select',editoptions:{value:ang_type}},
		   		{name:'ANG_NAME',index:'ANG_NAME', width:100,editable:true},
		   		{name:'ANG_TRAYEK',index:'ANG_TRAYEK', width:100,editable:true},
		   		{name:'ANG_IMG',index:'ANG_IMG', width:100,editable:true,edittype: 'file',editoptions: {enctype: "multipart/form-data", autoComplete:false},search:false},
		   		{name:'ACTION',index:'ACTION',width:70,editable:false,align:'center'}
		   	],
		   	rowNum:10,
		   	rowList:[10,20,30],
		   	pager: '#pcrud',
		   	sortname: 'ANG_ID',
		   	rownumbers: true,
			rownumWidth: 40,
		    viewrecords: true,
		    sortorder: "asc",
		    editurl: '<?php echo base_url().index_page();?>/angkutan/action',
		    caption:"Angkutan"
		});

		
		var crud  = jQuery("#crud").jqGrid('navGrid','#pcrud',{edit:true,add:true,del:true,search:false},{afterSubmit:UploadImage,closeAfterEdit: true},{afterSubmit:UploadImage,closeAfterAdd: true});

		  // console.log(crud);
		jQuery("#crud").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});

		function UploadImage(response, postdata) {
		    var data = $.parseJSON(response.responseText);

		    if (data.success == true) {
		        if ($("#fileToUpload").val() != "") {
		            ajaxFileUpload(data.id);
		        }
		    }  

		    return [data.success, data.message, data.id];

		}

		function ajaxFileUpload(id) 
		{
		    $("#loading")
		    .ajaxStart(function () {
		        $(this).show();
		    })
		    .ajaxComplete(function () {
		        $(this).hide();
		    });

		    $.ajaxFileUpload
		    (
		        {
		            url: '<?php echo base_url().index_page();?>/angkutan/upload_image',
		            secureuri: false,
		            fileElementId: 'ANG_IMG',
		            dataType: 'json',
		            data:{'ANG_ID':id},
		            success: function (data, status) {

		                if (typeof (data.success) != 'undefined') {
		                    if (data.success == true) {
		                        return [true,""];
		                    } else {
		                        return [false,data.message];
		                    }
		                }
		                else {
		                    return [false,'Failed to upload logo!'];
		                }
		            },
		            error: function (data, status, e) {
		               return [false,'Failed to upload logo!'];
		            }
		        }
		    )          
		} 

		jQuery("#route-crud").jqGrid({
        	height: winHeight-120,
			width: winWidth-210,
			multiselect:true,
		   	mtype:'POST',
			datatype: "json",
		   	colNames:['Id','Jalan','Route Type','Order'],
		   	colModel:[
		   		{name:'RT_ID',index:'RT_ID', width:55, editable:false, editoptions:{readonly:true}, sorttype:'int', hidden : true},
		   		{name:'ROUTE',index:'JL_NAME', width:100,editable:true, edittype:'select',editoptions:{value:jalan}},		   		
		   		{name:'ROUTE_TYPE',index:'ROUTE_TYPE', width:40,editable:true, edittype:'select',editoptions:{value:{"F":"Forward","R":"Reverse"}}},
		   		{name:'ORDER',index:'ORDER', width:40,editable:true}
		   	],
		   	rowNum:10,
		   	rowList:[10,20,30],
		   	pager: '#route-pcrud',
		   	sortname: 'ORDER',
		   	rownumbers: true,
			rownumWidth: 40,
		    viewrecords: true,
		    sortorder: "asc",
		    editurl: '<?php echo base_url().index_page();?>/route/action',
		    caption:"Rute Angkutan"
		});

		$("#window-route").dialog({
			// title:'Route',
			autoOpen: false,
			height: winHeight,
			width: winWidth-200,
			modal: true,
			draggable:false,
			resizable:false
		});	

		
    });
    var idAngkutan = null;
    function show_route(id,name,trayek){
    	idAngkutan = id;
    	var winWidth = $(window).innerWidth();
		var winHeight = $(window).innerHeight() - 160;
		
		jQuery("#route-crud").jqGrid().setCaption("Rute angkutan "+name+" ("+trayek+")");
		jQuery("#route-crud").jqGrid().setGridParam({url:'<?php echo base_url().index_page();?>/route/read/'+id});
		jQuery("#route-crud").trigger("reloadGrid");
		jQuery("#route-crud").jqGrid().navGrid('#route-pcrud',{edit:true,add:true,del:true,search:false},{beforeSubmit:function(d){d.ANG_ID = idAngkutan;;return [true,d];},closeAfterEdit: true,width:370},{beforeSubmit:function(d){d.ANG_ID = idAngkutan;return [true,d];},closeAfterAdd: true});

		$("#window-route").dialog("open");

		$("#gview_route-crud > .ui-jqgrid-titlebar > a").unbind('click');
		$("#gview_route-crud > .ui-jqgrid-titlebar > a > span").css({"background-position":"-31px -192px"});
		$("#gview_route-crud > .ui-jqgrid-titlebar > a").click(function(){
			$("#window-route").dialog("close");
		});
		$(".ui-dialog-titlebar").hide();

	}
    
	</script>
</head>
<body>
	
	<div id="pcrud"></div>
	<div id="route-pcrud"></div>
  	<table id="crud" width="100%"></table>
  	<div id="window-route" style="padding:0 !important;">
  		<table id="route-crud" width="100%"></table>
  	</div>
</body>
</html>