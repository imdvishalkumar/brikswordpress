<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

//ACF PRO OPTIONS PAGES
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Website Settings',
        'menu_title'    => 'General Settings',
        'menu_slug'     => 'general-settings',
        'capability'    => 'edit_posts',
        'redirect'      =>  false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Company Information',
        'menu_title'    => 'Company Information',
        'parent_slug'   => 'general-settings',
    ));

}

// SHARE FUNCTION
function share_icons() {

    $shareimage = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()),'medium')[0];

    echo '<div class="share-page">';
    echo '<ul class="share">';
    echo    '<li class="tab">Share <i class="fa fa-share"></i></li>';
    echo    '<li><a href="http://www.facebook.com/sharer.php?u='.get_permalink().'" target="_blank" title="Share on Facebook!"><i class="fa fa-facebook"></i></a></li>'; // FACEBOOK SHARE
    echo    '<li><a href="http://www.twitter.com/share?url='.get_permalink().'&text='.get_the_title().'" target="_blank" title="Share on Twitter!"><i class="fa fa-twitter"></i></a></li>'; // TWITTER SHARE
    echo    '<li><a href="https://plus.google.com/share?url='.get_permalink().'" target="_blank" title="Share on Google Plus"><i class="fa fa-google-plus"></i></a></li>'; // GOOGLE PLUS SHARE
    echo    '<li><a title="Share on Pinterest" onclick=\'window.open("http://www.pinterest.com/pin/create/button/?url='.get_permalink().'&description='.get_the_title().'&media='.$shareimage.'","Pin It","width=300,height=300,top=0,left=100");\'><i class="fa fa-pinterest"></i></a></li>'; // PINTEREST SHARE (BY FEATURED IMAGE URL)
    echo    '<li><a title="Share By Email" href="mailto:?Subject='.get_the_title().'&Body=I%20saw%20this%20and%20thought%20of%20you!%20 '.get_permalink().'"><i class="fa fa-envelope-o"></i></a></li>'; // EMAIL SHARE
    echo '</ul>';
    echo '</div>';
}
add_action('share_code','share_icons');


//COMPANY INFORMATION SHORTCODE
function company_info() {

    ob_start();

    $address1 = get_field('address_line_1','option');
    $address2 = get_field('address_line_2','option');
    $phone = get_field('phone_number','option');
    $phone2 = get_field('phone_number_2','option');
    $email = get_field('email_address','option');
    $fax = get_field('fax_number','option');

    echo '<address>';
    if($address1 && $address2): echo '<span class="address">'.$address1.'<br/>'.$address2.'</span>'; endif;
    if($phone): echo '<span class="phone"><a href="tel:'.$phone.'">888-MY-BRICK</a></span>'; endif;
    if($phone2): echo '<span class="phone"><a href=tel:'.$phone2.'">'.$phone2.'</a></span>'; endif;
    if($email): echo '<span class="email"><a href="mailto:'.$email.'">'.$email.'</a></span>'; endif;
    if($fax): echo '<span class="fax">'.$fax.'</span>'; endif;
    echo '</address>';

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('address','company_info');

// CUSTOM WP LOGIN
function custom_login_logo() {
    echo '<style type="text/css">
    h1 a { background-image: url('.get_bloginfo('template_directory').'/img/logo.png) !important; width:100% !important; background-size:70% !important; height:100px !important; background-position:center center !important; }
    .login {background-color:#FFFFFF; }
    </style>';
}
add_action('login_head', 'custom_login_logo');

// ALLOWS SVG UPLOAD
function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );


function social_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'social-menu', 'items_wrap' => '<ul class="social-menu">%3$s</ul>',));
}
function footer_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'footer-menu',));
}
function mobile_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'mobile-menu',));
}
/* FOOTER NAVIGATION */
function about_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'about-menu',));
}
function services_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'services-menu',));
}
function product_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'products-menu',));
}
function fundraising_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'fundraising-menu',));
}
function faq_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'faq-menu',));
}
function blog_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'blog-menu',));
}
function contact_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'contact-menu',));
}
function extra_nav()
{
    wp_nav_menu( array( 'theme_location'  => 'extra-menu',));
}
/* END FOOTER NAVIGATION */

// HTML5 Blank navigation
function html5blank_nav()
{
    wp_nav_menu(
        array(
            'theme_location'  => 'header-menu',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => 'menu-{menu slug}-container',
            'container_id'    => '',
            'menu_class'      => 'menu',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul>%3$s</ul>',
            'depth'           => 0,
            'walker'          => ''
        )
    );
}

add_action('wpcf7_init','add_source_url');

function add_source_url(){
    wpcf7_add_form_tag('sourceurl','source_url_handler');
}
function source_url_handler(){
    return '<input type="hidden" name="thesource" value="http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'"/>';
}


// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'social-menu' => __('Social Menu', 'html5blank'), // Social Menu
        'mobile-menu' => __('Mobile Menu', 'html5blank'), // Mobile Menu
        'footer-menu' => __('Footer Menu', 'html5blank'), // Footer Menu
        'about-menu' => __('About Menu', 'html5blank'), // Footer Menu
        'services-menu' => __('Services Menu', 'html5blank'), // Footer Menu
        'products-menu' => __('Products Menu', 'html5blank'), // Footer Menu
        'fundraising-menu' => __('Fundraising Menu', 'html5blank'), // Footer Menu
        'faq-menu' => __('FAQ Menu', 'html5blank'), // Footer Menu
        'blog-menu' => __('Blog Menu', 'html5blank'), // Footer Menu
        'contact-menu' => __('Contact Menu', 'html5blank'), // Footer Menu
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}


// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.min.js', array(), filemtime(get_template_directory().'/js/scripts.min.js'),true); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!

        wp_register_script('validate', '//ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js#asyncload', array('jquery'), '1.14',true); //VALIDATION

        wp_register_script('slick', get_template_directory_uri() . '/js/lib/slick/slick.min.js', array(), '1.5.9',true); // Placeholder
        wp_register_style('slick-css', get_template_directory_uri() . '/js/lib/slick/slick.css', array(), '1.5.9', 'all');

        wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit#asyncload', array('jquery'), '1.0',true); //Recaptcha

        wp_register_script('prettyPhotonew', get_template_directory_uri() . '/js/lib/jquery.prettyPhoto.min.js', array('jquery'), '1.0.0',true);
        wp_register_script('prettyPhotonew-init', get_template_directory_uri() . '/js/lib/jquery.prettyPhoto.init.min.js', array('jquery'), '1.0.0',true);
        wp_register_style('prettyPhotonewStyle', get_template_directory_uri(). '/sass/prettyPhoto.css', array(), '1.0','all');
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    wp_register_script('colorbox', get_template_directory_uri() . '/js/lib/jquery.colorbox-min.js', array('jquery'), '1.0.0', true); // Colorbox
    wp_enqueue_script('colorbox');
    if(is_front_page() || is_page(132) || is_page(547)){

        wp_enqueue_script('colorbox'); // Enqueue it!

        wp_register_script('masonry', get_template_directory_uri() . '/js/lib/masonry.pkgd.min.js', array(), '1.0.0',true); // Masonry
        wp_enqueue_script('masonry'); // Enqueue it!
    }
    if(is_page(160)){
        wp_register_script('masonry', get_template_directory_uri() . '/js/lib/masonry.pkgd.min.js', array('jquery'), '1.0.0',true); // Masonry
        wp_enqueue_script('masonry'); // Enqueue it!
    }

    if(!is_woocommerce()){

        wp_dequeue_script('flexslider');
        wp_dequeue_script('js-cookie');
        wp_dequeue_script('jquery-blockui');
        wp_dequeue_script('jquery-cookie');
        wp_dequeue_script('jquery-payment');
        wp_dequeue_script('photoswipe');
        wp_dequeue_script('photoswipe-ui-default');
        wp_dequeue_script('prettyPhoto');
        wp_dequeue_script('prettyPhoto-init');
        wp_dequeue_script('select2');
        wp_dequeue_script('wc-address-i18n');
        wp_dequeue_script('wc-add-payment-method');
        wp_dequeue_script('wc-cart');
        wp_dequeue_script('wc-cart-fragments');
        wp_dequeue_script('wc-checkout');
        wp_dequeue_script('wc-country-select');
        wp_dequeue_script('wc-credit-card-form');
        wp_dequeue_script('wc-add-to-cart');
        wp_dequeue_script('wc-add-to-cart-variation');
        wp_dequeue_script('wc-geolocation');
        wp_dequeue_script('wc-lost-password');
        wp_dequeue_script('wc-password-strength-meter');
        wp_dequeue_script('wc-single-product');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('zoom');

        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
    }

    if(is_front_page()){
        wp_dequeue_style('html5blank');
        wp_dequeue_style('fontawesome');
        wp_dequeue_style('googlefonts');
        add_filter( 'wpcf7_load_css', '__return_false' );
        wp_dequeue_script('imagesloaded');

        wp_dequeue_script('jquery-blockui');
    }


    wp_dequeue_script('dsq_count_script');
    wp_dequeue_script('comment-reply');



    if(is_woocommerce()){
        if(wp_script_is('prettyPhoto','enqueued')) {
            wp_deregister_script('prettyPhoto');
            wp_dequeue_script('prettyPhoto');
            wp_enqueue_script('prettyPhotonew-init');
            wp_enqueue_style('prettyPhotonewStyle');
            wp_enqueue_script('prettyPhotonew');
        } else {
            wp_enqueue_script('prettyPhotonew-init');
            wp_enqueue_style('prettyPhotonewStyle');
            wp_enqueue_script('prettyPhotonew');
        }
    };

}



