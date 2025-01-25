



	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	<h1>
	Vi Super Payments
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

	<form role="form" id="submit_form" method="post" enctype="multipart/form-data">
	<div class="box">

	<!-- /.box-header -->
	<div class="box-body">
		<div class="row" >
		<?php if(empty($record)){ ?> 
		<div class="col-md-3 col-xs-4">
			<select class="form-control" id="heading" name="heading" required>
				<option value="">Select Heading</option>
				<?php	
				for($i=0;$i<6;$i++){ 
				$date=date("Y-m-01",strtotime("+".$i." months"));
				$date_text=date("M Y",strtotime("+".$i." months"));
				?> 
				<option value="<?php echo $date; ?>"><?php echo $date_text; ?></option>
				<?php }  ?>
			</select>
		</div>
		<div class="col-md-3 col-xs-4">
			<button type="button" onclick="showPayments()" class="btn btn-primary">Submit</button>
		</div>
		<?php }else{ ?> 
		<div class="col-md-6 col-xs-8">
			<input type="hidden" id="heading" name="heading" value="<?php echo date("Y-m-01",strtotime($record['heading'])); ?>">
			<?php echo date("M Y",strtotime($record['heading'])); ?>
		</div>
		<?php } ?>
		<div class="col-md-6 col-xs-4 text-right">
			<a href="<?php echo base_url(); ?>admin/vi_payments" class="btn btn-danger">Back</a>
		</div>
		</div>
	</div>
	<!-- /.box-body -->
	</div>          <!-- /.box -->

	<input type="hidden" id="edit" name="edit" value="<?php if(!empty($records)){ echo '1'; }else{ echo '0'; } ?>">
	<input type="hidden" id="pro_percentage" name="pro_percentage" value="<?php echo $super['pro_percentage']; ?>">
	<input type="hidden" id="super_percentage" name="super_percentage" value="<?php echo $super['super_percentage']; ?>">
	<input type="hidden" id="submit_id" name="submit_id" value="0">
	<div class="box" id="payments_div" <?php if(empty($record)){ ?>style="display:none;"<?php } ?>>
		<div class="box-header">
			<h3 class="box-title">Vi Payments Table</h3>
			<div id="dmsg"></div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive" id="">
			<table id="" class="table table-bordered table-striped">            
			<thead>       
			<tr>       
			<th>SNO</th> 
			<th>Date</th>  
			<th>Fixed Amount</th>  
			<th>Rate/Gram</th>  
			<th>Total Grams</th> 
			<th>Commission</th>     
			<th>Amount</th>     
			<th>Super Amount</th>  
			<th>Pro Amount</th>  
			<th>Action</th>  
			</tr>       
			</thead>   
			<tbody>
			<?php 
				for($i=0;$i<20;$i++){ 
				$row=array();
				if(!empty($records)){					
				$row=$records[$i];
				}
			?> 
			<tr class="text-center">
			<td><?php echo $i+1; ?></td>
			<td>
			<input type="text" class="form-control datepicker" id="date_<?php echo $i; ?>" name="date[]" value="<?php if(!empty($row)){ echo date("Y-m-d",strtotime($row['date'])); }else{ echo date("Y-m-d"); } ?>">
			</td>
			<td>
			<input type="text" class="form-control" id="fixed_amount_<?php echo $i; ?>" name="fixed_amount[]" value="<?php if(!empty($row) && !empty($row['rate_per_gram'])){ echo $row['fixed_amount']; }else{ echo $super['fixed_amount']; } ?>" readonly>							
			</td>
			<td>
			<input type="text" class="form-control" id="rate_per_gram_<?php echo $i; ?>" name="rate_per_gram[]" value="<?php if(!empty($row)){ echo $row['rate_per_gram']; } ?>" onkeyup="calcAmount(<?php echo $i; ?>)" onkeydown="calcAmount(<?php echo $i; ?>)">							
			</td>
			<td>
			<input type="text" class="form-control" id="total_grams_<?php echo $i; ?>" name="total_grams[]" value="<?php if(!empty($row)){ echo $row['total_grams']; } ?>" readonly>							
			</td>
			<td>
			<input type="text" class="form-control" id="commission_<?php echo $i; ?>" name="commission[]" value="<?php if(!empty($row)){ echo $row['commission']; } ?>" onkeyup="calcAmount(<?php echo $i; ?>)" onkeydown="calcAmount(<?php echo $i; ?>)">							
			</td>
			<td>
			<input type="text" class="form-control" id="amount_<?php echo $i; ?>" name="amount[]" value="<?php if(!empty($row)){ echo $row['amount']; } ?>" readonly>							
			</td>
			<td>
			<input type="text" class="form-control" id="super_amount_<?php echo $i; ?>" name="super_amount[]" value="<?php if(!empty($row)){ echo $row['super_amount']; } ?>" readonly>							
			</td>
			<td>
			<input type="text" class="form-control" id="pro_amount_<?php echo $i; ?>" name="pro_amount[]" value="<?php if(!empty($row)){ echo $row['pro_amount']; } ?>" readonly>							
			</td>
			<td>
				<button type="submit" class="btn btn-primary" onclick="submitPayments(<?php echo $i; ?>)">Submit</button>
			</td>
			</tr>
			<?php }   ?>
			</tbody></table>
		</div>
	</div>
	</form>
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
	function showPayments(){
		var heading1=$("#heading").val();
		$("#payments_div").hide();
		if(heading1!=''){			
			$("#payments_div").show();
		}else{	
			$.toast({heading: 'Error',text: 'Select Heading',showHideTransition: 'fade',position: 'top-right',icon: 'error'});		
		}
	}
	function submitPayments(id){
		$("#submit_id").val(id);
	}
	function calcAmount(id){
		var fixed_amount=$("#fixed_amount_"+id).val();
		var rate_per_gram=$("#rate_per_gram_"+id).val();
		var total_grams=Math.round(parseInt(fixed_amount)/parseInt(rate_per_gram));
		$("#total_grams_"+id).val(total_grams);
		var commission=$("#commission_"+id).val();
		if(commission!=''){
			var amount=Math.round(total_grams*commission);			
			/*amount = amount.toFixed(2);*/
			$("#amount_"+id).val(amount);
			if(amount!=''){
				var super_percentage=$("#super_percentage").val();
				var super_amount=Math.round((amount/10)*parseInt(super_percentage));
				$("#super_amount_"+id).val(super_amount);
				var pro_percentage=$("#pro_percentage").val();
				var pro_amount=Math.round((amount/10)*parseInt(pro_percentage));
				$("#pro_amount_"+id).val(pro_amount);
			}
		}
	}
	$(document).ready(function(){	
		$("#submit_form").on("submit", function(e){
			e.preventDefault();
			var submit_id=$("#submit_id").val();
			var date=$("#date_"+submit_id).val();
			var fixed_amount=$("#fixed_amount_"+submit_id).val();
			var rate_per_gram=$("#rate_per_gram_"+submit_id).val();
			var total_grams=$("#total_grams_"+submit_id).val();
			var commission=$("#commission_"+submit_id).val();
			var amount=$("#amount_"+submit_id).val();
			var super_amount=$("#super_amount_"+submit_id).val();
			var pro_amount=$("#pro_amount_"+submit_id).val();
			if(date==''){	
				$.toast({heading: 'Error',text: 'Select date',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else if(fixed_amount==''){
				$.toast({heading: 'Error',text: 'Select fixed amount',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else if(rate_per_gram==''){
				$.toast({heading: 'Error',text: 'Select rate per gram',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else if(total_grams==''){
				$.toast({heading: 'Error',text: 'Select total grams',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else if(commission==''){
				$.toast({heading: 'Error',text: 'Select commission',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else if(amount==''){
				$.toast({heading: 'Error',text: 'Select amount',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else if(super_amount==''){
				$.toast({heading: 'Error',text: 'Select super amount',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else if(pro_amount==''){
				$.toast({heading: 'Error',text: 'Select pro amount',showHideTransition: 'fade',position: 'top-right',icon: 'error'});
			}else{
				$("#submit_form #submit_id").attr('disabled',true);
				$("#submit_form #submit_id").text('Please Wait...');
				let data = new FormData($("#submit_form")[0]);
				$.post({
					type: "post",
					url:"<?php echo base_url(); ?>admin/vi_payments_ajax",
					data:data,
					processData: false,
					contentType: false,
					success:function(result)
					{		
						var jsondata=jQuery.parseJSON(result);	
						if(jsondata['status']==1)
						{
							$.toast({heading: 'Success',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'success'});
							setTimeout(function(){ window.location = "<?php echo base_url(); ?>admin/vi_payments"; }, 1000);
						}
						else
						{
							$.toast({heading: 'Error',text: jsondata['msg'],showHideTransition: 'fade',position: 'top-right',icon: 'error'});		
						}
						$("#submit_form #submit_id").attr('disabled',false);
						$("#submit_form #submit_id").text('Submit');
					}
				});	
			}
		});
	});
	</script>

