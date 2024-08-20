
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
					url:"<?php echo base_url(); ?>admin/users_propreitership_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/users"; }, 1000);
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
		 
		 
		</script>
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Company Details       
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
		<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
		<input type="hidden" id="user_id" name="user_id" value="<?php if(!empty($record)){ echo $record['user_id']; }else{ echo $user_id; } ?>">
		<div class="row" >
			<div class="col-md-3 form-group">
				<label for="name">Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php if(!empty($record)){ echo $record['name']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">Father Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="father_name" name="father_name" placeholder="Enter Father Name" value="<?php if(!empty($record)){ echo $record['father_name']; } ?>" required>
			</div>
			<div class="col-md-2 form-group">
				<label for="cat_slno" class="control-label">Mobile <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" value="<?php if(!empty($record)){ echo $record['mobile']; } ?>" required>
			</div>
			<div class="col-md-2 form-group">
				<label for="cat_slno" class="control-label">Email <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php if(!empty($record)){ echo $record['email']; } ?>" required>
			</div>
			<div class="col-md-2 form-group">
				<label for="cat_slno" class="control-label">Pan Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="pan_number" name="pan_number" placeholder="Enter pan number" value="<?php if(!empty($record)){ echo $record['pan_number']; } ?>" required>
			</div>
		</div>
		<div class="row" >
			<div class="col-md-6 form-group">
				<label for="name">Trade Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="trade_name" name="trade_name" placeholder="Enter Trade Name" value="<?php if(!empty($record)){ echo $record['trade_name']; } ?>" required>
			</div>
			<div class="col-md-6 form-group">
				<label for="cat_slno" class="control-label">GST Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number" value="<?php if(!empty($record)){ echo $record['gst_no']; } ?>" required>
			</div>
		</div>
		<div class="row" >
			<div class="col-md-3 form-group">
				<label for="name">State<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="state" name="state" placeholder="Enter State" value="<?php if(!empty($record)){ echo $record['state']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">District <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="district" name="district" placeholder="Enter district" value="<?php if(!empty($record)){ echo $record['district']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Post <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="post" name="post" placeholder="Enter Post" value="<?php if(!empty($record)){ echo $record['post']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Pincode <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" value="<?php if(!empty($record)){ echo $record['pincode']; } ?>" required>
			</div>
		</div>
		<div class="row" >
			<div class="col-md-4 form-group">
				<label for="name">Trade Contact Number<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="trade_contact_number" name="trade_contact_number" placeholder="Enter Contact Number" value="<?php if(!empty($record)){ echo $record['trade_contact_number']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Trade Phone Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="trade_phone_number" name="trade_phone_number" placeholder="Enter Phone Number" value="<?php if(!empty($record)){ echo $record['trade_phone_number']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Trade Email <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="trade_email" name="trade_email" placeholder="Enter email" value="<?php if(!empty($record)){ echo $record['trade_email']; } ?>" required>
			</div>
		</div>
		<div class="row" >
			<div class="col-md-4 form-group">
				<label for="name">Bank account type<span class="text-danger">*</span></label>
				<select class="form-control" id="bank_account_type" name="bank_account_type" required>
					<option value="0" <?php if(!empty($record) && $record['bank_account_type']=='0'){ echo 'selected'; } ?>>Savings</option>
					<option value="1" <?php if(!empty($record) && $record['bank_account_type']=='1'){ echo 'selected'; } ?>>Current</option>
				</select>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Bank account name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="bank_account_name" name="bank_account_name" placeholder="Enter Bank account name" value="<?php if(!empty($record)){ echo $record['bank_account_name']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Bank account number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="bank_account_number" name="bank_account_number" placeholder="Enter Bank account number" value="<?php if(!empty($record)){ echo $record['bank_account_number']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Bank ifsc <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="bank_ifsc" name="bank_ifsc" placeholder="Enter Bank ifsc code" value="<?php if(!empty($record)){ echo $record['bank_ifsc']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Bank name <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank name" value="<?php if(!empty($record)){ echo $record['bank_name']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Bank branch <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Enter Bank branch" value="<?php if(!empty($record)){ echo $record['bank_branch']; } ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Upload document <span class="text-danger">*</span></label>
				<?php if(!empty($record)){ ?>
				<a href="<?php echo site_url(); ?>assets/images/users/<?php echo $record['document']; ?>" target="_blank">Click Here</a>
				<?php } ?>
				<input type="file" class="form-control" id="pdf" name="pdf" <?php if(empty($record)){ echo 'required'; } ?>>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Referral id <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="referral_id" name="referral_id" placeholder="Enter Referral id" value="<?php if(!empty($record)){ echo $record['referral_id']; } ?>" required>
			</div>
		</div>
		<div class="">
			<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
			<a href="<?php echo base_url(); ?>admin/users" class="btn btn-danger text-white">Cancel</a>
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

 
