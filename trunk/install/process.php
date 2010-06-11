<?php 

	if($_POST)
	{
	        
		/*Getting information for Db connectivity from database.php file */
		include_once '../application/config/database.php';
		$prefix=$config['default']['table_prefix'];
		$host=$config['default']['connection']['host'];
		$user=$config['default']['connection']['user'];
		$pass=$config['default']['connection']['pass'];
		$db=$config['default']['connection']['database'];
		$server_path = $config['server_path'];
		/*User Information*/
		$title  = trim($_POST['title']);
		$name  = trim($_POST['name']);
		$email  = trim($_POST['email']);
		$password  = trim($_POST['password']);
		$mode= "1";
		$table = trim($_POST['table']);
		/*UserTable Information*/
		$usertbname  = trim($_POST['tbname']);
		$unamefield  = trim($_POST['uname']);
		$upass   = trim($_POST['upass']);
		$uemail = trim($_POST['uemail']);
		$uidfield  = trim($_POST['uidfield']);
		$ustatus = trim($_POST['ustatus']);
		$utype = trim($_POST['utype']);
		$liurl = trim($_POST['liurl']);
		$lourl = trim($_POST['lourl']);
		$regurl = trim($_POST['regurl']);
		$stno = trim($_POST['chk1']);
		$tyno = trim($_POST['chk2']);
		//echo $stno."<br>".$tyno;exit;
		
		
		//if (empty($prefix)) $prefix = ''; else { if(substr($prefix, -1)!="_") $prefix=$prefix."_";   }
		/* data base connection */
		$link = mysql_connect($host, $user, $pass) or die('Could not connect: ' . mysql_error());
		/* db select */
		$select = mysql_select_db($db) or die('Query failed: ' . mysql_error());
		
		/*Getting Config file root and Replacing the values*/
		$str=implode("",file('../application/config/database.php'));
		/*Config File Writing Starts here*/
		if($table=="yourtbl") //if already usertable exist
		{       
		        $dummy='';
			$str=str_replace('yourusertablename',$usertbname,$str);
			$str=str_replace('youruseridfield',$uidfield,$str);
			$str=str_replace('yourusernamefield',$unamefield,$str);
			$str=str_replace('youruserpasswordfield',$upass,$str);
			$str=str_replace('youruseremailidfield',$uemail,$str);
			$str=str_replace('yourusertypefield','user_type',$str);
			$str=str_replace('youruserstatusfield','user_status',$str);
			$str=str_replace($prefix,$dummy,$str);
		}
		else //ndot usertable field values
		{
			$str=str_replace('yourusertablename',$prefix.'users',$str);
			$str=str_replace('youruseridfield','id',$str);
			$str=str_replace('yourusernamefield','name',$str);
			$str=str_replace('youruserpasswordfield','password',$str);
			$str=str_replace('youruseremailidfield','email',$str);
			$str=str_replace('yourusertypefield','user_type',$str);
			$str=str_replace('youruserstatusfield','user_status',$str);
			$str=str_replace('youropenidfield','open_id',$str);
			$str=str_replace('yourthirdidfield','third_id',$str);
			$str=str_replace('yourmoduleidfield','module_id',$str);
		}
		$fp=fopen('../application/config/database.php','w');
		fwrite($fp,$str,strlen($str));
		fclose($fp);
		
		
		
		//checking user table of other party
		if($table=='yourtbl')
		{       
		        $prefix='';
		        if($usertbname=='' && $unamefield=='' && $upass=='' && $uemail=='' && $uidfield=='')
		        {
		                $urlm = $_SERVER['REQUEST_URI'];
			        $msg1 = '1';
			        ?>
			        <script type="text/javascript">
			        window.location = "<?PHP echo $urlm."?msg1=$msg1"; ?>";			 
			        </script>
			        <?php 
			        exit;		
		        }
		        else
		        {
                                $tables = mysql_list_tables($db);
	                        $num_tables = @mysql_numrows($tables);
	                        $i = 0;
	                        
	                        while($i < $num_tables)
	                        {
	                                $tablename = mysql_tablename($tables, $i);
	                                if ($tablename==$usertbname) 
	                                $exist=1;
	                                //echo $exist; exit;
	                                $i++;
	                        }
	                        if ($exist==0)
	                        {
                                       /* $url = $_SERVER['REQUEST_URI'];
                                        $msg1 = '2';
                                        ?>
                                        <script type="text/javascript">
                                        window.location = "<?PHP echo "?msg1=$msg1"; ?>";			 
                                        </script>
                                        <?php */
                                        exit;
	                        }
                                if($stno==1)
                                {
                                        $alter2="ALTER TABLE `$usertbname`  ADD `user_status` int(10) NOT NULL COMMENT '1-active,0-blocked user'";
                                        $exealter=mysql_query($alter2) or die(mysql_error());
                                }
                                if($tyno==1)
                                {
                                
                                        $alter1="ALTER TABLE `$usertbname`  ADD `user_type` 
                                        int(10) NOT NULL COMMENT '-2 -moderator,-1-admin,1-user,2-twitter,3-facebook,4-openid'";  
                                        $exealter1=mysql_query($alter1) or die(mysql_error());
                                        
                                }
		        }
		}
		// Performing SQL query      twitter_user,users,users_profile,updates,action,modules,update_comments,

		//****** Creation of user table Starts here*******//
		if($table=='ndottbl')
			{
				$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."users` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(41) DEFAULT NULL,
                          `email` varchar(256) DEFAULT NULL,
                          `password` varchar(32) NOT NULL,
                          `user_type` int(2) NOT NULL COMMENT '1-user,-1-admin,2-twitter,3-facebook,4-openid, -2 moderater',
                          `user_status` int(2) NOT NULL COMMENT '1-active,0-blocked user',
                          `third_id` int(11) NOT NULL,
                          `open_id` varchar(100) NOT NULL,
                          `module_id` varchar(30) NOT NULL,
                          PRIMARY KEY (`id`),
                          KEY `id` (`id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123469 ;";
        $exe1=mysql_query($sql1) or die(mysql_error());	
			                        }
			//Creating Users friends table
			
                      

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."action` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `action` varchar(50) NOT NULL,
  `action_desc` varchar(50) NOT NULL,
  `mod_id` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."action` (`id`, `action`, `action_desc`, `mod_id`) VALUES
(1, 'add friend', 'are friends now', 10),
(2, 'update', 'updated', 12),
(6, 'add', 'has been added by', 11),
(7, 'post', 'Wrote wall on ', 13),
(8, 'question', 'asked the question', 1),
(9, 'answer', 'answered for the question', 1),
(10, 'news comment', 'comment for the news', 8),
(12, 'Advertisement comment', 'comment for the Advertisement', 3),
(13, 'post Advertisement', 'has posted the Advertisement', 3),
(14, 'post forum', 'posted the forum', 5),
(15, 'forum reply', 'reply for the forum', 5),
(16, 'edit forum', 'edited the forum', 5),
(17, 'post blog', 'posted the blog', 2),
(18, 'edit blog', 'edited  the blog', 2),
(19, 'comment blog', 'comment for the blog', 2),
(20, 'add video', 'added video', 14),
(21, 'comment video', 'comment for the video', 14),
(22, 'added photo', ' photos', 9),
(23, 'created album', 'created photo album', 9),
(24, 'edit album ', 'updated album information', 9),
(25, 'comment photo', 'comment for the photo', 9),
(26, 'create group', 'created the group', 6),
(27, 'join group', 'joined the group', 6),
(28, 'post wall on group', 'posted wall on the group ', 6),
(29, 'add photos on the group', 'added photos on the group', 6),
(31, 'comment photo on the group', 'comment for photo on the group', 6),
(32, 'create discussion on the group', 'created discussion on the group', 6),
(33, 'reply for the discussion on the group', 'reply for the discussion on the group', 6),
(35, 'join event', 'joined in an event', 4),
(36, 'unjoin event', 'unjoin from the event', 4),
(37, 'updated ', 'updated profile photo', 12),
(38, 'create event', 'created an event', 4);";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."ads_favour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `classifieds_id` int(11) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1012 ;";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `subject` varchar(240) NOT NULL,
  `category` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `counts` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `block` int(11) NOT NULL COMMENT '0-Deactive,1-Active',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1523 ;";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."article_category` (
  `category_id` int(3) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ; ";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="INSERT INTO `".$prefix."article_category` (`category_id`, `category_name`) VALUES
(1, 'Arts &amp; Humanities'),
(2, 'Beauty &amp; Styles'),
(3, 'Business &amp; Finance'),
(4, 'Cars &amp; Transportation'),
(5, 'Computers & Internet'),
(6, 'Consumer Electronics'),
(7, 'Dining Out'),
(8, 'Education & Reference'),
(9, 'Entertainment & Music'),
(10, 'Environment'),
(11, 'Family & Relationships'),
(12, 'Food & Drink'),
(13, 'Games & Recreation'),
(14, 'Health'),
(16, 'Horoscope'),
(17, 'News & Events'),
(18, 'Pets'),
(19, 'Politics & Government'),
(20, 'Pregnancy & Parenting'),
(21, 'Science & Mathematics'),
(22, 'Social Science'),
(23, 'Society & Culture'),
(24, 'Sports'),
(25, 'Travel'); ";
$exe1=mysql_query($sql1) or die(mysql_error());



$sql1="CREATE TABLE IF NOT EXISTS `demo_article_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comments` longtext NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `demo_favourite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL COMMENT '0-bookmarks,1-favourite',
  `userid` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `demo_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `note_url` varchar(250) NOT NULL,
  `note_description` varchar(300) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `demo_ratings` (
  `rate_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(25) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1-Answer,2-Blogs,3-Classifieds,4-Events,5-Forum,6-Groups,7-Articles,8-Photos,9-Video',
  `type_id` bigint(20) DEFAULT NULL,
  `rate_val` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`rate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ; ";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."answer` (
  `answers_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `answer` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_answer` datetime NOT NULL,
  `status` int(2) NOT NULL COMMENT '0-active,1-inactive',
  PRIMARY KEY (`answers_id`),
  KEY `id` (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."answers_category` (
  `category_id` int(3) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(40) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."answers_category` (`category_id`, `category_name`) VALUES
(1, 'Arts &amp; Humanitiess'),
(2, 'Beauty & Style'),
(3, 'Business & Finance'),
(4, 'Cars & Transportation'),
(5, 'Computers & Internet'),
(6, 'Consumer Electronics'),
(7, 'Dining Out'),
(8, 'Education & Reference'),
(9, 'Entertainment & Music'),
(10, 'Environment'),
(11, 'Family & Relationships'),
(12, 'Food & Drink'),
(13, 'Games & Recreation'),
(14, 'Health'),
(17, 'News &amp; Event'),
(18, 'Pets'),
(19, 'Politics & Government'),
(20, 'Pregnancy & Parenting'),
(21, 'Science & Mathematics'),
(22, 'Social Science'),
(23, 'Society & Culture'),
(24, 'Sports'),
(25, 'Travel');";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."block_users` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `message` varchar(500) NOT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."blog` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `blog_title` varchar(256) NOT NULL,
  `blog_desc` longtext NOT NULL,
  `blog_category` int(3) NOT NULL DEFAULT '2',
  `type` int(3) NOT NULL,
  `blog_date` datetime NOT NULL,
  `counts` int(8) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1-Active,2-Denied',
  PRIMARY KEY (`blog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10053 ;";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."blog_category` (
  `category_id` int(3) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."blog_category` (`category_id`, `category_name`) VALUES
(1, 'Arts &amp; Humanities'),
(2, 'Beauty &amp; Styles'),
(3, 'Business &amp; Finance'),
(4, 'Cars &amp; Transportation'),
(5, 'Computers & Internet'),
(6, 'Consumer Electronics'),
(7, 'Dining Out'),
(8, 'Education & Reference'),
(9, 'Entertainment & Music'),
(10, 'Environment'),
(11, 'Family & Relationships'),
(12, 'Food & Drink'),
(13, 'Games & Recreation'),
(14, 'Health'),
(16, 'Horoscope'),
(17, 'News & Events'),
(18, 'Pets'),
(19, 'Politics & Government'),
(20, 'Pregnancy & Parenting'),
(21, 'Science & Mathematics'),
(22, 'Social Science'),
(23, 'Society & Culture'),
(24, 'Sports'),
(25, 'Travel');";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."blog_comments` (
  `comment_id` int(6) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parant_id` int(11) NOT NULL DEFAULT '-1',
  `comments` text NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `private` int(11) DEFAULT NULL,
  `book_date` varchar(25) NOT NULL,
  `childof` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT NULL,
  `favicon` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `Submit` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1  ;";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) DEFAULT NULL,
  `cat_desc` tinytext,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";


$exe1=mysql_query($sql1) or die(mysql_error());
$sql1="INSERT INTO `".$prefix."categories` (`cat_id`, `cat_name`, `cat_desc`) VALUES
(1, 'Web Technology', 'Web Technology'),
(2, 'Software Development', 'Software Development'),
(3, 'Graphic Arts & Design', 'Graphic Arts & Design');";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."category` (
  `category_id` int(4) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="INSERT INTO `".$prefix."category` (`category_id`, `category_name`) VALUES
(1, 'Arts & Humanities'),
(2, 'Beauty & Style'),
(3, 'Business & Finance'),
(4, 'Cars & Transportation'),
(5, 'Computers & Internet'),
(6, 'Consumer Electronics'),
(7, 'Dining Out'),
(8, 'Education & Reference'),
(9, 'Entertainment & Music'),
(10, 'Environment'),
(11, 'Family & Relationships'),
(12, 'Food & Drink'),
(13, 'Games & Recreation'),
(14, 'Health'),
(15, 'Home & Garden'),
(16, 'Horoscope'),
(17, 'News & Events'),
(18, 'Pets'),
(19, 'Politics & Government'),
(20, 'Pregnancy & Parenting'),
(21, 'Science & Mathematics'),
(22, 'Social Science'),
(23, 'Society & Culture'),
(24, 'Sports'),
(25, 'Travel');";

$exe1=mysql_query($sql1) or die(mysql_error());
$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."category_ads` (
  `cat_id` int(3) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `parent_id` int(3) NOT NULL,
  `ads_count` int(5) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."category_ads` (`cat_id`, `category`, `parent_id`, `ads_count`) VALUES
(1, 'Items For Sale', 0, 0),
(2, 'Rentals', 0, 0),
(3, 'Vehicles', 0, 0),
(4, 'Property', 0, 0),
(5, 'Jobs', 0, 0),
(6, 'Textbooks', 1, 0),
(7, 'Tickets', 1, 0),
(8, 'Electronics', 1, 2),
(9, 'Furniture', 1, 0),
(10, 'Clothes & Accessories', 1, 0),
(11, 'Computers', 1, 0),
(12, 'Sporting Goods & Bicycles', 1, 0),
(13, 'Movies, Music & Video Games', 1, 1),
(14, 'Baby & Kid Stuff', 1, 0),
(15, 'Musical Instruments', 1, 0),
(16, 'Home & Garden', 1, 0),
(17, 'Collectibles', 1, 0),
(18, 'Health & Beauty', 1, 0),
(19, 'Services', 1, 0),
(20, 'Everything Else', 1, 0),
(21, 'Apartments', 2, 0),
(22, 'Condos', 2, 0),
(23, 'Homes', 2, 0),
(24, 'Short Term', 2, 0),
(25, 'Roommates', 2, 0),
(26, 'Other', 2, 0),
(27, 'Cars', 3, 1),
(28, 'Motorcycles', 3, 0),
(29, 'Parts & Accessories', 3, 0),
(30, 'Power Sports', 3, 0),
(31, 'Airplanes & Aviation', 3, 0),
(32, 'Boats', 3, 0),
(33, 'RVs & Motor Homes', 3, 0),
(34, 'Other Vehicles', 3, 0),
(35, 'Homes', 4, 0),
(36, 'Condos', 4, 0),
(37, 'Foreclosures', 4, 0),
(38, 'Other', 4, 0),
(39, 'Accounting & Finance', 5, 0),
(40, 'Admin & Support Services', 5, 0),
(41, 'Advertising, Marketing & PR', 5, 0),
(42, 'Architecture & Design', 5, 0),
(43, 'Art, Media & Writer', 5, 0),
(44, 'Civil Service & Public Policy', 5, 0),
(45, 'Construction & Skilled Labor', 5, 0),
(46, 'Customer Service & Call Center', 5, 0),
(47, 'Domestic Help & Child Care', 5, 0),
(48, 'Engineering & Product Development', 5, 0),
(49, 'Facilities & Maintenance', 5, 0),
(50, 'General Labor & Warehouse', 5, 0),
(51, 'Healthcare & Nurse', 5, 0),
(52, 'Hospitality, Tourism & Travel', 5, 0),
(53, 'Human Resources & Recruiting', 5, 1),
(54, 'Law Enforcement & Security', 5, 0),
(55, 'Legal', 5, 0),
(56, 'Management & Executive', 5, 0),
(57, 'Non-Profit & Fundraising', 5, 0),
(58, 'Oil, Gas & Solar Power', 5, 0),
(59, 'Production & Operation', 5, 0),
(60, 'Quality Assurance & Control', 5, 0),
(61, 'Property', 5, 0),
(62, 'Research & Development', 5, 0),
(63, 'Retail, Grocery & Wholesale', 5, 0),
(64, 'Sales & Business Development', 5, 0),
(65, 'Salon, Fitness & Spa', 5, 0),
(66, 'Science, Pharma & Biotech', 5, 0),
(67, 'Social Services & Counseling', 5, 0),
(68, 'Teaching, Training & Library', 5, 0),
(69, 'Computer & Software', 5, 0),
(70, 'Transportation & Logistics', 5, 0),
(71, 'TV, Film & Musician', 5, 0),
(72, 'Veterinary & Animal Care', 5, 0),
(73, 'Work at Home & Self Employed', 5, 0),
(74, 'Other Jobs', 5, 0);";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."city` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."city` (`id`, `name`, `status`) VALUES
(1, 'Agra', 0),
(2, 'Ahmedabad', 0),
(3, 'Allahabad', 0),
(4, 'Amravati', 0),
(5, 'Amritsar', 0),
(6, 'Ashok Nagar', 0),
(7, 'Baharampur', 0),
(8, 'Bahadurgarh', 0),
(9, 'Balasore', 0),
(10, 'Belgaum', 0),
(11, 'Bhubaneswar', 0),
(12, 'Chengalpattu', 0),
(13, 'Cochin', 0),
(14, 'Coimbatore', 0),
(15, 'Coonoor', 0),
(16, 'Darjeeling', 0),
(17, 'Dharampur', 0);";

$exe1=mysql_query($sql1) or die(mysql_error());



$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."classifieds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `desc` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `type` int(3) NOT NULL,
  `city` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `count_comments` int(5) NOT NULL,
  `classifieds_photo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12350 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."classifieds_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comments` varchar(256) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(5) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;";

$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."cms` (
  `cms_id` int(2) NOT NULL AUTO_INCREMENT,
  `cms_title` varchar(50) NOT NULL,
  `cms_desc` longtext,
  `cms_metatag` varchar(150) DEFAULT NULL,
  `cms_metadesc` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`cms_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1  ;";

$exe1=mysql_query($sql1) or die(mysql_error());
$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."comments` (
  `comment_id` int(4) NOT NULL AUTO_INCREMENT,
  `message_id` int(4) NOT NULL,
  `user_id` int(4) NOT NULL,
  `comment_date` date NOT NULL,
  `comment` longtext NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."country` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `ccode` varchar(2) DEFAULT NULL,
  `cdesc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `cid` (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=275 ;";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."country` (`cid`, `ccode`, `cdesc`) VALUES
(1, 'AX', 'Aland Islands'),
(2, 'AF', 'Afghanistan'),
(3, 'AL', 'Albania'),
(4, 'DZ', 'Algeria'),
(5, 'AS', 'American Samoa'),
(6, 'AD', 'Andorra'),
(7, 'AO', 'Angola'),
(8, NULL, 'Anguilla'),
(9, NULL, 'Antarctica'),
(10, NULL, 'Antigua And Barbuda'),
(11, NULL, 'Argentina'),
(12, NULL, 'Armenia'),
(13, NULL, 'Aruba'),
(14, NULL, 'Australia'),
(15, NULL, 'Austria'),
(16, NULL, 'Azerbaijan'),
(17, NULL, 'Bahamas'),
(18, NULL, 'Bahrain'),
(19, NULL, 'Bangladesh'),
(20, NULL, 'Barbados'),
(21, NULL, 'Belarus'),
(22, NULL, 'Belgium'),
(23, NULL, 'Belize'),
(24, NULL, 'Benin'),
(25, NULL, 'Bermuda'),
(26, NULL, 'Bhutan'),
(27, NULL, 'Bolivia'),
(28, NULL, 'Bosnia And Herzegovina'),
(29, NULL, 'Botswana'),
(30, NULL, 'Bouvet Island'),
(31, NULL, 'Brazil'),
(32, NULL, 'British Indian Ocean Territory'),
(33, NULL, 'Brunei Darussalam'),
(34, NULL, 'Bulgaria'),
(35, NULL, 'Burkina Faso'),
(36, NULL, 'Burundi'),
(37, NULL, 'Anguilla'),
(38, NULL, 'Antarctica'),
(39, NULL, 'Antigua And Barbuda'),
(40, NULL, 'Argentina'),
(41, NULL, 'Armenia'),
(42, NULL, 'Aruba'),
(43, NULL, 'Australia'),
(44, NULL, 'Austria'),
(45, NULL, 'Azerbaijan'),
(46, NULL, 'Bahamas'),
(47, NULL, 'Bahrain'),
(48, NULL, 'Bangladesh'),
(49, NULL, 'Barbados'),
(50, NULL, 'Belarus'),
(51, NULL, 'Belgium'),
(52, NULL, 'Belize'),
(53, NULL, 'Benin'),
(54, NULL, 'Bermuda'),
(55, NULL, 'Bhutan'),
(56, NULL, 'Bolivia'),
(57, NULL, 'Bosnia And Herzegovina'),
(58, NULL, 'Botswana'),
(59, NULL, 'Bouvet Island'),
(60, NULL, 'Brazil'),
(61, NULL, 'British Indian Ocean Territory'),
(62, NULL, 'Brunei Darussalam'),
(63, NULL, 'Bulgaria'),
(64, NULL, 'Burkina Faso'),
(65, NULL, 'Burundi'),
(66, NULL, 'C?te D''Ivoire'),
(67, NULL, 'Cambodia'),
(68, NULL, 'Cameroon'),
(69, NULL, 'Canada'),
(70, NULL, 'Cape Verde'),
(71, NULL, 'Cayman Islands'),
(72, NULL, 'Central African Republic'),
(73, NULL, 'Chad'),
(74, NULL, 'Chile'),
(75, NULL, 'China'),
(76, NULL, 'Christmas Island'),
(77, NULL, 'Cocos (Keeling) Islands'),
(78, NULL, 'Colombia'),
(79, NULL, 'Comoros'),
(80, NULL, 'Congo'),
(81, NULL, 'Congo, The Democratic Republic Of The'),
(82, NULL, 'Cook Islands'),
(83, NULL, 'Costa Rica'),
(84, NULL, 'Croatia'),
(85, NULL, 'Cuba'),
(86, NULL, 'Cyprus'),
(87, NULL, 'Czech Republic'),
(88, NULL, 'Denmark'),
(89, NULL, 'Djibouti'),
(90, NULL, 'Dominica'),
(91, NULL, 'Dominican Republic'),
(92, NULL, 'Ecuador'),
(93, NULL, 'Egypt'),
(94, NULL, 'El Salvador'),
(95, NULL, 'Equatorial Guinea'),
(96, NULL, 'Eritrea'),
(97, NULL, 'Estonia'),
(98, NULL, 'Ethiopia'),
(99, NULL, 'Falkland Islands (Malvinas)'),
(100, NULL, 'Faroe Islands'),
(101, NULL, 'Fiji'),
(102, NULL, 'Finland'),
(103, NULL, 'France'),
(104, NULL, 'French Guiana'),
(105, NULL, 'French Polynesia'),
(106, NULL, 'French Southern Territories'),
(107, NULL, 'Gabon'),
(108, NULL, 'Gambia'),
(109, NULL, 'Georgia'),
(110, NULL, 'Germany'),
(111, NULL, 'Ghana'),
(112, NULL, 'Gibraltar'),
(113, NULL, 'Greece'),
(114, NULL, 'Greenland'),
(115, NULL, 'Grenada'),
(116, NULL, 'Guadeloupe'),
(117, NULL, 'Guam'),
(118, NULL, 'Guatemala'),
(119, NULL, 'Guernsey'),
(120, NULL, 'Guinea'),
(121, NULL, 'Guinea-Bissau'),
(122, NULL, 'Guyana'),
(123, NULL, 'Haiti'),
(124, NULL, 'Heard Island And Mcdonald Islands'),
(125, NULL, 'Holy See (Vatican City State)'),
(126, NULL, 'Honduras'),
(127, NULL, 'Hong Kong'),
(128, NULL, 'Hungary'),
(129, NULL, 'Iceland'),
(130, NULL, 'India'),
(131, NULL, 'Indonesia'),
(132, NULL, 'Iran, Islamic Republic Of'),
(133, NULL, 'Iraq'),
(134, NULL, 'Ireland'),
(135, NULL, 'Isle Of Man'),
(136, NULL, 'Israel'),
(137, NULL, 'Italy'),
(138, NULL, 'Jamaica'),
(139, NULL, 'Japan'),
(140, NULL, 'Jersey'),
(141, NULL, 'Jordan'),
(142, NULL, 'Kazakhstan'),
(143, NULL, 'Kenya'),
(144, NULL, 'Kiribati'),
(145, NULL, 'Korea, Democratic People''s Republic Of'),
(146, NULL, 'Korea, Republic Of'),
(147, NULL, 'Kuwait'),
(148, NULL, 'Kyrgyzstan'),
(149, NULL, 'Lao People''s Democratic Republic'),
(150, NULL, 'Latvia'),
(151, NULL, 'Lebanon'),
(152, NULL, 'Lesotho'),
(153, NULL, 'Liberia'),
(154, NULL, 'Libyan Arab Jamahiriya'),
(155, NULL, 'Liechtenstein'),
(156, NULL, 'Lithuania'),
(157, NULL, 'Luxembourg'),
(158, NULL, 'Macao'),
(159, NULL, 'Macedonia, The Former Yugoslav Republic Of'),
(160, NULL, 'Madagascar'),
(161, NULL, 'Malawi'),
(162, NULL, 'Malaysia'),
(163, NULL, 'Maldives'),
(164, NULL, 'Mali'),
(165, NULL, 'Malta'),
(166, NULL, 'Marshall Islands'),
(167, NULL, 'Martinique'),
(168, NULL, 'Mauritania'),
(169, NULL, 'Mauritius'),
(170, NULL, 'Mayotte'),
(171, NULL, 'Mexico'),
(172, NULL, 'Micronesia, Federated States Of'),
(173, NULL, 'Moldova, Republic Of'),
(174, NULL, 'Monaco'),
(175, NULL, 'Mongolia'),
(176, NULL, 'Montenegro'),
(177, NULL, 'Montserrat'),
(178, NULL, 'Morocco'),
(179, NULL, 'Mozambique'),
(180, NULL, 'Myanmar'),
(181, NULL, 'Namibia'),
(182, NULL, 'Nauru'),
(183, NULL, 'Nepal'),
(184, NULL, 'Netherlands'),
(185, NULL, 'Netherlands Antilles'),
(186, NULL, 'New Caledonia'),
(187, NULL, 'New Zealand'),
(188, NULL, 'Nicaragua'),
(189, NULL, 'Niger'),
(190, NULL, 'Nigeria'),
(191, NULL, 'Niue'),
(192, NULL, 'Norfolk Island'),
(193, NULL, 'Northern Mariana Islands'),
(194, NULL, 'Norway'),
(195, NULL, 'Oman'),
(196, NULL, 'Pakistan'),
(197, NULL, 'Palau'),
(198, NULL, 'Palestinian Territory, Occupied'),
(199, NULL, 'Panama'),
(200, NULL, 'Papua New Guinea'),
(201, NULL, 'Paraguay'),
(202, NULL, 'Peru'),
(203, NULL, 'Philippines'),
(204, NULL, 'Pitcairn'),
(205, NULL, 'Poland'),
(206, NULL, 'Portugal'),
(207, NULL, 'Puerto Rico'),
(208, NULL, 'Qatar'),
(209, NULL, 'R?union'),
(210, NULL, 'Romania'),
(211, NULL, 'Russian Federation'),
(212, NULL, 'Rwanda'),
(213, NULL, 'Saint Barth?lemy'),
(214, NULL, 'Saint Helena'),
(215, NULL, 'Saint Kitts And Nevis'),
(216, NULL, 'Saint Lucia'),
(217, NULL, 'Saint Martin'),
(218, NULL, 'Saint Pierre And Miquelon'),
(219, NULL, 'Saint Vincent And The Grenadines'),
(220, NULL, 'Samoa'),
(221, NULL, 'San Marino'),
(222, NULL, 'Sao Tome And Principe'),
(223, NULL, 'Saudi Arabia'),
(224, NULL, 'Senegal'),
(225, NULL, 'Serbia'),
(226, NULL, 'Seychelles'),
(227, NULL, 'Sierra Leone'),
(228, NULL, 'Singapore'),
(229, NULL, 'Slovakia'),
(230, NULL, 'Slovenia'),
(231, NULL, 'Solomon Islands'),
(232, NULL, 'Somalia'),
(233, NULL, 'South Africa'),
(234, NULL, 'South Georgia And The South Sandwich Islands'),
(235, NULL, 'Spain'),
(236, NULL, 'Sri Lanka'),
(237, NULL, 'Sudan'),
(238, NULL, 'Suriname'),
(239, NULL, 'Svalbard And Jan Mayen'),
(240, NULL, 'Swaziland'),
(241, NULL, 'Sweden'),
(242, NULL, 'Switzerland'),
(243, NULL, 'Syrian Arab Republic'),
(244, NULL, 'Taiwan, Province Of China'),
(245, NULL, 'Tajikistan'),
(246, NULL, 'Tanzania, United Republic Of'),
(247, NULL, 'Thailand'),
(248, NULL, 'Timor-Leste'),
(249, NULL, 'Togo'),
(250, NULL, 'Tokelau'),
(251, NULL, 'Tonga'),
(252, NULL, 'Trinidad And Tobago'),
(253, NULL, 'Tunisia'),
(254, NULL, 'Turkey'),
(255, NULL, 'Turkmenistan'),
(256, NULL, 'Turks And Caicos Islands'),
(257, NULL, 'Tuvalu'),
(258, NULL, 'Uganda'),
(259, NULL, 'Ukraine'),
(260, NULL, 'United Arab Emirates'),
(261, NULL, 'United Kingdom'),
(262, NULL, 'United States'),
(263, NULL, 'United States Minor Outlying Islands'),
(264, NULL, 'Uruguay'),
(265, NULL, 'Uzbekistan'),
(266, NULL, 'Vanuatu'),
(267, NULL, 'Venezuela'),
(268, NULL, 'Viet Nam'),
(269, NULL, 'Virgin Islands, British'),
(270, NULL, 'Virgin Islands, U.S.'),
(271, NULL, 'Wallis And Futuna'),
(272, NULL, 'Western Sahara'),
(273, NULL, 'Yemen'),
(274, NULL, 'Zambia');";

$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(256) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `event_place` varchar(60) DEFAULT NULL,
  `event_description` mediumtext,
  `event_date` date DEFAULT NULL,
  `end_date` date NOT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `address` varchar(256) NOT NULL,
  `contacts` bigint(20) NOT NULL,
  `member_count` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `posted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_count` int(11) NOT NULL,
  `contact_email` varchar(256) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `event_id` (`event_id`),
  KEY `event_name` (`event_name`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=123473 ;";

$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."events_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comments` varchar(140) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `comments` (`comments`),
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1041 ;";

$exe1=mysql_query($sql1) or die(mysql_error());



$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."event_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."event_category` (`category_id`, `category_name`) VALUES
(1, 'Business & Finance'),
(2, 'Computers & Internet'),
(3, 'Culture & Community'),
(4, 'Entertainment & Arts'),
(7, 'Sports'),
(8, 'Technology');";

$exe1=mysql_query($sql1) or die(mysql_error());



$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."event_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `userid` int(10) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=168 ;";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."event_photo` (
  `photo_id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `photo_name` varchar(100) NOT NULL,
  PRIMARY KEY (`photo_id`),
  KEY `photo_id` (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12356 ;";
$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."fans` (
  `fanId` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `uniquevalue` varchar(500) NOT NULL,
  `dateofjoining` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`fanId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1  ;";
$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."filestore` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(200) NOT NULL,
  `filedata` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1  ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."forum` (
  `category_id` int(3) NOT NULL,
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `posts` int(5) NOT NULL,
  `hit` int(8) NOT NULL,
  `lpost` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic` varchar(256) NOT NULL,
  `topic_desc` text NOT NULL,
  `group_id` int(11) NOT NULL,
  `object_type` int(3) NOT NULL DEFAULT '1' COMMENT '1=normal forum,-1=group discussion',
  PRIMARY KEY (`topic_id`),
  KEY `author_id` (`author_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2359 ;";


$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."forum_category` (
  `category_id` int(3) NOT NULL AUTO_INCREMENT,
  `forum_category` varchar(40) NOT NULL,
  `category_description` varchar(256) NOT NULL,
  `total_discussion` int(11) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `forum_category` (`forum_category`),
  UNIQUE KEY `forum_category_2` (`forum_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."forum_category` (`category_id`, `forum_category`, `category_description`, `total_discussion`) VALUES
(1, 'Arts &amp; Humanities', 'All arts and humanities will come under this category', 1),
(2, 'Beauty & Style', '', 0),
(3, 'Business & Finance', '', -1),
(4, 'Cars & Transportation', '', 0),
(5, 'Computers & Internet', '', 0),
(6, 'Consumer Electronics', '', 0),
(7, 'Dining Out', '', 0),
(8, 'Education & Reference', '', 0),
(9, 'Entertainment & Music', '', 0),
(10, 'Environment', '', 0),
(11, 'Family & Relationships', '', 0),
(12, 'Food & Drink', '', 0),
(13, 'Games & Recreation', '', 0),
(14, 'Health', '', 0),
(16, 'Horoscope', '', 0),
(17, 'News & Events', '', 0),
(18, 'Pets', '', 0),
(19, 'Politics & Government', '', 0),
(20, 'Pregnancy & Parenting', '', 0),
(21, 'Science & Mathematics', '', 0),
(22, 'Social Science', '', 0),
(23, 'Society & Culture', '', 0),
(24, 'Sports', '', 0),
(25, 'Travel', '', 0);";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."forum_discussion` (
  `topic_id` int(11) NOT NULL,
  `discuss_id` int(11) NOT NULL AUTO_INCREMENT,
  `commentor_id` int(11) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `desc` text NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`discuss_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."freinds_referral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` varchar(200) NOT NULL,
  `userid` int(11) NOT NULL,
  `message` varchar(256) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1  ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."general_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(400) NOT NULL,
  `meta_keywords` varchar(300) NOT NULL,
  `meta_desc` varchar(400) NOT NULL,
  `logo_path` varchar(100) DEFAULT NULL,
  `theme` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());
$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_name` varchar(256) NOT NULL,
  `group_photo` varchar(50) NOT NULL,
  `group_desc` text NOT NULL,
  `group_category` int(3) NOT NULL,
  `group_access` int(11) NOT NULL COMMENT '0 - automatic membership  1 - approval from admin',
  `company_name` varchar(256) NOT NULL,
  `member_count` int(8) NOT NULL,
  `location` varchar(50) NOT NULL,
  `website` varchar(100) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `group_status` int(3) NOT NULL DEFAULT '1',
  `group_country` int(3) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."group_category` (
  `group_category_id` int(3) NOT NULL AUTO_INCREMENT,
  `group_category_name` varchar(70) NOT NULL,
  PRIMARY KEY (`group_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."group_category` (`group_category_id`, `group_category_name`) VALUES
(1, 'Animals'),
(2, 'Business & Finance'),
(3, 'Computers & Internet'),
(4, 'Culture & Community'),
(5, 'Entertainment & Arts'),
(6, 'Family & Home'),
(7, 'Games'),
(8, 'Government & Politics'),
(9, 'Health & Wellness'),
(10, 'Hobbies & Crafts'),
(12, 'Regional'),
(13, 'Religion & Beliefs'),
(14, 'Romance &amp; Relationships'),
(15, 'Music');";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."group_members` (
  `group_member_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `member_status` int(3) NOT NULL DEFAULT '1' COMMENT '1=members,-1=pending',
  PRIMARY KEY (`group_member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1010 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."inbox` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `message` longtext,
  `mail_date` datetime NOT NULL,
  `mod_id` int(2) DEFAULT NULL,
  PRIMARY KEY (`mail_id`),
  UNIQUE KEY `mail_id` (`mail_id`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `subject` (`subject`),
  FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1425 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."mail_template` (
  `mail_temp_id` int(3) NOT NULL AUTO_INCREMENT,
  `mail_temp_title` varchar(100) NOT NULL,
  `mail_subject` varchar(256) DEFAULT NULL,
  `mail_temp_code` longtext NOT NULL,
  PRIMARY KEY (`mail_temp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."mail_template` (`mail_temp_id`, `mail_temp_title`, `mail_subject`, `mail_temp_code`) VALUES
(1, 'Registration', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt;Welcome to N.Social #user_name# !\r\n\r\n      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\nCongratulations #user_name# for creating your account on n.social identity that you\r\n\r\ncontrol. You can now use your n.social to sign in and find friends, groups,\r\n\r\nand many upcoming features, making the social connection quick and easy.\r\n\r\nJust look for this login box on websites.&lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;table width=&quot;440&quot; border=&quot;0&quot;&gt;\r\n\r\n        &lt;tr&gt;\r\n\r\n          &lt;td width=&quot;106&quot;&gt;&lt;div align=&quot;right&quot;&gt;Your User Id :&lt;/div&gt;&lt;/td&gt;\r\n\r\n          &lt;td width=&quot;18&quot;&gt; &lt;/td&gt;\r\n\r\n          &lt;td width=&quot;303&quot;&gt;#user_id#&lt;/td&gt;\r\n\r\n        &lt;/tr&gt;\r\n\r\n        &lt;tr&gt;\r\n\r\n          &lt;td&gt;&lt;div align=&quot;right&quot;&gt;Your Password : &lt;/div&gt;&lt;/td&gt;\r\n\r\n          &lt;td&gt; &lt;/td&gt;\r\n\r\n          &lt;td&gt;#user_pass#&lt;/td&gt;\r\n\r\n        &lt;/tr&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;p align=&quot;left&quot;&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;left&quot;&gt; &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social \r\n\r\n              &lt;/h1&gt;\r\n\r\n            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;\r\n\r\n            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.  \r\n\r\n      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;\r\n\r\n      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;\r\n\r\n      &lt;/p&gt;\r\n\r\n      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(4, 'Commented', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #friend_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #friend_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #user_name# has commented on your update. #description# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View &lt;/a&gt; the comment and replay to it. &lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to  &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View&lt;/a&gt; #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(10, 'Invite friends', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\n\n&lt;html&gt;&lt;head&gt;\n\n\n\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\n\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\n\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\n\n&lt;/div&gt;\n\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\n\n  &lt;tbody&gt;\n\n    &lt;tr&gt;\n\n      &lt;td&gt;\n\n      &lt;h1 style=&quot;text-align: center;&quot;&gt;Welcome to N.Social Network !\n\n      &lt;/h1&gt;\n\n      &lt;p&gt;\n        Welcome to Ndot social network. &lt;?php echo #this-&gt;username; ?&gt; Inviting you to join ndot.social.&lt;br&gt;\n&lt;?php echo #message; ?&gt;\n       &lt;/p&gt;\n\n      &lt;p align=&quot;center&quot;&gt;\n\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\n      &lt;p align=&quot;left&quot;&gt; &lt;/p&gt;\n\n      &lt;p align=&quot;left&quot;&gt; &lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\n\n        &lt;tbody&gt;\n\n          &lt;tr&gt;\n\n             &lt;td colspan=&quot;2&quot;&gt;\n\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\n\n                Great features of N.Social \n\n              &lt;/h1&gt;\n\n            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n          &lt;tr&gt;\n\n            &lt;td valign=&quot;top&quot;&gt;\n\n            &lt;ul&gt;\n\n              &lt;li&gt;\n\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\n\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\n\n              &lt;li&gt;\n\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\n\n              Here u can use any of the above site longin details for \n\n              n.social authentication factor.&lt;/li&gt;\n\n              &lt;li&gt;\n\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \n\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\n\n            &lt;/ul&gt;\n\n            &lt;p&gt;\n\n              These are just a few of the added benefits of having a n.social.\n\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;\n\n            &lt;/td&gt;\n\n            &lt;td valign=&quot;center&quot;&gt;\n\n            &lt;p&gt;\n\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\n\n            &lt;p&gt;\n\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\n\n            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n        &lt;/tbody&gt;\n\n      &lt;/table&gt;\n\n      &lt;hr&gt;\n\n      &lt;p&gt;\n\n      Again, welcome to n.social and we hope you enjoy the service.\n\n      Please feel free to provide us with feedback on your experience by\n\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.  \n\n      &lt;/p&gt;\n\n      &lt;p&gt;\n\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;\n\n      &lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;p align=&quot;center&quot;&gt;\n\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;\n\n      &lt;/p&gt;\n\n      &lt;/td&gt;\n\n    &lt;/tr&gt;\n\n  &lt;/tbody&gt;\n\n&lt;/table&gt;\n\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\n\n&lt;/div&gt;\n\n&lt;/body&gt;&lt;/html&gt;\n'),
(14, 'Commented on photos', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://192.168.1.2:1154/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n&lt;a href=&quot;http:/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n&lt;/div&gt;\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n  &lt;tbody&gt;\r\n    &lt;tr&gt;\r\n      &lt;td&gt;\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n      &lt;p&gt;\r\n		Hi #&lt;span style=&quot;text-align: center;&quot;&gt;user_name&lt;/span&gt;# ,&lt;/p&gt;\r\n      &lt;blockquote&gt;\r\n        &lt;blockquote&gt;\r\n          &lt;p&gt;                  #friend_name# has commented on your photos. &lt;/p&gt;\r\n          &lt;p&gt; Click here to &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View &lt;/a&gt; the comment and replay to it. &lt;/p&gt;\r\n          &lt;p&gt;Click here to  &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View&lt;/a&gt; #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n        &lt;/blockquote&gt;\r\n      &lt;/blockquote&gt;\r\n      &lt;p&gt; &lt;/p&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a href=&quot;http:/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n        &lt;tbody&gt;\r\n          &lt;tr&gt;\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n          &lt;tr&gt;\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n            &lt;ul&gt;\r\n              &lt;li&gt;\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n              &lt;li&gt;\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n              Here u can use any of the above site longin details for \r\n              n.social authentication factor.&lt;/li&gt;\r\n              &lt;li&gt;\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http:/&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http:/&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n            &lt;/ul&gt;\r\n            &lt;p&gt;\r\n              These are just a few of the added benefits of having a n.social.\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n            &lt;p&gt;\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n            &lt;p&gt;\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n        &lt;/tbody&gt;\r\n      &lt;/table&gt;\r\n      &lt;hr&gt;\r\n      &lt;p&gt;\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n      Please feel free to provide us with feedback on your experience by\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n      &lt;p&gt;\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n    &lt;/tr&gt;\r\n  &lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(15, 'Added video', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://192.168.1.2:1154//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n&lt;/div&gt;\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n  &lt;tbody&gt;\r\n    &lt;tr&gt;\r\n      &lt;td&gt;\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n      &lt;p&gt;\r\n		Hi #&lt;span style=&quot;text-align: center;&quot;&gt;user_name&lt;/span&gt;# ,&lt;/p&gt;\r\n      &lt;blockquote&gt;\r\n        &lt;blockquote&gt;\r\n          &lt;p&gt;                  #friend_name# has added a video. &lt;/p&gt;\r\n          &lt;p&gt; Click here to &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View &lt;/a&gt; the video. &lt;/p&gt;\r\n          &lt;p&gt;Click here to  &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View&lt;/a&gt; #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n        &lt;/blockquote&gt;\r\n      &lt;/blockquote&gt;\r\n      &lt;p&gt; &lt;/p&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n        &lt;tbody&gt;\r\n          &lt;tr&gt;\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n          &lt;tr&gt;\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n            &lt;ul&gt;\r\n              &lt;li&gt;\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n              &lt;li&gt;\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n              Here u can use any of the above site longin details for \r\n              n.social authentication factor.&lt;/li&gt;\r\n              &lt;li&gt;\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n            &lt;/ul&gt;\r\n            &lt;p&gt;\r\n              These are just a few of the added benefits of having a n.social.\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n            &lt;p&gt;\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n            &lt;p&gt;\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n        &lt;/tbody&gt;\r\n      &lt;/table&gt;\r\n      &lt;hr&gt;\r\n      &lt;p&gt;\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n      Please feel free to provide us with feedback on your experience by\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n      &lt;p&gt;\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n    &lt;/tr&gt;\r\n  &lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(16, 'Commented on ads', 'You Recieve comment for your ads', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi &lt;span style=&quot;text-align: center;&quot;&gt; #user_name# &lt;/span&gt; ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #friend_name# has commented on your #description# advertisement on classifieds. &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View #description#  and replay to it. &lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to  View #friend_name#&#039;s profile. &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(17, 'Inbox recieved', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n&lt;/div&gt;\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n  &lt;tbody&gt;\r\n    &lt;tr&gt;\r\n      &lt;td&gt;\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n      &lt;p&gt;\r\n		Hi #&lt;span style=&quot;text-align: center;&quot;&gt;user_name&lt;/span&gt;# ,&lt;/p&gt;\r\n      &lt;blockquote&gt;\r\n        &lt;blockquote&gt;\r\n          &lt;p&gt;                  #friend_name# has sent u a mail in  N.social. &lt;/p&gt;\r\n          &lt;p&gt; Click here to &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View &lt;/a&gt; go to your inbox . &lt;/p&gt;\r\n          &lt;p&gt;Click here to  &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View&lt;/a&gt; #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n        &lt;/blockquote&gt;\r\n      &lt;/blockquote&gt;\r\n      &lt;p&gt; &lt;/p&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n        &lt;tbody&gt;\r\n          &lt;tr&gt;\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n          &lt;tr&gt;\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n            &lt;ul&gt;\r\n              &lt;li&gt;\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n              &lt;li&gt;\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n              Here u can use any of the above site longin details for \r\n              n.social authentication factor.&lt;/li&gt;\r\n              &lt;li&gt;\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n            &lt;/ul&gt;\r\n            &lt;p&gt;\r\n              These are just a few of the added benefits of having a n.social.\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n            &lt;p&gt;\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n            &lt;p&gt;\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n        &lt;/tbody&gt;\r\n      &lt;/table&gt;\r\n      &lt;hr&gt;\r\n      &lt;p&gt;\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n      Please feel free to provide us with feedback on your experience by\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n      &lt;p&gt;\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n    &lt;/tr&gt;\r\n  &lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(18, 'Added classifieds', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n&lt;/div&gt;\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n  &lt;tbody&gt;\r\n    &lt;tr&gt;\r\n      &lt;td&gt;\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n      &lt;p&gt;\r\n		Hi #&lt;span style=&quot;text-align: center;&quot;&gt;user_name&lt;/span&gt;# ,&lt;/p&gt;\r\n      &lt;blockquote&gt;\r\n        &lt;blockquote&gt;\r\n          &lt;p&gt;                  #friend_name# has posted a advertisement. #ads# &lt;/p&gt;\r\n          &lt;p&gt; Click here to &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View &lt;/a&gt; the  advertisement.. &lt;/p&gt;\r\n          &lt;p&gt;Click here to  &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View&lt;/a&gt; #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n        &lt;/blockquote&gt;\r\n      &lt;/blockquote&gt;\r\n      &lt;p&gt; &lt;/p&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n        &lt;tbody&gt;\r\n          &lt;tr&gt;\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n          &lt;tr&gt;\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n            &lt;ul&gt;\r\n              &lt;li&gt;\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n              &lt;li&gt;\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n              Here u can use any of the above site longin details for \r\n              n.social authentication factor.&lt;/li&gt;\r\n              &lt;li&gt;\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n            &lt;/ul&gt;\r\n            &lt;p&gt;\r\n              These are just a few of the added benefits of having a n.social.\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n            &lt;p&gt;\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n            &lt;p&gt;\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n          &lt;/tr&gt;\r\n        &lt;/tbody&gt;\r\n      &lt;/table&gt;\r\n      &lt;hr&gt;\r\n      &lt;p&gt;\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n      Please feel free to provide us with feedback on your experience by\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n      &lt;p&gt;\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n      &lt;hr&gt;\r\n      &lt;p align=&quot;center&quot;&gt;\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n    &lt;/tr&gt;\r\n  &lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n&lt;/div&gt;\r\n&lt;/body&gt;&lt;/html&gt;\r\n');";


$sql1="INSERT INTO `".$prefix."mail_template` (`mail_temp_id`, `mail_temp_title`, `mail_subject`, `mail_temp_code`) VALUES
(19, 'Blog reply', 'You Recieve comment for your blog', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\n\n&lt;html&gt;&lt;head&gt;\n\n\n\n\n\n\n\n\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\n\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\n\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\n\n&lt;/div&gt;\n\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\n\n  &lt;tbody&gt;\n\n    &lt;tr&gt;\n\n      &lt;td&gt;\n\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\n\n      &lt;p&gt;\n\n		Hi &lt;span style=&quot;text-align: center;&quot;&gt; #user_name# &lt;/span&gt; ,&lt;/p&gt;\n\n      &lt;blockquote&gt;\n\n        &lt;blockquote&gt;\n\n          &lt;p&gt;                  #friend_name# has replyed for your blog. #description# &lt;/p&gt;\n\n          &lt;p&gt; Click here to View the #description# . &lt;/p&gt;\n\n          &lt;p&gt;Click here to View #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\n\n        &lt;/blockquote&gt;\n\n      &lt;/blockquote&gt;\n\n      &lt;p&gt; &lt;/p&gt;\n\n      &lt;p align=&quot;center&quot;&gt;\n\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\n\n        &lt;tbody&gt;\n\n          &lt;tr&gt;\n\n             &lt;td colspan=&quot;2&quot;&gt;\n\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\n\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n          &lt;tr&gt;\n\n            &lt;td valign=&quot;top&quot;&gt;\n\n            &lt;ul&gt;\n\n              &lt;li&gt;\n\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\n\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\n\n              &lt;li&gt;\n\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\n\n              Here u can use any of the above site longin details for \n\n              n.social authentication factor.&lt;/li&gt;\n\n              &lt;li&gt;\n\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \n\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\n\n            &lt;/ul&gt;\n\n            &lt;p&gt;\n\n              These are just a few of the added benefits of having a n.social.\n\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\n\n            &lt;td valign=&quot;center&quot;&gt;\n\n            &lt;p&gt;\n\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\n\n            &lt;p&gt;\n\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n        &lt;/tbody&gt;\n\n      &lt;/table&gt;\n\n      &lt;hr&gt;\n\n      &lt;p&gt;\n\n      Again, welcome to n.social and we hope you enjoy the service.\n\n      Please feel free to provide us with feedback on your experience by\n\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\n\n      &lt;p&gt;\n\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;p align=&quot;center&quot;&gt;\n\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\n\n    &lt;/tr&gt;\n\n  &lt;/tbody&gt;\n\n&lt;/table&gt;\n\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\n\n&lt;/div&gt;\n\n&lt;/body&gt;&lt;/html&gt;\n'),
(20, 'Reply to discussion', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #&lt;span style=&quot;text-align: center;&quot;&gt;friend_name&lt;/span&gt;# has replyied for your discussion #discussion# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View &lt;/a&gt; the replayt. &lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to  &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;View&lt;/a&gt; #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(21, 'Answered for a question', 'You Received answer for a question from N.social media', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #friend_name# has answered for ur question #description# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View the answer #description#.&lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to view #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(22, 'Password change', NULL, '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt;Hi  #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\nDear #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n        As you requested, your password has now been reset. Your new details are as follows:&lt;/p&gt;\r\n\r\n      &lt;table width=&quot;440&quot; border=&quot;0&quot;&gt;\r\n\r\n        &lt;tr&gt;\r\n\r\n          &lt;td width=&quot;106&quot;&gt;&lt;div align=&quot;right&quot;&gt;Your User Id :&lt;/div&gt;&lt;/td&gt;\r\n\r\n          &lt;td width=&quot;18&quot;&gt; &lt;/td&gt;\r\n\r\n          &lt;td width=&quot;303&quot;&gt;#user_id#&lt;/td&gt;\r\n\r\n        &lt;/tr&gt;\r\n\r\n        &lt;tr&gt;\r\n\r\n          &lt;td&gt;&lt;div align=&quot;right&quot;&gt;Your Password : &lt;/div&gt;&lt;/td&gt;\r\n\r\n          &lt;td&gt; &lt;/td&gt;\r\n\r\n          &lt;td&gt;#user_pass#&lt;/td&gt;\r\n\r\n        &lt;/tr&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n       &lt;p align=&quot;left&quot;&gt;To change your password, please visit this page: &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://http://192.168.1.2:1154/profile.php?do=editpassword&quot;&gt;click here&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;p align=&quot;left&quot;&gt; &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social \r\n\r\n              &lt;/h1&gt;\r\n\r\n            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;\r\n\r\n            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.  \r\n\r\n      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;\r\n\r\n      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;\r\n\r\n      &lt;/p&gt;\r\n\r\n      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(23, 'Commented on forum', 'you receive commented for  your forum discussion', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #friend_name# has commented for ur forum discussion #description# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View the discusssion #description#.&lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to view #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(24, 'Commented on video', 'you receive commented for  your video', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\n\n&lt;html&gt;&lt;head&gt;\n\n\n\n\n\n\n\n\n\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\n\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\n\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\n\n&lt;/div&gt;\n\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\n\n  &lt;tbody&gt;\n\n    &lt;tr&gt;\n\n      &lt;td&gt;\n\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\n\n      &lt;p&gt;\n\n		Hi #user_name# ,&lt;/p&gt;\n\n      &lt;blockquote&gt;\n\n        &lt;blockquote&gt;\n\n          &lt;p&gt;                  #friend_name# has commented for your video #description# &lt;/p&gt;\n\n          &lt;p&gt; Click here to View the video #description# comments.&lt;/p&gt;\n\n          &lt;p&gt;Click here to view #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\n\n        &lt;/blockquote&gt;\n\n      &lt;/blockquote&gt;\n\n      &lt;p&gt; &lt;/p&gt;\n\n      &lt;p align=&quot;center&quot;&gt;\n\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\n\n        &lt;tbody&gt;\n\n          &lt;tr&gt;\n\n             &lt;td colspan=&quot;2&quot;&gt;\n\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\n\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n          &lt;tr&gt;\n\n            &lt;td valign=&quot;top&quot;&gt;\n\n            &lt;ul&gt;\n\n              &lt;li&gt;\n\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\n\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\n\n              &lt;li&gt;\n\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\n\n              Here u can use any of the above site longin details for \n\n              n.social authentication factor.&lt;/li&gt;\n\n              &lt;li&gt;\n\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \n\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\n\n            &lt;/ul&gt;\n\n            &lt;p&gt;\n\n              These are just a few of the added benefits of having a n.social.\n\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\n\n            &lt;td valign=&quot;center&quot;&gt;\n\n            &lt;p&gt;\n\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\n\n            &lt;p&gt;\n\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n        &lt;/tbody&gt;\n\n      &lt;/table&gt;\n\n      &lt;hr&gt;\n\n      &lt;p&gt;\n\n      Again, welcome to n.social and we hope you enjoy the service.\n\n      Please feel free to provide us with feedback on your experience by\n\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\n\n      &lt;p&gt;\n\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;p align=&quot;center&quot;&gt;\n\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\n\n    &lt;/tr&gt;\n\n  &lt;/tbody&gt;\n\n&lt;/table&gt;\n\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\n\n&lt;/div&gt;\n\n&lt;/body&gt;&lt;/html&gt;\n'),
(25, 'Commented on photo', 'you receive commented for your photo', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #friend_name# has commented for your photo #description# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View the photo #description# comments.&lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to view #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n\r\n'),
(26, 'Join event', 'joined in the event', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #friend_name# has joined in your event #description# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View the event #description# comments.&lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to view #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n');";


$sql1="INSERT INTO `".$prefix."mail_template` (`mail_temp_id`, `mail_temp_title`, `mail_subject`, `mail_temp_code`) VALUES
(27, 'Unjoin event', 'unjoined from the event', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #friend_name# has unjoined in your event #description# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View the event #description# comments.&lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to view #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(28, 'Group wall', 'Received comment on your group wall', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name#,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                 #friend_name# has written on your group  #description# wall.  &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View  your group #description# wall and replay to it. &lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to View #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(29, 'Group discussion', 'Your group member created discussion on your group', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name#,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                 #friend_name# has created discussion on your group  #description# wall.  &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View  discussion on your group #description# . &lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to View #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(30, 'Group photo', 'Your group member added photos on your group', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name#,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                 #friend_name# has added photos on your group  #description# wall.  &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to View  your group #description# photos and replay to it. &lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to View #friend_name#&#039;s profile. &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;&lt;/a&gt; &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(31, 'Wall', 'Received comment on your  wall', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\r\n\r\n&lt;html&gt;&lt;head&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\r\n\r\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\r\n\r\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n  &lt;tbody&gt;\r\n\r\n    &lt;tr&gt;\r\n\r\n      &lt;td&gt;\r\n\r\n      &lt;h1 style=&quot;text-align: center;&quot;&gt; Hi #user_name# !      &lt;/h1&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n		Hi #user_name# ,&lt;/p&gt;\r\n\r\n      &lt;blockquote&gt;\r\n\r\n        &lt;blockquote&gt;\r\n\r\n          &lt;p&gt;                  #friend_name# has written on your wall. #description# &lt;/p&gt;\r\n\r\n          &lt;p&gt; Click here to view your wall #description#. &lt;/p&gt;\r\n\r\n          &lt;p&gt;Click here to  View #friend_name#&#039;s profile.  &lt;/p&gt;\r\n\r\n        &lt;/blockquote&gt;\r\n\r\n      &lt;/blockquote&gt;\r\n\r\n      &lt;p&gt; &lt;/p&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\r\n\r\n        &lt;tbody&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n             &lt;td colspan=&quot;2&quot;&gt;\r\n\r\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\r\n\r\n                Great features of N.Social              &lt;/h1&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n          &lt;tr&gt;\r\n\r\n            &lt;td valign=&quot;top&quot;&gt;\r\n\r\n            &lt;ul&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\r\n\r\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\r\n\r\n              Here u can use any of the above site longin details for \r\n\r\n              n.social authentication factor.&lt;/li&gt;\r\n\r\n              &lt;li&gt;\r\n\r\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \r\n\r\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\r\n\r\n            &lt;/ul&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n              These are just a few of the added benefits of having a n.social.\r\n\r\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n            &lt;td valign=&quot;center&quot;&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\r\n\r\n            &lt;p&gt;\r\n\r\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;            &lt;/td&gt;\r\n\r\n          &lt;/tr&gt;\r\n\r\n        &lt;/tbody&gt;\r\n\r\n      &lt;/table&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      Again, welcome to n.social and we hope you enjoy the service.\r\n\r\n      Please feel free to provide us with feedback on your experience by\r\n\r\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.      &lt;/p&gt;\r\n\r\n      &lt;p&gt;\r\n\r\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;      &lt;/p&gt;\r\n\r\n      &lt;hr&gt;\r\n\r\n      &lt;p align=&quot;center&quot;&gt;\r\n\r\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;      &lt;/p&gt;      &lt;/td&gt;\r\n\r\n    &lt;/tr&gt;\r\n\r\n  &lt;/tbody&gt;\r\n\r\n&lt;/table&gt;\r\n\r\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\r\n\r\n&lt;/div&gt;\r\n\r\n&lt;/body&gt;&lt;/html&gt;\r\n'),
(32, 'Forget password', 'New Password Details', '&lt;!DOCTYPE HTML PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt;\n\n&lt;html&gt;&lt;head&gt;\n\n\n\n\n\n\n\n\n\n&lt;/head&gt;&lt;body&gt;&lt;div style=&quot;border: 4px solid rgb(153, 153, 153); padding: 0pt 0.5em; margin-left: auto; margin-right: auto; max-width: 647px; font-family: &#039;Lucida Grande&#039;,&#039;Trebuchet MS&#039;,Arial,Helvetica,sans-serif; font-style: normal; font-variant: normal; font-weight: normal; font-size: 80%; line-height: 1.5em; font-size-adjust: none; font-stretch: normal; -x-system-font: none; color: rgb(0, 0, 0);&quot;&gt;\n\n&lt;div style=&quot;padding-top: 1.5em; text-align: center;&quot;&gt;\n\n&lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;logo.jpg&quot; alt=&quot;N.Social Logo&quot; style=&quot;border: 0pt none ;&quot;&gt;&lt;/a&gt;\n\n&lt;/div&gt;\n\n&lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;0&quot;&gt;\n\n  &lt;tbody&gt;\n\n    &lt;tr&gt;\n\n      &lt;td&gt;\n\n      &lt;h1 style=&quot;text-align: center;&quot;&gt;Hi  #user_name# !      &lt;/h1&gt;\n\n      &lt;p&gt;\n\nDear #user_name# ,&lt;/p&gt;\n\n      &lt;p&gt;\n\n        As your request, your password has now been reset. Your new details are as follows:&lt;/p&gt;\n\n      &lt;table width=&quot;440&quot; border=&quot;0&quot;&gt;\n\n        &lt;tr&gt;\n\n          &lt;td width=&quot;106&quot;&gt;&lt;div align=&quot;right&quot;&gt;Your User Id :&lt;/div&gt;&lt;/td&gt;\n\n          &lt;td width=&quot;18&quot;&gt; &lt;/td&gt;\n\n          &lt;td width=&quot;303&quot;&gt;#user_id#&lt;/td&gt;\n\n        &lt;/tr&gt;\n\n        &lt;tr&gt;\n\n          &lt;td&gt;&lt;div align=&quot;right&quot;&gt;Your Password : &lt;/div&gt;&lt;/td&gt;\n\n          &lt;td&gt; &lt;/td&gt;\n\n          &lt;td&gt;#user_pass#&lt;/td&gt;\n\n        &lt;/tr&gt;\n\n      &lt;/table&gt;\n\n       &lt;p align=&quot;left&quot;&gt;To change your password, please visit this page: &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users/forgot_password&quot;&gt;click here&lt;/a&gt;&lt;/p&gt;\n\n      &lt;p align=&quot;left&quot;&gt; &lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;table width=&quot;100%&quot; border=&quot;0&quot; cellpadding=&quot;5&quot; cellspacing=&quot;0&quot;&gt;\n\n        &lt;tbody&gt;\n\n          &lt;tr&gt;\n\n             &lt;td colspan=&quot;2&quot;&gt;\n\n              &lt;h1 style=&quot;text-align: center; margin-bottom: 0pt;&quot;&gt;\n\n                Great features of N.Social \n\n              &lt;/h1&gt;\n\n            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n          &lt;tr&gt;\n\n            &lt;td valign=&quot;top&quot;&gt;\n\n            &lt;ul&gt;\n\n              &lt;li&gt;\n\n                &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/users&quot;&gt;\n\n                &lt;strong&gt;Simple Registration&lt;/strong&gt;&lt;/a&gt;                One step registraion no questions and no much entries.              &lt;/li&gt;\n\n              &lt;li&gt;\n\n              &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/twitter&quot;&gt;Login Through OpenID, Facebook and Twitter logins&lt;/a&gt;&lt;/strong&gt;.\n\n              Here u can use any of the above site longin details for \n\n              n.social authentication factor.&lt;/li&gt;\n\n              &lt;li&gt;\n\n                &lt;strong&gt;&lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;Friend Search&lt;/a&gt;&lt;/strong&gt;. \n\n                Search your friends by using mail id, user name, cithy, state and more &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154&quot;&gt;&lt;/a&gt;.              &lt;/li&gt;\n\n            &lt;/ul&gt;\n\n            &lt;p&gt;\n\n              These are just a few of the added benefits of having a n.social.\n\n              Explore your &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;settings and features&lt;/a&gt; today!            &lt;/p&gt;\n\n            &lt;/td&gt;\n\n            &lt;td valign=&quot;center&quot;&gt;\n\n            &lt;p&gt;\n\n            &lt;a href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;img src=&quot;/&quot; style=&quot;border: 1px solid rgb(36, 108, 152);&quot; alt=&quot;login page Page Screenshot&quot; height=&quot;132&quot; width=&quot;150&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\n\n            &lt;p&gt;\n\n            &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/&quot;&gt;&lt;/a&gt;            &lt;/p&gt;\n\n            &lt;/td&gt;\n\n          &lt;/tr&gt;\n\n        &lt;/tbody&gt;\n\n      &lt;/table&gt;\n\n      &lt;hr&gt;\n\n      &lt;p&gt;\n\n      Again, welcome to n.social and we hope you enjoy the service.\n\n      Please feel free to provide us with feedback on your experience by\n\n      contacting &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;mailto:support@n.social.com&quot;&gt;support@n.social.com&lt;/a&gt;.  \n\n      &lt;/p&gt;\n\n      &lt;p&gt;\n\n      —The Team at &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://www.ndot.in&quot;&gt;Ndot.in&lt;/a&gt;\n\n      &lt;/p&gt;\n\n      &lt;hr&gt;\n\n      &lt;p align=&quot;center&quot;&gt;\n\n      &lt;a style=&quot;color: rgb(36, 108, 152);&quot; href=&quot;http://192.168.1.2:1154/privacy&quot;&gt;Privacy Policy&lt;/a&gt;\n\n      &lt;/p&gt;\n\n      &lt;/td&gt;\n\n    &lt;/tr&gt;\n\n  &lt;/tbody&gt;\n\n&lt;/table&gt;\n\n&lt;img src=&quot;mail_files/t.gif&quot; height=&quot;1&quot; width=&quot;1&quot;&gt;\n\n&lt;/div&gt;\n\n&lt;/body&gt;&lt;/html&gt;\n'),
(33, 'video share', 'your friend share video for you', 'd');";


$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."members_permission` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `members_role` int(3) NOT NULL,
  `action_add` int(3) NOT NULL,
  `action_edit` int(3) NOT NULL,
  `action_delete` int(3) NOT NULL,
  `action_block` int(3) NOT NULL,
  `status` int(3) NOT NULL COMMENT '0-disable,1-enable',
  `module_id` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."members_permission` (`id`, `members_role`, `action_add`, `action_edit`, `action_delete`, `action_block`, `status`, `module_id`) VALUES
(1, 1, 1, 1, 1, 1, 0, -1),
(2, 2, 0, 0, 0, 0, 0, -1),
(3, 3, 0, 0, 0, 0, 0, -1),
(4, 4, 1, 1, 0, 1, 1, -1),
(6, 6, 0, 0, 0, 0, 1, 2),
(7, 7, 0, 0, 0, 0, 1, 3),
(8, 8, 0, 0, 0, 0, 1, 9);";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."members_role` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `members_type` varchar(20) NOT NULL,
  `role_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."members_role` (`id`, `members_type`, `role_type`) VALUES
(1, 'Administrator', -1),
(2, 'User', -1),
(3, 'Guest', -1),
(4, 'Moderator', -1),
(6, 'Answers moderator', 0),
(7, 'Blog moderator', 0),
(8, 'Group moderator', 0);";


$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."menus` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `status` int(3) NOT NULL COMMENT '0-enabled,1-disabled',
  `login` int(2) NOT NULL COMMENT '0-need to login,1-no neet to login',
  `display_name` varchar(50) NOT NULL,
  `description` varchar(256) NOT NULL,
  `system_module` int(3) NOT NULL COMMENT '0=>normal,1=>system modules',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."modules` (
  `mod_id` int(3) NOT NULL AUTO_INCREMENT,
  `mod_name` varchar(25) NOT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."modules` (`mod_id`, `mod_name`) VALUES
(1, 'Answers'),
(2, 'Blog'),
(3, 'Classifieds'),
(4, 'Events'),
(5, 'Forum'),
(6, 'Groups'),
(7, 'Inbox'),
(8, 'News'),
(9, 'Photos'),
(10, 'Friends'),
(11, 'User Status'),
(12, 'Profile'),
(13, 'Wall'),
(14, 'Video');";


$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."module_settings` (
  `mod_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '-1- friends,0- no one,1-everone',
  `wall` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `updates` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `profile` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `video` int(2) NOT NULL DEFAULT '1' COMMENT '-1 = friends,0 = no one,1 = everone',
  `photo` int(2) NOT NULL DEFAULT '1' COMMENT '-1 = friends,0 = no one,1 = everone',
  PRIMARY KEY (`mod_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2358 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(256) NOT NULL,
  `news_desc` text NOT NULL,
  `news_date` datetime NOT NULL,
  `news_category` int(3) NOT NULL,
  `news_photo` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_count` int(5) NOT NULL,
  PRIMARY KEY (`news_id`),
  KEY `news_category` (`news_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."news_category` (
  `category_id` int(3) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(40) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."news_category` (`category_id`, `category_name`) VALUES
(1, 'Arts &amp; Humanities'),
(2, 'Beauty & Style'),
(3, 'Business & Finance'),
(4, 'Cars & Transportation'),
(5, 'Computers & Internet'),
(6, 'Consumer Electronics'),
(7, 'Dining Out'),
(8, 'Education & Reference'),
(9, 'Entertainment & Music'),
(10, 'Environment'),
(11, 'Family & Relationships'),
(12, 'Food & Drink'),
(13, 'Games & Recreation'),
(14, 'Health'),
(15, 'Home & Garden'),
(16, 'Horoscope'),
(17, 'News & Events'),
(18, 'Pets'),
(19, 'Politics & Government'),
(20, 'Pregnancy & Parenting'),
(21, 'Science & Mathematics'),
(22, 'Social Science'),
(23, 'Society & Culture'),
(24, 'Sports'),
(25, 'Travel'),
(26, 'test');";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."news_comments` (
  `comment_id` int(7) NOT NULL AUTO_INCREMENT,
  `comments` longtext NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(5) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."photos` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo_title` varchar(100) NOT NULL,
  `photo_desc` varchar(256) NOT NULL,
  `photo_date` date NOT NULL,
  `photo_name` varchar(50) NOT NULL,
  `count_comment` int(5) NOT NULL,
  `object_type` int(3) NOT NULL DEFAULT '1' COMMENT '1=album photos, -1=groups photo',
  PRIMARY KEY (`photo_id`),
  KEY `album_id` (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12458 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."photos_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `album_type` int(3) NOT NULL,
  `album_title` varchar(100) NOT NULL,
  `album_desc` varchar(256) NOT NULL,
  `album_date` date NOT NULL,
  `album_permision` int(3) NOT NULL COMMENT '0-everyone,1-friends',
  `album_cover` int(11) NOT NULL,
  PRIMARY KEY (`album_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12352 ;";


$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."photos_comments` (
  `comment_id` int(5) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comments` varchar(256) NOT NULL,
  `cdate` date NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `photo_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1030 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."profile_settings` (
  `prof_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '-1- friends,0- no one,1-everone',
  `email` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `dob` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `phone` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `mobile` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `videos` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  `wall` int(2) NOT NULL DEFAULT '1' COMMENT '-1- friends,0- no one,1-everone',
  PRIMARY KEY (`prof_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1013 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(256) NOT NULL,
  `question_description` mediumtext NOT NULL,
  `user_id` int(5) NOT NULL,
  `type` int(2) NOT NULL,
  `category` int(3) NOT NULL,
  `time` datetime NOT NULL,
  `answer` int(11) NOT NULL,
  `best_answer` int(11) NOT NULL,
  `status` int(2) NOT NULL COMMENT '0-active,1-inactive',
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2352 ;";


$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."sent_mails` (
  `sentmail_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mailto_id` int(11) DEFAULT NULL,
  `cc_id` int(11) DEFAULT NULL,
  `archive` int(2) DEFAULT '0',
  `read_status` int(2) DEFAULT '-1',
  `delete_status` int(2) DEFAULT '-1',
  PRIMARY KEY (`sentmail_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1418 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."twitter_users` (
  `user` varchar(50) NOT NULL,
  `access_key` varchar(100) NOT NULL,
  `secret_key` varchar(100) NOT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `action_id` int(3) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `third_party_url` varchar(500) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `photo_count` int(3) DEFAULT '0',
  `post_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12661 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."update_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upd_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `desc` varchar(256) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `upd_id` (`upd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";


$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."update_like` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `update_id` int(11) NOT NULL,
  `upd_like` int(1) NOT NULL COMMENT '0-unlike,1-like',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."url` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `url_type` int(2) NOT NULL COMMENT '1-login 2-logout 3-register',
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."url` (`id`, `url_type`, `url`) VALUES
('1','1', '$liurl'), 
('2','2', '$lourl'),
('3','3', '$regrl');";

$exe1=mysql_query($sql1) or die(mysql_error());



$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."users_profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `aboutme` varchar(256) NOT NULL,
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `country` int(3) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `street` varchar(50) NOT NULL DEFAULT '',
  `post_code` int(6) NOT NULL,
  `news_letter` int(2) DEFAULT '1' COMMENT '1-yes,0-no',
  `phone` bigint(12) NOT NULL,
  `mobile` bigint(12) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `user_photo` varchar(50) NOT NULL DEFAULT '',
  `total_points` int(5) NOT NULL,
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `country` (`country`)  
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12358 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."user_friend_list` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `friend_id` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `cd` datetime DEFAULT NULL,
  PRIMARY KEY (`request_id`),
  KEY `user_id` (`user_id`),
  KEY `friend_id` (`friend_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23483 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."user_interest` (
  `interest_id` int(3) NOT NULL AUTO_INCREMENT,
  `interest` varchar(250) NOT NULL,
  PRIMARY KEY (`interest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."user_interest` (`interest_id`, `interest`) VALUES
(1, 'Friends'),
(2, 'Partners'),
(3, 'Games'),
(4, 'Dating');";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."user_interest_mapping` (
  `user_id` int(11) NOT NULL,
  `interest_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


$exe1=mysql_query($sql1) or die(mysql_error());


$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(256) NOT NULL,
  `userid` int(11) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."user_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL,
  `points` int(8) NOT NULL,
  `answer_type` int(3) NOT NULL COMMENT '0=>normal,-1=>best answer,-2=>first one to answer',
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;";


$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."video` (
  `video_id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_id` int(5) NOT NULL,
  `video_title` varchar(50) DEFAULT NULL,
  `video_desc` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `thumb_url` varchar(100) DEFAULT NULL,
  `embed_code` longtext,
  `video_url` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0-Allow 1-Dont Allow',
  `comment_count` int(11) NOT NULL DEFAULT '0',
  `video_viewed` int(5) DEFAULT '0',
  `video_tag` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`video_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12366 ;";


$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."video_category` (
  `cat_id` int(5) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`cat_id`),
  FULLTEXT KEY `category` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="INSERT INTO `".$prefix."video_category` (`cat_id`, `category`) VALUES
(1, 'Autos & Vehicles'),
(2, 'Comedy'),
(3, 'Education'),
(4, 'Entertainment'),
(5, 'Film & Animation'),
(6, 'Gaming'),
(7, 'Howto & Style'),
(8, 'Music'),
(9, 'News &amp; Politic'),
(10, 'People & Blogs'),
(11, 'Pets & Animals'),
(12, 'Science & Technology'),
(13, 'Sports'),
(14, 'Travel & Events'),
(15, 'Shows'),
(16, 'Movies'),
(17, 'Contests'),
(20, 'test');";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."video_comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `comments` varchar(140) NOT NULL,
  `type_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `date` (`cdate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

$sql1="CREATE TABLE IF NOT EXISTS `".$prefix."wall` (
  `wall_id` int(11) NOT NULL AUTO_INCREMENT,
  `poster_id` int(11) NOT NULL,
  `receiver_user_id` int(11) NOT NULL,
  `wall_text` varchar(256) NOT NULL,
  `wall_date` datetime NOT NULL,
  `group_id` int(5) NOT NULL,
  `object_type` int(3) NOT NULL COMMENT '1=user,-1=group',
  PRIMARY KEY (`wall_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2367 ;";

$exe1=mysql_query($sql1) or die(mysql_error());

                
                
                mysql_query("CREATE TRIGGER profileupdate AFTER INSERT ON ".$usertbname." FOR EACH ROW BEGIN INSERT INTO ".$prefix."users_profile SET user_id = NEW.".$uidfield."; END");

                mysql_query("CREATE TRIGGER profilesetting AFTER INSERT ON ".$prefix."users_profile FOR EACH ROW BEGIN INSERT INTO ".$prefix."profile_settings SET user_id = NEW.user_id END");
                           
                mysql_query("CREATE TRIGGER modulesetting AFTER INSERT ON ".$prefix."profile_settings FOR EACH ROW BEGIN INSERT INTO ".$prefix."module_settings SET user_id = NEW.user_id END");
              
			
		//****** Creating Table ends here*******//
			/*Performing SQL query for Inserting title information in General Setting table*/
			$keywords="blog,forum,answers,inbox,articles,news";
			$meta="Ndot Open Source:Online Free social network module...";
			$createconfig="insert INTO `".$prefix."general_settings`(title,meta_keywords,meta_desc,theme) values ('$title','$keywords','$meta','default') ";
			$created=mysql_query($createconfig) or die('Query failed: ' . mysql_error());
		
			/*Creating Admin information if ndot table have selected*/
		if($table=='ndottbl')
		{
			$sql="insert INTO `".$prefix."users`(name,email,password,user_type,user_status) values ('$name','$email',md5('$password'),'-1','1') ";
			$execute=mysql_query($sql) or die('Query failed: ' . mysql_error());
			$inster_id = mysql_insert_id();
			
			$sql1="insert INTO `".$prefix."users_profile`(user_id) values ('$inster_id') ";
			$execute=mysql_query($sql1) or die('Query failed: ' . mysql_error());
			$sql1="insert INTO `".$prefix."profile_settings`(user_id) values ('$inster_id') ";
			$execute=mysql_query($sql1) or die('Query failed: ' . mysql_error());
			$sql1="insert INTO `".$prefix."module_settings`(user_id) values ('$inster_id') ";
			$execute=mysql_query($sql1) or die('Query failed: ' . mysql_error());
	
		}	
                
                if($mode==1)
                {
                       					
			$sql="INSERT INTO `".$prefix."menus` (`id`, `name`, `link`, `status`, `login`, `display_name`, `description`, `system_module`) VALUES
				(1, 'updates', '', 0, 0, 'Updates', 'LIst the all friends updates and users activities', 1),
				(3, 'blog', 'blog', 0, 0, 'Blog', 'Defines the blog activity', 0),
				(4, 'friends', 'profile', 0, 0, 'Friends', 'List the friends list', 1),
				(8, 'forum', 'forum', 0, 0, 'Forum', 'Defines the forum', 0),
				(10, 'inbox', 'inbox', 0, 0, 'Inbox', 'Defines the inbox', 1),
				(11, 'news', '/news', 0, 1, 'News', 'Defines the news', 1),
				(12, 'photos', 'photos', 0, 0, 'Photos', 'Defines the photos', 0),
				(13, 'video', 'video', 0, 0, 'Video', 'Defines the Videos', 0),
				(14, 'ktwitter', '', 0, 0, 'Ktwitter', 'Defines the twitter integration', 1),
				(15, 'lib', '', 0, 0, 'Lib', 'Defines common library functions', 1),
				(16, 'debug_toolbar', '', 1, 1, '', 'Defines the Debugger tools', 0),
				(18, 'admin', '', 0, 0, 'Admin', 'Defines the admin', 1),
				(19, 'profile', '', 0, 0, 'Profile', 'Defines the profile', 1),
				(20, 'users', '', 0, 0, 'Users', 'Defines the users', 1),
				(5, 'cms', '/cms', 0, 0, 'Cms', 'Content Management System', 1),
				(22, 'comments', '', 0, 0, '', 'comments', 1),
				(23, 'thirdparty', 'thirdparty', 0, 0, '', '', 1);";		
                        $exe=mysql_query($sql) or die(mysql_error());
	                $sql1="select * from ".$prefix."menus";
	                $modres=mysql_query($sql1) or die(mysql_error());            
	                //writing the application.php file
	                $str=implode("",file('../application/config/application-sample.php'));					
                        $fp=fopen('../application/config/application.php','w');
                        fwrite($fp,$str,strlen($str));
                        fclose($fp);
	
                        header("Location: $server_path");	
                }
		else
		{
		
		$d=$_SERVER['REQUEST_URI'];
		$d = trim($d,"process.php.");
		$d = $d."module.php";
		header("Location: $d");		
		}
		exit;

		/*Installation Ends Here*/
	}//Second Request Process Ends here
?>		
	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>NDOT Installation</title>
<link rel="stylesheet" href="style.css" type="text/css">
        <script src="../public/js/jquery.js" type="text/javascript"></script>

    <script src="../public/themes/default/js/jquery.validate.js" type="text/javascript"></script>
    
    <script src="../public/js/jquery.validate.js" type="text/javascript"></script>
    
<SCRIPT language=JavaScript type=text/javascript>
function checkrequired(which) {
var pass=true;
if (document.images) {
for (i=0;i<which.length;i++) {
var tempobj=which.elements[i];
if (tempobj.name.substring(0,8)=="title" || tempobj.name.substring(0,8)=="email" || tempobj.name.substring(0,8)=="name" || tempobj.name.substring(0,8)=="password" || tempobj.name.substring(0,8)=="tbname") {
if (((tempobj.type=="text"||tempobj.type=="text"||tempobj.type=="text"||tempobj.type=="text")&&
tempobj.value=='')||(tempobj.type.toString().charAt(0)=="s"&&
tempobj.selectedIndex==0)) {
pass=false;
break;
}
}
}
}
if (!pass) {
shortFieldName=tempobj.name.substring(8,30).toUpperCase();
alert("Please enter all required fields.");
return false;
}
else
return true;
}

$(document).ready(
  function()
  {
	 // show
	   $("#yourtable").click(function()
	    {
		$("#tblshow").show("slow");
	    });
		 // hide
	   $("#ndottable").click(function()
	    {
		$("#tblshow").hide("slow");
	    }); 
  });
</script>
</head>
<body>	
    <div class="instal_outer">
<div class="instal_logo"></div>
<div class="instal_inner">
<h1>Ndot Package Install </h1>
<?php 
$msg1=$_GET['msg1'];
if($msg1==1)
echo '<font color=red>Please enter the your Users tables correctly or the package will not work properly!</font>';
if($msg1==2)
echo '<font color=red>Users table does not exist!</font>';

?>
<script type="text/javascript">

$(document).ready(function(){$("#install").validate();});

</script>
<form action="" method="post" name="install_form" id="install" >

<table border="0" align="center" cellpadding="5" cellspacing="5"  class="table2">
<tr><td width="516">
<table width="506" border="0" >
<tr><td width="212">Your Application Name
<td width="10">
<td width="8">:</td>
<td width="268"><input type="text" name="title" value="Ndot Open Source" class="required" title="Enter your Application Name"/></td></tr>
<tr><td>Admin Email id<td><td>:</td><td><input type="text" name="email" class="required" title="Enter an e-mail" /></td></tr>
<tr><td>Admin Name<td><td>:</td><td><input type="text" name="name" class="required" title="Enter the admin name" /></td></tr>
<tr><td>Admin Password<td><td>:</td><td><input type="password" name="password" class="required" title="Enter the password"/></td></tr>
<tr><td>3rd Party Install<td><td>:</td><td><input type="radio" name="table" value="yourtbl" id="yourtable" title="Already User Table Exists"/>3rd party Install<input type="radio" name="table" value="ndottbl" id="ndottable" checked="true" title="Create Ndot's User Table"/>Fresh Install</td></tr>
</table>
<table border="0" id="tblshow" style="display:none;" width="506"><tr><td>
	
		  <fieldset  >
		    	<legend  align="right" style="background:red;">Please Enter Existing User Table Informations</legend>
			<table>
			<tr><td></td></tr>
			<tr><td>User Table Name<td><td>:</td><td><input type="text" name="tbname" title="Already Existing User Table Name"/></td></tr>
			<tr><td>User Id Field Name<td><td>:</td><td><input type="text" name="uidfield" title="Already Existing UserId Field Name"/></td></tr>
			<tr><td width="205">User Name Field Name<td><td>:</td><td><input type="text" name="uname" title="Already Existing UserName Field Name"/></td></tr>
			<tr><td>Password Field Name<td><td>:</td><td><input type="text" name="upass" title="Already Existing Password Field Name"/></td></tr>
			<tr><td>Email Field Name<td><td>:</td><td><input type="text" name="uemail" title="Already Existing Email Field Name"/></td></tr>
			<tr><td>User Status Field Name<td><td>:</td><td><input type="text" name="ustatus" title="Already Existing User Status Field Name"/> No:<input type="checkbox" name="chk1" value="1"></td></tr>
			<tr><td>User Type Field Name<td><td>:</td><td><input type="text" name="utype" title="Already Existing User Type Field Name"/> No:<input type="checkbox" name="chk2" value="1"></td></tr>
			</table>
		   </fieldset>
		   <fieldset>
		    	<legend  align="right" style="background:red;">Please Your Url Informations</legend>
			<table>
			<tr><td>Login Url<td><td>:</td><td><input type="text" name="liurl" title="Your Login URL"/></td></tr>
			<tr><td>Logout Url<td><td>:</td><td><input type="text" name="lourl" title="Your Logout URL"/></td></tr>
			<tr><td width="205">Regsiter Url<td><td>:</td><td><input type="text" name="regurl" title="Your Register URL"/></td></tr>
			</table>
		  </fieldset>
	</table>
<table width="420" border="0">
<tr><td width="225" align="right"><input name="" type="reset" value="" class="reset"/><td width="13">
<td width="45"></td>
<td width="119"><input name="" type="submit" value="" class="next"/></td></tr>
</table>
</td>
  </table>
</td></tr></table>

</div>
    <div class="instal_footer">Copyright &copy;2009 ndot.in.</div>
    </div>
</body>
</html>
