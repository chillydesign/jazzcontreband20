<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: webfactor.com | @webfactor
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
    External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
    Theme Support
\*------------------------------------*/

if (!isset($content_width)) {
    $content_width = 900;
}

if (function_exists('add_theme_support')) {
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 1400, '', true); // Large Thumbnail
    add_image_size('medium', 700, '', true); // Medium Thumbnail
    add_image_size('small', 350, '', true); // Small Thumbnail
    add_image_size('square', 200, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

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
    load_theme_textdomain('webfactor', get_template_directory() . '/languages');
}

/*------------------------------------*\
    Functions
\*------------------------------------*/

// webfactor  navigationh
function webfactor_nav()
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

function wf_version()
{
    return '0.1.0';
}

// Load webfactor  scripts (header.php)webfactor
function webfactor_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

       // wp_deregister_script( 'jquery' );


        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        $gkey = 'AIzaSyBvf6VrRRqDk5QwEGY6gavuqpSdpiMU_3k';
        wp_register_script('wf_google_maps', '//maps.google.com/maps/api/js?key=' . $gkey, array(), '', true); // Custom scripts
        wp_enqueue_script('wf_google_maps'); // Enqueue it!
    }
}


// Load webfactor  conditional scripts
function webfactor_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load webfactor  styles
function webfactor_styles()
{
    wp_dequeue_style('wp-block-library');

    wp_register_style('wf_style', get_template_directory_uri() . '/css/global.css', array(), wf_version(), 'all');
    wp_enqueue_style('wf_style'); // Enqueue it!

    wp_register_style('featherlight', get_template_directory_uri() . '/css/featherlight.min.css', array(), '1.0', 'all');
    wp_enqueue_style('featherlight'); // Enqueue it!
    wp_register_style('featherlight-gallery', get_template_directory_uri() . '/css/featherlight.gallery.min.css', array(), '1.0', 'all');
    wp_enqueue_style('featherlight-gallery'); // Enqueue it!
    wp_register_style('justifiedGallery', get_template_directory_uri() . '/css/justifiedGallery.min.css', array(), '1.0', 'all');
    wp_enqueue_style('justifiedGallery'); // Enqueue it!
}

// Register webfactor  Navigation
function register_webfactor_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'webfactor'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'webfactor'), // Sidebar Navigation
        'loggedin-menu' => __('Logged In Menu', 'webfactor') // Extra Navigation if needed (duplicate as many as you need!)
    ));
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

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'webfactor'),
        'description' => __('Description for this widget-area...', 'webfactor'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'webfactor'),
        'description' => __('Description for this widget-area...', 'webfactor'),
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
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function webfactorwp_pagination()
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
function webfactorwp_index($length) // Create 20 Word Callback for Index page Excerpts, call using webfactorwp_excerpt('webfactorwp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using webfactorwp_excerpt('webfactorwp_custom_post');
function webfactorwp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function webfactorwp_excerpt($length_callback = '', $more_callback = '')
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

// Custom View Article link to Post
function webfactor__view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'webfactor') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function webfactor_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html)
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function webfactorgravatar($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() and comments_open() and (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function webfactorcomments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ('div' == $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    } ?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ('div' != $args['style']) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) {
        echo get_avatar($comment, $args['180']);
    } ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
		<?php
            printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'), '  ', ''); ?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ('div' != $args['style']) : ?>
	</div>
	<?php endif; ?>
<?php
}

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'webfactor_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'webfactor_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'webfactor_styles'); // Add Theme Stylesheet
add_action('init', 'register_webfactor_menu'); // Add webfactor  Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'webfactorwp_pagination'); // Add our webfactor Pagination

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
add_filter('avatar_defaults', 'webfactorgravatar'); // Custom Gravatar in Settings > Discussion
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
add_filter('excerpt_more', 'webfactor__view_article'); // Add 'View Article' button instead of [...] for Excerpts
// add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'webfactor_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('webfactor_shortcode_demo', 'webfactor_shortcode_demo'); // You can place [webfactor_shortcode_demo] in Pages, Posts now.
add_shortcode('webfactor_shortcode_demo_2', 'webfactor_shortcode_demo_2'); // Place [webfactor_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [webfactor_shortcode_demo] [webfactor_shortcode_demo_2] Here's the page title! [/webfactor_shortcode_demo_2] [/webfactor_shortcode_demo]

/*------------------------------------*\
    Custom Post Types
\*------------------------------------*/

