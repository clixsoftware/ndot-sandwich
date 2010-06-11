<?php
include('openinviter.php');
$inviter=new OpenInviter();
$oi_services=$inviter->getPlugins();
if (isset($_POST['provider_box'])) 
{
	if (isset($oi_services['email'][$_POST['provider_box']])) $plugType='email';
	elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType='social';
	else $plugType='';
}
else $plugType = '';

function ers($ers)
	{
	
	if (!empty($ers))
		{
		$_SESSION["Msg"] = '';
		foreach ($ers as $key=>$error)
			{
		//	$_SESSION["Msg"] .="{$error}";
		$_SESSION["Msg"] .="{$error},&nbsp;";
			}
		}
	}
	
function oks($oks)
	{
	if (!empty($oks))
		{
		$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;margin-top:10px;' align='center' class='tbInfoMsgGrad'>
		<tr>
		<td valign='middle' valign='middle' class='tbInfoMsg'>
		<img src='/public/images/oks.gif' ></td>
		<td valign='middle' style='color:#5897FE;padding:5px;'>	";
		foreach ($oks as $key=>$msg)
			$contents.="{$msg}<br >";
		$contents.="</td></tr></table><br >";
		return $contents;
		}
	}

if (!empty($_POST['step'])) $step=$_POST['step'];
else $step='get_contacts';

$ers=array();$oks=array();$import_ok=false;$done=false;
if ($_SERVER['REQUEST_METHOD']=='POST')
	{
	if ($step=='get_contacts')
		{
		if (empty($_POST['email_box']))
			$ers['email']="Email missing";
		if (empty($_POST['password_box']))
			$ers['password']="Password missing";
		if (empty($_POST['provider_box']))
			$ers['provider']="Provider missing";
		if (count($ers)==0)
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal)
				$ers['inviter']=$internal;
			elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
				{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later");
				}
			elseif (false===$contacts=$inviter->getMyContacts())
			
				$ers['contacts']="Unable to get contacts.";
			else
				{

				$import_ok=true;
				$step='send_invites';
				$_POST['oi_session_id']=$inviter->plugin->getSessionID();
				$_POST['message_box']='';
				}
			}
		}
	elseif ($step=='send_invites')
		{
		
		if (empty($_POST['provider_box'])) $ers['provider']='Provider missing';
		else
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal) $ers['internal']=$internal;
			else
				{
				if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing';
				if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session';
				if (empty($_POST['message_box'])) $ers['message_body']='Message missing';
				else
				 $_POST['message_box']=strip_tags($_POST['message_box']);
				$selected_contacts=array();$contacts=array();
				$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"<br>".$_POST['message_box']);
				if ($inviter->showContacts())
					{
					foreach ($_POST as $key=>$val)
						if (strpos($key,'check_')!==false)
							$selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
						elseif (strpos($key,'email_')!==false)
							{
							$temp=explode('_',$key);$counter=$temp[1];
							if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
							}
					if (count($selected_contacts)==0) $ers['contacts']="You haven't selected any contacts to invite";
					}
				}
			}
		if (count($ers)==0)
			{
			$sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
			$inviter->logout();
			
			if ($sendMessage===-1)
				{
				$uid=$_SESSION['userid'];
				$uname=$_SESSION['username'];
				$message_footer="<br>";
				$message_subject=$uname.' '.$message['subject'];
				$message_body=$message['body'].$message['attachment'].$message_footer; 
				$headers= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .="From: ".$uname."";
				$userid=$_SESSION['userid'];
				$uname=$_SESSION['username'];
				
				foreach ($selected_contacts as $email=>$name)
				{	
                    
					$userid=$_SESSION['userid'];
					
					if($_POST['invite_type']==1)
					{
					//changes by saran
					
					//common::insert_invitations($this->userid,$name,$email);
				        mail($email,$message_subject,$message_body,$headers);
					}
					
					
				}
				$oks['mails']="Mails sent successfully";
				}
			        elseif ($sendMessage===false)
				{
				$internal=$inviter->getInternalError();
				$ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
				}
			else $oks['internal']="Invites sent successfully!";
			$done=true;
			}
		}
	}
else
	{
	$_POST['email_box']='';
	$_POST['password_box']='';
	$_POST['provider_box']='';
	}

