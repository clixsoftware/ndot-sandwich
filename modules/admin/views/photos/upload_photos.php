	<script type="text/javascript">
	//upload form validation
	/* function photo_validation()
	{
	//title
                if(document.upload_form.photo_title.value=="")
                {
                alert("Please enter the title");
                return false;
                }
                if(document.upload_form.upload_photo.value=="")
                {
                alert("Please select the image");
                return false;
                }

                if(document.getElementById("upload_photo").value!="")
                {
                checkval=document.getElementById("upload_photo").value;
                var check=checkval.indexOf('.');
                var ext=checkval.substr(check+1,checkval.length);
                if(ext=='jpg' || ext=='gif' || ext=='png' || ext=='JPG' || ext=='GIF' || ext=='PNG')
                {
                }
                else
                {
                alert('Select the valid image');
                document.getElementById("upload_photo").value='';
                return false;
                }
                }

                return true;
	 } */

	$(document).ready(function(){$("#addcat").validate();});
	</script>
	<div id="cont_pb">
	<p>You can upload multiple JPG, GIF, or PNG files. (Maximum size of 1MB per photo
	).</p>
	<form name="upload_form" action="" method="post" enctype="multipart/form-data" id="addcat">
	<table border="0" cellpadding="2" cellspacing="5" align="left">
	<tr>
	<td>Title</td>
	<td><input type="text" style="width:500px" name="photo_title" id="photo_title" class="required"></td>
	</tr>
	<tr>
	<td valign="top">Description</td>
	<td><textarea name="photo_description" id="photo_description" style="width:500px" rows="7" class="required"></textarea></td>
	</tr>
	<tr>
	<td>Upload the Image</td>
	<td><input type="file" name="upload_photo" id="upload_photo" size="68" class="required">
	</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td><?php echo UI::btn_("Submit", "Upload", "Upload", "", "", "new_q","Upload");?>
	<?php
	echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."admin_photos' ", "cancel","");
	?>
	</td>
	</tr>
	</table>
	</form>
	</div>

