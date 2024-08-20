

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

					url:"<?php echo base_url(); ?>admin/company_employees_ajax",

					data:data,

					processData: false,

					contentType: false,

					success:function(result)

					{		

						var jsondata=jQuery.parseJSON(result);	

						if(jsondata['status']==1)

						{

							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});

							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/company_employees"; }, 1000);

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

       Company employees Add

        

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

			<div class="col-md-3 form-group">

			<label for="cat_slno" class="control-label">Name <span class="text-danger">*</span></label>

			<input type="text" class="form-control" id="address" name="name" placeholder="Enter Name" value="<?php if(!empty($record)){ echo $record['name']; } ?>" required>
				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">

			</div>
			<div class="col-md-3 form-group">

			<label for="cat_slno" class="control-label">Mobile <span class="text-danger">*</span></label>

			<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" value="<?php if(!empty($record)){ echo $record['mobile']; } ?>" required>

			</div>
			<div class="col-md-3 form-group">

			<label for="cat_slno" class="control-label">Email <span class="text-danger">*</span></label>

			<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php if(!empty($record)){ echo $record['email']; } ?>" required>

			</div>
			<div class="col-md-3 form-group">

			<label for="cat_slno" class="control-label">Unique Code <span class="text-danger">*</span></label>

			<input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="Enter Unique Code" value="<?php if(!empty($record)){ echo $record['unique_code']; } ?>" required>

			</div>
			<div class="col-md-12 form-group">

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

 