/*------------------------------------*\
    ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function webfactor_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function webfactor_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}




function chilly_nav($menu)
{
    wp_nav_menu(
        array(
        'theme_location'  => $menu,
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
        'items_wrap'      => '%3$s',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}

function chilly_map($atts, $content = null)
{
    $attributes = shortcode_atts(array(
        'title' => "Rue du Midi 15 Case postale 411 1020 Renens"
    ), $atts);



    $title = $attributes['title'];
    $chilly_map = '<div id="map_container_1"></div>';
    $chilly_map .= "<script> var latt = 46.5380683; var lonn=6.5812023; var map_title = '" . $title . "'  </script>";
    return $chilly_map;
}
add_shortcode('chilly_map', 'chilly_map');


function disable_wp_emojicons()
{

  // all actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // filter to remove TinyMCE emojis
  // add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action('init', 'disable_wp_emojicons');


function remove_json_api()
{

    // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');
    // Turn off oEmbed auto discovery.
    add_filter('embed_oembed_discover', '__return_false');
    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
    // Remove all embeds rewrite rules.
  // add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
}
add_action('after_setup_theme', 'remove_json_api');




function count_to_bootstrap_class($count)
{
    if ($count == 1) {
        $class = 'col-sm-12';
    } elseif ($count == 2) {
        $class = 'col-sm-6';
    } elseif ($count == 3) {
        $class = 'col-sm-4';
    } elseif ($count == 4) {
        $class = 'col-sm-3 col-xs-6';
    } elseif ($count <= 6) {
        $class = 'col-sm-2';
    } else {
        $class = 'col-sm-1';
    }
    return $class;
};

function thumbnail_of_post_url($post_id, $size='large')
{
    $image_id = get_post_thumbnail_id($post_id);
    $image_url = wp_get_attachment_image_src($image_id, $size);
    $image = $image_url[0];
    return $image;
}



include('functions_jazz.php');
include('functions_create_reperage.php');



function admin_default_page()
{
    $redirectto = get_home_url() . '/espace-membres';
    return $redirectto;
}

add_filter('login_redirect', 'admin_default_page');


add_filter('the_password_form', 'custom_password_form');
function custom_password_form()
{
    global $post;
    $label = 'pwbox-'.(empty($post->ID) ? rand() : $post->ID);
    $o = '<form class="protected-post-form" action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '"
 method="post">
    ' . __("<section class=\"section  section_colonnes\"><div class=\"container section1col\"><div class=\"column_container\"><div class=\"sectioncol col-sm-12 white colnmb1\"><div class=\"content\"><h1 style=\"text-align: center;margin-bottom:40px;\">Espace Presse</h1></div></div></div></div></section><section class=\"section  section_colonnes yellow_box\" style=\"padding-top:50px;\"><div class=\"container section2col\"><div class=\"column_container\"><div class=\"sectioncol column stripes colnmb1\" style=\"height: 569px;\"><div class=\"title\"><h2><strong>CONNEXION</strong></a></h2></div><div class=\"content\"><p style = \"margin-botton:-10px\">Pour accéder à l’espace presse, merci d’entrer le mot de passe :</p>") . '
    <label class="pass-label" for="' . $label . '">' . __("Mot de passe:") . ' </label><input name="post_password" id="' . $label . '" type="password" style="background: #ffffff; border:1px solid #999; color:#333333; padding:10px;" size="20" /><input type="submit" name="Submit" class="button" value="' . esc_attr__("Envoyer") . '" />
    </form><p style="font-size:14px;margin:0px;"></div></div><div class="sectioncol column checkers colnmb2"><div class="title"><h2><strong>DEMANDE D\'ACCÈS</strong></h2></div><div class="content"><p>Pour obtenir le code d’accès, veuillez contacter:</p><p><strong>Agathe Denis</strong><br>Coordinatrice JazzContreBand<br>agathe@jazzcontreband.com</p></div></div></div></div></section>
    ';
    return $o;
}


$args = array(

    /* (string) The title displayed on the options page. Required. */
    'page_title' => 'Type d\'évènement à afficher',

    /* (string) The title displayed in the wp-admin sidebar. Defaults to page_title */
    'menu_title' => 'Options Evnt',

    /* (string) The slug name to refer to this menu by (should be unique for this menu).
    Defaults to a url friendly version of menu_slug */
    'menu_slug' => 'event-type',

    /* (string) The capability required for this menu to be displayed to the user. Defaults to edit_posts.
    Read more about capability here: http://codex.wordpress.org/Roles_and_Capabilities */
    'capability' => 'manage_options',

    /* (int|string) The position in the menu order this menu should appear.
    WARNING: if two menu items use the same position attribute, one of the items may be overwritten so that only one item displays!
    Risk of conflict can be reduced by using decimal instead of integer values, e.g. '63.3' instead of 63 (must use quotes).
    Defaults to bottom of utility menu items */
    'position' => false,

    /* (string) The slug of another WP admin page. if set, this will become a child page. */
    'parent_slug' => '',

    /* (string) The icon class for this menu. Defaults to default WordPress gear.
    Read more about dashicons here: https://developer.wordpress.org/resource/dashicons/ */
    'icon_url' => false,

    /* (boolean) If set to true, this options page will redirect to the first child page (if a child page exists).
    If set to false, this parent page will appear alongside any child pages. Defaults to true */
    'redirect' => true,

    /* (int|string) The '$post_id' to save/load data to/from. Can be set to a numeric post ID (123), or a string ('user_2').
    Defaults to 'options'. Added in v5.2.7 */
    'post_id' => 'options',

    /* (boolean)  Whether to load the option (values saved from this options page) when WordPress starts up.
    Defaults to false. Added in v5.2.8. */
    'autoload' => false,

);
acf_add_options_page($args);




function nice_event_dates($dates)
{
    if (sizeof($dates) == 0) {
        return '-';
    } elseif (sizeof($dates) == 1) {
        $nice_date =  strftime('%d.%m', strtotime(current($dates[0])));
        return $nice_date;
    } else {
        $first = current($dates);
        $last = end($dates);
        $nice_first =  strftime('%d', strtotime(current($first)));
        $nice_last =  strftime('%d.%m', strtotime(current($last)));
        return $nice_first . ' → '  . $nice_last;
    }
}


// requred to keep track of what color column we should be using
$color_classes = ['yellow_box', 'black_box', 'grey_box'];
$ccc = 0;


?>
