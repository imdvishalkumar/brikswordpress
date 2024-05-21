<section class="sample-form center">
    <div class="wrapper">
        <div class="form-validation" style="display:none;">
            <?php
            if(isset($_POST['g-recaptcha-response'])) {

                $is_ajax = isset($_POST['ajax']);
                $captcha = $_POST['g-recaptcha-response'];
                $privatekey = "6LcFTRETAAAAADVnYncL6D84KHuXmw-TJCZaVbAJ";
                $server = $_SERVER['HTTP_HOST'];
                $uri = $_SERVER['REQUEST_URI'];

                $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret='.$privatekey.'&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
                $obj = json_decode($response);

                if ($obj && $obj->{'success'} == false) {


                    $msg = '<div class="error-message"><h2>The reCAPTCHA was not entered correctly! Please try again.</h2></div>';
                    if($is_ajax) {
                        echo 'false';
                        exit;
                    }

                } else {

                    extract($_POST);
                    $url = 'http://www.bricksrus.com/cgi-bin/freesample.cgi';

                    $myvars = array();
                    $myvars['name'] = $name;
                    $myvars['email'] = $email;
                    $myvars['phone'] = $phone;
                    $myvars['organization'] = $organization;

                    foreach($myvars as $key=>$value) { $myvars_string .= $key.'='.$value.'&'; }
                    rtrim($myvars_string, '&');

                    $ch = curl_init( $url );
                    curl_setopt( $ch, CURLOPT_POST, true);
                    curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars_string);
                    curl_setopt( $ch, CURLOPT_REFERER, 'http://'.$server.$uri );

                    ob_start();
                    $response = curl_exec( $ch );
                    ob_get_clean();

                    curl_close($ch);

                    if(isset($_POST['mailchimp-signup']) && !empty($_POST['mailchimp-signup']) && $_POST['mailchimp-signup'] == 'signup'){

                        require_once 'Mailchimp.php';
                        $api = new \Drewm\Mailchimp('5c68fea42251eb7214ebf30b4c8d2fc5-us3');
                        $result = $api->call('lists/subscribe',array(
                            'id' => '3d3c85ab1c',
                            'email'=>array('email'=>$_POST['email']),
                            'update_existing'=>true,
                            'send_welcome'=>false,
                        ));

                        if ($result['error']){
                            $msg = '<div class="error-message"><h2>Newsletter Signup failed. Please try again.</h2></div>'.var_dump($api->errorCode);
                        } else {
                            $msg = '<div class="error-message success"><h2>Thank you for your submission and signing up for our newsletter! You should hear back from us shortly</h2></div>';
                        }

                    } else {

                        $msg = '<div class="error-message success"><h2>Thank you for your submission. You should hear back from us shortly.</h2></div>';

                    }

                }
            }
            ?>
        </div>
        <a id="freesample"></a>
        <span class="text-red"><?php if($formtitle){ echo $formtitle; } else { ?> Free Sample Brick <?php } ?></span>
        <?php if($formcopy){  echo $formcopy; } else { ?>
            <span class="text-black">We Will Ship Your Brick Within 24 Hours</span>
        <?php } ?>

        <form onsubmit="return verifyFreeSample(this);" action="?" target="_blank" method="POST">
            <input name="xCommentsx" type="text" id="xCommentsx" value="" style="display:none;">
            <div class="form-group ">
                <input type="text" class="form-control" placeholder="Enter Your Name" required="required" name="name" style="cursor: auto; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==); background-attachment: scroll; background-position: 100% 50%; background-repeat: no-repeat;">
            </div>
            <div class="form-group ">
                <input type="email" class="form-control" placeholder="Enter Your Email" required="required" name="email">
            </div>
            <div class="form-group ">
                <input type="text" class="form-control" placeholder="Enter Your Phone Number" name="phone">
            </div>
            <div class="form-group ">
                <input type="text" class="form-control" placeholder="Enter Your Organization" name="organization">
            </div>
            <div class="form-group" style="margin:.5em auto 1em;">
                <input type="checkbox" class="form-control" checked="checked" name="mailchimp-signup" style="width:10%; margin-right:5px; outline:0; border:none;" value="signup">Sign Up for Bricks R Us Newsletter
            </div>
            <div class="form-group ">
                <?php //if($msg){ echo $msg; } ?>
                <div class="g-recaptcha" data-sitekey="6LcFTRETAAAAAF7ao7VTP5xWdLVUtvfP_ROYEqjS"></div>
                <button type="submit" name="Submit2" onclick="dataLayer.push({'event':'Submit2-click'});" class="button btn myButton btn-lg btn-sm btn-xs" value=""><?php if($formtitle){ echo $formtitle; } else { ?> Get My Free Brick <?php } ?></button>
            </div>
            <input name="xNamex" type="text" id="xNamex" value="" style="visibility: hidden;width:5px; height:0; padding:0; margin:0;">
        </form>
    </div>
</section>