<?php

add_action('pre_get_posts', 'filter_fintech_by_price');
function filter_fintech_by_price($query)
{
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    if (is_post_type_archive('fintech') || is_tax('fintech-category')) {
        $meta_query = [];

        if (! empty($_GET['min_price'])) {
            $meta_query[] = array(
                'key'     => '_pricing_min',
                'value'   => (int) $_GET['min_price'],
                'type'    => 'NUMERIC',
                'compare' => '>='
            );
        }

        if (! empty($_GET['max_price'])) {
            $meta_query[] = array(
                'key'     => '_pricing_max',
                'value'   => (int) $_GET['max_price'],
                'type'    => 'NUMERIC',
                'compare' => '<='
            );
        }

        if (! empty($meta_query)) {
            $query->set('meta_query', $meta_query);
        }
    }
}

function fintech_filter_callback()
{
    check_ajax_referer('fintech_filter_nonce', 'security');

    parse_str($_POST['form'], $form_data);

    $search = isset($form_data['search']) ? sanitize_text_field($form_data['search']) : '';

    $args = array(
        'post_type' => 'fintech',
        'posts_per_page' => -1,
        's' => $search,
    );

    // Filter by category
    if (!empty($form_data['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'fintech-category',
            'field'    => 'slug',
            'terms'    => $form_data['category'],
        );
    }

    // Filter by pricing
    if (!empty($form_data['pricing'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'fintech-pricing',
            'field'    => 'slug',
            'terms'    => $form_data['pricing'],
        );
    }

    // Filter by size
    if (!empty($form_data['size'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'fintech-size',
            'field'    => 'slug',
            'terms'    => $form_data['size'],
        );
    }

    if (! empty($form_data['min_price'])) {
        $meta_query[] = array(
            'key'     => 'fintech_minimum_pricing',
            'value'   => (int) $form_data['min_price'],
            'type'    => 'NUMERIC',
            'compare' => '>='
        );
    }

    if (! empty($form_data['max_price'])) {
        $meta_query[] = array(
            'key'     => 'fintech_maximum_pricing',
            'value'   => (int) $form_data['max_price'],
            'type'    => 'NUMERIC',
            'compare' => '<='
        );
    }

    if (! empty($form_data['country'])) {
        $meta_query[] = array(
            'key'     => 'fintech_maximum_pricing',
            'value'   => $form_data['country'],
            'type'    => 'NUMERIC',
            'compare' => '<='
        );
    }

    if (! empty($form_data['state'])) {
        $meta_query[] = array(
            'key'     => 'fintech_maximum_pricing',
            'value'   => (int) $form_data['max_price'],
            'type'    => 'NUMERIC',
            'compare' => '<='
        );
    }

    if (! empty($meta_query)) {
        $args['meta_query'] =  $meta_query;
    }


    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-4">
                <article class="post">
                    <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('fintech-profiler-three-col');
                        } else {
                            echo '<img src="' . esc_url(get_template_directory_uri() . '/images/fallback/default-thumb-3col.jpg') . '"  alt="' . esc_attr(get_the_title()) . '" />';
                        }
                        ?>
                    </a>
                    <header class="entry-header">
                        <div class="icon-holder">
                            <div class="cat-icon">
                                <img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/img8.png">
                            </div>
                            <div>
                                <a href="<?php the_permalink(); ?>"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/arrow-right.png"></a>
                            </div>
                        </div>
                        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </header>
                    <div class="similar-content">
                        <?php echo get_excerpt_or_trimmed_content($query->ID, 80); ?>
                    </div>
                    <div class="similar-tags">
                        <?php
                        $terms = get_the_terms($query->ID, 'fintech-category');

                        if (! empty($terms) && ! is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                echo '<a href="' . get_term_link((int) $term->term_id,  'fintech-category') . '" class="list-category">' . esc_html($term->name) . '</a>';
                            }
                        }
                        ?>
                    </div>
                </article>
            </div>
        <?php endwhile;
    } else {
        echo '<p>No fintechs found.</p>';
    }
    wp_reset_postdata();

    $html = ob_get_clean();

    wp_send_json_success(['html' => $html]);
}
add_action('wp_ajax_fintech_filter', 'fintech_filter_callback');
add_action('wp_ajax_nopriv_fintech_filter', 'fintech_filter_callback');


