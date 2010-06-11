 <?php 
$this->session=Session::instance();
$userid=$this->session->get('userid');

if(count($this->template->get_allevents) > 0)
{
	foreach($this->template->get_allevents as $events)
	{
		$_POST['title'] = $events->event_name;
		$_POST['event_description'] = $events->event_description;
		$_POST['datevalue'] = $events->event_date;
		$_POST['end_date'] = $events->end_date;
		$_POST['stime'] = $events->start_time;
		$_POST['etime'] = $events->end_time;
		$_POST['address'] = $events->address;
		$_POST['place'] = $events->event_place;
		$_POST['contacts'] = $events->contacts;
		$_POST['contact_email'] = $events->contact_email;
		$_POST['eid'] = $events->event_id;
		$_POST['category'] = $events->category_id;
	}
}

 ?>


<script src="<?php echo $this->docroot;?>public/js/jquery.clockpick.js" type="text/javascript"></script>
  <link href="<?php echo $this->docroot;?>public/css/clock.css" type="text/css" rel="stylesheet" />
 <script>
$(document).ready(function() {
 
	// validate signup form on keyup and submit
	var validator = $("#form").validate({
 
		rules: {
			title: {
				required: true
			},
			category: {
				required: true
			},
			event_description: {
				required: true
			},
			datevalue: {
				required: true,
				dateISO: true
			},
			end_date: {
				required: true,
				dateISO: true
			},
			stime: {
				required: true
			},
			etime: {
				required: true
			},
			address: {
				required: true,
			},
			place: {
				required: true
			}
		},
		messages: {
			title: {
				required: "Title Required."
			},
			category: {
				required: "Category Required."
			},
			event_description: {
				required: "Description Required."
			},
			datevalue: {
				required: "Start Date Required."
			},
			end_date: {
				required: "End Date Required."
			},
			stime: {
				required: "Start time Required."
			},
			etime: {
				required: "End time Required."
			},
			address: {
				required: "Address Required."
			},
			place: {
				required: "Event Place Required."
			}
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent().next().next() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.next() );
			else
				error.appendTo( element.parent().next() );
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		 
		// set this class to error-labels to indicate valid fields
		success: function(label) { 
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}
	});

	// propose username by combining first- and lastname
	 

});

$(document).ready(function(){
date_obj = new Date();
date_obj_hours = date_obj.getHours();
date_obj_mins = date_obj.getMinutes();

$("#datevalue").datepicker({dateFormat: $.datepicker.W3C });  
$("#end_date").datepicker({dateFormat: $.datepicker.W3C });  
  //  $('#startDate').datepicker(new Date('yyyy-mm-dd'));

	$("#stime").clockpick();
	$("#etime").clockpick();
  });
  
  function validate(elem)
  {
        var stime = elem.stime.value;
        var etime = elem.etime.value;
        
        var cont1 = elem.contacts.value;
        var cont2 = elem.contact_email.value;
        
        stime_hour = stime.split(':');
        etime_hour = etime.split(':');
        var noon = stime.split(' ');
        var noon1 = etime.split(' ');
        
        if((noon[1] == 'AM' && noon1[1] == 'AM') || (noon[1] == 'PM' && noon1[1] == 'PM'))
        {
                if((etime_hour[0] < stime_hour[0]) )
                {
                        document.getElementById('error').innerHTML = "End Time should be greater than Start Time.";
                        document.getElementById('error').style.color= "red";
                        document.getElementById('error').style.fontWeight = 'bold';

                        return false;
                }
        }
        else
        {
                 document.getElementById('error').innerHTML = "";
        }
        if (elem.datevalue.value <= elem.end_date.value){
                document.getElementById('date_error').innerHTML = "";
        }
        else
        {
               document.getElementById('date_error').innerHTML = "End Date should be greater than Start Date.";
               document.getElementById('date_error').style.color= "red";
               document.getElementById('date_error').style.fontWeight = 'bold'; 
               return false;
        }
        
        if(cont1 == '' && cont2 == '')
        {
               document.getElementById('cont_error').innerHTML = "Please enter contact email or Contact Number.";
               document.getElementById('cont_error').style.color= "red";
               document.getElementById('cont_error').style.fontWeight = 'bold'; 
               return false;
        }
         
        else
        {
                 document.getElementById('cont_error').innerHTML = "";
        }
  }
