
<?php defined('SYSPATH') OR die('No direct access allowed.'); 
/**
 * Google Maps API integration.
 *
 * $Id: Gmap.php 4302 2009-05-01 02:49:41Z kiall $
 *
 * @package    Gmaps
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class UI_Core {

    //checking login 
	public function btn_( $actionType = "Click", $name="", $value="", $cls="", $onclick="",$eid = "",$formname="" )
	{       
		if($actionType=="Submit"){
			//echo  ' <a name="'.$name.'" class="button" href="javascript:;" onclick="this.blur();'.$onclick.';document.'.$formname.'.submit();"  id="'.$eid.'" ><span>'.$value.'</span></a>  ';
			echo  '<button name="'.$name.'" class="button" href="javascript:;" onclick="this.blur();'.$onclick.';" type="submit"  id="'.$eid.'" ><span>'.$value.'</span></button>  ';
		}else{ 
			echo  ' <a name="'.$name.'" class="button" href="javascript:;" onclick="this.blur();'.$onclick.'" id="'.$eid.'"><span>'.$value.'</span></a>  ';
		}
		
	}
	
	public function a_tag($name='',$eid='',$value='',$href='')
	{
        echo  ' <a name="'.$name.'" class="button" href="'.$href.'"  id="'.$eid.'" title="'.$value.'"><span>'.$value.'</span></a>  ';
	}
	public function noresults_($html=""){
		echo '<div class="noresults clear margin_top">';
		echo 'Sorry, we didn\'t find any results for your search.';
		if($html!=""){
			echo '<br/> $html';
		}
		echo '</div>';
	
	}
	
	public function nodata_($html=""){
		echo '<div class="noresults clear margin_top">';
		echo 'Sorry, There is no data found.';
		if($html!="")
		{
				echo "<br/> $html";
		}
		echo '</div>';
	
	}
	
	public function count_($count=""){
		echo '<div class="noresults clear margin_top">';
		echo $count.' results found!.';
		echo '</div>';
	}

	public function nocomment_($html="")
	{
	echo '<div class="noresults margin_top">';
	echo 'No Comments Available.';
	if($html!="")
	{
			echo "<br/> $html";
	}
	echo '</div>';
	}
	
	/* Function for facebook share */
	public function share($share_link = '', $title = '' ,$desc = '' )
	{?>
<!-- Facebook Share -->

<a title='FShare' href="http://www.facebook.com/sharer.php?u=<?php echo $share_link;?>" target="_blank"> <img src="<?echo $this->docroot; ?>public/themes/default/images/v_facebook.jpg"  border="0" width="23" height="23" /> </a>
<!-- Twitter Share -->
<a href="http://twitter.com/home?status=<?php echo $share_link; ?>" title="Twitter Share" target="_blank"> <img src="<?echo $this->docroot; ?>public/themes/default/images/v_twitter.jpg" title="Twitter Share" border="0" width="23" height="23" /> </a>
<!-- Mail Share -->
<?php $message =  $desc."<a href='.$share_link.'>".$title."</a>"  ?>
<a  href="<?echo $this->docroot; ?>inbox/compose?subject=<?php echo urlencode($title); ?>&message=<?php echo urlencode($message); ?>" title="Mail share"> <img src="<?echo $this->docroot; ?>public/themes/default/images/v_mail.jpg" title="Email" border="0" width="26" height="23" /> </a>
<?php }
 

        
	
}
?>
