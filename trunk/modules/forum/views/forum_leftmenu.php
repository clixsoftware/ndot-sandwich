<?php 
/**
 * Defines the forum left menu
 *
 * @package    Core
 * @author     Saranraj
 * @copyright  (c) 2010 Ndot.in
 */
?>

<div class="left_menu">
<div class="left_box">Discussions</div>
<ul class="discussion_lefmenu">
<li>
 <a href="<?php echo $this->docroot;?>forum/" title="Recent Discussions" class="d_discussions">Discussions</a></li>

<li> 
<a href="<?php echo $this->docroot;?>forum/popular" title="Popular Discussions" class="d_populardiscussions">Popular</a></li>
<li> 
<a href="<?php echo $this->docroot;?>forum/myforums" title="My Discussions" class="d_mydiscussions">My Discussions</a></li>
<li> 
<a href="<?php echo $this->docroot;?>forum/category" title="Categories" class="d_categories">Categories</a></li>
<li> 
<a href="<?php echo $this->docroot;?>forum/add" title="New Discussion" class="d_newdiscussion">New Discussion</a></li>
<li> 
<a href="<?php echo $this->docroot;?>forum/advanced" title="Search Discussions" class="d_searchdiscussion">Search</a></li>
</ul>
</div>
