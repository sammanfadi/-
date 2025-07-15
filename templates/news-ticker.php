
<?php
/**
 * Template Name: News Ticker
 * Description: A template for displaying a news ticker.
 */

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$news_query = new WP_Query( $args );

if ( $news_query->have_posts() ) : ?>
    <div class="news-ticker-container">
        <ul class="news-ticker">
            <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <span class="news-date"><?php echo get_the_date(); ?>:</span>
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
<?php endif; 

wp_reset_postdata();


