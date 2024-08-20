
		<script>
			$(document).ready(function(){	

				$("#search_form").on("submit", function(e){
				e.preventDefault();	
				$("#search_form #submit_id").attr('disabled',true);
				$("#search_form #submit_id").text('Please Wait...');
				$.ajax({  
				type: "POST",    
				dataType: "html",    
				url: "<?php echo site_url(); ?>admin/casted_silver_sales_ajax",    
				data: $("#search_form").serialize()})
				.done(function(data){
				$("#sales_div").html(data);
				});
				$("#search_form #submit_id").attr('disabled',false);
				$("#search_form #submit_id").text('Submit');
				});		
		

				$("#update_form").on("submit", function(e){
				e.preventDefault();		
					$("#update_form #update_id").attr('disabled',true);
					$("#update_form #update_id").text('Please Wait...');
					let data = new FormData($("#update_form")[0]);
					$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/casted_silver_sales_update",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						$.toast({heading: 'Success',text: 'Updated Successfully',showHideTransition: 'fade',position: 'top-right',icon: 'success'});
						$("#update_modal").modal("hide");
						$("#search_form").submit();
						$("#update_form #update_id").attr('disabled',false);
						$("#update_form #update_id").text('Submit');
					}
					});	
				});	
				$("#cancel_form").on("submit", function(e){
				e.preventDefault();		
					$("#cancel_form #cancel_id").attr('disabled',true);
					$("#cancel_form #cancel_id").text('Please Wait...');
					let data = new FormData($("#cancel_form")[0]);
					$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/casted_silver_sales_cancel",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						$.toast({heading: 'Success',text: 'Updated Successfully',showHideTransition: 'fade',position: 'top-right',icon: 'success'});
						$("#cancel_modal").modal("hide");
						$("#search_form").submit();
						$("#cancel_form #cancel_id").attr('disabled',false);
						$("#cancel_form #cancel_id").text('Yes');
					}
					});	
				});	
			});		
			
		</script>
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Sales
        
      </h1>
     <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">  
	
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
	<form role="form" id="search_form" method="post" enctype="multipart/form-data">
		<div class="row" >
			<div class="col-md-3 form-group">
				<label for="name">Sales Type<span class="text-danger">*</span></label>
				<select class="form-control" id="order_type" name="order_type">
					<option value="0">Ongoing Sales</option>
					<option value="1">Total Sales</option>
					<option value="2">EMP Sales</option>
					<option value="3">Cancelled</option>
				</select>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">From Date<span class="text-danger">*</span></label>
				<input type="text" class="form-control datepicker" id="from_date" name="from_date" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="name">To Date<span class="text-danger">*</span></label>
				<input type="text" class="form-control datepicker" id="to_date" name="to_date" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Sales Table</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="sales_div">
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">            
					<thead>       
					<tr>       
					<th>SNO</th>  
					<th>Buyer Details</th>     
					<th>Pickup Details</th>     
					<th>Order Details</th>     
					<th>Payment Details</th>  
					<th>Other Details</th>  
					</tr>       
					</thead>   
					<tbody>
					<?php	
					if(count($records) > 0){
					foreach($records as $key => $row){ 
					?> 
					<tr class="text-center">
					<td><?php echo $key+1; ?></td>
					<td>
					<div><?php echo $row['buyer_name']; ?></div>
					<div><?php echo $row['buyer_mobile']; ?></div>
					<div><?php echo $row['buyer_email']; ?></div>
					<div><?php echo $row['buyer_address']; ?> - <?php echo $row['buyer_pincode']; ?></div>
					<div><?php echo $row['buyer_state']; ?> - <?php echo $row['buyer_state_code']; ?></div>
					<div><b>GST :</b> <?php echo $row['buyer_gst_no']; ?></div>
					<div><b>Pan No :</b> <?php echo $row['buyer_pan_number']; ?></div>
					<div><b>Aadhar No :</b> <?php echo $row['buyer_aadhar_number']; ?></div>
					</td>
					<td>
					<?php echo $row['pickup_dealer_address']; ?><br>
					<?php echo $row['pickup_state']; ?> - <?php echo $row['pickup_state_code']; ?>
					</td>
					<td>
					<div><b>Order ID :</b> <?php echo $row['order_ref_id']; ?></div>
					<div><?php echo date("d/M/Y h:i A", strtotime($row['order_date_time'])); ?></div>
					<?php 
						if($row['order_status']=='0'){
							$curr_time=date("h:i:s");			
							$end_time = date("h:i:s",strtotime("+".$home_content['casted_silver_order_time']." minutes", strtotime($row['order_date_time'])));			
							$mins = (strtotime($end_time) - strtotime($curr_time)) / 60;
							if($mins>0){
							echo '<b class="text-danger">'.round($mins).' mins</b>';
							}else{
							echo '<b class="text-danger">0 mins</b>';
							}
						}
					?>
					<?php if($row['qr_code']!=''){ ?>
					<a target="_blank" href="<?php echo base_url(); ?>admin/casted_silver_sales_download_admin?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Admin Invoice</a><br><br>
					<a target="_blank" href="<?php echo base_url(); ?>admin/casted_silver_sales_download_customer?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Customer Invoice</a><br><br>
					<a target="_blank" href="<?php echo base_url(); ?>admin/casted_silver_sales_download_pickup?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Pickup Invoice</a>
					<?php } ?>
					</td>
					<td>
						<div><b>Total :</b> Rs.<?php echo $row['total_amount']; ?>/-</div>
						<div><b>Discount :</b> Rs.<?php echo $row['coupon_amount']; ?>/-</div>
						<div><b>Final Amount :</b> Rs.<?php echo $row['final_amount']; ?>/-</div>
					</td>
					<td>
						<?php if($row['qr_code']!=''){ ?>
						<div style="display:flex;">
							<div style="margin-right:10px;">
								<img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $row['qr_code']; ?>" width="100">
							</div>
							<div>
								<div><b>HSN Code :</b> <?php echo $row['hsn_code']; ?></div>			
								<div><b>Silver No's :</b> <?php echo $row['silver_nos']; ?></div>			
								<div><b>IRN No :</b> <?php echo $row['irn_no']; ?></div>			
								<div><b>TCS Value :</b> <?php echo $row['tcs_value']; ?></div>			
								<div><b>Time :</b> <?php echo $row['time']; ?></div>			
							</div>
						</div>
						<?php }else{ ?>
						<a href="javascript:void(0)" onclick="openUpdate(<?php echo $row['id']; ?>)" class="btn btn-success text-white">Update</a>
						<a href="javascript:void(0)" onclick="openCancel(<?php echo $row['id']; ?>,'<?php echo $row['total_weight']*$home_content['casted_silver_deposit']; ?>')" class="btn btn-danger text-white">Cancel</a>
						<?php } ?>
					</td>
					</tr>
					<?php }}  ?>
					</tbody>
					</table>
				</div>
			  </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		  
					  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
