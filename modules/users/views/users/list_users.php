<table width="349" border="0" align="center">
<?php
if(count($this->template->list_users)>0)
{
	foreach($this->template->list_users as $user)
	{ ?>
	<script>
	$(document).ready(function(){
	$("#friend<?php echo $user->id;?>").click(function(){$("#friend_form<?php echo $user->id;?>").toggle("slow");});
	$("#cancel<?php echo $user->id;?>").click(function(){$("#friend_form<?php echo $user->id;?>").hide("slow");});
	})
	</script>

    <tr>
       <td>
          <table align="center">
          <tr>
            <td width="105" rowspan="4"><a href="<?php echo $this->docroot ;?>profile/index/<?php echo $user->id; ?>">
<img style="border:1px solid #ccc; padding:5px; " src="<?php echo $this->docroot;?>public/user_photo/50/<?php echo $user->id;?>.jpg"  alt="<?php echo $user->name; ?>" title="<?php echo $user->name; ?>" onerror="this.src='<?php echo $this->docroot;?>/public/images/no_image11.jpg';"/>
</a></td>
            <td width="222"><a href="<?php echo $this->docroot ;?>profile/index/<?php echo $user->id; ?>"><?php echo $user->name.$user->last_name ; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $user->street; ?></td>
          </tr>
          <tr>
            <td><?php echo $user->city; ?></td>
          </tr>
          <tr>
            <td><?php echo $user->gender; ?></td>
          </tr>
          <tr>
          <td>&nbsp;</td>
          <?php 
		  if($user->fid=='' && $user->zid=='')
		  { ?>
		   <td><div id="friend<?php echo $user->id;?>" style="cursor:pointer;"><strong>Add As Friend</strong></div></td>
		<?php  }
		  else
		  { ?>
		   <td width="10"></td>
		<?php  }
		  ?>
          
           
           
          </tr>
          </table>
      </td>
   </tr>
   <tr>
	<td>
		<div id="friend_form<?php echo $user->id;?>" style=" display:none;">
            <form  action="" method="post"  >
            <table width="300" border="0">
            <tr>
            <td>
            <textarea style="height:70px; width:250px;" id="description3"  name="friend_comment">Hi <?php echo $user->name;?>,
            Add Me as your friend</textarea>
            </td>
            </tr>
            <tr>
            <td><input type="submit" class="convey"  value="submit" id="send<?php echo $user->id;?>" >
             <input type="button"  class="convey" value="cancel" id="cancel<?php echo $user->id;?>"></td>
            </tr>
            <input type="hidden" name="friends_id" id="friends_id" value="<?php echo $user->id;?>">
            </table>
          </form>
		</div>
	</td>
   </tr>
   <tr>
   <td><hr /></td>
   </tr>
<?php 
	}
}
else
{
	echo "No Users Found";
}

?> 

</table>