add_action('fintech_profiler_breadcrumbs', 'fintech_profiler_breadcrumbs_cb');
if (! function_exists('fintech_profiler_breadcrumbs_cb')) :
    /**
     * Breadcrumb 
     */
    function fintech_profiler_breadcrumbs_cb()
    {

        global $post;
        $post_page  = get_option('page_for_posts'); //The ID of the page that displays posts.
        $show_front = get_option('show_on_front'); //What to show on the front page    
        $home       = get_theme_mod('fintech_profiler_breadcrumb_home_text', __('Home', 'fintech-profiler')); // text for the 'Home' link
        $delimiter  = get_theme_mod('fintech_profiler_breadcrumb_separator', __('/', 'fintech-profiler')); // delimiter between crumbs
        $before     = '<span class="current">'; // tag before the current crumb
        $after      = '</span>'; // tag after the current crumb

        if (! is_front_page()) {

            echo '<div id="crumbs"><a href="' . esc_url(home_url()) . '">' . esc_html($home) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';

            if (is_home()) {

                echo $before . esc_html(single_post_title('', false)) . $after;
            } elseif (is_category()) {

                $thisCat = get_category(get_query_var('cat'), false);

                if ($show_front === 'page' && $post_page) { //If static blog post page is set
                    $p = get_post($post_page);
                    echo ' <a href="' . esc_url(get_permalink($post_page)) . '">' . esc_html($p->post_title) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                }

                if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' <span class="separator">' . $delimiter . '</span> ');
                echo $before .  esc_html(single_cat_title('', false)) . $after;
            } elseif (fintech_profiler_is_woocommerce_activated() && (is_product_category() || is_product_tag())) { //For Woocommerce archive page

                $current_term = $GLOBALS['wp_query']->get_queried_object();

                if (wc_get_page_id('shop')) { //Displaying Shop link in woocommerce archive page
                    $_name = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';
                    if (! $_name) {
                        $product_post_type = get_post_type_object('product');
                        $_name = $product_post_type->labels->singular_name;
                    }
                    echo ' <a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' . esc_html($_name) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                }

                if (is_product_category()) {
                    $ancestors = get_ancestors($current_term, 'product_cat');
                    $ancestors = array_reverse($ancestors);
                    foreach ($ancestors as $ancestor) {
                        $ancestor = get_term($ancestor, 'product_cat');
                        if (! is_wp_error($ancestor) && $ancestor) {
                            echo ' <a href="' . esc_url(get_term_link($ancestor)) . '">' . esc_html($ancestor->name) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                        }
                    }
                }
                echo $before . esc_html($current_term->name) . $after;
            } elseif (fintech_profiler_is_woocommerce_activated() && is_shop()) { //Shop Archive page
                if (get_option('page_on_front') == wc_get_page_id('shop')) {
                    return;
                }
                $_name = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';

                if (! $_name) {
                    $product_post_type = get_post_type_object('product');
                    $_name = $product_post_type->labels->singular_name;
                }
                echo $before . esc_html($_name) . $after;
            } elseif (is_tag()) {

                echo $before . esc_html(single_tag_title('', false)) . $after;
            } elseif (is_author()) {

                global $author;
                $userdata = get_userdata($author);
                echo $before . esc_html($userdata->display_name) . $after;
            } elseif (is_search()) {

                echo $before . esc_html__('Search Results for "', 'fintech-profiler') . esc_html(get_search_query()) . esc_html__('"', 'fintech-profiler') . $after;
            } elseif (is_day()) {

                echo '<a href="' . esc_url(get_year_link(get_the_time(__('Y', 'fintech-profiler')))) . '">' . esc_html(get_the_time(__('Y', 'fintech-profiler'))) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                echo '<a href="' . esc_url(get_month_link(get_the_time(__('Y', 'fintech-profiler')), get_the_time(__('m', 'fintech-profiler')))) . '">' . esc_html(get_the_time(__('F', 'fintech-profiler'))) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                echo $before . esc_html(get_the_time(__('d', 'fintech-profiler'))) . $after;
            } elseif (is_month()) {

                echo '<a href="' . esc_url(get_year_link(get_the_time(__('Y', 'fintech-profiler')))) . '">' . esc_html(get_the_time(__('Y', 'fintech-profiler'))) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                echo $before . esc_html(get_the_time(__('F', 'fintech-profiler'))) . $after;
            } elseif (is_year()) {

                echo $before . esc_html(get_the_time(__('Y', 'fintech-profiler'))) . $after;
            } elseif (is_single() && !is_attachment()) {

                if (fintech_profiler_is_woocommerce_activated() && 'product' === get_post_type()) { //For Woocommerce single product

                    if (wc_get_page_id('shop')) { //Displaying Shop link in woocommerce archive page
                        $_name = wc_get_page_id('shop') ? get_the_title(wc_get_page_id('shop')) : '';
                        if (! $_name) {
                            $product_post_type = get_post_type_object('product');
                            $_name = $product_post_type->labels->singular_name;
                        }
                        echo ' <a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '">' . esc_html($_name) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                    }

                    if ($terms = wc_get_product_terms($post->ID, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'))) {
                        $main_term = apply_filters('woocommerce_breadcrumb_main_term', $terms[0], $terms);
                        $ancestors = get_ancestors($main_term->term_id, 'product_cat');
                        $ancestors = array_reverse($ancestors);
                        foreach ($ancestors as $ancestor) {
                            $ancestor = get_term($ancestor, 'product_cat');
                            if (! is_wp_error($ancestor) && $ancestor) {
                                echo ' <a href="' . esc_url(get_term_link($ancestor)) . '">' . esc_html($ancestor->name) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                            }
                        }
                        echo ' <a href="' . esc_url(get_term_link($main_term)) . '">' . esc_html($main_term->name) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                    }

                    echo $before . esc_html(get_the_title()) . $after;
                } elseif (get_post_type() != 'post') {

                    $post_type = get_post_type_object(get_post_type());

                    if ($post_type->has_archive == true) { // For CPT Archive Link

                        // Add support for a non-standard label of 'archive_title' (special use case).
                        $label = !empty($post_type->labels->archive_title) ? $post_type->labels->archive_title : $post_type->labels->name;
                        printf('<a href="%1$s">%2$s</a>', esc_url(get_post_type_archive_link(get_post_type())), $label);
                        echo '<span class="separator">' . esc_html($delimiter) . '</span> ';
                    }
                    echo $before . esc_html(get_the_title()) . $after;
                } else { //For Post

                    $cat_object       = get_the_category();
                    $potential_parent = 0;

                    if ($show_front === 'page' && $post_page) { //If static blog post page is set
                        $p = get_post($post_page);
                        echo ' <a href="' . esc_url(get_permalink($post_page)) . '">' . esc_html($p->post_title) . '</a> <span class="separator">' . esc_html($delimiter) . '</span> ';
                    }

                    if (is_array($cat_object)) { //Getting category hierarchy if any

                        //Now try to find the deepest term of those that we know of
                        $use_term = key($cat_object);
                        foreach ($cat_object as $key => $object) {
                            //Can't use the next($cat_object) trick since order is unknown
                            if ($object->parent > 0  && ($potential_parent === 0 || $object->parent === $potential_parent)) {
                                $use_term = $key;
                                $potential_parent = $object->term_id;
                            }
                        }

                        $cat = $cat_object[$use_term];

                        $cats = get_category_parents($cat, TRUE, ' <span class="separator">' . esc_html($delimiter) . '</span> ');
                        $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats); //NEED TO CHECK THIS
                        echo $cats;
                    }

                    echo $before . esc_html(get_the_title()) . $after;
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {

                $post_type = get_post_type_object(get_post_type());
                if (get_query_var('paged')) {
                    echo '<a href="' . esc_url(get_post_type_archive_link($post_type->name)) . '">' . esc_html($post_type->label) . '</a>';
                    echo ' <span class="separator">' . esc_html($delimiter) . '</span> ' . $before . sprintf(__('Page %s', 'fintech-profiler'), get_query_var('paged')) . $after;
                } else {
                    echo $before . esc_html($post_type->label) . $after;
                }
            } elseif (is_attachment()) {

                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                if ($cat) {
                    $cat = $cat[0];
                    echo get_category_parents($cat, TRUE, ' <span class="separator">' . esc_html($delimiter) . '</span> ');
                    echo '<a href="' . esc_url(get_permalink($parent)) . '">' . esc_html($parent->post_title) . '</a>' . ' <span class="separator">' . esc_html($delimiter) . '</span> ';
                }
                echo  $before . esc_html(get_the_title()) . $after;
            } elseif (is_page() && !$post->post_parent) {

                echo $before . esc_html(get_the_title()) . $after;
            } elseif (is_page() && $post->post_parent) {

                $parent_id  = $post->post_parent;
                $breadcrumbs = array();

                while ($parent_id) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a>';
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs) - 1) echo ' <span class="separator">' . esc_html($delimiter) . '</span> ';
                }
                echo ' <span class="separator">' . esc_html($delimiter) . '</span> ' . $before . esc_html(get_the_title()) . $after;
            } elseif (is_404()) {
                echo $before . esc_html__('404 Error - Page Not Found', 'fintech-profiler') . $after;
            }

            if (get_query_var('paged')) echo __(' (Page', 'fintech-profiler') . ' ' . get_query_var('paged') . __(')', 'fintech-profiler');

            echo '</div>';
        }
    }
