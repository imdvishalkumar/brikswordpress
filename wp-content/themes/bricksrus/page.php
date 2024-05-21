<?php get_header(); ?>

	<main role="main" class="clear" itemscope="" itemtype="http://schema.org/WebPage">
		<!-- section -->
		<section class="interior">

            <div class="wrapper">

			<?php alternate_title(); ?>
			<?php subheading(); ?>
			<?php featured_image(); ?>

				<?php if(get_the_ID() == 451){ call_to_action(); } ?>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>
			<?php if(get_the_ID() != 451){ call_to_action(); } ?>
            </div>

		</section>
		<!-- /section -->
	</main>


<?php get_footer(); ?>
