<div class='login-style'>
	<div class="grid_8 white-bg-round">
		<?php echo form_open("auth/login");?>
		<table>
			<tr style="line-height: 30px;">
				<td class="td-title">邮箱</td>
				<td><input type="email" class="input-text" name="email" /></td>
			</tr>
			
			<tr style="line-height: 30px;">
				<td class="td-title">密码</td>
				<td><input type="password" class="input-text" name="password" /></td>
			</tr>
			
			<tr style="line-height: 30px;">
				<td class="td-title"></td>
				<td>
					<label for="remember">下次直接登录:</label>
					<input type="checkbox" name="remember" id="remember" value="1" />
				</td>
			</tr>
			
			<tr style="line-height: 30px;">
				<td class="td-title"></td>
				<td>
					<input type="submit" class="input-submit" value="登录" />
				</td>
			</tr>
			
		</table>
      
    <?php echo form_close();?>

	</div>
	<div class="clearfix"></div>
</div>
