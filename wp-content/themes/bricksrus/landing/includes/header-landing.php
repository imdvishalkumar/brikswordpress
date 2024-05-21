<!doctype html>
<?php
$home = get_template_directory_uri().'/landing/';
?>

<html lang="en-US" class="no-js">

	<head>
		<meta charset="UTF-8">
		<script>
			dataLayer = [];
			
			
			
			<?php // header (javascript) tracking codes for Google Analytics, Google Ads, etc. added by drewadesigns.com on 8/7/2019
				include_once(get_template_directory() . '/tracking-header.php');
			?>
			
			
			
		</script>
		<meta name="robots" content="index,follow">

		<title><?php if($seotitle){ echo $seotitle; } else { ?> <?php echo get_field('page_title'); ?> <?php } ?></title>

		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo $home; ?>includes/img/icons/brickicon.ico" rel="shortcut icon">
        <link href="<?php echo $home; ?>includes/img/icons/logo.png" rel="apple-touch-icon-precomposed">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro%3A400%2C600%2C70" media="all">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

			
		<?php
			add_action( 'wp_enqueue_scripts', function () {

				$styles = array( 'html5blank', 'html5reset-reset', 'html5reset-chipstyles'); // Append additional styles names here to remove more

				foreach ( $styles as $style ) {
					wp_dequeue_style( $style );
					wp_deregister_style( $style );
				}
				$scripts = array(''); // Append additional scripts names here to remove more

				foreach ( $scripts as $script ) {
					wp_dequeue_script( $script );
					wp_deregister_script( $script );
				}

				// Enqueue New
				wp_enqueue_style( 'go-landing-page-style', get_template_directory_uri() . '/landing/includes/css/style.css', array(), '1.0' );
				//wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/new-landing-page/js/lib/colorbox/jquery.colorbox-min.js' );
			}, 20 );
		?>

		<?php wp_head(); ?>

	
		


	</head>

	<!--[if lte IE 9]>
	<body class="page-template-page-landing ie" itemscope="" itemtype="http://schema.org/WebPage">
	<![endif]-->
	<!--[if (gt IE 9)|!(IE)]>
	<!--><body class="page-template-page-landing" itemscope="" itemtype="http://schema.org/WebPage"><!--<![endif]-->
			<header class="header clear" role="banner">
				<div class="wrapper">

					<div class="logo">
						<a href="//bricksrus.com" target="_blank">
							<img itemprop="logo" src="<?php echo get_field('logo'); ?>" alt="Bricks R Us Logo" class="logo-img">
						</a>
					</div>
					<div class="phone">
						<a class="tel" href="tel:8886927425">888.692.7425</a>
					</div>

				</div>
			</header>


			<header class="s-header clear">
				<div class="wrapper">
					<div class="logo">
						<a href="//bricksrus.com" target="_blank">
							<img itemprop="logo" src="<?php echo get_field('logo'); ?>" alt="Bricks R Us Logo" class="logo-img">
						</a>
					</div>
					<div class="phone">
						<a class="tel" href="tel:<?php echo str_replace('.','',get_field('phone_number')); ?>"><?php echo get_field('phone_number'); ?></a>
					</div>
				</div>
			</header>




