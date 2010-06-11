
<?php 
        $session=Session::instance();
       $this->usertype = $session->get('usertype');
	$i=1;
 
    if(count($this->template->news_category)>0)
	{
	foreach ($this->template->news_category as $row )
   { ?>
	
   <div class="right_inner" style="float:left; margin-right:0px;   width:684px; overflow:hidden; ">
   <?php
   if($i%2==1) {
?>
 <div class="message_entry"  style="float:left; margin-right:0px;   width:684px;" >
<?php }else
{  
echo '<div class="message_entry2" tyle="float:left; margin-right:0px;   width:684px;" >';
}
?><br />
	  <h3 class="con_title"><a href="<?php echo $this->docroot;?>news/view/?nid=<?php echo $row->news_id;?>"><?php  echo  $row->news_title; ?></a></h3>
      <div class="m_entrybody" style="width:676px;">	  
       <?php $desc=html_entity_decode($row->news_desc); $desc1=strip_tags($desc); echo substr($desc1,0,180).'. . .'; ?>
	  
	   
	   </div>
	  <div class="post"><b>Posted -</b> <b class="p_nam" style="color:#C4B866;"><?php 
if($row->dat==0) 
{ 
echo "today"; 
}
elseif($row->dat==1)
{
echo $row->dat." day ago..";
}
else
{
echo $row->dat." days ago..";
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;";

?></b><b>Category -</b>
	  <b ><a href="<?php echo $this->docroot;?>news/category/?cate=<?php echo $row->category_id;?>"><?php echo $row->category_name;?></a> Comments (<?php echo $row->comment_count;?>)</b>
  </div>
 </div>  </div>
 <?php
$i++; }
 ?> 
 <?php }else{ ?>
 
 <div style="padding:5px;">No news Found</div>
 
 <?php } ?>
<?php
if($this->total>10)
{
 ?>
 
	<div style="font-size:12px; color:#0000A0; width:200px; margin-right:10px;	 border:0px solid red; float:right;  margin-bottom:10px; " > <?php  echo  $this->template->pagination; ?> </div>
 <?php } ?>
 </div>

















