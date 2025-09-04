<?php
/**
 * Home Page Options
 *
 * @package fintech_profiler_archive
 */
 
function fintech_profiler_archive_customize_register( $wp_customize ) {

    /** Home Page Settings */
    $wp_customize->add_panel( 
        'fintech_profiler_archive_settings',
         array(
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'title' => __( 'Fintech Page Settings', 'fintech-provider' ),
            'description' => __( 'Customize Home Page Settings', 'fintech-provider' ),
        ) 
    );
    
     /** Slider Settings */
    $wp_customize->add_section(
        'fintech_profiler_archive_slider_section_settings',
        array(
            'title'     => __( 'Slider Settings', 'fintech-provider' ),
            'priority'  => 10,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_archive_settings'
        )
    );
   
    /** Enable/Disable Slider */
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_slider',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_slider',
        array(
            'label' => __( 'Enable Home Page Slider', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Auto Transition */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_auto',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_auto',
        array(
            'label' => __( 'Enable Slider Auto Transition', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Loop */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_loop',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_loop',
        array(
            'label' => __( 'Enable Slider Loop', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Pager */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_pager',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_pager',
        array(
            'label' => __( 'Enable Slider Pager', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Enable/Disable Slider Caption */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_caption',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_caption',
        array(
            'label' => __( 'Enable Slider Caption', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'checkbox',
        )
    );
        
    /** Slider Animation */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_animation',
        array(
            'default' => 'slide',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_animation',
        array(
            'label' => __( 'Select Slider Animation', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'select',
            'choices' => array(
                'fade' => __( 'Fade', 'fintech-provider' ),
                'slide' => __( 'Slide', 'fintech-provider' ),
            )
        )
    );
    
    /** Slider Speed */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_speeds',
        array(
            'default' => 400,
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_speeds',
        array(
            'label' => __( 'Slider Speed', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'text',
        )
    );
    
    /** Slider Pause */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_pause',
        array(
            'default' => 6000,
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_number_absint',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_pause',
        array(
            'label' => __( 'Slider Pause', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'text',
        )
    );
    
    for( $i=1; $i<=3; $i++){  
        /** Select Slider Post */
        $wp_customize->add_setting(
            'fintech_profiler_archive_slider_post_'.$i,
            array(
                'default' => '',
                'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
            )
        );
        
        $wp_customize->add_control(
            'fintech_profiler_archive_slider_post_'.$i,
            array(
                'label' => __( 'Select Post ', 'fintech-provider' ).$i,
                'section' => 'fintech_profiler_archive_slider_section_settings',
                'type' => 'select',
                'choices' => array(),
            )
        );

    }

     /** Slider Readmore */
    $wp_customize->add_setting(
        'fintech_profiler_archive_slider_readmore',
        array(
            'default' => __( 'Learn More', 'fintech-provider' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_slider_readmore',
        array(
            'label' => __( 'Readmore Text', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'text',
        )
    );

    
    /** Enable/Disable Slider */
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_curtain',
        array(
            'default' => '',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_curtain',
        array(
            'label' => __( 'Enable Header Curtain', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_slider_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Slider Settings Ends */
    
    /** Featured Section */
    $wp_customize->add_section(
        'fintech_profiler_archive_feature_section_settings',
        array(
            'title' => __( 'Featured Section', 'fintech-provider' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_archive_settings'
        )
    );
    
    /** Enable/Disable Featured Section */
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_featured_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_featured_section',
        array(
            'label' => __( 'Enable Featured Post Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_feature_section_settings',
            'type' => 'checkbox',
        )
    );
       
    /** Enable/Disable Featured Section Icon*/
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_featured_icon',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_featured_icon',
        array(
            'label' => __( 'Enable Featured Post Icon', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_feature_section_settings',
            'type' => 'checkbox',
        )
    );

    for( $i=1; $i<=3; $i++){  
    
        /** featured Post */
        $wp_customize->add_setting(
            'fintech_profiler_archive_feature_post_'.$i,
            array(
                'default' => '',
                'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
            ));
        
        $wp_customize->add_control(
            'fintech_profiler_archive_feature_post_'.$i,
            array(
                'label'   => __( 'Select Featured Post ', 'fintech-provider' ) .$i ,
                'section' => 'fintech_profiler_archive_feature_section_settings',
                'type'    => 'select',
                'choices' => array()
            ));

        // $wp_customize->add_setting(
        //     'fintech_profiler_archive_feature_icon_'.$i,
        //     array(
        //         'default'           => 'fa fa-bell',
        //         'sanitize_callback' => 'sanitize_text_field',
        //         'transport'         => 'postMessage'
        //     )
        // );

        // $wp_customize->add_control(
        //     new fintech_profiler_archive_Fontawesome_Icon_Chooser(
        //     $wp_customize,
        //     'fintech_profiler_archive_feature_icon_'.$i,
        //         array(
        //             'settings' => 'fintech_profiler_archive_feature_icon_'.$i,
        //             'section'  => 'fintech_profiler_archive_feature_section_settings',
        //             'label'    => __( 'FontAwesome Icon ', 'fintech-provider' ) .$i,
        //         )
        //     )
        // );
        
    }

    /** About Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_archive_about_section_settings',
        array(
            'title' => __( 'About Section', 'fintech-provider' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_archive_settings'
        )
    );
    
    /** Enable about Section */   
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_about_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_about_section',
        array(
            'label' => __( 'Enable Welcome Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_about_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** welcome Section Ends */

    /* Featured Product Section*/
     $wp_customize-> add_section(
        'fintech_profiler_archive_featured_product_settings',
        array(
            'title'=> __('Featured Product Section','fintech-provider'),
            'priority'=> 30,
            'panel'=> 'fintech_profiler_archive_settings'
            )
        );

    /** Enable/Disable featured_dish Section */
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_product_section',
        array(
            'default' => '',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_product_section',
        array(
            'label' => __( 'Enable Featured Product Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_featured_product_settings',
            'type' => 'checkbox',
            'description' => __( 'Please Enable Woocommerce to display items in Featured Products.', 'fintech-provider'),
        )
    );
    
    /*select page for Product section*/
    $wp_customize->add_setting(
        'fintech_profiler_archive_featured_product_page',
        array(
            'default' => '',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_featured_product_page',
        array(
            'label' => __( 'Select Page', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_featured_product_settings',
            'type' => 'select',
            'choices' => array(),
        )
    );

  //  if( fintech_profiler_archive_is_woocommerce_activated() ){
    
  //       for( $i=1; $i<=10; $i++){  
  //           /** Select Slider Post */
  //           $wp_customize->add_setting(
  //               'fintech_profiler_archive_product_post_'.$i,
  //               array(
  //                   'default' => '',
  //                   'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
  //               )
  //           );
            
  //           $wp_customize->add_control(
  //               'fintech_profiler_archive_product_post_'.$i,
  //               array(
  //                   'label' => __( 'Select Product ', 'fintech-provider' ).$i,
  //                   'section' => 'fintech_profiler_archive_featured_product_settings',
  //                   'type' => 'select',
  //                   'choices' => $fintech_profiler_archive_options_products,
  //               )
  //           );
  //       }
    
  //   }
  
    /** cta Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_archive_cta_section_settings',
        array(
            'title' => __( 'CTA Section', 'fintech-provider' ),
            'priority' => 50,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_archive_settings'
        )
    );
    
    /** Enable cta Section */   
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_cta_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_cta_section',
        array(
            'label' => __( 'Enable cta Us Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_cta_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** CTA Section Title */
    $wp_customize->add_setting(
        'fintech_profiler_archive_cta_section_page',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_archive_cta_section_page',
        array(
              'label' => __('Select Page','fintech-provider'),
              'description' => __( 'Featured Image of Selected Page will be set as Background Image of this section.', 'fintech-provider' ),
              'type' => 'select',
              'choices' => array(),
              'section' => 'fintech_profiler_archive_cta_section_settings', 
              
        )
    );
    

    /** CTA First Button */
    $wp_customize->add_setting(
        'fintech_profiler_archive_cta_section_button_one',
        array(
            'default'=> __( 'About Us', 'fintech-provider' ),
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_archive_cta_section_button_one',
        array(
              'label' => __('CTA Button','fintech-provider'),
              'section' => 'fintech_profiler_archive_cta_section_settings', 
              'type' => 'text',
            ));

    /** CTA First Button Link */
    $wp_customize->add_setting(
        'fintech_profiler_archive_cta_button_one_url',
        array(
            'default'=> '#',
            'sanitize_callback'=> 'esc_url_raw'
            )
        );
    
    $wp_customize-> add_control(
        'fintech_profiler_archive_cta_button_one_url',
        array(
              'label' => __('CTA Button Link','fintech-provider'),
              'section' => 'fintech_profiler_archive_cta_section_settings', 
              'type' => 'text',
            ));

    /** Teams Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_archive_teams_section_settings',
        array(
            'title' => __( 'Teams Section', 'fintech-provider' ),
            'priority' => 70,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_archive_settings'
        )
    );

    /** Enable Teams Section */   
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_teams_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_teams_section',
        array(
            'label' => __( 'Enable Teams Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_teams_section_settings',
            'type' => 'checkbox',
        ));
    
    /** Section Title */
    $wp_customize->add_setting(
        'fintech_profiler_archive_teams_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'fintech_profiler_archive_teams_section_title',
        array(
              'label' => __('Select Page','fintech-provider'),
              'type' => 'select',
              'choices' => array(),
              'section' => 'fintech_profiler_archive_teams_section_settings', 
         
        ));

    /** Select Teams Category */
    $wp_customize->add_setting(
        'fintech_profiler_archive_team_category',
        array(
            'default' => '',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
        ));
    
    $wp_customize->add_control(
        'fintech_profiler_archive_team_category',
        array(
            'label' => __( 'Select Teams Category', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_teams_section_settings',
            'type' => 'select',
            'choices' => array()
        ));


    
    /** Testimonials Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_archive_testimonials_section_settings',
        array(
            'title' => __( 'Testimonials Section', 'fintech-provider' ),
            'priority' => 80,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_archive_settings'
        )
    );

    /** Enable Testimonials Section */   
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_testimonials_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_testimonials_section',
        array(
            'label' => __( 'Enable Testimonials Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_testimonials_section_settings',
            'type' => 'checkbox',
        ));
    
    /** Section Title */
    $wp_customize->add_setting(
        'fintech_profiler_archive_testimonials_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
            )
        );
    $wp_customize-> add_control(
        'fintech_profiler_archive_testimonials_section_title',
        array(
              'label' => __('Select Page','fintech-provider'),
              'type' => 'select',
              'choices' => array(),
              'section' => 'fintech_profiler_archive_testimonials_section_settings', 
         
            ));

    /** Select Testimonials Category */
    $wp_customize->add_setting(
        'fintech_profiler_archive_testimonial_category',
        array(
            'default' => '',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
        ));
    
    $wp_customize->add_control(
        'fintech_profiler_archive_testimonial_category',
        array(
            'label' => __( 'Select Testimonial Category', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_testimonials_section_settings',
            'type' => 'select',
            'choices' => array()
        ));


      

    /** Blog Section Settings */
    $wp_customize->add_section(
        'fintech_profiler_archive_blog_section_settings',
        array(
            'title' => __( 'Blog Section', 'fintech-provider' ),
            'priority' => 40,
            'capability' => 'edit_theme_options',
            'panel' => 'fintech_profiler_archive_settings'
        )
    );
    
   /** Enable Blog Section */
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_blog_section',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_blog_section',
        array(
            'label' => __( 'Enable Blog Section', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_blog_section_settings',
            'type' => 'checkbox',
        )
    );
    
    /** Show/Hide Blog Date */
    $wp_customize->add_setting(
        'fintech_profiler_archive_ed_blog_date',
        array(
            'default' => '1',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_ed_blog_date',
        array(
            'label' => __( 'Show Posts Date, Author, Comment, Category', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_blog_section_settings',
            'type' => 'checkbox',
        )
    );
     
    /** Blog Section Title */
    $wp_customize->add_setting(
        'fintech_profiler_archive_blog_section_title',
        array(
            'default'=> '',
            'sanitize_callback'=> 'sanitize_text_field'
        ));
    
    $wp_customize-> add_control(
        'fintech_profiler_archive_blog_section_title',
        array(
              'label' => __('Select Page','fintech-provider'),
              'type' => 'select',
              'choices' => array(),
              'section' => 'fintech_profiler_archive_blog_section_settings', 
          
        ));

    /** Select Blog Category */
    $wp_customize->add_setting(
        'fintech_profiler_archive_blog_section_category',
        array(
            'default' => '',
            'sanitize_callback' => 'fintech_profiler_archive_sanitize_select',
        ));
    
    $wp_customize->add_control(
        'fintech_profiler_archive_blog_section_category',
        array(
            'label' => __( 'Select Blogs Category', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_blog_section_settings',
            'type' => 'select',
            'choices' => array()
        ));

    /** Blog Section Read More Text */
    $wp_customize->add_setting(
        'fintech_profiler_archive_blog_section_readmore',
        array(
            'default' => __( 'Read More', 'fintech-provider' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_blog_section_readmore',
        array(
            'label' => __( 'Blog Section Read More Text', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_blog_section_settings',
            'type' => 'text',
        )
    );

    /** Blog Section Read More Url */
    $wp_customize->add_setting(
        'fintech_profiler_archive_blog_section_url',
        array(
            'default' => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'fintech_profiler_archive_blog_section_url',
        array(
            'label' => __( 'Blog Page url', 'fintech-provider' ),
            'section' => 'fintech_profiler_archive_blog_section_settings',
            'type' => 'text',
        )
    );
    /** Blog Section Ends */
    
}
add_action( 'customize_register', 'fintech_profiler_archive_customize_register' );