endif;

if (! function_exists('fintech_profiler_post_author')) :
    /**
     * Author Bio
     */
    function fintech_profiler_post_author()
    {
        if (get_theme_mod('fintech_profiler_ed_bio', '1') && get_the_author_meta('description') && ('post' === get_post_type())) {
        ?>
            <section class="author-section">
                <h2 class="title"><?php esc_html_e('About Author', 'bakery-shop-pro'); ?></h2>
                <div class="holder">
                    <div class="img-holder"><?php echo get_avatar(get_the_author_meta('ID'), 126); ?></div>
                    <div class="text-holder">
                        <h3 class="name"><?php echo esc_html(get_the_author_meta('display_name')); ?></h3>
                        <?php echo wpautop(esc_html(get_the_author_meta('description'))); ?>
                    </div>
                </div>
            </section>
        <?php
        }
    }
endif;


if (! function_exists('fintech_profiler_claim_business')) :
    /**
     * Author Bio
     */
    function fintech_profiler_claim_business()
    {
        // if( get_theme_mod( 'fintech_profiler_ed_claim_business', '1' ) && get_the_author_meta( 'description' ) && ( 'post' === get_post_type() ) ){
        // 
        ?>
        <section class="claim-business-section">
            <div class="holder">
                <h4 class="title"><?php esc_html_e('Is This Your Company?', 'bakery-shop-pro'); ?></h4>
                <div class="text-holder">
                    Take control of your company’s listing on FinExplore 360. Sign up to update your details and enhance your visibility to financial institutions.
                </div>
            </div>
            <div class="button-holder"><a href="<?php echo get_site_url(); ?>/claim-fintech-profile">Claim Business</a></div>
        </section>
        <?php
        // }  
    }
    add_action('fintech_profiler_after_post_content', 'fintech_profiler_claim_business', 50);
