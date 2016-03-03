<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Pencarian Rute Angkutan Umum Jakarta</title>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/jquery.loadmask.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/assets/js/tooltipsy.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery-ui-1.8.11.custom.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery.autocomplete.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/jquery.loadmask.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url();?>application/assets/css/home.css" type="text/css" />
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
	
	#container_main{
		position:fixed;
		z-index:100;
	}

	#container{
		width:600px;
		height: 200px;
		margin: 0 auto;
		z-index:99;
	}

	.ui-menu{
		max-height:200px;
		overflow-y:scroll;
	}

	.trayek{
		font-weight:bold;
	}

	.no_urut{
		width:30px;		
	}
	.nama_angkutan{
		z-index: 10000;
		height: 30px;
		/*color:#3510EF;*/
		/*background:#fff;*/
		background: url("http://localhost/ruteangkutan/application/assets/images/double_arrow.jpg") no-repeat scroll right center transparent;
		padding:5px;
		border-bottom: 1px dashed #000;
	}

	.nama_angkutan:hover{
		z-index:99;
		background: none;
		background-color:#515258;
		color:#fff;
		border:1px solid #E7590D;
		border-right:1px solid #515258;
	}

	.naik{
		padding:5px;
		background:#EEB98E;
	}
	.turun{
		padding:5px;
		background:#EF9595;
	}

	.tip-content{
		font-size:11px;
	}

    .tip-image{
    	text-align:center;
    	padding:5px;    	
    }

    .tip-image img{
    	width:100px;
    }
    .tip-title{
    	font-weight:bold;
    	text-align:center;
    	padding:3px 5px;
    }
    .tip-item{
    	padding:3px 5px;
    }

    .trayek-group{
    	width:100%;
    }
    /*.double_arrow{
    	height:20px;
    	width:20px;
    	float:right;
    	right:5px;
    	background: url('http://localhost/ruteangkutan/application/assets/images/double_arrow.jpg') no-repeat;
    }*/
	</style>
	<script>
	$(function() {
		var winWidth = $(window).width();
		var winHeight = $(window).height();

		// Auto complete
		var searchLayout = $('#mainLayout');
		var animated = false;
		var src,dst;
		// console.log(.height());
		searchLayout.css({"margin-top":(winHeight-(searchLayout.height()+40))/2+'px'});

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

		var tooltipParam = {
			offset: [1, 1],
			content: function ($el, $tip) {
		        $.get('<?php echo base_url().index_page();?>/home/angkutan_tip/'+$el.attr('idAngkutan'), function (data) {
		            $tip.html(data);
		        });
		        return 'Fallback content';
		    },
		    show: function (e, $el) {
		        $el.css({
		        	'top': parseInt($el[0].style.top.replace(/[a-z]/g, '')) - 31 + 'px',
		            'left': parseInt($el[0].style.left.replace(/[a-z]/g, '')) - 2 + 'px',
		            'opacity': '1.0',
		            'display': 'block',
		            'z-index': '2'
		        });
		    },
		    hide: function (e, $el) {
		    	$el.css({
		    		'top': parseInt($el[0].style.top.replace(/[a-z]/g, '')) - 31 + 'px',
		            'left': parseInt($el[0].style.left.replace(/[a-z]/g, '')) - 2 + 'px',
		            'opacity': '0.0',
		            'display': 'none',
		            'z-index': '-1'
		        });
		        // $el.slideUp(1000);
		    },
		    css: {		    	
		        'padding': '10px',
		        'color': '#FFF',
		        // 'opacity': '0.9',
		        'background-color': '#515258',
		        'border': '1px solid #E7590D',	
		        'border-left': 'none',	        
		        // '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
		        // '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
		        // 'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
		        '-moz-border-radius':'0 5px 5px 5px',
		        'text-shadow': 'none'
		    }
		};
		
		$('#search_submit').click(function(){
			var start = $('#start').val();
			var end = $('#end').val();
			if(animated){
				$("#result").mask("Loading...");
  				$('#result').load("<?php echo base_url().index_page();?>/home/search",{'start':start,'end':end},function(r,s){
			  		$('#result').unmask();
			  		$('.nama_angkutan').tooltipsy(tooltipParam);			  		
				});	
			}else{
				$('#site-title').animate({"width":"20%"},500,function(){	
					$('#site-title').css({"text-align":"left","margin-left":"10px","width":"180px"});			
					$('#site-form').animate({"width":"500px"},500,function(){
						// $('#best-view').css({"bottom":"15px","right":"0","position":"absolute"});	
							$('#mainLayout').animate({"height":60,"margin-top":"0px"},500, function(){
								$('#result').animate({"top":62,"overflow-y":"scroll"},10,function(){
									$("#result").mask("Loading...");
					  				$('#result').load("<?php echo base_url().index_page();?>/home/search",{'start':start,'end':end},				function(r,s){
								  		$('#result').unmask();
								  		$('.nama_angkutan').tooltipsy(tooltipParam);
								  		animated = true;
									});	
					  			});
							});
					});
				});
			}
				
		});		
		
		// Login

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
				"Login": function() {
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

		// End login

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
<div id="login-info"></div>
<div id="mainLayout" style="position:absolute;text-align:left;width:100%;margin-top:200px;z-index:99">
	<div id="site-title" style="width:100%;text-align:center;float:left;" class="hastip"><h1>Cari Angkutan</h1></div>
	<!-- <form action="<?php echo base_url().index_page();?>/home/search" method="post"> -->
	<div id="site-form" style="width:100%;text-align:center;float:left;margin:5px 0;">
	<input type="text" id="search_origin" name="org" value="Dari ..." class="search"/>	
	<input id="start" type="hidden" name="start" value=""/>		
	<input type="text" id="search_destination" name="dest" value="Tujuan ..." class="search"/>
	<input id="end" type="hidden" name="end" value=""/>
	<input type="submit" id="search_submit" value="Go" style="height:28px;padding:0 3px;"/>
	</div>
	<!-- </form> -->
	<div style="width:100%;height:10px;background:#3F8FF2;margin:2px 0px;border-bottom:1px solid #E7590D;float:left;"></div>
    <span id="best-view" style="float:right;margin:5px 10px;"><b>Best viewed using Mozilla Firefox</b></span> 
</div>
<div id="result"></div>
</body>
</html>