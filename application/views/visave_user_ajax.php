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
<div class="table-responsive">
	<table class="table table-bordered table-striped">            
		<thead class="nbg2 text-white">       
		<tr>      
			<?php if($type ==0){ ?>
			<th>Category</th>  
			<?php }else{ ?>
			<th>Group</th> 
			<?php } ?>
			<th>Promoter</th>  
			<th>User Details</th>  
			<th>Joining Date</th>  
			<th>Fixed Gold price</th>  
			<th>Action</th>  
		</tr>       
		</thead>   
		<tbody>		
			<tr class="text-center text-white">
				<?php if($type ==0){ ?>
				<td>
				<?php echo $record['category_name']; ?><br>
				<?php echo $record['sub_category_name']; ?>
				</td>
				<?php }else{ ?>
				<td><?php echo $record['group_name']; ?></td>
				<?php } ?>
				<td><?php echo $record['promoter_name']; ?></td>
				<td>
				<?php echo $record['name']; ?><br>
				<?php echo $record['mobile']; ?><br>
				<?php echo $record['email']; ?>
				</td>
				<td><?php echo date("Y-m-d",strtotime($record['joining_date'])); ?></td>
				<td>
					<?php if($record['fixed_gold_price_status']==1) { ?>
					<?php echo $record['fixed_gold_price']; ?>
					<?php } ?>
				</td>
				<td>
				<button type="button" class="btn btn-sm abt-btn" onclick="getPayments('<?php echo $record['unique_code']; ?>')">View</button>
				</td>
			</tr>
			<tr class="promoters" id="pro_<?php echo $record['unique_code']; ?>" style="display:none;">
				<td colspan="6">
					<?php if(!empty($lucky_draw)){ ?> 
					<h3 class="text-white">Lucky Draw</h3>	
					<table class="table table-bordered table-striped">            
						<thead class="nbg2 text-white">      
							<tr>       
								<th>SNO</th>  
								<th>Month</th>  
								<th>User</th>  
							</tr>       
						</thead>   
						<tbody>
							<?php foreach($lucky_draw as $key => $row){ ?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("M Y",strtotime($row['month'])); ?></td>
								<td>
									<div><?php echo $row['user_name']; ?></div>
									<div><?php echo $row['user_mobile']; ?></div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php } ?>
					<h3 class="text-white">Total Payments</h3>	
					<table class="table table-bordered table-striped">            
						<thead class="nbg2 text-white">      
							<tr>       
								<th>SNO</th>  
								<th>Date</th>  
								<th>Amount</th>  
								<th>Payment Details</th>  
							</tr>       
						</thead>   
						<tbody>
							<?php	
							$total_payments=array();
							if(count($payments) > 0){
							foreach($payments as $key => $row){ 
							if($row['payment_status']==1){
							$total_payments[]=$row['amount'];
							}
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row['payment_date'])); ?></td>
								<td><?php echo $row['amount']; ?></td>
								<td>
								<?php if($row['payment_status']==0){ ?>
									<a href="" class="btn btn-sm btn-success">Pay Now</a>
								<?php }else{ ?>
								<b class="text-danger">Paid</b>
								<?php } ?>
								</td>
							</tr>
							<?php }  }  ?>
						</tbody>
					</table>
					<h3 class="text-white">Total Bonus</h3>	
					<table class="table table-bordered table-striped">            
						<thead class="nbg2 text-white">       
							<tr>       
								<th>SNO</th>  
								<th>Date</th>  
								<th>Amount</th>  
							</tr>       
						</thead>   
						<tbody>
							<?php	
							$total_bonus=array();
							if(count($bonus) > 0){
							foreach($bonus as $key => $row){ 
							$total_bonus[]=$row['amount'];
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row['payment_date'])); ?></td>
								<td><?php echo $row['amount']; ?></td>
							</tr>
							<?php }  }  ?>
						</tbody>
					</table>
					<h3 class="text-white">Total Penalties</h3>	
					<table class="table table-bordered table-striped">            
						<thead class="nbg2 text-white">    
							<tr>       
								<th>SNO</th>  
								<th>Date</th>  
								<th>Amount</th>  
							</tr>       
						</thead>   
						<tbody>
							<?php	
							$total_penalties=array();
							if(count($penalties) > 0){
							foreach($penalties as $key => $row){ 
							$total_penalties[]=$row['amount'];
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row['payment_date'])); ?></td>
								<td><?php echo $row['amount']; ?></td>
							</tr>
							<?php }  }  ?>
						</tbody>
					</table>
					<h3 class="text-white">Total Payments</h3>		
					<table class="table table-bordered table-striped">      
						<tbody>
							<tr class="text-center text-white">    
								<th>Payments (A)</th>  
								<th><?php echo round(array_sum($total_payments)); ?></th>  
							</tr> 
							<tr class="text-center text-white">    
								<th>Bonus (B)</th>  
								<th><?php echo round(array_sum($total_bonus)); ?></th>  
							</tr>
							<tr class="text-center text-white">     
								<th>Penalties (C)</th>  
								<th><?php echo round(array_sum($total_penalties)); ?></th>  
							</tr> 
							<tr class="text-center text-white">    
								<th>Total (A+B)-C</th>  
								<th><?php echo (round(array_sum($total_payments))+round(array_sum($total_bonus)))-round(array_sum($total_penalties)); ?></th>  
							</tr>       
						</tbody>  
				  </table>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<script>
	function getPayments(uid){
		$(".promoters").hide();
		$("#pro_"+uid).css("display","table-row");	
	}	
	$(document).ready(function(){		
		$("#orders_form").on("submit", function(e){
		e.preventDefault();	
		$("#orders_form #order_btn").attr('disabled',true);
		$("#orders_form #order_btn").text('Please Wait...');
		$.ajax({  
		type: "POST",    
		dataType: "html",    
		url: "<?php echo site_url(); ?>visave_user_ajax",    
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