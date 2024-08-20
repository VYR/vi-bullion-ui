<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>VI Bullion | Admin</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/dist/css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/iCheck/square/blue.css">
 

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/error.js"></script>
 
<script type="text/javascript">		
	$(document).ready(function(){	
		$("#login_form").on("submit", function(e){
			e.preventDefault();	
			$.ajax({
				type: "post",
				url:"<?php echo base_url(); ?>admin/ajax_login",
				data:$("#login_form").serialize(),
				success:function(result)
				{		
					var jsondata=jQuery.parseJSON(result);	
					if(jsondata['status']==1)
					{
						showSuccessMessage("msg",jsondata['msg']);
						$("#login_form")[0].reset();
						setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/dashboard"; }, 1000);
					}
					else
					{
						showErrorMessage("msg",jsondata['msg']);	
					}
				}
			});	
		});	
	});
</script>
	<style>
		.err-msg
		{
			color:red;
			font-weight:bold;
		}
		.success-msg
		{
			color:green;
			font-weight:bold;
		}
	</style>
  </head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>VI Bullion</b> Admin</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" id="login_form" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Mobile Number/Email ID" required />
        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
		<div class="col-sm-12" id="msg"></div>
        <!-- /.col -->
      </div>
    </form>


  </div>
  
</div>


<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
