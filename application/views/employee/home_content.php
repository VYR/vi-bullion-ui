
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
					url:"<?php echo base_url(); ?>admin/home_content_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/home_content"; }, 1000);
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
      Home content
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
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Title <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="<?php if(!empty($record)){ echo $record['title']; } ?>" required>
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Meta Description <span class="text-danger">*</span></label>
				<textarea class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description"><?php if(!empty($record)){ echo $record['meta_description']; } ?></textarea>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Logo <span class="text-danger"></span></label>
				<?php if(!empty($record)){ ?><br>
				<img src="<?php echo base_url(); ?>assets/images/logo/<?php echo $record['logo']; ?>" width="100">
				<?php } ?>
				<input type="file" class="form-control" id="logo" name="logo">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Logo Alt <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="logo_alt" name="logo_alt" placeholder="Enter Logo Alt" value="<?php if(!empty($record)){ echo $record['logo_alt']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Footer Logo <span class="text-danger"></span></label>
				<?php if(!empty($record)){ ?><br>
				<img src="<?php echo base_url(); ?>assets/images/logo/<?php echo $record['footer_logo']; ?>" width="100">
				<?php } ?>
				<input type="file" class="form-control" id="footer_logo" name="footer_logo">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Footer Logo Alt <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="footer_logo_alt" name="footer_logo_alt" placeholder="Enter Logo Alt" value="<?php if(!empty($record)){ echo $record['footer_logo_alt']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Mobile <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" value="<?php if(!empty($record)){ echo $record['mobile']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Email <span class="text-danger">*</span></label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php if(!empty($record)){ echo $record['email']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Corporate Address <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="address" name="address" placeholder="Enter Corporate address" value="<?php if(!empty($record)){ echo $record['address']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Rights Reserved <span class="text-danger"></span></label>
				<input type="text" class="form-control" id="rights_reserved" name="rights_reserved" placeholder="Enter Rights reserved" value="<?php if(!empty($record)){ echo $record['rights_reserved']; } ?>">
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Other Meta Tags<span class="text-danger"></span></label>
				<textarea class="form-control" rows="10" id="meta_tags" name="meta_tags"><?php if(!empty($record)){ echo $record['meta_tags']; } ?></textarea>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Casted Gold Deposit Per Gram <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="casted_gold_deposit" name="casted_gold_deposit" placeholder="Enter Casted Gold Deposit Per Gram" value="<?php if(!empty($record)){ echo $record['casted_gold_deposit']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Casted Gold Discount Per Gram <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="casted_gold_discount" name="casted_gold_discount" placeholder="Enter Casted Gold Discount Per Gram" value="<?php if(!empty($record)){ echo $record['casted_gold_discount']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Casted Gold Order Time (in Mins) <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="casted_gold_order_time" name="casted_gold_order_time" placeholder="Enter Casted Gold Order Time (in Mins)" value="<?php if(!empty($record)){ echo $record['casted_gold_order_time']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Casted Silver Deposit Per Gram <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="casted_silver_deposit" name="casted_silver_deposit" placeholder="Enter Casted Silver Deposit Per Gram" value="<?php if(!empty($record)){ echo $record['casted_silver_deposit']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Casted Silver Discount Per Gram <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="casted_silver_discount" name="casted_silver_discount" placeholder="Enter Casted Silver Discount Per Gram" value="<?php if(!empty($record)){ echo $record['casted_silver_discount']; } ?>" required>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Casted Silver Order Time (in Mins) <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="casted_silver_order_time" name="casted_silver_order_time" placeholder="Enter Silver Gold Order Time (in Mins)" value="<?php if(!empty($record)){ echo $record['casted_silver_order_time']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="cat_slno" class="control-label">Bank Details<span class="text-danger"></span></label>
				<textarea class="ckeditor" id="bank_details" name="bank_details"><?php if(!empty($record)){ echo $record['bank_details']; } ?></textarea>
			</div>
			<div class="col-md-4 form-group">
				<label for="cat_slno" class="control-label">Scrolling text <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="scrolling_text" name="scrolling_text" placeholder="Enter scrolling_text" value="<?php if(!empty($record)){ echo $record['scrolling_text']; } ?>" required>
			</div>
			<div class="col-md-12 form-group">
				<label for="upload_image">&nbsp;</label><br>
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

	<script type="text/javascript">
			CKEDITOR.replaceAll( function( textarea, config ){
				if ( new CKEDITOR.dom.element( textarea ).hasClass('ckeditor') ) {
				CKEDITOR.tools.extend( config, {				
				filebrowserBrowseUrl: '<?php echo base_url(); ?>assets/ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl: '<?php echo base_url(); ?>assets/ckfinder/ckfinder.html?type=Images',
				filebrowserUploadUrl: '<?php echo base_url(); ?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl: '<?php echo base_url(); ?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
				} );
				return true;
				} 
				return false;
			});
	</script>
 
