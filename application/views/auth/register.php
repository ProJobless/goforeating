<div class="setting-style">
	<div class="grid_8">
		<div class="white-bg-round min-height-200">
			<h2 class="add-h2">我们在等你吃饭</h2>
			<?php echo form_open('auth/register');?>
			<table>
				<tr>
					<td class="td-title">用户名 <span class="required">*</span></td>
					<td>
					  <input name="username" type="text" class="input-text" value="<?php echo set_value('username');?>" autofocus/><span class="required"><?php echo form_error('username'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title">邮箱 <span class="required">*</span></td>
					<td>
					  <input name="email" type="email" class="input-text" value="<?php echo set_value('email');?>" /><span class="required"><?php echo form_error('email'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title">姓名 <span class="required">*</span></td>
					<td>
					  <input name="realname" type="text" class="input-text" value="<?php echo set_value('realname');?>" />
					  <span class="required"><?php echo form_error('realname'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title">密码 <span class="required">*</span></td>
					<td>
						<input type="password" name="password" id="password" class="input-text" />
						<span class="required"><?php echo form_error('password'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title">邀请码 <span class="required">*</span></td>
					<td>
						<input type="text" class="input-text" name="code" value="<?php echo set_value('code');if(isset($_GET['code'])) echo $_GET['code']; ?>" /><span class="grey">&nbsp;内测期, 仅对北邮及周边高校学生开放</span>
						<span class="required"><?php echo form_error('code'); ?></span>
					</td>
				</tr>
				
				<tr>
					<td class="td-title"></td>
					<td style="height: 30px; line-height: 30px;">
						注册即表示我已同意<a href="/page/tos">服务条款</a>
					</td>
				</tr>
				
				<tr>
					<td class="td-title"></td>
					<td><input type="submit" class="input-submit" value="加入!" name="register-submit" /></td>
				</tr>
			</table>
			<?php echo form_close();?>
		</div>
	</div>
	
	<div class="grid_4">
	</div>
	<div class="clearfix"></div>
</div>