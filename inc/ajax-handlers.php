<?php
/**
 * معالجات AJAX لقالب محتوى
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// منع الوصول المباشر
if (!defined('ABSPATH')) {
    exit;
}

/**
 * تحميل المتاجر مع الفلاتر والترتيب
 */
function mohtawa_get_stores() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    $page = intval($_POST['page']) ?: 1;
    $sort = sanitize_text_field($_POST['sort']) ?: 'distance';
    $filters = $_POST['filters'] ?: array();
    $user_location = $_POST['user_location'] ?: null;
    $per_page = 10;

    // إعداد استعلام المتاجر
    $args = array(
        'post_type' => 'store',
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'meta_query' => array(),
        'tax_query' => array()
    );

    // تطبيق الفلاتر
    if (!empty($filters['search'])) {
        $args['s'] = sanitize_text_field($filters['search']);
    }

    if (!empty($filters['category'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'store_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($filters['category'])
        );
    }

    if (!empty($filters['location'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'store_location',
            'field' => 'slug',
            'terms' => sanitize_text_field($filters['location'])
        );
    }

    if (!empty($filters['rating'])) {
        $rating = intval($filters['rating']);
        $args['meta_query'][] = array(
            'key' => 'store_rating',
            'value' => $rating,
            'compare' => '>='
        );
    }

    if (!empty($filters['status'])) {
        $is_open = $filters['status'] === 'open' ? '1' : '0';
        $args['meta_query'][] = array(
            'key' => 'store_is_open',
            'value' => $is_open,
            'compare' => '='
        );
    }

    if (!empty($filters['features'])) {
        foreach ($filters['features'] as $feature) {
            $feature = sanitize_text_field($feature);
            $args['meta_query'][] = array(
                'key' => 'store_' . $feature,
                'value' => '1',
                'compare' => '='
            );
        }
    }

    // تطبيق الترتيب
    switch ($sort) {
        case 'rating':
            $args['meta_key'] = 'store_rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'name':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            break;
        case 'newest':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
        case 'distance':
        default:
            if ($user_location && is_array($user_location) && count($user_location) === 2) {
                $args['meta_key'] = 'store_latitude';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'ASC';
            } else {
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
            }
            break;
    }

    // تنفيذ الاستعلام
    $query = new WP_Query($args);
    $stores = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $store_id = get_the_ID();
            
            // جمع بيانات المتجر
            $store_data = array(
                'id' => $store_id,
                'name' => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'permalink' => get_permalink(),
                'latitude' => get_post_meta($store_id, 'store_latitude', true),
                'longitude' => get_post_meta($store_id, 'store_longitude', true),
                'address' => get_post_meta($store_id, 'store_address', true),
                'phone' => get_post_meta($store_id, 'store_phone', true),
                'website' => get_post_meta($store_id, 'store_website', true),
                'rating' => floatval(get_post_meta($store_id, 'store_rating', true)),
                'is_open' => get_post_meta($store_id, 'store_is_open', true) === '1',
                'featured_image' => get_the_post_thumbnail_url($store_id, 'store-thumbnail'),
                'distance' => null
            );

            // حساب المسافة إذا كان موقع المستخدم متاحاً
            if ($user_location && is_array($user_location) && count($user_location) === 2 && 
                $store_data['latitude'] && $store_data['longitude']) {
                $store_data['distance'] = calculate_distance(
                    $user_location[0], $user_location[1],
                    $store_data['latitude'], $store_data['longitude']
                );
            }

            // الحصول على فئة المتجر
            $categories = get_the_terms($store_id, 'store_category');
            if ($categories && !is_wp_error($categories)) {
                $category = $categories[0];
                $store_data['category'] = $category->name;
                $store_data['category_color'] = get_term_meta($category->term_id, 'category_color', true);
                $store_data['category_icon'] = get_term_meta($category->term_id, 'category_icon', true);
            }

            // تطبيق فلتر المسافة
            if (!empty($filters['distance']) && $store_data['distance'] !== null) {
                $max_distance = floatval($filters['distance']);
                if ($store_data['distance'] > $max_distance) {
                    continue;
                }
            }

            $stores[] = $store_data;
        }
        wp_reset_postdata();
    }

    // ترتيب حسب المسافة إذا كان مطلوباً
    if ($sort === 'distance' && $user_location) {
        usort($stores, function($a, $b) {
            if ($a['distance'] === null && $b['distance'] === null) return 0;
            if ($a['distance'] === null) return 1;
            if ($b['distance'] === null) return -1;
            return $a['distance'] <=> $b['distance'];
        });
    }

    // حساب إجمالي النتائج
    $total_stores = $query->found_posts;
    $has_more = $page * $per_page < $total_stores;

    wp_send_json_success(array(
        'stores' => $stores,
        'total' => $total_stores,
        'page' => $page,
        'has_more' => $has_more
    ));
}
add_action('wp_ajax_get_stores', 'mohtawa_get_stores');
add_action('wp_ajax_nopriv_get_stores', 'mohtawa_get_stores');

