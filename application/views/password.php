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

	<style>
		@font-face {
			font-family: 'Lobster';
			font-style: normal;
			font-weight: normal;
			src: local('Lobster'), url('http://themes.googleusercontent.com/static/fonts/lobster/v4/NIaFDq6p6eLpSvtV2DTNDQLUuEpTyoUstqEm5AMlJo4.woff') format('woff');
		}
		.success-status{
			font-family: 'Lobster';
			font-size:20px;
			line-height:20px;
			padding:20px;
		}
		#success_container{
			display:none;
		}
	</style>

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
		  
			<div id="success_container" class="col-md-6 col-md-offset-3  animated fadeInRightBig text-center">
				<img alt="VIP Brand" src="<?=base_url()?>includes/ngadmin/img/logo1.png" style="width:200px;height:65px;margin-top:10px;">
				<h3 class="success-status btn-warning">Your account has been activated.Thank You for using VIP App.</h3>
				
			</div>
			
			
			  <div id="password_container" class="col-md-6 col-md-offset-3  animated fadeInRightBig">
				  <div id="loginbox"  class="mainbox col-md-12">                    
					<div class="panel panel-warning" >
							<div class="panel-heading">
								<div class="panel-title">Password Creation</div>
								
							</div>     

							<div style="padding-top:30px" class="panel-body" >

								<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
									
								<form id="password_form" method="post" class="form-horizontal" role="form">
											
									
										
									<div style="margin-bottom: 25px;" class="input-group"  >
												<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
												<input type="email" class="form-control" value="<?=$email?>" placeholder="Email" disabled>                                        
												<input  type="hidden" class="form-control" name="email" value="<?=$email?>" >                                        
									</div>
									
									<div style="margin-bottom: 25px" class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
												<input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
									</div>
									
									<div style="margin-bottom: 25px" class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
												<input id="confirm_password" type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
									</div>
									
											
									<div id="messages" style="color:red;font-weight:bold;margin-bottom:10px;">
									
									</div


										<div style="margin-top:10px;padding:0;" class="form-group">
											<!-- Button -->

											<div class="col-sm-12 controls" style="padding:0;">
											  <input type="submit" id="btn-login" href="#" class="btn btn-warning" value="Submit" /> 
											  
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
	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) 
    <script src="<?=base_url()?>includes/js/jquery.min.js"></script> -->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	
    <!-- Latest compiled and minified JavaScript -->
    <script src="<?=base_url()?>includes/js/bootstrap.min.js"></script>
	<script>
		$(function(){
			
			$("#password_form").on("submit",userPwdCreation);
			
			
			
			
		});
		function userPwdCreation(e){
			e.preventDefault();
			$("#messages").text("");
			
			var email,pwd,c_pwd;
			email = $("#email").val();
			pwd = $("#password").val();
			c_pwd = $("#confirm_password").val();
			
			
			console.log(pwd.length+","+ c_pwd.length);
			if(pwd.length< 5)
			{
				$("#messages").text("Password length is low.");
			}
			else if((pwd.length == c_pwd.length) && (pwd == c_pwd)){
				    createPassword();  
					
				
			}else{
				$("#messages").text("Passwords mismatch.");
			}
			
			
			
		}
		
		function createPassword()
		{
			var form = $("#password_form").serialize();
			$.post('/mailer/reset_password',form,function(result){
				if(result.code == 200)
				{
					
					$("#password_container").hide();
					$("#success_container").show();
					
				}else{
					$("#messages").html(result.msg).show();
			
				}
			},'json');
		}
	</script>
  </body>
</html>