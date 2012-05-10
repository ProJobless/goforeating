<div class="page-style">
	<div class="grid_8 white-bg-round min-height-200">
		<h2 class="add-h2">反馈</h2>
		<?php echo form_open('page/feedback');?>
			<table>
				<?php if(!$this->ion_auth->logged_in()): ?>
				<input type="hidden" name="user-type" value="guest" />
				<tr>
					<td class="td-title">联系邮箱</td>
					<td><input type="email" class="input-text" name="email" />
					<span class="grey">我们将会回复到该地址</span>
					</td>
				</tr>
				<?php else: ?>
				<input type="hidden" name="user-type" value="<?php echo $this->ion_auth->get_user()->id;?>" />
				<?php endif; ?>
				
				<tr>
					<td class="td-title">类型</td>
					<td>
						<?php echo form_dropdown('type', $options, 'A'); ?>
					</td>
				</tr>
				<tr>
					<td class="td-title">说点什么</td>
					<td>
						<textarea name="content" id="content" cols="50" rows="10" class="input-textarea"></textarea>
					</td>
				</tr>
				<tr>
					<td class="td-title"></td>
					<td><input type="submit" name="feedback-submit" value="OK" class="input-submit" /></td>
				</tr>
			</table>
		<?php echo form_close(); ?>
	</div>
	<div class="grid_4">
		
	</div>
	<div class="clearfix"></div>
</div>