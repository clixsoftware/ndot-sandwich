<?php
/**
 * Edit the Template
 *
 * @package    Core
 * @author     M.Balamurugan
 * @copyright  (c) 2010 Ndot.in
 */
?>
<script src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/js/jquery.validate.js" type="text/javascript"></script>
<!-- jQuery -->
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
	//validation form id
	$("#addcat").validate();
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
});
-->
</script>


<!-- template -->
		
<form action="<?php echo $this->docroot;?>admin_mailtemplates/create_temp" method="post"  name="addcat" id="addcat" >
<table border="0" cellpadding="10" cellspacing="10"> 
<tr><td>Title</td></tr>
<tr><td><input  type="text" id="title" name="title" class="required" ></td></tr>
<tr><td style="vertical-align:top;">Template Code</td></tr>
<tr><td><textarea id="markItUp" name="markItUp" cols="80" rows="20" class="required"></textarea></td>
</tr>

<tr>
<td><input  type="submit" value="Create" /><input type="button" value="Cancel" onclick="window.location='<?php echo $this->docroot;?>admin_mailtemplates/create_temp';"/></td>
</tr>

</table>
</form>

 
