<div class="add-style">
	<div class="grid_8">
		<div class="add-left white-bg-round min-height-200">
			<h2 class="add-h2 gift">一起去吃饭吧</h2>
			<?php echo form_open('meal/add');?>
			<table>
				<tr>
					<td class="td-title">去哪吃 <span class="required">*</span></td>
					<td>
					  <input name="location" type="text" class="input-text" value="<?php echo set_value('location');?>" autofocus/><span class="required"><?php echo form_error('location'); ?></span>
					</td>
				</tr>
				<tr>
					<td class="td-title">截止时间</td>
					<td><input name="deadline" type="date" class="input-text" style="width: 90px;" value="<?php echo set_value('deadline', date("Y-m-d", strtotime("+14 day")));?>" />
					<span class="required"><?php echo form_error('deadline'); ?></span>
					</td>
				</tr>
				<tr>
					<td class="td-title">人数</td>
					<td><input type="number" name="num_people" step="1" min="1" max="20" value="3" class="input-text" style="width: 30px;" value="<?php echo set_value('num_people');?>"/>
					<span class="required"><?php echo form_error('num_people'); ?></span>
					</td>
				</tr>
				<tr>
					<td class="td-title">人均</td>
					<td><input type="text" class="input-text" name="avg_price" value="<?php echo set_value('avg_price');?>" />
					<span class="required"><?php echo form_error('avg_price'); ?></span>
					</td>
				</tr>
				<tr>
					<td class="td-title">地址 <span class="required">*</span></td>
					<td><input name="addr" type="text" class="input-text" onblur="searchPlace(this.value)" value="<?php echo set_value('addr');?>" style="width: 300px;"/>
					<span class="required"><?php echo form_error('addr'); ?></span>
					</td>
				</tr>
				<tr>
				  <td class="td-title">标签</td>
				  <td><input type="text" name="tags" id="tags" value="" /></td>
				</tr>
				<tr>
				  <td class="td-title">权限</td>
				  <td>
					<select name="auth" id="auth">
					  <?php if(isset($_POST['auth'])): ?>
					  <?php if($_POST['auth'] == 0): ?>
						<option value="0" selected="selected">全体</option>
						<option value="1">仅好友可见</option>
					  <?php else: ?>
						<option value="0">全体</option>
						<option value="1" selected="selected">仅好友可见</option>
					  <?php endif; ?>
					  <?php else: ?>
						<option value="0">全体</option>
						<option value="1">仅好友可见</option>
					  <?php endif; ?>
					</select>
				  </td>
				</tr>
				<tr>
					<td class="td-title">说明</td>
					<td><textarea name="desc" id="desc" cols="50" rows="10" class="input-textarea" ><?php echo set_value('desc');?></textarea>
					<span class="required"><?php echo form_error('desc'); ?></span>
					</td>
				</tr>
				<tr>
					<td class="td-title"></td>
					<td><input type="submit" class="input-submit" value="确认" name="meal-submit" /></td>
				</tr>
			</table>
			<?php echo form_close();?>
		</div>
	</div>
	<div class="grid_4">
		<div class="add-right white-bg-round" style="height: 250px;">
			<h2 class="add-h2 map">地图</h2>
			<div id="map_canvas"></div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
