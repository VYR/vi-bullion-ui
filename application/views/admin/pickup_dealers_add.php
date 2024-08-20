

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

					url:"<?php echo base_url(); ?>admin/pickup_dealers_ajax",

					data:data,

					processData: false,

					contentType: false,

					success:function(result)

					{		

						var jsondata=jQuery.parseJSON(result);	

						if(jsondata['status']==1)

						{

							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});

							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/pickup_dealers"; }, 1000);

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

       Pickup dealers Add

        

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

			<div class="col-md-2 form-group">

				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">

				<label for="name">Place<span class="text-danger">*</span></label>

				<select class="form-control" id="place_id" name="place_id"  onchange="getSub()" required>

					<option value="">Select</option>

					<?php	

					if(count($places) > 0){

					foreach($places as $skey => $srow){ 

					?> 

					<option value="<?php echo $srow['id']; ?>" <?php if(!empty($record) && $record['place_id']==$srow['id']){ echo 'selected'; } ?>><?php echo $srow['name']; ?></option>

					<?php }}  ?>

				</select>

			</div>
			<div class="col-md-2 form-group">

			<label for="cat_slno" class="control-label">Address <span class="text-danger">*</span></label>

			<input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="<?php if(!empty($record)){ echo $record['address']; } ?>" required>

			</div>
			<div class="col-md-2 form-group">
				<label for="name">Image<span class="text-danger">*</span></label>
				<?php if(!empty($record)){ ?>
				<img src="<?php echo base_url(); ?>assets/images/dealers/<?php echo $record['image']; ?>" width="100">
				<?php } ?>
				<input type="file" class="form-control" id="image" name="image"  <?php if(empty($record)){ echo 'required'; } ?>>
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">
			</div>

			<div class="col-md-2 form-group">

			<label for="cat_slno" class="control-label">Image alt <span class="text-danger">*</span></label>

			<input type="text" class="form-control" id="image_alt" name="image_alt" placeholder="Enter image alt" value="<?php if(!empty($record)){ echo $record['image_alt']; } ?>" required>

			</div>
			<div class="col-md-2 form-group">

			<label for="cat_slno" class="control-label">Unique Code <span class="text-danger">*</span></label>

			<input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="Enter Unique Code" value="<?php if(!empty($record)){ echo $record['unique_code']; } ?>" required>

			</div>
			<div class="col-md-2 form-group">

			<label for="cat_slno" class="control-label">Password <span class="text-danger">*</span></label>

			<input type="text" class="form-control" id="password" name="password" placeholder="Enter password" value="<?php if(!empty($record)){ echo decode5t($record['password']); } ?>" required>

			</div>
			</div>
		<div class="row" >

			<div class="col-md-6 form-group">

				<label for="inputEmail3" class="control-label">Description <span class="text-danger">*</span></label>

				<textarea class="form-control" name="description"  ><?php if(!empty($record)){ echo $record['description']; } ?></textarea>	

			</div>
			<div class="col-md-6 form-group">

				<label for="inputEmail3" class="control-label">Google Map <span class="text-danger">*</span></label>

				<textarea class="form-control" name="google_map"  ><?php if(!empty($record)){ echo $record['google_map']; } ?></textarea>	

			</div>

			<div class="col-md-4 form-group">

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

 

