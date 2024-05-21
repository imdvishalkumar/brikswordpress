<?php get_header(); ?>

<main role="main" class="clear main-blog">

	<div class="wrapper">

		<section class="has-sidebar">

			<h1 class="page-title"><?php _e( 'Archives', 'html5blank' ); ?></h1>

			<div class="columns"><?php get_template_part('loop'); ?></div>

			<?php get_template_part('pagination'); ?>

		</section>

		<?php get_sidebar(); ?>

	</div>

</main>


<?php get_footer(); ?>
