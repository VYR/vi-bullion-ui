
<?php	
	if(!empty($categories)){
	foreach($categories as $key => $row){ 
	$pcol='col-md-12';
	if($row['products_display_count']=='2'){
	$pcol='col-md-6';
	}else if($row['products_display_count']=='3'){
	$pcol='col-md-4';
	}else if($row['products_display_count']=='4'){
	$pcol='col-md-3';
	}
	$acol='col-md-12';
	if($row['ads_display_count']=='2'){
	$acol='col-md-6';
	}else if($row['ads_display_count']=='3'){
	$acol='col-md-4';
	}else if($row['ads_display_count']=='4'){
	$acol='col-md-3';
	}
?> 
<h3 class="text-center text-white"><?php echo $row['name']; ?></h3>
<div class="row">	
<?php	
	if(!empty($row['products'])){
	foreach($row['products'] as $key1 => $row1){ 
	$price1=$minted_value*$row1['weight'];
	$price2=$price1*$row1['add_value'];
	$gst=($crecord['gst']*$price2)/100;
	$final_price=$price2+$gst;
?> 
<div class="<?php echo $pcol; ?> col-sm-6 mb-3">
	<div class="p-3 border nbr2 rounded text-center text-white">
		<h5><?php echo $row1['name']; ?></h5>
		<img src="<?php echo base_url(); ?>assets/images/minted/<?php echo $row1['image']; ?>" alt="<?php echo $row1['image_alt']; ?>" style="max-width:100%;">
		<!--<div class="row text-center py-2 f18">
			<div class="col-4">
				<?php echo $row1['weight']; ?>g
			</div>
			<div class="col-4">
				Rs.<?php echo $row1['mrp']; ?>/-
			</div>
			<div class="col-4">
				Rs.<?php echo round($final_price,2); ?>/-
			</div>
		</div>-->
		<div class="f18 py-2">
			<div>
				<?php echo $row1['weight']; ?>g				
			</div>		
			<div class="px-3 d-none">
				Rs.<?php echo $row1['mrp']; ?>/-			
			</div>		
			<div>
				Rs.<?php echo round($final_price,2); ?>/-			
			</div>		
		</div>		
		<div class="text-center">
		<a href="javascript:void(0)" onclick="addCart(<?php echo $row1['id']; ?>)" class="btn buy-btn">Buy Now</a>
		</div>
	</div>
</div>
<?php }}  ?>	
</div>
<div class="row">	
<?php	
	if(!empty($row['ads'])){
	foreach($row['ads'] as $key2 => $row2){ 
?> 
<div class="<?php echo $acol; ?> col-sm-6 mb-3">
	<?php if($row2['ad_type']=='0'){ ?> 
	<img src="<?php echo base_url(); ?>assets/images/minted/<?php echo $row2['image']; ?>" alt="<?php echo $row2['image_alt']; ?>" style="max-width:100%;">
	<?php }else{ ?>	
	<?php echo $row2['google_code']; ?>
	<?php } ?>	
</div>
<?php }}  ?>	
</div>
<?php }}  ?>	
