<script>
//delete blogs

function delete_blog(id)
{
var aa=confirm("Are you sure want to delete it?");
if(aa)
{
window.location='<?php echo $this->docroot;?>blog/delete/?bid='+id;
}
}
</script>
<?php 
/**
 * Defines my blog 
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
  if(count($this->template->get_blog)>0)      
  {
         echo UI::count_(count($this->template->get_blog));
         
  foreach ( $this->template->get_blog as $row )
  {
    ?>

			<script>
			 $(document).ready(function(){
	                 $("#delete_<?php echo $row->blog_id;?>").click(function(){ $("#delete_form<?php echo $row->blog_id;?>").toggle("show") });
	                 $("#close<?php echo $row->blog_id;?>").click( function(){  $("#delete_form<?php echo $row->blog_id;?>").hide("slow");  });
	                 $("#cancell<?php echo $row->blog_id;?>").click( function(){  $("#delete_form<?php echo $row->blog_id;?>").hide("slow");  });
			 });
			 </script>
			 
    <div class="span-19 pl-10 border_bottom mb-10 pb-10">
     <div class="span-1a fl">
    <?php 
        Nauth::getPhoto($row->user_id,$row->name);  ?>

    </div>

    <div class="span-17 ml-10">
    <p class="span-17">
    <a href="<?php echo $this->docroot;?>blog/view/<?php echo url::title($row->blog_title);?>_<?php echo $row->blog_id;?>" class="text_bold">  
    <?php echo $row->blog_title; ?> </a> <br>
    <span>
<?php if(strlen(htmlspecialchars_decode($row->blog_desc))>=200) 
	{ 
	echo substr(htmlspecialchars_decode($row->blog_desc),0,200)."..."; 
	} else { 
	echo htmlspecialchars_decode($row->blog_desc); 
	}?>
    </span>
    </p>
    
    <div class="span-17">
    <ul class="inlinemenu">
    
    <li class="color999"><?php Nauth::print_name($row->user_id,$row->name); ?> </li>
    <li> <span class="quiet">Posted on</span> <?php echo common::getdatediff($row->DATE);?></li> 
     
   <li class="color999"> <span>in</span>
   <a href="<?php echo $this->docroot ;?>blog/category/?id=<?php  echo $row->blog_category; ?>" title="<?php  echo $row->category_name; ?>">
   <?php echo $row->category_name;?></a></li>
   
    <li class="color999"> <a href="<?php echo $this->docroot;?>blog/view/<?php echo url::title($row->blog_title);?>_<?php echo $row->blog_id;?>">Comments (<?php echo $row->counts;?>)</a></li>
    <li class="color999">
    
    </li>
    <li class="color999"></li>
    </ul>
    </div>
    <div class="span-10 mt-5">
    <?php  echo UI::btn_("button", "Edit", "Edit", "", "javascript:window.location='".$this->docroot."blog/edit/?bid=".$row->blog_id."'", "Edit","Edit");?>
    <?php  echo UI::btn_("button", "del", "Delete", "", "", "delete_".$row->blog_id."","del");?>
    </div>
 
    </div>


                <!-- for delete -->
		<div id="delete_form<?php echo $row->blog_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Blog</h3>
		<span class="fr"e>
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->blog_id;?>"  >
		</span>
		<div class="clear fl">Are you sure want to delete this Blog? </div>
		<div class="clear fl mt-10" > 
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot."blog/delete/?bid=".$row->blog_id."' ", "delete_blog","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->blog_id."","");?>
		
		</div>
		</div>

    </div>

<?php 	}
  }
else
{
        echo UI::nodata_();
}
?>

<!-- innercontentfinish-->

<?php if($this->total>15)
  echo $this->template->pagination ; ?>



