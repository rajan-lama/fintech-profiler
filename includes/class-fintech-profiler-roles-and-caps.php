<?php
/**
 * Plugin Name: My Custom CPT with Mapped Role
 * Description: Registers a custom post type "Book" and a user role "Book Manager" with mapped capabilities.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: my-custom-cpt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

if ( ! class_exists( 'Fintech_Profiler_Roles_And_Caps' ) ) {

    class My_Custom_CPT {

        public function __construct() {
            add_action( 'init', array( $this, 'register_cpt' ) );
            add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

            register_activation_hook( __FILE__, array( $this, 'add_custom_role' ) );
            register_deactivation_hook( __FILE__, array( $this, 'remove_custom_role' ) );
        }

        /**
         * Register Custom Post Type: Book with custom capabilities
         */
        public function register_cpt() {
            $labels = array(
                'name'          => __( 'Books', 'my-custom-cpt' ),
                'singular_name' => __( 'Book', 'my-custom-cpt' ),
            );

            $capabilities = array(
                'edit_post'          => 'edit_book',
                'read_post'          => 'read_book',
                'delete_post'        => 'delete_book',
                'edit_posts'         => 'edit_books',
                'edit_others_posts'  => 'edit_others_books',
                'publish_posts'      => 'publish_books',
                'read_private_posts' => 'read_private_books',
                'delete_posts'       => 'delete_books',
                'delete_private_posts' => 'delete_private_books',
                'delete_published_posts' => 'delete_published_books',
                'delete_others_posts' => 'delete_others_books',
                'edit_private_posts' => 'edit_private_books',
                'edit_published_posts' => 'edit_published_books',
                'create_posts'       => 'edit_books',
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'has_archive'        => true,
                'rewrite'            => array( 'slug' => 'books' ),
                'supports'           => array( 'title', 'editor', 'thumbnail' ),
                'menu_icon'          => 'dashicons-book',
                'show_in_rest'       => true,
                'capability_type'    => array( 'book', 'books' ),
                'map_meta_cap'       => true,
                'capabilities'       => $capabilities,
            );

            register_post_type( 'book', $args );
        }

        /**
         * Add custom user role with mapped capabilities
         */
        public function add_custom_role() {
            $caps = array(
                'read'                   => true,
                'upload_files'           => true,
                'read_book'              => true,
                'read_private_books'     => true,
                'edit_book'              => true,
                'edit_books'             => true,
                'edit_others_books'      => true,
                'edit_published_books'   => true,
                'publish_books'          => true,
                'delete_book'            => true,
                'delete_books'           => true,
                'delete_others_books'    => true,
                'delete_published_books' => true,
                'delete_private_books'   => true,
                'edit_private_books'     => true,
            );

            add_role( 'book_manager', __( 'Book Manager', 'my-custom-cpt' ), $caps );
        }

        /**
         * Remove custom user role on deactivation
         */
        public function remove_custom_role() {
            remove_role( 'book_manager' );
        }
    }

    new My_Custom_CPT();
}
