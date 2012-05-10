<div class="notification-style">
	<div class="grid_8">
		<div class="white-bg-round min-height-200">
			<h2 class="add-h2"><?php echo $title;?></h2>
			<?php if($unread_nums == 0): ?>
			<p style="margin:10px;">你没有未读的通知</p>
			<?php else: ?>
			<ul style="list-style: square; margin: 10px;">
			<?php foreach($notifications as $item): ?>
				<li>
					<?php echo $this->notifications_model->translate($item); ?>
					<?php $this->notifications_model->mark_read($item->id); ?>
				</li>	
			<?php endforeach; ?>
			</ul>
			
			<?php endif; ?>
		</div>
	</div>
	<div class="grid_4">
		
	</div>
	<div class="clearfix"></div>
</div>