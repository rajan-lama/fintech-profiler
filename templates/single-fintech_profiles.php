<?php
get_header();
?>

<main id="main" class="site-main">
    <div class="entry-header">
        <?php

        $meta = get_post_meta(get_the_ID());

        $meta_pricing = get_post_meta(get_the_ID(), 'pricing_plans', true);
        $meta_cs = get_post_meta(get_the_ID(), 'case_studies', true);

        // var_dump('meta', $meta);
        // var_dump('meta_pricing', $meta_pricing);
        // var_dump('meta_cs', $meta_cs);
        if (function_exists('fintech_profiler_breadcrumbs')) {
            fintech_profiler_breadcrumbs();
        }
        ?>
        <h1 class="entry-title"><?php the_title(); ?> Rajan</h1>
        <ul>
            <li>
                <a href="#" class="btn btn-secondary btn-request-demo"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.9733 10.9373C19.3397 11.6988 19.3447 12.6568 17.9733 13.5177L7.37627 20.6645C6.04478 21.3751 5.14046 20.9556 5.04553 19.418L5.00057 4.45982C4.97059 3.04355 6.13721 2.6434 7.24887 3.32244L17.9733 10.9373Z" stroke="black" stroke-opacity="0.8" stroke-width="2" />
                    </svg> Request Demo</a>
            </li>
            <li>
                <a href="#" class="btn btn-secondary btn-favourite"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.80674 6.20659C4.70687 5.30673 5.92755 4.80122 7.20034 4.80122C8.47313 4.80122 9.69381 5.30673 10.5939 6.20659L12.0003 7.61179L13.4067 6.20659C13.8495 5.74815 14.3792 5.38247 14.9648 5.13091C15.5504 4.87934 16.1803 4.74693 16.8176 4.74139C17.455 4.73585 18.087 4.8573 18.6769 5.09865C19.2668 5.34 19.8028 5.69641 20.2534 6.1471C20.7041 6.59778 21.0605 7.13371 21.3019 7.72361C21.5432 8.31352 21.6647 8.94558 21.6591 9.58292C21.6536 10.2203 21.5212 10.8501 21.2696 11.4357C21.0181 12.0214 20.6524 12.551 20.1939 12.9938L12.0003 21.1886L3.80674 12.9938C2.90688 12.0937 2.40137 10.873 2.40137 9.60019C2.40137 8.32741 2.90688 7.10673 3.80674 6.20659V6.20659Z" stroke="black" stroke-width="2" stroke-linejoin="round" />
                    </svg> Favourite</a>
            </li>
            <li>
                <a href="#" class="btn btn-primary btn-visit-website">Visit Website</a>
            </li>
            <li>
                <a href="#" class="btn btn-secondary btn-download-brochure"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.9996 7.20039C10.6741 7.20039 9.59961 6.12587 9.59961 4.80039C9.59961 3.47491 10.6741 2.40039 11.9996 2.40039C13.3251 2.40039 14.3996 3.47491 14.3996 4.80039C14.3996 6.12587 13.3251 7.20039 11.9996 7.20039Z" fill="black" fill-opacity="0.8" />
                        <path d="M11.9996 14.4004C10.6741 14.4004 9.59961 13.3259 9.59961 12.0004C9.59961 10.6749 10.6741 9.60039 11.9996 9.60039C13.3251 9.60039 14.3996 10.6749 14.3996 12.0004C14.3996 13.3259 13.3251 14.4004 11.9996 14.4004Z" fill="black" fill-opacity="0.8" />
                        <path d="M11.9996 21.6004C10.6741 21.6004 9.59961 20.5259 9.59961 19.2004C9.59961 17.8749 10.6741 16.8004 11.9996 16.8004C13.3251 16.8004 14.3996 17.8749 14.3996 19.2004C14.3996 20.5259 13.3251 21.6004 11.9996 21.6004Z" fill="black" fill-opacity="0.8" />
                    </svg>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.07583 1.64344C8.39329 0.785522 9.60671 0.785521 9.92417 1.64344L11.5043 5.91355C11.6041 6.18328 11.8167 6.39594 12.0864 6.49575L16.3566 8.07583C17.2145 8.39329 17.2145 9.60671 16.3566 9.92417L12.0864 11.5043C11.8167 11.6041 11.6041 11.8167 11.5043 12.0864L9.92417 16.3566C9.60671 17.2145 8.39329 17.2145 8.07583 16.3566L6.49575 12.0864C6.39594 11.8167 6.18328 11.6041 5.91355 11.5043L1.64344 9.92417C0.785522 9.60671 0.785521 8.39329 1.64344 8.07583L5.91355 6.49575C6.18328 6.39594 6.39594 6.18328 6.49575 5.91355L8.07583 1.64344Z" stroke="black" stroke-opacity="0.8" stroke-width="1.66667" stroke-linejoin="round" />
                            </svg> Claim Company</a></li>
                    <li><a href="#"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 10.7497V7.01173M10 13.5203V13.5532M14.7249 16.6663H5.27506C3.98425 16.6663 2.89494 15.8132 2.55221 14.6461C2.40591 14.1479 2.58567 13.6289 2.86063 13.1871L7.58557 4.66719C8.69258 2.88828 11.3074 2.88828 12.4144 4.6672L17.1394 13.1871C17.4143 13.6289 17.5941 14.1479 17.4478 14.6461C17.1051 15.8132 16.0157 16.6663 14.7249 16.6663Z" stroke="black" stroke-opacity="0.8" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> Report Incorrect Information</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="entry-content">

        <div class="container">
            <div>
                <?php
                $slides = get_post_meta(get_the_ID(), 'fintech_profiler_slides', true);

                if (! empty($slides)) {
                    echo '<div class="owl-carousel fintech-carousel">';
                    foreach ($slides as $slide) {
                        if (empty($slide['image_id'])) {
                            continue; // Skip if no image ID
                        }

                        $image_id = $slide['image_id'];

                        // This returns a complete <img> tag with your custom size
                        $image_tag = wp_get_attachment_image($image_id, 'fintech_profiler_slider', false, array(
                            'alt' => '', // you can set a dynamic alt here
                        ));

                        echo '<div class="item">';
                        echo $image_tag; // Directly output the <img>
                        echo '</div>';
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <div class="container">

            <div class="row content-holder">
                <section id="primary" class="content-area">
                    <div id="tabs" class="fintech-tabs">
                        <ul>
                            <li><a href="#overview">Overview</a></li>
                            <li><a href="#pricing-plans">Pricing Plans</a></li>
                            <li><a href="#case-studies">Case Studies</a></li>
                        </ul>
                        <div id="overview">
                            <?php
                            $content = apply_filters('the_content', get_the_content());

                            // Split content at the more tag
                            if (strpos($content, 'id="more-') !== false) {
                                // Use regex to split into two parts
                                preg_match('/^(.*?)<span id="more-\d+"><\/span>(.*)$/is', $content, $matches);

                                $before_more = isset($matches[1]) ? $matches[1] : $content;
                                $after_more  = isset($matches[2]) ? $matches[2] : '';

                            ?>
                                <div class="content-before">
                                    <?php echo $before_more; ?>
                                </div>

                                <?php if ($after_more) : ?>
                                    <div class="content-after" style="display:none;">
                                        <?php echo $after_more; ?>
                                    </div>
                                    <button class="btn btn-secondary toggle-more">Show More</button>
                            <?php endif;
                            } else {
                                echo $content;
                            } ?>

                        </div>
                        <div id="pricing-plans">
                            <?php
                            $pricing_plans_content = get_post_meta(get_the_ID(), 'fintech_pricing_plans', true);

                            if ($pricing_plans_content) {
                                echo '<table>';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Plan Name</th>';
                                echo '<th>Description</th>';
                                echo '<th>Cost</th>';
                                echo '</tr>';
                                echo ' </thead>';
                                echo '<tbody>';
                                foreach ($pricing_plans_content as $plan) {

                                    echo '<tr>';
                                    echo '<td>' . esc_html($plan['name']) . '</td>';
                                    echo '<td>' . esc_html($plan['description']) . '</td>';
                                    echo '<td>' . esc_html($plan['cost']) . '</td>';
                                    echo '</tr>';
                                }
                                echo '</tbody></table>';
                                // echo apply_filters('the_content', $pricing_plans_content);
                            } else {
                                echo '<p>' . esc_html__('No pricing plans available.', 'fintech-profiler') . '</p>';
                            }
                            ?>
                        </div>
                        <div id="case-studies">
                            <?php
                            $case_studies_content = get_post_meta(get_the_ID(), 'fintech_case_studies', true);
                            if ($case_studies_content) {
                                foreach ($case_studies_content as $case) {
                                    echo '<a href="' . esc_url($case['link']) . '">' . esc_html($case['title']) . '</a>';
                                }
                                // echo apply_filters('the_content', $case_studies_content);
                            } else {
                                echo '<p>' . esc_html__('No case studies available.', 'fintech-profiler') . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php do_action('fintech_profiler_after_post_content'); ?>
                </section>
                <aside id="sidebar">
                    <div class="sidebar-widget sidebar-widget--services-provided">
                        <h3><?php esc_html_e('Services Provided', 'fintech-profiler'); ?></h3>
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'fintech-category');

                        if (! empty($terms) && ! is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                echo '<a href="" class="btn-category">' . esc_html($term->name) . '</a>';
                            }
                        }
                        ?>
                    </div>
                    <div class="sidebar-widget sidebar-widget--company-info">
                        <h3><?php esc_html_e('More Information', 'fintech-profiler'); ?></h3>
                        <ul class="more-info-list">
                            <?php
                            $founded = get_post_meta(get_the_ID(), 'fintech_founded', true);
                            $company_size = get_post_meta(get_the_ID(), 'fintech_company_size', true);
                            $pricing_model = get_post_meta(get_the_ID(), 'fintech_pricing_model', true);
                            $min_pricing = get_post_meta(get_the_ID(), 'fintech_minimum_pricing', true);
                            $max_pricing = get_post_meta(get_the_ID(), 'fintech_maximum_pricing', true);


                            if ($founded && !empty($founded)) {
                                echo '<li><strong>' . esc_html__('Founded:', 'fintech-profiler') . '</strong> <span>' . esc_html($founded) . '</span></li>';
                            }
                            if ($company_size && !empty($company_size)) {
                                echo '<li><strong>' . esc_html__('Company Size:', 'fintech-profiler') . '</strong> <span>' . esc_html($company_size) . '</span></li>';
                            }
                            if ($pricing_model && !empty($pricing_model)) {
                                echo '<li><strong>' . esc_html__('Pricing Model:', 'fintech-profiler') . '</strong> <span>' . esc_html($pricing_model) . '</span></li>';
                            }
                            if ($min_pricing && !empty($min_pricing) && $max_pricing && !empty($max_pricing)) {
                                echo '<li><strong>' . esc_html__('Pricing range:', 'fintech-profiler') . '</strong> <span>$' . esc_html($min_pricing) . ' - ' . esc_html($max_pricing) . '</span></li>';
                            }

                            ?>
                        </ul>
                    </div>
                    <div class="sidebar-widget">
                        <h3><?php esc_html_e('More Information', 'fintech-profiler'); ?></h2>
                            <ul class="more-info-list">
                                <?php
                                $website = get_post_meta(get_the_ID(), 'fintech_website', true);
                                $email = get_post_meta(get_the_ID(), 'fintech_email', true);
                                $phone = get_post_meta(get_the_ID(), 'fintech_phone', true);
                                $location = get_post_meta(get_the_ID(), 'fintech_location', true);

                                if ($website && !empty($website)) {
                                    echo '<li><strong>' . esc_html__('Website:', 'fintech-profiler') . '</strong> <span><a href="' . esc_url($website) . '" target="_blank">' . esc_html($website) . '</a></span></li>';
                                }
                                if ($email && !empty($email)) {
                                    echo '<li><strong>' . esc_html__('Email:', 'fintech-profiler') . '</strong> <span><a href="mailto:' . esc_html($email) . '">' . esc_html($email) . '</a></span></li>';
                                }
                                if ($phone && !empty($phone)) {
                                    echo '<li><strong>' . esc_html__('Phone:', 'fintech-profiler') . '</strong> <span><a href="tel:' . esc_html($phone) . '">' . esc_html($phone) . '</a></span></li>';
                                }
                                if ($location && !empty($location)) {
                                    echo '<li><strong>' . esc_html__('Location:', 'fintech-profiler') . '</strong> <span>' . nl2br(esc_html($location)) . '</span></li>';
                                }
                                ?>
                            </ul>
                    </div>
                </aside>
            </div>
        </div>

        <div class="container">
            <?php
            // Display the content after the post
            do_action('fintech_profiler_before_footer');
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
