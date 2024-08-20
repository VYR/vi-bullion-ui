
<div class="container py-5" style="min-height:500px;">
<div class="border nbr2 rounded text-white p-3">
		
	<h1 class="text-center color1 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
	<form role="form" id="submit_form" method="post" enctype="multipart/form-data">
		<div class="row" >
			<div class="col-md-4 form-group">	
				<label for="name">Name<span class="text-danger">*</span></label>
				<div class="input-group">
					<select class="form-control" id="name_type" name="name_type" required style="max-width:80px;">
					<option value="Mr">Mr</option>	
					<option value="Mrs">Mrs</option>		
					<option value="Ms">Ms</option>		
					</select>
					<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
				</div>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Mobile <span class="text-danger">*</span></label>
				<input type="text" class="form-control"maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="mobile" name="mobile" placeholder="Enter mobile" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Email <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Company Type <span class="text-danger">*</span></label>
				<select class="form-control" id="company_type" name="company_type" required>
					<option value="">Select</option>
					<option value="1">Propreitership</option>
					<option value="2">Partnership</option>
					<option value="3">Private & Public Firm</option>
					<option value="4">HUF Firm</option>
				</select>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Company Name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name" required>
			</div>		
			<div class="col-md-4 form-group">			
				<label for="cat_slno" class="control-label">Pan Type <span class="text-danger">*</span></label><br>
				<label><input type="radio" name="firm_type" value="0"> Individual</label> &nbsp;
				<label><input type="radio" name="firm_type" value="1" checked> Firm / Company</label>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Pan Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" maxlength="10" id="pan_number" name="pan_number" placeholder="Enter Pan Number" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Aadhar Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control"maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="aadhar_number" name="aadhar_number" placeholder="Enter Aadhar Number" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">GST Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number" required>
			</div>	
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Business Type <span class="text-danger">*</span></label>
				<select class="form-control" id="shop_type" name="shop_type" required>
					<option value="">Select</option>
					<option value="1">Wholesaler</option>
					<option value="2">Retailer</option>
					<option value="3">Manufacturer</option>
					<option value="4">Jewellery Shop</option>
				</select>
			</div>
			</div>
			<div class="row">
			<div class="col-md-6 form-group">
			<h6><b>How much gold do you need per month</b></h6>
			<div class="row">
			<div class="col-6">
				<label for="cat_slno" class="control-label">Type <span class="text-danger">*</span></label>
				<select class="form-control" id="grams" name="grams" required>
					<option value="grams">Grams</option>
					<option value="kgs">KGS</option>
				</select>
			</div>
			<div class="col-6">
				<label for="cat_slno" class="control-label">QTY <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="kgs" name="kgs" placeholder="Enter QTY" required>
			</div>
			</div>
			</div>
			<div class="col-md-6 form-group">
			<h6><b>How much siver do you need per month</b></h6>
			<div class="row">
			<div class="col-6">
				<label for="cat_slno" class="control-label">Type <span class="text-danger">*</span></label>
				<select class="form-control" id="silver_grams" name="silver_grams" required>
					<option value="grams">Grams</option>
					<option value="kgs">KGS</option>
				</select>
			</div>
			<div class="col-6">
				<label for="cat_slno" class="control-label">QTY <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="silver_kgs" name="silver_kgs" placeholder="Enter QTY" required>
			</div>
			</div>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">State<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="state" name="state" placeholder="Enter State" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">State Code<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="state_code" name="state_code" placeholder="Enter State Code" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">District <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="district" name="district" placeholder="Enter district" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Pincode <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" required>
			</div>	
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Address <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>
			</div>	
			<div class="col-md-3 form-group">			
			<label for="name">Bank account type<span class="text-danger">*</span></label>	
			<select class="form-control" id="bank_account_type" name="bank_account_type" required>
			<option value="0">Savings</option>	
			<option value="1">Current</option>		
			</select>			
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Bank name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank name" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Bank Account Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="account_number" name="account_number" placeholder="Enter Bank Account Number" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">IFSC Code <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC Code" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Promoter ID <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="promoter_id" name="promoter_id" placeholder="Enter Promoter ID" onkeyup="get_casted_promoter()" autocomplete="off" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Promoter Name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="promoter_name" name="promoter_name" placeholder="Enter Promoter Name" readonly>
			</div>
			<div class="col-md-6 form-group">
				<label for="cat_slno" class="control-label">Remarks <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks" required>
			</div>	
			<div class="col-md-12 form-group text-center">
				<h4 class="text-danger">If you dont have Promoter ID, please call <?php echo $home_content['register_mobile']; ?></h4>
				<button type="submit" id="submit_id" class="btn abt-btn">Submit</button>
				<div id="msg"></div>
			</div>
			<div class="col-md-12 text-center">
			<a href="<?php echo site_url(); ?>casted-gold-login" class="color1">Login Now?</a>
			</div>
		</div>
	</form>
</div>
</div>

<script>
	function get_casted_promoter(){
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
			}			
		});
	}
	$(document).ready(function(){			
		$("#submit_form").on("submit", function(e){
			e.preventDefault();				
			var promoter_name=$("#promoter_name").val();
			if(promoter_name==''){
				showErrorMessage("msg","Enter Valid Promoter ID");
			}else{
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>casted_gold_register_ajax",
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
							setTimeout(function(){ window.location.href="<?php echo site_url(); ?>casted-gold-login"; }, 1000);
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
</script>