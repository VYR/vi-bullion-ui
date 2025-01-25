
		<script>
$(document).ready(function(){	
	
	$("#submit_form").on("submit", function(e){
				e.preventDefault();		
				for ( instance in CKEDITOR.instances ) 	
				{        
					CKEDITOR.instances[instance].updateElement();    
				}	
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/casted_silver_products_prices_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							var employee_id=jsondata['employee_id'];
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location.reload(); }, 1000);
						}
						else
						{
							$.toast({heading: 'Error',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'error'});		
						}
						$("#submit_form #submit_id").attr('disabled',false);
						$("#submit_form #submit_id").text('Submit');
					}
				});	
			});	
	
}); 
	setInterval(function(){ 
	getPricing();
	}, 3000);
	function getPricing()
	{
		var org_price=$("#org_price").val();
		var dollar_price=$("#dollar_price").val();
		$.ajax({  
			type: "POST",    
			dataType: "html",    
			url: "<?php echo site_url(); ?>admin/casted_silver_products_prices_loop",    
			data: { org_price:org_price,dollar_price:dollar_price }})
			.done(function(data){
			$("#pricing_div").html(data);
		});
	}      
		 
		 
		</script>
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Casted Silver Products Prices
        
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
            <div class="box-header">
				<h4>Default Values</h4>
			</div>
            <div class="box-body">
	<form role="form" id="submit_form" method="post" enctype="multipart/form-data">
		<div class="row" >
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">A1 Value <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="a1_value" name="a1_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['a1_value']; } ?>" required>
			<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">A3 Value <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="a3_value" name="a3_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['a3_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">B1 Value <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="b1_value" name="b1_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['b1_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">C Value <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="c_value" name="c_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['c_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">E Value <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="e_value" name="e_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['e_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">G Value <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="g_value" name="g_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['g_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">L Value <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="l_value" name="l_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['l_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">GST % <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="gst" name="gst" placeholder="Enter GST %" value="<?php if(!empty($record)){ echo $record['gst']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Costing Value(A) <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mcxa_value" name="mcxa_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['mcxa_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Costing Value(GST) <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mcxb_value" name="mcxb_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['mcxb_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
			<label for="cat_slno" class="control-label">Costing Value(B) <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mcxc_value" name="mcxc_value" placeholder="Enter Value" value="<?php if(!empty($record)){ echo $record['mcxc_value']; } ?>" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="cat_slno" class="control-label">All Over India <span class="text-danger">*</span></label>
				<select class="form-control" id="all_india_display" name="all_india_display" required>
					<option value="0" <?php if(!empty($record) && $record['all_india_display']==0){ echo 'selected'; } ?>>Original price</option>
					<option value="1" <?php if(!empty($record) && $record['all_india_display']==1){ echo 'selected'; } ?>>Costing price</option>
				</select>
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
          <div id="pricing_div">
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-header">
				<h4>Pricing</h4>
			</div>
            <div class="box-body">
				<?php 
					$org_price='1853.65';
					$dollar_price='75.555';
				?>
				<div class="row" >
					<div class="col-md-3 form-group">
						<label>A</label>
						<input type="text" class="form-control" id="org_price" value="<?php echo $org_price; ?>" readonly>
					</div>
					<div class="col-md-3 form-group">
						<label>B</label>
						<input type="text" class="form-control" id="dollar_price" value="<?php echo $dollar_price; ?>" readonly>
					</div>
				</div>
				<div class="row" >
					<div class="col-md-3 form-group">
						<label>A1 (add)</label>
						<input type="text" class="form-control" value="<?php echo $record['a1_value']; ?>" readonly>
					</div>
					<div class="col-md-3 form-group">
						<label>B1 (add)</label>
						<input type="text" class="form-control" value="<?php echo $record['b1_value']; ?>" readonly>
					</div>
				</div>
				<div class="row" >
					<div class="col-md-3 form-group">
						<?php $a2_value=$org_price+$record['a1_value']; ?>
						<label>A2 (equal)</label>
						<input type="text" class="form-control" value="<?php echo round($a2_value,2); ?>" readonly>
					</div>
					<div class="col-md-3 form-group">
						<?php $b2_value=$dollar_price+$record['b1_value']; ?>
						<label>B2 (equal)</label>
						<input type="text" class="form-control" value="<?php echo round($b2_value,2); ?>" readonly>
					</div>
				</div>
				<div class="row" >
					<div class="col-md-3 form-group">
						<label>A3 (add)</label>
						<input type="text" class="form-control" value="<?php echo $record['a3_value']; ?>" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 form-group">
						<?php $a4_value=$a2_value+$record['a3_value']; ?>
						<label>A4 (equal)</label>
						<input type="text" class="form-control" value="<?php echo round($a4_value,2); ?>" readonly>
					</div>
					<div class="col-md-3 form-group">
						<label>B2 (x)</label>
						<input type="text" class="form-control" value="<?php echo round($b2_value,2); ?>" readonly>
					</div>
					<div class="col-md-3 form-group">
						<label>A5 (equal)</label>
						<?php $a5_value=$a4_value*$b2_value; ?>
						<input type="text" class="form-control" value="<?php echo round($a5_value,2); ?>" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 form-group">
						<label>A5</label>
						<input type="text" class="form-control" value="<?php echo round($a5_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<label>C (add)</label>
						<input type="text" class="form-control" value="<?php echo $record['c_value']; ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<label>D (equal)</label>
						<?php $d_value=$a5_value+$record['c_value']; ?>
						<input type="text" class="form-control" value="<?php echo round($d_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<label>E (Multiply by)</label>
						<input type="text" class="form-control" value="<?php echo $record['e_value']; ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
					<?php $m_value=$d_value*$record['e_value']; ?>
					<label>M (equal)</label>
					<input type="text" class="form-control" value="<?php echo round($m_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
					<label>N (Divided By)</label>
					<input type="text" class="form-control" value="<?php echo '1000'; ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<?php $f_value=$m_value/1000; ?>
						<label>F (equal)</label>
						<input type="text" class="form-control" value="<?php echo round($f_value,2); ?>" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 form-group">
						<label>F</label>
						<input type="text" class="form-control" value="<?php echo round($f_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<?php $i_value=($record['gst']*$f_value)/100; ?>					
						<label>I (GST)(add)</label>
						<input type="text" class="form-control" value="<?php echo round($i_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<label>H (equal)</label>
						<?php $h_value=$f_value+$i_value; ?>
						<input type="text" class="form-control" value="<?php echo round($h_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<label>G (add)</label>
						<input type="text" class="form-control" value="<?php echo $record['g_value']; ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<?php $j_value=$h_value+$record['g_value']; ?>
						<label>J (equal)</label>
						<input type="text" class="form-control" value="<?php echo round($j_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<?php $l_value=$record['l_value']; ?>					
						<label>L (Minus)</label>
						<input type="text" class="form-control" value="<?php echo round($l_value,2); ?>" readonly>
					</div>
					<div class="col-md-2 form-group">
						<?php $n_value=$j_value-$l_value; ?>
						<label>N (equal)</label>
						<input type="text" class="form-control" value="<?php echo round($n_value,2); ?>" readonly>
					</div>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Products Table</h3>
			   <div id="dmsg"></div>
            </div>
            <!-- /.box-header -->
			<?php	
			if(count($records) > 0){
			?> 
            <div class="box-body table-responsive">
				<table id="" class="table table-bordered table-striped">            
				<thead>       
					<tr>       
						<th>SNO</th>  
						<th>Purity</th>  
						<th>Weight</th>  
						<th>Price1/gm</th>   
						<th>Purity percentage</th>  
						<th>Purity amount</th>  
						<th>Price2/gm</th>     
						<th>Final Price</th>  
					</tr>       
				</thead>   
				<tbody>
					<?php	
					foreach($records as $key => $row){ 
					$purity_amount=($row['purity_percentage']*$n_value)/100;
					
					$price2=$n_value-$purity_amount;
					$final_price=$price2*$row['weight'];
					?> 
					<tr class="text-center">
					<td><?php echo $key+1; ?></td>
					<td><?php echo $row['purity']; ?></td>
					<td><?php echo $row['weight']; ?></td>
					<td><?php echo round($n_value,2); ?></td>
					<td><?php echo $row['purity_percentage']; ?>%</td>
					<td><?php echo round($purity_amount,2); ?></td>
					<td><?php echo round($price2,2); ?></td>
					<td><?php echo round($final_price,2); ?></td>
					</tr>
					<?php }   ?>
			  </tbody>
			  </table>
			  </div>
				<?php }  ?>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box -->
	
          
          <!-- /.box -->
		  
			
	
		  
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
    <script src="https://cdn.ckeditor.com/4.10.0/standard-all/ckeditor.js"></script>
    <script type="text/javascript">
	CKEDITOR.replaceAll( function( textarea, config ){
		if ( new CKEDITOR.dom.element( textarea ).hasClass('ckeditor') ) {
		CKEDITOR.tools.extend( config, {
		extraPlugins: 'colorbutton',
		colorButton_colors : 'CF5D4E,454545,FFF,CCC,DDD,CCEAEE,66AB16,f39c12',
		colorButton_enableAutomatic: false,
		height: 150,
		
		filebrowserBrowseUrl: '/assets/ckfinder/ckfinder.html',
		filebrowserImageBrowseUrl: '/assets/ckfinder/ckfinder.html?type=Images',
		filebrowserUploadUrl: '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
		filebrowserImageUploadUrl: '/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
		} );
		return true;
		} 
		return false;
	});
    </script>
