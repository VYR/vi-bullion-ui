
<div class="container py-5" style="min-height:500px;">
<div class="card shadow bg-white p-3">
	<h1 class="text-center color1 text-uppercase">Booking Details</h1>	
	<div class="row">
		<div class="col-md-6 form-group">
			<label for="name">Date</label><br>
			<?php echo date("d-M-Y", strtotime($record['booking_date_time'])); ?>
		</div>
		<div class="col-md-6 form-group text-right">
			<label for="name">Indent Number</label><br>
			<?php echo $record['booking_id']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Name</label><br><?php echo $record['name']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Mobile</label><br><?php echo $record['mobile']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Email</label><br><?php echo $record['email']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Company Name</label><br><?php echo $record['company_name']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Pan Number</label><br><?php echo $record['pan_number']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">GST Number</label><br><?php echo $record['gst_number']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Unique Code</label><br><?php echo $record['unique_code']; ?>
		</div>
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
	<?php echo $record['biscuit_type']; ?>
	</td>
	<td>
	<?php echo $record['quantity']; ?>
	</td>
	<td>
	<?php echo $record['total_kgs']; ?>
	</td>
	<td>
	<?php echo $record['sub_total']; ?>
	</td>
	</tr>
	<tr>
		<th colspan="3" class="text-right">GST (<?php echo $record['gst_percentage']; ?>%)</th>
		<th>
		<?php echo $record['gst_amount']; ?>
		</th>
	</tr>
	<tr>
		<th colspan="3" class="text-right">Total</th>
		<th>
		<?php echo $record['total_amount']; ?>
		</th>
	</tr>
	</tbody>
	</table>
	</div>
	<div class="row">
		<div class="col-md-12 form-group">
			<label for="name">Remarks</label><br>
			<?php if($record['remarks']==''){ ?>
			<div class="text-danger">Not Given</div>
			<?php }else{ ?>
			<?php echo $record['remarks']; ?>
			<?php } ?>
		</div>
		<div class="col-md-12 text-center">
			<a href="<?php echo site_url(); ?>my-bookings" class="btn btn-sm btn-success">Back</a>
		</div>
	</div>	
</div>
</div>
