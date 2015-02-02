<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VIP Admin</title>

    <!-- Bootstrap -->
    
		<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

	<link rel="stylesheet" href="<?=base_url()?>includes/css/media_query.css">
	<link href="<?=base_url()?>includes/css/animate.css" rel="stylesheet">

	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">



    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      
  </head>
  <body>
    <div id="wrap">
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="#">
				<img alt="VIP Brand" src="<?=base_url()?>includes/ngadmin/img/logo1.png" style="width:120px;height:40px;margin-top:-9px;">
			  </a>
			</div>
		  </div>
		</nav>
		<div class="container" >
		    
		  <div class="row">
			<div class="col-md-3 col-xs-3 animated fadeInLeftBig" id="slider_main" >
					<div class="slider_container">

						<div id="vip_slider" class="carousel slide" data-ride="carousel">
						  <!-- Indicators -->
		<!--
						  <ol class="carousel-indicators">
							<li data-target="#vip_slider" data-slide-to="0" class="active"></li>
							<li data-target="#vip_slider" data-slide-to="1"></li>
							<li data-target="#vip_slider" data-slide-to="2"></li>
							<li data-target="#vip_slider" data-slide-to="3"></li>
							<li data-target="#vip_slider" data-slide-to="4"></li>
							<li data-target="#vip_slider" data-slide-to="5"></li>
						  </ol>
		-->

						  <!-- Wrapper for slides -->
						  <div class="carousel-inner" role="listbox">
							<div class="item active">
							  <img src="<?=base_url()?>includes/images/slides/slider_1.png" alt="VIP Slider"  />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_2.png" alt="VIP Slider"  />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_3.png" alt="VIP Slider" />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_4.png" alt="VIP Slider" />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_5.png" alt="VIP Slider" />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_6.png" alt="VIP Slider" />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_7.png" alt="VIP Slider" />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_8.png" alt="VIP Slider" />

							</div>
							<div class="item">
							  <img src="<?=base_url()?>includes/images/slides/slider_9.png" alt="VIP Slider" />

							</div>

						 </div>
						</div>
						

					</div>
					
			  
			</div>
			<div class="col-md-5 col-xs-4 animated fadeInUpBig" id="slider_des">
				<div class="phone-description">
						
							<label class="title-widget-sidebar">VIP Admin Portal</label>
							<p><strong>
							If you need a new rewards app or want to add gamification to your existing customer rewards program email
							<a shape="rect" target="_blank" href="mailto:cross@gocross.com">cross@gocross.com</a>
							for help.
							</strong>
							<br>
							We can also help design, build, enhance, build incentives (gamification) and maintain/support the rewards program for iOS (iPhone/iPad/iWatch), Android, Windows and PC/MAC platforms.
							</p>
							<p>We can also design and build other app for other business and consumer uses. Inquire for examples.</p>
							<p>Customized Scoreboards based on industry, sport or event.</p>
				 </div>
			</div>
			  <div class="col-md-4 col-xs-12 col-sm-5 login-container animated fadeInRightBig">
				  <div id="loginbox"  class="mainbox col-md-12">                    
					<div class="panel panel-info" >
							<div class="panel-heading">
								<div class="panel-title">Sign In</div>
								<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
							</div>     

							<div style="padding-top:30px" class="panel-body" >

								<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
									
								<form id="loginform" method="post" class="form-horizontal" role="form">
											
									<div style="margin-bottom: 25px" class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
												<input id="login-username" type="email" class="form-control" name="email" value="" placeholder="Email" required>                                        
											</div>
										
									<div style="margin-bottom: 25px" class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
												<input id="login-password" type="password" class="form-control" name="password" placeholder="Password" required>
											</div>
											
									<div id="messages" style="color:red;font-weight:bold">
									
									</div>
								
									<div class="input-group">
											  <div class="checkbox">
												<label>
												  <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
												</label>
											  </div>
											</div>


										<div style="margin-top:10px" class="form-group">
											<!-- Button -->

											<div class="col-sm-12 controls">
											  <input type="submit" id="btn-login" href="#" class="btn btn-warning" value="Login" /> 
											  
											</div>
										</div>


											
									</form>     



								</div>                     
							</div>  
				</div> 

		  
		  </div>
		  
		  
		</div>
			
		
		</div>
		<div id="push"></div>
	</div>
	<div id="footer">
		<div class="container">
			
					<p style="display:inline-block">Copyright &copy; 2015   VIP</p>
				
				
					<p class="pull-right" style="display:inline-block">
						<!--<a href="#">HOME</a>
						<a href="#">ABOUT US</a>
						<a href="#">CONTACT US</a> -->
						Current Version 1.0
					</p>
				
		</div>
	</div>
	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>includes/js/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?=base_url()?>includes/js/bootstrap.min.js"></script>
	<script>
		$(function(){
			$("#loginform").on("submit",userLogin);
			
			setTimeout(function(){
				// doc ready when slide the next slide
				$('.carousel').carousel('next');
			},800);
			
		});
		function userLogin(e){
			e.preventDefault();
			var form = $("#loginform").serialize();
			//alert(form);
			$.post('admin/portal_signin',form,function(result){
				if(result.msg == 200)
				{
					//alert(JSON.stringify(result));
					$("#loginform #messages").hide();
					location.reload();
					//alert(result.user);
				}else{
					$("#loginform #messages").html(result.msg).show();
			
				}
			},'json');
			
		}
	</script>
  </body>
</html>