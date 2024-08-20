
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
					url:"<?php echo base_url(); ?>admin/users_huf_ajax",
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
       Firm Details       
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
		<input type="hidden" id="user_id" name="user_id" value="<?php if(!empty($record)){ echo $record['user_id']; }else{ echo $user_id; } ?>">		<div id="add_more_div">		<?php 				if(empty($record)){		?>		<div class="row" >			<div class="col-md-2 form-group">				<label for="name">Partner Name<span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_names" name="partner_names[]" placeholder="Enter Name" required>			</div>			<div class="col-md-3 form-group">				<label for="name">Partner Father Name<span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_father_names" name="partner_father_names[]" placeholder="Enter Father Name" required>			</div>			<div class="col-md-2 form-group">				<label for="cat_slno" class="control-label">Partner Mobile <span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_mobiles" name="partner_mobiles[]" placeholder="Enter mobile" required>			</div>			<div class="col-md-2 form-group">				<label for="cat_slno" class="control-label">Partner Email <span class="text-danger">*</span></label>				<input type="email" class="form-control" id="partner_emails" name="partner_emails[]" placeholder="Enter email" required>			</div>			<div class="col-md-2 form-group">				<label for="cat_slno" class="control-label">Partner Pan Number <span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_pan_numbers" name="partner_pan_numbers[]" placeholder="Enter Pan Number" required>			</div>		</div>		<?php 				}else{ 		$partner_names=explode("**",$record['partner_names']);		$partner_father_names=explode("**",$record['partner_father_names']);		$partner_mobiles=explode("**",$record['partner_mobiles']);		$partner_emails=explode("**",$record['partner_emails']);		$partner_pan_numbers=explode("**",$record['partner_pan_numbers']);		?>		<?php foreach($partner_names as $key=>$row){ ?>		<div class="row" id="div_<?php echo $key; ?>">			<div class="col-md-2 form-group">				<label for="name">Partner Name<span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_names" name="partner_names[]" placeholder="Enter Name" value="<?php if(!empty($record) && $partner_names[$key]!='0'){ echo $partner_names[$key]; } ?>" required>			</div>			<div class="col-md-3 form-group">				<label for="name">Partner Father Name<span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_father_names" name="partner_father_names[]" placeholder="Enter Father Name" value="<?php if(!empty($record) && $partner_father_names[$key]!='0'){ echo $partner_father_names[$key]; } ?>" required>			</div>			<div class="col-md-2 form-group">				<label for="cat_slno" class="control-label">Partner Mobile <span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_mobiles" name="partner_mobiles[]" placeholder="Enter mobile" value="<?php if(!empty($record) && $partner_mobiles[$key]!='0'){ echo $partner_mobiles[$key]; } ?>" required>			</div>			<div class="col-md-2 form-group">				<label for="cat_slno" class="control-label">Partner Email <span class="text-danger">*</span></label>				<input type="email" class="form-control" id="partner_emails" name="partner_emails[]" placeholder="Enter email" value="<?php if(!empty($record) && $partner_emails[$key]!='0'){ echo $partner_emails[$key]; } ?>" required>			</div>			<div class="col-md-2 form-group">				<label for="cat_slno" class="control-label">Partner Pan Number <span class="text-danger">*</span></label>				<input type="text" class="form-control" id="partner_pan_numbers" name="partner_pan_numbers[]" placeholder="Enter Pan Number" value="<?php if(!empty($record) && $partner_pan_numbers[$key]!='0'){ echo $partner_pan_numbers[$key]; } ?>" required>			</div>			<?php if($key>0){ ?>			<div class="col-md-1 form-group">			&nbsp; <br>			<button type="button" class="btn btn-danger" onclick="removeDiv(<?php echo $key; ?>)"><i class="fa fa-times"></i></button>			</div>			<?php } ?>		</div>		<?php } ?>		<?php 				}		?>		</div>		<hr style="margin:0;">		<button type="button" class="btn btn-success btn-sm" id="add_div" onclick="addDiv(0)" style="margin:10px 0;"><i class="fa fa-plus"></i> Add More Partners</button>
		<div class="row" >
			<div class="col-md-3 form-group">
				<label for="name">Firm Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="firm_name" name="firm_name" placeholder="Enter Firm Name" value="<?php if(!empty($record)){ echo $record['firm_name']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Firm Registration Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="firm_reg_number" name="firm_reg_number" placeholder="Enter Firm Registration Number" value="<?php if(!empty($record)){ echo $record['firm_reg_number']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Firm Pan Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="firm_pan_number" name="firm_pan_number" placeholder="Enter Firm Pan Number" value="<?php if(!empty($record)){ echo $record['firm_pan_number']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">Firm GST Number <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="firm_gst_number" name="firm_gst_number" placeholder="Enter Firm GST Number" value="<?php if(!empty($record)){ echo $record['firm_gst_number']; } ?>" required>
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
				<label for="name">Contact Name<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="Enter Contact Name" value="<?php if(!empty($record)){ echo $record['contact_name']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Contact Email <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="contact_email" name="contact_email" placeholder="Enter Contact email" value="<?php if(!empty($record)){ echo $record['contact_email']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Contact Mobile <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="contact_mobile" name="contact_mobile" placeholder="Enter Contact mobile" value="<?php if(!empty($record)){ echo $record['contact_mobile']; } ?>" required>
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
<script>	function addDiv(key)	{			var new_key=parseInt(key)+1;		$.ajax({    		type: "POST",    		dataType: "html",    		url: "<?php echo base_url();?>admin/partnership_ajax",    		data: { key: key }})		.done(function(data) { 		$('#add_more_div').append(data);		$('#add_div').attr("onclick","addDiv("+new_key+")");		});	}	function removeDiv(id)	{			$("#div_"+id).remove();	}</script>
 