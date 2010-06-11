<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Array helper class.
 *
 * $Id: arr.php 4346 2009-05-11 17:08:15Z zombor $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class common_Core {

	/**
	 * Return a callback array from a string, eg: limit[10,20] would become
	 * array('limit', array('10', '20'))
	 *
	 * @param   string  callback string
	 * @return  array
	 */
	  public function __construct()
	 {
		
		parent::__construct();
		
		//user response messages
		$mes=Kohana::config('users_config.session_message');
		$this->add_comment = $mes["add_comment"];
		$this->delete_comment = $mes["delete_comment"];
		$this->data=new Inbox_Data_Model();
        	
	 }
	 
	 //Get the time 
	public static  function getdatediff($dt)
	{
	    
            if( $diff=common::get_time_difference($dt, time()) ) // <-- HERE!
            {
              if($diff["days"] > 0){
                return $diff["days"] . " days ago ";
              }
              else{
                if($diff["hours"]>0){
                    if($diff["hours"] > 10){
                        return $diff["hours"]." hours ago ";
                    }else{
                        return $diff["hours"]." hours ".$diff["minutes"]. " minutes ago";
                    }
                }
                else{
                    if($diff["minutes"]==0){
                        return " just now ";
                    }else{
                        return $diff["minutes"]." minutes ago ";
                    }
                }
              }
            }

        }
        
        public static function get_time_difference( $start, $end )
        {
            $uts['start']      =    strtotime( $start );
            $uts['end']        =    $end ;
            if( $uts['start']!==-1 && $uts['end']!==-1 )
            {
                if( $uts['end'] >= $uts['start'] )
                {
                    $diff    =    $uts['end'] - $uts['start'];
                    if( $days=intval((floor($diff/86400))) )
                        $diff = $diff % 86400;
                    if( $hours=intval((floor($diff/3600))) )
                        $diff = $diff % 3600;
                    if( $minutes=intval((floor($diff/60))) )
                        $diff = $diff % 60;
                    $diff    =    intval( $diff );           
                    return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
                }
                else
                {
                    //trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
                }
            }
            else
                 {
                //trigger_error( "Invalid date/time data detected", E_USER_WARNING );
            }
            return( false );
        }
                
    public function change_time($time) 
    {
        $time = strtotime($time);
        $c_time = time() - $time;
        if ($c_time < 60) {
            return '0 minute ago.';
        } else if ($c_time < 120) {
            return '1 minute ago.';
        } else if ($c_time < (45 * 60)) {
            return floor($c_time / 60) . ' minutes ago.';
        } else if ($c_time < (90 * 60)) {
            return '1 hour ago.';
        } else if ($c_time < (24 * 60 * 60)) {
            return floor($c_time / 3600) . ' hours ago.';
        } else if ($c_time < (48 * 60 * 60)) {
            return '1 day ago.';
        } else {
            return floor($c_time / 86400) . ' days ago.';
        }
    }
    
    public function check_privacy($user_id='')
    {
    $this->pvy = $this->model->get_privacy($user_id);
    return $this->pvy["mysql_fetch_array"]->updates;
        
    }


   public function insert_mail($userid = "", $toid = "", $subject = "",$msg_body = "",$objecttype=-1)
    {
	 $this->data=new Inbox_Data_Model();
   	 $mailid = $this->data->insert_mail($userid,$subject,$msg_body,$objecttype);
	 $this->data->sent_mail($userid,$mailid,$toid);	
	 return 1;
   // return $this->pvy["mysql_fetch_array"]->updates;
        
    }

    public function insert_invitations($userid = "", $name = "", $email = "")
    {
	 $this->data=new Inbox_Data_Model();
   	 $mailid = $this->data->insert_invitations($userid,$name,$email);
	return 1;
   // return $this->pvy["mysql_fetch_array"]->updates;
        
    }

    public function get_video($video_id='')
    {
        $this->video_mod = new Video_Model();
    $this->video_image = $this->video_mod->get_video($video_id);
            if(count($this->video_image))
            {
            return $this->video_image["mysql_fetch_array"]->thumb_url;
            }
            else
            {
            return 0;
            }
        
    } 
    
    //delete the update
    public function delete_update($typeid = '', $actionid = '' , $post_id = '' )
    {
    		$this->model=new update_model_Model();
    		$this->delete_updates = $this->model->delete_upd($typeid,$actionid,$post_id);
    }
    //get the album photo 
    public function get_album_photo($album_id = '')
    {
		 $this->model_photo=new Photos_Model();
    		 $this->photos = $this->model_photo->get_abmphoto($album_id);
    		 return $this->photos;
    }
    
    //post the comments to all modules like blog,news and clasifieds..
     public function post_comments($table_name='',$type_id='',$desc='',$type='')
     {
                 $this->comments = new Comments_Model();
		 $this->result = $this->comments->post_comments($table_name,$type_id,$desc,$this->userid,$type);
		 if($this->result)
		 {
		        Nauth::setMessage(1,$this->add_comment);
		 }
		
     }
      //delete commemnts
      public function delete_comment($table_name='',$type_id='',$comment_id='',$type='')
      {
	    $this->comments = new Comments_Model();
	    $this->delete = $this->comments->delete_comment($table_name,$type_id,$comment_id,$this->userid,$type);
	    if($this->delete)
	    {
	            Nauth::setMessage(1,"Comment has been deleted");
	    }
	    
	}
	
      //get the comments
      public function get_comments($table_name='',$type_id='')
      {   
      
                 $this->comments = new Comments_Model();
                 $this->template->comments=$this->comments->get_comments($table_name,$type_id);
		 $this->total=$this->comments->get_comments_count($table_name,$type_id);
		 
		 ?>
        <div class="span-19 ml-10 mt-10 fl " >
  
        <h3 class="color2899DD pl-10 mb-10 mt-10  fl"> Comments <?php if($this->total>0) { ?>(<?php echo $this->total;?>) <?php } ?></h3>
        <hr>
	<?php
	//start comments
	if(count($this->template->comments)>0) 
	{ ?>
	
	<?php 
	foreach($this->template->comments as $row)
	{
	?>
	
			 
	<div class="span-19a pl-10 clear fl border_bottom ">
        <div class="span-1a fl ">

	<?php Nauth::getPhoto($row->user_id,$row->name);  //get the user photo
	?>
	</div>

	<div class="span-17 ml-10 ">
        <p class="span-17 ml-10">
        <?php echo nl2br(htmlspecialchars_decode($row->comments));?>
	</p>
    
        <div class="span-17  pl-8">
        <ul class="inlinemenu">
        <li class="color999"><?php Nauth::print_name($row->user_id,$row->name); ?> </li>
        <li> <span class="quiet">Posted on</span> <?php echo common::getdatediff($row->DATE);?></li> 
    	
	<?php 
	if($this->author_id == $this->userid || $row->user_id == $this->userid || $this->usertype == -1)
	{
	?>
	<li class="color999"><a href="javascript:;" id="delete_<?php echo $row->comment_id;?>" title="Delete ">Delete</a></li>
	<?php } ?>
	</ul>
	</div>
           
           	<script>
                $(document).ready(function(){
                 $("#delete_<?php echo $row->comment_id;?>").click(function(){ $("#delete_form<?php echo $row->comment_id;?>").toggle("show") });
                 $("#close<?php echo $row->comment_id;?>").click( function(){  $("#delete_form<?php echo $row->comment_id;?>").hide("slow");  });
                 $("#cancell<?php echo $row->comment_id;?>").click( function(){  $("#delete_form<?php echo $row->comment_id;?>").hide("slow");  });
		         });
	         </script>
	 
	         <!-- for delete -->
		<div id="delete_form<?php echo $row->comment_id;?>" class="width400 delete_alert clear ml-10 mb-10">
		<h3 class="delete_alert_head">Delete Comment</h3>
		<span class="fr">
		<img src="/public/images/icons/delete.gif" alt="delete" id="close<?php echo $row->comment_id;?>"  >
		</span>
		<div class="clear fl">Are you sure want to delete this Comment? </div>
		<div class="clear fl mt-10" > 
	
		<?php  echo UI::btn_("button", "Delete", "Delete", "", "javascript:window.location='".$this->docroot.$this->module."/delete_comment/?cid=".$row->comment_id."&type_id=".$this->type_id."&url=".urlencode($_SERVER['REQUEST_URI'])."' ", "delete_blog","");?>
		<?php  echo UI::btn_("button", "Cancel", "Cancel", "", "", "cancell".$row->comment_id."","");?>
		
		</div>
		</div>
		
	</div>

		
	        
	</div>

	<?php
	} ?>

	
	<?php
	}
	else
	{ ?>
	
	      <div class="clear"> <?php   echo UI::nocomment_(); ?> </div>
	<?php }
	?>
<script>
$(document).ready(function(){
$('#post').validate();
});
</script>

  	<!-- Post the Comment -->
  	 <h3 class="color2899DD pl-10 mb-15 mt-10 clear fl">Post your comments</h3>
  	 
         <div class="span-19 pl-10">
         <form action="" name="post" id="post" method="post" class="out_f">
	<table border="0" cellpadding="5">
	 <input type="hidden" name="type_id" value="<?php echo $this->type_id;?>">
	 <input type="hidden" value="<?php echo $_SERVER['REQUEST_URI']; ?>" name="redirect_url">
         <tr><td><textarea name="desc"  id="description1"  cols="75" rows="3" class="required" onkeypress="return MaxLength(this,event);" title="Enter the Comment"></textarea></td></tr>
    	 <tr><td>
    	 <span id="limits_count" class="quiet">Max 140 characters</span>
    	 <?php  echo UI::btn_("Submit", "create_blog", "Post", "", "", "new_q","create_blog");?>
         <?php  //echo UI::btn_("button", "Cancel", "Cancel", "", "javascript:window.location='".$this->docroot."blog' ", "cancel","");?>

    	 </td></tr>
         </table>
         </form>
         </div>
         
		 <?php 
      }
      /* Function is to check for friend */
      public function is_friend($id)
      {
    		$this->model=new update_model_Model();
    		return $this->model->is_friend($id);
      }
      
      public function show_ratings($url='',$type = '',$type_id = '')
      {
        $this->ratings = new Ratings_Model();
        
                      
                         //get the rating values from user
                         if($this->input->get('url'))
			 {
			
			                $url = $this->input->get('url');
		                        $type = $this->input->get('type');
		                        $type_id = $this->input->get('type_id');
		                        $rating = $this->input->get('rating');
		                        $ipadd = $_SERVER['REMOTE_ADDR']; 
		                        
		                        if($url != '' && $type != '' && $type_id != '')
		                        {
		                                
		                                $this->insert_rate = $this->ratings->insert_rating($url,$type,$type_id,$ipadd,$rating);
		                                if($this->insert_rate == 1)
		                                {
		                                        $this->session->set('Msg','Your Rating has been Successfully Added');
		                                        url::redirect($url);
		                                }
		                                elseif($this->insert_rate == -1)
		                                {
		                                        $this->session->set('Emsg','Your Rating Already Exist.');
		                                        url::redirect($url);
		                                }
		                        }
		                        else
		                        {
		                                $this->session->set('Emsg','Not allowed to Rate. Please try Later');
		                                url::redirect($url);
		                        }
			 }
			 
			 
            
                $this->get_ratings = $this->ratings->ratings($url,$type,$type_id);
                if($this->get_ratings->count() > 0)
                {
                        $rateval = 0;
                        $count = $this->get_ratings->count();
                        foreach($this->get_ratings as $rate)
                        {
                                $a = $rate->rate_val;
                                 $rateval += $a;
                        }
                       
                        $rateval = $rateval / $count; 
                }
                else
                {
                        $rateval = '';
                        $count = '';
                }
                ?>
                
                <table width=100% cellpadding=0 cellspacing=0 border=0 >
   <tr align=left>
      <td>
        <form name="rate" id="rate" method=get action="">
             <b>Rated as: </b>
             <?php for($i=1;$i<=5;$i++)
                     {
                   	if($rateval>=1)
                	{
                	?>
		          <img  name="i<?php echo $i; ?>" class=star  onclick="setrate(<?php echo $i; ?>)" src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme;?>/images/star2.gif">
                           <?php
                           $rateval=$rateval-1;
                           
	                }
	                else if($rateval>=0.5)
	                {
 		          
 		           ?>
		          <img  name="i<?php echo $i; ?>" class=star  onclick="setrate(<?php echo $i; ?>)" src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme;?>/images/star3.gif">
                           <?php
		           $rateval=$rateval-1;
	                }
 	                else if ($rateval<0.5 && $rateval>0)
	                {
		           ?>
		          <img  name="i<?php echo $i; ?>" class=star  onclick="setrate(<?php echo $i; ?>)" src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme;?>/images/star1.gif">
                           <?php
		           
	                }
	                else if($rateval<=0)
	                {
		           ?>
		          <img  name="i<?php echo $i; ?>" class=star  onclick="setrate(<?php echo $i; ?>)" src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme;?>/images/star1.gif">
                           <?php
		           
	                }
                    }	
           ?>
           <font color='#333'>
	<?php 
	 echo "[ $count &nbsp; <span style='font-size: 12px;'>votes</span> ]";
	?>
	</font>
     </td>
   </tr>
     <style>
       .star{cursor:pointer; }

     </style>
     <Script language=javascript>
      function selstar(val)
      {
	for(var x=1;x<=val;x++)
	{
		document['i'+x].src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme;?>/images/star2.gif";
	}
	
      }
      function remstar(val)
      {
	for(var x=1;x<=val;x++)
	{
		document['i'+x].src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme;?>/images/star1.gif";
	}
      }

      function setrate(val)
      {
	var a = document.getElementById('rating').value=val;
	document.getElementById('rate').submit()
      }
     </script>

     <input type=hidden name="rating" id="rating">
            <input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
            <input type="hidden" name="type_id" id="type_id" value="<?php echo $type_id; ?>" />
            <input type="hidden" name="url" id="url" value="<?php echo $url; ?>" />
            </form>
</table>
<?php
      }
                
} 


// End Common
