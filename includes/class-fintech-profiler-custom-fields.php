<?php
/* 
  * @package My_Custom_CPT
  * @version 1.0.0 
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

if ( ! class_exists( 'Easy_Business_Card_Custom_Fields' ) ) {

    class Easy_Business_Card_Custom_Fields {

        public function __construct() {

            // Meta boxes
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'save_post_fintech_profiler', array( $this, 'save_meta_boxes' ) );

            // Admin scripts
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

        }

        public function add_meta_boxes() {
            add_meta_box(
                'fintech_profiler_links',
                __( 'Fintech Profiler Links', 'my-custom-cpt' ),
                array( $this, 'render_repeater_meta_box' ),
                'fintech',
                'normal',
                'high'
            );

            add_meta_box(
                'fintech_profiler_pricing_plan',
                __( 'Pricing Plan', 'my-custom-cpt' ),
                array( $this, 'render_pricing_meta_box' ),
                'fintech',
                'side',
                'default'
            );

            add_meta_box(
                'fintech_profiler_case_study',
                __( 'Case Study', 'my-custom-cpt' ),
                array( $this, 'render_case_study_meta_box' ),
                'fintech',
                'normal',
                'default'
            );
        }

        public function render_repeater_meta_box( $post ) {
            wp_nonce_field( 'save_fintech_profiler_meta', 'fintech_profiler_meta_nonce' );
            $values = get_post_meta( $post->ID, '_fintech_profiler_links', true );
            if ( ! is_array( $values ) ) $values = array();
            ?>
            <div id="fintech-profiler-links-wrapper">
                <?php foreach ( $values as $index => $row ) : ?>
                    <div class="fintech-profiler-link-row">
                        <input type="hidden" name="fintech_profiler_links[<?php echo $index; ?>][image]" class="fintech-profiler-link-image" value="<?php echo esc_attr( $row['image'] ?? '' ); ?>">
                        <img src="<?php echo esc_url( $row['image'] ?? '' ); ?>" class="fintech-profiler-link-preview" style="max-width:80px;display:inline-block;margin-right:10px;<?php echo empty( $row['image'] ) ? 'display:none;' : ''; ?>">
                        <button type="button" class="button upload-fintech-profiler-image"><?php _e( 'Select Image', 'my-custom-cpt' ); ?></button>
                        <input type="url" name="fintech_profiler_links[<?php echo $index; ?>][url]" value="<?php echo esc_attr( $row['url'] ?? '' ); ?>" placeholder="https://example.com" style="width:50%;margin-left:10px;">
                        <button type="button" class="button remove-row"><?php _e( 'Remove', 'my-custom-cpt' ); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
            <p>
                <button type="button" class="button" id="add-fintech-profiler-link"><?php _e( 'Add Link', 'my-custom-cpt' ); ?></button>
            </p>
            <template id="fintech-profiler-link-template">
                <div class="fintech-profiler-link-row">
                    <input type="hidden" name="fintech_profiler_links[INDEX][image]" class="fintech-profiler-link-image" value="">
                    <img src="" class="fintech-profiler-link-preview" style="max-width:80px;display:inline-block;margin-right:10px;display:none;">
                    <button type="button" class="button upload-fintech-profiler-image"><?php _e( 'Select Image', 'my-custom-cpt' ); ?></button>
                    <input type="url" name="fintech_profiler_links[INDEX][url]" value="" placeholder="https://example.com" style="width:50%;margin-left:10px;">
                    <button type="button" class="button remove-row"><?php _e( 'Remove', 'my-custom-cpt' ); ?></button>
                </div>
            </template>
            <?php
        }

        public function render_pricing_meta_box( $post ) {
            $pricing = get_post_meta( $post->ID, '_fintech_profiler_pricing_plan', true );
            ?>
            <input type="text" name="fintech_profiler_pricing_plan" value="<?php echo esc_attr( $pricing ); ?>" placeholder="e.g., $199/year" style="width:100%;">
            <?php
        }

        public function render_case_study_meta_box( $post ) {
          wp_nonce_field( 'save_pricing_case_fields', 'pricing_case_nonce' );
          
          $case_study = get_post_meta( $post->ID, '_fintenh_profiler_case_study', true );
            wp_editor( 
                $case_study, 
                'pricing_plan_editor', 
                array(
                    'textarea_name' => 'case_study',
                    'media_buttons' => true,
                    'textarea_rows' => 8,
                    'teeny'         => false,
                )
            );

        }

        public function save_meta_boxes( $post_id ) {
            if ( ! isset( $_POST['fintech_profiler_meta_nonce'] ) || ! wp_verify_nonce( $_POST['fintech_profiler_meta_nonce'], 'save_fintech_profiler_meta' ) ) return;
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
            if ( ! current_user_can( 'edit_post', $post_id ) ) return;

            // Save repeater
            $links = $_POST['fintech_profiler_links'] ?? array();
            $sanitized_links = array();
            foreach ( $links as $link ) {
                if ( empty( $link['image'] ) && empty( $link['url'] ) ) continue;
                $sanitized_links[] = array(
                    'image' => esc_url_raw( $link['image'] ),
                    'url'   => esc_url_raw( $link['url'] ),
                );
            }
            update_post_meta( $post_id, '_fintech_profiler_links', $sanitized_links );

            // Save pricing
            update_post_meta( $post_id, '_fintech_profiler_pricing_plan', sanitize_text_field( $_POST['fintech_profiler_pricing_plan'] ?? '' ) );

            // Save case study
            update_post_meta( $post_id, '_fintech_profiler_case_study', wp_kses_post( $_POST['fintech_profiler_case_study'] ?? '' ) );
        }

        public function admin_scripts( $hook ) {
            global $post;
            if ( ( $hook === 'post-new.php' || $hook === 'post.php' ) && $post->post_type === 'fintech' ) {
                wp_enqueue_media();
                wp_enqueue_editor();
                wp_enqueue_script( 'fintech-profiler-admin', FINTECH_PROFILER_BASE_URL . 'admin/js/fintech-profiler-admin.js', array( 'jquery' ), '1.0', true );
            }
        }
  }

  new Easy_Business_Card_Custom_Fields();
}