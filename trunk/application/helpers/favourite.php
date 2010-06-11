<?php defined('SYSPATH') OR die('No direct access allowed.');

class Favourite{
	public function my_favourite($url = "")
	{
		$url = urldecode($url);
		$this->model = new Profile_Model();
		$result = $this->model->check_favourite($url,$this->userid);
		if($result == 0){
			//$link = "<a href=".$this->docroot."profile/favourite/add/1/?url=".urlencode($url).">Add To My Favourite</a>";
			$link =  UI::btn_("button", "Add To My Favourite", "Add To My Favourite", "", "javascript:window.location = '".$this->docroot."profile/favourite/add/1/?url=".urlencode($url)."'", "Add To My Favourite","Add To My Favourite");
		}
		else{
			//$link = "<a href=".$this->docroot."profile/favourite/delete/1/?url=".urlencode($url).">Remove from Favourite</a>";
			 $link = UI::btn_("button", "Remove from Favourite", "Remove from Favourite", "", "javascript:window.location = '".$this->docroot."profile/favourite/delete/1/?url=".urlencode($url)."'", "Remove from Favourite","Remove from Favourite");
		}
		return $link;
	}
	 
}
 

