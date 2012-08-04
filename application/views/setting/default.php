<div class="setting-style">
	<div class="grid_8">
		<div class="white-bg-round min-height-200">
			<h2 class="add-h2 gear">个人资料设置</h2>
			<?php echo form_open_multipart('setting/index');?>
			<table>
				<tr>
					<td class="td-title">姓名 <span class="required">*</span></td>
					<td>
					  <input name="realname" type="text" class="input-text" value="<?php echo set_value('realname', $user->name);?>" autofocus/>
					  <span class="required"><?php echo form_error('realname'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title">手机</td>
					<td>
					  <input name="phone" type="text" class="input-text" value="<?php echo set_value('phone', $user->phone);?>" />
					  <span class="grey">只对跟你一起吃饭的人公开</span>
					  <span class="required"><?php echo form_error('phone'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title">照片</td>
					<td>
						<input type="file" name="userfile" />
					</td>
				</tr>
				<tr>
					<td class="td-title">自述</td>
					<td>
					  <textarea name="bio" id="bio" cols="40" class="input-textarea" rows="10"><?php echo set_value('bio', $user->bio);?></textarea>
					  <span class="required"><?php echo form_error('bio'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title"></td>
					<td><input type="submit" class="input-submit" value="确认更新" name="setting-submit" /></td>
				</tr>
			</table>
			<?php echo form_close();?>
		</div>
	</div>
	
	<div class="grid_4">
		<div class="white-bg-round" style="min-height: 150px;">
			<h3 class="add-h3">我的照片</h3>
			<div style="text-align: center;">
				<img style="margin: 10px;" src="/assets/user_photos/<?php echo str_replace('.', '_100_thumb.', $user->photo);?>" alt="" />
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>