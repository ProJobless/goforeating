<script src="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"></script>
<script src="/js/mylibs/slides.min.jquery.js"></script>
<script>
	$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: '/img/loading.gif',
				play: 2000,
				pause: 2500,
				autoHeight: true,
				hoverPause: true
			});
		});
</script>