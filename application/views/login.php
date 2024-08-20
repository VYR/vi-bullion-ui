
<div class="container py-5" style="min-height:500px;">
<div class="row">
<div class="col-md-4 mx-auto">
<form action="" id="login_form" method="post">
<div class="card shadow bg-white px-3 pt-3">
<h1 class="text-center color1 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
<div class="form-group">
	<label for="name">Unique Code<span class="text-danger">*</span></label>
	<input type="text" class="form-control" id="username" name="username" placeholder="Enter Unique Code" required>
</div>
<div class="form-group">
	<label for="cat_slno" class="control-label">Password <span class="text-danger">*</span></label>
	<input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
</div>
<div id="otp_div" class="form-group" style="display:none;">
	<label for="cat_slno" class="control-label">OTP <span class="text-danger">*</span></label>
	<input type="hidden" id="otp_status" value="0">
	<input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP">
</div>
<div class="text-center form-group">
<button type="submit" id="submit_id" class="btn btn-success">Submit</button>
<div id="msg"></div>
</div>
</div>
</form>
</div>
</div>
<div class="pt-3 login-text">
<?php echo $record['description']; ?>
</div>
</div>

<script type="text/javascript">		
	$(document).ready(function(){	
		$("#login_form").on("submit", function(e){
			e.preventDefault();	
			$("#login_form #submit_id").attr('disabled',true);
			$("#login_form #submit_id").text('Please Wait...');
			var otp_status=$("#otp_status").val();
			if(otp_status=='0'){
				$.ajax({
					type: "post",
					url:"<?php echo base_url(); ?>login_ajax",
					data:$("#login_form").serialize(),
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							showSuccessMessage("msg",jsondata['msg']);
							$("#otp").attr('required','required');
							$("#otp_status").val('1');
							$("#otp_div").show();
						}
						else
						{
							showErrorMessage("msg",jsondata['msg']);	
						}
						$("#login_form #submit_id").attr('disabled',false);
						$("#login_form #submit_id").text('Submit');
					}
				});	
			}else{
				$.ajax({
					type: "post",
					url:"<?php echo base_url(); ?>login_otp_ajax",
					data:$("#login_form").serialize(),
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							showSuccessMessage("msg",jsondata['msg']);
							$("#login_form")[0].reset();
							<?php if(!empty($this->session->userdata('page_url'))){ ?>
							setTimeout(function(){ window.location = "<?php echo $this->session->userdata('page_url'); ?>"; }, 1000);
							<?php }else{ ?>
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>profile"; }, 1000);
							<?php } ?>
						}
						else
						{
							showErrorMessage("msg",jsondata['msg']);	
						}
						$("#login_form #submit_id").attr('disabled',false);
						$("#login_form #submit_id").text('Submit');
					}
				});	
			}
		});	
	});
</script>