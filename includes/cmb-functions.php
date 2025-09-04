<?php

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'fintech_profiler_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category fintech_profiler-toolkit
 * @package  fintech_profiler_Toolkit
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */
if (FINTECH_PROFILER_BASE . '/lib/cmb2/init.php') {
	require_once FINTECH_PROFILER_BASE . '/lib/cmb2/init.php';
}

add_action('cmb2_admin_init', 'fintech_register_pricing_plans_metabox');
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function fintech_register_pricing_plans_metabox()
{

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box(array(
		'id'           => 'fintech_pricing_plans_metabox',
		'title'        => esc_html__('Pricing Plans', 'fintech_profiler-toolkit'),
		'object_types' => array('fintech',),
	));

	$cmb_group->add_field(array(
		'name'          => esc_html__('Description', 'fintech_profiler'),
		'description'   => esc_html__('Select the type of content to display in the slider', 'fintech_profiler'),
		'id'            => 'fintech_pricing_plans_content',
		'type'          => 'wysiwyg',
		'type'    => 'wysiwyg',
		'show_names' => false,
		'options' => array(
			'media_buttons' => true,
			'textarea_rows' => 10,
			'teeny'         => false, // must be false for table
			'quicktags'     => true,
			// 'tinymce'       => array(
			// 		'plugins' => 'table', // ensures table plugin loads
			// ),
		),
	));
}

add_action('cmb2_admin_init', 'fintech_register_case_studies_metabox');
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function fintech_register_case_studies_metabox()
{

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box(array(
		'id'           => 'fintech_case_studies_metabox',
		'title'        => esc_html__('Case Studies', 'fintech_profiler-toolkit'),
		'object_types' => array('fintech'),
	));

	$cmb_group->add_field(array(
		'name'          => esc_html__('Description', 'fintech_profiler'),
		'description'   => esc_html__('Select the type of content to display in the slider', 'fintech_profiler'),
		'id'            => 'fintech_case_studies_content',
		'type'          => 'wysiwyg',
		'show_names' 		=> false,
		'options' 			=> array(
			'media_buttons' => true,
			'textarea_rows' => 10,
			'teeny'         => false, // must be false for table
			'quicktags'     => true,
			// 'tinymce'       => array(
			// 		'plugins' => 'table', // ensures table plugin loads
			// ),
		),
	));
}



add_action('cmb2_admin_init', 'fintech_register_slider_metabox');
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function fintech_register_slider_metabox()
{

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box(array(
		'id'           => 'fintech_featured_slider',
		'title'        => esc_html__('Feature Slider', 'fintech_profiler-toolkit'),
		'object_types' => array('fintech'),
	));


	// $group_field_id is the field id string, so in this case: 'fintech_profiler_group_demo'
	$group_field_id = $cmb_group->add_field(array(
		'id'          => 'fintech_profiler_slides',
		'type'        => 'group',
		'options'     => array(
			'group_title'    => esc_html__('Slide {#}', 'fintech_profiler-toolkit'), // {#} gets replaced by row number
			'add_button'     => esc_html__('Add Another Slide', 'fintech_profiler-toolkit'),
			'remove_button'  => esc_html__('Remove Slide', 'fintech_profiler-toolkit'),
			'sortable'       => true,
			'closed'      => true, // true to have the groups closed by default
			'remove_confirm' => esc_html__('Are you sure you want to remove?', 'fintech_profiler-toolkit'), // Performs confirmation before removing group.
		),
		'attributes' => [
			'data-conditional-id'    => 'slider_content_type',
			'data-conditional-value' => 'custom',
		],
	));

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */

	$cmb_group->add_group_field($group_field_id, array(
		'name' => esc_html__('Image', 'fintech_profiler-toolkit'),
		'id'   => 'image',
		'type' => 'file',
	));

	$cmb_group->add_group_field($group_field_id, array(
		'name'       => esc_html__('URL', 'fintech_profiler-toolkit'),
		'id'         => 'url',
		'description' => esc_html__('Enter the Link', 'fintech_profiler-toolkit'),
		'type'       => 'text_url',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	));
}

