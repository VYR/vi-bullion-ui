
<div class="container py-5" style="min-height:500px;">
	<h1 class="text-center color1 text-uppercase">Minted Gold Cart</h1>
	<div class="border nbr2 text-white">
		<div class="nbg2 text-white p-1">
			<h3 class="mb-0">Cart Items</h3>
		</div>
		<div id="cart_div">
		<?php if(!empty($records)){ ?>	
		<div class="table-responsive">		
			<table class="table table-bordered">
				<thead class="text-white">
				<tr>
				<th class="nbr2">Sno</th>
				<th class="nbr2">Product</th>
				<th class="nbr2">Quantity</th>
				<th class="nbr2">Price</th>
				<th class="nbr2">Total</th>
				<th class="nbr2">Delete </th>
				</tr>
				</thead>
				<tbody class="text-white">	
					<?php
					$sub_total=0;
					foreach($records as $key => $row){ 
					$product_total=$row['mrp']*$row['qty'];
					$sub_total=$sub_total+$product_total;
					?>
					<tr>
						<td class="nbr2"><?php echo $key+1; ?></td>
						<td class="nbr2"><img src="<?php echo base_url(); ?>assets/images/minted/<?php echo $row['image']; ?>" alt="<?php echo $row['image_alt']; ?>" class="mr-2" style="max-width:100px;max-height:100px;"><?php echo $row['name']; ?></td>
						<td class="nbr2">
							<div class="input-group" style="width:100px;">
							<div class="input-group-prepend">
							<button class="btn btn-sm btn-danger" type="button" onclick="decrementQuantity(<?php echo $row['id']; ?>)"><i class="fa fa-minus"></i></button>
							</div>
							<input type="text" id="qty_<?php echo $row['id']; ?>" class="form-control form-control-sm" value="<?php echo $row['qty']; ?>" readonly="">
							<div class="input-group-append">
							<button class="btn btn-sm btn-success" type="button" onclick="incrementQuantity(<?php echo $row['id']; ?>)"><i class="fa fa-plus"></i></button>
							</div>
							</div>
						</td>
						<td class="nbr2">Rs.<?php echo $row['mrp']; ?></td>
						<td class="nbr2">Rs.<?php echo $row['mrp']*$row['qty']; ?></td>
						<td class="nbr2"><a href="javascript:void(0)" onclick="removeCart(<?php echo $row['id']; ?>)" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
					</tr>
					<?php }  ?>					
				</tbody>	
			</table>
		</div>		
		<div class="p-2 border-bottom nbr2">
		<h5 class="text-right">Subtotal : <span id="showsubtot">Rs. <?php echo $sub_total; ?></span></h5>
		<br/>
		<?php
		$discount=0;
		if(!empty($this->session->userdata('coupon_code'))){
		$customer_discount=$home_content['customer_discount'];
		$discount=($sub_total*$customer_discount)/100;
		}
		$grand_total=$sub_total-$discount;
		?>
		<h5 class="text-right">Discount : <span id="showsubtot">Rs. <?php echo $discount; ?></span></h5>
		<br/>
		<h5 class="text-right">Grand Total	:<span id="gtt">Rs.<?php echo $grand_total; ?></span></h5>
		</div>
		<form method="post" onsubmit="return checkDetails()">
		<div class="px-3">
		<div class="row">
		<div class="col-md-4 pt-2">
		<a href="<?php echo base_url(); ?>" class="btn abt-btn upperCase"><i class="fa fa-angle-left mr-2" aria-hidden="true"></i>Continue Shopping</a>
		</div>
		<div class="col-md-3 offset-md-5 pt-2">
		<div class="input-group mb-3 mr-3">
		<input type="text" class="form-control" placeholder="Enter Coupon Code" id="coupon_code">
		<div class="input-group-append">
		<button type="button" class="btn abt-btn" onclick="addCoupon()">Apply</button>
		</div>
		</div>
		</div>
		</div>
		</div>
		<div class="row">
		<div class="col-md-12">
		<h5 class="upperCase p-3">Fill Address Details.</h5>
		</div>
		<div class="col-md-6">
		<h5 class="upperCase  pl-3">Buyer Address:</h5>
		<div class="col-md-12">
		<div class="form-group">
		<textarea type="text" class="form-control p1" placeholder="Enter Address" id="baddress" name="baddress" required></textarea>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter Pincode" id="bpincode" name="bpincode" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter name" id="bname" name="bname" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="email" class="form-control p1" placeholder="Enter Email" id="bemail" name="bemail" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="input-group mb-3">
		<div class="input-group-prepend">
		<span class="input-group-text">+91</span>
		</div>
		<input type="number" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Phone" id="bmobile" name="bmobile" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter Aadhaar Number" id="baadhaar" name="baadhaar" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter Pan Number" id="bpan" name="bpan" required>
		</div>
		</div>
		</div>
		<div class="col-md-6">
		<h5 class="upperCase   pl-3"><input type="checkbox" id="dev_id" onclick="deliveryAddress()"> Delivery Address:</h5>
		<div class="col-md-12">
		<div class="form-group">
		<textarea type="text" class="form-control p1" placeholder="Enter Address" id="daddress" name="daddress" required></textarea>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter Pincode" id="dpincode" name="dpincode" required> 
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter name" id="dname" name="dname" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter Email" id="demail" name="demail" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="input-group mb-3">
		<div class="input-group-prepend">
		<span class="input-group-text">+91</span>
		</div>
		<input type="number" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Phone" id="dmobile" name="dmobile" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter Aadhaar Number" id="daadhaar" name="daadhaar" required>
		</div>
		</div>
		<div class="col-md-12">
		<div class="form-group">
		<input type="text" class="form-control p1" placeholder="Enter Pan Number" id="dpan" name="dpan" required>
		</div>
		</div>
		</div>
		<div class="col-md-4 p-4"></div>
		<div class="col-md-5 text-center p-4">

		</div>
		<div class="col-md-12 p-4 text-center"><button type="button" class="btn abt-btn">Place Order<i class="fa fa-angle-right  ml-1" aria-hidden="true"></i></button></div>
		</div>
		</form>
		<?php }else{  ?>	
		<div class="text-danger text-center"><h3>Cart Empty</h3></div>
		<?php }  ?>	
		</div>
	</div>
