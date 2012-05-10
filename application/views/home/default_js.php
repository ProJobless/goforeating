<script type="text/javascript">
	function ajax_action(deal_id,post_field)
	{
		$.ajax({
			url : '/meal/ajax_action/',
			type: 'POST',
			data: {
				'deal_id' : deal_id,
				'post_field' : post_field
				},
			success: function(result)
			{
				alert('操作成功!');
				if(post_field == 'join' || post_field == 'quit_join')
				{
					$('#'+deal_id+'_cur_people').html(result);
				}
				
				if(post_field == 'join')
				{
					$('#'+deal_id+'_join').attr("value", "退出");
					$('#'+deal_id+'_join').attr("class", "input-submit-bw");
					$('#'+deal_id+'_join').attr("onclick", "ajax_action(" + deal_id + ", 'quit_join')");
					$('#'+deal_id+'_join').attr("id", deal_id + "_quit_join");
				}
				else if (post_field == 'quit_join')
				{
					$('#'+deal_id+'_quit_join').attr("value", "我要去");
					$('#'+deal_id+'_quit_join').attr("class", "input-submit-yellow");
					$('#'+deal_id+'_quit_join').attr("onclick", "ajax_action(" + deal_id + ", 'join')");
					$('#'+deal_id+'_quit_join').attr("id", deal_id + "_join");
				}
				else if (post_field == 'interest')
				{
					$('#'+deal_id+'_interest').attr("value", "退出");
					$('#'+deal_id+'_interest').attr("class", "input-submit-bw");
					$('#'+deal_id+'_interest').attr("onclick", "ajax_action(" + deal_id + ", 'quit_interest')");
					$('#'+deal_id+'_interest').attr("id", deal_id + "_quit_interest");
				}
				else if (post_field == 'quit_interest')
				{
					$('#'+deal_id+'_quit_interest').attr("value", "感兴趣");
					$('#'+deal_id+'_quit_interest').attr("class", "input-submit-blue");
					$('#'+deal_id+'_quit_interest').attr("onclick", "ajax_action(" + deal_id + ", 'interest')");
					$('#'+deal_id+'_quit_interest').attr("id", deal_id + "_interest");
				}
			}
		});
	}
</script>