</script>
 

  
		<div id="cont_pb" style="margin-top:0px;">	
 <form name="form" id="form" action="<?php echo $this->docroot;?>admin_events/editevent" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">

 <table width="742" border="0" cellpadding="8" cellspacing="8">
  <tr>
    <input type="hidden" value="<?php echo $this->input->get('eid'); ?>" name="eid" id="eid">
  <input type="hidden" value="<?php echo $this->userid; ?>" name="userid" id="userid">
    <td align="right" width="180"><label>Title :</label></td>
    <td align="left" width="276">
	
	<input name="title" id="title" type="text" value="<?php echo htmlspecialchars_decode($this->input->post('title')); ?>" style="width:320px;" class="required title"/>
	
 </td>
 <td class="status"></td>
  </tr>
  
   <tr>
   <td valign="top" align="right"><label>Category : </label></td>
   <td>
   <select name="category" id="category" title="Category Required." class="required span-5">
   <option value="">Select</option>
   <?php
   if(count($this->template->get_category) >0)
   {
        foreach($this->template->get_category as $cate)
        {
   ?>
   <option value="<?php echo $cate->category_id; ?>" <?php if($this->input->post('category') == $cate->category_id) echo 'selected';?>><?php echo $cate->category_name; ?></option>
   <?php 
        }
}
   ?>
   </select>
   </td>
   </tr>
  
  <tr>
    <td valign="top" align="right" width="180"><label>Description :</label></td>
    <td valign="top" >
	<textarea   id="event_description"  style="width:320px;height:60px;"  name="event_description" class="required"><?php echo htmlspecialchars_decode($this->input->post('event_description')); ?></textarea>
 	</td>
	<td class="status" valign="top"></td>
  </tr>
  <tr>
    <td align="right" width="180"><label>Start Date :</label></td>
    <td><input name="datevalue" id="datevalue" type="text" value="<?php echo $this->input->post('datevalue'); ?>"  readonly  class="required"/>
	
 	</td>
	<td class="status"></td>
  </tr>
  <tr>
    <td align="right" width="180"><label>End Date :</label></td>
    <td><input name="end_date" id="end_date"  type="text" value="<?php echo $this->input->post('end_date'); ?>" class="required"/>
     <span id="date_error"></span></td>
  </tr>
  <tr>
  <td align="right" width="180"><label>Start Time :</label></td>
  <td><input name="stime" id="stime" type="text" value="<?php echo $this->input->post('stime'); ?>" readonly class="required"/>
  
   </td>
   <td class="status"></td>
  </tr>
  <tr>
  <td align="right" width="180"><label>End Time  :</label></td>
  <td><input name="etime" id="etime" type="text" value="<?php echo $this->input->post('etime'); ?>"readonly class="required" />
  
   </td>
   <td class="status"><span id="error"></span></td>
  </tr>
  <tr>
  <td valign="top" align="right" width="180"><label>Address :</label></td>
  <td><input type="text" id="address" style="width:330px;" name="address" class="required" value="<?php echo htmlspecialchars_decode($this->input->post('address')); ?>" />
   </td>
   <td class="status" valign="top"></td>
  </tr>
  <tr>
  <td align="right" width="180"><label>City :</label></td>
  <td><input name="place" id="place" type="text" value="<?php echo htmlspecialchars_decode($this->input->post('place')); ?>" style="width:330px;"  class="required"/>
   </td>
   <td class="status"></td>
  </tr>
  <tr>
  <td valign="top" align="right" width="180"><label>Contacts  :</label></td>
  <td><input type="text"   id="contacts" style="width:330px;" name="contacts"  value="<?php echo htmlspecialchars_decode($this->input->post('contacts')); ?>" />
   </td>
   <td class="status" valign="top"></td>
  </tr>
   <tr>
  <td valign="top" align="right" width="180"> <label>Contact Email : </label></td>
  <td><input type="text" id="contact_email" style="width:330px;" name="contact_email" value="<?php echo htmlspecialchars_decode($this->input->post('contact_email')); ?>" /></textarea>
   </td>
   
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td> 
      <?php  echo UI::btn_("Submit", "Edit", "Edit", "", "", "new_q","Edit");?>
<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."admin_events' ", "cancel","");?> 
 </td>
  </tr>
</table></form>
 
 </div>
