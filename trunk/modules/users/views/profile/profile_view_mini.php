<?php
			$this->minimodel=new Profile_Model();
			$this->miniprofile_resource = $this->minimodel->profile_info($this->miniuserid);
			$this->miniprofile = $this->miniprofile_resource["mysql_fetch_array"];
			//print_r($this->miniprofile);
?>  <div class=" inb_probout">
    <div class="inb_probt"><img src="/public/themes/default/images/inbox_probt.jpg" /></div>
    <div class="inb_probc p10">
      <div class="inb_bcin">
        <table  width="180"  border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td><span  class="displayblock">
              <?php Nauth::getphoto($this->miniprofile->id,$this->miniprofile->name); ?>
              </span></td>
            <td valign="top" class="pl-10"><?php Nauth::print_name($this->miniprofile->id,$this->miniprofile->name); ?>
              <p class="clear fl"><!--<?php echo $this->miniprofile->dobforamt; ?>,--> <?php echo $this->miniprofile->gender; ?>, <?php echo $this->miniprofile->city; ?><?php if($this->miniprofile->cdesc!=""){echo ', '.$this->miniprofile->cdesc; } ?>.</p></td>
          </tr>
          <tr>
            <td colspan="2">
              <p class=" span-4 quiet"><?php  if(strlen($this->miniprofile->message) > 32){ echo "Saying '".substr($this->miniprofile->message,0,32)."'";} else { echo $this->miniprofile->message; } ?> </p></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="inb_probb"><img src="/public/themes/default/images/inbox_probb.jpg" /></div>
  </div>
