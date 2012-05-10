<div class="page-style">
	<div class="grid_8 white-bg-round min-height-200">
		<h2 class="add-h2"><?php echo $title;?></h2>
		<?php if($items): ?>
		<ul class="updates">
			<?php foreach($items as $item): ?>
			<li>
				<span class="date"><?php echo date('Y-m-d', $item->ctime) ?></span><?php echo $item->value;?>
			</li>
			<?php endforeach;?>
		</ul>
		<?php endif; ?>
	</div>
	
	<?php if($this->ion_auth->logged_in()): ?>
	<?php $admin = array(1,3,4,5); ?>
	<?php if(in_array($this->ion_auth->get_user()->id, $admin)): ?>
	<div class="grid_8 white-bg-round min-height-200">
	<h2 class="add-h2">添加更新</h2>
	<p>
		<form action="/admin/chungechunyemen" method="post" style="margin:0px auto; padding: 2px 20px;">
			<textarea name="update" id="update" cols="60" rows="10" class="input-textarea"></textarea>
			<input type="submit" value="添加更新" class="input-submit-blue" />
		</form>
	</p>
	<br />
	</div>
	
	<?php endif; ?>
	<?php endif; ?>
	
	<div class="grid_4">
		
	</div>
	<div class="clearfix"></div>
</div>