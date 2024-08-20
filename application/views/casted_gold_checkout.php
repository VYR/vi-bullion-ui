<style>
	label{
		color:#fff !important;
	}
</style>
<div class="container py-5" style="min-height:500px;">
<div class="border nbr2 rounded col-12 py-3">
	<h1 class="text-center color1 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
	<form id="submit_form" method="post">
		<div id="checkout_div">
			
		</div>
		<div id="msg"></div>
	</form>
</div>
</div>

<script>
	getCheckout();
	function getCheckout(){
		$.ajax({    
			type: "POST",    
			dataType: "html",    
			url:"<?php echo base_url(); ?>casted_gold_checkout_ajax",
			data: $("#submit_form").serialize()})
			.done(function(data) { 
			$('#checkout_div').html(data);
		});	
	} 
	function get_casted_promoter(){
		$('#msg').html('');	
		$('#promoter_name').val('');	
		var promoter_id=$("#promoter_id").val();
		$.ajax({    
			type: "POST",    
			dataType: "html",    
			url: "<?php echo base_url(); ?>get_casted_gold_promoter",    
			data: { promoter_id: promoter_id }})
		.done(function(data) { 
			if(data!=''){
				$('#promoter_name').val(data);		
				getCheckout();
			}else{				
				showErrorMessage("msg","Enter Valid Promoter Id to continue");	
			}			
		});
	}
	function showSubmit(){
		$('#msg').html('');	
		var promoter_name=$("#promoter_name").val();
		if(promoter_name==''){				
			showErrorMessage("msg","Enter Valid Promoter Id to continue");	
		}else{
			$('#submit_div').show();	
		}
	}
	function submitOrder(){
		$('#msg').html('');	
		$("#submit_form #submit_btn").attr('disabled',true);
		$("#submit_form #submit_btn").text('Please Wait...');
		$.ajax({    
		type: "POST",    
		dataType: "html",    
		url:"<?php echo base_url(); ?>casted_gold_order_ajax",
		data: $("#submit_form").serialize()})
		.done(function(data) {
			var jsondata=jQuery.parseJSON(data);	
			if(jsondata['status']==1)
			{
				showSuccessMessage("msg",jsondata['msg']);
				setTimeout(function(){ window.location.href="<?php echo site_url(); ?>casted-gold-success"; }, 1000);
			}
			else
			{
				showErrorMessage("msg",jsondata['msg']);			
			}
		});	
	}
	/*$(document).ready(function(){			
		$("#submit_form").on("submit", function(e){
			e.preventDefault();	
			$('#msg').html('');	
			var promoter_name=$("#promoter_name").val();
			if(promoter_name==''){				
				showErrorMessage("msg","Enter Valid Promoter Id to continue");	
			}else{
				$("#submit_form #submit_btn").attr('disabled',true);
				$("#submit_form #submit_btn").text('Please Wait...');
				$.ajax({    
				type: "POST",    
				dataType: "html",    
				url:"<?php echo base_url(); ?>casted_gold_order_ajax",
				data: $("#submit_form").serialize()})
				.done(function(data) {
					var jsondata=jQuery.parseJSON(data);	
					if(jsondata['status']==1)
					{
						showSuccessMessage("msg",jsondata['msg']);
						setTimeout(function(){ window.location.href="<?php echo site_url(); ?>casted-gold-success"; }, 1000);
					}
					else
					{
						showErrorMessage("msg",jsondata['msg']);			
					}
				});	
			}
		});	
	});	*/		
</script>