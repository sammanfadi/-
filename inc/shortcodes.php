<?php
/**
 * اختصارات مخصصة لقالب محتوى
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// منع الوصول المباشر
if (!defined('ABSPATH')) {
    exit;
}

/**
 * اختصار عرض خريطة المتاجر
 * [mohtawa_map height="400" zoom="11" category="" location=""]
 */
function mohtawa_map_shortcode($atts) {
    $atts = shortcode_atts(array(
        'height' => '400',
        'zoom' => '11',
        'category' => '',
        'location' => '',
        'featured_only' => 'false',
        'show_search' => 'true',
        'show_filters' => 'true'
    ), $atts, 'mohtawa_map');
    
    $map_id = 'map-' . uniqid();
    
    // إعداد استعلام المتاجر
    $args = array(
        'post_type' => 'store',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    
    $meta_query = array();
    $tax_query = array();
    
    if ($atts['featured_only'] === 'true') {
        $meta_query[] = array(
            'key' => 'store_featured',
            'value' => '1',
            'compare' => '='
        );
    }
    
    if (!empty($atts['category'])) {
        $tax_query[] = array(
            'taxonomy' => 'store_category',
            'field' => 'slug',
            'terms' => $atts['category']
        );
    }
    
    if (!empty($atts['location'])) {
        $tax_query[] = array(
            'taxonomy' => 'store_location',
            'field' => 'slug',
            'terms' => $atts['location']
        );
    }
    
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }
    
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    
    $stores = get_posts($args);
    
    // تحضير بيانات المتاجر للخريطة
    $stores_data = array();
    foreach ($stores as $store) {
        $lat = get_post_meta($store->ID, 'store_latitude', true);
        $lng = get_post_meta($store->ID, 'store_longitude', true);
        
        if ($lat && $lng) {
            $category_terms = get_the_terms($store->ID, 'store_category');
            $category_color = '#3498db';
            $category_icon = 'store';
            
            if ($category_terms && !is_wp_error($category_terms)) {
                $category = $category_terms[0];
                $category_color = get_term_meta($category->term_id, 'category_color', true) ?: '#3498db';
                $category_icon = get_term_meta($category->term_id, 'category_icon', true) ?: 'store';
            }
            
            $stores_data[] = array(
                'id' => $store->ID,
                'title' => $store->post_title,
                'lat' => floatval($lat),
                'lng' => floatval($lng),
                'url' => get_permalink($store->ID),
                'address' => get_post_meta($store->ID, 'store_address', true),
                'phone' => get_post_meta($store->ID, 'store_phone', true),
                'rating' => get_post_meta($store->ID, 'store_rating', true),
                'featured' => get_post_meta($store->ID, 'store_featured', true) === '1',
                'category_color' => $category_color,
                'category_icon' => $category_icon,
                'image' => get_the_post_thumbnail_url($store->ID, 'thumbnail')
            );
        }
    }
    
    ob_start();
    ?>
    <div class="mohtawa-map-container">
        <?php if ($atts['show_search'] === 'true' || $atts['show_filters'] === 'true') : ?>
        <div class="map-controls">
            <?php if ($atts['show_search'] === 'true') : ?>
            <div class="map-search">
                <input type="text" id="<?php echo $map_id; ?>-search" placeholder="<?php _e('ابحث عن متجر...', 'mohtawa'); ?>">
                <button type="button" id="<?php echo $map_id; ?>-search-btn"><?php _e('بحث', 'mohtawa'); ?></button>
            </div>
            <?php endif; ?>
            
            <?php if ($atts['show_filters'] === 'true') : ?>
            <div class="map-filters">
                <select id="<?php echo $map_id; ?>-category-filter">
                    <option value=""><?php _e('جميع الفئات', 'mohtawa'); ?></option>
                    <?php
                    $categories = get_terms(array('taxonomy' => 'store_category', 'hide_empty' => true));
                    foreach ($categories as $category) {
                        echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
                
                <select id="<?php echo $map_id; ?>-location-filter">
                    <option value=""><?php _e('جميع المناطق', 'mohtawa'); ?></option>
                    <?php
                    $locations = get_terms(array('taxonomy' => 'store_location', 'hide_empty' => true));
                    foreach ($locations as $location) {
                        echo '<option value="' . esc_attr($location->slug) . '">' . esc_html($location->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div id="<?php echo $map_id; ?>" class="mohtawa-map" style="height: <?php echo esc_attr($atts['height']); ?>px;"></div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapData = <?php echo json_encode($stores_data); ?>;
        const mapConfig = {
            zoom: <?php echo intval($atts['zoom']); ?>,
            center: [<?php echo get_theme_mod('mohtawa_map_default_lat', '24.7136'); ?>, <?php echo get_theme_mod('mohtawa_map_default_lng', '46.6753'); ?>]
        };
        
        // إنشاء الخريطة
        const map = L.map('<?php echo $map_id; ?>').setView(mapConfig.center, mapConfig.zoom);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // إضافة العلامات
        const markers = [];
        mapData.forEach(function(store) {
            const marker = L.marker([store.lat, store.lng]).addTo(map);
            
            const popupContent = `
                <div class="store-popup">
                    ${store.image ? `<img src="${store.image}" alt="${store.title}" class="store-popup-image">` : ''}
                    <h4><a href="${store.url}">${store.title}</a></h4>
                    ${store.address ? `<p class="address"><i class="fas fa-map-marker-alt"></i> ${store.address}</p>` : ''}
                    ${store.phone ? `<p class="phone"><i class="fas fa-phone"></i> ${store.phone}</p>` : ''}
                    ${store.rating ? `<div class="rating">${'★'.repeat(store.rating)}${'☆'.repeat(5-store.rating)}</div>` : ''}
                    ${store.featured ? '<span class="featured-badge">مميز</span>' : ''}
                </div>
            `;
            
            marker.bindPopup(popupContent);
            markers.push({marker: marker, data: store});
        });
        
        // وظائف البحث والفلترة
        <?php if ($atts['show_search'] === 'true') : ?>
        document.getElementById('<?php echo $map_id; ?>-search-btn').addEventListener('click', function() {
            const searchTerm = document.getElementById('<?php echo $map_id; ?>-search').value.toLowerCase();
            filterMarkers();
        });
        
        document.getElementById('<?php echo $map_id; ?>-search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterMarkers();
            }
        });
        <?php endif; ?>
        
        <?php if ($atts['show_filters'] === 'true') : ?>
        document.getElementById('<?php echo $map_id; ?>-category-filter').addEventListener('change', filterMarkers);
        document.getElementById('<?php echo $map_id; ?>-location-filter').addEventListener('change', filterMarkers);
        <?php endif; ?>
        
        function filterMarkers() {
            const searchTerm = document.getElementById('<?php echo $map_id; ?>-search') ? 
                document.getElementById('<?php echo $map_id; ?>-search').value.toLowerCase() : '';
            const categoryFilter = document.getElementById('<?php echo $map_id; ?>-category-filter') ? 
                document.getElementById('<?php echo $map_id; ?>-category-filter').value : '';
            const locationFilter = document.getElementById('<?php echo $map_id; ?>-location-filter') ? 
                document.getElementById('<?php echo $map_id; ?>-location-filter').value : '';
            
            markers.forEach(function(item) {
                let show = true;
                
                if (searchTerm && !item.data.title.toLowerCase().includes(searchTerm)) {
                    show = false;
                }
                
                // يمكن إضافة المزيد من منطق الفلترة هنا
                
                if (show) {
                    map.addLayer(item.marker);
                } else {
                    map.removeLayer(item.marker);
                }
            });
        }
    });
    </script>
    <?php
    
    return ob_get_clean();
}
add_shortcode('mohtawa_map', 'mohtawa_map_shortcode');

