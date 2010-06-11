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
<form class="search_form" name="frm" method="get" action="<?php echo $this->docroot;?>news/search" id="frm">
<tr>
<td valign="top" align="right"><label>Search Key:</label></td>
 <td><input type="text"  value="Keyword" name="search_text" onClick="if(this.value=='Keyword'){this.value='';}" class="span-10 title" /></td>
</tr>
<tr><td></td><td class="quiet">Enter the Title or Description.</td></tr>
<tr>

<td valign="top" align="right"><label>Category:</label></td>
<td>
<select id="category" name="search_category"  class="span-10" size="5" >
<?php
if(count($this->get_category)>0)
{
foreach($this->get_category as $row)
{
?>
<option value="<?php echo $row->category_id;?>"><?php echo $row->category_name;?></option>
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
<?php echo new View("news_main");?>