if(!is_woocommerce()){
    add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}



// Load HTML5 Blank styles
function html5blank_styles()
{

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory().'/style.css'), 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!

    wp_register_style('fontawesome', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css', array(), '4.2', 'all');
    wp_enqueue_style('fontawesome'); // Enqueue it!

    wp_register_style('googlefonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), '1.0.0', 'all');
    //wp_enqueue_style('googlefonts'); // Enqueue it!

}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

//ASYNC JSCRIPT LOADING


function add_async_forscript($url)
{
    if (strpos($url, '#asyncload')===false)
        return $url;
    else if (is_admin())
        return str_replace('#asyncload', '', $url);
    else
        return str_replace('#asyncload', '', $url)."' defer async='async";
}
add_filter('clean_url', 'add_async_forscript', 11, 1);

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
		//added isset() check and fallback by drewadesigns.com on 1/18/2021		
        (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) ? $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] : null),
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 19;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

function product_length($length){
    return 120;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

function html5wp_prodexcerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . strip_tags($output) . '</p>';
    echo $output;
}


// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
<?php endif; ?>
    <div class="comment-author vcard">
        <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
        <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
    <?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
    <br />
<?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
            <?php
            printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
        <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
/*add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type*/
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
            'labels' => array(
                'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
                'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
                'add_new' => __('Add New', 'html5blank'),
                'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
                'edit' => __('Edit', 'html5blank'),
                'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
                'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
                'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
                'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
                'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
                'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
                'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
            ),
            'public' => true,
            'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard Custom HTML5 Blank post for supports
            'can_export' => true, // Allows export in Tools > Export
            'taxonomies' => array(
                'post_tag',
                'category'
            ) // Add Category and Post Tags support
        ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

function alternate_title(){

    $title = get_the_title();
    $alternatetitle = get_field('alternate_header');

    if(is_woocommerce()){ $class = "product_title entry-title"; } else { $class = "page-title"; }
    if(!$alternatetitle) {
        echo '<h1 itemprop="name" class="'.$class.'">' . $title . '</h1>';
    } else {
        echo '<h1 itemprop="name" class="'.$class.'">'.$alternatetitle.'</h1>';
    }
} // ALTERNATE PAGE TITLES

function featured_image(){
    if(has_post_thumbnail() && get_field('show_image_on_page')){
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full')[0];
        echo '<img class="featured-image-display" src="'.$image.'" alt="'.get_the_title().'"/>';
    }
}

function archive_heading(){
    if (is_shop()) {
        $title = get_field('alternate_heading', 'options');
        if($title) {
            echo '<h1 itemprop="name" class="page-title">' . $title . '</h1>';
        } else {
            echo '<h1 itemprop="name" class="page-title">Shop</h1>';
        }
    } elseif (!is_shop() && is_woocommerce()) {
        $rows = get_field('category_heading','options');
        $match = get_queried_object()->term_id;
        foreach($rows as $row){
            if($row['category'] == $match){
                $title = $row['title'];
                echo '<h1 itemprop="name" class="page-title">' . $title . '</h1>';
            }
        }
    } else {
        $title = get_field('blog_heading', 'options');
        if($title) {
            echo '<h1 itemprop="name" class="page-title">' . $title . '</h1>';
        } else {
            echo '<h1 itemprop="name" class="page-title">Latest Posts</h1>';
        }
    }


}

add_action('woocommerce_before_single_product_summary','share_icons',3);
/*add_action('woocommerce_after_shop_loop_item','share_icons',15);*/

function subheading() {
    $subheading = get_field('subheading');
    if($subheading) {
        echo '<h2>'.$subheading.'</h2>';
    }
} // ADD SUBTITLES TO PAGE TITLES

// HOME URL Shortcode
add_shortcode("home_url",function(){
    return home_url();
});

function call_to_action(){
    if(get_field('call_to_action')){
        if(get_field('outside_url')){
            $link = get_field('outside_url');
        } else {
            $link = get_field('button_url_cta');
        }
        $text = get_field('button_text_cta');
        echo '<section class="page-cta clear"><a href="'.$link.'" class="button clear" target="_blank" title="'.$text.'">'.$text.'</a></section>';
    }
}

function banner(){
	// updated to resolve Countable warning on null values on 7/15/2021 by drewadesigns.com
	if (is_array(get_field('banner_slider'))) $count = count(get_field('banner_slider')); else $count = 0;
    $slider = false;
    if($count > 1): $slider = true; endif;
    if($slider): wp_enqueue_script('slick'); wp_enqueue_style('slick-css'); endif;



	if (is_front_page() && ('8.19.206.19000' == $_SERVER['REMOTE_ADDR'] || '67.11.195.14666' == $_SERVER['REMOTE_ADDR'] || 20199 == date('Y'))) { /* added to accomodate 30th anniversary background animation by drewadesigns on 12/20/2018 */ ?>
    	<div id="30thannivanimbg" style="position: absolute; top:25px; left: 0; z-index: 1; width: 50%; max-width: 800px; height: 800px; background-repeat: no-repeat; background-size: contain; background-position: top left; background-image:url(https://www.bricksrus.com/wp-content/uploads/2018/12/3.gif);">
        <a href="#" class="button sample-brick-form cboxElement" style="margin-top: 290px;padding-bottom:130px;opacity:0;">Request Free Sample Brick</a>
        </div>
        <div id="30thannivanimbgright" style="position: absolute; top:25px; right: 0; z-index: 1; width: 50%; max-width: 800px; height: 800px; background-repeat: no-repeat; background-size: contain; background-position: top left; background-image:url(https://www.bricksrus.com/wp-content/uploads/2018/12/3.gif); -moz-transform: scaleX(-1); -o-transform: scaleX(-1); -webkit-transform: scaleX(-1); transform: scaleX(-1); filter: FlipH; -ms-filter: "FlipH";">
        <a href="#" class="button sample-brick-form cboxElement" style="margin-top: 290px;padding-bottom:130px;opacity:0;">Request Free Sample Brick</a>
        </div>
        
    <? }



    if(have_rows('banner_slider')){ ?>    	
        <section class="banner img-fill clear" style="background-image:url(<?php echo get_template_directory_uri().'/img/banner-bg.jpg'; ?>);">
        <div class="<?php if($slider){ ?>home-page-slider <?php } ?> home-page-slider-inactive">
        <?php while(have_rows('banner_slider')){
                the_row();
                $featured = get_sub_field('use_featured_as_bg');
                $image_only = get_sub_field('is_image_only');
                $image = wp_get_attachment_image_src(get_sub_field('image'),'full');
                if($featured): $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full'); endif;
                $alt = get_post_meta($image[0],'_wp_get_attachment_image_alt',true);
                $cta = get_sub_field('banner_cta');
                $title = get_sub_field('banner_title'); ?>
              <div class="content-container slide<?php if($image && !$image_only): ?> img-fill" style="background-image:url(<?php echo $image[0]; ?>); <?php endif; ?>">
                   <?php if(($cta || $title) && !$image_only): ?>
                       <div class="absolute">
                    <div class="content valign">
                        <?php if($title): echo $title; endif; ?>
                        <?php if($cta): echo $cta; endif; ?>
                    </div>
                           </div>
                    <?php else : ?>
                        <img src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>"/>
                    <?php  endif; ?>
                </div>
        <?php } ?>
            </div>
        </section>
    <?php }
}

function testimonials_repeater(){
    ob_start();

    if(have_rows('testimonials')):
        echo '<div id="masonry-container" class="columns testimonials">';
        while(have_rows('testimonials')): the_row();
            $copy = get_sub_field('testimonial');
            $name = get_sub_field('customer_name');
            $location = get_sub_field('customer_location');
            $address = get_sub_field('customer_address');
            $test_id = get_sub_field('testimonial_id'); ?>
            <div class="col col-2 box">
                <?php if($test_id){ ?><a id="<?php echo $test_id; ?>"></a><?php } ?>
                <div class="testimonial">
                <p>"<?php if($copy): echo $copy; endif; ?>"</p>
                <?php if($name): echo '<span class="name">'.$name.'</span>'; endif; ?>
                <?php if($location): echo '<span class="location">'.$location.'</span>'; endif; ?>
                <?php if($address): echo '<span class="address">'.$address.'</span>'; endif; ?>
                </div>
            </div>
       <?php endwhile;
        echo '</div>';
    endif;

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('testimonials','testimonials_repeater');

function latestposts($numberofposts){

    $args = array('post_type'=>'post', 'posts_per_page'=>$numberofposts, 'orderby'=>'date', 'order'=>'DESC');
    $latestposts = new WP_Query($args);

    if ($latestposts->have_posts()): while ($latestposts->have_posts()) : $latestposts->the_post();

        $featuredimg = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()),'medium');  ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('col-3 col blog-style'); ?>>

            <div class="thumbnail img-fill lazy"
                 data-original="<?php echo $featuredimg[0]; ?>"
                 style="background-image:url(<?php echo create_placeholder_image($featuredimg[1],$featuredimg[2],array(255,255,255,1)); ?>);">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                </a>
            </div>
            <div class="content">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <h3><?php the_title(); ?></h3>
                <span class="date"><?php the_time('F j, Y'); ?></span>
                </a>
                <?php html5wp_excerpt('html5wp_index'); ?>


                <?php edit_post_link(); ?>
                <?php share_icons(); ?>
            </div>


        </article>

    <?php endwhile; else: ?>

        <article>
            <h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>
        </article>

     <?php wp_reset_query(); endif;
} //DISPLAY LATEST POSTS

