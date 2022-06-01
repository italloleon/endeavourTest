<?php

/**
 * The template for displaying a single brewery
 *
 * @package    ImportApiPlugin
 * @subpackage ImportApiPlugin/src
 * @author     Itallo Leonardo <itallolaraujo@gmail.com.com>
 * @since      1.0.0
 */

get_header();
?>
<main id="brewery-template">

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ob_start();
            $current_id = get_the_ID();
            $brewery_type = get_the_terms(get_the_ID(), 'category');
            $city = get_post_meta(get_the_ID(), 'city')[0];
            $country = get_post_meta(get_the_ID(), 'country')[0];
            $phone = get_post_meta(get_the_ID(), 'phone')[0];
            $website_url = get_post_meta(get_the_ID(), 'website_url')[0];
            $postal_code = get_post_meta(get_the_ID(), 'postal_code')[0];
    ?>
            <header class="brewery-header">
                <div class="brewery-header-container">
                    <h1 class="brewery-title">
                        <?php the_title(); ?>
                    </h1>
                </div>
            </header>
            <section class="brewery-template-container">
                <article class="brewery-body">
                    <?php if ($city) : ?>
                        <p class="brewery-info brewery-city">
                            <?php _e('City: ', 'import-api-plugin'); ?>
                            <?php echo $city; ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($country) : ?>
                        <p class="brewery-info brewery-country">
                            <?php _e('Country: ', 'import-api-plugin'); ?>
                            <?php echo $country; ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($phone) : ?>
                        <p class="brewery-info brewery-phone">
                            <?php _e('Phone: ', 'import-api-plugin'); ?>
                            <?php echo $phone; ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($postal_code) : ?>
                        <p class="brewery-info brewery-postal_code">
                            <?php _e('Postal Code: ', 'import-api-plugin'); ?>
                            <?php echo $postal_code; ?>
                        </p>
                    <?php endif; ?>
                    <?php if ($website_url) : ?>
                        <a target="_blank" href="<?php echo $website_url; ?>" class="brewery-website_url">
                            <?php _e('See more', 'import-api-plugin'); ?>
                        </a>
                    <?php endif; ?>
                </article>
                <aside class="brewery-side-bar">
                    <h2 class="related-breweries-container-title">Related Breweries</h2>
                    <div class="related-breweries-container">
                        <?php
                        $brewery_args = array(
                            'post_type' => 'brewery',
                            'post_status' => 'publish',
                            'post__not_in' => array($current_id),
                            'posts_per_page' => 5,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'category',
                                    'field'    => 'slug',
                                    'terms'    => $brewery_type[0]->slug,
                                ),
                            ),
                        );
                        $brewery_query = new WP_Query($brewery_args);
                        ?>
                        <?php if ($brewery_query->have_posts()) : ?>
                            <?php while ($brewery_query->have_posts()) : $brewery_query->the_post(); ?>
                                <div class="related-brewery">
                                    <a href="<?php the_permalink(); ?>" class="related-brewery-link">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                </aside>
            </section>
    <?php
            echo ob_get_clean();
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
</main>

<?php
get_footer();
