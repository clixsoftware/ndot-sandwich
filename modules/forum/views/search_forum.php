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
<form class="search_form" name="frm" method="get" action="<?php echo $this->docroot;?>forum/advanced" onsubmit="return search_valid();" id="frm">
<tr>
<td align="right" valign="top"><label>Search Key:</label></td>
 <td><input type="text"  value="<?php if($this->input->get('search_text')) { echo $this->input->get('search_text'); } else { echo 'Keyword';}?>" name="search_text" onClick="if(this.value=='Keyword'){this.value='';}" class="span-10 title" /></td>
</tr>
<tr><td></td><td class="quiet">Enter the Discussion Topic or Description.</td></tr>
<tr>

<td valign="top" align="right"><label>Category:</label></td>
<td>
<select id="category" name="search_category"  class="span-10" size="5" >
<?php
if(count($this->category)>0)
{
foreach($this->category as $row)
{
?>
<option value="<?php echo $row->category_id;?>"><?php echo $row->forum_category;?></option>
<?php
}
}
?>
</select>
<input type="hidden" name="q" value="search">
</td>
</tr>

<tr>
<td>&nbsp;</td>
    <td><?php  echo UI::btn_("Submit", "search", "Search", "", "", "frm","frm");?>
      
	</td>
	</tr>
    </form>
</table>

<?php 
//blog list
echo new View("forum_content"); ?>
