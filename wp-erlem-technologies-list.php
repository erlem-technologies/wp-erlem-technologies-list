<?php
/*
Plugin Name: WP Erlem Technologies List
Plugin URI: https://www.erlem-technologies.com
Description: List aticle or page
Version: 0.1.0
Author: Erlem Technologies
Author URI: https://www.erlem-technologies.com
License: GPL3
*/

function wp_erlem_technologies_list($atts){

    // Values
    /*
        id_css: *
        class_css: *
        title_header: h1 | h2 | h3 | h4 | h5 | h6 | p

    */

    // get the parameters
    $atts = shortcode_atts(
    array(
        'post_type' => 'page',
        'post_parent' => get_the_ID(),
        'posts_per_page' => 50,
        'orderby' => 'menu_order',
        'order'   => 'ASC',
        'id_css' => 'wp_erlem_technologies_list',
        'class_css' => 'list',
        'item_column_class_css' => 'column',
        'item_class_css' => 'item',
        'title_link' => 'yes',
        'title_header' => 'h2',
        'content' => 'yes',
        'content_class' => 'content',
    ), $atts);

    // Transforms the parameters into variables
    extract($atts);

    // The Query
    $query_list = new WP_Query($atts);

    $string = '';
    $string .= '<div id="'.$id_css.'" class="'.$class_css.'">';

    if($query_list->have_posts()) :
            while ($query_list->have_posts() ) : $query_list->the_post();
                $string .= '<div class="'.$item_class_css.'">';
                    $string .= '<div><a href="'.get_permalink().'">'.get_the_post_thumbnail().'</a></div>';

                    // Title
                    if ($title_link == "yes" ) {
                        $string .= '<a href="'.get_permalink().'"><'.$title_header.'>'.get_the_title().'</'.$title_header.'></a>';
                        $string .= '<hr>';
                    }
                    else {
                        $string .= '<'.$title_header.'>'.get_the_title().'</'.$title_header.'>';
                    }

                    // title
                    if ($content == "yes" ) {
                        $string .= '<div class="'.$content_class.'">'.get_the_content().'</div>';
                    }

            $string .= '</div>';
        endwhile;
    endif;

    wp_reset_postdata();

    $string .= '</div>';

    return $string;
}

/**
 * Register style sheet.
 */
function register_plugin_styles() {
	wp_register_style( 'wp-erlem-technologies-list', plugins_url( 'wp-erlem-technologies-list/css/default.css' ) );
	wp_enqueue_style( 'wp-erlem-technologies-list' );
}

// Register style sheet
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );

// Add shortcode
add_shortcode('wp-erlem-technologies-list', 'wp_erlem_technologies_list');

?>
