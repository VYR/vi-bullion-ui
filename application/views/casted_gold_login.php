<style>
	label{
		color:#fff !important;
	}
</style>
<div class="container py-5" style="min-height:500px;">
<div class="row">
<div class="col-md-4 mx-auto">
<div class="border nbr2 rounded p-3 text-white">
	<h1 class="text-center color1 text-uppercase">Login</h1>
	<form id="submit_form" method="post">
	<div class="row register-form">
	<div class="col-md-12">
	<div class="form-group">
	<label for="email">Unique Code:</label>
	<input type="text" id="unique_code" name="unique_code" class="form-control" placeholder="Enter Unique Code *" required>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
	<label for="email">Password:</label>
	<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password *" required>
	</div>
	</div>


	<div class="col-md-12 text-center mb-3">
	<button type="submit" id="submit_id" class="btn abt-btn">Login</button> 
	<div id="msg"></div>
	</div>
	</div>
	</form>	
	<h6 class="text-center mb-4">If not <a href="<?php echo site_url(); ?>casted-gold-register" class="color1">Register Here</a> to get Unique Code & Password</h6>

</div>
</div>
</div>
</div>

<script>
	$(document).ready(function(){			
		$("#submit_form").on("submit", function(e){
			e.preventDefault();	
			$("#submit_form #submit_id").attr('disabled',true);
			$("#submit_form #submit_id").text('Please Wait...');
			let data = new FormData($("#submit_form")[0]);
			$.post({
				type: "post",
				url:"<?php echo site_url(); ?>casted_gold_login_ajax",
				data:data,
				processData: false,
				contentType: false,
				success:function(result)
				{		
					var jsondata=jQuery.parseJSON(result);	
					if(jsondata['status']==1)
					{
						showSuccessMessage("msg",jsondata['msg']);
						$("#submit_form")[0].reset();
						setTimeout(function(){ window.location.href="<?php echo site_url(); ?>casted-gold-booking"; }, 1000);
					}
					else
					{
						showErrorMessage("msg",jsondata['msg']);			
					}
					$("#submit_form #submit_id").attr('disabled',false);
					$("#submit_form #submit_id").text('Submit');
				}
			});
		});	
	});		 
</script>