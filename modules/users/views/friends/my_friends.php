<?php   
//list the my friends
?>

<div class="span-5 friends  borderf p2"  >
  <?php
	if(!empty($this->template->my_friends)){ 
?>
  <h3 class="sub-heading">
  <span class="fl">
    <?php 
	  	if($this->template->id == $this->userid){
	  		echo " Friends (".count($this->template->my_friends).')'; } else { echo 'Friends('.count($this->template->my_friends).')'; } 
		?>
        </span>
    <a href="<?php echo $this->docroot;?>profile/friends?uid=<?php echo $this->template->id; ?>" class="fr">View all</a></h3>
  <div  >
    <?php
		if($this->template->my_friends->count()>0)
		{	
			$count_frd=0;
			foreach($this->template->my_friends as $friends)
			{
			  $a = count($this->template->my_friends); 		
				if($count_frd < 9)
				 {?>
    <div class="span-1-5 mr-10 fri_rcon"> <?php echo Nauth::getPhotoName($friends->id,$friends->name);?></div>
    <?php }
				$count_frd++;	
				if($count_frd%3==0){
					echo '<div class="span-5"></div>';
				}
			}	
				 if($this->template->my_friends->count()>9){?>
    <!--<div class="span-5 text-right " > <a href="<?php echo $this->docroot;?>profile/friends?uid=<?php echo $this->template->id;  ?>" class="less_link">More..</a> </div> -->
    <?php } 	
		}
		else{
			echo "No friends";
		}	
			?>
  </div>
  <?php 
}
else
{ 
	echo "No Friends";	
}
?>
</div>
