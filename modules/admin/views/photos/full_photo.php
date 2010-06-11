<?php
/**
 * Defines all full size photo
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
 
?>
<script type = "text/javascript">
function MaxLength(Object,event)
        {
                var val=event.which;

                if(Object.value.length<140)
                {
                        document.getElementById('limits').innerHTML = 140-Object.value.length + " Characters left";
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


$(document).ready(function(){$("#form").validate();});
</script>
<div style="float:left;">
<?php
//display the no of photos
if(count($this->template->full_photo) > 0)
{
foreach ($this->template->full_photo as $row)
{
?>
   <div class="fr mt-20" id="photo"><?php echo UI::a_tag("Back","Back","Back",$this->docroot."admin_photos/view/?album_id=".$row->album_id);?></div>

	<div class="span-19b fl text-align">
    	<div class="pho_fullimg  p2"> 
            <img src="<?php echo $this->docroot;?>/public/album_photo/normal/<?php echo $row->photo_id ;?>.jpg"  alt="<?php echo $row->photo_title ;?>" title="<?php echo $row->photo_title;?>" class="imgborder"/>
	 
            <p>
            	<?php 
					if($this->pagination->current_page > 1){
				?>
                <a href="<?php echo $this->docroot;?>admin_photos/zoom/<?php echo $this->pagination->current_page - 1;?>?album_id=<?php echo $row->album_id; ?>#photo" class="fl">
                    <img src="<?php echo $this->docroot;?>public/themes/default/images/back.gif"  />
                </a>
                
                <?php 
					}
					if($this->pagination->total_pages > $this->pagination->current_page ){
				?>
            
                <a href="<?php echo $this->docroot;?>admin_photos/zoom/<?php echo $this->pagination->current_page + 1;?>?album_id=<?php echo $row->album_id; ?>#photo" class="fr">
                    <img src="<?php echo $this->docroot;?>public/themes/default/images/more.gif"  />
                </a>
                
                <?php } ?>
            
            </p>
        </div>
    	 	<p><?php echo $row->photo_desc;?></p>
	</div>
        
	

	<div style="float:left;width:735px;">Comments [<?php echo $row->count_comment;?>] 
        
        <?php  echo UI::btn_("button", "post", "Post Comment", "", "", "repl".$row->photo_id."",""); ?>
        </div>

	<script>
	$(document).ready(function()
	{

	$("#repl<?php echo $row->photo_id;?>").click(
	function()
	{

	$("#dd<?php echo $row->photo_id;?>").toggle("slow");

	});

	}); 
	</script>

	<!-- post the comments -->
	
<div class="span-13 mt-20">
	<form id="form" name="form" action="<?php echo $this->docroot;?>admin_photos/post_comment/" method="post"  >
	<div class="example" id="dd<?php echo $row->photo_id;?>" style="display:none;">
	<textarea  style="width:500px;height:100px;" id="comment" class="required "  name="photo_comment" onkeypress="return MaxLength(this,event);" ></textarea>

	<input type="hidden" value="<?php echo $row->photo_id;?>" name="photo_id">
	<input type="hidden" value="<?php echo $row->album_id;?>" name="album_id">
	<input type="hidden" value="<?php echo $this->userid; ?>" name="user_id">

	<div style="margin:1px 0px 0px 280px;">
	
	<?php  echo UI::btn_("Submit", "submit", "Submit", "", "", "sen".$row->photo_id."",""); ?> <span id="limits" class="quiet">Max 140 characters</span>
	
	
	 
	</form>
	
	</div>
	</div></div>
<div class="span-13 mt-20">
	<?php
	//show the comments lists
	if (count($this->template->show_comment) > 0)
	{
		foreach ($this->template->show_comment as $comment)
		{
		?>
		    <div class="span-13">
		    <div class="span-2">
		    <?php Nauth::getPhoto($comment->user_id,$comment->name,$comment->user_photo); //get the user photo?>
		    </div>

		    <div class="span-10">
		    <p class="common_box_c">
		    <?php echo $comment->comments;?>	   
		    </p>
		    <div class="common_box_bl">
		    <ul>
		    <li><span>Posted by </span><a href="<?php echo $this->docroot ;?>profile/view/<?php  echo $comment->user_id; ?>" title="<?php  echo $comment->name; ?>">
		    <?php if(!empty($comment->name)) { echo $comment->name; } else { echo "Guest"; } ?></a></li>
		    <li>On <?php if($comment->DATE==0) { echo "Today";} else { echo $comment->DATE." days ago"; }?></li>
		    
		    </ul>
		    </div>
		 
		    </div>
		    </div>

		<?php 
		}
	}
	else
	{
	?>
		<div class="no_data">No comments</div>
	<?php 
	} ?>

</div>
	</div>

<?php 
//end of the first loop
}
}
?>
</div>

