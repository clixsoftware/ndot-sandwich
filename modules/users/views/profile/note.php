<?php defined('SYSPATH') or die('No direct script access.'); ?>
<?php
		if(count($this->note_comments) > 0 || count($this->note_like) > 0){
			 foreach($this->note_comments as $note) { ?>
                <div class=" span-14  box fl ">
                    <div class="span-2 fl ">
                    	<?php Nauth::getPhoto($note->uid);	?>
                    </div>
                    
                    <div class="span-11 fl">
                   	 	<?php Nauth::print_name($note->uid, $note->uname); ?>
                    	<span class="quiet">commented on your Updates </span> <a href="<?php echo $this->docroot;?>updates/notification/<?php echo $note->id; ?>" title="<?php echo htmlspecialchars_decode($note->description);?>"> <?php echo htmlspecialchars_decode($note->description);?> </a>
                    </div>
                    
                    <div class="span-5 f1 pb5" > 
                    	<span class="quiet"><?php  echo common::getdatediff($note->date); ?> </span>
                    </div>
                </div>
    <?php 
			}
			foreach($this->note_like as $like) { ?>
                <div class=" span-14  box fl ">
                    <div class="span-2 fl ">
                    	<?php Nauth::getPhoto($like->uid);	?>
                    </div>
                    
                    <div class="span-11 fl">
                   	 	<?php Nauth::print_name($like->uid, $like->uname); ?>
                    	<span class="quiet">likes your Updates </span> <a href="<?php echo $this->docroot;?>updates/notification/<?php echo $note->id; ?>" title="<?php echo htmlspecialchars_decode($note->description);?>"><?php echo htmlspecialchars_decode($like->description);?> </a>
                    </div>
                    
                    <div class="span-5 f1 pb5" > 
                    	<span class="quiet"><?php  echo common::getdatediff($like->date); ?> </span>
                    </div>
                </div>
    <?php 
			}
		}
		else{
			echo "You have no other notifications";
		} 
	?>
