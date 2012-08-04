<div class="invite-style">
    <div class="grid_8">
        <div class="white-bg-round min-height-200">
			<h2 class="add-h2 group"><?php echo $title;?></h2>
			<p style="margin: 15px;">>> 邀请码数量: <strong style="font-size: 18px; color: orange"><?php echo $code_num;?></strong></p>        
        <?php if($codes) :?>
        <ul style="list-style: none;">
            <?php foreach($codes as $code):?>
            <li style="margin: 5px 0px;">
                <input type="text" onmouseover="this.focus()" onfocus="this.select()" value="<?php echo site_url('/auth/register');?>?code=<?php echo $code;?>" style="border:none; width: 500px;border-bottom: #E4F2F8 1px dashed; margin: 3px 0px;padding: 4px;" readonly/>
            </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
		</div>
    </div>
    
    <div class="grid_4">
		<br />
		<h3 class="strip-grey">Q:为什么要采取邀请制?</h3>
		<p style="margin: 10px;">A:因为和谁吃饭是件严肃的事情. <br />目前"等你吃饭"仅对北邮以及周边高校开放, 请将邀请码散发给你认识的朋友, 一起来发展社区.</p>
    </div>
    
    <div class="clearfix"></div>
</div>