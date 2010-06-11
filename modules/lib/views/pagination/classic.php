<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Classic pagination style
 * 
 * @preview  ‹ First  < 1 2 3 >  Last ›
 */
?>

<p class="pagination">

	<?php if ($first_page): ?>
		<!--<a href="<?php echo str_replace('{page}', 1, $url) ?>">&lsaquo;&nbsp;<?php echo Kohana::lang('pagination.first') ?></a>-->
		<!--<a href="<?php echo str_replace('{page}', 1, $url) ?>"><img src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme; ?>/images/back_deactive.gif" /></a>		-->
	<?php endif ?>

	<?php if ($previous_page): ?>
		<a href="<?php echo str_replace('{page}', $previous_page, $url) ?>" title="Previous"><img src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme; ?>/images/back.gif" /></a>
	<?php endif ?>

&nbsp;
	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<!--<strong><?php echo $i ?></strong>-->
		<?php else: ?>
		<!--	<a href="<?php echo str_replace('{page}', $i, $url) ?>"><?php echo $i ?></a>-->
		<?php endif ?>

	<?php endfor ?>


	<?php if ($next_page): ?>
		<a href="<?php echo str_replace('{page}', $next_page, $url) ?>" title="Next"><img src="<?php echo $this->docroot; ?>public/themes/<?php echo $this->get_theme; ?>/images/more.gif" /></a>
	<?php endif ?>

	<?php if ($last_page): ?>
		<!--<a href="<?php echo str_replace('{page}', $last_page, $url) ?>"><?php echo Kohana::lang('pagination.last') ?>&nbsp;&rsaquo;</a>-->
	<?php endif ?>

</p>
