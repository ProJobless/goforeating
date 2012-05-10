<div id="main-left" class="grid_8">
	<h2 class="strip-grey">新鲜出炉</h2>
	
	<?php if($deals):foreach($deals as $deal): ?>
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
			<?php if($this->deals_model->is_private($deal->id)): ?>
				<img src="/images/icon/private.png" alt="仅好友可见" title="仅好友可见" />
			<?php endif; ?>
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
					<td><span class="em-red" id="<?php echo $deal->id;?>_cur_people"><?php echo $deal->cur_people;?></span>/<?php echo $deal->min_people;?></td>
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
			<?php if($user->id != $deal->user_id):?>
			<?php echo form_open('/meal/action');?>
				<input type="hidden" name="deal_id" value="<?php echo $deal->id;?>" />
				<input type="hidden" name="user_id" value="<?php echo $user->id;?>" />
				<?php
					$state = $this->deal_people_model->check_state($user->id, $deal->id);
					$disable = $this->deals_model->check_full($deal->id) ? 'disabled="disabled"' : '' ;
				?>
				<?php if($state == FALSE): ?>
					<input type="button" id="<?php echo $deal->id;?>_join" onclick="ajax_action(<?php echo $deal->id;?>, 'join')" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/><br />
					<input type="button" id="<?php echo $deal->id;?>_interest" onclick="ajax_action(<?php echo $deal->id;?>, 'interest')" class="input-submit-blue" value="感兴趣" name="interest" />
				<?php elseif($state == 'J'): ?>
					<input type="button" id="<?php echo $deal->id;?>_quit_join" onclick="ajax_action(<?php echo $deal->id;?>, 'quit_join')" class="input-submit-bw" value="退出" name="join"/><br />
					<input type="button" id="<?php echo $deal->id;?>_interest" onclick="ajax_action(<?php echo $deal->id;?>, 'interest')" class="input-submit-blue" value="感兴趣" name="interest" />
				<?php elseif($state == 'I'): ?>
					<input type="button" id="<?php echo $deal->id;?>_join" onclick="ajax_action(<?php echo $deal->id;?>, 'join')" class="input-submit-yellow" value="我要去" name="join" <?php echo $disable;?>/><br />
					<input type="button" id="<?php echo $deal->id;?>_quit_interest" onclick="ajax_action(<?php echo $deal->id;?>, 'quit_interest')" class="input-submit-bw" value="退出" name="interest" />
				<?php endif; ?>
			<?php echo form_close(); ?>
			<?php else: ?>
				<!--<input type="button" class="input-submit-blue" value="EDIT" name="edit" />-->
				<span class="grey"  onclick="ajax_action('test');">(这是我创建的)</span>
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
<div class="main-right grid_4">
	<h2 class="strip-grey"><?php echo $salut;?>了么, <?php echo $user->name;?></h2>
	<div class="salut">
		<p class="salut-info">我创建了 <strong style="color: #900; font-size: 14px;"><?php echo $created_nums;?></strong> 个订单<br />
		我参加了 <strong style="color: #900; font-size: 14px;"><?php echo $joined_nums;?></strong> 个订单<br />
		我对 <strong style="color: #900; font-size: 14px;"><?php echo $interested_nums;?></strong> 个订单感兴趣</p>
		<?php if($unread > 0): ?>
		<a class="home-notification" href="/notification">
			你有<?php echo $unread;?>个未读通知
		</a>
		<?php endif; ?>
	</div>
	
	<div class="clearfix"></div>
	<h2 class="strip-grey">吃品大分类</h2>
	<ul id="home-tags">
	  <?php if($tags):foreach($tags as $tag): ?>
		<li><a href="/tag/view/<?php echo urlencode($tag->value);?>"><?php echo $tag->value;?></a></li>
	  <?php endforeach;endif; ?>
	</ul>
</div>
<div class="clearfix"></div>