<?php


include (__DIR__.'/includes/header-landing.php');

/* Template Name: Bricks For Fundraising Landing Page */




	$page_title = 'bricks-for-fundraising'; ?>

	<main role="main">

		<section class="banner img-fill clear" style="background-image:url(<?php echo get_field('banner_image'); ?>">
			<div class="content-container">
				<div class="content valign">
					<h1 itemprop="name" class="page-title"><?php echo get_field('banner_text'); ?></h1>
				</div>
			</div>
		</section>
		<section class="sample-form center">
			<div class="wrapper">
				<span class="text-red"><?php echo get_field('contact_form_header'); ?></span>
				<span class="text-black" style="text-transform:none;font-weight:normal; margin-top:15px; font-size:1.2em;">
					<?php echo get_field('contact_form_paragraph'); ?>
				</span>
				<a id="freesample"></a>
				<?php echo get_field('contact_form'); ?>

			</div>
		</section>

		<?php echo get_field('bricks_r_us_body'); ?>


		<section class="list list-one clear" >
			<div class="wrapper">

				<h2 class="section-title"><?php echo get_field('benefits_for_working_header'); ?></h2>
				<ul>
					<?php
						if(have_rows('benefits_for_working_reapeater')){
							while(have_rows('benefits_for_working_reapeater')){
								the_row();
								?>
									<li><img src="<?php echo $home; ?>includes/img/checkmark.png" /><?php echo get_sub_field('text') ?></li>
								<?php
							}
						}
					?>

				</ul>
			</div>
		</section>

		<?php if(get_field('main_content')){ ?>
			<section class="main_text clear" itemprop="mainContentOfPage">
				<div class="wrapper">
					<?php echo get_field('main_content'); ?>
				</div>
			</section>
		<?php } ?>

		<section class="testimonials img-fill center" style="background-image:url(<?php echo get_field('middle_banner_image'); ?>);">
			<div class="wrapper">
				<?php echo get_field('middle_banner_text'); ?>
			</div>
		</section>

		<?php if(get_field('manage_your_brick_campaign_header')){?>
			<section class="list list-one clear">
				<div class="wrapper">

					<h2 class="section-title"><?php echo get_field('manage_your_brick_campaign_header'); ?></h2>
					<ul>
						<?php
							if(have_rows('manage_your_brick_campaign')){
								while(have_rows('manage_your_brick_campaign')){
									the_row();
									?>
										<li><img src="<?php echo $home; ?>includes/img/checkmark.png" /><?php echo get_sub_field('text') ?></li>
									<?php
								}
							}
						?>

					</ul>
				</div>
			</section>
		<?php } ?>

		<?php if(get_field('additional_content')){ ?>
			<section class="main_text clear">
				<div class="wrapper">

					<?php
						echo get_field('additional_content');
					?>

				</div>
			</section>
		<?php } ?>

	</main>


	<?php include(__DIR__.'/includes/footer-landing.php'); ?>
	<?php
