	
	<p class="notice">
	Select themes below to change your settings. If you want to add a theme, Please read documentation.
	</p>
	<table width="300" cellpadding="10" cellspacing="5">
	<form action="/admin/themes" method="post" name="theme_form" ID="theme_form">
	 <?php	
	$project = trim($_SERVER['SCRIPT_NAME'],"index.php.");
	$dir = $this->file_docroot.$project."public/themes/";
	$dh = opendir($dir) or die("Cannot open the file $path");	 
	while (($file = readdir($dh)) !== false)
	{ 
		if($file!='.' && $file!='..')
		{
			?>
			
			<tr><td style="text-transform:capitalize">
			
			<input type="radio" id="themes" name="set_themes" value="<?php echo $file;?>" <?php if($this->get_theme==$file){ echo "checked=\"checked\"";}?> />&nbsp;<?php echo $file;?>
			</td><td>
			<img src="<?php echo $this->docroot;?>public/themes/<?php echo $file;?>/screen.jpg" style="vertical-align:top; width:200px;" />
			</td>
			</tr>
			<?php
		} 
	}
	?>
	<tr>
		
	<td >
	<!--input type="submit" value="select"-->
	<?php  echo UI::btn_("Submit", "theme", "Save", "", "", "theme","theme");?>
	</td>
	</tr>
	</table>
	</form>