/**
 * تحميل بيانات المتاجر للخريطة
 */
function mohtawa_get_stores_for_map() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    $args = array(
        'post_type' => 'store',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'store_latitude',
                'value' => '',
                'compare' => '!='
            ),
            array(
                'key' => 'store_longitude',
                'value' => '',
                'compare' => '!='
            )
        )
    );

    $query = new WP_Query($args);
    $stores = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $store_id = get_the_ID();
            
            $store_data = array(
                'id' => $store_id,
                'name' => get_the_title(),
                'latitude' => floatval(get_post_meta($store_id, 'store_latitude', true)),
                'longitude' => floatval(get_post_meta($store_id, 'store_longitude', true)),
                'address' => get_post_meta($store_id, 'store_address', true),
                'phone' => get_post_meta($store_id, 'store_phone', true),
                'rating' => floatval(get_post_meta($store_id, 'store_rating', true)),
                'is_open' => get_post_meta($store_id, 'store_is_open', true) === '1'
            );

            // الحصول على فئة المتجر
            $categories = get_the_terms($store_id, 'store_category');
            if ($categories && !is_wp_error($categories)) {
                $category = $categories[0];
                $store_data['category'] = $category->name;
                $store_data['category_color'] = get_term_meta($category->term_id, 'category_color', true) ?: '#3498db';
                $store_data['category_icon'] = get_term_meta($category->term_id, 'category_icon', true) ?: 'store';
            }

            $stores[] = $store_data;
        }
        wp_reset_postdata();
    }

    wp_send_json_success($stores);
}
add_action('wp_ajax_get_stores_for_map', 'mohtawa_get_stores_for_map');
add_action('wp_ajax_nopriv_get_stores_for_map', 'mohtawa_get_stores_for_map');

/**
 * الحصول على اقتراحات البحث
 */
function mohtawa_get_search_suggestions() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    $query = sanitize_text_field($_POST['query']);
    $suggestions = array();

    if (strlen($query) >= 2) {
        // البحث في المتاجر
        $stores = get_posts(array(
            'post_type' => 'store',
            'post_status' => 'publish',
            'posts_per_page' => 5,
            's' => $query
        ));

        foreach ($stores as $store) {
            $address = get_post_meta($store->ID, 'store_address', true);
            $suggestions[] = array(
                'type' => 'store',
                'title' => $store->post_title,
                'subtitle' => $address ? $address : '',
                'url' => get_permalink($store->ID)
            );
        }

        // البحث في فئات المتاجر
        $categories = get_terms(array(
            'taxonomy' => 'store_category',
            'hide_empty' => true,
            'number' => 3,
            'search' => $query
        ));

        foreach ($categories as $category) {
            $suggestions[] = array(
                'type' => 'category',
                'title' => $category->name,
                'subtitle' => sprintf('%d متجر', $category->count),
                'url' => get_term_link($category)
            );
        }

        // البحث في المواقع
        $locations = get_terms(array(
            'taxonomy' => 'store_location',
            'hide_empty' => true,
            'number' => 3,
            'search' => $query
        ));

        foreach ($locations as $location) {
            $suggestions[] = array(
                'type' => 'location',
                'title' => $location->name,
                'subtitle' => sprintf('%d متجر', $location->count),
                'url' => get_term_link($location)
            );
        }
    }

    wp_send_json_success($suggestions);
}
add_action('wp_ajax_get_search_suggestions', 'mohtawa_get_search_suggestions');
add_action('wp_ajax_nopriv_get_search_suggestions', 'mohtawa_get_search_suggestions');

