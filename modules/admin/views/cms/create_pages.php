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
</script>

<!--manage cmss -->

 
 



<!-- Create page -->
<div class="span-19 border_bottom" >
<div class="span-18" >

<div class="span-16">
<form action="<?php echo $this->docroot;?>admin_cms/create_pages" method="post"  name="frm" id="frm"   >
<table border="0" cellpadding="10" cellspacing="10"> 
<input type="hidden" name="cms_id" value=""/>
<tr><td>Title</td></tr>
<tr><td><input  type="text" id="title" name="title" style="width:508px;"   value=""  class="required" / ></td></tr>
<tr><td style="vertical-align:top;">Description</td></tr>
<tr><td><textarea id="markItUp" name="markItUp" cols="80" rows="20" class="required"><?php echo $this->input->post('markItUp');?>
</textarea></td>
</tr>
<tr><td>Meta Tag(optional)</td></tr>
<tr><td><input  type="text" id="meta" name="meta" style="width:508px;"   value="<?php echo $this->input->post('meta');?>"  / ></td></tr>
<tr><td>Meta Description(optional)</td></tr>
<tr><td><textarea name="meta_desc" id="meta_desc" cols="70" rows="5"></textarea></td></tr>
<tr>
<td><input  type="submit" value="Create" name="Create"/><input type="button" value="Cancel" onclick="window.location='<?php echo $this->docroot;?>admin_cms';"/></td>
</tr>

</table>
</form>
</div></div></div>
