<?php

/* Template Name: Newsletter Landing */

get_header(); ?>

	<main role="main" class="clear">

		<div class="wrapper">
			<?php alternate_title(); ?>
			<?php if (has_post_thumbnail()) {
				$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full')[0];
			}
			$prefix = 'newsletter-signup' ?>
			<section class="<?php echo $prefix; ?> clear">
				<div class="img-fill <?php echo $prefix; ?>-thumbnail"
					 <?php if (has_post_thumbnail()){ ?>style="background-image:url(<?php echo $image; ?>);"<?php } ?>></div>
				<div class="<?php echo $prefix; ?>-form">
					<?php the_content(); ?>
					<?php echo do_shortcode('[mailchimp_newsletter_signup]'); ?>
				</div>
			</section>

		</div>

	</main>


<?php get_footer(); ?>