/**
 * الحصول على تفاصيل المتجر
 */
function mohtawa_get_store_details() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    $store_id = intval($_POST['store_id']);
    
    if (!$store_id || get_post_type($store_id) !== 'store') {
        wp_send_json_error('متجر غير موجود');
    }

    $store = get_post($store_id);
    
    // جمع بيانات المتجر
    $store_data = array(
        'id' => $store_id,
        'name' => $store->post_title,
        'description' => $store->post_content,
        'excerpt' => $store->post_excerpt,
        'address' => get_post_meta($store_id, 'store_address', true),
        'phone' => get_post_meta($store_id, 'store_phone', true),
        'email' => get_post_meta($store_id, 'store_email', true),
        'website' => get_post_meta($store_id, 'store_website', true),
        'rating' => floatval(get_post_meta($store_id, 'store_rating', true)),
        'is_open' => get_post_meta($store_id, 'store_is_open', true) === '1',
        'opening_hours' => get_post_meta($store_id, 'store_opening_hours', true),
        'delivery' => get_post_meta($store_id, 'store_delivery', true) === '1',
        'parking' => get_post_meta($store_id, 'store_parking', true) === '1',
        'wifi' => get_post_meta($store_id, 'store_wifi', true) === '1',
        'featured_image' => get_the_post_thumbnail_url($store_id, 'store-large'),
        'gallery' => array()
    );

    // الحصول على معرض الصور
    $gallery_ids = get_post_meta($store_id, 'store_gallery', true);
    if ($gallery_ids) {
        $gallery_ids = explode(',', $gallery_ids);
        foreach ($gallery_ids as $image_id) {
            $image_url = wp_get_attachment_image_url($image_id, 'store-medium');
            if ($image_url) {
                $store_data['gallery'][] = $image_url;
            }
        }
    }

    // الحصول على الفئات
    $categories = get_the_terms($store_id, 'store_category');
    $store_data['categories'] = array();
    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $store_data['categories'][] = array(
                'name' => $category->name,
                'color' => get_term_meta($category->term_id, 'category_color', true),
                'icon' => get_term_meta($category->term_id, 'category_icon', true)
            );
        }
    }

    // الحصول على المواقع
    $locations = get_the_terms($store_id, 'store_location');
    $store_data['locations'] = array();
    if ($locations && !is_wp_error($locations)) {
        foreach ($locations as $location) {
            $store_data['locations'][] = $location->name;
        }
    }

    // الحصول على التقييمات
    $comments = get_comments(array(
        'post_id' => $store_id,
        'status' => 'approve',
        'number' => 5,
        'orderby' => 'comment_date',
        'order' => 'DESC'
    ));

    $store_data['reviews'] = array();
    foreach ($comments as $comment) {
        $rating = get_comment_meta($comment->comment_ID, 'rating', true);
        $store_data['reviews'][] = array(
            'author' => $comment->comment_author,
            'date' => get_comment_date('j F Y', $comment->comment_ID),
            'content' => $comment->comment_content,
            'rating' => $rating ? intval($rating) : null
        );
    }

    // إنشاء HTML للعرض
    ob_start();
    ?>
    <div class="store-details">
        <?php if ($store_data['featured_image']) : ?>
            <div class="store-image mb-3">
                <img src="<?php echo esc_url($store_data['featured_image']); ?>" 
                     alt="<?php echo esc_attr($store_data['name']); ?>" 
                     class="img-fluid rounded">
            </div>
        <?php endif; ?>

        <div class="store-info">
            <h4 class="store-name mb-2"><?php echo esc_html($store_data['name']); ?></h4>
            
            <?php if ($store_data['categories']) : ?>
                <div class="store-categories mb-3">
                    <?php foreach ($store_data['categories'] as $category) : ?>
                        <span class="badge me-1" style="background-color: <?php echo esc_attr($category['color'] ?: '#3498db'); ?>">
                            <i class="fas fa-<?php echo esc_attr($category['icon'] ?: 'store'); ?> me-1"></i>
                            <?php echo esc_html($category['name']); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($store_data['rating']) : ?>
                <div class="store-rating mb-3">
                    <div class="stars text-warning d-inline-block">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $store_data['rating'] ? '★' : '☆';
                        }
                        ?>
                    </div>
                    <span class="ms-2"><?php echo esc_html($store_data['rating']); ?>/5</span>
                </div>
            <?php endif; ?>

            <?php if ($store_data['description']) : ?>
                <div class="store-description mb-3">
                    <?php echo wp_kses_post($store_data['description']); ?>
                </div>
            <?php endif; ?>

            <div class="store-contact-info">
                <?php if ($store_data['address']) : ?>
                    <div class="contact-item mb-2">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        <span><?php echo esc_html($store_data['address']); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($store_data['phone']) : ?>
                    <div class="contact-item mb-2">
                        <i class="fas fa-phone text-primary me-2"></i>
                        <a href="tel:<?php echo esc_attr($store_data['phone']); ?>" class="text-decoration-none">
                            <?php echo esc_html($store_data['phone']); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($store_data['email']) : ?>
                    <div class="contact-item mb-2">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        <a href="mailto:<?php echo esc_attr($store_data['email']); ?>" class="text-decoration-none">
                            <?php echo esc_html($store_data['email']); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($store_data['website']) : ?>
                    <div class="contact-item mb-2">
                        <i class="fas fa-globe text-primary me-2"></i>
                        <a href="<?php echo esc_url($store_data['website']); ?>" target="_blank" class="text-decoration-none">
                            زيارة الموقع
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($store_data['opening_hours']) : ?>
                <div class="opening-hours mt-3">
                    <h6>ساعات العمل:</h6>
                    <div class="hours-info">
                        <?php echo wp_kses_post(nl2br($store_data['opening_hours'])); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="store-features mt-3">
                <h6>الخدمات المتاحة:</h6>
                <div class="features-list">
                    <?php if ($store_data['delivery']) : ?>
                        <span class="badge bg-success me-1 mb-1">
                            <i class="fas fa-truck me-1"></i>توصيل
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($store_data['parking']) : ?>
                        <span class="badge bg-info me-1 mb-1">
                            <i class="fas fa-parking me-1"></i>موقف سيارات
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($store_data['wifi']) : ?>
                        <span class="badge bg-warning me-1 mb-1">
                            <i class="fas fa-wifi me-1"></i>واي فاي
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($store_data['gallery']) : ?>
                <div class="store-gallery mt-3">
                    <h6>معرض الصور:</h6>
                    <div class="row">
                        <?php foreach (array_slice($store_data['gallery'], 0, 4) as $image) : ?>
                            <div class="col-3">
                                <img src="<?php echo esc_url($image); ?>" 
                                     alt="صورة من المتجر" 
                                     class="img-fluid rounded mb-2">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($store_data['reviews']) : ?>
                <div class="store-reviews mt-3">
                    <h6>آراء العملاء:</h6>
                    <?php foreach (array_slice($store_data['reviews'], 0, 3) as $review) : ?>
                        <div class="review-item border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <strong><?php echo esc_html($review['author']); ?></strong>
                                <small class="text-muted"><?php echo esc_html($review['date']); ?></small>
                            </div>
                            <?php if ($review['rating']) : ?>
                                <div class="review-rating text-warning small">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $review['rating'] ? '★' : '☆';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            <p class="review-content small mb-0"><?php echo esc_html($review['content']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="store-actions mt-4">
                <div class="d-flex gap-2">
                    <a href="<?php echo esc_url(get_permalink($store_id)); ?>" class="btn btn-primary flex-fill">
                        <i class="fas fa-eye me-1"></i>عرض الصفحة الكاملة
                    </a>
                    <?php if ($store_data['phone']) : ?>
                        <a href="tel:<?php echo esc_attr($store_data['phone']); ?>" class="btn btn-success">
                            <i class="fas fa-phone"></i>
                        </a>
                    <?php endif; ?>
                    <button type="button" class="btn btn-info" onclick="showStoreOnMap(<?php echo $store_id; ?>)" data-bs-dismiss="modal">
                        <i class="fas fa-map-marked-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    wp_send_json_success($html);
}
add_action('wp_ajax_get_store_details', 'mohtawa_get_store_details');
add_action('wp_ajax_nopriv_get_store_details', 'mohtawa_get_store_details');

