<?php
	//echo $this->username;
	if($this->userid > 0){
?>

<table class="boxstyle" width="100%">
  <tr>
    <td class="150px" width="100px"><div class="photobox">
        <?php Nauth::getPhotoName($this->userid,$this->username); ?>
      </div></td>
    <td><form name ="comments" action="<?php echo  $this->thirdparty; ?>/comments/third_party_set_updates" method="post">
        <input type="hidden" name="url" value="<?php echo $this->url; ?>" />
        <input type="hidden" name="userid" value="<?php echo $this->user_id; ?>" />
        <textarea type="text" name="comment_data" style="width:95%;" ></textarea>
        <br/>
        <input type="submit" value="Submit Comment" class="postbutton" />
        <spa>
        * Comment Required</span>
      </form></td>
  </tr>
</table>
<?php
}else{
?>
<table class="boxstyle" width="100%">
  <tr>
    <td><h1>Leave a comment</h1></td>
  </tr>
  <tr>
    <td class="iu"> You must be logged in to add comments on this page!</td>
    <td><a href="/" target="_blank">Login</a> or <a href="/"  target="_blank">Signup</a> to use our social portal integration</td>
  </tr>
</table>
<?php } ?>
<?php 
if(count($this->updates) > 0 ){
?>
<br/>
<table class="boxstyle" width="100%" cellpadding="10">
  <tr>
    <td><h1>There is <span style="color:#ff9f00;"><?php echo count($this->updates); ?></span> comments added!</h1>
      <br/>
      <?php
foreach($this->updates as $data)
{
	if($data->username)
	{ 
	?>
      <table width="100%">
        <td width="100px" valign="top"><?php Nauth::getPhotoTarget($data->user_id,$data->username); ?>
            <br/>
            <span class="date"><?php echo $data->dateofpost; ?></span> </td>
          <td class="boxwhitestyle"><?php echo $data->comment;  ?> 
                        
             </td>
      </table>
      <br/>
      <?php
	 } 
 }
?>
    </td>
  </tr>
</table>
<?php
 }
  ?>
