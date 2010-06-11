<table class="boxstyle" width="100%">
  <tr>
    <td><h1>There is <span style="color:#ff6600;"><?php echo count($this->fans); ?></span> fans for this page!</h1></td>
    <td><?php 
	if($this->check_fans>0)
	{
	?>
      <h5>You are a Fan </h5>
      <?php }else{?>
      <h5><a href="<?php echo  $this->thirdparty; ?>/comments/set_fan/?u_value=<?php echo url::title($this->url); ?>">Became a Fan</a>	</h5>
      <?php }
?>
    </td>
  </tr>
  <tr><td colspan="2">
  <?php 
	if(count($this->fans) > 0)
	{
	foreach($this->fans as $fan) {
		echo "<div style=' height:100px; width:70px; text-align:center; float:left;'>";
		echo Nauth::getPhotoTarget($fan->user_id,$fan->username);
		echo "</div>";
	}
	}?>  
  </td></tr>
</table>
