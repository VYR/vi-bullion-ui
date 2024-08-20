
<div class="container py-5 text-white" style="min-height:500px;">
<h1 class="text-center color1 text-uppercase mb-3"><?php echo $record['h1_tag']; ?></h1>
	<?php	
	if(!empty($addresses)){
	foreach($addresses as $key => $row){ 
	?> 
	<div class="row">
		<div class="col-md-6 mb-3">
			<h2>Address</h2>
			<i class="fa fa-map-marker"></i> <?php echo $row['address']; ?>
		</div>
		<div class="col-md-6 mb-3">
			<iframe src="<?php echo $row['google_map']; ?>" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
		</div>
	</div>
	<?php }}  ?>
	<h2 class="text-center color1"><?php echo $record['h2_tag']; ?></h2>
	<form method="post" id="contact_form">
	<div class="row">
		<div class="col-md-4 mb-3">
			<label>Name <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
		</div>
		<div class="col-md-4 mb-3">
			<label>Mobile <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile" required>
		</div>
		<div class="col-md-4 mb-3">
			<label>Email <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="email" placeholder="Email" name="email" required>
		</div>
		<div class="col-md-12 mb-3">
			<label>Subject <span class="text-danger">*</span></label>
			<textarea class="form-control" id="subject" placeholder="Subject" name="subject" required></textarea>
		</div>
		<div class="col-md-12 mb-3 text-center">
			<button type="submit" id="submit_id" class="btn abt-btn">SUBMIT</button>
			<div id="alert_div"></div>
		</div>
	</div>
	</form>
</div>
<script>
$(document).ready(function(){	

$("#contact_form").on("submit", function(e){
e.preventDefault();	
var user_mobile=$("#mobile").val();
if(user_mobile.length==10 && user_mobile>6000000000 && user_mobile<10000000000){
$("#contact_form #submit_id").attr('disabled',true);
$("#contact_form #submit_id").text('Please Wait...');
let data = new FormData($("#contact_form")[0]);
$.post({
type: "post",
url:"<?php echo base_url(); ?>contact_ajax",
data:data,
processData: false,
contentType: false,
success:function(result)
{		
var jsondata=jQuery.parseJSON(result);	
if(jsondata['status']==1)
{
$('#alert_div').html('<div class="alert alert-success">'+jsondata['msg']+'</div>');
setTimeout(function(){ window.location.reload(); }, 1000);
}
else
{
$('#alert_div').html('<div class="alert alert-danger">'+jsondata['msg']+'</div>');
}
$("#contact_form #submit_id").attr('disabled',false);
$("#contact_form #submit_id").text('Submit');
}
});	
}else{				
$('#alert_div').html('<div class="alert alert-danger">Enter valid mobile number</div>');
}
$('#alert_div').show();
$('#alert_div').fadeOut(3000);
});	

});


</script>
