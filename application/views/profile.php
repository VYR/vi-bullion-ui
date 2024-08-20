
<div class="container py-5" style="min-height:500px;">
<div class="card shadow bg-white p-3">
	<h1 class="text-center color1 text-uppercase">Profile</h1>
	<div class="row" >
		<div class="col-md-6 form-group">
			<label for="name">Unique Code</label><br>
			<?php if(!empty($record)){ echo $record['unique_code']; } ?>
		</div>
		<div class="col-md-6 form-group">
			<label for="cat_slno" class="control-label">Password </label><br>
			<?php if(!empty($record)){ echo decode5t($record['password']); } ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Name</label><br>
			<?php if(!empty($record)){ echo $record['name']; } ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Mobile </label><br>
			<?php if(!empty($record)){ echo $record['mobile']; } ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Email </label><br>
			<?php if(!empty($record)){ echo $record['email']; } ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Company Type </label><br>
			<?php if(!empty($record) && $record['company_type']=='1'){ echo 'Propreitership'; } ?>
			<?php if(!empty($record) && $record['company_type']=='2'){ echo 'Partnership'; } ?>
			<?php if(!empty($record) && $record['company_type']=='3'){ echo 'Private & Public Firm'; } ?>
			<?php if(!empty($record) && $record['company_type']=='4'){ echo 'HUF Firm'; } ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Company Name </label><br>
			<?php if(!empty($record)){ echo $record['company_name']; } ?>
		</div>		
		<div class="col-md-4 form-group">			
		<label for="cat_slno" class="control-label">Pan Type </label><br>
		<?php if(!empty($record) && $record['firm_type']=='0'){ echo 'Individual'; } ?>
		<?php if(!empty($record) && $record['firm_type']=='1'){ echo 'Firm/Company'; } ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Pan Number </label><br>
			<?php if(!empty($record)){ echo $record['pan_number']; } ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">GST Number </label><br>
			<?php if(!empty($record)){ echo $record['gst_no']; } ?>
		</div>	
		<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Business Type </label><br>
			<?php if(!empty($record) && $record['shop_type']=='1'){ echo 'Wholesaler'; } ?>
			<?php if(!empty($record) && $record['shop_type']=='2'){ echo 'Retailer'; } ?>
			<?php if(!empty($record) && $record['shop_type']=='3'){ echo 'Manufacturer'; } ?>
			<?php if(!empty($record) && $record['shop_type']=='4'){ echo 'Jewellery Shop'; } ?>
		</div>
		<div class="col-md-6 form-group">
		<h6><b>How much gold do you need per month</b></h6>
		<div class="row">
		<div class="col-6">
			<label for="cat_slno" class="control-label">Type <span class="text-danger"></span></label><br>
			<?php if(!empty($record)){ echo $record['grams']; } ?>
		</div>
		<div class="col-6">
			<label for="cat_slno" class="control-label">QTY <span class="text-danger"></span></label><br>
			<?php if(!empty($record)){ echo $record['kgs']; } ?>
		</div>
		</div>
		</div>
		<div class="col-md-6 form-group">
		<h6><b>How much siver do you need per month</b></h6>
		<div class="row">
		<div class="col-6">
			<label for="cat_slno" class="control-label">Type <span class="text-danger"></span></label><br>
			<?php if(!empty($record)){ echo $record['silver_grams']; } ?>
		</div>
		<div class="col-6">
			<label for="cat_slno" class="control-label">QTY <span class="text-danger"></span></label><br>
			<?php if(!empty($record)){ echo $record['silver_kgs']; } ?>
		</div>
		</div>
		</div>
		<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Gold Monthly grams </label><br>
			<?php if(!empty($record)){ echo $record['grams']; } ?>
		</div>
		<div class="col-md-3 form-group">
			<label for="name">State</label><br>
			<?php if(!empty($record)){ echo $record['state']; } ?>
		</div>
		<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">District </label><br>
			<?php if(!empty($record)){ echo $record['district']; } ?>
		</div>
		<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Post </label><br>
			<?php if(!empty($record)){ echo $record['post']; } ?>
		</div>
		<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Pincode </label><br>
			<?php if(!empty($record)){ echo $record['pincode']; } ?>
		</div>		
		<div class="col-md-6 form-group">		
		<label for="name">Bank account type</label><br>
		<?php if(!empty($record) && $record['bank_account_type']=='0'){ echo 'Savings'; }else{ echo 'Current'; } ?>	</div>
		<div class="col-md-6 form-group">
			<label for="cat_slno" class="control-label">Bank name </label><br>
			<?php if(!empty($record)){ echo $record['bank_name']; } ?>
		</div>
	</div>
</div>
</div>
