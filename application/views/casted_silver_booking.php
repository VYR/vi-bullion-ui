<style>
	label{
		color:#fff !important;
	}
</style>
<div class="container py-5" style="min-height:500px;">
<div class="border nbr3 rounded col-12 py-3">
	<h1 class="text-center ncolor3 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
	<form id="submit_form" method="post">
		<input type="hidden" id="org_price" value="<?php echo $org_price; ?>">
		<input type="hidden" id="dollar_price" value="<?php echo $dollar_price; ?>">
		<div class="row register-form">
			<div class="col-md-4 mb-3">
				<label for="email">Pickup State<span class="text-danger"></span></label>
				<select class="form-control" id="place_id" name="place_id"  onchange="getDealers()" required>
					<option value="">Select</option>
					<?php	
					if(!empty($places)){
					foreach($places as $skey => $srow){ 
					?> 
					<option value="<?php echo $srow['id']; ?>"><?php echo $srow['name']; ?></option>
					<?php }}  ?>
				</select>
			</div>
			<div class="col-md-4 mb-3">
				<label for="email">Pickup Point<span class="text-danger"></span></label>
				<select class="form-control" id="dealer_id" name="dealer_id" required>
					<option value="">Select</option>
					<?php	
					if(!empty($dealers)){
					foreach($dealers as $skey => $srow){ 
					?> 
					<option value="<?php echo $srow['id']; ?>"><?php echo $srow['address']; ?></option>
					<?php }}  ?>
				</select>
			</div>
			<div class="col-md-4 mb-3">
				<label for="email">&nbsp; </label><br>
				<button type="submit" id="submit_btn" class="btn silver-btn">Submit</button> 
			</div>
		</div>
	</form>	
</div>
</div>

<script>	
	function getDealers(){
		var place_id=$("#place_id").val();
		$.ajax({    
		type: "POST",    
		dataType: "html",    
		url:"<?php echo base_url(); ?>get_dealers",
		data: {place_id: place_id }})
		.done(function(data) { 
		if(data!=''){
		$('#dealer_id').html(data);
		}
		});	
	}
	$(document).ready(function(){			
		$("#submit_form").on("submit", function(e){
			e.preventDefault();	
			$("#submit_form #submit_btn").attr('disabled',true);
			$("#submit_form #submit_btn").text('Please Wait...');
			$.ajax({    
			type: "POST",    
			dataType: "html",    
			url:"<?php echo base_url(); ?>casted_silver_pickup_ajax",
			data: $("#submit_form").serialize()})
			.done(function(data) {
				location.href="<?php echo site_url(); ?>casted-silver-cart";
			});	
		});	
	});		
</script>