/**
 * اختصار عرض قائمة المتاجر
 * [mohtawa_stores number="6" category="" location="" featured_only="false" layout="grid"]
 */
function mohtawa_stores_shortcode($atts) {
    $atts = shortcode_atts(array(
        'number' => '6',
        'category' => '',
        'location' => '',
        'featured_only' => 'false',
        'layout' => 'grid', // grid, list, carousel
        'show_rating' => 'true',
        'show_address' => 'true',
        'show_excerpt' => 'true'
    ), $atts, 'mohtawa_stores');
    
    // إعداد استعلام المتاجر
    $args = array(
        'post_type' => 'store',
        'posts_per_page' => intval($atts['number']),
        'post_status' => 'publish'
    );
    
    $meta_query = array();
    $tax_query = array();
    
    if ($atts['featured_only'] === 'true') {
        $meta_query[] = array(
            'key' => 'store_featured',
            'value' => '1',
            'compare' => '='
        );
    }
    
    if (!empty($atts['category'])) {
        $tax_query[] = array(
            'taxonomy' => 'store_category',
            'field' => 'slug',
            'terms' => $atts['category']
        );
    }
    
    if (!empty($atts['location'])) {
        $tax_query[] = array(
            'taxonomy' => 'store_location',
            'field' => 'slug',
            'terms' => $atts['location']
        );
    }
    
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }
    
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    
    $stores = get_posts($args);
    
    if (!$stores) {
        return '<p>' . __('لا توجد متاجر متاحة.', 'mohtawa') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="mohtawa-stores-shortcode layout-<?php echo esc_attr($atts['layout']); ?>">
        <?php foreach ($stores as $store) : 
            $store_rating = get_post_meta($store->ID, 'store_rating', true);
            $store_address = get_post_meta($store->ID, 'store_address', true);
            $store_phone = get_post_meta($store->ID, 'store_phone', true);
            $store_featured = get_post_meta($store->ID, 'store_featured', true) === '1';
            $store_image = get_the_post_thumbnail_url($store->ID, 'medium');
        ?>
            <div class="store-item">
                <?php if ($store_image) : ?>
                <div class="store-image">
                    <a href="<?php echo get_permalink($store->ID); ?>">
                        <img src="<?php echo esc_url($store_image); ?>" alt="<?php echo esc_attr($store->post_title); ?>">
                    </a>
                    <?php if ($store_featured) : ?>
                        <span class="featured-badge"><?php _e('مميز', 'mohtawa'); ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="store-content">
                    <h3 class="store-title">
                        <a href="<?php echo get_permalink($store->ID); ?>">
                            <?php echo esc_html($store->post_title); ?>
                        </a>
                    </h3>
                    
                    <?php if ($atts['show_rating'] === 'true' && $store_rating) : ?>
                    <div class="store-rating">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $store_rating ? '★' : '☆';
                        }
                        ?>
                        <span class="rating-number">(<?php echo esc_html($store_rating); ?>)</span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($atts['show_address'] === 'true' && $store_address) : ?>
                    <p class="store-address">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo esc_html($store_address); ?>
                    </p>
                    <?php endif; ?>
                    
                    <?php if ($atts['show_excerpt'] === 'true' && $store->post_excerpt) : ?>
                    <p class="store-excerpt"><?php echo esc_html($store->post_excerpt); ?></p>
                    <?php endif; ?>
                    
                    <div class="store-meta">
                        <?php
                        $categories = get_the_terms($store->ID, 'store_category');
                        if ($categories && !is_wp_error($categories)) {
                            echo '<span class="store-category">' . esc_html($categories[0]->name) . '</span>';
                        }
                        ?>
                        
                        <?php if ($store_phone) : ?>
                        <a href="tel:<?php echo esc_attr($store_phone); ?>" class="store-phone">
                            <i class="fas fa-phone"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    
    return ob_get_clean();
}
add_shortcode('mohtawa_stores', 'mohtawa_stores_shortcode');

