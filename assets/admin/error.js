
	function showErrorMessage(id,msg){
		$("#"+id).html(msg);
		$("#"+id).addClass("err-msg");
		$("#"+id).removeClass("success-msg");
	}
	
	function showSuccessMessage(id,msg){
		$("#"+id).html(msg);
		$("#"+id).addClass("success-msg");
	    $("#"+id).removeClass("err-msg");
	}