add_action('cmb2_admin_init', 'fintech_register_more_info_metabox');
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function fintech_register_more_info_metabox()
{

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box(array(
		'id'           => 'fintech_more_info_metabox',
		'title'        => esc_html__('More Information', 'fintech_profiler-toolkit'),
		'object_types' => array('fintech',),
	));

	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Founded', 'fintech_profiler'),
			// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
			'id'            => 'fintech_founded',
			'type'          => 'text',
		),
	);


	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Company Size', 'fintech_profiler'),
			// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
			'id'            => 'fintech_company_size',
			'type'          => 'text',
		),
	);

	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Pricing Model', 'fintech_profiler'),
			// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
			'id'            => 'fintech_pricing_model',
			'type'          => 'text',
		),
	);

	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Minimum Pricing Range', 'fintech_profiler'),
			'description'   => esc_html__('These currency are in USD.', 'fintech_profiler'),
			'id'            => 'fintech_minimum_pricing',
			'type' 					=> 'text_money',
			// 'before_field' => '£', // Replaces default '$'
		),
	);

	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Maximum Pricing Range', 'fintech_profiler'),
			'description'   => esc_html__('These currency are in USD.', 'fintech_profiler'),
			'id'            => 'fintech_maximum_pricing',
			'type' 					=> 'text_money',

		),
	);

	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Website', 'fintech_profiler'),
			// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
			'id'            => 'fintech_website',
			'type'          => 'text_url',
		),
	);

	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Email', 'fintech_profiler'),
			// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
			'id'            => 'fintech_email',
			'type'          => 'text_email',
		),
	);

	$cmb_group->add_field(
		array(
			'name'          => esc_html__('Phone', 'fintech_profiler'),
			// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
			'id'            => 'fintech_phone',
			'type'          => 'text_medium',
		),
	);

	// Load countries.json
	$countries_file = FINTECH_PROFILER_BASE . '/public/img/countries.json'; // adjust path
	$countries = array();

	if (file_exists($countries_file)) {
		$json_data = file_get_contents($countries_file);
		$countries_array = json_decode($json_data, true);

		if (!empty($countries_array)) {
			foreach ($countries_array as $country) {
				if (isset($country['name'])) {
					$countries[$country['code']] = $country['name'];
				}
			}
		}
	}


	$cmb_group->add_field(array(
		'name'          => esc_html__('Country', 'fintech_profiler'),
		// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
		'id'            => 'fintech_country',
		'type'          => 'select',
		'options_cb' => 'fintech_get_countries_list',
	));

	$cmb_group->add_field(array(
		'name'          => esc_html__('State', 'fintech_profiler'),
		// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
		'id'            => 'fintech_state',
		'type'          => 'select',
		'options' => [],
	));

	$cmb_group->add_field(array(
		'name'          => esc_html__('City', 'fintech_profiler'),
		// 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech_profiler' ),
		'id'            => 'fintech_city',
		'type'          => 'text',
	));
}

// add_action( 'cmb2_admin_init', 'fintech_profiler_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function fintech_profiler_register_demo_metabox()
{
	// Try to get the post ID from $_GET or $_POST
	$post_id = 0;

	if (isset($_GET['post'])) {
		$post_id = absint($_GET['post']);
	} elseif (isset($_POST['post_ID'])) {
		$post_id = absint($_POST['post_ID']);
	}

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box(array(
		'id'            => 'fintech_profiler_demo_metabox',
		'title'         => esc_html__('Slider Shortcode', 'fintech_profiler'),
		'object_types'  => array('wp-slider'), // Post type
		'context'    => 'side', // 'normal', 'advanced', or 'side'
	));

	$cmb_demo->add_field(array(
		'name'       => esc_html__('Generated Shortcode', 'fintech_profiler'),
		'desc'       => esc_html__('Copy the shortcode and paste on content editor', 'fintech_profiler'),
		'id'         => 'fintech_profiler_demo_readonly',
		'type'       => 'text_medium',
		'default' 	 => "[fintech_profiler_slider id='{$post_id}']",
		'save_field' => false, // Disables the saving of this field.
		'attributes' => array(
			'disabled' => 'disabled',
			'readonly' => 'readonly',
		),
	));
}

/**
 * Short Code for List Items 
 */
