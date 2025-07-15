<?php
/**
 * Template Part: Store Card
 * Description: Displays a single store card in archive loops.
 */

$store_id = get_the_ID();
$store_name = get_the_title();
$store_link = get_permalink();
$store_address = get_post_meta( $store_id, 
    'mohtawa_store_address', true );
$store_category = get_the_terms( $store_id, 
    'store_category' );
$store_rating = get_post_meta( $store_id, 
    'mohtawa_store_rating', true );
$store_image = get_the_post_thumbnail_url( $store_id, 
    'medium' );

?>

<div class="store-card">
    <div class="store-card-image">
        <?php if ( $store_image ) : ?>
            <a href="<?php echo esc_url( $store_link ); ?>">
                <img src="<?php echo esc_url( $store_image ); ?>" alt="<?php echo esc_attr( $store_name ); ?>">
            </a>
        <?php else : ?>
            <div class="placeholder-image"></div>
        <?php endif; ?>
    </div>
    <div class="store-card-content">
        <h3 class="store-card-title"><a href="<?php echo esc_url( $store_link ); ?>"><?php echo esc_html( $store_name ); ?></a></h3>
        <?php if ( $store_category && ! is_wp_error( $store_category ) ) : ?>
            <div class="store-card-category">
                <?php foreach ( $store_category as $category ) : ?>
                    <span class="category-tag" style="background-color: <?php echo esc_attr( get_term_meta( $category->term_id, 'category_color', true ) ); ?>;"><?php echo esc_html( $category->name ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ( $store_address ) : ?>
            <p class="store-card-address"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html( $store_address ); ?></p>
        <?php endif; ?>
        <?php if ( $store_rating ) : ?>
            <div class="store-card-rating">
                <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
                    <?php if ( $store_rating >= $i ) : ?>
                        <i class="fas fa-star"></i>
                    <?php elseif ( $store_rating > ( $i - 1 ) ) : ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php else : ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                <?php endfor; ?>
                <span>(<?php echo esc_html( $store_rating ); ?>)</span>
            </div>
        <?php endif; ?>
        <a href="<?php echo esc_url( $store_link ); ?>" class="store-card-button">View Details</a>
    </div>
</div>


