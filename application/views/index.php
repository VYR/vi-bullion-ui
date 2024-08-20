<style>	
	.live_rates{
		display:block !important;
	}
</style>

	<div class="position-relative" style="background:url(<?php echo base_url(); ?>assets/images/banners/<?php echo $banners['image']; ?>);min-height:calc(100vh - 128px);">
		<div class="py-3 py-md-5 text-center text-white">
			<h1 class="my-md-5"><?php echo $banners['h1_tag']; ?></h1>
		</div>
		<div class="btm-divs">
			<div class="container-fluid">
				<div class="row">
					<?php	
					if(!empty($categories)){
					foreach($categories as $key => $row){ 
					if($row['status']==1){				
					$url='';
					if($row['url_redirect']==1){
						if($row['id']==1){
							$url='casted-gold';
						}else if($row['id']==2){
							$url='minted-gold';
						}else if($row['id']==3){
							$url='gold-scrap';
						}else if($row['id']==4){
							$url='casted-silver';
						}else if($row['id']==5){
							$url='minted-silver';
						}else if($row['id']==6){
							$url='corporate-deals';
						}
					}
					?> 
					<div class="col-md-2 col-sm-6 mb-3 text-center mx-auto">
						<div class="btm-div h-100">
							<div class="mb-2">
								<img src="<?php echo base_url(); ?>assets/images/categories/<?php echo $row['image']; ?>" alt="<?php echo $row['image_alt']; ?>" style="max-width:100%;height:70px;">
							</div>
							<h6 class="text-uppercase"><?php echo $row['name']; ?><h6>
							<div class="mb-3"><?php echo $row['description']; ?></div>
							<a href="<?php echo site_url().$url; ?>" class="text-white font-weight-bold text-uppercase"><?php echo $row['link_name']; ?> <i class="fa fa-arrow-right"></i></a>
						</div>
					</div>
					<?php }}}  ?>
				</div>
			</div>
		</div>
	</div>
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
				setTimeout(function(){ $(".sprice").removeClass("blinkclr2"); }, 1500);		
			});
		}
	</script>