<div class="welcome-style">
	<div class="grid_4 welcome-left">
		<div class="white-bg-round">
			<h2 class="common-h2">欢迎你</h2>
			<div class="welcome-login">
				<?php echo form_open('welcome/login');?>
					<table>
						<tr>
							<td class="td-title"><label for="email">邮箱</label></td>
							<td><input type="email" class="input-text" name="email" id="email" /></td>
						</tr>
						<tr>
							<td class="td-title"><label for="password">密码</label></td>
							<td><input type="password" class="input-text" id="password" name="password" /></td>
						</tr>
						
						<tr>
							<td class="td-title"></td>
							<td><label for="remember">保持登录</label><input type="checkbox" class="input-text" id="remember" name="remember" checked="checked" value="1"/></td>
						</tr>
						
						
						<tr>
							<td class="td-title"></td>
							<td>
								<input style="margin-top: 10px;" type="submit" class="input-submit" value="登录" />
								<input type="button" style="margin-top: 10px; margin-left: 10px;" class="input-submit" value="加入" onclick="javascript:location.href='/auth/register'" />
							</td>
						</tr>
					</table>
					<br />
				<?php echo form_close();?>
			</div>
		</div>
	</div>
	<div class="grid_8 welcome-right">
		<div style="height: 440px;">
			<div id="example">
			<img src="/img/new-ribbon.png" width="112" height="112" alt="New Ribbon" id="ribbon">
			<div id="slides">
				<div class="slides_container">
					<!--<a href=" target="_blank"><img src="/assets/slideshow/0.jpg" width="570" height="380" alt="Slide 1"></a>-->
					<a href=" target="_blank"><img src="/assets/slideshow/1.jpg" width="570" height="380" alt="Slide 2"></a>
					<a href=" target="_blank"><img src="/assets/slideshow/2.jpg" width="570" height="380" alt="Slide 3"></a>
					<a href=" target="_blank"><img src="/assets/slideshow/3.jpg" width="570" height="380" alt="Slide 4"></a>
					<a href=" target="_blank"><img src="/assets/slideshow/4.jpg" width="570" height="380" alt="Slide 5"></a>
					<a href=" target="_blank"><img src="/assets/slideshow/5.jpg" width="570" height="380" alt="Slide 5"></a>
				</div>
				<a href="#" class="prev"><img src="/img/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="/img/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
			</div>
			<img src="/img/example-frame.png" width="739" height="341" alt="Example Frame" id="frame">
			<div class="clearfix"></div>
		</div>
			
		</div>
	</div>
	<div class="clearfix"></div>
</div>