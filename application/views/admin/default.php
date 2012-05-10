<div class="admin-style">
	<div class="grid_8 white-bg-round min-height-200">
		<h2 class="add-h2">TODO Lists</h2>
		<ul style="">
			<?php for($i=1; $i<=4; $i++): ?>
				<li id="item_<?php echo $i;?>"><input type="checkbox" onclick="check_this('<?php echo $i;?>')" id="check_<?php echo $i;?>" name="check_<?php echo $i;?>"/><label for="check_<?php echo $i;?>"><?php echo $i.$i.$i.$i.$i;?></label></li>
			<?php endfor; ?>
		</ul>
	</div>
	<div class="grid_4"></div>
	<div class="clearfix"></div>
</div>