function faq_content(){
    ob_start();

    if(have_rows('faq')):
        while(have_rows('faq')): the_row();
            $category = get_sub_field('faq_category');
            echo '<div class="faq-category">';
            echo '<a id="'.$category.'"></a>';
            if($category): echo '<h2>'.$category.'</h2>'; endif;
            if(have_rows('faq_fields')):
                while(have_rows('faq_fields')): the_row();
                    $question = get_sub_field('question');
                    $answer = get_sub_field('answer'); ?>
                    <div class="faq">
                        <span class="question"><?php echo $question; ?></span>
                        <span class="answer"><?php echo $answer; ?></span>
                    </div>
                <?php endwhile;
            endif;
            echo '</div>';
        endwhile;
    endif;

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
} // FAQ REPEATER
add_shortcode('faq','faq_content');

function gallery_content(){
    ob_start();

    if(have_rows('gallery')):
        //$lazy = get_field('lazy_load');
        //if($lazy){
            //wp_enqueue_script('lazyload');
        //}
        echo '<div id="masonry-container">';
        while(have_rows('gallery')): the_row();
            if(!get_sub_field('image_url')) {
                $image = wp_get_attachment_image_src(get_sub_field('image'), "medium")[0];
                $fullsize = wp_get_attachment_image_src(get_sub_field('image'),"full")[0];
            } else {
                $image = get_sub_field('image_url');
                $fullsize = get_sub_field('image_url');
            }
            $description = get_sub_field('description');
            $alt = get_post_meta(get_sub_field('image'), '_wp_attachment_image_alt', true);
            $size = 'small'; ?>
            <div class="box img-fill <?php //if($lazy){ echo 'lazy'; } ?> <?php echo $size; ?>" <?php echo 'style="background-image:url('.$image.');"'; ?>>
                <?php if(preg_match('/(?i)msie [5-9]/',$_SERVER['HTTP_USER_AGENT'])) { ?>
                <a href="<?php echo $fullsize; ?>" class="image" target="_blank">
                <?php } else { ?>
                <a href="<?php echo $fullsize; ?>" class="colorbox image">
                <?php } ?>
                <div class="content">
                    <div class="valign">
                    <?php echo '<span>Click to Enlarge</span>'; ?>
                    </div>
                </div>
                </a>
            </div>
        <?php endwhile;
        echo '</div>';
    endif;

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
} // MASONRY GALLERY
add_shortcode('gallery','gallery_content');

function large_gallery(){
    ob_start();

    $lightbox = get_field('lightbox');
    $number = get_field('number_of_columns');
    if(have_rows('large_gallery')): ?>
        <div class="columns clear">
    <?php while(have_rows('large_gallery')): the_row();
            $category = get_sub_field('large_gallery_category');
            if(have_rows('gallery')): ?>
                <section class="gallery">
                    <?php if($category):?><a id="<?php echo $category; ?>"></a><?php endif; ?>
                    <h2><?php echo $category; ?></h2>
                    <?php while(have_rows('gallery')): the_row();
                        $image = wp_get_attachment_image_src(get_sub_field('image'),'small')[0];
                        $fullsize = wp_get_attachment_image_src(get_sub_field('image'),'full')[0];
                        $alt = get_post_meta(get_sub_field('image'), '_wp_attachment_image_alt', true);
                        if(is_product()): $class = 'class="image zoom" data-rel="prettyPhoto"'; else: $class='class="colorbox image"'; endif; ?>
                        <div class="image col col-<?php echo $number; ?>">
                            <div class="image-absolute">
                            <?php if($lightbox): echo '<a href="'.$fullsize.'" '.$class.'';
                                    if($alt): echo 'title="'.$alt.'"'; endif;
                                 echo '>'; endif; ?>
                                <img src="<?php echo $image; ?>" <?php if($alt): ?>alt="<?php echo $alt; ?>" <?php endif; ?>/>
                            <?php if($lightbox): echo '</a>'; endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </section>
    <?php endif; endwhile; echo '</div>'; endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
} // COLUMN GALLERY
add_shortcode('image_gallery','large_gallery');

function add_gallery(){
    echo do_shortcode('[image_gallery]');
} // ADD GALLERY SHORTCODE TO PRODUCT PAGE
add_action('woocommerce_after_single_product_summary','add_gallery',7);



/* WOOCOMMERCE EDITS */

// SITE WRAPPER CLASSES

function begin_wrapper(){
    echo '<main><div class="wrapper clear">';
} //ADD WRAPPER CLASS TO PRODUCT PAGE

function column_wrapper(){
    echo '<div class="columns">';
} //STYLE PRODUCTS TO COLUMNS

function valign_img(){
    echo '<div class="thumbnail"><div class="absolute">';
} //VERTICALLY CENTER PRODUCT IMAGE (ARCHIVE)

function end_wrapper() {
    echo '</div>';
} //UNIVERSAL ENDING DIV

function end_main(){
    echo '</main>';
}
add_action('woocommerce_before_main_content', 'begin_wrapper', 5);
add_action('woocommerce_after_main_content', 'end_wrapper', 15);
add_action('woocommerce_after_main_content', 'end_main', 16);

add_action('woocommerce_before_shop_loop', 'column_wrapper',35);
add_action('woocommerce_after_shop_loop','end_wrapper', 5);
add_action('woocommerce_after_shop_loop', 'end_main', 6);

add_action('woocommerce_before_shop_loop_item_title','valign_img',5);
add_action('woocommerce_before_shop_loop_item_title','end_wrapper',14);
add_action('woocommerce_before_shop_loop_item_title','end_wrapper',15);

add_action('woocommerce_before_subcategory_title','valign_img',9);
add_action('woocommerce_before_subcategory_title','end_wrapper',11);
add_action('woocommerce_before_subcategory_title','end_wrapper',12);
//APPLY WRAPPERS

// ADD THUMBNAIL GALLERY TO SINGLE PRODUCT PAGE WITH HOVER EFFECT
function special_thumbnails(){
    if(have_rows('thumbnails')): $x = 0;
        //global $product;
        echo '<div class="columns clear">';
        if(get_field('thumbnail_title')): echo '<h2>'.get_field('thumbnail_title').'</h2>'; endif;
        while(have_rows('thumbnails')): the_row();
            $thumbnail = wp_get_attachment_image_src(get_sub_field('thumbnail'),"large");
            $fullsize = wp_get_attachment_image_src(get_sub_field('thumbnail'),"full");
            $texture = wp_get_attachment_image_src(get_sub_field('texture'),"full");
            $dimensions = get_sub_field('dimensions');
            $alt = get_post_meta(get_sub_field('thumbnail'), '_wp_attachment_image_alt', true);
            if(get_the_ID() == 1658){
                $column = 'col-2';
                $pretty = 'data-rel="prettyPhoto[benchGallery]" aria-label="'.$dimensions.'"';
                if($x % 2 == 0){
                    echo '<div class="clear">';
                }
            } else {
                $column = 'col-3';
                $pretty = null;
            }
            ?>

            <div class="col <?php echo $column; ?> thumbnail">
                <?php if($pretty){ echo '<a href="'.$fullsize[0].'" '.$pretty.'>'; } ?>
                <?php if($thumbnail): ?><img src="<?php echo $thumbnail[0]; ?>" alt="<?php if($dimensions && (get_the_ID() != 1658)): echo preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($dimensions, ENT_QUOTES)); else: echo $alt; endif; ?>"/><?php endif;
                if($dimensions && ($column == 'col-2') && (get_the_ID() != 1658)){
                    echo '<h3>'.$dimensions.'</h3><em style="display:block; text-align:center;">Click to Enlarge</em>';
                } else if(get_the_ID() == 1658){
                    echo '<h3 style="margin:1em 0 .2em;">'.$alt.'</h3>';
                    //echo '<span style="display:block; text-align:center;">'.$dimensions.'</span>';
                    echo '<em style="display:block; text-align:center; margin:.5em auto;">Click to Enlarge and See Details</em>';
                }
                if($pretty){
                    echo '</a>';
                }
                if($texture && !is_handheld()): ?>
                    <div class="hover">
                        <img src="<?php echo $texture[0]; ?>" alt="<?php if($alt): echo $alt; else: echo get_the_title().'-'.$x; endif; ?>">
                        <?php echo '<h3>';  if($dimensions): echo $dimensions; else: echo get_field('thumbnail_title'); endif; echo '</h3>'; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if(get_the_ID() == 1658){
                if(($x - 1) % 2 == 0){
                    echo '</div>';
                }
            } ?>
        <?php $x++; endwhile;
        echo '</div>';
    endif;
}
add_action('woocommerce_after_single_product_summary','special_thumbnails',5);

