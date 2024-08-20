<div class="container pt-5" id="live_rates_div"></div>
<script>
	setInterval(function(){ 
	getLiverates();
	}, 3000);
	getLiverates();
	function getLiverates()
	{
		$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>live_rates_ajax",    
			data: { org_price:1 }})
			.done(function(data){
			$("#live_rates_div").html(data);
		});
	}
</script>
<div class="container py-5" style="min-height:500px;">
<h1 class="text-center color1 text-uppercase">Casted Silver</h1>
<div id="products_div">
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
<h3 class="color1"><?php echo $row['name']; ?></h3>
<div class="row">	
<?php	
	if(!empty($row['products'])){
	foreach($row['products'] as $key1 => $row1){ 
	$purity_amount=($row1['purity_percentage']*$casted_value)/100;
	$price2=$casted_value-$purity_amount;
	$final_price=$price2*$row1['weight'];
?> 
<div class="<?php echo $pcol; ?> col-sm-6 mb-3">
	<div class="p-3 bg-white border shadow rounded text-center">
		<h5><?php echo $row1['name']; ?></h5>
		<img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $row1['image']; ?>" alt="<?php echo $row1['image_alt']; ?>" style="max-width:100%;">
		<div class="row text-center py-2 f18">
			<div class="col-6">
				<?php echo $row1['weight']; ?>g
			</div>
			<div class="col-6">
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
		<a href="<?php echo site_url(); ?>casted-register" class="btn btn-success d-inline-block w-auto">Buy Now</a>
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
</div>
</div>

<script>
	setInterval(function(){ 
	getProducts();
	}, 3000);
	function getProducts()
	{
		var org_price=$("#org_price").val();
		var dollar_price=$("#dollar_price").val();
		$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>casted_silver_loop",    
			data: { org_price:org_price,dollar_price:dollar_price }})
			.done(function(data){
			$("#products_div").html(data);
		});
	} 		 
</script>
