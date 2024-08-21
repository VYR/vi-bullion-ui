<style>	
	.live_rates{
		display:block !important;
	}
	.my-modal-content{
		background-color: #3a2709 !important;
		color: #fff;
	}
	.my-modal-content .close,.close:hover {
		color: #fff;
	}
	.loading{
		width: 5rem;
		height: 5rem;
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
							<a onclick="showProduct('<?=$row['name']?>')" href="javascript:void(0)" class="text-white font-weight-bold text-uppercase"><?php echo $row['link_name']; ?> <i class="fa fa-arrow-right"></i></a>
						</div>
					</div>
					<?php }}}  ?>
				</div>
			</div>
		</div>
	</div>
	<div class="container pt-5" id="live_rates_div"></div>
	<script>
		var liveRatesAjaxFlag=0;
		setInterval(function(){ 
			if(liveRatesAjaxFlag===0){			
				liveRatesAjaxFlag=1;
				getLiverates();
			}
		}, 3000);
		function getLiverates()
		{
			$.ajax({  
				type: "POST",    
				dataType: "html",    
				url: "<?php echo site_url(); ?>live_rates_ajax",    
				data: { org_price:1 }})
				.done(function(data){
				$("#live_rates_div").html(data);						
				liveRatesAjaxFlag=0;				
				setTimeout(function(){ $(".sprice").removeClass("blinkclr2"); }, 1500);		
			});
		}
		function showProduct(data){
			console.log(data);
			$("#exampleModalLongTitle").html(data);
			$('#exampleModalCenter').modal('show');
			$("#productModalBody").html('<center><img src="<?=base_url()?>assets/images/loading.gif" class="loading" /></center>');
			$.ajax({  
				type: "GET",    
				dataType: "html",    
				url: "<?php echo site_url(); ?>casted-gold"
				})
				.done(function(data){
					$("#productModalBody").html(data);
				});
		}
	</script>

	<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content my-modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body" id="productModalBody">
         
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>