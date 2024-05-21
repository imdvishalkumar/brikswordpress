<?php /* ALSO UPDATE CODE IN /includes/chat.asp ?>
		<!-- ALIVECHAT MARKUP -->
		<script language="javascript">
			function wsa_include_js(){
				var js = document.createElement('script');
				js.setAttribute('language', 'javascript');
				js.setAttribute('type', 'text/javascript');
				js.setAttribute('src','//www.websitealive5.com/3637/Visitor/vTracker_v2.asp?websiteid=0&groupid=3637');
				document.getElementsByTagName('head').item(0).appendChild(js);
			}
			window.onload = wsa_include_js;
		</script>
		<!-- END ALIVECHAT MARKUP  -->
*/ ?>
<!-- Start WebsiteAlive AliveTracker Code -->
<script type="text/javascript">(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)){ return; }js = d.createElement(s); js.id = id;js.async = true;js.src="//alive5.com/js/a5app.js";js.setAttribute("data-widget_code_id", "150831bd-bc75-4196-b835-fd92e38396cb");fjs.parentNode.insertBefore(js, fjs);}(document, "script", "a5widget"));</script>
<!-- End WebsiteAlive AliveTracker Code -->

<!-- Begin Web-Stat code v 7.0 -->
<span id="wts3375"></span>
<script>
var wts7 = {};
wts7.invisible='yes';
wts7.page_name='<?=preg_replace("/[^A-Za-z0-9 ]/", '', get_the_title());?>';
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

<?php /* old ALIVE chat code removed 12/30/2021
<script type="text/javascript">
function wsa_include_js(){
var wsa_host = (("https:" == document.location.protocol) ? "https://" : "http://");
var js = document.createElement("script");
js.setAttribute("language", "javascript");
js.setAttribute("type", "text/javascript");
js.setAttribute("src",wsa_host + "tracking-v3.websitealive.com/3.0/?objectref=wsa5&groupid=3637&websiteid=0");
document.getElementsByTagName("head").item(0).appendChild(js);
}
if (window.attachEvent) {window.attachEvent("onload", wsa_include_js);}
else if (window.addEventListener) {window.addEventListener("load", wsa_include_js, false);}
else {document.addEventListener("load", wsa_include_js, false);}
</script>*/
?>