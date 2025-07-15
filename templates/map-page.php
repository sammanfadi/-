<?php
/**
 * Template Name: Map Page
 * Description: A full-width page template for displaying the interactive map.
 */

get_header(); ?>

<div id="primary" class="content-area full-width-map">
    <main id="main" class="site-main">

        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'parts/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>

        <div id="mohtawa-map" style="height: 600px; width: 100%;"></div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();


