		
<div class="mb-3 text-right">
	<label for="name">Indent Number</label><br>
	<input type="hidden" id="booking_id" name="booking_id" value="<?php echo $post['booking_id']; ?>">
	<?php echo $post['booking_id']; ?>
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
<option value="100" <?php if($post['biscuit_type']=='100'){ echo 'selected'; } ?>>100g</option>
<option value="500" <?php if($post['biscuit_type']=='500'){ echo 'selected'; } ?>>500g</option>
<option value="1000" <?php if($post['biscuit_type']=='1000'){ echo 'selected'; } ?>>1000g</option>
</select>
</td>
<td>
<div class="input-group" style="width:150px;">
<div class="input-group-prepend">
<button class="btn btn-sm btn-danger" type="button" onclick="decrementQuantity()"><span id="minus_div"><i class="fa fa-minus"></i></span></button>
</div>
<input type="text" id="quantity" name="quantity" class="form-control form-control-sm" value="<?php echo $post['quantity']; ?>" readonly>
<div class="input-group-append">
<button class="btn btn-sm btn-success" type="button" onclick="incrementQuantity()"><span id="plus_div"><i class="fa fa-plus"></i></span></button>
</div>
</div>
</td>
<td>
<?php 
$total_kgs='';
if($post['biscuit_type']!=''){
	$total_kgs=($post['biscuit_type']*$post['quantity'])/1000;
}
echo $total_kgs;
?>
<input type="hidden" id="total_kgs" name="total_kgs" value="<?php echo $total_kgs; ?>">
</td>
<td>
<?php 
$sub_total='';
$qrate=0;
if(!empty($rate)){
	$qrate=$rate['rate'];
}
if($post['biscuit_type']!=''){
	$sub_total=($post['biscuit_type']*$post['quantity'])*$qrate;
}
echo $sub_total;
?>
<input type="hidden" id="sub_total" name="sub_total" value="<?php echo $sub_total; ?>">
</td>
</tr>
<?php if($post['biscuit_type']!=''){ ?>
<?php
	$gst_percentage=$home_content['gst_percentage'];
	$gst_amount=($sub_total*$gst_percentage)/100;
	$total_amount=$sub_total+$gst_amount;
?>
<tr>
	<th colspan="3" class="text-right">GST (<?php echo $gst_percentage; ?>%)</th>
	<th>
	<?php echo $gst_amount; ?>
	<input type="hidden" id="gst_percentage" name="gst_percentage" value="<?php echo $gst_percentage; ?>">
	<input type="hidden" id="gst_amount" name="gst_amount" value="<?php echo $gst_amount; ?>">
	</th>
</tr>
<tr>
	<th colspan="3" class="text-right">Total</th>
	<th>
	<?php echo $total_amount; ?>
	<input type="hidden" id="total_amount" name="total_amount" value="<?php echo $total_amount; ?>">
	</th>
</tr>
<?php } ?>
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