// TABLE TO DISPLAY VARIATION DATA
function product_table(){
    global $product;
    if($product->product_type == 'variable') {

       $variations = $product->get_available_variations();

        foreach($variations as $variation){
            $variableproduct = wc_get_product($variation['variation_id']);
            $colorcheck = $variableproduct->get_attribute('pa_colors');
            $linescheck = $variableproduct->get_attribute('pa_lines-characters');
            $stylecheck = $variableproduct->get_attribute('pa_style');
        }   ?>

       <div class="variation-table clear">
           <div class="table-header row">
               <div class="cell"><?php if($stylecheck){ echo 'Styles'; } else {  ?>Dimensions<?php } ?></div>
               <div class="cell"><?php if($colorcheck): ?>Color Options<?php endif; ?><?php if($linescheck): ?>Lines / Characters<?php endif; ?></div>
               <div class="cell">Price</div>
           </div>

       <?php foreach($variations as $variation ){
           $id = $variation['variation_id'];

           /* @var $product WC_Product_Variation */

           $var = wc_get_product($id);

           $price = number_format($variation['display_price'],2,'.','');

           /* GET ATTRIBUTES AND FORMAT */
           $dimension = $variation['attributes']['attribute_pa_dimensions'];
           $dimension = get_term_by('slug',$dimension,'pa_dimensions');
           $dimension = $dimension->name;

           $style = $variation['attributes']['attribute_pa_style'];
           $style = get_term_by('slug',$style,'pa_style');
           $style = $style->name;

           $lines = $variation['attributes']['attribute_pa_lines-characters'];
           $lines = get_term_by('slug',$lines,'pa_lines-characters');
           $lines = $lines->name;

           $colors = $var->get_attribute('pa_colors');
           $colors = explode(',',$colors); ?>

            <div class="row variation-<?php echo $id; ?>">
                <div class="cell"><?php if($style): echo $style; endif; ?><?php if($dimension): echo $dimension; endif; ?></div>
                <div class="cell color"><?php if($lines): echo $lines; else: foreach($colors as $color){  $class = str_replace('#','',substr($color,1,3)); echo '<span class="color-'.$class.'">'.$color.'</span>'; } endif; ?></div>
                <div class="cell price"><?php echo '$'.$price; ?></div>
            </div>
            <?php    }   ?>
       </div>
  <?php }
}
add_action('woocommerce_after_single_product_summary','product_table',8);

function pricing_table(){
    ob_start();
    $bricks = array(279,260,259,258,257,256,255,254,245);
    $args = array('post_type'=>'product', 'post__in'=>$bricks,'post_status'=>'publish', 'posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC');
    $products = get_posts($args); ?>
    <div class="pricing-table clear">
           <div class="table-header row">
               <div class="cell">Product</div>
               <div class="cell">Image</div>
               <div class="cell">Size</div>
               <div class="cell">4 x 8</div>
               <div class="cell">8 x 8</div>
               <div class="cell">12 x 12</div>
           </div>
   <?php foreach($products as $product) {
        $id = $product->ID;
        $title = $product->post_title;
        $slug = $product->post_name;
        $url = get_permalink($id);
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($id),'medium')[0];
        $product = wc_get_product($id);
        echo '<div class="row '.$slug.'">';

            echo '<div class="cell title">';
                if($url): echo '<a href="'.$url.'">'; endif;
                    echo '<h3>'.$title.'</h3>';
                if($url): echo '</a>'; endif;
            echo '</div>';

            echo '<div class="cell image">';
                if($url): echo '<a href="'.$url.'">'; endif;
                    echo '<img src="'.$thumbnail.'"/>';
                if($url): echo '</a>'; endif;
            echo '</div>';

       if($product->product_type == 'variable'){
           $variations = $product->get_available_variations();
            echo '<div class="cell size">';
                foreach($variations as $variation){
                    $dimension = $variation['attributes']['attribute_pa_dimensions'];
                    if($dimension) {
                        $dimension = get_term_by('slug', $dimension, 'pa_dimensions');
                        $dimension = $dimension->name;
                        echo '<span class="dimension">'.$dimension.'</span>';
                    }
                }
            echo '</div>';

            if($slug != 'standard-bricks') {
                foreach ($variations as $variation) {
                    echo '<div class="cell price">';
                    $price = number_format($variation['display_price'], 2, '.', '');
                    $style = $variation['attributes']['attribute_pa_style'];
                    echo '<span class="price">$' . $price . '</span>';
                    if ($style) {
                        $style = get_term_by('slug', $style, 'pa_style');
                        $style = $style->name;
                        echo $style;
                    }

                    echo '</div>';
                }
            } else {
                for($i = 0; $i <= 1; $i++){
                    echo '<div class="cell price">';
                    if($i == 0){
                        echo '<span class="price">$19.00</span>';
                    } else {
                        echo '';
                    }
                    echo '</div>';
                }
            }
           if(count($variations) < 3){
               echo '<div class="cell price"></div>';
           }
        }
       echo '</div>';
    } ?>
   </div>
    <div class="pricing-table additional-products clear">
        <div class="table-header row">
            <div class="cell">Product</div>
            <div class="cell">Image</div>
            <div class="cell">Price</div>
        </div>
    <?php
        $args2 = array('post_type'=>'product', 'post__not_in'=>$bricks,'post_status'=>'publish', 'posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC');
        $otherproducts = get_posts($args2);
        foreach($otherproducts as $product) {
            $id = $product->ID;
            $title = $product->post_title;
            $slug = $product->post_name;
            $url = get_permalink($id);
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'medium')[0];
            $product = wc_get_product($id);
            $regprice = $product->get_price();

            echo '<div class="row ' . $slug . '">';

            echo '<div class="cell title">';
            if ($url): echo '<a href="' . $url . '">'; endif;
            echo '<h3>' . $title . '</h3>';
            if ($url): echo '</a>'; endif;
            echo '</div>';

            echo '<div class="cell image">';
            if ($url): echo '<a href="' . $url . '">'; endif;
            echo '<img src="' . $thumbnail . '"/>';
            if ($url): echo '</a>'; endif;
            echo '</div>';

            echo '<div class="cell price">';
            if ($product->product_type == 'variable') {
                $variations = $product->get_available_variations();
                foreach ($variations as $variation) {

                    $price = number_format($variation['display_price'], 2, '.', '');
                    $style = $variation['attributes']['attribute_pa_style'];
                    $dimension = $variation['attributes']['attribute_pa_dimensions'];
                    echo '<span class="price">$' . $price;
                    if ($style) {
                        $style = get_term_by('slug', $style, 'pa_style');
                        $style = $style->name;
                        echo '<em>'.$style.'</em>';
                    }
                    if($dimension) {
                        $dimension = get_term_by('slug', $dimension, 'pa_dimensions');
                        $dimension = $dimension->name;
                        echo '<em>'.$dimension.'</em>';
                    }
                    echo '</span>';
                }
            } else {

                if ($regprice && ($id != 285)) {
                    echo '<span class="price">$' . $regprice . '</span>';
                } else if ($regprice && ($id == 285)){
                    echo '<span class="price">$'.$regprice.' Printed Certificate / $4 E-Donor Certificate</span>';
                } else {
                    echo '<span>Free</span>';
                }

            }
            echo '</div></div>';
        }
    ?>
    <?php if(have_rows('additional_products','options')): while(have_rows('additional_products','options')): the_row();
    $title = get_sub_field('product_title');
    $url = get_sub_field('product_url');
    $copy = get_sub_field('product_description');
    echo '<div class="row">';
        echo '<div class="cell title"><h3>';
                if($url): echo '<a href="'.$url.'">'; endif;
                    echo $title;
                    if($url): echo '</a>'; endif;
                echo '</h3></div>';
        echo '<div class="cell image"></div>';
        echo '<div class="cell price">'.$copy.'</div>';
        echo '</div>';
    endwhile; endif;
    ?>
                </div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('pricetable','pricing_table');

/* ADD DISCLAIMER TO SINGLE PRODUCT PAGE FOR SPECIAL MESSAGE */
function product_disclaimer(){
    if(get_field('product_disclaimer')):
        echo '<aside class="product-disclaimer">'.get_field('product_disclaimer').'</aside>';
    endif;
}
add_action('woocommerce_after_single_product_summary','product_disclaimer',9);

