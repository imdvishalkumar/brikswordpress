<?php get_header(); ?>

	<main role="main">

		<section>

            <div class="wrapper">

			    <article id="post-404">

				    <h1 class="page-title"><?php _e( 'Page not found', 'html5blank' ); ?></h1>

				     <h2>
					    <a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a>
				    </h2>

			    </article>

            </div>

		</section>

	</main>

<?php /*get_sidebar(); */?>

<?php get_footer(); ?>
