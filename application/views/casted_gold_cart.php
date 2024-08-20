
<div class="container py-5" style="min-height:500px;">
<div class="border nbr2 rounded col-12 py-3">
	<h1 class="text-center color1 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
	<form id="submit_form" method="post">
		<input type="hidden" id="org_price" value="<?php echo $org_price; ?>">
		<input type="hidden" id="dollar_price" value="<?php echo $dollar_price; ?>">
		<div id="cart_div">
			
		</div>
	</form>
</div>
</div>

<script>
	setInterval(function(){ 
	getCart();
	}, 3000);
	getCart();
	function getCart(){
		$.ajax({    
			type: "POST",    
			dataType: "html",    
			url:"<?php echo base_url(); ?>casted_gold_cart_ajax",
			data: $("#submit_form").serialize()})
			.done(function(data) { 
			$('#cart_div').html(data);
		});	
	}
	function incrementQuantity(id)
	{
		var qty=$("#qty_"+id).val();
		var nqty=parseInt(qty)+parseInt(1);
		$("#qty_"+id).val(nqty);
		updateCart(id);
	}
	function decrementQuantity(id)
	{
		var qty=$("#qty_"+id).val();
		var nqty=parseInt(qty)-parseInt(1);
		if(nqty>=0)
		{
			$("#qty_"+id).val(nqty);
			updateCart(id);
		}
	}      
	function updateCart(pid)
	{
		var qty=$("#qty_"+pid).val();
		$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>casted_gold_add_cart",    
			data: { pid:pid,qty:qty }})
			.done(function(data){
			getCart();
		});
	} 
</script>