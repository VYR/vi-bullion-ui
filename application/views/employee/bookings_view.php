
<style>
th,td{
	border:1px solid #dee2e6 !important;
}
</style>
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

					url:"<?php echo base_url(); ?>admin/bookings_ajax",

					data:data,

					processData: false,

					contentType: false,

					success:function(result)

					{		

						var jsondata=jQuery.parseJSON(result);	

						if(jsondata['status']==1)

						{

							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});

							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/bookings"; }, 1000);

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

       Bookings Details

        

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

	<div class="row">
		<div class="col-md-6 form-group">
			<label for="name">Date</label><br><?php echo date("d-M-Y", strtotime($record['booking_date_time'])); ?>
		</div>
		<div class="col-md-6 form-group text-right">
			<label for="name">Indent Number</label><br><?php echo $record['booking_id']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Name</label><br><?php echo $record['name']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Mobile</label><br><?php echo $record['mobile']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Email</label><br><?php echo $record['email']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Company Name</label><br><?php echo $record['company_name']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Pan Number</label><br><?php echo $record['pan_number']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">GST Number</label><br><?php echo $record['gst_number']; ?>
		</div>
		<div class="col-md-4 form-group">
			<label for="name">Unique Code</label><br><?php echo $record['unique_code']; ?>
		</div>
	</div>
	<div class="table-responsive">
	<table class="table table-bordered table-striped">
	<thead>
	<tr>
	<th>Biscuit Type</th>
	<th>QTY</th>
	<th>Total KGS</th>
	<th>Amount</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td>
	<?php echo $record['biscuit_type']; ?>
	</td>
	<td>
	<?php echo $record['quantity']; ?>
	</td>
	<td>
	<?php echo $record['total_kgs']; ?>
	</td>
	<td>
	<?php echo $record['sub_total']; ?>
	</td>
	</tr>
	<tr>
		<th colspan="3" class="text-right">GST (<?php echo $record['gst_percentage']; ?>%)</th>
		<th>
		<?php echo $record['gst_amount']; ?>
		</th>
	</tr>
	<tr>
		<th colspan="3" class="text-right">Total</th>
		<th>
		<?php echo $record['total_amount']; ?>
		</th>
	</tr>
	</tbody>
	</table>
	</div>

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



 

