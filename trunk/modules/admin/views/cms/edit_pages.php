<?php
/**
 *
 * @package    Core
 * @author     M.Balamurugan
 * @copyright  (c) 2010 Ndot.in
 */

?>


<!-- markItUp! -->
<script type="text/javascript" src="<?php echo $this->docroot;?>/public/js/Html_editor/jquery.markitup.pack.js"></script>
<!-- markItUp! toolbar settings -->
<script type="text/javascript" src="<?php echo $this->docroot;?>/public/js/Html_editor/set.js"></script>
<!-- markItUp! skin -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->docroot;?>/public/css/Html_editor/style2.css" />
<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="<?php echo $this->docroot;?>/public/css/Html_editor/style.css" />


<script type="text/javascript">
<!--
$(document).ready(function()	{
	// Add markItUp! to your textarea in one line
	// $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
	$('#markItUp').markItUp(mySettings);
	
	// You can add content from anywhere in your page
	// $.markItUp( { Settings } );	
	$('.add').click(function() {
 		$.markItUp( { 	openWith:'<opening tag>',
						closeWith:'<\/closing tag>',
						placeHolder:"New content"
					}
				);
 		return false;
	});
	
	// And you can add/remove markItUp! whenever you want
	// $(textarea).markItUpRemove();
	$('.toggle').click(function() {
		if ($("#markItUp.markItUpEditor").length === 1) {
 			$("#markItUp").markItUpRemove();
			$("span", this).text("get markItUp! back");
		} else {
			$('#markItUp').markItUp(mySettings);
			$("span", this).text("remove markItUp!");
		}
 		return false;
	});
	
	//for create form validation
	$("#frm").validate();
	
});
-->
</script>
<!--manage cmss -->

 
 



<!-- edit page -->
<div class="span-19 border_bottom" >
<div class="span-18" >

<div class="span-16">
<form action="<?php echo $this->docroot;?>admin_cms/edit_cms" method="post"  name="frm" id="frm"   >
<table border="0" cellpadding="10" cellspacing="10"> 
<input type="hidden" name="cms_id" value="<?php echo ucfirst($this->total_cms_pages['mysql_fetch_object']->cms_id); ?> "/>
<tr><td>Title</td></tr>
<tr><td><input  type="text" id="title" name="title" style="width:508px;"   value="<?php echo ucfirst($this->total_cms_pages['mysql_fetch_object']->cms_title); ?>"  class="required" / ></td></tr>
<tr><td>Page URL</td></tr>
<tr><td><input  type="text" id="url" name="url" style="width:508px;"   value="<?php echo $this->docroot;?>cms?page=<?php echo $this->total_cms_pages['mysql_fetch_object']->cms_title; ?>" readonly / ></td></tr>
<tr><td style="vertical-align:top;">Description</td></tr>
<tr><td><textarea id="markItUp" name="markItUp" cols="80" rows="20" class="required">
<?php echo ucfirst($this->total_cms_pages['mysql_fetch_object']->cms_desc); ?>
</textarea></td>
</tr>
<tr><td>Meta Tag(optional)</td></tr>
<tr><td><input  type="text" id="meta" name="meta" style="width:508px;"   value="<?php echo ucfirst($this->total_cms_pages['mysql_fetch_object']->cms_metatag); ?>"  / ></td></tr>
<tr><td>Meta Description(optional)</td></tr>
<tr><td><textarea name="meta_desc" id="meta_desc" cols="70" rows="5"><?php echo ucfirst($this->total_cms_pages['mysql_fetch_object']->cms_metadesc); ?></textarea></td></tr>
<tr>
<td>
<?php   echo UI::btn_("Submit", "edit", "Edit", "", "","edit","frm");?>
<?php   echo UI::btn_("button", "cancel", "Cancel", "", "window.location='".$this->docroot."admin_cms/'","frm","frm");?>
</td>
</tr>

</table>
</form>
</div></div></div>


