	<div class="table-responsive">
		<table class="table table-bordered text-white">
			<thead class="nbg3">
			<tr>
			<th>Sno</th>
			<th>Product</th>
			<th>Weight</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total Weight</th>
			<th>Total Amount</th>
			</tr>
			</thead>
			<tbody>	
				<?php
				$total_weight=0;
				$sub_total=0;			
				$i=0;		
				if(!empty($products)){
				foreach($products as $key => $row){ 
				$qty=0;				
				$display=0;			
				if(!empty($cart_products)){
				foreach($cart_products as $key1 => $row1){ 
					if($row1['pid']==$row['id']){
						$qty=$row1['qty'];
						$display=1;
					}
				}}
				if($display==1){
				$i++;
				$purity_amount=($row['purity_percentage']*$casted_value)/100;
				$price2=$casted_value-$purity_amount;
				$final_price=$price2*$row['weight'];
				$product_total=$final_price*$qty;
				$sub_total=$sub_total+$product_total;
				$product_weight=$row['weight']*$qty;
				$total_weight=$total_weight+$product_weight;
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><img src="<?php echo base_url(); ?>assets/images/casted_silver/<?php echo $row['image']; ?>" alt="<?php echo $row['image_alt']; ?>" class="mr-2" style="max-width:100px;max-height:100px;"><?php echo $row['name']; ?> </td>
					<td><?php echo $row['weight']; ?> Gms</td>
					<td>Rs.<?php echo round($final_price,2); ?></td>
					<td>
						<?php echo $qty; ?>
					</td>
					<td><?php echo $product_weight; ?> Gms</td>
					<td>Rs.<?php echo round($product_total,2); ?></td>
				</tr>
				<?php }}} ?>	
			</tbody>				
		</table>				
	</div>				
	<div class="text-right mt-3 text-white">	
		<h3>TOTAL : Rs.<?php echo round($sub_total,2); ?></h3>
	</div>	
	<div class="row">	
		<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Promoter ID <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="promoter_id" name="promoter_id" placeholder="Enter Promoter ID" onkeyup="get_casted_promoter()" autocomplete="off" value="<?php if(!empty($promoter)){ echo $promoter['unique_code']; } ?>" required>
		</div>
		<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Promoter Name <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="promoter_name" name="promoter_name" placeholder="Enter Promoter Name" value="<?php if(!empty($promoter)){ echo $promoter['name']; } ?>" readonly>
		</div>
		<div class="col-md-3 form-group text-white">
			<label for="cat_slno" class="control-label">After Discount</label><br>
			<?php 
				$discount=0;
				if(!empty($promoter)){
					$discount=$total_weight*$home_content['casted_silver_discount'];
				}
				$grand_total=$sub_total-$discount;
			?>	
			<h3 class="mb-0">Rs.<?php echo round($grand_total,2); ?></h3>
		</div>		
		<div class="col-md-3 form-group"><br>	
			<button type="button" class="btn silver-btn" onclick="showSubmit()">Confirm</button> 		
		</div>				
	</div>			
	<div class="text-center mt-3 text-white" id="submit_div" style="display:none;">	
		<h5 class="mb-3">Dear <?php echo $urecord['name']; ?>, Your order for <?php echo $total_weight; ?> Gms for the amount of Rs.<?php echo round($grand_total,2); ?>/- If ok click submit to complete order.</h5>		
		<button type="button" id="submit_btn" class="btn silver-btn" onclick="submitOrder()">Submit</button> 	
	</div>	