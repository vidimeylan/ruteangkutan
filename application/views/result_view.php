<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Angkutan Umum</title>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.autocomplete.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery-ui-1.8.11.custom.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery.autocomplete.css" type="text/css" />
	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }
	body {
		width:100%;
		margin:0px;
		overflow:hidden;
		font-family:"Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
    	font-size:12px;
	}

	h1{
		padding:0;
		margin:0;
	}

	.input_form{
		width:150px;
		border:1px solid #7C9D9D;
		-webkit-box-shadow: 
	      inset 0 0 8px  rgba(0,0,0,0.1),
	            0 0 16px rgba(0,0,0,0.1); 
	    -moz-box-shadow: 
	      inset 0 0 8px  rgba(0,0,0,0.1),
	            0 0 16px rgba(0,0,0,0.1); 
	    box-shadow: 
	      inset 0 0 8px  rgba(0,0,0,0.1),
	            0 0 16px rgba(0,0,0,0.1); 
	    
	}

	

	#login{
		top:0px;
		right:5px;
		position:absolute;
	}

	#login a{
		text-decoration:none;
		color:#000;
	}

	#login a:hover{
		font-weight:bold;
	}
	

	#main-layout {
		position: absolute; text-align: left; width: 100%; margin-top: 0px; z-index: 99; height: 60px;
	}

	#site-title {
		width: 180px; text-align: left; float: left; margin-left: 10px;
	}

	#site-form {
		width: 500px; text-align: center; float: left; margin: 5px 0px;
	}

	#result{
		width:100%;
		top: 62px;
		position:fixed;			
	}
	</style>
	<script>
	$(function() {
		// Auto complete
		// var searchLayout = $('#mainLayout');
		var animated = false;
		var src,dst;
		// console.log(.height());
		// searchLayout.css({"margin-top":(winHeight-(searchLayout.height()+40))/2+'px'});

		$( "#search_origin" ).autocomplete({
			source: jalan,
			click: function(){ },
			select: function(event,ui) { $("#start").val(ui.item.id);$('#search_origin').removeClass('defaul_tag'); src = ui.item.label; }
		});
		$('#search_origin').click(function() {
			src = $('#search_origin').val();
			$('#search_origin').removeClass('defaul_tag');
		   	$('#search_origin').val('');
		});

		$('#search_origin').blur(function() {
		   if(src == ''){
		   		$('#search_origin').addClass('defaul_tag');
		   		$('#search_origin').val('Dari ...');
		   }else{
		   		$('#search_origin').val(src);
		   }
		});

		$( "#search_destination" ).autocomplete({
			source: jalan,
			click: function(e,u){console.log(e); },
			select: function(event,ui) { $("#end").val(ui.item.id);$('#search_destination').removeClass('defaul_tag'); dst = ui.item.label;}
		});

		$('#search_destination').click(function() {
			dst = $('#search_destination').val();
			$('#search_destination').removeClass('defaul_tag');
		   	$('#search_destination').val('');
		});

		$('#search_destination').blur(function() {
		   if(dst == ''){
		   		$('#search_destination').addClass('defaul_tag');
		   		$('#search_destination').val('Tujuan ...');
		   }else{
		   		$('#search_destination').val(dst);
		   }
		});

		// End auto complete

		// Login form

		var name = $( "#txtUser" ),
			password = $( "#txtPass" ),
			allFields = $( [] ).add( name ).add( password ),
			tips = $( ".validateTips" );

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}

		function checkLength(o) {
			if ( o.val().length == 0 ) {
				o.addClass( "ui-state-error" );
				updateTips( "Field can't be empty .");
				return false;
			} else {
				return true;
			}
		}

		var formLogin = $("#login-form").dialog({
			title:'Login',
			autoOpen: false,
			height: 130,
			width: 200,
			modal: true,
			draggable:false,
			resizable:false,
			buttons: {
				Login: function() {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );

					bValid = bValid && checkLength( name);
					bValid = bValid && checkLength( password);
					if(bValid){
						$.ajax({
						  type: 'POST',
						  url: '<?php echo base_url().index_page();?>/login/do_login',
						  data: {'user':name.val(),'pass':password.val()},
						  success: function(d,r) {	
						  	$("#login-form").dialog("close");			    
						    var obj = jQuery.parseJSON(d);
						    if(obj.success == true){
						    	document.location.href = '<?php echo base_url().index_page();?>/admin';
						    }else{
						    	$('#login-info').html(obj.reason);
						    	$('#login-info').dialog({
						    		title:'Error',
						    		autoOpen:true,
							    	width:120,
							    	height: 80
							    });
						    }
						  }
						});
					}
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});	

		$("#login").click(function(e){ e.preventDefault();$("#login-form").dialog("open");});

		// End login form
	});
	var jalan = <?php echo $jalan;?>;
	</script>
</head>
<body>
<div id="login" style="z-index:100"><a href="#">Login</a></div>
<div id="login-form" style="display:none;">
	<table>
	<tr>
		<td>
			<label for="txtUser">Username</label>
			<input type="text" id="txtUser" class="text ui-widget-content ui-corner-all"/>
		</td>
	</tr>
	<tr>
		<td>
			<label for="txtPass">Password</label>
			<input type="password" id="txtPass" class="text ui-widget-content ui-corner-all"/>
		</td>
	</tr>
	</table>
</div>
<div id="main-layout">
	<div id="site-title" class="hastip"><h1>Cari Angkutan</h1></div>
	<form action="<?php echo base_url().index_page();?>/home/search" method="post">
	<div id="site-form">
	<input type="text" id="search_origin" name="org" value="<?php echo $org ?>" class="search"/>	
	<input id="start" type="hidden" name="start" value="<?php echo $start ?>"/>		
	<input type="text" id="search_destination" name="dest" value="<?php echo $dest ?>" class="search"/>
	<input id="end" type="hidden" name="end" value="<?php echo $end ?>"/>
	<input type="submit" id="search_submit" value="Go" style="height:28px;padding:0 3px;"/>
	</div>
	</form>
	<div style="width:100%;height:10px;background:#3F8FF2;margin:2px 0px;border-bottom:1px solid #E7590D;float:left;"></div>

</div>
<div id="result"><?php echo $result?></div>
</body>
</html>