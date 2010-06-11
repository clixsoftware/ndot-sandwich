<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
	*  helper use check user type, admin or user or moderator  
**/

class Photo_size{
	public  function size($width = 50,$height = 50 ,$heightadjust = 50 ,$widthadjust = 50)
	{
		if( $width > $height){
			$widthadjust  = $width * $widthadjust / $height;
		}
		else{
			 $heightadjust  = $height * $heightadjust / $width;
		}
		return array("width_adj" => $widthadjust ,"height_adj" => $heightadjust);
	}
	 
}