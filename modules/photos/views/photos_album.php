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
          <form name="album_form" action="<?php echo $this->docroot;?>photos/photos/create_album" method="post">
            <table border="0" cellpadding="2" cellspacing="5">
              <tr>
                <td valign="top">Title</td>
                <td><input type="text" name="title" title="Enter the Title" /></td>
              </tr>
              <tr>
                <td valign="top">Description</td>
                <td><textarea name="description" ></textarea></td>
              </tr>
              <tr>
                <td>Shared with</td>
                <td><select name="share" title="Select the Photo Settings">
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
