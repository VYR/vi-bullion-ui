<style>
    .pbtn{
        background-color:#262524;
    }
    .pbtn1{
        background-color:#393938;
    }
    .pbtn2{
        background-color:#686868;
    }
    .bgdark{
        background-color:#524528;
        color:#fff !important;
    }
	label{
        color:#fff !important;
	}
</style>
<form id="orders_form" method="post">  
	<div class="row register-form">
	<div class="col-md-4">
	<div class="form-group">
	<label for="email">From:</label>
	<input type="text" id="from_date" name="from_date" class="form-control datepicker" value="<?php echo date("Y-m-d", strtotime($from_date)); ?>" required>
	<input type="hidden" name="type" value="<?php echo $type; ?>">
	<input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
	</div>
	</div>
	<div class="col-md-4">
	<div class="form-group">
	<label for="email">To:</label>
	<input type="text" id="to_date" name="to_date" class="form-control datepicker" value="<?php echo date("Y-m-d", strtotime($to_date)); ?>" required>
	</div>
	</div>
	<div class="col-md-4">
	<label for="email">Search:</label>
	<button type="submit" id="order_btn" class="btn btn-block silver-btn">SEARCH</button> 
	</div>
	</div>
</form>
<?php if($type ==0){ ?>
<div class="table-responsive">
	<?php	
	if(!empty($records)){
	?> 
	<table class="table table-bordered table-striped">            
	<thead class="nbg3 text-white">       
	<tr>       
	<th>SNO</th>  
	<th>Corporate Name</th>     
	<th>Commission(<?php echo $commission['employee_commission']; ?> Per Gram)</th>     
	<th>Email</th>    
	<th>Mobile</th>    
	<th>Promoters</th>  
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($records as $key => $row){ 
	?> 
	<tr class="text-center text-white">
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
	<button type="button" class="btn btn-sm silver-btn" onclick="getPromoters('<?php echo $row['unique_code']; ?>')">promoters</button>
	</td>
	</tr>
	<tr class="promoters" id="pro_<?php echo $row['unique_code']; ?>" style="display:none;">
	<td colspan="6">
	<?php	
	if(!empty($row['promoters'])){
	?> 
	<table class="table table-bordered table-striped">            
	<thead class="nbg3 text-white">       
	<tr>       
	<th>SNO</th>  
	<th>Promoter Name</th>     
	<th>Commission(<?php echo $commission['promoter_commission']; ?>)</th>     
	<th>Coupon code</th>    
	<th>Email</th>    
	<th>Mobile</th>    
	<th>Promoters</th>  
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($row['promoters'] as $pkey => $prow){ 
	?> 
	<tr class="text-center text-white">
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
	<button type="button" class="btn btn-sm silver-btn" onclick="getSales('<?php echo $prow['unique_code']; ?>')">Sales</button>
	</td>
	</tr>
	<tr class="sales" id="sales_<?php echo $prow['unique_code']; ?>" style="display:none;">
	<td colspan="7">
	<?php	
	if(!empty($prow['orders'])){
	?> 
	<table class="table table-bordered table-striped">          
	<thead class="nbg3 text-white">       
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
	<tr class="text-center text-white">
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
	<a target="_blank" href="<?php echo base_url(); ?>casted_silver_sales_download_admin?id=<?php echo $orow['id']; ?>" class="btn btn-sm silver-btn"><i class="fa fa-download"></i> Download</a>
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
	<?php } ?>
	</td>
	</tr>
	</tbody>
	</table>
	<?php }else{ ?>
	<h4 class="text-center text-danger">No Data Found</h4>
	<?php } ?>
</div>	
<?php }else{ ?>
<div class="table-responsive">
	<?php	
	if(!empty($records)){
	?> 
	<table class="table table-bordered table-striped">            
	<thead class="nbg3 text-white">        
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
	foreach($records as $pkey => $prow){ 
	?> 
	<tr class="text-center text-white">
	<td><?php echo $pkey+1; ?></td>
	<td>
	<?php echo $prow['name']; ?>
	</td>
	<td>
	<b>Total Sales : </b><?php echo $prow['sales']; ?><br>
	<b>Commission : </b><?php echo ($prow['sales']*$commission['promoter_commission'])/100; ?>
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
	<button type="button" class="btn btn-sm silver-btn" onclick="getSales('<?php echo $prow['unique_code']; ?>')">Sales</button>
	</td>
	</tr>
	<tr class="sales" id="sales_<?php echo $prow['unique_code']; ?>" style="display:none;">
	<td colspan="7">
	<?php	
	if(!empty($prow['orders'])){
	?> 
	<table class="table table-bordered table-striped">          
	<thead class="nbg3 text-white">       
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
	<tr class="text-center text-white">
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
	<a target="_blank" href="<?php echo base_url(); ?>casted_silver_sales_download_admin?id=<?php echo $orow['id']; ?>" class="btn btn-sm silver-btn"><i class="fa fa-download"></i> Download</a>
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
	<?php }else{ ?>
	<h4 class="text-center text-danger">No Data Found</h4>
	<?php } ?>
</div>	
<?php } ?>

<script>
	function getPromoters(uid){
		$(".promoters").hide();
		$("#pro_"+uid).css("display","table-row");	
	}
	function getSales(uid){
		$(".sales").hide();
		$("#sales_"+uid).css("display","table-row");	
	}
	
	$(document).ready(function(){		
		$("#orders_form").on("submit", function(e){
		e.preventDefault();	
		$("#orders_form #order_btn").attr('disabled',true);
		$("#orders_form #order_btn").text('Please Wait...');
		$.ajax({  
		type: "POST",    
		dataType: "html",    
		url: "<?php echo site_url(); ?>casted_silver_dashboard_ajax",    
		data: $("#orders_form").serialize()})
		.done(function(data){
			$("#orders_div").html(data);
		});
		$("#orders_form #order_btn").attr('disabled',false);
		$("#orders_form #order_btn").text('SEARCH');
		});	
	});	
</script>
<script src="<?php echo site_url(); ?>assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd'
    })
</script>