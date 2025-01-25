
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
					url:"<?php echo base_url(); ?>admin/casted_products_ajax",
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
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/casted_products"; }, 1000);
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
		 
		 
		</script>
		
	
		

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Casted Products Add
        
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
	<form role="form" id="submit_form" method="post" enctype="multipart/form-data">
		<div class="row" >
			<div class="col-md-6 form-group">
				<label for="name">Category<span class="text-danger">*</span></label>

				<select class="form-control" id="category_id" name="category_id" required>

					<option value="">Select</option>

					<?php	

					if(count($categories) > 0){

					foreach($categories as $skey => $srow){ 

					?> 

					<option value="<?php echo $srow['id']; ?>" <?php if(!empty($record) && $record['category_id']==$srow['id']){ echo 'selected'; } ?>><?php echo $srow['name']; ?></option>

					<?php }}  ?>

				</select>

			</div>
			<div class="col-md-6 form-group">
			<label for="cat_slno" class="control-label">Product Name <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" value="<?php if(!empty($record)){ echo $record['name']; } ?>" required>
			<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
		</div>
		<div class="row" >
			<div class="col-md-6 form-group">
				<label for="name">Image<span class="text-danger">*</span></label>
				<?php if(!empty($record) && $record['image']!=''){ ?>
				<img src="<?php echo base_url(); ?>assets/images/casted/<?php echo $record['image']; ?>" height="100">
				<?php } ?>
				<input type="file" class="form-control" id="image" name="image"  <?php if(empty($record)){ echo 'required'; } ?>>
			</div>
			<div class="col-md-6 form-group">
			<label for="cat_slno" class="control-label">Image alt <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="image_alt" name="image_alt" placeholder="Enter alt" value="<?php if(!empty($record)){ echo $record['image_alt']; } ?>" required>
			</div>
		</div>
		<div class="row" >
			<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">Weight(gms) <span class="text-danger">*</span></label>
			<input type="number" class="form-control" id="weight" name="weight" placeholder="Enter weight" value="<?php if(!empty($record)){ echo $record['weight']; } ?>" required>
			</div>
			<div class="col-md-4 form-group" style="display:none;">
			<label for="cat_slno" class="control-label">Mrp <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mrp" name="mrp" placeholder="Enter mrp" value="<?php if(!empty($record)){ echo $record['mrp']; } ?>">
			</div>
			<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">purity <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="purity" name="purity" placeholder="Enter purity" value="<?php if(!empty($record)){ echo $record['purity']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
			<label for="cat_slno" class="control-label">purity percentage <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="purity_percentage" name="purity_percentage" placeholder="Enter purity percentage" value="<?php if(!empty($record)){ echo $record['purity_percentage']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<a href="<?php echo base_url(); ?>admin/casted_products" class="btn btn-danger">Cancel</a>
				<button type="submit" id="submit_id" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
            </div>
            <!-- /.box-body -->
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
