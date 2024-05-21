<?php

/* Template Name: Generic Landing */

get_header('landing');


?>

	<main role="main" class="clear" itemscope="" itemtype="//schema.org/WebPage">

		<?php if(get_field('show_free_sample_form')){
			wp_enqueue_script('validate'); ?>
			<section class="sample-form center">
				<div class="wrapper">
					<a id="freesample"></a>
					<span class="text-red"><?php the_field('sample_text_top'); ?></span>
					<span class="text-black"><?php the_field('sample_text_bottom'); ?></span>
					<form action="//www.bricksrus.com/cgi-bin/freesample.cgi" target="_blank" class="customform" method="POST">
						<input name="xCommentsx" type="text" id="xCommentsx" value="" style="display:none;">
						<div class="form-group ">
							<input type="text" class="form-control" placeholder="Enter Your Name" required="required" name="name" style="cursor: auto; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
						</div>
						<div class="form-group ">
							<input type="email" class="form-control" placeholder="Enter Your Email" required="required" name="email">
						</div>
						<div class="form-group ">
							<input type="tel" class="form-control" placeholder="Enter Your Phone Number" name="phone">
						</div>
						<div class="form-group recaptcha">
							<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
							<?php do_action( 'recaptcha_print'); ?>
						</div>
						<div class="form-group ">
							<button type="submit" name="Submit2" class="button btn myButton btn-lg btn-sm btn-xs" value="">Get My Free Brick </button>
						</div>
						<input name="xNamex" type="text" id="xNamex" value="" style="visibility: hidden;width:5px; height:0; padding:0; margin:0;">
					</form>
				</div>
			</section>
		<?php } ?>

		<?php if(have_rows('list_one')) {
			$listicon = wp_get_attachment_image_src(get_field('list_one_icon'),'full')[0]; ?>
			<section class="list list-one offwhite clear">
				<div class="wrapper">
					<h2 class="section-title"><?php the_field('list_one_title'); ?></h2>
					<ul>
					<?php while(have_rows('list_one')){ the_row(); ?>
						<li><img src="<?php echo $listicon; ?>"><?php the_sub_field('list_item'); ?></li>
					<?php } ?>
					</ul>
				</div>
			</section>
		<?php } ?>

		<?php if(get_field('content')) { ?>
			<section class="content-main offwhite clear section-padding">
				<div class="wrapper">
					<p><?php the_field('content'); ?></p>
				</div>
			</section>
		<?php } ?>

		<?php if(get_field('testimonial_copy')){
			$background = wp_get_attachment_image_src(get_field('testimonial_background'),'full')[0]; ?>
			<section class="testimonials img-fill center" style="background-image:url(<?php echo $background; ?>);">
				<div class="wrapper">
					<em><?php the_field('testimonial_copy'); ?></em>
				</div>
			</section>
		<?php } ?>

		<?php if(have_rows('list_two')){
			$listicon = wp_get_attachment_image_src(get_field('list_two_icon'),'full')[0]; ?>
			<section class="list list-two clear">
				<div class="wrapper">
					<h2 class="section-title"><?php the_field('list_two_title'); ?></h2>
					<ul>
					<?php while(have_rows('list_two')){ the_row(); ?>
						<li><img src="<?php echo $listicon; ?>"><?php the_sub_field('list_item'); ?></li>
					<?php } ?>
					</ul>
				</div>
			</section>
		<?php } ?>

		<?php if(get_field('additional_copy')){ ?>
			<section class="content-additional offwhite center clear section-padding">
				<div class="wrapper">
					<p><?php the_field('additional_copy'); ?></p>
				</div>
			</section>
		<?php } ?>

		<?php if(have_rows('additional_links')){ ?>
			<section class="additional-links section-padding">
				<div class="wrapper">
					<h2 class="section-title"><?php the_field('additional_links_title'); ?></h2>
					<div class="columns">
						<?php while(have_rows('additional_links')){ the_row();
							$category = wp_get_attachment_image_src(get_sub_field('link_image'),'full')[0];
							if(get_sub_field('outside_url')){
								$link = get_sub_field('outside_link');
							} else {
								$link = get_sub_field('link_url');
							}?>
							<aside class="category col col-4">
								<?php if($link){ ?><a href="<?php echo $link; ?>"><?php } ?>
								<figure class="image img-fill" style="background-image:url(<?php echo $category; ?>);">
									<div class="hidden">
										<strong><?php the_sub_field('link_title'); ?></strong>
									</div>
								</figure>
								<figcaption><strong><?php the_sub_field('link_title'); ?></strong></figcaption>
								<?php if($link){ ?></a><?php } ?>
							</aside>
						<?php } ?>
					</div>
					<?php if(get_field('button_cta')){ ?>
						<a href="<?php the_field('button_url'); ?>" class="button" target="_blank"><?php the_field('button_cta'); ?></a>
					<?php } ?>
				</div>
			</section>
		<?php } ?>

	</main>


<?php get_footer('landing'); ?>