endif;


add_action('fintech_profiler_before_footer', 'fintech_profiler_related_post', 60);

if (! function_exists('fintech_profiler_related_post')) :
    /**
     * Similar/related post
     */
    function fintech_profiler_related_post()
    {
        global $post;
        $ed_related_post    = get_theme_mod('fintech_profiler_ed_related_post', '1');
        $related_post_tax   = get_theme_mod('fintech_profiler_related_taxonomy', 'tag'); // from customizer
        $related_post_label = get_theme_mod('fintech_profiler_related_post_label', __('Similar Fintechs', 'fintech-profiler'));

        if ($ed_related_post) {

            $args = array(
                'post_type'             => 'fintech',
                'post_status'           => 'publish',
                'posts_per_page'        => 3,
                'ignore_sticky_posts'   => true,
                'post__not_in'          => array($post->ID),
                'orderby'               => 'rand'
            );

            if ($related_post_tax == 'cat') {
                $cats = get_the_category($post->ID);
                if ($cats) {
                    $c = array();
                    foreach ($cats as $cat) {
                        $c[] = $cat->term_id;
                    }
                    $args['category__in'] = $c;

                    $qry = new WP_Query($args);

                    if ($qry->have_posts()) {
        ?>
                        <section class="similar-posts">
                            <h3><?php echo esc_html($related_post_label); ?></h3>
                            <div class="row">
                                <?php
                                while ($qry->have_posts()) {
                                    $qry->the_post();
                                ?>
                                    <div class="col-4">
                                        <article class="post">
                                            <a href="<?php the_permalink(); ?>" class="related-post-thumbnail">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('fintech-profiler-three-col');
                                                } else {
                                                    echo '<img src="' . esc_url(get_template_directory_uri() . '/images/fallback/default-thumb-3col.jpg') . '"  alt="' . esc_attr(get_the_title()) . '" />';
                                                }
                                                ?>
                                            </a>
                                            <header class="entry-header">
                                                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            </header>
                                        </article>
                                    </div>
                                <?php
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </section>
                    <?php
                    }
                }
            } elseif ($related_post_tax == 'tag') {
                $tags = get_the_terms(get_the_ID(), 'fintech-category');
                if (! is_wp_error($tags) && ! empty($tags) && ! is_null($tags)) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'fintech-category',
                            'field'    => 'term_id',
                            'terms'    => wp_list_pluck($tags, 'term_id'),
                            'operator' => 'IN',
                        ),
                    );
                }
                if ($tags) {
                    // $t = array();
                    // foreach( $tags as $tag ){
                    //     $t[] = $tag->term_id;
                    // }

                    $qry = new WP_Query($args);

                    if ($qry->have_posts()) {
                    ?>
                        <section class="similar-posts">
                            <h3 class="section-title"><?php echo esc_html($related_post_label); ?></h3>

                            <div class="row">
                                <?php
                                while ($qry->have_posts()) {
                                    $qry->the_post();
                                ?>
                                    <div class="col-4">
                                        <article class="post">
                                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    the_post_thumbnail('fintech-profiler-three-col');
                                                } else {
                                                    echo '<img src="' . esc_url(get_template_directory_uri() . '/images/fallback/default-thumb-3col.jpg') . '"  alt="' . esc_attr(get_the_title()) . '" />';
                                                }
                                                ?>
                                            </a>
                                            <header class="entry-header">
                                                <div class="icon-holder">
                                                    <div class="cat-icon"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/img8.png"></div>
                                                    <div><a href="<?php the_permalink(); ?>"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/arrow-right.png"></a></div>
                                                </div>
                                                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            </header>
                                            <div class="similar-content">
                                                <?php echo get_excerpt_or_trimmed_content($qry->ID, 80); ?>
                                            </div>
                                            <div class="similar-tags">
                                                <?php
                                                $terms = get_the_terms($qry->ID, 'fintech-category');

                                                if (! empty($terms) && ! is_wp_error($terms)) {
                                                    $count =  (int)count($terms) - 2;
                                                    $terms = array_slice($terms, 0, 2);
                                                    foreach ($terms as $term) {
                                                        echo '<a href="' . get_term_link((int) $term->term_id, 'fintech-category') . '" class="list-category">' . esc_html($term->name) . '</a>';
                                                    }
                                                    if ($count > 0) {
                                                        echo '<a href="' . site_url('/fintech') . '" class="list-category"> +' . $count . '</a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </article>
                                    </div>
                                <?php
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </section>
            <?php
                    }
                }
            }
        }
    }
