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
	<label for="email">Heading:</label>
	<select class="form-control" id="heading" name="heading" required>
		<option value="">Select Heading</option>
		<?php $date1=date("Y-m-01"); ?>
		<?php $date2=date("Y-m-01",strtotime("-1 months")); ?>
		<option value="<?php echo $date1; ?>" <?php if($heading==$date1){ echo 'selected'; } ?>><?php echo date("M Y"); ?></option>
		<option value="<?php echo $date2; ?>" <?php if($heading==$date2){ echo 'selected'; } ?>><?php echo date("M Y",strtotime("-1 months")); ?></option>
	</select>
	<input type="hidden" name="type" value="<?php echo $type; ?>">
	<input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
	</div>
	</div>
	<div class="col-md-4">
	<label for="email">Search:</label>
	<button type="submit" id="order_btn" class="btn btn-block abt-btn">SEARCH</button> 
	</div>
	</div>
</form>
<?php if($type ==0){ ?>
<div class="table-responsive">
	<?php	
	if(!empty($records)){
	?> 
	<table class="table table-bordered table-striped">            
	<thead class="nbg2 text-white">       
	<tr>       
	<th>SNO</th>  
	<th>Name</th>     
	<th>Mobile</th>       
	<th>Email</th>  
	<th>Commission(<?php echo $drecord['pro_percentage'] ?>%)</th>    
	<th>Vi Super</th>  
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
	<?php echo $row['mobile']; ?>
	</td>
	<td>
	<?php echo $row['email']; ?>
	</td>
	<td>
	<?php echo $pro_amount['total_pro_amount']; ?>
	</td>
	<td>
	<button type="button" class="btn btn-sm abt-btn" onclick="getPromoters('<?php echo $row['unique_code']; ?>')">View</button>
	</td>
	</tr>
	<tr class="promoters" id="pro_<?php echo $row['unique_code']; ?>" style="display:none;">
	<td colspan="6">
	<?php	
	if(!empty($super_records)){
	?> 
	<table class="table table-bordered table-striped">            
	<thead class="nbg2 text-white">       
	<tr>       
	<th>SNO</th>  
	<th>Name</th>      
	<th>Mobile</th>    
	<th>Email</th>    
	<th>Commission(<?php echo $drecord['super_percentage'] ?>%)</th>   
	<th>Payments</th>  
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($super_records as $pkey => $prow){ 
	?> 
	<tr class="text-center text-white">
	<td><?php echo $pkey+1; ?></td>
	<td>
	<?php echo $prow['name']; ?>
	</td>
	<td>
	<?php echo $prow['mobile']; ?>
	</td>
	<td>
	<?php echo $prow['email']; ?>
	</td>
	<td>
	<?php echo $prow['super_amount']['total_super_amount']; ?>
	</td>
	<td>
	<button type="button" class="btn btn-sm abt-btn" onclick="getSales('<?php echo $prow['unique_code']; ?>')">View</button>
	</td>
	</tr>
	<tr class="sales" id="sales_<?php echo $prow['unique_code']; ?>" style="display:none;">
	<td colspan="7">
	<?php	
	if(!empty($prow['super_payments'])){
	?> 
	<table class="table table-bordered table-striped">          
	<thead class="nbg2 text-white">       
	<tr>       
	<th>SNO</th>  
	<th>Date</th>     
	<th>Fixed Amount</th>      
	<th>Rate/Gram</th>      
	<th>Total Grams</th>      
	<th>Commission</th>    
	<th>Amount</th>    
	<th>Pro Amount</th>    
	<th>Super Amount</th>    
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($prow['super_payments'] as $okey => $orow){ 
	?> 
	<tr class="text-center text-white">
	<td><?php echo $okey+1; ?></td>
	<td>
	<?php echo date("d-m-Y",strtotime($orow['date'])); ?>
	</td>
	<td>
	<?php echo $orow['fixed_amount']; ?>
	</td>
	<td>
	<?php echo $orow['rate_per_gram']; ?>
	</td>
	<td>
	<?php echo $orow['total_grams']; ?>
	</td>
	<td>
	<?php echo $orow['commission']; ?>
	</td>
	<td>
	<?php echo $orow['amount']; ?>
	</td>
	<td>
	<?php echo $orow['pro_amount']; ?>
	</td>
	<td>
	<?php echo $orow['super_amount']; ?>
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
	if(!empty($super_records)){
	?> 
	<table class="table table-bordered table-striped">            
	<thead class="nbg2 text-white">        
	<tr>     
	<th>SNO</th>  
	<th>Name</th>      
	<th>Mobile</th>    
	<th>Email</th>    
	<th>Commission</th>   
	<th>Payments</th>  
	</tr>        
	</thead>   
	<tbody>
	<?php	
	foreach($super_records as $pkey => $prow){ 
	?> 
	<tr class="text-center text-white">
	<td><?php echo $pkey+1; ?></td>
	<td>
	<?php echo $prow['name']; ?>
	</td>
	<td>
	<?php echo $prow['mobile']; ?>
	</td>
	<td>
	<?php echo $prow['email']; ?>
	</td>
	<td>
	<?php echo $prow['super_amount']['total_super_amount']; ?>
	</td>
	<td>
	<button type="button" class="btn btn-sm abt-btn" onclick="getSales('<?php echo $prow['unique_code']; ?>')">View</button>
	</td>
	</tr>
	<tr class="sales" id="sales_<?php echo $prow['unique_code']; ?>" style="display:none;">
	<td colspan="7">
	<?php	
	if(!empty($prow['super_payments'])){
	?> 
	<table class="table table-bordered table-striped">          
	<thead class="nbg2 text-white">       
	<tr>       
	<th>SNO</th>  
	<th>Date</th>     
	<th>Fixed Amount</th>      
	<th>Rate/Gram</th>      
	<th>Total Grams</th>      
	<th>Commission</th>    
	<!--<th>Amount</th>    
	<th>Pro Amount</th>-->    
	<th>Super Amount</th>    
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($prow['super_payments'] as $okey => $orow){ 
	?> 
	<tr class="text-center text-white">
	<td><?php echo $okey+1; ?></td>
	<td>
	<?php echo date("d-m-Y",strtotime($orow['date'])); ?>
	</td>
	<td>
	<?php echo $orow['fixed_amount']; ?>
	</td>
	<td>
	<?php echo $orow['rate_per_gram']; ?>
	</td>
	<td>
	<?php echo $orow['total_grams']; ?>
	</td>
	<td>
	<?php echo round($orow['super_amount']/$orow['total_grams'],2); ?>
	</td>
	<!--<td>
	<?php echo $orow['amount']; ?>
	</td>
	<td>
	<?php echo $orow['pro_amount']; ?>
	</td>-->
	<td>
	<?php echo $orow['super_amount']; ?>
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
		url: "<?php echo site_url(); ?>vi_authority_ajax",    
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