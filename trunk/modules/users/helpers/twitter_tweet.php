<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
	* view page <?php twitter_tweet::tweets('ndotinn',5);?>
**/

class Twitter_tweet{
	public static function tweets($id = '', $count = 1)
	{
		$url = "http://twitter.com/statuses/user_timeline/".$id.".json?count=".$count;
		$updates = "\n\t<ul class=\"twitter\">";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec ($ch);
			curl_close ($ch);
			$data = json_decode($response);
			$tweets = "";
			foreach ($data as $tweet) {	
				if(property_exists($tweet, 'text')){
					foreach($tweet->user as $row)
					{
						
					}	
					$message = $tweet->text;
					$time = Twitter_tweet::niceTime(strtotime(str_replace("+0000", "", $tweet->created_at)));
					$tweets .= "\n\t\t<li><b>".$message."</b><br/><span>".$time."</span></li>";	
				}				
			}
		$updates .= $tweets."\n\t</ul>\n";
		return $updates;
	}	
	
	function niceTime($time) {
		$delta = time() - $time;
		if ($delta < 60) {
			return 'less than a minute ago.';
		} else if ($delta < 120) {
			return 'about a minute ago.';
		} else if ($delta < (45 * 60)) {
			return floor($delta / 60) . ' minutes ago.';
		} else if ($delta < (90 * 60)) {
			return 'about an hour ago.';
		} else if ($delta < (24 * 60 * 60)) {
			return 'about ' . floor($delta / 3600) . ' hours ago.';
		} else if ($delta < (48 * 60 * 60)) {
			return '1 day ago.';
		} else {
			return floor($delta / 86400) . ' days ago.';
		}
	}
}
