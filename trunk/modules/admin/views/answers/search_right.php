<?php 
/**
 * Defines the search for from for question and answers
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
?>

<table border="0" cellpadding="5"  width="100%">
<form class="search_form" name="frm" method="get" action="<?php echo $this->docroot;?>admin_answers/commonsearch" onsubmit="return search_valid();" id="frm">
<tr>
<td align="right"><label>Search Key:</label></td>
 <td><input type="text"  value="<?php if(isset($_GET["search_text"])){ echo $_GET["search_text"]; } else{ echo "Keyword"; }?>" name="search_text" onClick="if(this.value=='Keyword'){this.value='';}" class="title" /></td>
</tr>
<tr>

<td valign="top" align="right"><label>Category:</label></td>
<td>
<select id="category" name="search_category"  class="span-10" style="font-size:11px;" size="5" >
<optgroup label="- Select your category - ">
<option value="-1">All</option>
<?php
if(count($this->categories)>0)
{
foreach($this->categories as $row)
{
?>
<option value="<?php echo $row->category_id;?>"><?php echo $row->category_name;?></option>
<?php
}
}
?>
</optgroup>
</select>
<input type="hidden" name="q" value="search">
</td>
</tr>
<tr><td align="right"><label>Options:</label></td><td><input type="checkbox" name="unanswered" />Show only unanswered questions</td></tr>
<tr>
<td>&nbsp;</td>
    <td><?php  echo UI::btn_("Submit", "search", "Search", "", "", "frm","frm");?>
        <!--input type="submit"  value="Search"  width="40" height="18"  alt="Search" title="Search"  />-->
	</td>
	</tr>
    </form>
</table>