/**
 * اختصار عرض فئات المتاجر
 * [mohtawa_categories number="8" show_count="true" show_icons="true"]
 */
function mohtawa_categories_shortcode($atts) {
    $atts = shortcode_atts(array(
        'number' => '8',
        'show_count' => 'true',
        'show_icons' => 'true',
        'layout' => 'grid', // grid, list
        'orderby' => 'count', // name, count, term_id
        'order' => 'DESC'
    ), $atts, 'mohtawa_categories');
    
    $categories = get_terms(array(
        'taxonomy' => 'store_category',
        'hide_empty' => true,
        'number' => intval($atts['number']),
        'orderby' => $atts['orderby'],
        'order' => $atts['order']
    ));
    
    if (!$categories || is_wp_error($categories)) {
        return '<p>' . __('لا توجد فئات متاحة.', 'mohtawa') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="mohtawa-categories-shortcode layout-<?php echo esc_attr($atts['layout']); ?>">
        <?php foreach ($categories as $category) : 
            $icon = get_term_meta($category->term_id, 'category_icon', true);
            $color = get_term_meta($category->term_id, 'category_color', true) ?: '#3498db';
        ?>
            <div class="category-item">
                <a href="<?php echo get_term_link($category); ?>" class="category-link">
                    <?php if ($atts['show_icons'] === 'true' && $icon) : ?>
                    <div class="category-icon" style="color: <?php echo esc_attr($color); ?>;">
                        <i class="fas fa-<?php echo esc_attr($icon); ?>"></i>
                    </div>
                    <?php endif; ?>
                    
                    <div class="category-content">
                        <h4 class="category-name"><?php echo esc_html($category->name); ?></h4>
                        
                        <?php if ($atts['show_count'] === 'true') : ?>
                        <span class="category-count">
                            <?php printf(_n('%d متجر', '%d متجر', $category->count, 'mohtawa'), $category->count); ?>
                        </span>
                        <?php endif; ?>
                        
                        <?php if ($category->description) : ?>
                        <p class="category-description"><?php echo esc_html($category->description); ?></p>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    
    return ob_get_clean();
}
add_shortcode('mohtawa_categories', 'mohtawa_categories_shortcode');

/**
 * اختصار عرض نموذج البحث
 * [mohtawa_search_form layout="horizontal" show_filters="true"]
 */
function mohtawa_search_form_shortcode($atts) {
    $atts = shortcode_atts(array(
        'layout' => 'horizontal', // horizontal, vertical
        'show_filters' => 'true',
        'show_location_filter' => 'true',
        'show_category_filter' => 'true',
        'show_rating_filter' => 'false',
        'placeholder' => ''
    ), $atts, 'mohtawa_search_form');
    
    $placeholder = !empty($atts['placeholder']) ? $atts['placeholder'] : __('ابحث عن متجر...', 'mohtawa');
    
    ob_start();
    ?>
    <form class="mohtawa-search-form layout-<?php echo esc_attr($atts['layout']); ?>" method="get" action="<?php echo esc_url(get_post_type_archive_link('store')); ?>">
        <div class="search-input-group">
            <input type="text" name="s" placeholder="<?php echo esc_attr($placeholder); ?>" value="<?php echo get_search_query(); ?>" class="search-input">
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
                <span><?php _e('بحث', 'mohtawa'); ?></span>
            </button>
        </div>
        
        <?php if ($atts['show_filters'] === 'true') : ?>
        <div class="search-filters">
            <?php if ($atts['show_category_filter'] === 'true') : ?>
            <div class="filter-group">
                <select name="store_category" class="filter-select">
                    <option value=""><?php _e('جميع الفئات', 'mohtawa'); ?></option>
                    <?php
                    $categories = get_terms(array('taxonomy' => 'store_category', 'hide_empty' => true));
                    foreach ($categories as $category) {
                        $selected = (isset($_GET['store_category']) && $_GET['store_category'] === $category->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($category->slug) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php endif; ?>
            
            <?php if ($atts['show_location_filter'] === 'true') : ?>
            <div class="filter-group">
                <select name="store_location" class="filter-select">
                    <option value=""><?php _e('جميع المناطق', 'mohtawa'); ?></option>
                    <?php
                    $locations = get_terms(array('taxonomy' => 'store_location', 'hide_empty' => true));
                    foreach ($locations as $location) {
                        $selected = (isset($_GET['store_location']) && $_GET['store_location'] === $location->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($location->slug) . '" ' . $selected . '>' . esc_html($location->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <?php endif; ?>
            
            <?php if ($atts['show_rating_filter'] === 'true') : ?>
            <div class="filter-group">
                <select name="min_rating" class="filter-select">
                    <option value=""><?php _e('جميع التقييمات', 'mohtawa'); ?></option>
                    <option value="5" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '5'); ?>><?php _e('5 نجوم', 'mohtawa'); ?></option>
                    <option value="4" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '4'); ?>><?php _e('4 نجوم فأكثر', 'mohtawa'); ?></option>
                    <option value="3" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '3'); ?>><?php _e('3 نجوم فأكثر', 'mohtawa'); ?></option>
                    <option value="2" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '2'); ?>><?php _e('نجمتان فأكثر', 'mohtawa'); ?></option>
                </select>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </form>
    <?php
    
    return ob_get_clean();
}
add_shortcode('mohtawa_search_form', 'mohtawa_search_form_shortcode');

/**
 * اختصار عرض معلومات الاتصال
 * [mohtawa_contact_info show_phone="true" show_email="true" show_address="true" show_hours="true"]
 */
function mohtawa_contact_info_shortcode($atts) {
    $atts = shortcode_atts(array(
        'show_phone' => 'true',
        'show_email' => 'true',
        'show_address' => 'true',
        'show_hours' => 'true',
        'layout' => 'vertical' // vertical, horizontal
    ), $atts, 'mohtawa_contact_info');
    
    $phone = get_theme_mod('mohtawa_phone_number', '');
    $email = get_theme_mod('mohtawa_email_address', '');
    $address = get_theme_mod('mohtawa_address', '');
    $hours = get_theme_mod('mohtawa_working_hours', '');
    
    ob_start();
    ?>
    <div class="mohtawa-contact-info layout-<?php echo esc_attr($atts['layout']); ?>">
        <?php if ($atts['show_phone'] === 'true' && $phone) : ?>
        <div class="contact-item">
            <i class="fas fa-phone"></i>
            <div class="contact-content">
                <span class="contact-label"><?php _e('الهاتف:', 'mohtawa'); ?></span>
                <a href="tel:<?php echo esc_attr($phone); ?>" class="contact-value"><?php echo esc_html($phone); ?></a>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($atts['show_email'] === 'true' && $email) : ?>
        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <div class="contact-content">
                <span class="contact-label"><?php _e('البريد الإلكتروني:', 'mohtawa'); ?></span>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-value"><?php echo esc_html($email); ?></a>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($atts['show_address'] === 'true' && $address) : ?>
        <div class="contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <div class="contact-content">
                <span class="contact-label"><?php _e('العنوان:', 'mohtawa'); ?></span>
                <span class="contact-value"><?php echo esc_html($address); ?></span>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($atts['show_hours'] === 'true' && $hours) : ?>
        <div class="contact-item">
            <i class="fas fa-clock"></i>
            <div class="contact-content">
                <span class="contact-label"><?php _e('ساعات العمل:', 'mohtawa'); ?></span>
                <span class="contact-value"><?php echo nl2br(esc_html($hours)); ?></span>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php
    
    return ob_get_clean();
}
add_shortcode('mohtawa_contact_info', 'mohtawa_contact_info_shortcode');

/**
 * إضافة أنماط CSS للاختصارات
 */
function mohtawa_shortcodes_styles() {
    ?>
    <style>
    /* أنماط اختصار الخريطة */
    .mohtawa-map-container {
        margin: 20px 0;
    }
    
    .map-controls {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px 4px 0 0;
        border: 1px solid #dee2e6;
        border-bottom: none;
    }
    
    .map-search {
        display: flex;
        margin-bottom: 10px;
    }
    
    .map-search input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px 0 0 4px;
        border-right: none;
    }
    
    .map-search button {
        padding: 8px 16px;
        background: #007bff;
        color: white;
        border: 1px solid #007bff;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
    }
    
    .map-filters {
        display: flex;
        gap: 10px;
    }
    
    .map-filters select {
        padding: 6px 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background: white;
    }
    
    .mohtawa-map {
        border: 1px solid #dee2e6;
        border-radius: 0 0 4px 4px;
    }
    
    /* أنماط اختصار المتاجر */
    .mohtawa-stores-shortcode.layout-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }
    
    .mohtawa-stores-shortcode.layout-list .store-item {
        display: flex;
        margin-bottom: 20px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .mohtawa-stores-shortcode .store-item {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow: hidden;
        transition: box-shadow 0.2s;
    }
    
    .mohtawa-stores-shortcode .store-item:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .mohtawa-stores-shortcode .store-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .mohtawa-stores-shortcode.layout-list .store-image {
        width: 200px;
        height: auto;
        flex-shrink: 0;
    }
    
    .mohtawa-stores-shortcode .store-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .mohtawa-stores-shortcode .featured-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .mohtawa-stores-shortcode .store-content {
        padding: 15px;
    }
    
    .mohtawa-stores-shortcode .store-title {
        margin: 0 0 10px;
        font-size: 18px;
    }
    
    .mohtawa-stores-shortcode .store-title a {
        text-decoration: none;
        color: #333;
    }
    
    .mohtawa-stores-shortcode .store-rating {
        color: #ffc107;
        margin-bottom: 10px;
    }
    
    .mohtawa-stores-shortcode .store-address {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 10px;
    }
    
    .mohtawa-stores-shortcode .store-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }
    
    .mohtawa-stores-shortcode .store-category {
        background: #e9ecef;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    /* أنماط اختصار الفئات */
    .mohtawa-categories-shortcode.layout-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }
    
    .mohtawa-categories-shortcode .category-item {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        overflow: hidden;
        transition: transform 0.2s;
    }
    
    .mohtawa-categories-shortcode .category-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .mohtawa-categories-shortcode .category-link {
        display: block;
        padding: 20px;
        text-decoration: none;
        color: #333;
        text-align: center;
    }
    
    .mohtawa-categories-shortcode .category-icon {
        font-size: 32px;
        margin-bottom: 10px;
    }
    
    .mohtawa-categories-shortcode .category-name {
        margin: 0 0 5px;
        font-size: 16px;
    }
    
    .mohtawa-categories-shortcode .category-count {
        color: #6c757d;
        font-size: 14px;
    }
    
    /* أنماط نموذج البحث */
    .mohtawa-search-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 4px;
        margin: 20px 0;
    }
    
    .mohtawa-search-form.layout-horizontal {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .mohtawa-search-form .search-input-group {
        display: flex;
        flex: 1;
    }
    
    .mohtawa-search-form .search-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ced4da;
        border-radius: 4px 0 0 4px;
        border-right: none;
    }
    
    .mohtawa-search-form .search-button {
        padding: 10px 20px;
        background: #007bff;
        color: white;
        border: 1px solid #007bff;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .mohtawa-search-form.layout-vertical .search-filters {
        margin-top: 15px;
    }
    
    .mohtawa-search-form.layout-horizontal .search-filters {
        display: flex;
        gap: 10px;
    }
    
    .mohtawa-search-form .filter-select {
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background: white;
    }
    
    /* أنماط معلومات الاتصال */
    .mohtawa-contact-info {
        margin: 20px 0;
    }
    
    .mohtawa-contact-info.layout-horizontal {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .mohtawa-contact-info .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .mohtawa-contact-info.layout-horizontal .contact-item {
        margin-bottom: 0;
    }
    
    .mohtawa-contact-info .contact-item i {
        margin-right: 10px;
        margin-top: 2px;
        color: #007bff;
        width: 16px;
    }
    
    .mohtawa-contact-info .contact-label {
        font-weight: 600;
        margin-right: 5px;
    }
    
    .mohtawa-contact-info .contact-value a {
        text-decoration: none;
        color: #333;
    }
    
    .mohtawa-contact-info .contact-value a:hover {
        color: #007bff;
    }
    
    /* تحسينات للأجهزة المحمولة */
    @media (max-width: 768px) {
        .mohtawa-search-form.layout-horizontal {
            flex-direction: column;
            align-items: stretch;
        }
        
        .mohtawa-search-form.layout-horizontal .search-filters {
            flex-direction: column;
        }
        
        .mohtawa-contact-info.layout-horizontal {
            flex-direction: column;
        }
        
        .mohtawa-stores-shortcode.layout-list .store-item {
            flex-direction: column;
        }
        
        .mohtawa-stores-shortcode.layout-list .store-image {
            width: 100%;
            height: 200px;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'mohtawa_shortcodes_styles');

