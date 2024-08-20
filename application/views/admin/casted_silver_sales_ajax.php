	<div class="table-responsive">
	<table id="example1" class="table table-bordered table-striped">            
	<thead>       
	<tr>       
	<th>SNO</th>  
	<th>Buyer Details</th>     
	<th>Pickup Details</th>     
	<th>Order Details</th>      
	<th>Payment Details</th>  
	<th>Other Details</th>  
	<?php if(!empty($records) && $records[0]['order_status']!=0){ ?>
	<th>Employee Details</th>  
	<?php } ?>
	</tr>       
	</thead>   
	<tbody>
	<?php	
	if(count($records) > 0){
	foreach($records as $key => $row){ 
	?> 
	<tr class="text-center">
	<td><?php echo $key+1; ?></td>
	<td>
	<div><?php echo $row['buyer_name']; ?></div>
	<div><?php echo $row['buyer_mobile']; ?></div>
	<div><?php echo $row['buyer_email']; ?></div>
	<div><?php echo $row['buyer_address']; ?> - <?php echo $row['buyer_pincode']; ?></div>
	<div><?php echo $row['buyer_state']; ?> - <?php echo $row['buyer_state_code']; ?></div>
	<div><b>GST :</b> <?php echo $row['buyer_gst_no']; ?></div>
	<div><b>Pan No :</b> <?php echo $row['buyer_pan_number']; ?></div>
	<div><b>Aadhar No :</b> <?php echo $row['buyer_aadhar_number']; ?></div>
	</td>
	<td>
	<?php echo $row['pickup_dealer_address']; ?><br>
	<?php echo $row['pickup_state']; ?> - <?php echo $row['pickup_state_code']; ?>
	</td>
	<td>
	<div><b>Order ID : </b><?php echo $row['order_ref_id']; ?></div>
	<div><?php echo date("d/M/Y h:i A", strtotime($row['order_date_time'])); ?></div>
	<?php 
		if($row['order_status']=='0'){
			$curr_time=date("h:i:s");			
			$end_time = date("h:i:s",strtotime("+".$home_content['casted_silver_order_time']." minutes", strtotime($row['order_date_time'])));			
			$mins = (strtotime($end_time) - strtotime($curr_time)) / 60;
			if($mins>0){
			echo '<b class="text-danger">'.round($mins).' mins</b>';
			}else{
			echo '<b class="text-danger">0 mins</b>';
			}
		}
	?>
	<?php if($row['qr_code']!=''){ ?>
	<a target="_blank" href="<?php echo base_url(); ?>admin/casted_silver_sales_download_admin?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Admin Invoice</a><br><br>
	<a target="_blank" href="<?php echo base_url(); ?>admin/casted_silver_sales_download_customer?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Customer Invoice</a><br><br>
	<a target="_blank" href="<?php echo base_url(); ?>admin/casted_silver_sales_download_pickup?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Pickup Invoice</a>
	<?php } ?>
	</td>
	<td>
		<div><b>Total :</b> Rs.<?php echo $row['total_amount']; ?>/-</div>
		<div><b>Discount :</b> Rs.<?php echo $row['coupon_amount']; ?>/-</div>
		<div><b>Final Amount :</b> Rs.<?php echo $row['final_amount']; ?>/-</div>
	</td>
	<td>
		<?php if($row['order_status']==1 && $row['qr_code']!=''){ ?>
		<div style="display:flex;">
			<div style="margin-right:10px;">
				<img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $row['qr_code']; ?>" width="100">
			</div>
			<div>
				<div><b>HSN Code :</b> <?php echo $row['hsn_code']; ?></div>			
				<div><b>Silver No's :</b> <?php echo $row['silver_nos']; ?></div>			
				<div><b>IRN No :</b> <?php echo $row['irn_no']; ?></div>			
				<div><b>TCS Value :</b> <?php echo $row['tcs_value']; ?></div>			
				<div><b>Time :</b> <?php echo $row['time']; ?></div>			
			</div>
		</div>
		<?php }else if($row['order_status']==2){ ?>
		<b class="text-danger">Cancelled</b>
		<?php }else{ ?>
		<a href="javascript:void(0)" onclick="openUpdate(<?php echo $row['id']; ?>)" class="btn btn-success text-white">Update</a>
		<a href="javascript:void(0)" onclick="openCancel(<?php echo $row['id']; ?>,'<?php echo $row['total_weight']*$home_content['casted_silver_deposit']; ?>')" class="btn btn-danger text-white">Cancel</a>
		<?php } ?>
	</td>
	<td>
		<?php if($row['order_status']==1){ ?>
		<div><?php echo $row['employee_code']; ?></div>
		<div><?php echo $row['employee_name']; ?></div>
		<?php } ?>
	</td>
	</tr>
	<?php }}  ?>
	</tbody>
	</table>
	</div>
	
<script>
  $(function () {
	 $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  })
</script>