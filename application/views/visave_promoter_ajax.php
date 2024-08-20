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
			<th>Promoter Details</th> 
			<th>Commission</th>  
		</tr>       
		</thead>   
		<tbody>	
			<tr class="text-center text-white">
				<td>
				<?php echo $record['name']; ?><br>
				<?php echo $record['mobile']; ?><br>
				<?php echo $record['email']; ?>
				</td>
				<td><?php echo $record['commission']; ?>%</td>
			</tr>
		</tbody>
	</table>
</div>
<!--
<h3 class="text-white">Individual Users</h3>
<?php if(!empty($urecords)){ ?> 	
<div class="table-responsive">
	<table class="table table-bordered table-striped">            
		<thead class="nbg2 text-white">       
		<tr>      
			<th>Category</th> 
			<th>User Details</th>  
			<th>Joining Date</th>  
			<th>Fixed Gold price</th>  
			<th>Commission</th>  
			<th>Action</th>  
		</tr>       
		</thead>   
		<tbody>	
			<?php 
				foreach($urecords as $key => $row){
				$commission_array=array();
				if(!empty($row['payments'])){
				foreach($row['payments'] as $key => $row1){ 
					if($row1['payment_status']==1){
						$commission_array[]=$row1['amount'];
					}
				}}
				$commission=0;
				if(!empty($commission_array)){
					$commission=round(($record['commission']*array_sum($commission_array))/100);
				}
			?> 	
			<tr class="text-center text-white">
				<td>
				<?php echo $row['category_name']; ?><br>
				<?php echo $row['sub_category_name']; ?>
				</td>
				<td>
				<?php echo $row['name']; ?><br>
				<?php echo $row['mobile']; ?><br>
				<?php echo $row['email']; ?>
				</td>
				<td><?php echo date("Y-m-d",strtotime($row['joining_date'])); ?></td>
				<td>
					<?php if($row['fixed_gold_price_status']==1) { ?>
					<?php echo $row['fixed_gold_price']; ?>
					<?php } ?>
				</td>
				<td><?php echo $commission; ?></td>
				<td>
				<button type="button" class="btn btn-sm abt-btn" onclick="getPayments('<?php echo $row['id']; ?>')">View</button>
				</td>
			</tr>
			<tr class="promoters" id="pro_<?php echo $row['id']; ?>" style="display:none;">
				<td colspan="6">
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
							if(!empty($row['payments'])){
							foreach($row['payments'] as $key => $row1){ 
							if($row1['payment_status']==1){
							$total_payments[]=$row1['amount'];
							}
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row1['payment_date'])); ?></td>
								<td><?php echo $row1['amount']; ?></td>
								<td>
								<?php if($row1['payment_status']==0){ ?>
									<b class="text-danger"> Not Paid</b>
								<?php }else{ ?>
									<b class="text-success">Paid</b>
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
							if(!empty($row['bonus'])){
							foreach($row['bonus'] as $key2 => $row2){ 
							$total_bonus[]=$row2['amount'];
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row2['payment_date'])); ?></td>
								<td><?php echo $row2['amount']; ?></td>
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
							if(!empty($row['penalties'])){
							foreach($row['penalties'] as $key3 => $row3){ 
							$total_penalties[]=$row3['amount'];
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row3['payment_date'])); ?></td>
								<td><?php echo $row3['amount']; ?></td>
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
			<?php } ?>
		</tbody>
	</table>
</div>
<?php }else{ ?>
<h4 class="text-center text-danger">No Data Found</h4>
<?php } ?>
-->

<h3 class="text-white">Group Users</h3>
<?php if(!empty($grecords)){ ?> 	
<div class="table-responsive">
	<table class="table table-bordered table-striped">            
		<thead class="nbg2 text-white">       
		<tr>      
			<th>Group</th> 
			<th>User Details</th>  
			<th>Joining Date</th>  
			<th>Fixed Gold price</th>  
			<th>Commission</th>  
			<th>Action</th>  
		</tr>       
		</thead>   
		<tbody>	
			<?php 
				foreach($grecords as $key => $row){
				$commission_array=array();
				if(!empty($row['payments'])){
				foreach($row['payments'] as $key => $row1){ 
					if($row1['payment_status']==1){
						$commission_array[]=$row1['amount'];
					}
				}}
				$commission=0;
				if(!empty($commission_array)){
					$commission=round(($record['commission']*array_sum($commission_array))/100);
				}
			?> 	
			<tr class="text-center text-white">
				<td><?php echo $row['group_name']; ?></td>
				<td>
				<?php echo $row['name']; ?><br>
				<?php echo $row['mobile']; ?><br>
				<?php echo $row['email']; ?>
				</td>
				<td><?php echo date("Y-m-d",strtotime($row['joining_date'])); ?></td>
				<td>
					<?php if($row['fixed_gold_price_status']==1) { ?>
					<?php echo $row['fixed_gold_price']; ?>
					<?php } ?>
				</td>
				<td><?php echo $commission; ?></td>
				<td>
				<button type="button" class="btn btn-sm abt-btn" onclick="getPayments('<?php echo $row['id']; ?>')">View</button>
				</td>
			</tr>
			<tr class="promoters" id="pro_<?php echo $row['id']; ?>" style="display:none;">
				<td colspan="6">
					<?php if(!empty($row['lucky_draw'])){ ?> 
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
							<?php foreach($row['lucky_draw'] as $key => $row){ ?> 
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
							if(!empty($row['payments'])){
							foreach($row['payments'] as $key => $row1){ 
							if($row1['payment_status']==1){
							$total_payments[]=$row1['amount'];
							}
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row1['payment_date'])); ?></td>
								<td><?php echo $row1['amount']; ?></td>
								<td>
								<?php if($row1['payment_status']==0){ ?>
									<b class="text-danger"> Not Paid</b>
								<?php }else{ ?>
									<b class="text-success">Paid</b>
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
							if(!empty($row['bonus'])){
							foreach($row['bonus'] as $key2 => $row2){ 
							$total_bonus[]=$row2['amount'];
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row2['payment_date'])); ?></td>
								<td><?php echo $row2['amount']; ?></td>
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
							if(!empty($row['penalties'])){
							foreach($row['penalties'] as $key3 => $row3){ 
							$total_penalties[]=$row3['amount'];
							?> 
							<tr class="text-center text-white">
								<td><?php echo $key+1; ?></td>
								<td><?php echo date("Y-m-d",strtotime($row3['payment_date'])); ?></td>
								<td><?php echo $row3['amount']; ?></td>
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
			<?php } ?>
		</tbody>
	</table>
</div>
<?php }else{ ?>
<h4 class="text-center text-danger">No Data Found</h4>
<?php } ?>

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