function additionalImagesRepeater(){
    if(have_rows('additional_product_images')){
        $title = get_field('additional_product_title');
        echo '<div class="columns additional-product-images clear">';
        echo '<h2 style="text-align:center;">'.$title.'</h2>';
        while(have_rows('additional_product_images')){ the_row();
            $image = wp_get_attachment_image_src(get_sub_field('api_image'),'medium');
            $fullsize = wp_get_attachment_image_src(get_sub_field('api_image'),'full');
            $alt = get_post_meta(get_sub_field('api_image')[0], '_wp_attachment_image_alt', true); ?>
            <div class="col col-3 img-fill" style="background-image:url(<?php echo $image[0]; ?>);">
                <a href="<?php echo $fullsize[0]; ?>" data-rel="prettyPhoto[product-gallery]" title="<?php echo $alt; ?>"></a>
            </div>
        <?php }
        echo '</div>';
    }
}
add_action('woocommerce_after_single_product_summary','additionalImagesRepeater',35);

function pdf_upload(){
    ob_start();
    if(have_rows('pdf_uploads')): ?>
        <?php while(have_rows('pdf_uploads')): the_row();
                $category = get_sub_field('pdf_category_title');
                $cat_desc = get_sub_field('pdf_cat_desc');
                if(have_rows('pdf_category')):
                    echo '<section class="pdfs clear">';
                    if($category): echo '<h2>'.$category.'</h2>'; endif;
                    if($cat_desc): echo '<p>'.$cat_desc.'</p>'; endif;
                    while(have_rows('pdf_category')): the_row();
                        $file = get_sub_field('pdf_file');
                        $url = get_sub_field('pdf_url');
                        $button = get_sub_field('pdf_title'); ?>
                        <div class="pdf">
                            <a href="<?php if($file){ echo $file; } else { echo $url; } ?>" class="button" target="_blank" title="<?php echo $button; ?>"><?php echo $button; ?></a>
                        </div>
        <?php  endwhile; echo '</section>';   endif; endwhile; ?>
    <?php endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('pdfs','pdf_upload');

function do_pdf(){
    echo do_shortcode('[pdfs]');
}
add_action('woocommerce_after_single_product_summary','do_pdf',4);

// SHOW PRODUCT EXCERPT
function product_excerpt(){
    if(get_the_excerpt()):
        html5wp_prodexcerpt('product_length');
    endif;
}
add_action('woocommerce_after_shop_loop_item_title','product_excerpt',3);


// REMOVE ALL THE THINGS!

// REMOVE PRODUCT ORDERING AND RESULT COUNT FROM ARCHIVE PAGE
remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

// REMOVE SIDEBAR
remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);

// REMOVE META DATA AND RELATED PRODUCTS FROM SINGLE PRODUCT PAGE
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);

// REMOVE CATEGORY COUNT
add_filter( 'woocommerce_subcategory_count_html', 'woo_remove_category_products_count' );

function woo_remove_category_products_count() {
    return;
}

// REMOVE PRICE (ARCHIVE)
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);

// REMOVE PRICE AND ADD TO CART ACTION (SINGLE PRODUCT)
remove_action('woocommerce_single_product_summary','woocommerce_template_single_price',10);
remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);

remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
add_action('woocommerce_single_product_summary','alternate_title',5);


/* REMOVE PRODUCT TABS */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs )
{
    unset($tabs['description']);        // Remove the description tab
    unset($tabs['additional_information']);    // Remove the additional information tab
    return $tabs;
}

/* CHANGE BREADCRUMB TEXT */

add_filter( 'woocommerce_breadcrumb_home_url', 'woo_custom_breadrumb_home_url' );
    function woo_custom_breadrumb_home_url() {
        if(is_shop()){
            $url = get_bloginfo('url');
        } else {
            $url = get_permalink(wc_get_page_id('shop'));
        }
        return $url;
    }

add_filter( 'woocommerce_breadcrumb_defaults', 'change_breadcrumb_home_text' );
function change_breadcrumb_home_text( $defaults ) {
    if(is_shop()){
        $defaults['home'] = 'Home';
    } else {
        $defaults['home'] = 'Products';
    }
    return $defaults;
}

/* CHANGE DEFAULT ADD TO CART TEXT */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

add_action('woocommerce_after_shop_loop_item','button_replacement');

function button_replacement(){ ?>
    <a href="<?php the_permalink(); ?>" class="button red add_to_cart_button">Read More</a>
<?php }


// REMOVE DISQUS FROM PRODUCT PAGES
add_filter( 'comments_template' , 'block_disqus', 1 );
function block_disqus($file) {
    if ( 'product' == get_post_type() )
        remove_filter('comments_template', 'dsq_comments_template');
    return $file;
}

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support()
{
    add_theme_support('woocommerce');
}

