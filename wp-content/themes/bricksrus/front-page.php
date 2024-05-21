<?php get_header(); ?>

	<main role="main">

		<section class="main-content clear">
			<div class="wrapper">
				<?php if(get_field('heading')): echo '<h2>'.get_field('heading').'</h2>'; endif; ?>
				<?php if(get_field('copy')): echo get_field('copy'); endif; ?>
			</div>
		</section>

		<section class="benefits clear">
			<div class="wrapper">
				<?php if(have_rows('benefits_repeater')): ?>
					<div class="columns">
						<?php while(have_rows('benefits_repeater')): the_row();
							$icon = wp_get_attachment_image_src(get_sub_field('benefit_icon'),'full');
							$title = get_sub_field('benefit_title');
							$url = get_sub_field('benefit_url'); ?>
							<div class="col-6 col">
								<?php if($url): ?><a href="<?php echo $url; ?>"><?php endif; ?>
								<img class="lazy" data-original="<?php echo $icon[0]; ?>" src="<?php echo create_placeholder_image(70,70,array(255,255,255,1)); ?>" alt="<?php echo $title; ?>">
								<h3><?php echo $title; ?></h3>
								<?php if($url): ?></a><?php endif; ?>
							</div>
						<?php endwhile; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<section class="video-section clear">
			<div class="wrapper">
				<div class="copy">
					<?php 	if(get_field('video_section_title')): echo '<h2>'.get_field('video_section_title').'</h2>'; endif;
					      	if(get_field('video_section_subheading')): echo '<h3>'.get_field('video_section_subheading').'</h3>'; endif;
							if(get_field('video_section_copy')): echo get_field('video_section_copy'); endif; ?>
				</div>
				<div class="video">
					<?php   $videoid = get_field('video_id');
							$videoplaceholder = wp_get_attachment_image_src(get_field('video_image_placeholder'),'full'); ?>
					<a href="#" class="placeholder colorbox video" data-video="<?php echo $videoid; ?>">
                        <img class="lazy"
                             src="<?php echo create_placeholder_image($videoplaceholder[1],$videoplaceholder[2],array(255,255,255,1)); ?>"
                             data-original="<?php echo $videoplaceholder[0]; ?>"/>
                    </a>
				</div>
			</div>
		</section>

		<section class="past-success clear">
			<div class="wrapper">
				<?php if(get_field('success_section_title')): echo '<h2>'.get_field('success_section_title').'</h2>'; endif; ?>
				<?php if(have_rows('success_repeater')): $x = 1; ?>
				<div id="masonry-container">
					<?php while(have_rows('success_repeater')): the_row();
							$background = wp_get_attachment_image_src(get_sub_field('success_background'),'full');
							$title = get_sub_field('success_title');
							$copy = htmlspecialchars_decode(get_sub_field('success_copy'));
							if(strlen($copy) > 140) {
								$copy = substr($copy, 0, 140).'...';
							}
							$url = get_sub_field('success_url');
							if($x == 1 || $x == 3 || $x == 5) { $size = "large"; } else { $size = "small"; }
						?>
						<div class="box <?php echo $size; ?> img-fill lazy lazy-w-bg"
                             data-original="<?php echo $background[0]; ?>"
                             style="background-image:url(<?php echo create_placeholder_image($background[1],$background[2],array(255,255,255,1)); ?>);">
							<div class="content">
								<div class="valign">
								<?php if($url): echo '<a href="'.home_url().''.$url.'">'; endif; ?>
								<?php if($title): echo '<h3>'.$title.'</h3>'; endif; ?>
								<?php if($copy): echo $copy; endif; ?>
								<span>Read Full Story</span>
								<?php if($url): echo '</a>'; endif; ?>
								</div>
							</div>
						</div>
					<?php $x++; endwhile; ?>
				</div>
				<?php endif; ?>
				<?php if(get_field('success_section_button_text')): echo '<a class="button" href="'.get_field('success_section_button_url').'">'.get_field('success_section_button_text').'</a>'; endif; ?>
			</div>
		</section>

		<section class="latest-blogs clear">
			<div class="wrapper">
				<?php if(get_field('blog_section_title')): echo '<h2>'.get_field('blog_section_title').'</h2>'; endif; ?>
				<div class="columns">
					<?php latestposts(3); ?>
				</div>
				<?php if(get_field('blog_archive_text',5)): echo '<a class="button" href="'.get_field('blog_archive_url',5).'">'.get_field('blog_archive_text',5).'</a>'; endif; ?>
			</div>
		</section>

	</main>

<?php get_footer(); ?>
