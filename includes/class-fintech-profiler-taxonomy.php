<?php
if (! class_exists('Fintech_Profiler_Taxonomy')) {

    class Fintech_Profiler_Taxonomy
    {

        public function __construct()
        {
            add_action('init', array($this, 'register_taxonomy'));
        }

        public function register_taxonomy()
        {
            $labels = array(
                'name'              => _x('Categories', 'taxonomy general name', 'fintech-profiler'),
                'singular_name'     => _x('Category', 'taxonomy singular name', 'fintech-profiler'),
                'search_items'      => __('Search Categories', 'fintech-profiler'),
                'all_items'         => __('All Categories', 'fintech-profiler'),
                'parent_item'       => __('Parent Category', 'fintech-profiler'),
                'parent_item_colon' => __('Parent Category:', 'fintech-profiler'),
                'edit_item'         => __('Edit Category', 'fintech-profiler'),
                'update_item'       => __('Update Category', 'fintech-profiler'),
                'add_new_item'      => __('Add New Category', 'fintech-profiler'),
                'new_item_name'     => __('New Category Name', 'fintech-profiler'),
                'menu_name'         => __('Categories', 'fintech-profiler'),
            );

            $args = array(
                'hierarchical'      => true, // true = category-style, false = tag-style
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'fintech-category'),
                'show_in_rest'      => true, // enables Gutenberg support
            );

            // register_taxonomy('fintech-category', array('fintech_profiles'), $args);

            $labels = array(
                'name'              => _x('Size', 'taxonomy general name', 'fintech-profiler'),
                'singular_name'     => _x('Size', 'taxonomy singular name', 'fintech-profiler'),
                'search_items'      => __('Search Sizes', 'fintech-profiler'),
                'all_items'         => __('All Sizes', 'fintech-profiler'),
                'parent_item'       => __('Parent Size', 'fintech-profiler'),
                'parent_item_colon' => __('Parent Size:', 'fintech-profiler'),
                'edit_item'         => __('Edit Size', 'fintech-profiler'),
                'update_item'       => __('Update Size', 'fintech-profiler'),
                'add_new_item'      => __('Add New Size', 'fintech-profiler'),
                'new_item_name'     => __('New Size Name', 'fintech-profiler'),
                'menu_name'         => __('Sizes', 'fintech-profiler'),
            );

            $args = array(
                'hierarchical'      => true, // true = category-style, false = tag-style
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'fintech-size'),
                'show_in_rest'      => true, // enables Gutenberg support
            );

            register_taxonomy('fintech-size', array('fintech_profiles'), $args);

            $labels = array(
                'name'              => _x('Pricing Model', 'taxonomy general name', 'fintech-profiler'),
                'singular_name'     => _x('Pricing Model', 'taxonomy singular name', 'fintech-profiler'),
                'search_items'      => __('Search Pricing Models', 'fintech-profiler'),
                'all_items'         => __('All Pricing Models', 'fintech-profiler'),
                'parent_item'       => __('Parent Pricing Model', 'fintech-profiler'),
                'parent_item_colon' => __('Parent Pricing Model:', 'fintech-profiler'),
                'edit_item'         => __('Edit Pricing Model', 'fintech-profiler'),
                'update_item'       => __('Update Pricing Model', 'fintech-profiler'),
                'add_new_item'      => __('Add New Pricing Model', 'fintech-profiler'),
                'new_item_name'     => __('New Pricing Model Name', 'fintech-profiler'),
                'menu_name'         => __('Pricing Models', 'fintech-profiler'),
            );

            $args = array(
                'hierarchical'      => true, // true = category-style, false = tag-style
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'fintech-pricing'),
                'show_in_rest'      => true, // enables Gutenberg support
            );

            register_taxonomy('fintech-pricing', array('fintech_profiles'), $args);
        }
    }

    new Fintech_Profiler_Taxonomy();
}
