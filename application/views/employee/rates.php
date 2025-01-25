

		<script>

$(document).ready(function(){	

	

	$("#submit_form").on("submit", function(e){

				e.preventDefault();	

				$("#submit_form #submit_id").attr('disabled',true);

				$("#submit_form #submit_id").text('Please Wait...');

				let data = new FormData($("#submit_form")[0]);

				$.post({

					type: "post",

					url:"<?php echo base_url(); ?>admin/rates_ajax",

					data:data,

					processData: false,

					contentType: false,

					success:function(result)

					{		

						var jsondata=jQuery.parseJSON(result);	

						if(jsondata['status']==1)

						{

							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});

							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/rates"; }, 1000);

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

       Rates

        

      </h1>

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

				<label for="name">Type<span class="text-danger">*</span></label>
				<select class="form-control" id="metal_type" name="metal_type"  required>
					<option value="0" <?php if(!empty($record) && $record['metal_type']==0){ echo 'selected'; } ?>>Gold</option>
					<option value="1" <?php if(!empty($record) && $record['metal_type']==1){ echo 'selected'; } ?>>Silver</option>
				</select>


			</div>
			<div class="col-md-3 form-group">

				<label for="name">Area<span class="text-danger">*</span></label>
				<select class="form-control" id="area_id" name="area_id" required>

					<option value="">Select</option>

					<?php	

					if(count($areas) > 0){

					foreach($areas as $skey => $srow){ 

					?> 

					<option value="<?php echo $srow['id']; ?>" <?php if(!empty($record) && $record['area_id']==$srow['id']){ echo 'selected'; } ?>><?php echo $srow['name']; ?></option>

					<?php }}  ?>

				</select>


			</div>
			<div class="col-md-3 form-group">

				<label for="name">Rate<span class="text-danger">*</span></label>

				<input type="text" class="form-control" id="rate" name="rate" value="<?php if(!empty($record)){echo $record['rate'];} ?>" autocomplete="off" placeholder="Enter rate" required>

				<input type="hidden" id="id" name="id" value="<?php if(!empty($record)){ echo $record['id']; }else{ echo '0'; } ?>">

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

          <!-- /.box -->

	

          <div class="box">

            <div class="box-header">

              <h3 class="box-title">Rates Table</h3>

			   <div id="dmsg"></div>

            </div>

            <!-- /.box-header -->

            <div class="box-body" id="">

				<table id="example1" class="table table-bordered table-striped">            

				<thead>       

					<tr>       

						<th>SNO</th>  

						<th>Type</th>    
						<th>Area</th>    
						<th>Rate</th>    

						<th>Status</th>  

						<th>Action</th>  

					</tr>       

				</thead>   

				<tbody>

	<?php	

	if(count($records) > 0){

	foreach($records as $key => $row){ 

	?> 

	<tr class="text-center">

	<td><?php echo $key+1; ?></td>

	<td><?php echo $row['metal_type']==0?'Gold':'Silver'; ?></td>
	<td><?php echo $row['area_name']; ?></td>
	<td><?php echo $row['rate']; ?></td>

	<td>

	<?php if($row['status']==0) { ?>

	<a href="<?php echo base_url(); ?>admin/rates_status?id=<?php echo $row['id']; ?>&status=1" class="btn btn-danger text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Deactive</a>

	<?php } else if($row['status']==1) { ?>		

	<a href="<?php echo base_url(); ?>admin/rates_status?id=<?php echo $row['id']; ?>&status=0" class="btn btn-success text-white confirm_alert" data-title="Are You Sure Want To Change Status?">Active</a>					

	<?php } ?>							

	</td>

	<td>

	<a href="<?php echo base_url(); ?>admin/rates?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fa fa-edit"></i></a>

	<a href="<?php echo base_url(); ?>admin/rates_delete?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger confirm_alert" data-title="Are you sure want to delete?" title="Delete"><i class="fa fa-trash"></i></a>

	</td>

	</tr>

	<?php }  }  ?>

			  </tbody></table>

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



 

