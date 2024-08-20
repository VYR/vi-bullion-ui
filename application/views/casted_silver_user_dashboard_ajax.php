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
<?php if(!empty($records)){ ?>
<div class="table-responsive">
	<table class="table table-bordered table-striped">          
	<thead class="nbg3 text-white">       
	<tr>       
	<th>SNO</th>  
	<th>Buyer Details</th>    
	<th>Total Amount</th>      
	<th>Total Weight</th>      
	<th>Pickup Details</th>     
	</tr>       
	</thead>   
	<tbody>
	<?php	
	foreach($records as $okey => $orow){ 
	?> 
	<tr class="text-center text-white">
	<td><?php echo $okey+1; ?></td>
	<td>
	<?php echo $orow['buyer_name']; ?><br>
	<?php echo $orow['buyer_mobile']; ?><br>
	<?php echo $orow['buyer_email']; ?>
	</td>
	<td>
	<?php echo $orow['final_amount']; ?>
	</td>
	<td>
	<?php echo $orow['total_weight']; ?> Gms
	</td>
	<td>
		<?php if($orow['order_status']==0){ ?>
		<b class="text-danger">Pending</b>
		<?php }else if($orow['order_status']==1){ ?>
		<div><?php echo $orow['pickup_state']; ?></div>
		<div><?php echo $orow['pickup_state_code']; ?></div>
		<div><?php echo $orow['pickup_dealer_address']; ?></div>
		<div><?php echo $orow['time']; ?></div>
		<?php }else{ ?>
		<b class="text-danger">Cancelled</b>
		<?php }  ?>
	</td>
	</tr>
	<?php }  ?>
	</tbody>
	</table>
</div>	
<?php }else{ ?>
<h4 class="text-center text-danger">No Data Found</h4>
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
		url: "<?php echo site_url(); ?>casted_silver_user_dashboard_ajax",    
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