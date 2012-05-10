<div class="view-style">
	<div class="grid_8 left">
		<div class="white-bg-round">
			<h2 class="add-h2">去<?php echo $deal->location;?>吃好吃的
			<?php if($this->deals_model->is_private($deal->id)): ?>
			 <span class="grey"> <img src="/images/icon/private.png" alt="仅好友可见" />(仅好友可见)</span>
			<?php endif; ?>
			</h2>
			<div class="view-leftbar">
				<div class="photo">
					<a href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>">
					<img style="border: #eee 1px solid;" src="/assets/user_photos/<?php echo str_replace('.', '_100_thumb.', $this->ion_auth->get_user($deal->user_id)->photo);?>" alt="" />
					</a>
					<br />
					<p>
						发起人: <br /> <a href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>"><?php echo $this->ion_auth->get_user($deal->user_id)->name;?></a>
					</p>
				</div>
			</div>
			<div class="view-rightbar">
				<table>
					<tr class="even">
						<td class="title">地点:</td>
						<td><?php echo $deal->location;?></td>
					</tr>
					<tr>
						<td class="title">地址:</td>
						<td id="deal_addr"><?php echo $deal->addr;?></td>
					</tr>
					<tr class="even">
						<td class="title">人均:</td>
						<td><?php echo $deal->avg_price == 0 ? '不确定' : $deal->avg_price . '元';?></td>
					</tr>
					<tr>
						<td class="title">截止时间:</td>
						<td>
							<?php echo date('m-d', $deal->deadline);?>
						</td>
					</tr>
					<tr class="even">
						<td class="title">他还说:</td>
						<td><?php echo $deal->desc;?></td>
					</tr>
					
					<tr>
						<td class="title">人数:</td>
						<td class="people"><span class="em-red"><?php echo $deal->cur_people;?></span>/<?php echo $deal->min_people;?></td>
					</tr>
					
					<tr>
						<td class="title"></td>
						<td>
				<?php if($user->id != $deal->user_id):?>
				<?php echo form_open('/meal/action');?>
				<input type="hidden" name="deal_id" value="<?php echo $deal->id;?>" />
				<input type="hidden" name="user_id" value="<?php echo $user->id;?>" />
				<?php
					$state = $this->deal_people_model->check_state($user->id, $deal->id);
					$disable = $this->deals_model->check_full($deal->id) ? 'disabled="disabled"' : '' ;
				?>
				<?php if($state == FALSE): ?>
					<input type="submit" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/>
					<input type="submit" class="input-submit-blue" value="感兴趣" name="interest" />
				<?php elseif($state == 'J'): ?>
					<input type="submit" class="input-submit-bw" value="退出" name="join"/>
					<input type="submit" class="input-submit-blue" value="感兴趣" name="interest" />
				<?php elseif($state == 'I'): ?>
					<input type="submit" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/>
					<input type="submit" class="input-submit-bw" value="退出" name="interest" />
				<?php endif; ?>
				<?php echo form_close(); ?>
				<?php else: ?>
					<input type="button" class="input-submit-blue" value="编辑" name="edit" onclick="javascript: location.href='/meal/edit/<?php echo $deal->id;?>'" />
					<a style="margin-left: 20px;" href="/meal/delete/<?php echo $deal->id;?>" onclick="return confirm('确认要删除么?')">>>删除</a> 
				<?php endif; ?>
						</td>
					</tr>
					
					
				</table>
			</div>
			<div class="clearfix"></div>
			<?php if($is_full == TRUE): ?>
			<!--	contact form START	-->
			<h3 class="add-h3">大家的联系方式</h3>
			<div class="contact-form">
				<?php echo $this->table->generate(); ?>
			</div>
			<!--	contact form END	-->
			<?php endif; ?>
			<!--	people here		-->
			<h3 class="add-h3">出席此次聚餐的童鞋有</h3>
			<div class="join-people">
				<?php if($join):foreach($join as $item): ?>
				<div class="item">
					<a href="/user/view/<?php echo $this->ion_auth->get_user($item->user_id)->username;?>">
						<img style="border: #eee 1px solid;" src="/assets/user_photos/<?php echo str_replace('.', '_100_thumb.', $this->ion_auth->get_user($item->user_id)->photo);?>" alt="" />
					</a>
					<a href="/user/view/<?php echo $this->ion_auth->get_user($item->user_id)->username;?>"><?php echo $this->ion_auth->get_user($item->user_id)->name;?></a>
				</div>
				<?php endforeach;endif; ?>
				<div class="clearfix"></div>
			</div>
			
			<h3 class="add-h3">对聚餐表示墙裂关注的童鞋有</h3>
			<div class="interest-people">
				<?php if($interest):foreach($interest as $item): ?>
				<div class="item">
					<a href="/user/view/<?php echo $this->ion_auth->get_user($item->user_id)->username;?>">
					<img style="border: #eee 1px solid;" src="/assets/user_photos/<?php echo str_replace('.', '_100_thumb.', $this->ion_auth->get_user($item->user_id)->photo);?>" alt="" />
					</a>
					<a href="/user/view/<?php echo $this->ion_auth->get_user($item->user_id)->username;?>"><?php echo $this->ion_auth->get_user($item->user_id)->name;?></a>
				</div>
				<?php endforeach;endif; ?>
				<div class="clearfix"></div>
			</div>
			
			<?php if($comments): ?>
			<h3 class="add-h3">童鞋们指示</h3>
			<div id="display-comment">
				<?php foreach($comments as $item): ?>
					<div class="left">
						<a href="/user/view/<?php echo $this->ion_auth->get_user($item->user_id)->username;?>">
					<img style="border: #eee 1px solid;" src="/assets/user_photos/<?php echo str_replace('.', '_thumb.', $this->ion_auth->get_user($item->user_id)->photo);?>" alt="" />
					</a>
					</div>
					<div class="right">
						<h4><a href="/user/view/<?php echo $this->ion_auth->get_user($item->user_id)->username;?>"><?php echo $this->ion_auth->get_user($item->user_id)->name;?></a> <span class="grey"><?php echo date('Y-d-m  H:i:s', $item->ctime);?></span></h4>
						<p>
							<?php echo $item->value;?>
						</p>
					</div>
					<div class="clearfix"></div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			
			<h3 class="add-h3">关于这次大会, 我需要强调的是</h3>
			<div class="comment">
				<?php echo form_open('meal/submit_comment');?>
				<table>
					<tr>
						<td style="width: 450px; text-align: center;">
							<textarea name="comment" id="comment" cols="50" rows="10" class="input-textarea"><?php //echo set_value('comment');?></textarea></td>
						<td style="vertical-align: bottom;">
							<input type="hidden" name="user_id" value="<?php echo $user->id;?>" />
							<input type="hidden" name="deal_id" value="<?php echo $deal->id;?>" />
							<input type="submit" name="comment-submit" class="input-submit" value="提交"" /></td>
					</tr>
				</table>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
	
	<div class="grid_4 right">
		<div class="white-bg-round" style="min-height: 245px;">
			<h2 class="add-h3">据悉, 本次聚餐将于这里举行</h2>
			<div id="map_canvas">
				
			</div>
		</div>
		
		<div class="white-bg-round" style="height: 100px;">
			<h2 class="add-h3">将聚餐精神传达到</h2>
			<!-- JiaThis Button BEGIN -->
			<div id="jiathis_style_32x32">
			<a class="jiathis_button_qzone"></a>
			<a class="jiathis_button_tsina"></a>
			<a class="jiathis_button_tqq"></a>
			<a class="jiathis_button_renren"></a>
			<a href="http://www.jiathis.com/share?uid=1551643" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
			<a class="jiathis_counter_style"></a>
			</div>
			<!-- JiaThis Button END -->
		</div>
		
		<div>
			<ul id="home-tags">
				<h2 class="strip-grey">菜品标签</h2>
				<?php if($tags):foreach($tags as $tag): ?>
				<li>
					<a href="/tag/view/<?php echo urlencode($tag->value);?>"><?php echo $tag->value;?></a>
				</li>
				<?php endforeach;endif; ?>
			</ul>
		</div>
	</div>
	<div class="clearfix"></div>
</div>