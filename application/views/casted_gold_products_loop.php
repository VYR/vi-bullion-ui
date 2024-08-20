
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
<h3 class="text-white text-center"><?php echo $row['name']; ?></h3>
<div class="row">	
<?php	
	if(!empty($row['products'])){
	foreach($row['products'] as $key1 => $row1){
	// $purity_amount=($row1['purity_percentage']*$casted_value)/100;
	// $price2=$casted_value-$purity_amount;
	// $final_price=$price2*$row1['weight'];
	$purity_amount=($row1['purity_percentage']*$casted_value)/100;
	// $price2=$casted_value-$purity_amount;
	$price2=0;
	
	if($gold_mcx['all_india_display']=='0'){
		$price2=$casted_value;
	}else{
		$ask=$api_details[0]['Ask']/10;
		$ask1=$ask+$gold_mcx['mcxa_value'];
		$ask_gst=($ask1*$gold_mcx['mcxb_value'])/100;
		$gask2=$ask1+$ask_gst+$gold_mcx['mcxc_value'];
		//$purity_amount=($row1['purity_percentage']*$gask2)/100;
		//$price2=$gask2-$purity_amount;
		$price2=$gask2;
	}
	
	//$final_price=$price2*$row1['weight'];
	$final_price=$price2*100;
?> 
<div class="<?php echo $pcol; ?> col-sm-6 mb-3">
	<div class="p-3 border nbr2 text-white shadow rounded text-center h-100">
		<h5><?php echo $row1['name']; ?></h5>
		<img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $row1['image']; ?>" alt="<?php echo $row1['image_alt']; ?>" style="max-width:100%;">
		<div class="row py-2 f18">
			<div class="col-6 text-right">
				<?php echo $row1['weight']; ?>g
			</div>
			<div class="col-6 text-left">
				<?php echo $row1['purity']; ?>%
			</div>
			<div class="col-6 d-none">
				Rs.<?php echo $row1['mrp']; ?>/-
			</div>
			<div class="col-12">
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
	<a href="<?php echo $row2['url']; ?>"><img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $row2['image']; ?>" alt="<?php echo $row2['image_alt']; ?>" style="max-width:100%;"></a>
	<?php }else{ ?>	
	<?php echo $row2['google_code']; ?>
	<?php } ?>	
</div>
<?php }}  ?>	
</div>
<?php }}  ?>	