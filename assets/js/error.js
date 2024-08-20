var api_url="https://ahanaturals.com/api/index.php/";
var admin_url="https://ahanaturals.com/admin/";
var root_path="https://ahanaturals.com/";
var blog_path="https://ahanaturals.com/blog/";
	var editorFile= {

                    filebrowserBrowseUrl :'/assets/ckeditor/filemanager/browser/default/browser.html?Connector=/assets/ckeditor/filemanager/connectors/php/connector.php',

                    filebrowserImageBrowseUrl : '/assets/ckeditor/filemanager/browser/default/browser.html?Type=Image&amp;Connector=/assets/ckeditor/filemanager/connectors/php/connector.php',

                    filebrowserFlashBrowseUrl :'/assets/ckeditor/filemanager/browser/default/browser.html?Type=Flash&amp;Connector=/assets/ckeditor/filemanager/connectors/php/connector.php',

		    filebrowserUploadUrl  :'/assets/ckeditor/filemanager/connectors/php/upload.php?Type=File',

		    filebrowserImageUploadUrl : '/assets/ckeditor/filemanager/connectors/php/upload.php?Type=Image',

		    filebrowserFlashUploadUrl : '/assets/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'

 

};
function showSucessMessage(id,msg)
{
	$("#"+id).html(msg);
	$("#"+id).removeClass("fail");
	$("#"+id).addClass("success");
	
}
function showErrorMessage(id,msg)
{
	$("#"+id).html(msg);
	$("#"+id).removeClass("success");
	$("#"+id).addClass("fail");
	
}
function NumbersOnly(MyField, e, dec) {
	    var key;
	    var keychar;
	    if (window.event)
	        key = window.event.keyCode;
	    else if (e)
	        key = e.which;
	    else
	        return true;
	    keychar = String.fromCharCode(key);
	    if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) return true;
	    else if ((("0123456789").indexOf(keychar) > -1))
	        return true;
	    else if (dec && (keychar == ".")) {
	        MyField.form.elements[dec].focus();
	        return false;
	    } else
	        return false;
	}
function userLogout()
{			
	localStorage.clear();
	location.href =root_path;		
}
function displayDataTable()
	{
		var obj={
		  paging      : true,
		  lengthChange: true,
		  searching   : true,
		  ordering   : true,
		  info       : true,
		  autoWidth   : true
		};
		  $('#example2').DataTable(obj)
	}
	function displayDataTable1(id)
	{
		var obj={
		  paging      : true,
		  lengthChange: true,
		  searching   : true,
		  ordering   : true,
		  info       : true,
		  autoWidth   : true
		};
		  $('#'+id).DataTable(obj)
	}
	function converToJson(obj)
{
  return JSON.parse(obj); 
}
function getLocalData(key) 
{
    const obj = localStorage.getItem(key);
    if (obj == null)
    {
      return null;
    }
    else 
    {
      return JSON.parse(obj);
    }
}
function setLocalData(key, data)
{
    localStorage.setItem(key, JSON.stringify(data)); 
}

function logOut(name)

{

	
	localStorage.removeItem(name);
	
	
	if(getLocalData(name)==null )

	{
		if(name=='user')
		{
			location.href=rootpath;
		}
		else
		{
			location.href=admin_url;
		}

	}

}

function NumbersOnly(MyField, e, dec){	
		var key;			
		var keychar;		
		if (window.event)			   key = window.event.keyCode;			else if (e)			   key = e.which;			else			   return true;			keychar = String.fromCharCode(key);			if ((key==null) || (key==0) || (key==8) ||				(key==9) || (key==13) || (key==27) )			   return true;			else if ((("0123456789").indexOf(keychar) > -1))			   return true;			else if (dec && (keychar == "."))			   {			   MyField.form.elements[dec].focus();			   return false;			   }			else			   return false;		}

	
function ValidateEmail(mail) 
{
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 if (re.test(mail))
  {
    return true;
  }
  else 
  {
    return false;
  }
    
}

function getValue(id)
	{
	  return $('#'+id).val();
	}
function setData(id,data)
{
  return $('#'+id).html(data);
}
function setValue(id,data)
{
  $('#'+id).val(data);
}