</div>
<script>

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
		if(nqty>0)
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
			url: "<?php echo site_url(); ?>minted_add_cart",    
			data: { pid:pid,qty:qty }})
			.done(function(data){
			getCart();
		});
	}  
	function removeCart(pid)
	{
		$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>minted_remove_cart",    
			data: { pid:pid }})
			.done(function(data){
			getCart();
		});
	}       
	function getCart()
	{
		$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>minted_cart_ajax",    
			data: { pid:1 }})
			.done(function(data){
			$("#cart_div").html(data);
		});
	}      
	function deliveryAddress()
	{
		var baddress=$("#baddress").val();
		var bpincode=$("#bpincode").val();
		var bname=$("#bname").val();
		var bemail=$("#bemail").val();
		var bmobile=$("#bmobile").val();
		var baadhaar=$("#baadhaar").val();
		var bpan=$("#bpan").val();
		if($("#dev_id").is(":checked")) {
			$("#daddress").val(baddress);
			$("#dpincode").val(bpincode);
			$("#dname").val(bname);
			$("#demail").val(bemail);
			$("#dmobile").val(bmobile);
			$("#daadhaar").val(baadhaar);
			$("#dpan").val(bpan);
		}else{
			$("#daddress").val('');
			$("#dpincode").val('');
			$("#dname").val('');
			$("#demail").val('');
			$("#dmobile").val('');
			$("#daadhaar").val('');
			$("#dpan").val('');
		}
	}  
</script>