 <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
<footer class="main-footer">
    
    <strong>Copyright &copy; <?php date("Y"); ?> <a href="https://vibullion.com">VI Bullion</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/admin/dist/js/demo.js"></script>
<!-- page script -->
<script>
	$(function () 
	{ 
	CKEDITOR.replace('editor1'); 
	CKEDITOR.replace('editor2'); 
	CKEDITOR.replace('editor3'); 
	CKEDITOR.replace('editor4'); 
	CKEDITOR.replace('editor5'); 
	CKEDITOR.replace('editor6'); 
	$(".my-colorpicker2").colorpicker();
	}); 
</script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/jquery.toast.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/jquery-confirm.min.js"></script>

<script>
  $(function () {
	 $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  })
</script>
<script src="<?php echo base_url(); ?>assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
	  format: 'yyyy-mm-dd'
    })
</script>
<script type="text/javascript">
	
	$(document).ready(function(){
		$('a.confirm_alert').confirm({
		 content: "",
		});
		$('a.confirm_alert').confirm({
			buttons: {
				hey: function(){
					location.href = this.$target.attr('href');
				}
			}
		});	
	});
</script>
<?php

if($this->session->flashdata('success') != '')
{
$msg = $this->session->flashdata('success');
$heading = 'Success';
$icon = 'success';
}else
if ($this->session->flashdata('error') != '')
	{
	$msg = $this->session->flashdata('error');
	$heading = 'Error';
	$icon = 'error';
	}
  else
if (isset($error) && $error != '')
	{
	$msg = $error;
	$heading = 'Error';
	$icon = 'error';
	}
  else
if (isset($success) && $success != '')
	{
	$msg = $success;
	$icon = 'success';
	$heading = 'Success';
	}else{
		$msg = '';
$icon = '';
$icon = '';

	}		
?>
<script>
	<?php
	if ($msg != '')
	{ ?>
		$.toast({heading: '<?php echo $heading; ?>',text: '<?php echo $msg; ?>',showHideTransition: 'fade',position: 'top-right',icon: '<?php echo $icon; ?>'});
	<?php
	} ?>
</script>
</body>
</html>
