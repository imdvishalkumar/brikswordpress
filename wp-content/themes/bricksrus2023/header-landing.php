<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/brickicon.ico" rel="shortcut icon">
        <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php wp_head(); ?>

		<script>
        // conditionizr.com
        // configure environment tests
        conditionizr.config({
            assets: '<?php echo get_template_directory_uri(); ?>',
            tests: {}
        });
		
		
		
		<?php // header (javascript) tracking codes for Google Analytics, Google Ads, etc. added by drewadesigns.com on 8/7/2019
			include_once('tracking-header.php');
		?>
		
		
		
		</script>
        <!--[if gte IE 9]>
		<style type="text/css">
			.gradient {  filter: none;  }
		</style>
		<![endif]-->

	</head>

	<body <?php body_class(); ?>>

	<header class="header clear" role="banner">
		<div class="wrapper">

			<div class="logo">
				<a href="//bricksrus.com" target="_blank">
					<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Logo" class="logo-img">
				</a>
			</div>
			<div class="phone">
				<a class="tel" href="tel:8886927425">888.692.7425</a>
			</div>
			<div class="sample">
				<a href="#freesample" class="samplebrick">Free Sample</a>
			</div>

		</div>
	</header>

	<aside class="phone mobile clear" role="banner">
		<div class="wrapper">
			<div class="sample">
				<a href="#freesample" class="samplebrick button">Free Sample Brick</a>
			</div>
		</div>
	</aside>

	<header class="s-header clear">
		<div class="wrapper">
			<div class="logo">
				<a href="//bricksrus.com" target="_blank">
					<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Logo" class="logo-img">
				</a>
			</div>
			<div class="sample">
				<a href="#freesample" class="samplebrick button">Order Your Free Sample Brick</a>
			</div>
			<div class="phone">
				<a class="tel" href="tel:7179421374">717.942.1374</a>
			</div>
		</div>
	</header>

