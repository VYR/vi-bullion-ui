
<div class="container py-5" style="min-height:500px;">
<div class="card shadow bg-white p-3">
	<h1 class="text-center color1 text-uppercase">Bookings</h1>

	<div class="table-responsive">
	<table class="table table-bordered table-striped">
	<thead>
	<tr>
	<th>S.No</th>
	<th>Booking ID</th>
	<th>Biscuit Type</th>
	<th>QTY</th>
	<th>Total KGS</th>
	<th>Amount</th>
	<th>Status</th>
	<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if(count($records) > 0){
	foreach($records as $key => $row){ 
	?> 
	<tr>
	<td><?php echo $key+1; ?></td>
	<td><?php echo $row['booking_id']; ?></td>
	<td><?php echo $row['biscuit_type']; ?></td>
	<td><?php echo $row['quantity']; ?></td>
	<td><?php echo $row['total_kgs']; ?> Kgs</td>
	<td><?php echo $row['sub_total']; ?></td>
	<td>
	<?php if($row['status']==0){ ?>
	<span class="badge badge-pill badge-danger">Pending</a>
	<?php }else if($row['status']==1){ ?>
	<span class="badge badge-pill badge-success">Confirmed</a>
	<?php }else if($row['status']==2){ ?>
	<span class="badge badge-pill badge-success">Closed</a>
	<?php }else{ ?>
	<span class="badge badge-pill badge-danger">Declined</a>
	<?php } ?>
	</td>
	<td><a href="<?php echo site_url(); ?>my-bookings-view?bid=<?php echo $row['booking_id']; ?>" class="btn btn-sm btn-success">View</a></td>
	</tr>
	<?php }} ?>
	</tbody>
	</table>
	</div>
</div>
</div>
