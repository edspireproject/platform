<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]--> 
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]--> 
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]--> 
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]--> 
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
	<title><?php ed_title(); ?></title>
	<?php // do unless a cookie is set to say use full site all the time - but need an option to go back to mobile site too ?>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<script>
	<?php if(!get_dnt_status()): ?>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	// Uncomment the following line and replace placeholders to enable Google Analytic gathering
	// ga('create', '{insert Google Analytics key}', '{insert domain}');
	<?php write_ab_vars(); ?>
	ga('send', 'pageview');
	<?php else: ?>
	function ga(i,s,o,g,r,a,m) {
	};
	<?php endif ?>
    </script>
	<noscript>
	  <link rel="stylesheet" type="text/css" href="<?php echo get_themeroot(); ?>/css/edspire-min.css?v=1.15" />
	  <link rel="stylesheet" type="text/css" href="<?php echo get_themeroot(); ?>/css/noscript-min.css"/>
	  <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'/>
	</noscript>
	<style>
	/* above the fold css */
	html{font-size:16px;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}html,body,button,input,select,textarea {font-weight: 300;font-family: 'Lato', 'Helvetica Neue', helvetica, sans-serif;}
	body {margin:0}p,pre{margin:1em 0}a{text-decoration: none;}a:focus{outline:thin dotted}a:active, a:hover{ outline:0 }b, strong { font-weight:bold }
	* { box-sizing: border-box; }
	h1 { color: #83caff; margin: 0 0 0.5em 0; font-size: 1.75em; }h2, h3 { font-weight: normal; }h2 { margin-top: 0; }
	h1.not-front { color: #000; margin: 0.5em 0; }
	.sfp div { line-height: 180%; } #sfp2 a { display: inline-block; margin: 0 6px 6px 0; color: #ff6b00; } #sfp1 a { color: #ff6b00; }
	#sfp0 { background: url(<?php echo get_themeroot(); ?>/img/hero-background.jpg) no-repeat scroll 50% 50% #3B363A; padding: 0; height: 275px; margin-bottom: 20px; }
	/* general */
	.w0 { margin: 0 auto; padding: 0 10px; }	#h0 { left: 0; position: fixed; top: 0; width: 100%; box-shadow: 0px 5px 12px 0px rgba(0, 0, 0, 0.2); z-index: 100; background-color: #fff; height: 62px; padding: 0 }.headfaker { height: 62px; }	#as0 { display: none; }
	@media reader {	#as0 { display: block; } }
	.anav { padding: 0.75em; display: inline-block; text-transform: uppercase; color: #666; transition: all linear 0.05s; }
	.anav:hover { background-color: #aaa; color: #fff; }
	#ah0 { float: left; }
	#uh0 { float: right; margin: 0; padding: 22px 0 0 5px; position: relative; list-style-type: none; z-index: 1; }
	#am0 { display: block; margin: -22px -13px 0 0; width: 62px; height: 62px; background: transparent url(<?php echo get_themeroot(); ?>/img/icon-menu.svg) no-repeat 50% 50%; background-size: 20px 20px; text-indent: -9999px; overflow: hidden;  }
	#fh0 { position: absolute; right: 70px; height: 62px; padding-top: 17px; width: 5.5em; }
	#l0 { display: none; }
	#i0 { border: 1px solid #99A; font-size: 0.8em; border-radius: 6px; padding: 4px 24px 4px 6px; background-color: transparent; max-width: 100%; }
	#i0:focus { background-color: #fff; }
	#s0 { position: absolute; font-size: 0.8em; padding: 4px 8px; border: 0; right: 0; top: 17px; width: 28px; background: transparent url(<?php echo get_themeroot(); ?>/img/icon-search.svg) no-repeat 50% 50%; background-size: 16px 16px; text-indent: -100px; overflow: hidden; cursor: pointer; }
	#uh1 { display: none; background-color: #fff;  list-style-type: none; margin: 0; padding: 0; box-shadow: 0px 0px 10px 0px rgba(50, 50, 50, 0.5); margin-top: -6px; }
	#uh1 a.anav { display: block; }
	.isCC { position: relative; }
	#uh0 > li:hover #am0 { background-color: #d6d6d6; }
	#uh0 > li:hover #uh1 { display: block; position: absolute; right: -13px; top: 68px; }
	#uh0 > li:hover { padding-bottom: 100px; }
	.loz1 h1 { font-weight: 300; } #l1 { display: none; position: absolute; text-align: left; width: 68%; overflow: hidden; white-space: nowrap; padding: 4px 6px 0 8px; pointer-events: none; } #i1 { width: 80%; }
	.loz2 {	width: 100%; height: 215px; }
	#f0 { padding: 1em 0; border-top: 1px solid #d6d6d6; clear: both; background-color: #eee; overflow: auto; font-size: 0.9em; }
	.ful { list-style-type: none; margin: 0; padding: 0; } .ful > li { display: inline-block; } .ful a { color: #000; } .ful a:visited { color: #000; }
	#fl { margin-bottom: 20px; } #fl > li { margin: 0 12px 12px 0; } .soc { display: inline-block; width: 36px; height: 36px; margin-right: 10px; margin-left: 0; }
	#i1 { border-radius: 8px; border: 0; padding: 6px 8px; } #s1 { border: 0; padding: 2px 8px; width: 30px; margin-left: -32px; margin-top: -2px;background: transparent url(<?php echo get_themeroot(); ?>/img/icon-search.svg) no-repeat 50% 50%; background-size: 20px 20px; text-indent: -100px; }
	button,input,select,textarea{font-size:14px;margin:0;vertical-align:middle;*vertical-align:middle}
	button,input{line-height:normal}
	button,select{text-transform:none}button,html input[type="button"],input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer;*overflow:visible}
	@media only screen and (min-width: 480px) {
		#fh0 { width: 10.5em; }
		.loz2 { height: 210px; }
		#sfp0 { height: 290px; }
		#l1 { display: inline-block; }
	}
	@media only screen and (min-width: 595px) {
		.soc { margin-left: 10px; margin-right: 0;}
	}
	@media only screen and (min-width: 768px) {
		h1 { margin-top: 0.5em; }
		#am0 { display: none; }
		#uh1 { display: block; border: 0; box-shadow: none; }
		#uh1 li { display: inline-block; border: 0; }
		#uh0 > li:hover #uh1 { position: relative; right: 0; top: 0; }
		.anav { border: 1px solid #fff; padding: 0.2em 0.6em; }
		.anav:hover { background-color: #fff; color: #000; }
		.anav.hl { border-color: #aaa; padding: 0.2em 0.2em 0.2em 0.3em; }
		.anav.hl:hover { background-color: #aaa; color: #fff; }
		#fh0 { position: relative; right: 0; margin-left: 20px; float: left; width: 14em; }
		#i0 { width: 20em; }
		#l0 { display: block; position: absolute; z-index: -1; font-size: 0.8em; padding: 5px 0 0 8px; color: #aaa; }
		#l0.hidelabel { display: none; }
		#i1 { width: 440px; }
	}
	@media only screen and (min-width: 1020px) {
		.w0 { width: 1000px; }
		#sfp2 a { color: #fff;margin: 0; }
	}
	</style>
	<script async src="<?php echo get_themeroot(); ?>/js/edspire.js?v=1.15"></script>
<?php
wp_head();
write_metas();
?>
</head>
<body>
	<header id="h0"><nav class="w0"><a id="as0" href="#content">Skip navigation</a><a id="ah0" title="Go to the homepage" href="<?php echo home_url(); ?>/"><img class="edspirelogo" src="<?php echo get_themeroot(); ?>/img/edspire-logo-bare.svg" width="130" height="60" alt="edspire" /></a><ul id="uh0">
			  <li><a id="am0" href="#uh1">Menu</a>
			  <ul id="uh1">
			    <li><a class="anav" title="Use the wizard to discover online learning resources" href="/discover/">Discover</a></li>
			    <li><a class="anav" title="Find upcoming online learning resources with our calendar" href="/calendar/">Calendar</a></li>
			    <?php if (is_user_logged_in()): ?><li><a class="anav" title="View your pins and profile" href="/profile/">Profile</a></li>
			    <?php else: ?><li><a class="anav hl" title="Register, or log in to your account" href="/profile/">Login/Register</a></li><?php endif; ?>
			  </ul>
			  </li>
			</ul><form id="fh0" method="POST" action="<?php echo home_url(); ?>/search/">
				<label id="l0" for="i0">Search all courses, videos, tutorials</label>
				<input id="i0" type="text" name="s-ft" value="<?php echo get_query_var('s-ft'); ?>">
				<input id="s0" type="submit" value="Search">
			</form></nav></header>
