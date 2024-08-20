<div class="container py-5" style="min-height:500px;">
<div class="card shadow bg-white p-3">
	<h1 class="text-center color1 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
	<?php
		if($bookings==0){
			echo '<h3 class="text-danger text-center">Previous booking is in process new booking is not allowed</h3>';
		}else{
	?>
	<form role="form" id="submit_form" method="post" enctype="multipart/form-data">
		<div class="row" >
			<div class="col-md-3 form-group">
				<label for="name">Type<span class="text-danger">*</span></label>
				<select class="form-control" id="metal_type" name="metal_type" onchange="getBooking()" required>
					<option value="0">Gold</option>
					<option value="1">Silver</option>
				</select>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">Delivery Area<span class="text-danger">*</span></label>
				<select class="form-control" id="area_id" name="area_id" onchange="showMaindiv()" required>
					<option value="">Select</option>
					<?php	
					if(count($areas) > 0){
					foreach($areas as $skey => $srow){ 
					?> 
					<option value="<?php echo $srow['id']; ?>"><?php echo $srow['name']; ?></option>
					<?php }}  ?>
				</select>
			</div>
		</div>
		<div id="main_div" style="display:none;">			
			<div class="mb-3 text-right">
				<label for="name">Indent Number</label><br>
				<?php 
					$booking_id='VIBULL'.substr(str_shuffle("0123456789"), 0, 6);
				?>
				<input type="hidden" id="booking_id" name="booking_id" value="<?php echo $booking_id; ?>">
				<?php echo $booking_id; ?>
			</div>
			<div class="table-responsive">
			<table class="table table-bordered table-striped">
			<thead>
			<tr>
			<th>Biscuit Type</th>
			<th>QTY</th>
			<th>Total KGS</th>
			<th>Amount</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>
				<select class="form-control" id="biscuit_type" name="biscuit_type" onchange="getBooking()" required style="width:150px;">
					<option value="">Select</option>
					<option value="100">100g</option>
					<option value="500">500g</option>
					<option value="1000">1000g</option>
				</select>
				</td>
				<td>
				<div class="input-group" style="width:150px;">
				<div class="input-group-prepend">
				<button class="btn btn-sm btn-danger" type="button" onclick="decrementQuantity()"><span id="minus_div"><i class="fa fa-minus"></i></span></button>
				</div>
				<input type="text" id="quantity" name="quantity" class="form-control form-control-sm" value="1" readonly>
				<div class="input-group-append">
				<button class="btn btn-sm btn-success" type="button" onclick="incrementQuantity()"><span id="plus_div"><i class="fa fa-plus"></i></span></button>
				</div>
				</div>
				</td>
				<td></td>
				<td></td>
			</tr>
			</tbody>
			</table>
			</div>
			<div class="row">
				<div id="otp_div" class="col-md-6 mx-auto form-group" style="display:none;">
					<label for="cat_slno" class="control-label">OTP <span class="text-danger">*</span></label>
					<input type="hidden" id="otp_status" value="0">
					<input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP">
				</div>
				<div class="col-md-12 form-group text-center">
					<button type="submit" id="submit_id" class="btn btn-success">Submit</button>
					<div id="msg"></div>
				</div>
			</div>
		</div>
	</form>
	<?php
		}
	?>
</div>
</div>
		<script>
$(document).ready(function(){	
	
	$("#submit_form").on("submit", function(e){
				e.preventDefault();		
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				var otp_status=$("#otp_status").val();
				if(otp_status=='0'){
					$.post({
						type: "post",
						url:"<?php echo base_url(); ?>booking_confirm_ajax",
						data:data,
						processData: false,
						contentType: false,
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
							$("#submit_form #submit_id").attr('disabled',false);
							$("#submit_form #submit_id").text('Submit');
						}
					});	
				}else{
					$.post({
						type: "post",
						url:"<?php echo base_url(); ?>booking_confirm_otp_ajax",
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
								setTimeout(function(){ window.location = "<?php echo site_url(); ?>bookings"; }, 1000);
							}
							else
							{
								showErrorMessage("msg",jsondata['msg']);			
							}
							$("#submit_form #submit_id").attr('disabled',false);
							$("#submit_form #submit_id").text('Submit');
						}
					});	
				}
			});	
	
});
		 function showMaindiv(){
			 var area_id=$("#area_id").val();
			 if(area_id==''){
			 $("#main_div").hide();
			 }else{				 
			 getBooking();
			 }
		 }
		function getBooking(){
			$.ajax({    
				type: "POST",    
				dataType: "html",    
				url: "<?php echo base_url();?>booking_ajax",    
				data: $("#submit_form").serialize()})
				.done(function(data) { 
				$('#main_div').html(data);
				$("#main_div").show();
			});
		}	
		function decrementQuantity(){
			var quantity=$("#quantity").val();
			if(quantity>1){ 
				quantity=parseInt(quantity)-1;
				$("#quantity").val(quantity);
				getBooking();
			}
		}
		function incrementQuantity(){
			var quantity=$("#quantity").val();
			quantity=parseInt(quantity)+1;
			$("#quantity").val(quantity);
			getBooking();
		}
		 
		</script>