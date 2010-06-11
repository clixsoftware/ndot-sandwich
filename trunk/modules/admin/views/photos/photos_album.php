<script src="<?php echo $this->docroot;?>/public/themes/<?php echo $this->get_theme;?>/js/jquery.validate.js" type="text/javascript"></script>
<script>
$(document).ready(function()
{
$("#addcat").validate();
});
</script>
<div class="content">
  <div class="inner_box">
    <div class="inner_top">
      <h4 class="inner_head">Photos</h4>
    </div>
    <div class="inner_cen">
      <div class="alumni_offi_inner">
        <?php
  $session = Session::instance();
  $userid = $session->get('userid');
?>
        <div class="main_content1"    >
          <form name="addcat" action="<?php echo $this->docroot;?>photos/photos/create_album" method="post" id="addcat">
            <table border="0" cellpadding="2" cellspacing="5">
              <tr>
                <td>Title</td>
                <td><input type="text" name="title" class="required"></td>
              </tr>
              <tr>
                <td valign="top">Description</td>
                <td><textarea name="description" class="required"></textarea></td>
              </tr>
              <tr>
                <td>Shared with</td>
                <td><select name="share">
                    <option value="0">select</option>
                    <option value="0">Everyone</option>
                    <option value="1">Only my friends</option>
                  </select></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="Create">
                  &nbsp;
                  <input type="button" value="Cancel"></td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
    <div class="inner_bottom"> </div>
  </div>
</div>
