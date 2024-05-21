<?php if (have_posts()): while (have_posts()) : the_post();
	if(is_search()) {
		if ($post->post_type == 'page'):
			$result = 'Page';
		elseif ($post->post_type == 'product'):
			$result = 'Product';
		else:
			$result = 'Post';
		endif;
	}

	?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('col col-2 blog-style'); ?>>

		<?php 
			$featuredimg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
			$featuredimg_url = $featuredimg ? $featuredimg[0] : ''; // Check if $featuredimg is not false/null, then access its first element
		?>

        <div class="thumbnail img-fill" style="<?php if($result): echo 'background:#AF0E13;'; endif; ?> background-image:url(<?php echo $featuredimg; ?>);">

			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			</a>

			<?php if($result): echo '<span class="page">'.$result.'</span>'; endif; ?>

        </div>

        <div class="content">

			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

				<h2><?php the_title(); ?></h2>
		    	<span class="date"><?php the_time('F j, Y'); ?></span>
				<?php html5wp_excerpt('html5wp_index'); ?>

			</a>

		    <?php edit_post_link(); ?>

          <?php share_icons(); ?>

        </div>

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
