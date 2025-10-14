<?php

/**
 * Fintech Archive Page
 * 
 * @package fintech_profiler
 */

get_header();
?>
<main id="main" class="site-main full-width">
    <div class="container">
        <header class="page-header">
            <?php
            echo '<h1 class="page-title">Explore Fintechs </h1>';
            // the_archive_title( '<h1 class="page-title">', '</h1>' );
            // the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header><!-- .page-header -->
        <div class="row">
            <div class="archive-filter">
                <div class="archive-page-filter">
                    <h3>Filters</h3><button class="btn-filter" id="fintech-filter">Apply</button>
                </div>
                <div class="archive-search-box">
                    <input type="search" id="archive-search" placeholder="Search ..." />
                </div>
            </div>
        </div>
        <div class="row">

            <?php if (have_posts()) : ?>

                <div id="primary" class="content-area fintech-archive">
                    <div class="inner-contents">
                        <div class="inner-row">
                            <?php
                            /* Start the Loop */
                            while (have_posts()) :
                                the_post();
                                global $post;

                                do_action('fintech_profiler_archive_content');
                            ?>


                            <?php endwhile; ?>
                        </div>
                    </div>
                </div><!-- #primary -->
            <?php else :
                echo "<h2>No Item Found </h2>";

            endif; ?>

            <aside id="sidebar">
                <form method="post" id="fintech-filter-form">

                    <div class="sidebar-section category-filter">

                        <!-- Fintech Category -->
                        <h4 class="sidebar-title">Categories</h4>
                        <?php
                        $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

                        $post_type = 'fintech';

                        $taxonomies = get_object_taxonomies($post_type);

                        $categories = get_terms(['taxonomy' => 'category', 'hide_empty' => false]);

                        $taxonomy = 'category';

                        $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];
                        echo '<ul>';
                        render_taxonomy_tree('category', 0, $selected_cats);
                        echo '</ul>';
                        ?>

                    </div>

                    <!-- Cost Price Model -->
                    <div class="sidebar-section pricing-category">
                        <h4 class="sidebar-title">Cost Price Model</h4>
                        <?php
                        $models = get_terms(['taxonomy' => 'fintech-pricing', 'hide_empty' => false]);
                        echo '<ul>';
                        render_taxonomy_tree('fintech-pricing', 0, $models);
                        echo '</ul>';
                        ?>

                        <!-- Price Range -->
                        <h5 class="sidebar-title title-pricing">Pricing Range</h5>

                        <div id="slider-range"></div>
                        <div class="slider-value">
                            <div>
                                <label>Minimum</label> <input type="text" id="min_price" name="min_price" value="<?php echo esc_attr($_GET['min_price'] ?? ''); ?>">
                            </div>
                            <div>
                                <label>Maximum</label> <input type="text" id="max_price" name="max_price" value="<?php echo esc_attr($_GET['max_price'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="sidebar-section size-filter">
                        <h4>Size</h4>
                        <?php
                        $sizes = get_terms(['taxonomy' => 'fintech-size', 'hide_empty' => false]);
                        echo '<ul>';
                        render_taxonomy_tree('fintech-size', 0, $sizes);
                        echo '</ul>';
                        ?>

                    </div>
                    <!-- Location -->
                    <div class="sidebar-section location-filter">
                        <h4>Location</h4>
                        <div class="filter-location">
                            <select id="country" name="country">
                                <option value="">Select Country</option>
                            </select>
                            <select id="state" name="state">
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <input type="text" name="city" placeholder="City" value="<?php echo esc_attr($_GET['city'] ?? ''); ?>">
                    </div>

                    <button type="submit" style="display: none;">Filter</button>
                </form>

            </aside>

        </div>
    </div>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();
