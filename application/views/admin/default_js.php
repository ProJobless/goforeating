<script type="text/javascript">
	$(document).ready(function(){
		
	});
	
	function check_this(id)
	{
		$('#item_' + id).toggle(
			function(){
				$(this).attr('style', 'text-decoration: line-through;');
				},
			function(){
				$(this).attr('style', 'text-decoration: none;');
			}
			)
	}
</script>