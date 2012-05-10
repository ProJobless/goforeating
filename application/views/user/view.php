<div class="user-style">
	<div class="grid_8 left">
		<br />
		<?php if($join): ?>
		<h2 class="strip-grey"><?php echo $user->name;?>要出席的</h2>
		<?php foreach($join as $item): ?>
		<?php $deal = $this->uni->get_one('deals', $item->deal_id); ?>
		<!-- start .news-item -->
		<div class="news-item">
		  <div class="news-item-photo">
			<a href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>"><img src="/assets/user_photos/<?php echo str_replace('.', '_100_thumb.', $this->ion_auth->get_user($deal->user_id)->photo);?>" alt="" /></a>
			<br />
			<a style="padding-bottom: 10px; display: block;" href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>">
				<?php echo $this->ion_auth->get_user($deal->user_id)->name;?>
			</a>
		  </div>
		  <div class="news-item-desc">
			<h3>
				<a href="/meal/view/<?php echo $deal->id;?>">去<?php echo $deal->location;?>吃好吃的</a>
			</h3>
			<div class="left">
				<table>
					<tr class="even">
						<td class="left-td">截止:</td>
						<td><?php echo date('m月d日', $deal->deadline);?></td>
					</tr>
					<tr>
						<td class="left-td">地点:</td>
						<td><?php echo $deal->addr;?></td>
					</tr>
					<tr class="even">
						<td class="left-td">人数:</td>
						<td><span class="em-red"><?php echo $deal->cur_people;?></span>/<?php echo $deal->min_people;?></td>
					</tr>
					<tr>
						<td class="left-td">人均:</td>
						<td><?php echo $deal->avg_price == 0 ? '不确定' : $deal->avg_price . '元';?></td>
					</tr>
					<tr class="even">
						<td class="left-td">发起:</td>
						<td><a href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>"><?php echo $this->ion_auth->get_user($deal->user_id)->name;?></a></td>
					</tr>
					<?php $comment_count = $this->deal_comments_model->get_deal_comments_count($deal->id);?>
					<?php if($comment_count > 0): ?>
					<tr>
						<td class="left-td"></td>
						<td style="text-align: right;" class="grey">
						<a href="/meal/view/<?php echo $deal->id;?>/#display-comment" class="star">* 已有<?php echo $comment_count;?>条讨论提案</a>
						</td>
					</tr>
					<?php endif; ?>
				</table>
			
			</div>
			<div class="right">
				<div class="inner">
				<?php if($me->id != $deal->user_id):?>
				<?php echo form_open('/meal/action');?>
					<input type="hidden" name="deal_id" value="<?php echo $deal->id;?>" />
					<input type="hidden" name="user_id" value="<?php echo $me->id;?>" />
					<?php
						$state = $this->deal_people_model->check_state($me->id, $deal->id);
						$disable = $this->deals_model->check_full($deal->id) ? 'disabled="disabled"' : '' ;
					?>
					<?php if($state == FALSE): ?>
						<input type="submit" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/><br />
						<input type="submit" class="input-submit-blue" value="感兴趣" name="interest" />
					<?php elseif($state == 'J'): ?>
						<input type="submit" class="input-submit-bw" value="退出" name="join"/><br />
						<input type="submit" class="input-submit-blue" value="感兴趣" name="interest" />
					<?php elseif($state == 'I'): ?>
						<input type="submit" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/><br />
						<input type="submit" class="input-submit-bw" value="退出" name="interest" />
					<?php endif; ?>
				<?php echo form_close(); ?>
				<?php else: ?>
					<!--<input type="button" class="input-submit-blue" value="EDIT" name="edit" />-->
					<span class="grey">(这是我创建的)</span>
				<?php endif; ?>
				</div>
			</div>
			<div class="clearfix"></div>
		  </div>
		  <div class="clearfix"></div>
		</div>
		<!-- end .news-item -->
		<?php endforeach;endif; ?>
		
		<?php if($interest): ?>
		<h2 class="strip-grey"><?php echo $user->name;?>感兴趣的</h2>
		<?php foreach($interest as $item): ?>
		<?php $deal = $this->uni->get_one('deals', $item->deal_id); ?>
		<!-- start .news-item -->
		<div class="news-item">
		  <div class="news-item-photo">
			<a href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>"><img src="/assets/user_photos/<?php echo str_replace('.', '_100_thumb.', $this->ion_auth->get_user($deal->user_id)->photo);?>" alt="" /></a>
			<br />
			<a style="padding-bottom: 10px; display: block;" href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>">
				<?php echo $this->ion_auth->get_user($deal->user_id)->name;?>
			</a>
		  </div>
		  <div class="news-item-desc">
			<h3>
				<a href="/meal/view/<?php echo $deal->id;?>">去<?php echo $deal->location;?>吃好吃的</a>
			</h3>
			<div class="left">
				<table>
					<tr class="even">
						<td class="left-td">截止:</td>
						<td><?php echo date('m月d日', $deal->deadline);?></td>
					</tr>
					<tr>
						<td class="left-td">地点:</td>
						<td><?php echo $deal->addr;?></td>
					</tr>
					<tr class="even">
						<td class="left-td">人数:</td>
						<td><span class="em-red"><?php echo $deal->cur_people;?></span>/<?php echo $deal->min_people;?></td>
					</tr>
					<tr>
						<td class="left-td">人均:</td>
						<td><?php echo $deal->avg_price == 0 ? '不确定' : $deal->avg_price . '元';?></td>
					</tr>
					<tr class="even">
						<td class="left-td">发起:</td>
						<td><a href="/user/view/<?php echo $this->ion_auth->get_user($deal->user_id)->username;?>"><?php echo $this->ion_auth->get_user($deal->user_id)->name;?></a></td>
					</tr>
					<?php $comment_count = $this->deal_comments_model->get_deal_comments_count($deal->id);?>
					<?php if($comment_count > 0): ?>
					<tr>
						<td class="left-td"></td>
						<td style="text-align: right;" class="grey">
						<a href="/meal/view/<?php echo $deal->id;?>/#display-comment" class="star">* 已有<?php echo $comment_count;?>条讨论提案</a>
						</td>
					</tr>
					<?php endif; ?>
				</table>
			
			</div>
			<div class="right">
				<div class="inner">
				<?php if($me->id != $deal->user_id):?>
				<?php echo form_open('/meal/action');?>
					<input type="hidden" name="deal_id" value="<?php echo $deal->id;?>" />
					<input type="hidden" name="user_id" value="<?php echo $me->id;?>" />
					<?php
						$state = $this->deal_people_model->check_state($me->id, $deal->id);
						$disable = $this->deals_model->check_full($deal->id) ? 'disabled="disabled"' : '' ;
					?>
					<?php if($state == FALSE): ?>
						<input type="submit" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/><br />
						<input type="submit" class="input-submit-blue" value="感兴趣" name="interest" />
					<?php elseif($state == 'J'): ?>
						<input type="submit" class="input-submit-bw" value="退出" name="join"/><br />
						<input type="submit" class="input-submit-blue" value="感兴趣" name="interest" />
					<?php elseif($state == 'I'): ?>
						<input type="submit" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/><br />
						<input type="submit" class="input-submit-bw" value="退出" name="interest" />
					<?php endif; ?>
				<?php echo form_close(); ?>
				<?php else: ?>
					<!--<input type="button" class="input-submit-blue" value="EDIT" name="edit" />-->
					<span class="grey">(这是我创建的)</span>
				<?php endif; ?>
				</div>
			</div>
			<div class="clearfix"></div>
		  </div>
		  <div class="clearfix"></div>
		</div>
		<!-- end .news-item -->
		<?php endforeach;endif; ?>
	</div>
	<div class="grid_4 right">
		<div class="white-bg-round min-height-200">
			<h2 class="add-h2"><?php echo $user->name;?></h2>
			<div class="photo">
				<img src="/assets/user_photos/<?php echo str_replace('.', '_100_thumb.', $user->photo);?>" alt="" />
				<br />
				<?php if($this->ion_auth->get_user()->id != $user->id): ?>
					<?php if($is_friend): ?>
						<a href="#" onclick="delete_friend(<?php echo $user->id;?>)" class="input-submit-bw fake-button" style="color: #333;">解除好友</a>
					<?php else: ?>
						<a href="#" onclick="add_friend(<?php echo $user->id;?>)" class="input-submit-blue fake-button">加为好友</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			
			<h3>自述</h3>
			<div class="bio">
				<?php echo $user->bio;?>
			</div>
			
		</div>
	</div>
	<div class="clearfix"></div>
</div>