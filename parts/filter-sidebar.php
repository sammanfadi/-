
<?php
/**
 * Template Part: Filter Sidebar
 * Description: Displays the filter sidebar for stores.
 */
?>

<aside class="filter-sidebar">
    <button class="filter-close-button"><i class="fas fa-times"></i></button>
    <h3>Filter Stores</h3>
    <div class="filter-section">
        <h4>Categories</h4>
        <ul>
            <?php
            $categories = get_terms( array(
                'taxonomy'   => 'store_category',
                'hide_empty' => false,
                'fields'     => 'all',				
            ) );
            foreach ( $categories as $category ) {
                $term = is_object( $category ) ? $category : get_term( $category, 'store_category' );
                if ( ! $term || is_wp_error( $term ) ) {
                    continue;
                }
                echo '<li><label><input type="checkbox" class="filter-checkbox" data-filter="category" value="' . esc_attr( $term->slug ) . '"> ' . esc_html( $term->name ) . '</label></li>';
            }
            ?>
        </ul>
    </div>

    <div class="filter-section">
        <h4>Rating</h4>
        <div class="rating-filter">
            <label><input type="radio" name="rating-filter" value="5"> 5 Stars</label>
            <label><input type="radio" name="rating-filter" value="4"> 4 Stars & Up</label>
            <label><input type="radio" name="rating-filter" value="3"> 3 Stars & Up</label>
        </div>
    </div>

    <div class="filter-section">
        <h4>Open Now</h4>
        <label><input type="checkbox" class="filter-checkbox" data-filter="open-now" value="true"> Open Now</label>
    </div>

    <button class="apply-filters-button">Apply Filters</button>
    <button class="clear-filters-button">Clear Filters</button>
</aside>


