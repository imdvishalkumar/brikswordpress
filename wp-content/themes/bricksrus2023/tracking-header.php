        </script>
        
        <!-- Global site tag (gtag.js) - Google Ads: 1071447394 + Google Analytics G4A 268106025 - added by drewadesigns.com on 4/17/2023 -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-L9V8NRR6RM"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'G-L9V8NRR6RM'); /* Google Analytics */
          gtag('config', 'AW-1071447394'); /* Google Ads */


			/* Google Ads conversion tracking - linked to successful Contact Form 7 submission events - added by drewadesigns.com on 8/7/2019 */
            /* JavaScript */
			/* Changes to this (or any site-wide header code should also be made in header-landing.php */
			document.addEventListener( 'wpcf7mailsent', function( event ) {
				/*console.log(event.detail.contactFormId);*/
				/*alert(event.detail.contactFormId);*/
				if ('1902' == event.detail.contactFormId) 		gtag('event', 'conversion', {'send_to': 'AW-1071447394/miCTCO2npqcBEOL68_4D'}); /* Free Sample Brick */
				else if ('209' == event.detail.contactFormId) 	gtag('event', 'conversion', {'send_to': 'AW-1071447394/d9NyCPynpqcBEOL68_4D'}); /* Information & Sample Request */
				else if ('211' == event.detail.contactFormId) 	gtag('event', 'conversion', {'send_to': 'AW-1071447394/7RiXCP-npqcBEOL68_4D'}); /* Callback Request */
				else if ('373' == event.detail.contactFormId) 	gtag('event', 'conversion', {'send_to': 'AW-1071447394/WUXwCOj_pqcBEOL68_4D'}); /* Order One Brick */
                else if ('2829' == event.detail.contactFormId) 	gtag('event', 'conversion', {'send_to': 'AW-1071447394/33IiCIzJRhDi-vP-Aw'}); /* All Landing Pages */
			}, false );	