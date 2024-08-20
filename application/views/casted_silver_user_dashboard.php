
<style>
	label{
        color:#fff !important;
	}
</style>
<div class="container py-5">
<h1 class="text-center upperCase ncolor3">Dashboard</h1>
<div id="orders_div">

</div> 
</div> 


<script>  
function openData()
{
	$("#mymodel1").modal('show');
}
getData();
function getData()
{
	$.ajax({  
	type: "POST",    
	dataType: "html",    
	url: "<?php echo site_url(); ?>casted_silver_user_dashboard_ajax",    
	data: $("#search_form").serialize()})
	.done(function(data){
	$("#orders_div").html(data);
	});
}
</script>  