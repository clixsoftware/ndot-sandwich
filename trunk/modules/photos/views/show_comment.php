<?php
  if (count($this->template->show_comment) > 0)
  {
      foreach ($this->template->show_comment as $row)
      {
          echo '<div class="comment_job">' . $row->comments . '
 <div class="ask_by">
    <ul>
      <li>Posted by:&nbsp;<a href="<?php echo $this->docroot;?>career/bitalumni/display_alumni/?id=' . $row->user_id . '">' . $row->name . '</a>&nbsp;|</li>';
          if (($row->DATE) == 0)
          {
              echo '<li>on&nbsp;<b class="ask_tim">today</b></li>';
          }
          elseif (($row->DATE) == 1)
          {
              echo '<li>on&nbsp;<b class="ask_tim">' . $row->DATE . '&nbsp;day ago</b></li>';
          }
          else
          {
              echo '<li>on&nbsp;<b class="ask_tim">' . $row->DATE . '&nbsp;days ago</b></li>';
          }
          echo ' </ul></div><br></div>';
      }
  }
  else
  {
      echo '<div class="no_data" style="border:0px solid red;width:">No comment</div>';
  }
?>