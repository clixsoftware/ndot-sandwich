<?php
if(!empty($this->profile_info)){
	if($this->profile_info["mysql_fetch_array"]->id == $this->userid){
		if(!empty($this->template->request) && count($this->template->request) > 0){
			$i = 1;
?>

			<div class=" span-5 suggestion borderf p2">
			<h3 class="sub-heading">Friend Requests  <span class="fr mr-5"><?php if(count($this->template->request) > 0) { ?><a href="/profile/openrequest/">View all</a> <?php } ?></span></h3>
            
<?php
       		foreach($this->template->request as $request){
				if($i <= 2){
       ?>
       				<div class="span-5 mb-10">
					<div class="span-2 m0">
                    <?php echo Nauth::getPhoto($request->id,$request->name);?>
                    </div>
					<div class="span-3 last"  >
		<?php echo Nauth::print_name($request->user_id,$request->name); ?>
					<br/><?php echo substr($request->comments,0,33);?>
					</div>
                    	<div class="span-4 mt-5" > 
                    	
                    	<?php  echo UI::btn_("button", "Accept", "Accept", "", "javascript:window.location.href='$this->docroot"."profile/add_friend/$request->request_id/1/$request->user_id'", "Accept","");?>
                    	
                    	<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location.href='$this->docroot"."profile/add_friend/$request->request_id/0/$request->user_id'", "Cancel","");?>
          					
          			</div>
 					</div>
 					<br />
<?php		
				}
				$i++;
			} ?>
			</div>
			<?php 
		}
	}	
}
?>
