
<?php
/**
 * Template Name: Store Archive Page
 * Description: Custom template for displaying the store archive.
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <header class="page-header">
            <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
            <?php the_archive_description( 
                '<div class="archive-description">', 
                '</div>' 
            ); ?>
        </header><!-- .page-header -->

        <div class="store-archive-container">
            <div class="store-grid">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        get_template_part( 'parts/store-card' );
                    endwhile;
                else :
                    get_template_part( 'parts/content', 'none' );
                endif;
                ?>
            </div>

            <?php the_posts_pagination(); ?>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar( 'store' );
get_footer();


