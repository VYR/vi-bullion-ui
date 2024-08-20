
		<script>
$(document).ready(function(){	
	
	$("#submit_form").on("submit", function(e){
				e.preventDefault();		
				for ( instance in CKEDITOR.instances ) 	
				{        
					CKEDITOR.instances[instance].updateElement();    
				}	
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/minted_silver_users_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/minted_silver_users"; }, 1000);
						}
						else
						{
							$.toast({heading: 'Error',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'error'});		
						}
						$("#submit_form #submit_id").attr('disabled',false);
						$("#submit_form #submit_id").text('Submit');
					}
				});	
			});	
	
});
	function get_minted_silver_promoter(){
		$('#promoter_name').val('');	
		var promoter_id=$("#promoter_id").val();
		$.ajax({    
			type: "POST",    
			dataType: "html",    
			url: "<?php echo base_url(); ?>get_minted_silver_promoter",    
			data: { promoter_id: promoter_id }})
		.done(function(data) { 
			if(data!=''){
			$('#promoter_name').val(data);						
			}			
		});
	}
		 
		 
		</script>
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Users Add
        
      </h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
	<form role="form" id="submit_form" method="post" enctype="multipart/form-data">
		<div class="row" >
			<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			<div class="col-md-1 form-group">	
				<label for="name"> &nbsp;</label>
				<select class="form-control" id="name_type" name="name_type" required style="max-width:80px;">
				<option value="Mr" <?php if(!empty($record) && $record['name_type']=='Mr'){ echo 'selected'; } ?>>Mr</option>	
				<option value="Mrs" <?php if(!empty($record) && $record['name_type']=='Mrs'){ echo 'selected'; } ?>>Mrs</option>		
				<option value="Ms" <?php if(!empty($record) && $record['name_type']=='Ms'){ echo 'selected'; } ?>>Ms</option>		
				</select>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php if(!empty($record)){ echo $record['name']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Mobile <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" value="<?php if(!empty($record)){ echo $record['mobile']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Email <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php if(!empty($record)){ echo $record['email']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Company Type <span class="text-danger">*</span></label>
				<select class="form-control" id="company_type" name="company_type" required>
					<option value="">Select</option>
					<option value="1" <?php if(!empty($record) && $record['company_type']=='1'){ echo 'selected'; } ?>>Propreitership</option>
					<option value="2" <?php if(!empty($record) && $record['company_type']=='2'){ echo 'selected'; } ?>>Partnership</option>
					<option value="3" <?php if(!empty($record) && $record['company_type']=='3'){ echo 'selected'; } ?>>Private & Public Firm</option>
					<option value="4" <?php if(!empty($record) && $record['company_type']=='4'){ echo 'selected'; } ?>>HUF Firm</option>
				</select>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Company Name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name" value="<?php if(!empty($record)){ echo $record['company_name']; } ?>" required>
			</div>		
			<div class="col-md-4 form-group">		
			<label for="cat_slno" class="control-label">Pan Type <span class="text-danger">*</span></label>
			<select class="form-control" id="firm_type" name="firm_type" required>	
			<option value="0" <?php if(!empty($record) && $record['firm_type']=='0'){ echo 'selected'; } ?>>Individual</option>		
			<option value="1" <?php if(!empty($record) && $record['firm_type']=='1'){ echo 'selected'; } ?>>Firm/Company</option>		
			</select>	
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Pan Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="pan_number" name="pan_number" placeholder="Enter Pan Number" value="<?php if(!empty($record)){ echo $record['pan_number']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">GST Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number" value="<?php if(!empty($record)){ echo $record['gst_no']; } ?>" required>
			</div>	
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Business Type <span class="text-danger">*</span></label>
				<select class="form-control" id="shop_type" name="shop_type" required>
					<option value="">Select</option>
					<option value="1" <?php if(!empty($record) && $record['shop_type']=='1'){ echo 'selected'; } ?>>Wholesaler</option>
					<option value="2" <?php if(!empty($record) && $record['shop_type']=='2'){ echo 'selected'; } ?>>Retailer</option>
					<option value="3" <?php if(!empty($record) && $record['shop_type']=='3'){ echo 'selected'; } ?>>Manufacturer</option>
					<option value="4" <?php if(!empty($record) && $record['shop_type']=='4'){ echo 'selected'; } ?>>Jewellery Shop</option>
				</select>
			</div>
			<div class="col-md-6 form-group">
			<h6><b>How much gold do you need per month</b></h6>
			<div class="row">
			<div class="col-xs-6">
				<label for="cat_slno" class="control-label">Type <span class="text-danger">*</span></label>
				<select class="form-control" id="grams" name="grams" required>
					<option value="grams" <?php if(!empty($record) && $record['grams']=='grams'){ echo 'selected'; } ?>>Grams</option>
					<option value="kgs" <?php if(!empty($record) && $record['grams']=='kgs'){ echo 'selected'; } ?>>KGS</option>
				</select>
			</div>
			<div class="col-xs-6">
				<label for="cat_slno" class="control-label">QTY <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="kgs" name="kgs" value="<?php if(!empty($record)){ echo $record['kgs']; } ?>" placeholder="Enter QTY" required>
			</div>
			</div>
			</div>
			<div class="col-md-6 form-group">
			<h6><b>How much siver do you need per month</b></h6>
			<div class="row">
			<div class="col-xs-6">
				<label for="cat_slno" class="control-label">Type <span class="text-danger">*</span></label>
				<select class="form-control" id="silver_grams" name="silver_grams" required>
					<option value="grams" <?php if(!empty($record) && $record['silver_grams']=='grams'){ echo 'selected'; } ?>>Grams</option>
					<option value="kgs" <?php if(!empty($record) && $record['silver_grams']=='kgs'){ echo 'selected'; } ?>>KGS</option>
				</select>
			</div>
			<div class="col-xs-6">
				<label for="cat_slno" class="control-label">QTY <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="silver_kgs" name="silver_kgs" value="<?php if(!empty($record)){ echo $record['silver_kgs']; } ?>" placeholder="Enter QTY" required>
			</div>
			</div>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">State<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="state" name="state" placeholder="Enter State" value="<?php if(!empty($record)){ echo $record['state']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">District <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="district" name="district" placeholder="Enter district" value="<?php if(!empty($record)){ echo $record['district']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Pincode <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" value="<?php if(!empty($record)){ echo $record['pincode']; } ?>" required>
			</div>	
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Address <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?php if(!empty($record)){ echo $record['address']; } ?>" required>
			</div>	
			<div class="col-md-3 form-group">				<label for="name">Bank account type<span class="text-danger">*</span></label>				<select class="form-control" id="bank_account_type" name="bank_account_type" required>					<option value="0" <?php if(!empty($record) && $record['bank_account_type']=='0'){ echo 'selected'; } ?>>Savings</option>					<option value="1" <?php if(!empty($record) && $record['bank_account_type']=='1'){ echo 'selected'; } ?>>Current</option>				</select>			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Bank name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank name" value="<?php if(!empty($record)){ echo $record['bank_name']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Bank Account Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="account_number" name="account_number" placeholder="Enter Bank Account Number" value="<?php if(!empty($record)){ echo $record['account_number']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">IFSC Code <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC Code" value="<?php if(!empty($record)){ echo $record['ifsc_code']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Promoter ID <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="promoter_id" name="promoter_id" placeholder="Enter Promoter ID" onkeyup="get_minted_silver_promoter()" autocomplete="off" value="<?php if(!empty($record)){ echo $record['promoter_id']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Promoter Name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="promoter_name" name="promoter_name" placeholder="Enter Promoter Name" value="<?php if(!empty($record)){ echo $record['promoter_name']; } ?>" readonly>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Remarks <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks" value="<?php if(!empty($record)){ echo $record['remarks']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Upload document <span class="text-danger">*</span></label>
				<?php if(!empty($record) && !empty($record['document'])){ ?>
				<a href="<?php echo site_url(); ?>assets/images/users/<?php echo $record['document']; ?>" target="_blank">Click Here</a>
				<?php } ?>
				<input type="file" class="form-control" id="pdf" name="pdf" <?php if(empty($record)){ echo 'required'; } ?>>
			</div>
			<div class="col-md-4 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	
          
          <!-- /.box -->
		  
			
	
		  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
