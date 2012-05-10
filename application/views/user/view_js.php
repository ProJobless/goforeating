<script type="text/javascript">
	function add_friend(fid)
	{
		if(confirm('确认要加为好友么?'))
		{
		$.ajax({
			url : '/friend/ajax_add/',
			type: 'POST',
			data: {
				'uid' : <?php echo $this->ion_auth->get_user()->id;?>,
				'fid' : fid
			},
			success : function(result) {
				if(result == 'success')
				{
					alert('成功加为好友!');
				}
				else {
					confirm('Internal Error! Please contact your dear system administrator, but I\'m sure he cannot manage it either.')
				}
			}
			
		});
		}
	}
	
	function delete_friend(fid)
	{
		if(confirm('确认要删除好友么?'))
		{
		$.ajax({
			url : '/friend/ajax_delete/',
			type: 'POST',
			data: {
				'uid' : <?php echo $this->ion_auth->get_user()->id;?>,
				'fid' : fid
			},
			success : function(result) {
				if(result == 'success')
				{
					alert('成功解除好友!');
				}
				else {
					confirm('Internal Error! Please contact your dear system administrator, but I\'m sure he cannot manage it either.')
				}
			}
			
		});
		}
	}
</script>