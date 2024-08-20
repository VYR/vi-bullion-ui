<h2 class="text-white">Fix Your Gold Price</h2>
<form id="price_form" method="post">
	<div class="row register-form">
		<div class="col-md-4">
			<div class="form-group">
				<label for="email">Fix Gold Price:</label>
				<input type="hidden" name="id" class="form-control" value="<?php echo $record['id']; ?>">
				<input type="hidden" name="type" class="form-control" value="<?php echo $type; ?>">
				<input type="text" id="fixed_gold_price" name="fixed_gold_price" class="form-control" value="<?php echo round($api_details[0]['Ask'],2); ?>" readonly>
			</div>
		</div>		
		<div class="col-md-4">
			<label for="email">Submit:</label>
			<button type="submit" id="submit_id" class="btn btn-block abt-btn">SUBMIT</button> 
		</div>
	</div>
</form>
<script>
	setInterval(function(){ 
	getLiverates();
	}, 3000);
	getLiverates();
	function getLiverates()
	{
		$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>visave_live_ajax",    
			data: { org_price:1 }})
			.done(function(data){
			$("#fixed_gold_price").val(data);				
		});
	}
	$(document).ready(function(){
		$("#price_form").on("submit", function(e){
		e.preventDefault();	
		$("#price_form #submit_id").html('Please Wait...');
		$.ajax({  
		type: "POST",    
		dataType: "html",    
		url: "<?php echo site_url(); ?>visave_price_ajax",    
		data: $("#price_form").serialize()})
		.done(function(data){		
			$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>visave_user_ajax",    
			data: $("#search_form").serialize()})
			.done(function(data){
				$("#orders_div").html(data);
			});
		});
		});	
	});		 
</script>