<?php
/**
 * Breadcrumbs Options
 *
 * @package fintech_profiler
 */
 
function fintech_profiler_customize_register_breadcrumbs( $wp_customize ) {

    /** BreadCrumb Settings */
    
    $wp_customize->add_section(
        'fintech_profiler_breadcrumb_settings',
        array(
            'title' => __( 'Breadcrumb Settings', 'fintech-profiler' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Enable/Disable BreadCrumb */
    $wp_customize->add_setting(
        'fintech_profiler_ed_breadcrumb',
        array(
            'default' => '',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_ed_breadcrumb',
        array(
            'label' => __( 'Enable Breadcrumb', 'fintech-profiler' ),
            'section' => 'fintech_profiler_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Show/Hide Current */
    $wp_customize->add_setting(
        'fintech_profiler_ed_current',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_ed_current',
        array(
            'label' => __( 'Show current', 'fintech-profiler' ),
            'section' => 'fintech_profiler_breadcrumb_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Home Text */
    $wp_customize->add_setting(
        'fintech_profiler_breadcrumb_home_text',
        array(
            'default' => __( 'Home', 'fintech-profiler' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_breadcrumb_home_text',
        array(
            'label' => __( 'Breadcrumb Home Text', 'fintech-profiler' ),
            'section' => 'fintech_profiler_breadcrumb_settings',
            'type' => 'text',
        )
    );
    
    /** Breadcrumb Separator */
    $wp_customize->add_setting(
        'fintech_profiler_breadcrumb_separator',
        array(
            'default' => __( '>', 'fintech-profiler' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_breadcrumb_separator',
        array(
            'label' => __( 'Breadcrumb Separator', 'fintech-profiler' ),
            'section' => 'fintech_profiler_breadcrumb_settings',
            'type' => 'text',
        )
    );
    /** BreadCrumb Settings Ends */
    
    }
add_action( 'customize_register', 'fintech_profiler_customize_register_breadcrumbs' );
