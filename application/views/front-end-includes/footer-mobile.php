<?php
	$this->load->model(array('Common_model','Admin_model'));
	$home_content = $this->Common_model->get_record('tbl_home_content', '*', array('id'=>1),2);
?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/jquery.toast.js"></script>
<?php
echo $this->session->flashdata('success');
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
