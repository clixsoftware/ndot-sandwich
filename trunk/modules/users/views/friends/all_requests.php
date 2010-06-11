<?php
if(!empty($this->profile_info)){
	if($this->profile_info["mysql_fetch_array"]->id == $this->userid){
		if(!empty($this->template->request) && count($this->template->request) > 0){
			$i = 1;
?>

            <div class="fri_rcon">
<?php
       		foreach($this->template->request as $request){
				if($i <= 2){
       ?>
       				<div class="span-13 fl">
					<div class="span-2 m0">
                    <?php echo Nauth::getPhoto($request->id,$request->name);?>
                    </div>
					<div class="span-7 last">
		<p><?php echo Nauth::print_name($request->user_id,$request->name); ?></p>
        <p><?php echo $request->city; ?> </p>
					<?php echo $request->comments;?>
					</div>
                    	<div class="span-4 mt-5"> 
                    	<?php  echo UI::btn_("button", "Accept", "Accept", "", "javascript:window.location.href='$this->docroot"."profile/add_friend/$request->request_id/1/$request->user_id'", "Accept","");?>
                    	
                    	<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location.href='$this->docroot"."profile/add_friend/$request->request_id/0/$request->user_id'", "Cancel","");?>
          					
          			</div>
 					</div>
                    
                     <div class="span-4">
						<p> <a href="<?php echo $this->docroot;?>inbox/compose?username=<?php echo $request->name; ?>&fid=<?php echo $request->id; ?>" title="Email" class="p_inbox" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Send Message </a> </p>
                     </div>		
<?php		
				}
				$i++;
			}
		}
		else{
			echo UI::nodata_();
		}
	}	
}
?>
