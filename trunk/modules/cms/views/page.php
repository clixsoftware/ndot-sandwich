<?php 
if($this->input->get("page") == "Contact Us")
{ ?>

        <script>
	$(document).ready(function()
	{
		//for create form validation
		$("#contactus").validate();
	});
	</script>
<?php 
}
?>

<?php 
//get the page content
if(count($this->page))
{
        foreach($this->page as $page)
        {
        ?>
              <div class="margin_left3 padding3">
              <?php   echo nl2br(htmlspecialchars_decode($page->cms_desc)); ?>
              </div>
        <?php }
}
else
{
        echo "No Description Available";
}
?>
