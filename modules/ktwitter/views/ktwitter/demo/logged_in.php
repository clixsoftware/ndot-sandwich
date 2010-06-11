<?php
$this->twitter_username=$twitter->user->username;
?>


Hello <?php echo $twitter->user->username;?> :: You are now logged in using Twitter Oauth!
<br /><?php echo html::anchor('ktwitter/demo/logout','Logout');?>
<br /><?php echo html::anchor('ktwitter/demo/status','Update Status (Example)');?>
<h3>Rate Limits</h3>
<?php echo $limits->remaining_hits;?> requests remaining this hr
<h3>Your Timeline</h3>
Retrieved the last <?php echo count($timeline);?> status updates:<br />
<ul>
    <?php foreach($timeline as $status): ?>
        <li><?php echo $status['text'];?></li>
    <?php endforeach; ?>
	<?php /*foreach($friendinvite as $inviteid): ?>
        <li><?php echo $inviteid['id'];?></li>
    <?php endforeach; */?>
</ul>
<!---->
