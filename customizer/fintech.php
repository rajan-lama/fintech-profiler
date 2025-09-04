<?php
/**
 * Home Page Options
 *
 * @package fintech_profiler
 */
 
function fintech_profiler_customize_register_home( $wp_customize ) {

    /** Home Page Settings */
    $wp_customize->add_panel( 
        'fintech_profiler_home_page_settings',
         array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'title' => __( 'Fintech Page Settings', 'fintech-provider' ),
            'description' => __( 'Customize Home Page Settings', 'fintech-provider' ),
        ) 
    );
    
     /** Slider Settings */
    $wp_customize->add_section(
        'fintech_profiler_slider_section_settings',
        array(
            'title'     => __( 'Slider Settings', 'fintech-provider' ),
            'priority'  => 10,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_home_page_settings'
        )
    );
   
    /** Enable/Disable Slider */
    $wp_customize->add_setting(
        'fintech_profiler_ed_slider',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_ed_slider',
        array(
            'label' => __( 'Enable Home Page Slider', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Auto Transition */
    $wp_customize->add_setting(
        'fintech_profiler_slider_auto',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_slider_auto',
        array(
            'label' => __( 'Enable Slider Auto Transition', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Loop */
    $wp_customize->add_setting(
        'fintech_profiler_slider_loop',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_slider_loop',
        array(
            'label' => __( 'Enable Slider Loop', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Pager */
    $wp_customize->add_setting(
        'fintech_profiler_slider_pager',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_slider_pager',
        array(
            'label' => __( 'Enable Slider Pager', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Caption */
    $wp_customize->add_setting(
        'fintech_profiler_slider_caption',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_slider_caption',
        array(
            'label' => __( 'Enable Slider Caption', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'checkbox',
        )
    );
        
    /** Slider Animation */
    $wp_customize->add_setting(
        'fintech_profiler_slider_animation',
        array(
            'default' => 'slide',
            'sanitize_callback' => 'fintech_profiler_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_slider_animation',
        array(
            'label' => __( 'Select Slider Animation', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'select',
            'choices' => array(
                'fade' => __( 'Fade', 'fintech-provider' ),
                'slide' => __( 'Slide', 'fintech-provider' ),
            )
        )
    );
    
    /** Slider Speed */
    $wp_customize->add_setting(
        'fintech_profiler_slider_speeds',
        array(
            'default' => 400,
            'sanitize_callback' => 'fintech_profiler_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_slider_speeds',
        array(
            'label' => __( 'Slider Speed', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'text',
        )
    );
    
    /** Slider Pause */
    $wp_customize->add_setting(
        'fintech_profiler_slider_pause',
        array(
            'default' => 6000,
            'sanitize_callback' => 'fintech_profiler_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_slider_pause',
        array(
            'label' => __( 'Slider Pause', 'fintech-provider' ),
            'section' => 'fintech_profiler_slider_section_settings',
            'type' => 'text',
        )
    );
    
    // for( $i=1; $i<=3; $i++){  
    //     /** Select Slider Post */
    //     $wp_customize->add_setting(
    //         'fintech_profiler_slider_post_'.$i,
    //         array(
    //             'default' => '',
    //             'sanitize_callback' => 'fintech_profiler_sanitize_select',
    //         )
    //     );
        
    //     $wp_customize->add_control(
    //         'fintech_profiler_slider_post_'.$i,
    //         array(
    //             'label' => __( 'Select Post ', 'fintech-provider' ).$i,
    //             'section' => 'fintech_profiler_slider_section_settings',
    //             'type' => 'select',
    //             'choices' => array(),
    //         )
    //     );

    // }

     /** Slider Readmore */
    // $wp_customize->add_setting(
    //     'fintech_profiler_slider_readmore',
    //     array(
    //         'default' => __( 'Learn More', 'fintech-provider' ),
    //         'sanitize_callback' => 'sanitize_text_field',
    //     )
    // );
    
    // $wp_customize->add_control(
    //     'fintech_profiler_slider_readmore',
    //     array(
    //         'label' => __( 'Readmore Text', 'fintech-provider' ),
    //         'section' => 'fintech_profiler_slider_section_settings',
    //         'type' => 'text',
    //     )
    // );
    
    /** Slider Settings Ends */
  
    /** more_info Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_more_info_section_settings',
        array(
            'title' => __( 'More Information 1 Section', 'fintech-provider' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_home_page_settings'
        )
    );
    
    /** Enable more_info Section */   
    $wp_customize->add_setting(
        'fintech_profiler_ed_more_info_1_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_ed_more_info_1_section',
        array(
            'label' => __( 'Enable More Information Section 1', 'fintech-provider' ),
            'section' => 'fintech_profiler_more_info_section_settings',
            'type' => 'checkbox',
        )
    );

    /** more_info First Button */
    $wp_customize->add_setting(
        'fintech_profiler_more_info_1_section_title',
        array(
            'default'=> __( 'About Us', 'fintech-provider' ),
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_more_info_1_section_title',
        array(
              'label' => __('More Information','fintech-provider'),
              'section' => 'fintech_profiler_more_info_section_settings', 
              'type' => 'text',
            )
        );

    /** more_info First Button */
    $wp_customize->add_setting(
        'fintech_profiler_more_info_1_section_description',
        array(
            'default'=> '',
            'sanitize_callback'=> 'wp_kses_post'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_more_info_1_section_description',
        array(
              'label' => __('More Information Details','fintech-provider'),
              'section' => 'fintech_profiler_more_info_section_settings', 
              'type' => 'textarea',
            )
        );

    /** more_info Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_more_info_2_section_settings',
        array(
            'title' => __( 'More Information 2 Section', 'fintech-provider' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_home_page_settings'
        )
    );
    
    /** Enable more_info Section */   
    $wp_customize->add_setting(
        'fintech_profiler_ed_more_info_2_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_ed_more_info_2_section',
        array(
            'label' => __( 'Enable more_info Us Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_more_info_2_section_settings',
            'type' => 'checkbox',
        )
    );

    /** more_info First Button */
    $wp_customize->add_setting(
        'fintech_profiler_more_info_2_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_more_info_2_section_title',
        array(
              'label' => __('Section Title','fintech-provider'),
              'section' => 'fintech_profiler_more_info_2_section_settings', 
              'type' => 'text',
            ));

     /** More Information First Button Link */
    $wp_customize->add_setting(
        'fintech_profiler_more_info_url',
        array(
            'default'=> '#',
            'sanitize_callback'=> 'esc_url_raw'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_more_info_url',
        array(
              'label' => __('Website','fintech-provider'),
              'section' => 'fintech_profiler_more_info_2_section_settings', 
              'type' => 'text',
            ));


    /** more_info First Button */
    $wp_customize->add_setting(
        'fintech_profiler_more_info_email',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_more_info_email',
        array(
              'label' => __('Email','fintech-provider'),
              'section' => 'fintech_profiler_more_info_2_section_settings', 
              'type' => 'text',
            ));

    /** more_info First Button */
    $wp_customize->add_setting(
        'fintech_profiler_more_info_phone',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_more_info_phone',
        array(
              'label' => __('Phone','fintech-provider'),
              'section' => 'fintech_profiler_more_info_2_section_settings', 
              'type' => 'text',
            ));

    /** more_info First Button */
    $wp_customize->add_setting(
        'fintech_profiler_more_info_location',
        array(
            'default'=> '',
            'sanitize_callback'=> 'wp_kses_post'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_more_info_location',
        array(
              'label' => __('Location','fintech-provider'),
              'section' => 'fintech_profiler_more_info_2_section_settings', 
              'type' => 'textarea',
            ));

        
   /** Enable Related Post Section */
    $wp_customize->add_setting(
        'fintech_profiler_ed_share',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_ed_share',
        array(
            'label' => __( 'Enable Social Share', 'fintech-provider' ),
            'section' => 'fintech_profiler_more_info_2_section_settings',
            'type' => 'checkbox',
        )
    );
    

    /** Blog Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_related_post_section_settings',
        array(
            'title' => __( 'Related Posts Section', 'fintech-provider' ),
            'priority' => 80,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_home_page_settings'
        )
    );
    
   /** Enable Related Post Section */
    $wp_customize->add_setting(
        'fintech_profiler_ed_related_post_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_ed_related_post_section',
        array(
            'label' => __( 'Enable Related Post Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_related_post_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Blog Section Title */
    $wp_customize->add_setting(
        'fintech_profiler_related_post_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
        ));

    $wp_customize->add_control(
        'fintech_profiler_related_post_section_title',
        array(
            'label' => __( 'Related Posts Section Title', 'fintech-provider' ),
            'section' => 'fintech_profiler_related_post_section_settings',
            'type' => 'text',
        )
    );
    // /** Show/Hide Blog Date */
    // $wp_customize->add_setting(
    //     'fintech_profiler_ed_related_post_date',
    //     array(
    //         'default' => '1',
    //         'sanitize_callback' => 'fintech_profiler_sanitize_checkbox',
    //     )
    // );
    
    // $wp_customize->add_control(
    //     'fintech_profiler_ed_related_post_date',
    //     array(
    //         'label' => __( 'Show Posts Date, Author, Comment, Category', 'fintech-provider' ),
    //         'section' => 'fintech_profiler_related_post_section_settings',
    //         'type' => 'checkbox',
    //     )
    // );
     
}
add_action( 'customize_register', 'fintech_profiler_customize_register_home' );
