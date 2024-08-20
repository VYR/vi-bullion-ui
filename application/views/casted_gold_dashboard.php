
<style>
	label{
        color:#fff !important;
	}
</style>
<div class="container py-5">
<h1 class="text-center upperCase color1">Dashboard</h1>
<form id="search_form" method="post">
   <div class="row register-form">
      <div class="col-md-3">
         <div class="form-group">
            <label for="email">Type:</label>
            <select class="form-control" onchange="getDashboard()">
				<option value="1">Casted Gold</option>
				<option value="2">Casted silver</option>
			</select>
         </div>
      </div>
      <div class="col-md-3">
         <div class="form-group">
            <label for="email">Unique Code:</label>
            <input type="text" id="unique_code" name="unique_code" class="form-control" placeholder="Enter Unique Code *" required>
         </div>
      </div>
	  <div class="col-md-3">
        <div class="form-group">
            <label for="email">Password:</label>
            <input type="text" id="password" name="password" class="form-control" placeholder="Enter Password *" required>
         </div>
      </div>
	 
		
	   <div class="col-md-3">
  <label for="email">Search:</label>
        <button type="submit" id="submit_id" class="btn btn-block abt-btn">SEARCH</button> 
      </div>
   </div>
</form>
<div id="orders_div">

</div> 
</div> 


<div class="modal" id="mymodel1">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bgdark1">
        <h4 class="modal-title ">Total Sales</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="table-responsive">
       <table class="table table-striped table-bordered table-hover"><thead><tr class="bgdark"><th>S.No</th><th>Order ID</th><th>Order Amount</th><th>Coupon Code</th><th>Discount</th><th>Date</th><th>Bill</th></tr></thead><tbody><tr><td>1</td><td>308584058</td><td>540.00</td><td>W3NP05</td><td>10%</td><td>2020-03-14 14:46:02</td><td><a href="/Reports/pdf?oid=47" target="_blank">Show</a></td></tr><tr><td>2</td><td>337785235</td><td>1440.00</td><td>W3np05</td><td>10%</td><td>2020-07-18 14:59:48</td><td><a href="/Reports/pdf?oid=50" target="_blank">Show</a></td></tr></tbody></table>
      </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
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
		url: "<?php echo site_url(); ?>casted_gold_dashboard_check",    
		data: $("#search_form").serialize()})
		.done(function(data){
			$("#orders_div").html(data);
		});
		$("#search_form #submit_id").attr('disabled',false);
		$("#search_form #submit_id").text('SEARCH');
		});	
	});		 
</script>
