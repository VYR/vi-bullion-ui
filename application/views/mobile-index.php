<style>	
	.live_rates{
		display:block !important;
	}
</style>

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