<script>
	function openUpdate(order_id){
		/*
		var tracking_id=$("#tracking_id_"+order_id).val();
		$("#tracking_id").val(tracking_id);
		var tracking_content=$("#tracking_content_"+order_id).val();
		$("#tracking_content").val(tracking_content);
		var tracking_url=$("#tracking_url_"+order_id).val();
		$("#tracking_url").val(tracking_url);*/
		$("#order_id").val(order_id);
		$("#update_modal").modal("show");
	}
	function openCancel(order_id,amount){
		$("#corder_id").val(order_id);
		$("#order_amount").html(amount);
		$("#cancel_modal").modal("show");
	}
</script>
 <div class="modal fade" id="update_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Order</h4>
        </div>
        <div class="modal-body">
			<form role="form" id="update_form" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label>Employee<span class="text-danger">*</span></label>
				<select class="form-control" id="employee_id" name="employee_id" required>

					<option value="">Select</option>

					<?php	

					if(count($employees) > 0){

					foreach($employees as $skey => $srow){ 

					?> 

					<option value="<?php echo $srow['id']; ?>"><?php echo $srow['name']; ?></option>

					<?php }}  ?>

				</select>
				<input type="hidden" id="order_id" name="order_id" value="0">
			</div>
			<div class="form-group">
				<label>Qr Code<span class="text-danger">*</span></label>
				<input type="file" class="form-control" id="image" name="image" required>
			</div>
			<div class="form-group">
				<label>hsn code<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="hsn_code" name="hsn_code" placeholder="Enter hsncode" required>
			</div>
			<div class="form-group">
				<label>silver nos<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="silver_nos" name="silver_nos" placeholder="Enter silver nos" required>
			</div>
			<div class="form-group">
				<label>irn no<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="irn_no" name="irn_no" placeholder="Enter irn no" required>
			</div>
			<div class="form-group">
				<label>tcs value<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="tcs_value" name="tcs_value" placeholder="Enter tcs value" required>
			</div>
			<div class="form-group">
				<label>time<span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="time" name="time" placeholder="Enter time" required>
			</div>
			<div class="form-group">
				<button type="submit" id="update_id" class="btn btn-success">Submit</button>
			</div>
		  </form>
        </div>
      </div>
      
    </div>
  </div>
 <div class="modal fade" id="cancel_modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancel Order</h4>
        </div>
        <div class="modal-body text-center">
			<form role="form" id="cancel_form" method="post" enctype="multipart/form-data">
				<input type="hidden" id="corder_id" name="order_id" value="0">
				<h4>Rs.<span id="order_amount"></span> will be debited from user wallet</h4>
				<div class="form-group text-danger">Are you sure want to cancel order?</div>
				<div class="form-group">
					<button type="submit" id="cancel_id" class="btn btn-success">Yes</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
				</div>
		  </form>
        </div>
      </div>
      
    </div>
  </div>
