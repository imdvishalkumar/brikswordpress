

		<footer class="footer" role="contentinfo">
			<div class="wrapper">
				<div class="logo">
					<a href="/">
						<img src="<?php echo get_field('logo'); ?>" alt="Bricks R Us Logo" class="logo-img">
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
		<span id="wts3375"></span><script type="text/javascript">
			var wtsh = {};
			wtsh['invisible']='yes';
			wtsh['page_name']='<?php echo $page_title; ?>';
			wtsh['custom']='#';
			var wts=document.createElement('script');wts.type='text/javascript';
			wts.async=true;wts.src='//server3.web-stat.com/2/3375/log6.js';
			document.getElementById('wts3375').appendChild(wts);
		</script><noscript><a href="//www.web-stat.net">
				<img src="//server3.web-stat.com/6/2/3375.gif"
				     style="border:0px;" alt=""></a></noscript>
		<?php //END WEBSTAT MARKUP ?>
        

		
		<?php wp_footer(); ?>
        
        
        
        <?php // footer tracking codes for Google Analytics, Google Ads, etc. added by drewadesigns.com on 8/7/2019
			include_once(get_template_directory() . '/tracking-footer.php');
		?>



	</body>
</html>