function webpoint_toolkit_custom_slider_shortcode($atts, $content = null)
{
	extract(shortcode_atts(
		array(),
		$atts,
		'webpoint_slider'
	));

	// Get the metadata for the post with ID $id
	$id = isset($atts['id']) ? $atts['id'] : 0;
	if (! $id) {
		return '';
	}

	$type = get_post_meta($id, 'slider_content_type', true);

	switch ($type) {
		case "team":
			$team = get_post_meta($id, 'team_ids', true);
			$teams = !empty($team) ? explode(',', $team) : array();
			break;

		case "event":
			if (function_exists('webpoint_pci_retrieve_events')) {

				$data = webpoint_pci_retrieve_events();
				$events = $data['calendar_events'];

				$slider = '<section class="webpoint-event-slider">';
				$slider .= '<div class="webpoint-event-slider-header">';
				$slider .= '<h2 class="webpoint-event-slider-title">There’s more coming</h2>';
				$slider .= '<a href="' . get_site_url() . '/events' . '">View All Events</a>';
				$slider .= '</div>';
				$slider .= '<div class="owl-carousel owl-theme owl-carousel-event">';

				foreach ($events as $event) {


					$upcoming_event = [
						'event_id' => !empty($event['event_id']) ? $event['event_id'] : 0,
						'name' => !empty($event['name']) ? $event['name'] : '',
						'description' => !empty($event['description']) ? $event['description'] : '',
						'image' => !empty($event['image_url']) ? $event['image_url'] : WPC_INTEGRATION_URL . 'assets/images/fallback-img.jpg',
						'featured' => $event['featured'] ?? false,
						'instance_id' => !empty($event['instance_id']) ? $event['instance_id'] : 0,
						'starts_at' => !empty($event['starts_at']) ? $event['starts_at'] : '',
						'ends_at' => !empty($event['ends_at']) ? $event['ends_at'] : '',
						'location' => !empty($event['location']) ? $event['location'] : '',
						'recurrence' => !empty($event['recurrence']) ? $event['recurrence'] : 'None',
						'recurrence_description' => !empty($event['recurrence_description']) ? $event['recurrence_description'] : '',
					];

					if (empty($upcoming_event)) {
						return;
					}
					$image = "'" . esc_url($upcoming_event['image']) . "'";

					$slider .= '<div class="item">';
					$slider .= '<div class="event-content">';


					$slider .= '<div class="image-holder">';
					$slider .= '<a href="' . get_site_url() . '/event?event_id=' . $upcoming_event['event_id'] . '">';
					$slider .= '<figure style="background:url(' . $image . '); " >';
					$slider .= '<img src="' . esc_url($upcoming_event["image"]) . '" alt="' . esc_attr($upcoming_event["name"]) . '" /></figure>';

					$slider .= '</a>';
					$slider .= '</div>';

					$slider .= '<div class="event-text">';

					$slider .= '<a href="' . get_site_url() . '/event?event_id=' . $upcoming_event['event_id'] . '">';
					$slider .= '<h3>' . esc_attr($upcoming_event["name"]) . '</h3>';
					$slider .= '</a>';
					$slider .= '<div class="wpc-events__date-time">';
					$slider .= '<p class="wpc-events__info-title">TIME</p>';
					$slider .= '<p class="wpc-events__info-detail">';
					if (isset($upcoming_event['starts_at'], $upcoming_event['ends_at'])) {
						$slider .= esc_html(date('g:i A', strtotime($upcoming_event['starts_at']))) . ' - ' . esc_html(date('g:i A', strtotime($upcoming_event['ends_at'])));
					}
					$slider .= '</p></div>';


					$slider .= '<div class="wpc-events__days-date">';
					$slider .= '<p class="wpc-events__info-title">Days</p>';
					$slider .= '<p class="wpc-events__info-detail">';
					if (isset($upcoming_event['starts_at'], $upcoming_event['ends_at'])) {
						$slider .=  esc_html(date('d/m/Y', strtotime($upcoming_event['starts_at']))) . ' - ' . esc_html(date('d/m/Y', strtotime($upcoming_event['ends_at'])));
					}
					$slider .= '</p></div>';

					$slider .= '<div class="wpc-events__place-holder">';
					$slider .= '<p class="wpc-events__info-title">PLACE</p>';
					$slider .= '<p class="wpc-events__info-detail">';
					if (isset($upcoming_event['location'])) {
						$slider .= esc_html($upcoming_event['location']);
					}
					$slider .= '</p>';
					$slider .= '</div>';

					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '</div>';
				}

				$slider .= '</div>';
				$slider .= '</section>';
			}
			break;

		case "testimonial":
			$testimonial = get_post_meta($id, 'testimonial_ids', true);
			$section_title = get_post_meta($id, 'section_title', true);
			$section_title_align = get_post_meta($id, 'section_title_align', true);
			$en_double_quote = get_post_meta($id, 'en_double_quote', true);
			$testimonials = !empty($testimonial) ? explode(',', $testimonial) : array();
			$qry = new WP_Query(array(
				'post_type'      => 'testimonial',
				'post_status'    => 'publish',
				'post__in'			=> $testimonials,
			));

			$has_icon = ($en_double_quote == 'on') ? 'has-icon' : 'no-icon';

			$slider = '<section class="testimonial-section">';
			$slider .= '<div class="testimonial-header" style="text-align:' . $section_title_align . ';" >';
			$slider .= '<h1 class="testimonial-title ' . esc_attr($has_icon) . '" >' . esc_html($section_title) . '</h1>';
			$slider .= '</div>';

			if ($qry->have_posts()) {
				$slider .= '<div class="owl-carousel owl-theme owl-carousel-' . esc_attr($type) . '">';
				while ($qry->have_posts()) {
					$qry->the_post();
					$slider .= '<div class="item">';
					$slider .= '<div class="testimonial-content">';
					$slider .= '<div class="testimonial-thumbnail">';

					if (has_post_thumbnail()) {
						$slider .= get_the_post_thumbnail();
					} else {
						$slider .=  '<img src="' . get_template_directory_uri() . '/images/testimonial.jpg" alt="' . esc_attr(get_the_title()) . '" />';
					}

					$slider .= '<h5>' . get_the_title() . '</h5>';
					$slider .= '</div>';
					$slider .= '<div class="testimonial-text">';
					$slider .= '<blockquote>';
					$slider .= get_the_content();
					$slider .= '</blockquote>';
					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '</div>';
				}
				wp_reset_postdata();
				$slider .= '</div>';
			}
			break;
		case "custom":
		default:
			$slides = get_post_meta($id, 'webpoint_slides', true);

			$slider = '<div class="owl-carousel-' . esc_attr($type) . '">';

			$counter = 0;
			foreach ($slides as $slide) {
				if (! is_array($slide) || empty($slide['title']) || empty($slide['image'])) {
					continue; // Skip if slide data is not valid
				}

				$title = !empty(esc_html($slide['title'])) ? esc_html($slide['title']) : '';
				$description = !empty(esc_html($slide['description'])) ? esc_html($slide['description']) : '';
				$image = !empty(esc_url($slide['image'])) ? esc_url($slide['image']) : '';
				$section_img = "'" . $image . "'";
				if ($counter % 2 == 0) {
					$slider .= '<div class="item">';
					$slider .= '<div class="slider-content webpoint-row clearfix animated-text even">';
					$slider .= '<div class="webpoint-col-3 webpoint-blank"></div>';
					$slider .= '<div class="webpoint-col-3">';
					$slider .= '<div class="slider-image" style="background-image:url(' . $section_img . ');">';
					// $slider .= '<img src="' . $image . '" alt="' . $title . '" />';
					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '<div class="slider-text webpoint-col-3"  data-animation-in="slideInLeft" data-animation-out="animate-out slideOutLeft" data-wow-duration="3s">';
					$slider .= '<h2 class="animated-text slider-title" >' . $title . '</h2>';
					$slider .= '<p class="animated-text slider-excerpt">' . $description . '</p>';
					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '</div>';
				} else {

					$slider .= '<div class="item">';
					$slider .= '<div class="slider-content webpoint-row clearfix animated-text odd">';
					$slider .= '<div class="webpoint-col-3 webpoint-blank"></div>';
					$slider .= '<div class="webpoint-col-3">';
					$slider .= '<div class="slider-image" style="background-image:url(' . $section_img . ');">';
					// $slider .= '<img src="' . $image . '" alt="' . $title . '" />';
					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '<div class="slider-text webpoint-col-3"  data-animation-in="slideInRight" data-animation-out="animate-out slideOutRight" data-wow-duration="3s">';
					$slider .= '<h2 class="animated-text slider-title" >' . $title . '</h2>';
					$slider .= '<p class="animated-text slider-excerpt">' . $description . '</p>';
					$slider .= '</div>';
					$slider .= '</div>';
					$slider .= '</div>';
				}
				$counter++;
			}
			$slider .= '</div>';
	}

	return $slider;
}
// add_shortcode( 'webpoint_slider', 'webpoint_toolkit_custom_slider_shortcode' );