/**
 * إضافة تقييم للمتجر
 */
function mohtawa_add_store_review() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    $store_id = intval($_POST['store_id']);
    $rating = intval($_POST['rating']);
    $review_text = sanitize_textarea_field($_POST['review_text']);
    $author_name = sanitize_text_field($_POST['author_name']);
    $author_email = sanitize_email($_POST['author_email']);

    // التحقق من صحة البيانات
    if (!$store_id || get_post_type($store_id) !== 'store') {
        wp_send_json_error('متجر غير موجود');
    }

    if ($rating < 1 || $rating > 5) {
        wp_send_json_error('تقييم غير صحيح');
    }

    if (empty($review_text) || empty($author_name) || empty($author_email)) {
        wp_send_json_error('جميع الحقول مطلوبة');
    }

    // إضافة التعليق
    $comment_data = array(
        'comment_post_ID' => $store_id,
        'comment_author' => $author_name,
        'comment_author_email' => $author_email,
        'comment_content' => $review_text,
        'comment_type' => 'review',
        'comment_approved' => 0 // في انتظار الموافقة
    );

    $comment_id = wp_insert_comment($comment_data);

    if ($comment_id) {
        // إضافة التقييم كـ meta
        add_comment_meta($comment_id, 'rating', $rating);

        // تحديث متوسط التقييم للمتجر
        update_store_rating($store_id);

        wp_send_json_success('تم إرسال تقييمك بنجاح وسيظهر بعد المراجعة');
    } else {
        wp_send_json_error('فشل في إرسال التقييم');
    }
}
add_action('wp_ajax_add_store_review', 'mohtawa_add_store_review');
add_action('wp_ajax_nopriv_add_store_review', 'mohtawa_add_store_review');

