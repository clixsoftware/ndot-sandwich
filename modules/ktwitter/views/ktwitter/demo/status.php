This page lets you update your status on Twitter!
<br />
<br />
<?php echo form::open();?>
<?php echo form::input('status');?>&nbsp;&nbsp;&nbsp;
<?php echo form::submit('set','Set Status');?>
<?php echo form::close();?>

<?php if($response): ?>
    <br /><br />Your status was successfully updated to: <?=$response;?>
<?php endif;?>
<h3>Your Timeline</h3>
<ul>
    <?php foreach($timeline as $status): ?>
        <li><?php echo $status['text'];?></li>
    <?php endforeach; ?>
</ul>