<?php get_header(); ?>

	<main role="main" class="clear main-blog">

		<div class="wrapper">

			<section class="has-sidebar">

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<?php $featuredimg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large')[0]; ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            	<div class="copy">

					<div class="meta-content clear">
						<div class="thumbnail img-fill" style="background-image:url(<?php echo $featuredimg; ?>);">
						</div>

						<div class="blog-title">
							<?php share_icons(); ?>
			     			<h1 class="page-title"><?php the_title(); ?></h1>
			    			<span class="date"><?php the_time('F j, Y'); ?> </span>

						</div>
					</div>

					<?php the_content(); // Dynamic Content ?>

			    	<?php edit_post_link(); // Always handy to have Edit Post Links available ?>

			    	<?php comments_template(); ?>

            	</div>

			</article>

			<?php endwhile; else: ?>

			<article><h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1></article>

			<?php endif; ?>

			</section>

			<?php get_sidebar(); ?>

		</div>

	</main>

<?php get_footer(); ?>