endif;



if (! function_exists('fintech_profiler_footer_widgets')) :
    /**
     * Footer Widgets
     * 
     * @since 1.0.1 
     */
    function fintech_profiler_footer_widgets()
    {
        if (is_active_sidebar('footer-one') || is_active_sidebar('footer-two') || is_active_sidebar('footer-three')) { ?>
            <div class="widget-area">
                <div class="container">
                    <div class="row">

                        <?php if (is_active_sidebar('footer-one')) { ?>
                            <div class="col-4">
                                <?php dynamic_sidebar('footer-one'); ?>
                            </div>
                        <?php } ?>

                        <?php if (is_active_sidebar('footer-two')) { ?>
                            <div class="col-4">
                                <?php dynamic_sidebar('footer-two'); ?>
                            </div>
                        <?php } ?>

                        <?php if (is_active_sidebar('footer-three')) { ?>
                            <div class="col-4">
                                <?php dynamic_sidebar('footer-three'); ?>
                            </div>
                        <?php } ?>

                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .widget-area -->
    <?php }
    }
endif;

if (! function_exists('get_excerpt_or_trimmed_content')) :
    /** 
     * Dynamic Excerpt
     */
    function get_excerpt_or_trimmed_content($post_id, $length = 100)
    {
        $post = get_post($post_id);

        if (! $post) {
            return '';
        }

        // If manual excerpt exists, use it
        if (! empty($post->post_excerpt)) {
            return wp_trim_words($post->post_excerpt, $length / 5, '...');
        }

        // Otherwise, trim the content to X characters
        $content = wp_strip_all_tags($post->post_content);
        if (strlen($content) > $length) {
            $content = substr($content, 0, $length) . '...';
        }

        return $content;
    }

