<script src="<?php echo $this->docroot;?>public/js/highlight.js" type="text/javascript"></script>
<!-- contents start -->


<?php
						
if (count($this->result)!= 0)
{
      //show the counts
                echo UI::count_(count($this->result));
      
        
	foreach($this->result as $row)
	{
				 
 ?>             <script>
		  /* for highlighting search */
			  $(function () {
			$(".runnable")
				.attr({ title: "Click to run this script" })
				.css({ cursor: "pointer"})
				.click(function () {
					// here be eval!
					eval($(this).text());
				});

			$('div p').highlight('<?php if(isset($_GET["search_text"]))echo $this->value;?>'); 
			$('div p').highlight('<?php if(isset($_GET["search_value"]))echo $_GET["search_value"];?>');
		});
			 </script>

	<div class="span-19 pl-10 border_bottom mb-10 pb-10">
     <div class="span-1a fl">
	 <?php 
	Nauth::getPhoto($row->author_id,$row->name);
	?>

	</div>

    <div class="span-17 ml-10">
    <p class="span-17">
    <a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>" title="<?php echo $row->topic; ?>" class="font13 text_bold">
    <?php echo $row->topic; ?></a> <br></p>
	
   <div class="span-17">
    <ul class="inlinemenu">
        <li class="color999"><?php Nauth::print_name($row->author_id,$row->name); ?> </li>
	<li ><span class="quiet">Last Active</span> <span><?php echo common::getdatediff($row->lpost);?></span></li>
	<li class="color999"><span>in</span>
	<a href="<?php echo $this->docroot ;?>forum/search/?id=<?php  echo $row->category_id; ?>" title="<?php  echo $row->forum_category; ?>"><?php  echo $row->forum_category; ?></a>
	

	<li class="color999">
	<a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>" title="Comments"> Replies (<?php echo $row->posts;?>)</a>
	</li>
        <li class="color999"><a href="<?php echo $this->docroot;?>forum/updatehit/<?php echo url::title($row->topic);?>_<?php echo $row->topic_id; ?>" >Views (<?php echo $row->hit;?>)</a></li>
	
	</ul>
	</div>

	

	</div>
	</div>

<?php } ?>
<?php 
if(count($this->cout) >15) {
echo $this->template->pagination;
}
?>

<?php
}
else
{
        if($_GET)
        {
                echo UI::noresults_();
        }
        else
        {
                if($this->uri->last_segment() !="advanced")
                {
                        echo UI::nodata_();
                }
        }
 }
?>




