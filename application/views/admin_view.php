<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Angkutan Umum</title>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.loadmask.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery-ui-1.8.11.custom.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/sidebar.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery.loadmask.css" type="text/css" />

	<script>
	$(function() {
		
		var winWidth = $(window).width();
		var winHeight = $(window).height();
		var topBar = 70;
		var page = winHeight-topBar-30;
		var sideBar = 228;

		var objMain = $('#main');
		function toggleSidebar(){
			if ( objMain.hasClass('use-sidebar') ){
	            objMain.removeClass('use-sidebar');
	            $('#separator').css('display','block');
	            $('#content-frame').css('width',(winWidth-30)+'px');
	        }
	        else {
	            objMain.addClass('use-sidebar');
	            $('#separator').css('display','none');	   
	            $('#content-frame').css('width',(winWidth-sideBar-10)+'px');         
	        }
		}
		$('#sidebar-toggle').click(function(el,o){
			toggleSidebar();
		});

		$('#separator').click(function(){
		    toggleSidebar();
		});

		function setDimension(){
			var winWidth = $(window).width();
			var winHeight = $(window).height();
			var topBar = 70;
			var page = winHeight-topBar-30;
			var sideBar = 228;
			$('#topbar').css({'height':topBar+'px'});
		    $('#sidebar').css({'width': sideBar+'px','height':page+'px'});
		    $('#content-frame').css({'width':(winWidth-sideBar-10)+'px','height':page+'px'});
		    $('#separator').css('height', page+'px');
		}
		
		setDimension();

		$(window).resize(function(){
			setDimension();
		}); 


	});
	function change_page(t,url){
		$("#content").mask("Opening page ... please wait ...");
		$('#content-frame').attr("src",url);
		$('#framepage-title').html(t);
		$('#content-frame').load(function() {
	        $("#content").unmask();
	    });
	}
    
	</script>
</head>
<body>
<div id="topbar">
	<div id="header"><div>
	<h1 class="site_title">
		<img id="site_logo" src="".KCT_APP_IMG_URL."logo.png" />
	</h1>
	<h2 class="section_title">Admin Panel</h2>
	</div></div>
	<div id="secondary_bar"><div class="user"><p><?php echo $this->session->userdata('NAME');?></p>
	<a class="logout_user" href="<?php echo base_url().index_page();?>/login/do_logout" title="Logout" >Logout</a>
	</div>
	<div id="breadcrumbs_container" class="breadcrumbs_container">
		<div class="breadcrumbs">
			<a id="framepage-parenttitle" href="#">Admin</a>
			<div class="breadcrumb_divider"></div>
			<a id="framepage-title" class="current" href="#">Welcome</a>
		</div>
	</div>
</div>
<div class="use-sidebar sidebar-at-left" id="main">
    <div id="content">
    	<iframe frameborder="0" id="content-frame" name="framepage" class=" ux-mif" style="overflow: auto; height: 342px;" src="<?php echo base_url().index_page();?>/admin/welcome">
    	</iframe>
    </div>
    <div id="sidebar">
    <div id="sidebar-header"><div id="sidebar-title">Menu</div><div id="sidebar-toggle"></div></div>
    <div id="sidebar-content">
    	<ul>
    		<li class="icn_menu">
    			<a title="List user" onclick="change_page('User','<?php echo base_url().index_page();?>/user');" href="#">User</a>
    		</li>
    		<li class="icn_menu">
    			<a title="Referensi Type Angkutan" onclick="change_page('Type Angkutan','<?php echo base_url().index_page();?>/type_angkutan');" href="#">Type Angkutan</a>
    		</li>
    		<li class="icn_menu">
    			<a title="List of angkutan" onclick="change_page('Angkutan','<?php echo base_url().index_page();?>/angkutan');" href="#">Angkutan</a>
    		</li>
    		<li class="icn_menu">
    			<a title="List of Jalan" onclick="change_page('Jalan','<?php echo base_url().index_page();?>/jalan');" href="#">Jalan</a>
    		</li>
    	</ul>
    </div>
    </div>
    <div id="separator" class="hide"><div id="sidebar-collapse"></div></div>
    <div class="clearer">&nbsp;</div>
</div>
</body>
</html>