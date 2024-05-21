<?php get_header(); ?>

	<main role="main">

            <div class="wrapper">

				<section class="has-sidebar">
					<h1 class="page-title"><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
					<div class="columns">
						<?php get_template_part('loop'); ?>

						<?php get_template_part('pagination'); ?>
					</div>
				</section>

				<?php get_sidebar(); ?>

			</div>

	</main>

<?php get_footer(); ?>
