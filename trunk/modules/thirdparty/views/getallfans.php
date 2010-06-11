

<?php
if(count($this->getallfans) > 0)
{
        foreach($this->getallfans as $fans)
        {
                ?>
                <div class="span-15 border_bottom">
                <div class="span-2">
                <?php Nauth::getphoto($fans->user_id,$fans->username); ?>
                </div>
                <div class="span-12">
                
                </div>
                </div>
                <?php
        }
}
else
{
}
?>