function mostPopular(){
    global $product;
    if($product->is_featured()){
        echo '<span id="most-popular">Most Popular!</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title','mostPopular',3);

function strReplaceAssoc(array $replace, $subject) {
    return str_replace(array_keys($replace), array_values($replace), $subject);
}


add_filter('the_content','add_whitespaces',20);
add_filter('the_excerpt','add_whitespaces',20);
add_filter('acf/load_value/type=textarea','add_whitespaces',10,3);
//add_filter('acf/load_value/type=text','add_whitespaces',11,3);



function add_whitespaces($content){
    //$content = preg_replace('/(?<=[a-zA-Z])[.]/','.&nbsp; ', $content);
    $content = preg_replace('/\.\s+/','.&nbsp; ', $content);
    $content = preg_replace('/\!\s+/','!&nbsp; ', $content);
    $content = preg_replace('/\?\s+/','?&nbsp; ', $content);
    return $content;
}

function loginForm(){
    ob_start();

    if(!wp_script_is('validate','queue')) {
        wp_enqueue_script('validate');
    }?>

    <form id="loginForm" name="form1" method="post" action="https://www.bricksrus.com/ordernow/login2.asp" class="customform customform-login">
        <p><label>Customer ID:</label><input class="login-id" type="text" name="CustomerID" size="15" maxlength="6" required></p>
        <p><label>Password:</label><input class="login-pass" type="password" name="Password" size="15" maxlength="30" required></p>
        <p><input type="hidden" name="URL" value="//www.bricksrus.com/"></p>
        <p><button type="submit" class="button button-login">Sign In</button></p>
    </form>

    <?php $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('login','loginForm');

function registrationForm(){ //function heavily modified by drewadesigns.com on 2/25/2016
    ob_start();

    if(!wp_script_is('validate','queue')) {
        wp_enqueue_script('validate');
    }

    recaptchaCallback(); ?>

    <form id="registrationForm" name="registrationform" method="post" action="https://bricksrus.com/ordernow/requestpassword_.asp" class="customform customform-register">
        <p><label>Company Name:</label><input class="register-company" type="text" id="CompanyName" name="CompanyName" size="15" maxlength="100" required></p>
        <p><label>First Name:</label><input class="register-name" type="text" id="FullName" name="FullName" size="15" maxlength="30" required></p>
        <p><label>City:</label><input class="register-city" type="text" id="City" name="City" size="15" maxlength="30" required></p>
        <p><label>State:</label><select name="State" class="register-state" required><option selected="">Select One</option><?php get_template_part('states'); ?></select></p>
        <p><label>Zip Code:</label><input class="register-zip" id="ZIP" name="ZIP" type="number" size="7" maxlength="10" required></p>
        <p><label>Phone Number:</label>(<input type="text" id="PhoneNumber1" name="PhoneNumber1" class="register-phone register-phone-1" size="3" maxlength="3" required>)<input type="text" id="PhoneNumber2" name="PhoneNumber2" class="register-phone register-phone-2" size="3" maxlength="3" required>
            &nbsp;-&nbsp;&nbsp;<input type="text" id="PhoneNumber3" name="PhoneNumber3" class="register-phone register-phone-3" size="4" maxlength="4" required></p>
        <p class="clear"><input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha" data-response=""></p>
        <div id="recaptcha"></div>
        <p><button type="submit" class="button button-register">Continue</button></p>
    </form>

    <?php $content = ob_get_contents();
    ob_end_clean();
    return $content;

}
add_shortcode('register','registrationForm');

function passwordForm(){
    ob_start();

    if(!wp_script_is('validate','queue')) {
        wp_enqueue_script('validate');
    }?>

    <form id="passwordForm" name="passwordform" method="post" action="https://bricksrus.com/ordernow/forgotlogin_.asp" class="customform customform-password" target="_blank">
        <p><label>Email:</label><input class="password-email" type="email" id="EMail" name="EMail" size="30" maxlength="45" required></p>
        <p><button type="submit" class="button button-password">Continue</button></p>
    </form>

    <?php $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('password','passwordForm');

function orderonebrickForm(){ //function created by drewadesigns.com on 2/25/2016
    ob_start();

    if(!wp_script_is('validate','queue')) {
        wp_enqueue_script('validate');
    }

    recaptchaCallback(); ?>

	<script type="text/javascript" src="//www.bricksrus.com/donororderscripts.js"></script>
    <form id="orderonebrickForm" name="orderonebrickform" method="post" action="https://www.bricksrus.com/cgi-bin/orgdonate.cgi" class="customform customform-register">
        <p><label>* Your Name:</label><input type="text" id="name" name="name" size="15" maxlength="50" required></p>
        <p><label>Company Name:</label><input type="text" id="company" name="company" size="15" maxlength="100"></p>
        <p><label>* Street Address:</label><input type="text" id="address" name="address" size="15" maxlength="50" required></p>
        <p><label>* City:</label><input type="text" id="city" name="city" size="15" maxlength="40" required></p>
        <p><label>* State:</label><select id="state" name="state" required><option selected="">Select One</option><?php get_template_part('states'); ?></select></p>
        <p><label>* ZIP/Postal Code:</label><input id="zip" name="zip" type="text" size="15" maxlength="40" required></p>
        <p><label>* Phone Number:</label><input id="phone" name="phone" type="tel" size="15" maxlength="40" required></p>
        <p><label>Fax Number:</label><input id="fax" name="fax" type="tel" size="15" maxlength="40"></p>
        <p><label>* Email Address:</label><input type="email" id="email" name="email" size="30" maxlength="40" required></p>
        <p><label>* Brick Size:</label><select name="BrickLines" id="BrickLines" required onChange="autoAmount(this.form);">
                      <option value="none" selected>&lt;Select One&gt;</option>
					  <option value="3--1--0--34.00--0.00--34.00--0--0.00">4x8-Red $34.00</option>
					  <option value="6--2--0--44.50--0.00--44.50--0--0.00">8x8-Red $44.50</option>
                      <option value="3--1--0--39.00--0.00--39.00--0--0.00--1">4x8-Red $39.00 w/ stock logo</option>
                      <option value="6--2--0--49.50--0.00--49.50--0--0.00--1">8x8-Red $49.50 w/ stock logo</option>
                      <option value="3--3--0--34.00--0.00--34.00--0--0.00">4x8-Caribbean $34.00</option>
                      <option value="6--4--0--44.50--0.00--44.50--0--0.00">8x8-Caribbean $44.50</option>
                      <option value="3--3--0--39.00--0.00--39.00--0--0.00--1">4x8-Caribbean $39.00 w/ stock logo</option>
                      <option value="6--4--0--49.50--0.00--49.50--0--0.00--1">8x8-Caribbean $49.50 w/ stock logo</option>
                      <option value="3--5--0--34.00--0.00--34.00--0--0.00">4x8-Ivory $34.00</option>
                      <option value="6--6--0--44.50--0.00--44.50--0--0.00">8x8-Ivory $44.50</option>
                      <option value="3--5--0--39.00--0.00--39.00--0--0.00--1">4x8-Ivory $39.00 w/ stock logo</option>
                      <option value="6--2--0--49.50--0.00--49.50--0--0.00--1">8x8-Ivory $44.50 w/ stock logo</option>
                      <option value="3--7--0--34.00--0.00--34.00--0--0.00">4x8-Majestic $34.00</option>
                      <option value="6--8--0--44.50--0.00--44.50--0--0.00">8x8-Majestic $44.50</option>
                      <option value="3--7--0--39.00--0.00--39.00--0--0.00--1">4x8-Majestic $39.00 w/ stock logo</option>
                      <option value="6--8--0--49.50--0.00--49.50--0--0.00--1">8x8-Majestic $49.50 w/ stock logo</option>
                      <option value="10--9--0--54.50--0.00--54.50--0--0.00">12x12-Red #E3 $54.50</option>
                      <option value="10--10--0--54.50--0.00--54.50--0--0.00">12x12-Natural Gray #E1 $54.50</option>
                    </select></p>
        <input type="hidden" id="DonationAmount" name="DonationAmount" size="30" maxlength="10" >
		<input name="NumberBricks" type="hidden" id="NumberBricks" value="1">
        <input name="organization" type="hidden" id="organization" value="Bricks R Us">
        <input name="orgemail" type="hidden" id="orgemail" value="terry@bricksrus.com">
        <input name="orgemail2" type="hidden" id="orgemail2" value="">
        <input name="orgcontactemail" type="hidden" id="orgcontactemail" value="sales@bricksrus.com">
        <input name="orgcontactphone" type="hidden" id="orgcontactphone" value="305-931-7773">
        <input name="orgpayableto" type="hidden" id="orgpayableto" value="Bricks R Us">
        <input name="orgline1" type="hidden" id="orgline1" value="Bricks R Us">
        <input name="orgline2" type="hidden" id="orgline2" value="201 S Biscayne Boulevard">
        <input name="orgline3" type="hidden" id="orgline3" value="28th Floor">
        <input name="orgline4" type="hidden" id="orgline4" value="Miami, Florida  33131">
        <input name="orgline5" type="hidden" id="orgline5" value="">
        <input name="orgcomments" type="hidden" id="orgcomments" value="Thank you for your order!  Although you may see the word donation, this is not a donation.  It is a sale for the purchase of one brick.  You will receive a confirmation within 24 hours.  If you don't receive the confirmation, please contact our office for there may be an error in your order that we are unaware of.">
        <input name="orglogo" type="hidden" id="orglogo" value="order/onebrick/logo.jpg">

        <!--Credit Card Option-->
        <input name="acceptcc" type="hidden" id="acceptcc" value="no">
        <input name="cvv2" type="hidden" id="cvv2" value="no">
        <input name="acceptamex" type="hidden" id="acceptamex" value="no">

        <!--ECheck Option-->
        <input name="acceptcheck" type="hidden" id="acceptcheck" value="yes">

        <!--Regular Check Option-->
        <input name="acceptregcheck" type="hidden" id="acceptregcheck" value="no">

        <!--Custom Payment Option-->
        <input name="acceptcustompayment" type="hidden" id="acceptcustompayment" value="no">
        <input name="custompaymenturl" type="hidden" id="custompaymenturl" value="https://www.bricksrus.com/order/mpaef/custom.php?a={{{DonationAmount}}}">


        <!--PayPal Option-->
        <input name="acceptpaypal" type="hidden" id="acceptpaypal" value="yes">
        <input name="paypalemail" type="hidden" id="paypalemail" value="bricksrus_tkus@bricksrus.com">
        <input name="paypalsuccessurl" type="hidden" id="paypalsuccessurl" value="http://www.bricksrus.com">
        <input name="paypalcancelurl" type="hidden" id="paypalcancelurl" value="https://www.bricksrus.com/order/onebrick">

        <!--Google Payment Option-->
        <input name="acceptgooglecheckout" type="hidden" id="acceptgooglecheckout" value="no">
        <input name="googlecheckouturl" type="hidden" id="googlecheckouturl" value="https://checkout.google.com/cws/v2/Merchant/142136725240386/checkoutForm">

        <!--Miscellaneous Options-->
        <input name="MaxCharacters4x8" type="hidden" id="MaxCharacters4x8" value="18">
        <input name="MaxCharacters8x8" type="hidden" id="MaxCharacters8x8" value="18">
        <input name="MaxCharacters12x12" type="hidden" id="MaxCharacters12x12" value="23">


        <input name="startpage" type="hidden" id="startpage" value="order/onebrick/">
        <input name="forcecaps" type="hidden" id="forcecaps" value="yes">

        <input name="CustomerID" type="hidden" id="CustomerID" value="BRIX">
        <input name="storedata" type="hidden" id="storedata" value="yes">

        <input name="acceptcc" type="hidden" id="acceptcc" value="no">
        <input name="usecustomergateway" type="hidden" id="usecustomergateway" value="Authorize.Net AIM">
	    <!-- FOR BRICK CREATOR -->
        <input name="BrickSize--1" type="hidden" id="BrickSize--1" value="4X8">
        <input name="Engraving--1" type="hidden" id="Engraving--1" value="Paint">
        <input name="BrickName--1" type="hidden" id="BrickName--1" value="WG/Red-4x8.jpg">
        <input name="BrickSize--2" type="hidden" id="BrickSize--2" value="8X8">
        <input name="Engraving--2" type="hidden" id="Engraving--2" value="Paint">
        <input name="BrickName--2" type="hidden" id="BrickName--2" value="WG/Red-8x8.jpg">

        <input name="BrickSize--3" type="hidden" id="BrickSize--3" value="4X8">
        <input name="Engraving--3" type="hidden" id="Engraving--3" value="Paint">
        <input name="BrickName--3" type="hidden" id="BrickName--3" value="WG/Caribbean-4X8.jpg">
        <input name="BrickSize--4" type="hidden" id="BrickSize--4" value="8X8">
        <input name="Engraving--4" type="hidden" id="Engraving--4" value="Paint">
        <input name="BrickName--4" type="hidden" id="BrickName--4" value="WG/Caribbean-8X8.jpg">

        <input name="BrickSize--5" type="hidden" id="BrickSize--5" value="4X8">
        <input name="Engraving--5" type="hidden" id="Engraving--5" value="Paint">
        <input name="BrickName--5" type="hidden" id="BrickName--5" value="WG/Ivory-4X8.jpg">
        <input name="BrickSize--6" type="hidden" id="BrickSize--6" value="8X8">
        <input name="Engraving--6" type="hidden" id="Engraving--6" value="Paint">
        <input name="BrickName--6" type="hidden" id="BrickName--6" value="WG/Ivory-8X8.jpg">

        <input name="BrickSize--7" type="hidden" id="BrickSize--7" value="4X8">
        <input name="Engraving--7" type="hidden" id="Engraving--7" value="Paint">
        <input name="BrickName--7" type="hidden" id="BrickName--7" value="WG/Majestic-4X8.jpg">
        <input name="BrickSize--8" type="hidden" id="BrickSize--8" value="8X8">
        <input name="Engraving--8" type="hidden" id="Engraving--8" value="Paint">
        <input name="BrickName--8" type="hidden" id="BrickName--8" value="WG/Majestic-8X8.jpg">
        <!-- END BRICK CREATOR -->
        <p class="clear"><input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha" data-response=""></p>
        <div id="recaptcha"></div>
        <p><button type="submit" class="button button-register">Continue</button></p>
    </form>

    <?php $content = ob_get_contents();
    ob_end_clean();
    return $content;

}
add_shortcode('orderonebrick','orderonebrickForm');

function recaptchaCallback(){
    if(!wp_script_is('recaptcha','queue')){
        wp_enqueue_script('recaptcha');
    } ?>
    <script type="text/javascript">
        var onloadCallback = function() {
        grecaptcha.render('recaptcha',{
				'sitekey' : '6LcFTRETAAAAAF7ao7VTP5xWdLVUtvfP_ROYEqjS',
                'callback' : verifyCallback
            });
        };
        var verifyCallback = function(response){
        jQuery('input.hiddenRecaptcha').attr('data-response',response);
    };

    </script>
<?php }
function donorSampleForm(){
    ob_start();

    if(!wp_script_is('validate','queue')) {
        wp_enqueue_script('validate');
    }
    ?>

   <?php recaptchaCallback(); ?>

    <form id="sampleForm" name="inforeq" method="post" action="https://bricksrus.com/cgi-bin/orgdonate.cgi" class="customform customform-sample" target="_blank">
        <p><label>* Your Name:</label><input type="text" maxlength="50" name="name" size="30" id="name" class="sample-name" required></p>
        <p><label>Your Company:</label><input type="text" maxlength="100" name="company" size="30" id="company" class="sample-company"></p>
        <p><label>* Street Address:</label><input type="text" maxlength="50" name="address" size="30" id="address" class="sample-address" required></p>
        <p><label>* City:</label><input type="text" maxlength="40" name="city" size="30" id="city" class="sample-city" required></p>
        <p><label>* State/Province:</label><select name="state" id="state" class="sample-state" required><option selected="">Select One</option><?php get_template_part('states'); ?></select></p>
        <p><label>* Zip Code/Postal Code:</label><input type="number" maxlength="10" name="zip" size="30" id="zip" class="sample-zip" required></p>
        <p><label>* Country:</label><select name="country" id="country" class="sample-country" required><option selected="">Select One</option><?php get_template_part('countries'); ?></select></p>
        <p><label>* Phone Number:</label><input type="tel" maxlength="14" name="phone" size="30" id="phone" class="sample-phone" required></p>
        <p><label>Fax Number:</label><input type="tel" maxlength="14" name="fax" size="30" id="fax" class="sample-fax"></p>
        <p><label>* Email Address:</label><input type="email" maxlength="50" name="email" size="30" id="email" class="sample-email" required></p>
        <p><label>* Brick Size:</label><select name="BrickLines" id="BrickLines" class="sample-bricklines" required>
                <option selected="">Select One</option>
                <option value="3--1--0--100.00--25.00--50.00------0--10.00" data-price="100">4X8 $100</option>
                <option value="3--1--0--100.00--25.00--60.00------1--10.00" data-price="100">4X8 (with logo) $100</option>
                <option value="6--2--0--250.00--25.00--125.00------0--10.00" data-price="250">8X8 $250</option>
                <option value="9--3--0--500.00--25.00--250.00------0--10.00" data-price="500">12X12 $500</option>
                <option value="3--6--0--00.00--0.00--0.00------0--0.00" data-price="0">4X8 $0</option>
        </select></p>
        <p class="with-price"><label>Would you like to receive Donor Certificate(s)?</label><select name="DonorCertificate" id="DonorCertificate" class="sample-donorcertificate" disabled>
                <option selected="" value="default">Select One</option>
                <option class="positive" value="1" data-price="10">Yes</option>
                <option value="0" data-price="0">No</option>
        </select><span class="price">$10.00</span></p>
        <p class="with-price"><label>Would you like to receive Donor Brick(s)?</label><select name="DonorBrick" id="DonorBrick" class="sample-donorbrick" disabled>
                <option selected="" value="default">Select One</option>
                <option class="positive" value="1" data-price="25">Yes</option>
                <option value="0" data-price="0">No</option>
        </select><span class="price">$25.00</span></p>
        <p><label>* Donation Amount:</label><span id="donation-amount"></span></p>
        <input type="hidden" name="DonationAmount" id="DonationAmount">
        <p class="clear"><input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha" data-response=""></p>
        <div id="recaptcha"></div>
        <p>Press the Continue button to enter the customized text that will be engraved on your bricks.<button type="submit" class="button button-password">Continue</button></p>
        <input name="organization" type="hidden" id="organization" value="Bricks R Us High School">
        <input name="NumberBricks" type="hidden" id="NumberBricks" value="1">
        <input name="orgemail" type="hidden" id="orgemail" value="info@bricksrus.com">
        <input name="orgcontactemail" type="hidden" id="orgcontactemail" value="info@bricksrus.com">
        <input name="orgcontactphone" type="hidden" id="orgcontactphone" value="305-931-7773">
        <input name="orgpayableto" type="hidden" id="orgpayableto" value="Bricks R Us High School PTA">
        <input name="orgline1" type="hidden" id="orgline1" value="Bricks R Us High School">
        <input name="orgline2" type="hidden" id="orgline2" value="Attn: PTA Office">
        <input name="orgline3" type="hidden" id="orgline3" value="201 South Biscayne Boulevard">
        <input name="orgline4" type="hidden" id="orgline4" value="Suite 2846">
        <input name="orgline5" type="hidden" id="orgline5" value="Miami, Florida  33131">
        <input name="orgcomments" type="hidden" id="orgcomments" value="These are the comments.">
        <input name="orglogo" type="hidden" id="orglogo" value="brusmlogo.png">
        <input name="acceptcc" type="hidden" id="acceptcc" value="yes">
        <input name="acceptcheck" type="hidden" id="acceptcheck" value="no">
        <input name="acceptregcheck" type="hidden" id="acceptregcheck" value="yes">
        <input name="acceptamex" type="hidden" id="acceptamex" value="yes">
        <input name="cvv2" type="hidden" id="cvv2" value="no">
        <input name="forcecaps" type="hidden" id="forcecaps" value="yes">
        <input name="acceptpaypal" type="hidden" id="acceptpaypal" value="yes">
        <input name="paypalemail" type="hidden" id="paypalemail" value="paypal@bricksrus.com">
        <input name="paypalsuccessurl" type="hidden" id="paypalsuccessurl" value="https://www.bricksrus.com/order/abchighschool/index.php">
        <input name="paypalcancelurl" type="hidden" id="paypalcancelurl" value="https://www.bricksrus.com/order/abchighschool/index.php">
        <input name="acceptgooglecheckout" type="hidden" id="acceptgooglecheckout" value="yes">
        <input name="googlecheckouturl" type="hidden" id="googlecheckouturl" value="https://checkout.google.com/cws/v2/Merchant/8714891dd73179409/checkoutForm">
        <input name="acceptcustompayment" type="hidden" id="acceptcustompayment" value="no">
        <input name="custompaymenturl" type="hidden" id="custompaymenturl" value="http://www.lbschools.net/Community/Education_Foundation/Donations/index.cfm?a={{{DonationAmount}}}">
        <input name="MaxCharacters4x8" type="hidden" id="MaxCharacters4x8" value="18">
        <input name="MaxCharacters8x8" type="hidden" id="MaxCharacters8x8" value="18">
        <input name="MaxCharactersBench" type="hidden" id="MaxCharactersBench" value="35">
        <input name="MaxCharactersaa5" type="hidden" id="MaxCharactersaa5" value="20">
        <input name="MaxCharactersab30" type="hidden" id="MaxCharactersab30" value="40">
        <input name="startpage" type="hidden" id="startpage" value="order/abchighschool">
        <input name="forcecaps" type="hidden" id="forcecaps" value="yes">
        <!--To store Data, template must have a CustomerID, "yes" value for the "storedata tag
         and see note at "bricklines" select box -->
        <input name="CustomerID" type="hidden" id="CustomerID" value="abcd">
        <input name="VirtualSID" type="hidden" id="VirtualSID" value="0DDFC8B2ACE8">
        <input name="storedata" type="hidden" id="storedata" value="yes">
        <!-- FOR BRICK CREATOR -->
        <input name="BrickSize--1" type="hidden" id="BrickSize--1" value="4X8">
        <input name="Engraving--1" type="hidden" id="Engraving--1" value="Paint">
        <input name="BrickName--1" type="hidden" id="BrickName--1" value="WG/Cimmaron-4X8.jpg">
        <input name="BrickSize--2" type="hidden" id="BrickSize--2" value="8X8">
        <input name="Engraving--2" type="hidden" id="Engraving--2" value="Paint">
        <input name="BrickName--2" type="hidden" id="BrickName--2" value="WG/Red-8x8.jpg">
        <input name="BrickSize--3" type="hidden" id="BrickSize--3" value="12X12">
        <input name="Engraving--3" type="hidden" id="Engraving--3" value="Paint">
        <input name="BrickName--3" type="hidden" id="BrickName--3" value="Alfagres/SpanishRed-12X12.jpg">

    </form>

    <?php $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('sampleform','donorSampleForm');

add_shortcode('symbols','output_symbols_page');
function output_symbols_page($atts) {
    
    wp_enqueue_script( 'lazyload' );
    wp_enqueue_script('colorbox');
    
    $mysql = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, 'bricksrusdb' );
    if ( $mysql->connect_error ) {
        $mysql->close();
        return;
    }
    

	
	/*
	$result  = $mysql->query( "SELECT SymbolCode, SymbolCategory FROM symbols ORDER BY SymbolCategory, SymbolCode" );
	Added filter for Assign OOS checkbox, excluded Custom Symbols category by drewadesigns.com on 11/23/2022
	*/
	/*
	$result  = $mysql->query( "SELECT s.SymbolCode, s.SymbolCategory FROM symbols s WHERE s.SymbolCategory <> 'Custom Symbols' AND (SELECT COUNT(*) FROM SymbolCustomers sc WHERE sc.SymbolID = s.SymbolID AND sc.CustomerID = '0') = 1 ORDER BY s.SymbolCategory, s.SymbolCode;" );
	*/
	$result  = $mysql->query( "SELECT s.SymbolCode, s.SymbolCategory FROM symbols s WHERE s.SymbolCategory <> 'Custom Symbols' AND s.ShowOnPublicSite = 'Y' ORDER BY s.SymbolCategory, s.SymbolCode;" );

	
	
    $symbols = $result->fetch_all( MYSQLI_ASSOC );
    $mysql->close();

    $symbols_grouped = array();
    foreach ( $symbols as $symbol ) {
        if($symbol['SymbolCategory'] == "Custom Symbols") {
            continue; // Skip 'Custom Symbols' category in database.
        } else if ($symbol['SymbolCategory'] == "Medals/National"){
            $symbol['SymbolCategory'] = $symbol['SymbolCategory'] . "*"; // Add asterisk
        }
        $symbols_grouped[ $symbol['SymbolCategory'] ][] = $symbol['SymbolCode'];
    }
    $symbols = null;

    ob_start();
    ?>
    <div class="symbol-list columns">
        <?php foreach ( $symbols_grouped as $category => $symbol_array ) {
            echo '<div class="symbol-list-container"><h2>' . $category . '</h2><div class="symbol-list-symbols clear">';
            foreach ( $symbol_array as $symbol ) {
                echo '<div class="col col-5">
                <a href="http://www.bricksrus.com/symbolsnew/' . strtoupper( preg_replace( "/\s|&nbsp;/", '%20', $symbol ) ) . '.jpg" rel="'.$category.'" class="colorbox image">
                    <img class="lazy" data-original="http://www.bricksrus.com/symbolsnew/' . strtoupper( preg_replace( "/\s|&nbsp;/", '%20', $symbol ) ) . '.jpg" src="' . create_placeholder_image( 137, 165 ) . '" width="137" height="165" alt="Bricks R Us ' . $category . ' Symbol" style="background-color:white;">
                </a>    
                </div>';
            }
            echo '</div></div>';
        } ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('donors','output_donors_page');
function output_donors_page($atts) {
    $mysql = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, 'bricksrusdb' );
    if ( $mysql->connect_error ) {
        $mysql->close();
        return;
    }
    $result  = $mysql->query( "SELECT OrganizationName, DonorSiteAddress, IF(SiteCompleted IS NULL OR SiteCompleted > '2017-07-24', 1, 0) AS NewFormat FROM donorsiterequests WHERE OrganizationName IS NOT NULL AND OrganizationName != '' AND SiteCompleted IS NOT NULL AND HideFromDonatePage = 'N' AND SiteDisabled = 'N' ORDER BY OrganizationName" );
    $sites = $result->fetch_all( MYSQLI_ASSOC );
    $mysql->close();

    ob_start();
    ?>
    <table class="donor-list clear">
        <thead>
            <tr>
                <th><span class="title">Donor Name</span></th>
                <th><span class="url">Website</span></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($sites as $site){
                $name     = iconv('ISO-8859-1', 'UTF-8', $site['OrganizationName']); //iconv added to avoid blank page issue with non-standard characters by drewadesigns.com on 4/30/2020
                $linkname = $site['DonorSiteAddress'];
                $url      = 'https://www.bricksrus.com/' . ($site['NewFormat'] ? 'donorsite' : 'order') . '/' . $linkname;
                echo "<tr><td><span class=\"name\">$name</span></td><td><a target=\"_blank\" href=\"$url\">$linkname</a></td></tr>";
            }?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}

/**
 * Function to create a data-uri placeholder image - useful for lazy-loading.
 *
 * @param int  $width
 * @param int  $height
 * @param array $color
 *
 * @return string data uri to set as 'src' attribute for image.
 */
function create_placeholder_image( $width = 1, $height = 1, $color = false ) {
    if(!$color) $color = apply_filters('placeholder_image_color', array(255, 255, 255));
    $image = imagecreate( $width, $height );
    $color = imagecolorallocate($image, $color[0], $color[1], $color[2]);
    imagefill($image, 0, 0, $color);
    ob_start();
    imagegif($image);
    $string = ob_get_clean();
    imagedestroy($image);
    return 'data:image/png;base64,'.base64_encode($string);
}

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	
	add_action( 'wp_footer', 'mycustom_wp_footer' );
 
	function mycustom_wp_footer() { ?>
	<script type="text/javascript">
	document.addEventListener( 'wpcf7mailsent', function( event ) {
		
		if(typeof(__gaTracker) == 'function' || typeof(ga) == 'function') {
			var ga = (typeof(ga) == 'undefined') ? __gaTracker : ga ;
			switch (event.detail.contactFormId){
				case '209':
					ga('send', 'event', 'Information & Sample Request Form', 'sent');
					break;
				case '211':
					ga('send', 'event', 'Callback Request Form', 'sent');
					break;
				case '2829':
					ga('send', 'event', 'Fundraising Contact Form', 'sent');
					if(typeof(fbq === 'function') && window.location.href.indexOf('charities') > 0){fbq.push('track','Lead');}if(typeof(window.google_trackConversion) == "function"){window.google_trackConversion({google_conversion_id: 1071447394,google_conversion_language: "en",google_conversion_format: "1",google_conversion_color: "ffffff",google_conversion_label: "33IiCIzJRhDi-vP-Aw",google_conversion_value: 1.00,google_conversion_currency: "USD",google_remarketing_only: false});}
					break;
			}
		}
	

		
	}, false );
	</script>
	<?php }

    /// Disables Embeds

    function cb_disable_peskies_disable_embeds_rewrites( $rules ) {
        foreach ( $rules as $rule => $rewrite ) {
            if ( false !== strpos( $rewrite, 'embed=true' ) ) {
                unset( $rules[ $rule ] );
            }
        }
        return $rules;
    }

    function cb_disable_peskies_disable_embeds_tiny_mce_plugin( $plugins ) {
        return array_diff( $plugins, array( 'wpembed' ) );
    }

    function cb_disable_peskies_disable_embeds_remove_rewrite_rules() {
        add_filter( 'rewrite_rules_array', 'cb_disable_peskies_disable_embeds_rewrites' );
        flush_rewrite_rules();
    }

    function cb_disable_peskies_disable_embeds_flush_rewrite_rules() {
        remove_filter( 'rewrite_rules_array', 'cb_disable_peskies_disable_embeds_rewrites' );
        flush_rewrite_rules();
    }


    function cb_disable_peskies_disable_embeds()
    {

        // Remove the REST API endpoint.
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );

        // Turn off oEmbed auto discovery.
        add_filter( 'embed_oembed_discover', '__return_false' );

        // Don't filter oEmbed results.
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

        // Remove oEmbed discovery links.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );

        add_filter( 'tiny_mce_plugins', 'cb_disable_peskies_disable_embeds_tiny_mce_plugin' );

        // Remove all embeds rewrite rules.
        add_filter( 'rewrite_rules_array', 'cb_disable_peskies_disable_embeds_rewrites' );


    }

    add_action( 'init', 'cb_disable_peskies_disable_embeds', 99 );
    register_activation_hook( __FILE__, 'cb_disable_peskies_disable_embeds_remove_rewrite_rules' );
    register_deactivation_hook( __FILE__, 'cb_disable_peskies_disable_embeds_flush_rewrite_rules' );
?>