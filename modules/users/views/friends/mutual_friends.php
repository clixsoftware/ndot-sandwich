 

<?php
if(!empty($this->template->profile_info))
{
	if($this->template->profile_info["mysql_fetch_array"]->id!=$this->userid)
	{
		?>
		<div class="span-5-5"  >
		<?php
		if(!empty($this->template->mutual_friends) && $this->template->mutual_friends->count()>0 )
		{  ?>
			
			<h3 class="span-5-5 sub-heading">Mutual Friends&nbsp;<?php echo '('.count($this->template->mutual_friends).')'; ?></h3>
			
			
			
			<?php
			foreach($this->template->mutual_friends as $mut_friends)
			{
			?>	
			    <div class="span-1-5 fl text-align"> 
			    <?php echo Nauth::getPhotoName($mut_friends->id,$mut_friends->name);?>
			    </div>		
			<?php
			}
			?>
			
			
		<?php	
		}?>
		</div>
<?php
	}	
}
?>