endif;

// Add this to your theme's functions.php or a custom plugin
add_filter('get_the_archive_title', function ($title) {
    // Remove the "Archives:" prefix
    if (is_post_type_archive('fintech_profile')) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});


/**
 * Get taxonomies terms links.
 *
 * @see get_object_taxonomies()
 */
function fintech_custom_taxonomies_terms_links()
{
    // Get post by post ID.
    if (! $post = get_post()) {
        return '';
    }

    // Get post type by post.
    $post_type = $post->post_type;

    // Get post type taxonomies.
    $taxonomies = get_object_taxonomies($post_type, 'objects');

    $out = array();

    foreach ($taxonomies as $taxonomy_slug => $taxonomy) {

        // Get the terms related to post.
        $terms = get_the_terms($post->ID, $taxonomy_slug);

        if (! empty($terms)) {
            $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
            foreach ($terms as $term) {
                $out[] = sprintf(
                    '<li><a href="%1$s">%2$s</a></li>',
                    esc_url(get_term_link($term->slug, $taxonomy_slug)),
                    esc_html($term->name)
                );
            }
            $out[] = "\n</ul>\n";
        }
    }
    return implode('', $out);
}


function render_taxonomy_tree($taxonomy, $parent_id = 0, $selected = [])
{
    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'parent'     => $parent_id
    ]);

    if (!empty($terms) && !is_wp_error($terms)) {
        // echo '<ul>';
        foreach ($terms as $term) {
            $children = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
                'parent'     => $term->term_id
            ]);

            $checked = in_array($term->slug, $selected) ? 'checked' : '';

            // Add class if has children
            $li_class = !empty($children) ? 'has-children' : '';

            echo '<li class="' . esc_attr($li_class) . '">';

            echo '<div>';
            // Checkbox
            echo '<label><input type="checkbox" name="category[]" value="' . esc_attr($term->slug) . '" ' . $checked . '> ' . esc_html($term->name) . '</label>';
            if (!empty($children)) {
                // Toggle icon
                // echo '<span class="toggle-icon">▶</span> ';
                echo '<span class="toggle-icon"></span> ';
            }
            echo '</div>';

            // Recursively render children
            if (!empty($children)) {
                echo '<ul class="children">';
                render_taxonomy_tree($taxonomy, $term->term_id, $selected);
                echo '</ul>';
            }

            echo '</li>';
        }
        // echo '</ul>';
    }
}

function fintech_get_countries_list()
{
    $countries_file =  FINTECH_PROFILER_BASE . '/public/img/countries.json';
    $countries      = json_decode(file_get_contents($countries_file), true);

    $options = array();
    if (! empty($countries)) {
        foreach ($countries as $country) {
            $options[$country['code']] = $country['name'];
        }
    }

    return $options;
}

