 <script language="javascript" type="text/javascript">
  function selDept()
		{
 
			k=0;
			document.thisForm.branch.length=0;			
			for(i=0;i<document.thisForm.branch_vs_dept.length;i++)
			{
				if(document.thisForm.branch_vs_dept.options[i].value==document.thisForm.course.value)
				{
							for(l=0;l<document.thisForm.branch_vs_dept1.length;l++)
							{
								if(document.thisForm.branch_vs_dept.options[i].text==document.thisForm.branch_vs_dept1.options[l].text)
								{
									id=document.thisForm.branch_vs_dept1.options[l].value;
									break;
								}
							}	
							if(k==0)
							{
								//alert();
								var op=new Option("Select Branch","");
								document.thisForm.branch.options[k]=op;	
								k=k+1;	
								var op=new Option(document.thisForm.branch_vs_dept.options[i].text,id);
								document.thisForm.branch.options[k]=op;																
							}
							else
							{	
								var op=new Option(document.thisForm.branch_vs_dept.options[i].text,id);
								document.thisForm.branch.options[k]=op;																	
							}
							k=k+1;						
					}
				}	
			}

  </script>




<div  class="left_menu1"  >

<div id="left_center" >
<div class="navi_con">
<div id="left2_top"><div class="top_heading">Find Your Friend</div></div>
<table border="0" cellpadding="2" cellspacing="3"  style="margin-top:-40px; width:90px;" >
 
 <form name="thisForm" action="<?php echo $this->docroot;?>career/bitalumni/search_alumni/" method="get">

<tr>
<td>Name:</td>
<td></td>
</tr>
<tr>
<td colspan="2" align="left" >
<input type="text" name="name" id="txtName" style="width:130px; height:15px;"></td>
</tr>

<tr>
<td style=" height:20px;width:30px;   overflow:hidden;">Year:</td>
<td><select name="passout" id="passout" style="width:85px; height:20px; clear:both; ">
					<option value="">Year</option>
										<option value=2009>2009</option><option value=2008>2008</option><option value=2007>2007</option><option value=2006>2006</option><option value=2005>2005</option><option value=2004>2004</option><option value=2003>2003</option><option value=2002>2002</option><option value=2001>2001</option><option value=2000>2000</option>

									  </select></td>
</tr>

<!--<tr>
<td>Course:</td>
<td><select name="course" onChange="selDept()" style="width:82px; height:20px;" >
									  <option value="">Course</option>

									  <option value=100>BE</option><option value=101>B.Tech.</option><option value=102>M.E</option><option value=102>M.Tech.</option><option value=104>MCA</option><option value=105>M.Sc.</option><option value=106>B.Sc</option>
									</select></td>
</tr>-->
 <tr><td >
 <label>Course</label></td>
 <td style="width:240px;">
			<select name="course" onChange="selDept()" class="text_b1" id="course" style="width:85px; height:20px;">
									  <option value="">Select</option>
									  <?php foreach ($this->template->course as  $row ){?>
									  <option value=<?php echo $row->course_id;?>><?php echo $row->course_name; ?></option>> <?php } ?>
									</select> 
								 
</td>
<tr>
<td style="width:50px;"><label>Branch</label></td>
<td ><select name="branch" class="text_b1" id="branch" style="width:85px; height:20px;">
									<option value ="">Select</option>
									</select> </td>
</tr>
								 
 
							<select name="branch_vs_dept" style="visibility:hidden">
									  <?php  foreach ($this->template->branch as  $row ){?>				
									<option value="<?php echo $row->course_id;?>"><?php echo $row->branch_name;?></option> <?php }?>
								
									
										
								  </select>

								<select name="branch_vs_dept1" style="visibility:hidden">
									  <?php  foreach ($this->template->branch as  $row ){?>					
									<option value="<?php echo $row->branch_id;?>"><?php echo $row->branch_name;?></option><?php } ?>
									
									
										
								  </select>		

<input type="hidden" name="q" />
<tr><td></td>
<td><input type="submit" style=" margin-left:30px;_margin-left:25px;"  value="Search"  class="convey" /></td>
</tr>
</form>
</table>

</div>
		  
 </div>
			  <div id="left_bottom"></div>

</div>
