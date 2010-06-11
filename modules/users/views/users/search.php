<?php

if(count($this->template->search) > 0)
{

echo UI::count_($this->user_search_count);
    foreach($this->template->search as $search)
    {

?>
      <script>
		  /* for highlighting search */
			  $(function () {
			$(".runnable")
				.attr({ title: "Click to run this script" })
				.css({ cursor: "pointer"})
				.click(function () {
					// here be eval!
					eval($(this).text());
				});

			$('div p').highlight('<?php if(isset($_GET["search_value"])) echo $_GET["search_value"];?>');
		});
			 </script>
<div style="padding:10px;" class="span-21" ><p>
  <div class="span-2 text-align">
    <?php Nauth::getPhoto($search->id,$search->name); //get the user photo ?>
  </div>
  <div class="span-7"> <?php echo Nauth::print_name($search->id, $search->name); ?> <br/>
    <span class="margin_left3">
    <?php if(!empty($search->city)) { echo $search->city; } ?>
    <?php if(!empty($search->cdesc)) { echo ", ".$search->cdesc; } ?>
    </span> </div>
  <div class="span-8">
    <?php
        if($search->fid=='' && $search->zid=='')
        { ?>
    <li><a href="<?php echo $this->docroot; ?>profile/add_as_friend/?uid=<?php echo $search->id;?>" id="friend<?php echo $search->id;?>" style="cursor:pointer;">Add as a Friend</a></li>
    <?php  
		}
		
      ?>
  </div> </p>
</div>
<hr class="span-21"/>
<?php
    }echo $this->template->pagination;
    ?>
<?php
}
else
{
	echo UI::noresults_("");
}
?>