function fintech_get_states_list($field)
{
    $countries_file = FINTECH_PROFILER_BASE . '/public/img/countries.json';
    $countries      = json_decode(file_get_contents($countries_file), true);

    // Default empty
    $options = array();

    // Get current selected country from submitted data (or saved value)
    $selected_country = isset($_POST['fintech_country'])
        ? sanitize_text_field($_POST['fintech_country'])
        : get_post_meta(get_the_ID(), 'fintech_country', true);

    if (! empty($selected_country)) {
        foreach ($countries as $country) {
            if ($country['code'] === $selected_country && ! empty($country['states'])) {
                foreach ($country['states'] as $state) {
                    $options[$state['name']] = $state['name'];
                }
                break;
            }
        }
    }

    return $options;
}

add_action('cmb2_after_form', function () {
    ?>
    <script>
        jQuery(document).ready(function($) {
            const countriesData = <?php $json = FINTECH_PROFILER_BASE . '/public/img/countries.json';
                                    echo $json ? $json : '[]'; ?>;

            // On country change → update states
            $('#fintech_country').on('change', function() {
                let countryCode = $(this).val();
                let states = [];

                let country = countriesData.find(c => c.code === countryCode);
                if (country) states = country.states;

                let $state = $('#fintech_state');
                $state.empty().append('<option value="">Select State</option>');

                states.forEach(st => {
                    $state.append(`<option value="${st.name}">${st.name}</option>`);
                });

                $state.trigger('change');
            });

            // On state change → update cities
            $('#fintech_state').on('change', function() {
                let countryCode = $('#fintech_country').val();
                let stateName = $(this).val();
                let cities = [];

                let country = countriesData.find(c => c.code === countryCode);
                if (country) {
                    let state = country.states.find(s => s.name === stateName);
                    if (state) cities = state.cities;
                }

                let $city = $('#fintech_city');
                $city.empty().append('<option value="">Select City</option>');

                cities.forEach(city => {
                    $city.append(`<option value="${city}">${city}</option>`);
                });
            });
        });
    </script>
<?php
});


function fintech_profiler_get_users()
{
    $args = array(
        'role__in' => array('fintech_manager', 'financial_manager'),
        'orderby' => 'display_name',
        'order'   => 'ASC',
    );

    $users   = get_users($args);
    $options = array();

    if (! empty($users)) {
        foreach ($users as $user) {
            $options[$user->ID] = $user->display_name . ' (' . $user->user_email . ')';
        }
    }

    return $options;
}

add_action('wp_ajax_upload_company_logo', 'handle_company_logo_upload');
add_action('wp_ajax_nopriv_upload_company_logo', 'handle_company_logo_upload');

function handle_company_logo_upload()
{
    check_ajax_referer('fp_media_uploader_nonce');

    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $uploadedfile = $_FILES['company_logo'];
    $upload_overrides = ['test_form' => false];
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        // Insert into media library
        $attachment_id = wp_insert_attachment([
            'post_mime_type' => $movefile['type'],
            'post_title'     => sanitize_file_name($uploadedfile['name']),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ], $movefile['file']);

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attachment_id, $movefile['file']);
        wp_update_attachment_metadata($attachment_id, $attach_data);

        // Get thumbnail size URL
        $image_src = wp_get_attachment_image_src($attachment_id, 'thumbnail');

        wp_send_json_success([
            'id'  => $attachment_id,
            'url' => $image_src[0], // <-- thumbnail URL
        ]);
    } else {
        wp_send_json_error($movefile['error']);
    }
}


add_action('wp_ajax_upload_documents', 'fp_upload_documents');
add_action('wp_ajax_nopriv_upload_documents', 'fp_upload_documents');

