
<?php
/**
 * Template Part: Map Controls
 * Description: Displays the map control elements.
 */
?>

<div class="map-controls">
    <div class="map-search-bar">
        <input type="text" id="map-search-input" placeholder="Search for stores...">
        <button id="map-search-button"><i class="fas fa-search"></i></button>
    </div>
    <div class="map-filters">
        <select id="map-filter-category">
            <option value="">All Categories</option>
            <?php
            $categories = get_terms( array(
                'taxonomy'   => 'store_category',
                'hide_empty' => false,
            ) );
            foreach ( $categories as $category ) {
                echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
            }
            ?>
        </select>
        <button id="find-my-location"><i class="fas fa-crosshairs"></i> Find Me</button>
    </div>
</div>


