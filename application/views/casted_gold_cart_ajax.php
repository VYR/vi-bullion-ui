
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead class="nbg2 text-white">
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
				if(!empty($products)){
				foreach($products as $key => $row){ 
				$qty=0;				
				if(!empty($cart_products)){
				foreach($cart_products as $key1 => $row1){ 
					if($row1['pid']==$row['id']){
						$qty=$row1['qty'];
					}
				}}
				$purity_amount=($row['purity_percentage']*$casted_value)/100;
				$price2=$casted_value-$purity_amount;
				$final_price=$price2*$row['weight'];
				$product_total=$final_price*$qty;
				$sub_total=$sub_total+$product_total;
				$product_weight=$row['weight']*$qty;
				$total_weight=$total_weight+$product_weight;
				?>
				<tr class="text-white <?php if($qty>0){ echo 'nbg2'; } ?>">
					<td><?php echo $key+1; ?></td>
					<td><img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $row['image']; ?>" alt="<?php echo $row['image_alt']; ?>" class="mr-2" style="max-width:100px;max-height:100px;"><?php echo $row['name']; ?> </td>
					<td><?php echo $row['weight']; ?> Gms</td>
					<td>Rs.<?php echo round($final_price,2); ?></td>
					<td>
						<div class="input-group" style="width:100px;">
						<div class="input-group-prepend">
						<button class="btn btn-sm btn-danger" type="button" onclick="decrementQuantity(<?php echo $row['id']; ?>)"><i class="fa fa-minus"></i></button>
						</div>
						<input type="text" id="qty_<?php echo $row['id']; ?>" class="form-control form-control-sm" value="<?php echo $qty; ?>" readonly="">
						<div class="input-group-append">
						<button class="btn btn-sm btn-success" type="button" onclick="incrementQuantity(<?php echo $row['id']; ?>)"><i class="fa fa-plus"></i></button>
						</div>
						</div>
					</td>
					<td><?php echo $product_weight; ?> Gms</td>
					<td>Rs.<?php echo round($product_total,2); ?></td>
				</tr>
				<?php }} ?>	
			</tbody>				
		</table>				
	</div>				
	<div class="text-right mt-3 text-white">	
		<h3>TOTAL : Rs.<?php echo round($sub_total,2); ?></h3>
	</div>	
	<div class="text-center">	
		<?php 
			$deposit=$total_weight*$home_content['casted_gold_deposit'];
			$available_grams=$urecord['deposit_amount']/$home_content['casted_gold_deposit'];
			if($sub_total>0 && $urecord['deposit_amount']>=$deposit){
		?>	
		<a href="<?php echo site_url(); ?>casted-gold-checkout" class="btn abt-btn">Book Now</a> 
		<?php }else{ ?>	
		<?php if($available_grams>0){ ?>	
		<h3 class="text-danger">Max <?php echo $available_grams; ?> gms allowed for booking</h3>
		<?php }else{ ?>	
		<h3 class="text-danger">Booking not available</h3>
		<?php } ?>	
		<?php } ?>	
	</div>				