$(function()
{
	var a=getLocalData('user');
	console.log(a);
	if(getLocalData('user')==null )

	{
		location.href=admin_url;
		

	}
	
});

setInterval(myLogout, 1800000 );

function myLogout() {
 localStorage.clear();
	location.href =root_path;	
}