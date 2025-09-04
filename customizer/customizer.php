<?php
/**
 * Bakery Shop Theme Customizer.
 *
 * @package fintech_profiler
 */

    $fintech_profiler_settings = array( 'default', 'fintech', 'breadcrumb'  );

    // /* Option list of all categories */
    // $fintech_profiler_args = array(
	  //  'type'                     => 'post',
	  //  'orderby'                  => 'name',
	  //  'order'                    => 'ASC',
	  //  'hide_empty'               => 1,
	  //  'hierarchical'             => 1,
	  //  'taxonomy'                 => 'category'
    // ); 
    // $fintech_profiler_option_categories = array();
    // $fintech_profiler_category_lists = get_categories( $fintech_profiler_args );
    // $fintech_profiler_option_categories[''] = __( 'Choose Category', 'fintech-profiler' );
    // foreach( $fintech_profiler_category_lists as $fintech_profiler_category ){
    //     $fintech_profiler_option_categories[$fintech_profiler_category->term_id] = $fintech_profiler_category->name;
    // }

	foreach( $fintech_profiler_settings as $setting ){
		require FINTECH_PROFILER_BASE . 'customizer/' . $setting . '.php';
	}

/**
 * Font Awesome List
 */
// require FINTECH_PROFILER_BASE . 'fontawesome-list.php';

/**
 * Sanitization Functions
*/
require FINTECH_PROFILER_BASE . 'customizer/sanitization-functions.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function fintech_profiler_customize_preview_js() {
    wp_enqueue_script( 'fintech_profiler_customizer', FINTECH_PROFILER_BASE_URL . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'fintech_profiler_customize_preview_js' );

/**
 * Enqueue Scripts for customize controls
*/
function fintech_profiler_customize_scripts() {
    wp_enqueue_style( 'font-awesome', FINTECH_PROFILER_BASE_URL .'css/font-awesome.css');   
    wp_enqueue_style( 'fintech-profiler-admin-style',FINTECH_PROFILER_BASE_URL.'css/admin.css', '1.0', 'screen' );    
    //wp_enqueue_script( 'fintech-profiler-admin-js', FINTECH_PROFILER_BASE_URL.'js/admin.js', array( 'jquery' ), '', true );
}
add_action( 'customize_controls_enqueue_scripts', 'fintech_profiler_customize_scripts' );