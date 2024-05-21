
		<?php if((is_shop() || is_product_category()) && have_rows('footer_content_repeater','options')): echo '<div class="guarantee-copy">'; while(have_rows('footer_content_repeater','options')): the_row(); ?>
		<?php 	$title = get_sub_field('section_title');
				$copy = get_sub_field('section_copy');
				$category = get_sub_field('product_category');
			if(is_product_category($category)): ?>
		<section class="guarantee clear">
			<div class="wrapper">
			<?php if($title): ?><strong><?php echo $title; ?></strong><?php endif; ?>
			<?php if($copy): ?><p><?php echo $copy; ?></p><?php endif; ?>
			</div>
		</section>
		<?php endif; endwhile; echo '</div>'; endif; ?>

		<footer class="footer clear gradient footer-gradient" role="contentinfo">
				<div class="overlay img-fill lazy"
                     data-original="/wp-content/themes/bricksrus/img/bricks-bg.png"
                style="background-image:url(<?php echo create_placeholder_image(1500,524,array(37,37,37,1)); ?>);"></div>
					<div class="wrapper">

						<div class="footer-cta">
							<?php if(get_field('footercta','options')): echo '<span class="white">'.get_field('footercta','options').'</span>'; endif; ?>
							<aside class="newsletter clear">
								<div class="copy">
									<?php if(get_field('newsletter_title','options')): echo '<strong>'.get_field('newsletter_title','options').'</strong>'; endif; ?>
									<?php if(get_field('newsletter_cta','options')): echo '<p>'.get_field('newsletter_cta','options').'</p>'; endif; ?>
								</div>
								<div class="input">
									<label>Email Address</label>
									<?php echo do_shortcode('[mailchimp_newsletter_signup]'); ?>
								</div>
							</aside>
						</div>
<!-- removed footer navigation 9/21/23 -TH
						<nav class="footer" role="navigation">
							<div class="columns">
								<div class="col-7 col"><?php about_nav(); ?></div>
								<div class="col-7 col two-col"><?php product_nav(); ?></div>
								<div class="col-7 col"><?php services_nav(); ?></div>
								<div class="col-odd col"><?php faq_nav(); ?></div>
								<div class="col-7 col"><?php blog_nav(); ?></div>
								<div class="col-7 col"><?php contact_nav(); ?></div>
							</div>
							
							<aside class="phone clear" role="banner">
								<?php $sitename = get_bloginfo('name'); $siteurl = get_bloginfo('url'); if($sitename): echo '<a class="sitename" href="'.$siteurl.'">'.$sitename.'</a>'; endif; ?>
								<?php if(get_field('phone_number','options')): echo '<a class="tel" href="tel:'.get_field('phone_number','options').'"><span>888</span>-MY-BRICK</a><div class="spanish">Hablamos Español</div>'; endif; ?>
							</aside>
						</nav>
-->
					</div>
			</footer>

			<section class="social clear">
				<div class="wrapper">
					<p class="copyright">
						Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved. <!--Designed by <a href="http://kwikturnmedia.com" target="_blank">Kwikturn Media</a>.
						<a href="http://kwikturnmedia.com" target="_blank"><img src="<?php /*echo get_template_directory_uri(); */?>/img/kwikturn.png" /></a>-->
						&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo get_page_link(23); ?>" title="Privacy Policy">Privacy Policy</a>
					</p>
					<?php social_nav(); ?>
				</div>
			</section>
<?php /* old ALIVE chat button replaced 12/30/2021
			<aside class="live-chat fixed">
				<a href="#" class="popup-chat">
					<div class="comment img-fill">
						<div class="circle circle-1"></div>
						<div class="circle circle-2"></div>
						<div class="circle circle-3"></div>
					</div>
					<strong>Have Questions?</strong>
					<span>Chat Live Now!</span>
				</a>
			</aside>
*/ ?>
		<?php if(is_front_page()){ ?>
		<div id="side" class="form">
			<h3>Free Brick Sample</h3>
			<p>Enter your phone and/or e-mail address. We’ll contact you and ship a sample brick right away</p>
			<?php echo do_shortcode('[contact-form-7 id="1902" title="Sample Request Form"]'); ?>
			<?php /* wp_enqueue_script('validate'); */?><!--
			<form id="free-brick-form" action="http://www.bricksrus.com/cgi-bin/freesample.cgi" target="_blank" method="POST">
				<input name="xCommentsx" type="text" id="xCommentsx" value="" style="display:none;">
				<div class="form-group ">
					<input type="text" class="form-control name" placeholder="Enter Your Name" name="name" style="cursor: auto; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;" required>
				</div>
				<div class="form-group ">
					<input type="email" class="form-control email" placeholder="Enter Your Email" name="email">
				</div>
				<div class="form-group ">
					<input type="tel" class="form-control phone" placeholder="Enter Your Phone Number" name="phone">
				</div>
				<div class="form-group">
					<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
					<?php /*do_action( 'recaptcha_print'); */?>
				</div>
				<div class="form-group ">
					<button type="submit" name="Submit2" class="<?php /*if($class) { echo $class; } */?> btn myButton btn-lg btn-sm btn-xs" value="">Get My Free Brick </button>
				</div>
				<input name="xNamex" type="text" id="xNamex" value="" style="visibility: hidden;width:5px; height:0; padding:0; margin:0;">
			</form>
			<script type="text/javascript">
				var $ = jQuery;
				$(window).load(function() {
					if($('#side').size() > 0) {
						$('#free-brick-form').validate({
							ignore: '.ignore',
							rules: {
								email: {
									required: function () {
										if ($('.form-control.email').val() || $('.form-control.phone').val()) {
											return false;
										} else {
											return true;
										}
									}
								},
								phone: {
									required: function () {
										if ($('.form-control.phone').val() || $('.form-control.email').val()) {
											return false;
										} else {
											return true;
										}
									}
								},
								"hiddenRecaptcha": {
									required: function () {
										if (grecaptcha.getResponse() == '') {
											return true;
										} else {
											return false;
										}
									}
								}
							}
						});
					}
				});
			</script>-->
		</div>
		<?php } ?>

		<?php wp_footer(); ?>
        
        
        
        <?php // footer tracking codes for Google Analytics, Google Ads, etc. added by drewadesigns.com on 8/7/2019
			include_once('tracking-footer.php');
		?>



	</body>
</html>
