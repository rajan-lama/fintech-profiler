<?php

/**
 * Sanitization Functions
 * 
 * @link https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php 
 */



if( class_exists( 'WP_Customize_Control' ) ):

/* Class for icon selector */

class Fintech_Profiler_Fontawesome_Icon_Chooser extends WP_Customize_Control{
    public $type = 'icon';

    public function render_content(){
        ?>
            <label>
                <span class="customize-control-title">
                <?php echo esc_html( $this->label ); ?>
                </span>

                <?php if($this->description){ ?>
                <span class="description customize-control-description">
                    <?php echo wp_kses_post($this->description); ?>
                </span>
                <?php } ?>

                <div class="fintech-provider-selected-icon">
                    <i class="fa <?php echo esc_attr($this->value()); ?>"></i>
                    <span><i class="fa fa-angle-down"></i></span>
                </div>

                <ul class="fintech-provider-icon-list clearfix">
                    <?php
                    $fintech_profiler_font_awesome_icon_array = fintech_profiler_font_awesome_icon_array();
                    foreach ($fintech_profiler_font_awesome_icon_array as $fintech_profiler_font_awesome_icon) {
                            $icon_class = $this->value() == $fintech_profiler_font_awesome_icon ? 'icon-active' : '';
                            echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $fintech_profiler_font_awesome_icon ).'"></i></li>';
                        }
                    ?>
                </ul>
                <input type="hidden" value="<?php $this->value(); ?>" <?php $this->link(); ?> />
            </label>
        <?php
    }
}
endif;

 function fintech_profiler_sanitize_checkbox( $checked ){
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
 }
  
 function fintech_profiler_sanitize_select( $input, $setting ){
    // Ensure input is a slug.
    $input = sanitize_key( $input );
    
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;
    
    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
 }
 
 function fintech_profiler_sanitize_number_absint( $number, $setting ) {
    // Ensure $number is an absolute integer (whole number, zero or greater).
    $number = absint( $number );
    
    // If the input is an absolute integer, return it; otherwise, return the default
    return ( $number ? $number : $setting->default );
 }
