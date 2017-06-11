<?php
//
//  Custom Child Theme Functions
//
/*  SWAPS ACCESS AND HEADER  */
function thinkup_remove_thematic_actions() {
  //Remove Thematic's Navigation
  remove_action('thematic_header', 'thematic_access', 9);
}
add_action('init', 'thinkup_remove_thematic_actions');
//change header order
add_action('thematic_header', 'thematic_access', 1);
// change Thematic #access menu for a Wordpress 3.0 menu
function child_access_menu() {
	$menu_sys = 'wp_nav_menu';
	return $menu_sys;
}
add_filter('thematic_menu_type', 'child_access_menu');

// Wp Enqueue Google Fonts
function add_FontsAndScripts(){
  wp_enqueue_style( 'add_Raleway', 'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,70', false);
  wp_enqueue_script( 'iden-custom', get_stylesheet_directory_uri() . '/idens.js', array(), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'add_FontsAndScripts');



//Customize Post Nav Below Links
function childtheme_override_previous_post_link(){
	$args = array (
			'format'              => '%link',
			'link'                => '<span class="meta-nav">&laquo;</span> Previous',
			'in_same_cat'         => TRUE,
			'excluded_categories' => ''
		);

		$args = apply_filters('thematic_previous_post_link_args', $args );

		previous_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
	}

function childtheme_override_next_post_link() {
$args = array (
			'format' => '%link',
			'link' => 'Next <span class="meta-nav">&raquo;</span>',
			'in_same_cat' => TRUE,
			'excluded_categories' => ''
		);

		$args = apply_filters('thematic_next_post_link_args', $args );
		next_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
	}

// Remove Theme Post Meta
function childtheme_override_postheader_postmeta(){}
// Remove Post Footer Connect
function childtheme_override_postfooter_postconnect(){}
// Remove Post footer post category
function childtheme_override_postfooter_postcategory(){}
// Remove Post Footer Permalink Bookmark
function  childtheme_override_postfooter(){
	$post_type = get_post_type();
	    $post_type_obj = get_post_type_object($post_type);

		// Check for "Page" post-type and logged in user to show edit link
	    if ( $post_type == 'page' && current_user_can('edit_posts') ) {
	        $postfooter = '<div class="entry-utility">' . thematic_postfooter_posteditlink();
	        $postfooter .= "</div><!-- .entry-utility -->\n";
	    // Display nothing for logged out users on a "Page" post-type
	    } elseif ( $post_type == 'page' ) {
	        $postfooter = '';
	    // For post-types other than "Pages" press on
	    } else {
	    	$postfooter = '<div class="entry-utility">';
	        if ( is_single() ) {
	        	$post_type_archive_link = ( function_exists( 'get_post_type_archive_link' )  ? get_post_type_archive_link( $post_type ) :  home_url( '/?post_type=' . $post_type ) );
	        	if ( thematic_is_custom_post_type() && $post_type_obj->has_archive ) {
	        		$postfooter .= __('Browse the ', 'thematic') . '<a href="' . $post_type_archive_link . '" title="' . __('Permalink to ', 'thematic') . $post_type_obj->labels->singular_name . __(' Archive', 'thematic') . '">';
	        		$postfooter .= $post_type_obj->labels->singular_name . '</a>' . __(' archive', 'thematic') . '. ';
	        	}
	        		if ( post_type_supports( $post_type, 'comments') ) {
	            		$postfooter .= thematic_postfooter_postconnect();
	            	}
	        } elseif ( post_type_supports( $post_type, 'comments') ) {
	        	$postfooter .= thematic_postfooter_posttax();
	            $postfooter .= thematic_postfooter_postcomments();
	        }
	       	// Display edit link
	    	if (current_user_can('edit_posts')) {
	    		if ( !is_single() && post_type_supports( $post_type, 'comments') ) {
	        		$postfooter .= "\n\n\t\t\t\t\t\t" . '<span class="meta-sep meta-sep-edit">|</span> ';
	        	}
	        	$postfooter .= ' ' . thematic_postfooter_posteditlink();
	    	}
	    	$postfooter .= "\n\n\t\t\t\t\t</div><!-- .entry-utility -->\n";
	    }
	    // Put it on the screen
	    echo apply_filters( 'thematic_postfooter', $postfooter ); // Filter to override default post footer
}


/*  New Widget for GUILD Mention */

function iden_guild() {
  register_sidebar(array(
        'name' => 'Guild',
        'id' => 'guild',
        ));
}
add_action('init', 'iden_guild');

// adding this to the theme below the site-description

function guild_widget() {
  if ( function_exists('dynamic_sidebar') && is_active_sidebar('Guild') ) {
    echo '<div id="guild" >'. "\n";
    dynamic_sidebar('Guild');
    echo '' . "\n" . '</div><!-- #guild -->'. "\n";
  }
}
add_action('thematic_header', 'guild_widget', 4);


?>
