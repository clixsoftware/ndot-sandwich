<script>
//jquery to post the album
	$(document).ready(function()
	{
		$("#upload_form").validate();
	});
</script>
           <script>
            //Variable to store last file input Index
            var PowUploadLastFileIndex = 1;
            var count=1;
            var Upload_File= new Array(100); 
            Upload_File[1]='file1';
            var control_id;
            function AddFileInput(parentObjID)
            { 
                var parentObj = document.getElementById(parentObjID);
                PowUploadLastFileIndex ++;    
                var newFileIndex = PowUploadLastFileIndex;
                var newFileInputID = 'repeat_fields' + newFileIndex;
                var newFileInput = document.createElement('div');    
                newFileInput.setAttribute("id", newFileInputID);    
				//alert(document.getElementById('filediv1').innerHTML);
				newFileInput.setAttribute("style","margin:2px 0px 5px 0px;");
				newFileInput.innerHTML =document.getElementById('repeat_fields').innerHTML;
               
                newFileInput.innerHTML += '<br>';
                parentObj.appendChild(newFileInput);
               
            }
            </script>

   <div class="span-19a">
	<div id="cont_pb">
	<p class="pho_imgtype  mb-20">You can upload multiple JPG, GIF, or PNG files. (Maximum size of 1MB per photo
	).</p>
	<form name="upload_form" id="upload_form" action="" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="album_id" value="<?php echo $this->album_get_data->current()->album_id;?>">
    <input type="hidden" name="userid" value="<?php echo $this->album_get_data->current()->user_id;?>">
	<div id="upload_photos" class="span-18 ml-30 mb-10 mt-20"   >
	
	<div id="repeat_fields">
	<label>Title: </label><input type="text"  name="photo_title[]" id="photo_title" class="required title" title="Enter the Title"  /><br/><br/>
     <label>Photo: </label><input type="file" name="upload_photo[]" id="upload_photo" size="30" title="Select the Photo" class="required" ><br/><br/>
	</div>
	
	</div>
	
	<div class="fl  span-18  ml-30 mb-10" >
    
     <?php  echo UI::btn_("Submit", "submit", "submit", "", "", "upload_photo","upload_photo");?>
     <?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."photos/?id".$this->userid."' ", "cancel","");?>
 	
        <a onClick="javascript: AddFileInput('upload_photos');" style="cursor:pointer;" class="fl"> &nbsp; Add More</a>
        </div>
        
	</form>
	</div>	</div>