/**
 * Function to generate the featured slider
 *
 * @param int $id The post ID.
 * @param string $type The type of slider.
 * @return string HTML for the slider.
 */
// function fintech_featured_slider(){	

// 	if ( ! $id ) {
// 		return '';
// 	}
// 		$slides = get_post_meta( $id , 'webpoint_slides', true );

// 		var_dump($slides);

// 			$slider = '<div class="owl-carousel-' . esc_attr( $type ) . '">';

// 			$counter = 0;
// 			foreach ( $slides as $slide ) {
// 				if ( ! is_array( $slide ) || empty( $slide['title'] ) || empty( $slide['image'] ) ) {
// 					continue; // Skip if slide data is not valid
// 				}

// 				$title = !empty(esc_html( $slide['title'] )) ? esc_html( $slide['title'] ) : '';
// 				$description = !empty(esc_html( $slide['description'] )) ? esc_html( $slide['description'] ) : '';	
// 				$image = !empty(esc_url( $slide['image'] )) ? esc_url( $slide['image'] ) : '';
// 				$section_img = "'" . $image . "'";
// 				if ( $counter % 2 == 0 ) {
// 					$slider .= '<div class="item">';
// 					$slider .= '<div class="slider-content webpoint-row clearfix animated-text even">';
// 						$slider .= '<div class="webpoint-col-3 webpoint-blank"></div>';
// 						$slider .= '<div class="webpoint-col-3">' ;
// 						$slider .= '<div class="slider-image" style="background-image:url(' . $section_img . ');">' ;
// 							// $slider .= '<img src="' . $image . '" alt="' . $title . '" />';
// 							$slider .= '</div>';
// 						$slider .= '</div>';
// 						$slider .= '<div class="slider-text webpoint-col-3"  data-animation-in="slideInLeft" data-animation-out="animate-out slideOutLeft" data-wow-duration="3s">';
// 							$slider .= '<h2 class="animated-text slider-title" >' . $title . '</h2>';
// 							$slider .= '<p class="animated-text slider-excerpt">' .$description . '</p>';
// 						$slider .= '</div>';
// 					$slider .= '</div>'; 
// 				$slider .= '</div>';
// 				} else {
				
// 					$slider .= '<div class="item">';
// 					$slider .= '<div class="slider-content webpoint-row clearfix animated-text odd">';
// 						$slider .= '<div class="webpoint-col-3 webpoint-blank"></div>';
// 						$slider .= '<div class="webpoint-col-3">' ;
// 						$slider .= '<div class="slider-image" style="background-image:url(' . $section_img . ');">' ;
// 							// $slider .= '<img src="' . $image . '" alt="' . $title . '" />';
// 							$slider .= '</div>';
// 						$slider .= '</div>';
// 						$slider .= '<div class="slider-text webpoint-col-3"  data-animation-in="slideInRight" data-animation-out="animate-out slideOutRight" data-wow-duration="3s">';
// 							$slider .= '<h2 class="animated-text slider-title" >' . $title . '</h2>';
// 							$slider .= '<p class="animated-text slider-excerpt">' .$description . '</p>';
// 						$slider .= '</div>';
// 					$slider .= '</div>'; 
// 				$slider .= '</div>';
// 				}
// 				$counter++;
// 			}
// 			$slider .= '</div>';

// 			return $slider;
// }