function fp_upload_documents()
{
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $uploaded_files = $_FILES['attach_media'];
    $uploaded_urls = [];
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

    foreach ($uploaded_files['name'] as $key => $value) {
        if ($uploaded_files['name'][$key]) {
            $file = [
                'name' => $uploaded_files['name'][$key],
                'type' => $uploaded_files['type'][$key],
                'tmp_name' => $uploaded_files['tmp_name'][$key],
                'error' => $uploaded_files['error'][$key],
                'size' => $uploaded_files['size'][$key],
            ];

            $upload_overrides = ['test_form' => false];
            $movefile = wp_handle_upload($file, $upload_overrides);

            if ($movefile && !isset($movefile['error'])) {
                $uploaded_urls[] = $movefile['url'];
            }
        }
    }

    if ($post_id && !empty($uploaded_urls)) {
        $existing = get_post_meta($post_id, '_company_logo_gallery', true);
        if (!is_array($existing)) $existing = [];
        $merged = array_merge($existing, $uploaded_urls);
        update_post_meta($post_id, '_company_logo_gallery', $merged);
    }

    wp_send_json_success(['files' => $uploaded_urls]);
}

add_action('wp_ajax_remove_uploaded_image', 'fp_remove_uploaded_image');
add_action('wp_ajax_nopriv_remove_uploaded_image', 'fp_remove_uploaded_image');

function fp_remove_uploaded_image()
{
    $post_id = intval($_POST['post_id']);
    $image_url = esc_url_raw($_POST['image_url']);
    if (!$post_id || !$image_url) wp_send_json_error();

    $existing = get_post_meta($post_id, '_company_logo_gallery', true);
    if (!is_array($existing)) $existing = [];

    $updated = array_filter($existing, fn($url) => $url !== $image_url);
    update_post_meta($post_id, '_company_logo_gallery', array_values($updated));

    // Optional: Delete file
    $upload_dir = wp_upload_dir();
    $file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_url);
    if (file_exists($file_path)) unlink($file_path);

    wp_send_json_success(['removed' => $image_url]);
}

add_action('wp_ajax_update_image_order', 'fp_update_image_order');
add_action('wp_ajax_nopriv_update_image_order', 'fp_update_image_order');

function fp_update_image_order()
{
    $post_id = intval($_POST['post_id']);
    $order = isset($_POST['order']) ? array_map('esc_url_raw', $_POST['order']) : [];
    if ($post_id && is_array($order)) {
        update_post_meta($post_id, '_company_logo_gallery', $order);
    }
    wp_send_json_success(['order_saved' => true]);
}

add_action('wp_ajax_fintech_upload_media', 'fintech_upload_media');
add_action('wp_ajax_nopriv_fintech_upload_media', 'fintech_upload_media');

function fintech_upload_media()
{
    if (empty($_FILES['file'])) {
        wp_send_json_error(['message' => 'No file uploaded']);
    }

    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $file = $_FILES['file'];
    $upload_id = media_handle_upload('file', 0);

    if (is_wp_error($upload_id)) {
        wp_send_json_error(['message' => $upload_id->get_error_message()]);
    }

    $url = wp_get_attachment_url($upload_id);

    var_dump($url);
    var_dump($file);

    return $url;
    wp_send_json_success(['url' => $url, 'id' => $upload_id]);
}


// function fintech_upload_media()
// {
//     if (!function_exists('wp_handle_upload')) {
//         require_once(ABSPATH . 'wp-admin/includes/file.php');
//     }

//     $uploaded_files = $_FILES['attach_media'];
//     $uploaded_urls = [];
//     $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

//     foreach ($uploaded_files['name'] as $key => $value) {
//         if ($uploaded_files['name'][$key]) {
//             $file = [
//                 'name' => $uploaded_files['name'][$key],
//                 'type' => $uploaded_files['type'][$key],
//                 'tmp_name' => $uploaded_files['tmp_name'][$key],
//                 'error' => $uploaded_files['error'][$key],
//                 'size' => $uploaded_files['size'][$key],
//             ];

//             $upload_overrides = ['test_form' => false];
//             $movefile = wp_handle_upload($file, $upload_overrides);

//             if ($movefile && !isset($movefile['error'])) {
//                 $uploaded_urls[] = $movefile['url'];
//             }
//         }
//     }

//     if ($post_id && !empty($uploaded_urls)) {
//         $existing = get_post_meta($post_id, '_company_logo_gallery', true);
//         if (!is_array($existing)) $existing = [];
//         $merged = array_merge($existing, $uploaded_urls);
//         update_post_meta($post_id, '_company_logo_gallery', $merged);
//     }

//     wp_send_json_success(['files' => $uploaded_urls]);
// }
