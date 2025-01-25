
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
					url:"<?php echo base_url(); ?>admin/casted_silver_ads_ajax",
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
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/casted_silver_ads"; }, 1000);
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
       Casted Silver Ads Add
        
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
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">

			</div>
			<div class="col-md-6 form-group">
				<label for="name">Ad Type<span class="text-danger">*</span></label>

				<select class="form-control" id="ad_type" name="ad_type" onchange="show_ads()" required>

					<option value="">Select</option>
					<option value="0" <?php if(!empty($record) && $record['ad_type']==0){ echo 'selected'; } ?>>Normal</option>
					<option value="1" <?php if(!empty($record) && $record['ad_type']==1){ echo 'selected'; } ?>>Google</option>
				</select>

			</div>
		</div>
		<div class="row" >
			<div class="col-md-6 form-group normal_div" style="display:none;">
				<label for="name">Image<span class="text-danger">*</span></label>
				<?php if(!empty($record) && $record['image']!=''){ ?>
				<img src="<?php echo base_url(); ?>assets/images/casted_silver/<?php echo $record['image']; ?>" height="100">
				<?php } ?>
				<input type="file" class="form-control" id="image" name="image">
			</div>
			<div class="col-md-6 form-group normal_div" style="display:none;">
			<label for="cat_slno" class="control-label">Image alt <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="image_alt" name="image_alt" placeholder="Enter alt" value="<?php if(!empty($record)){ echo $record['image_alt']; } ?>">
			</div>
			<div class="col-md-12 form-group normal_div" style="display:none;">
			<label for="cat_slno" class="control-label">Url <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="url" name="url" placeholder="Enter url" value="<?php if(!empty($record)){ echo $record['url']; } ?>">
			</div>
		</div>
		<div class="row" >
			<div class="col-md-12 form-group google_div" style="display:none;">
			<label for="cat_slno" class="control-label">Google Code <span class="text-danger">*</span></label>
			<textarea class="form-control" id="google_code" name="google_code" placeholder="Enter Google Code"><?php if(!empty($record)){ echo $record['google_code']; } ?></textarea>
			</div>
			<div class="col-md-4 form-group">
				<label for="upload_image">&nbsp;</label><br>
				<a href="<?php echo base_url(); ?>admin/casted_silver_ads" class="btn btn-danger">Cancel</a>
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
	show_ads();
	function show_ads(){
		var ad_type=$("#ad_type").val();
		$(".normal_div").hide();
		$("#image").attr("required",false);
		$("#image_alt").attr("required",false);
		$("#url").attr("required",false);
		$(".google_div").hide();
		$("#google_code").attr("required",false);
		if(ad_type=='0'){
		$(".normal_div").show();
		<?php if(empty($record) || $record['image']==''){ ?>
		$("#image").attr("required",true);
		<?php } ?>
		$("#image_alt").attr("required",true);
		$("#url").attr("required",true);
		}else if(ad_type=='1'){
		$(".google_div").show();
		$("#google_code").attr("required",true);
		}
	}
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
