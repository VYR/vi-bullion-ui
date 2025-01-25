<div class="table-responsive">
	<table class="table table-bordered table-striped">            
	<thead>       
	<tr>       
	<th>SNO</th>  
	<th>Employee Name</th>     
	<th>Commission(<?php echo $commission['employee_commission']; ?> Per Gram)</th>     
	<th>Email</th>    
	<th>Mobile</th>    
	<th>Promoters</th>  
	</tr>       
	</thead>   
	<tbody>
	<?php	
	if(!empty($records)){
	foreach($records as $key => $row){ 
	?> 
	<tr class="text-center">
	<td><?php echo $key+1; ?></td>
	<td>
	<?php echo $row['name']; ?>
	</td>
	<td>
	<b>Total Weight : </b><?php echo $row['weight']; ?><br>
	<b>Commission : </b><?php echo $row['weight']*$commission['employee_commission']; ?>
	</td>
	<td>
	<?php echo $row['email']; ?>
	</td>
	<td>
	<?php echo $row['mobile']; ?>
	</td>
	<td>
	<button type="button" class="btn btn-sm btn-primary" onclick="getPromoters('<?php echo $row['unique_code']; ?>')">promoters</button>
	</td>
	</tr>
	<tr class="promoters" id="pro_<?php echo $row['unique_code']; ?>" style="display:none;">
	<td colspan="6">
	<?php	
	if(!empty($row['promoters'])){
	?> 
	<table class="table table-bordered table-striped">            
	<thead class="bg-primary">       
	<tr>       
	<th>SNO</th>  
	<th>Promoter Name</th>     
	<th>Commission(<?php echo $commission['promoter_commission']; ?> Per Gram)</th>     
	<th>Coupon code</th>    
	<th>Email</th>    
	<th>Mobile</th>    
	<th>Sales</th>  
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($row['promoters'] as $pkey => $prow){ 
	?> 
	<tr class="text-center">
	<td><?php echo $pkey+1; ?></td>
	<td>
	<?php echo $prow['name']; ?>
	</td>
	<td>
	<b>Total Weight : </b><?php echo $prow['weight']; ?><br>
	<b>Commission : </b><?php echo $prow['weight']*$commission['promoter_commission']; ?>
	</td>
	<td>
	<?php echo $prow['unique_code']; ?>
	</td>
	<td>
	<?php echo $prow['email']; ?>
	</td>
	<td>
	<?php echo $prow['mobile']; ?>
	</td>
	<td>
	<button type="button" class="btn btn-sm btn-success" onclick="getSales('<?php echo $prow['unique_code']; ?>')">Sales</button>
	</td>
	</tr>
	<tr class="sales" id="sales_<?php echo $prow['unique_code']; ?>" style="display:none;">
	<td colspan="7">
	<?php	
	if(!empty($prow['orders'])){
	?> 
	<table class="table table-bordered table-striped">          
	<thead class="bg-success">       
	<tr>       
	<th>SNO</th>  
	<th>Buyer Details</th>     
	<th>Coupon Code</th>      
	<th>Total Amount</th>      
	<th>Discount Amount</th>      
	<th>Download</th>    
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($prow['orders'] as $okey => $orow){ 
	?> 
	<tr class="text-center">
	<td><?php echo $okey+1; ?></td>
	<td>
	<?php echo $orow['buyer_name']; ?><br>
	<?php echo $orow['buyer_mobile']; ?><br>
	<?php echo $orow['buyer_email']; ?>
	</td>
	<td>
	<?php echo $orow['coupon_code']; ?>
	</td>
	<td>
	<?php echo $orow['final_amount']; ?>
	</td>
	<td>
	<?php echo $orow['coupon_amount']; ?>
	</td>
	<td>
	<a target="_blank" href="<?php echo base_url(); ?>admin/casted_gold_sales_download_admin?id=<?php echo $orow['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Admin Invoice</a><br><br>
	<a target="_blank" href="<?php echo base_url(); ?>admin/casted_gold_sales_download_customer?id=<?php echo $orow['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Customer Invoice</a><br><br>
	<a target="_blank" href="<?php echo base_url(); ?>admin/casted_gold_sales_download_pickup?id=<?php echo $orow['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Pickup Invoice</a>
	</td>
	</tr>
	<?php }  ?>
	</tbody>
	</table>
	<?php }  ?>
	</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	<?php }} ?>
	</td>
	</tr>
	</tbody>
	</table>
</div>	

<script>
	function getPromoters(uid){
		$(".promoters").hide();
		$("#pro_"+uid).css("display","table-row");	
	}
	function getSales(uid){
		$(".sales").hide();
		$("#sales_"+uid).css("display","table-row");	
	}
</script>