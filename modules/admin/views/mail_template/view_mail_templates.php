<?php
/**
 * Edit the Template
 *
 * @package    Core
 * @author     M.Balamurugan
 * @copyright  (c) 2010 Ndot.in
 */
?>
<!-- jQuery -->
<script type="text/javascript" src="<?php echo $this->docroot;?>/public/js/Html_editor/jquery-1.3.2.min.js"></script>
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


<!-- template -->
<form action="<?php echo $this->docroot;?>admin_mailtemplates/edit_temp" method="post"  name="frm" id="frm" onSubmit="return validation()"  style=" border:0px solid #EEEEEE;padding:5px;">
<table border="0" cellpadding="10" cellspacing="10"> 
<input type="hidden" name="id" value="<?php echo ucfirst($this->view_temp['mysql_fetch_object']->mail_temp_id); ?> "/>
<tr><td>Title</td></tr>
<tr><td><input  type="text" id="title" name="title" style="width:508px;"   value="<?php echo ucfirst($this->view_temp['mysql_fetch_object']->mail_temp_title); ?>" class="required" / ></td></tr>
<tr><td style="vertical-align:top;">Template Code</td></tr>
<tr><td><textarea id="markItUp" name="markItUp" cols="80" rows="20" class="required">
<?php echo ucfirst($this->view_temp['mysql_fetch_object']->mail_temp_code); ?>
</textarea></td>
</tr>

<tr>
<td><input  type="submit" value="Edit" /><input type="button" value="Cancel" onclick="window.location='<?php echo $this->docroot;?>admin_mailtemplates';"/></td>
</tr>

</table>
</form>

 
