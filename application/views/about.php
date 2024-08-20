
<div class="container py-5 text-white" style="min-height:500px;">
<h1 class="text-center color1 text-uppercase"><?php echo $record['h1_tag']; ?></h1>
<?php echo $record['description']; ?>

<?php	
	if(!empty($pdfs)){
	foreach($pdfs as $key => $row){ 
?> 
<div class="mb-3">
	<div class="p-3 nbg2 text-white" onclick="showCollapse(<?php echo $key; ?>)"><?php echo $row['link']; ?> <i class="fa fa-plus float-right"></i> </div>
	<div id="demo_<?php echo $key; ?>" style="display:none;">
		<div class="p-3 border nbr2">
			<div class="row">
				<div class="col-md-4">
					<form method="post" onsubmit="return getPdf(<?php echo $key; ?>)">
					<div class="input-group">
					<input type="text" class="form-control" placeholder="Enter Code" id="code_<?php echo $key; ?>" autocomplete="off" required>
					<input type="hidden" id="id_<?php echo $key; ?>" value="<?php echo $row['id']; ?>">
					<div class="input-group-append">
					<button class="btn abt-btn" type="submit">Submit</button>
					</div>
					</div>
					</form>
				</div>
			</div>
			<div id="pdf_div_<?php echo $key; ?>">
			</div>
		</div>
	</div>
</div>	
<?php }}  ?>	
</div>

<script>
	function showCollapse(key){
		$('#code_'+key).val('');
		$('#pdf_div_'+key).html('');
		$('#demo_'+key).slideToggle();
	}
	function getPdf(key){
		var id=$("#id_"+key).val();
		var code=$("#code_"+key).val();
		$.ajax({    
		type: "POST",    
		dataType: "html",    
		url: "<?php echo base_url();?>get_pdf",    
		data: {id:id,code:code}})
		.done(function(data) { 		
		$('#pdf_div_'+key).html(data);
		});
		return false;
	}
</script>