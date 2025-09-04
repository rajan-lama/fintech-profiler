<?php
/* 
  * @package My_Custom_CPT
  * @version 1.0.0 
*/

if (! defined('ABSPATH')) {
    exit; // Prevent direct access
}

if (! class_exists('Easy_Business_Card_CPT')) {

    class Easy_Business_Card_CPT
    {

        public function __construct()
        {

            // Register hooks
            add_action('init', array($this, 'register_cpt'));
            add_action('init', array($this, 'add_custom_role'));
        }

        /**
         * Register Custom Post Type
         */
        public function register_cpt()
        {
            $labels = array(
                'name'               => __('Fintech Profile', 'fintech-profiler'),
                'singular_name'      => __('Fintech Profile', 'fintech-profiler'),
                'menu_name'          => __('Fintech Profiles', 'fintech-profiler'),
                'name_admin_bar'     => __('Fintech Profile', 'fintech-profiler'),
                'add_new'            => __('Add New', 'fintech-profiler'),
                'add_new_item'       => __('Add New Fintech Profile', 'fintech-profiler'),
                'new_item'           => __('New Fintech Profile', 'fintech-profiler'),
                'edit_item'          => __('Edit Fintech Profile', 'fintech-profiler'),
                'view_item'          => __('View Fintech Profile', 'fintech-profiler'),
                'all_items'          => __('All Fintech Profiles', 'fintech-profiler'),
                'search_items'       => __('Search Fintech Profiles', 'fintech-profiler'),
                'not_found'          => __('No Fintech Profiles found.', 'fintech-profiler'),
                'not_found_in_trash' => __('No Fintech Profiles found in Trash.', 'fintech-profiler')
            );

            $fintech_capabilities = array(
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
                'rewrite'            => array('slug' => 'fintech'),
                'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'menu_icon'          => 'dashicons-nametag',
                // 'show_in_rest'       => true,
                // 'capability_type'    => array( 'fintech', 'fintechs' ),
                // 'map_meta_cap'       => true,
                // 'capabilities'       => $fintech_capabilities,
            );

            register_post_type('fintech', $args);

            $labels = array(
                'name'               => __('Financial Profile', 'fintech-profiler'),
                'singular_name'      => __('Financial Profile', 'fintech-profiler'),
                'menu_name'          => __('Financial Profiles', 'fintech-profiler'),
                'name_admin_bar'     => __('Financial Profile', 'fintech-profiler'),
                'add_new'            => __('Add New', 'fintech-profiler'),
                'add_new_item'       => __('Add New Financial Profile', 'fintech-profiler'),
                'new_item'           => __('New Financial Profile', 'fintech-profiler'),
                'edit_item'          => __('Edit Financial Profile', 'fintech-profiler'),
                'view_item'          => __('View Financial Profile', 'fintech-profiler'),
                'all_items'          => __('All Financial Profiles', 'fintech-profiler'),
                'search_items'       => __('Search Financial Profiles', 'fintech-profiler'),
                'not_found'          => __('No Financial Profiles found.', 'fintech-profiler'),
                'not_found_in_trash' => __('No Financial Profiles found in Trash.', 'fintech-profiler')
            );

            $financial_capabilities = array(
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
                'rewrite'            => array('slug' => 'financial'),
                'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
                'menu_icon'          => 'dashicons-buddicons-buddypress-logo',
                // 'show_in_rest'       => true,
                // 'capability_type'    => array( 'fintech', 'fintechs' ),
                // 'map_meta_cap'       => true,
                // 'capabilities'       => $fintech_capabilities,
            );

            register_post_type('financial', $args);
        }

        /**
         * Add custom user role with mapped capabilities
         */
        public function add_custom_role()
        {
            $fintech_caps = array(
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

            add_role('fintech_manager', __('Fintech Manager', 'fintech-profiler'), $fintech_caps);

            $financial_caps = array(
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

            add_role('financial_manager', __('Financial Manager', 'fintech-profiler'), $financial_caps);
        }

        /**
         * Remove custom user role on deactivation
         */
        public function remove_custom_role()
        {
            remove_role('book_manager');
        }
    }

    new Easy_Business_Card_CPT();
}
