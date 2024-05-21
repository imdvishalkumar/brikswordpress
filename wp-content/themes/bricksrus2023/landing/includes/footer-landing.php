

		<footer class="footer" role="contentinfo">
			<div class="wrapper">
				<div class="logo">
					<a href="/">
						<img src="https://www.bricksrus.com/wp-content/themes/bricksrus2023/landing/includes/img/logo.png" alt="Bricks R Us Logo" class="logo-img">
					</a>
				</div>
				<div class="phone">
					<a class="tel" href="tel:7863615925"><?php echo get_field('phone_number'); ?></a>
				</div>
			</div>
		</footer>



		<div id="side" class="form">
			<h3><?php echo get_field('free_brick_sample'); ?></h3>
			<script type="text/javascript">
				function verifyFreeSample(f) {
					var msg = '';

					if (f.phone.value == '' && f.email.value == '') { msg = 'Please enter either your phone or e-mail.'; f.phone.focus(); }
					else if (f.phone.value != '') {
						var validphone = f.phone.value;
						validphone = validphone.replace(/[^0-9]/gi, "");
						if (validphone.length < 10) { msg = 'Please enter a valid phone number, including area code.'; f.phone.focus(); }
					}
					else if (f.email.value != '') {
						if (f.email.value.indexOf('@') == -1) { msg = 'Please enter a valid e-mail address.'; f.email.focus(); }
						else if (f.email.value.indexOf('.') == -1) { msg = 'Please enter a valid e-mail address.'; f.email.focus(); }
					}
					if (msg != '') {
						alert(msg);
						return false;
					}
				}
			</script>
		</div>



		<?php //WEBSTAT MARKUP ?>
        <!-- Begin Web-Stat code v 7.0 -->
        <span id="wts3375"></span>
        <script>
        var wts7 = {};
        wts7.invisible='yes';
        wts7.page_name='<?=preg_replace("/[^A-Za-z0-9 ]/", '', $page_title);?>';
        wts7.group_name='';
        wts7.conversion_number='';
        wts7.user_id='';
        var wts=document.createElement('script');wts.async=true;
        wts.src='https://app.ardalio.com/log7.js';document.head.appendChild(wts);
        wts.onload = function(){ wtslog7(3375,2); };
        </script><noscript><a href="https://www.web-stat.com">
        <img src="https://app.ardalio.com/7/2/3375.png" 
        alt="Web-Stat analytics"></a></noscript>
        <!-- End Web-Stat code v 7.0 -->
        <?php //END WEBSTAT MARKUP ?>
        

		
		<?php wp_footer(); ?>
        
        
        
        <?php // footer tracking codes for Google Analytics, Google Ads, etc. added by drewadesigns.com on 8/7/2019
			include_once(get_template_directory() . '/tracking-footer.php');
		?>



	</body>
</html>
