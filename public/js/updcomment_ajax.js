/*
 * 
*/
var xmlhttp;
	function showlike(upd_id,user_id,like)
	{  

	var r=document.getElementById('comment_like'+upd_id).innerHTML;
	if(r=="Like")
	{
		document.getElementById('comment_like'+upd_id).innerHTML="Unlike";
	}
	else
	{
	document.getElementById('comment_like'+upd_id).innerHTML="Like";
	}

	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
	  alert ("Your browser does not support XMLHTTP!");
	  return;
	  }
	var url="/updates/update_like/";

	url=url+"?upd_id="+upd_id;
	url=url+"&user_id="+user_id;
	url=url+"&like="+like;

	$.get(url,function(feedback){

	if(feedback)
	{

	        document.getElementById('upd_like'+upd_id).innerHTML=feedback;
	        return true;
        }
        else
        {

                document.getElementById('upd_like'+upd_id).innerHTML = '';
                return true;
        }
	});
	//xmlhttp.onreadystatechange=stateChanged();
	//xmlhttp.open("GET",url,true);
	//xmlhttp.send(null);
	}


	function clear_text(control)
	{
	if(document.getElementById(control.id).value=="Enter Comment"  )
		{
			document.getElementById(control.id).value="";	
			document.getElementById(control.id).style.background="none";
		}
	} 
	


        function imposeMaxLength(Object,event,id)
        { 
                var val=event.which;

                if(Object.value.length<140)
                {
                        document.getElementById('limits'+id).innerHTML = 139-Object.value.length + " Characters left";
                        return true;
                }
                else
                {
                        if(val<30)
                        {
                        return true;
                        }
                        else
                        {
                        //alert("max 140 char");
                        return false;
                        }
                }

        }


	function show_comment(upd_id,coment)
	{
	        if(document.getElementById('coment_text'+upd_id).value=="" || document.getElementById('coment_text'+upd_id).value=="Enter Comment")
	        {
	                document.getElementById('coment_text'+upd_id).style.background="#FBC0C0";
	                document.getElementById('coment_text'+upd_id).value="Enter Comment";
	                return false;
	        }
	        
	        document.getElementById('coment_text'+upd_id).style.background="none";
	        document.getElementById('coment_text'+upd_id).value="";
	        xmlhttp=GetXmlHttpObject();
	        if (xmlhttp==null)
	        {
	          alert ("Your browser does not support XMLHTTP!");
	          return;
	        }
	        
	        var url="/updates/adddeletecomment/";
	        url=url+"?upd_id="+upd_id;
	        url=url+"&coment="+coment;
	        $.get(url,function(feedback){
	        document.getElementById('cmd_content'+upd_id).innerHTML=feedback;
	        });

	}



	// for Show More (Pagination)
	function show_more(noofrecord,upd)
	{
	        document.getElementById('more').innerHTML="";
	        xmlhttp=GetXmlHttpObject();
	        
	        if (xmlhttp==null)
	        {
	          alert ("Your browser does not support XMLHTTP!");
	          return;
	        }
	        
	        var url="/updates/show_more/";
	        url=url+"?noofrecord="+noofrecord+"&upd="+upd;
	        $.get(url,function(feedback){
	        document.getElementById('more').innerHTML=feedback;
	        });
	 
	}



// to delete comments
function del_comment(cmd_id,upd_id)
{

        xmlhttp=GetXmlHttpObject();
        if (xmlhttp==null)
        {
          alert ("Your browser does not support XMLHTTP!");
          return;
        }

        var url="/updates/adddeletecomment/";
        url=url+"?id="+cmd_id;
        url=url+"&upd_id="+upd_id;
        $.get(url,function(feedback){
        document.getElementById('cmd_content'+upd_id).innerHTML=feedback;
        $.facebox.close();
        });

}



function GetXmlHttpObject()
{
        if (window.XMLHttpRequest)
        {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          return new XMLHttpRequest();
        }
        
        if (window.ActiveXObject)
        {
          // code for IE6, IE5
          return new ActiveXObject("Microsoft.XMLHTTP");
        }
        return null;
}