$contents="<script type='text/javascript'>
	function toggleAll(element) 
	{
	
	var form = document.forms.openinviter, z = 0;
	for(z=0; z<form.length;z++)
		{
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
	function loadProvider(val){
	        document.getElementById('emailprovider').innerHTML = val;
	}
</script>";
$contents.="<form action='' method='POST' name='openinviter'>".ers($ers).oks($oks);
if (!$done)
	{ 
	if ($step=='get_contacts')
		{
		$contents.="<table width='50%' align='left'><tr>
		<td><input type='radio' name='provider_box' value='gmail' onclick='javascript:loadProvider(this.value);'> <img src='".$this->docroot."/modules/openInviter/images/gmail.png'> </td>
		<td><input type='radio' name='provider_box' value='aol' onclick='javascript:loadProvider(this.value);'> <img src='".$this->docroot."/modules/openInviter/images/aol.png'></td></tr>
		<tr><td><input type='radio' name='provider_box' value='hotmail' onclick='javascript:loadProvider(this.value);'> <img src='".$this->docroot."/modules/openInviter/images/hotmail.png'> </td>
		<td><input type='radio' name='provider_box' value='linkedin' onclick='javascript:loadProvider(this.value);'><img src='".$this->docroot."/modules/openInviter/images/linkedin.jpg'></td></tr>
		<tr><td><input type='radio' name='provider_box' value='msn' onclick='javascript:loadProvider(this.value);'> <img src='".$this->docroot."/modules/openInviter/images/msn.jpg'> </td>
		<td><input type='radio' name='provider_box' value='yahoo' onclick='javascript:loadProvider(this.value);'> <img src='".$this->docroot."/modules/openInviter/images/yahoo.png'> </td></tr>
		<tr><td><input type='radio' name='provider_box' value='facebook' onclick='javascript:loadProvider(this.value);'> <img src='".$this->docroot."/modules/openInviter/images/facebook.jpg'> </td>
		<td><input type='radio' name='provider_box' value='twitter' onclick='javascript:loadProvider(this.value);'> <img src='".$this->docroot."/modules/openInviter/images/twitter.jpg'> </td></tr>
		</table>";
		$contents.="<table width='50%' align='right' class='thTable' cellspacing='5' cellpadding='5' style='border:none;'>
			<tr class='thTableRow'>
			<td align='right'><span id='emailprovider' style='text-transform:capitalize;'>Gmail</span><span> Username</span></td><td>
			<input class='thTextbox' type='text' name='email_box' value='{$_POST['email_box']}' size='35' maxlength='35' style=' width:232px;'></td></tr>
			 <input class='thTextbox' type='hidden' name='invite_type' value='1' size='35' maxlength='35'>
			<tr class='thTableRow'><td align='right'><span>Password</span></td><td><input class='thTextbox' type='password' name='password_box' value='{$_POST['password_box']}' size='35' maxlength='35' style='width:232px;'></td></tr>
			
			<tr class='thTableImportantRow'><td align='center'>&nbsp;</td>
			<td align='left'>
			
			<input class='thButton' type='submit' name='import' value='Import Contacts' style='padding: 0.2em; margin-right: 2px; font-weight: 700;'>&nbsp;
			<input type='button' name='Button' value='Back' onClick=\"javascript:window.location='".$this->docroot."profile';\" style='padding: 0.2em; margin-right: 2px; font-weight: 700;'></td></tr>
		</table>
		<input type='hidden' name='step' value='get_contacts'>";
		}
	
		
	}
//$contents.="<center><a href='http://openinviter.com/'><img src='http://openinviter.com/images/banners/banner_blue_1.gif' border='0' alt='Powered by OpenInviter.com' title='Powered by OpenInviter.com'></a></center>";
if (!$done)
	{
	
	if ($step=='send_invites')
		{
		
		if ($inviter->showContacts())
			{
			if($_GET)
			{
				$event = 'Event Name:'.$this->input->get("title").'';
				$link = '<br /><a href="http://192.168.1.2:1111/'.$this->input->post('link').'">'.$this->input->post('link').'</a>';
			}
			else
			{
				$event = '';
				$link = '';
			}
			$contents.="<table class='thTable' cellspacing='0' cellpadding='5' style='margin-top:5px;'>";
					$contents.="<tr class='thTableRow'><td align='right' valign='top'>
				<label for='message_box'>Message</label></td>
				<td><textarea rows='5' cols='50' name='message_box' class='thTextArea' style='width:370px;'>".$event.html::specialchars($link)."</textarea></td></tr>
			<tr class='thTableRow'>
				<td>&nbsp;</td><td align='left' colspan='2'>
				<input type='submit' name='send' value='Send Invites' class='thButton' style='padding: 0.2em; margin-right: 2px; font-weight: 700;' >
				</td></tr>";
			$contents.="</table>";
			$contents.="<table class='thTable' align='center' cellspacing='0' cellpadding='0' >
			
			<tr class='thTableHeader'>
			&nbsp;<td colspan='".($plugType=='email'? "3":"2")."' style='padding:5px 10px 5px 10px;border:1px solid #64CDF4;margin:1px;font-weight:bold;background:#ABE3FA;text-align:center;'>YOUR CONTACT LISTS</td>&nbsp;
			</tr>";
			
			//get the contacts list
			if (count($contacts)==0)
				$contents.="<tr class='thTableOddRow'><td align='center' style='padding:20px;' colspan='".($plugType=='email'? "3":"2")."'>You do not have any contacts in your address book.</td></tr>";
			else
				{
				$contents.="<tr class='thTableDesc'>
				<td style='width:100px;'>
				<input type='checkbox' onChange='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked><b>Invite?</b></td>
				<td><b>Name</b></td>".($plugType == 'email' ?"<td><b>E-mail</b></td>":"")."</tr>";
				$odd=true;$counter=0;
			//	require_once("inc/func/sms.php");
				foreach ($contacts as $email=>$name)
					{
					
					$counter++;
					if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
					$contents.="<tr class='{$class}'>

					<td><input name='check_{$counter}' value='{$counter}' type='checkbox' class='thCheckbox' checked><input type='hidden' name='email_{$counter}' value='{$email}'><input type='hidden' name='name_{$counter}' value='{$name}'></td><td>{$name}</td>".($plugType == 'email' ?"<td>{$email}</td>":"")."</tr>";
					$odd=!$odd;
					
					}
				$contents.="<tr class='thTableFooter'>
				<td></td>
				<td colspan='".($plugType=='email'? "3":"2")."' style='padding:3px;' align='left'>
				<input type='submit' name='send' value='Send invites' class='thButton' style='padding: 0.2em; margin-right: 2px; font-weight: 700;'>
				</td>
				<td></td>
				</tr>";
				}
			$contents.="</table>";
			}
		$contents.="<input type='hidden' name='step' value='send_invites'>
			<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
			<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
			<input type='hidden' name='invite_type' value='1'>
			<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
		}
	}
$contents.="</form>";
return  $contents;
?>
