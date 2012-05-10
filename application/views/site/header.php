<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php if(isset($title)) echo "$title | ";?>等你吃饭</title>
  <meta name="description" content="与美妙的吃饭经历不期而遇">
  <meta name="author" content="G4E Team">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/layout.css">
  <link rel="stylesheet" href="/css/960_12_col.css">
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="/js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>
	<?php if($this->session->flashdata('user-info')): ?>
<div class="flash-info">
    <?php echo $this->session->flashdata('user-info');?>
</div>
<?php endif;?>

<?php if($this->session->flashdata('user-warn')): ?>
<div class="flash-warn">
    <?php echo $this->session->flashdata('user-warn');?>
</div>
<?php endif;?>

<?php if($this->session->flashdata('user-error')): ?>
<div class="flash-error">
    <?php echo $this->session->flashdata('user-error');?>
</div>
<?php endif;?>
  <div id="container">
    <header>
      <div class="container_12">
	<h1 class="header-logo"><a title="等你吃饭" alt="等你吃饭" href="/">等你吃饭</a></h1>
	<div class="search">
		<!--
	  <form action="/">
	    <input id="search-bar" type="text" placeholder="有没有人跟我想吃一样的..." />
	    <input type="submit" class="input-submit-blue" value="搜吃的" />
	  </form>
		-->
	</div>
	<ul class="header-nav">
		<?php if($this->ion_auth->logged_in()): ?>
	  <li><a href="/">首页</a></li>
	  <li><a href="/meal/add/">开饭</a></li>
		<!--<li><a href="/friend/">朋友</a></li>-->
	  <li><a href="/invite/">邀请</a></li>
	  <!--<li><a href="/meal/find/">找饭</a></li>-->
	  <li><a href="/setting/">设置</a></li>
		<li><a href="/auth/logout/">退出</a></li>
		<?php else: ?>
		<li><a href="/auth/register/">注册</a></li>
		<li><a href="/auth/login/">登录</a></li>
		<?php endif; ?>
	</ul>
	<div class="clearfix"></div>
      </div>
    </header>
    <!--<div style="background: url(/images/color_panel.png); height: 40px; margin-top: 5px;"></div>-->
    <div id="main" role="main" class="container_12 bg">