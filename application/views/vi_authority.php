
<style>
	label{
        color:#fff !important;
	}
</style>
<div class="container py-5">
<h1 class="text-center upperCase color1">VI Grants</h1>
<form id="search_form" method="post">
   <div class="row register-form">
      <div class="col-md-4">
         <div class="form-group">
            <label for="email">Unique Code:</label>
            <input type="text" id="unique_code" name="unique_code" class="form-control" placeholder="Enter Unique Code *" required>
         </div>
      </div>
	  <div class="col-md-4">
        <div class="form-group">
            <label for="email">Password:</label>
            <input type="text" id="password" name="password" class="form-control" placeholder="Enter Password *" required>
         </div>
      </div>
	 
		
	   <div class="col-md-4">
  <label for="email">Search:</label>
        <button type="submit" id="submit_id" class="btn btn-block abt-btn">SEARCH</button> 
      </div>
   </div>
</form>
<div id="orders_div">

</div> 
</div> 


<script>  
function openData()
{
	$("#mymodel1").modal('show');
}
function getDashboard()
{
	location.href="<?php echo site_url(); ?>casted-silver-dashboard";
}
</script>  
<script>
	$(document).ready(function(){
		$("#search_form").on("submit", function(e){
		e.preventDefault();	
		$("#search_form #submit_id").attr('disabled',true);
		$("#search_form #submit_id").text('Please Wait...');
		$.ajax({  
		type: "POST",    
		dataType: "html",    
		url: "<?php echo site_url(); ?>vi_authority_check",    
		data: $("#search_form").serialize()})
		.done(function(data){
			$("#orders_div").html(data);
		});
		$("#search_form #submit_id").attr('disabled',false);
		$("#search_form #submit_id").text('SEARCH');
		});	
	});		 
</script>