/**
 * تحديث متوسط التقييم للمتجر
 */
function update_store_rating($store_id) {
    $comments = get_comments(array(
        'post_id' => $store_id,
        'status' => 'approve',
        'type' => 'review',
        'meta_query' => array(
            array(
                'key' => 'rating',
                'value' => '',
                'compare' => '!='
            )
        )
    ));

    if ($comments) {
        $total_rating = 0;
        $count = 0;

        foreach ($comments as $comment) {
            $rating = get_comment_meta($comment->comment_ID, 'rating', true);
            if ($rating) {
                $total_rating += intval($rating);
                $count++;
            }
        }

        if ($count > 0) {
            $average_rating = round($total_rating / $count, 1);
            update_post_meta($store_id, 'store_rating', $average_rating);
            update_post_meta($store_id, 'store_reviews_count', $count);
        }
    }
}

/**
 * حساب المسافة بين نقطتين
 */
function calculate_distance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // نصف قطر الأرض بالكيلومتر

    $lat1_rad = deg2rad($lat1);
    $lon1_rad = deg2rad($lon1);
    $lat2_rad = deg2rad($lat2);
    $lon2_rad = deg2rad($lon2);

    $delta_lat = $lat2_rad - $lat1_rad;
    $delta_lon = $lon2_rad - $lon1_rad;

    $a = sin($delta_lat / 2) * sin($delta_lat / 2) +
         cos($lat1_rad) * cos($lat2_rad) *
         sin($delta_lon / 2) * sin($delta_lon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earth_radius * $c;

    return round($distance, 2);
}

/**
 * البحث المتقدم في المتاجر
 */
function mohtawa_advanced_search() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    $search_params = $_POST['search_params'];
    $results = array();

    // البحث في المتاجر
    if (!empty($search_params['query'])) {
        $stores_args = array(
            'post_type' => 'store',
            'post_status' => 'publish',
            'posts_per_page' => 20,
            's' => sanitize_text_field($search_params['query'])
        );

        $stores_query = new WP_Query($stores_args);
        
        if ($stores_query->have_posts()) {
            while ($stores_query->have_posts()) {
                $stores_query->the_post();
                $results[] = array(
                    'type' => 'store',
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'url' => get_permalink(),
                    'excerpt' => get_the_excerpt(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
                );
            }
            wp_reset_postdata();
        }
    }

    wp_send_json_success($results);
}
add_action('wp_ajax_advanced_search', 'mohtawa_advanced_search');
add_action('wp_ajax_nopriv_advanced_search', 'mohtawa_advanced_search');

/**
 * الحصول على إحصائيات المتاجر
 */
function mohtawa_get_stores_stats() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    $stats = array(
        'total_stores' => wp_count_posts('store')->publish,
        'total_categories' => wp_count_terms('store_category'),
        'total_locations' => wp_count_terms('store_location'),
        'total_reviews' => get_comments(array('post_type' => 'store', 'count' => true)),
        'featured_stores' => get_posts(array(
            'post_type' => 'store',
            'meta_key' => 'store_featured',
            'meta_value' => '1',
            'posts_per_page' => -1,
            'fields' => 'ids'
        )),
        'open_stores' => get_posts(array(
            'post_type' => 'store',
            'meta_key' => 'store_is_open',
            'meta_value' => '1',
            'posts_per_page' => -1,
            'fields' => 'ids'
        ))
    );

    $stats['featured_stores_count'] = count($stats['featured_stores']);
    $stats['open_stores_count'] = count($stats['open_stores']);

    wp_send_json_success($stats);
}
add_action('wp_ajax_get_stores_stats', 'mohtawa_get_stores_stats');
add_action('wp_ajax_nopriv_get_stores_stats', 'mohtawa_get_stores_stats');

/**
 * تسجيل متجر جديد من قبل المستخدمين
 */
function mohtawa_submit_store() {
    // التحقق من الأمان
    if (!wp_verify_nonce($_POST['nonce'], 'mohtawa_nonce')) {
        wp_die('خطأ في التحقق من الأمان');
    }

    // التحقق من البيانات المطلوبة
    $required_fields = array('store_name', 'store_address', 'store_phone', 'store_category');
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error('جميع الحقول المطلوبة يجب ملؤها');
        }
    }

    // إنشاء المتجر كمسودة
    $store_data = array(
        'post_title' => sanitize_text_field($_POST['store_name']),
        'post_content' => sanitize_textarea_field($_POST['store_description']),
        'post_type' => 'store',
        'post_status' => 'pending', // في انتظار المراجعة
        'post_author' => get_current_user_id() ?: 0
    );

    $store_id = wp_insert_post($store_data);

    if ($store_id) {
        // إضافة البيانات الإضافية
        update_post_meta($store_id, 'store_address', sanitize_text_field($_POST['store_address']));
        update_post_meta($store_id, 'store_phone', sanitize_text_field($_POST['store_phone']));
        update_post_meta($store_id, 'store_email', sanitize_email($_POST['store_email']));
        update_post_meta($store_id, 'store_website', esc_url_raw($_POST['store_website']));
        update_post_meta($store_id, 'store_latitude', floatval($_POST['store_latitude']));
        update_post_meta($store_id, 'store_longitude', floatval($_POST['store_longitude']));

        // إضافة الفئة
        if (!empty($_POST['store_category'])) {
            wp_set_object_terms($store_id, intval($_POST['store_category']), 'store_category');
        }

        // إضافة الموقع
        if (!empty($_POST['store_location'])) {
            wp_set_object_terms($store_id, intval($_POST['store_location']), 'store_location');
        }

        wp_send_json_success('تم إرسال طلب إضافة المتجر بنجاح وسيتم مراجعته قريباً');
    } else {
        wp_send_json_error('فشل في إرسال طلب إضافة المتجر');
    }
}
add_action('wp_ajax_submit_store', 'mohtawa_submit_store');
add_action('wp_ajax_nopriv_submit_store', 'mohtawa_submit_store');

