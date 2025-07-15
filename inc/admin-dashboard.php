<?php
/**
 * لوحة التحكم المخصصة لقالب محتوى
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// منع الوصول المباشر
if (!defined('ABSPATH')) {
    exit;
}

/**
 * إضافة صفحة لوحة التحكم المخصصة
 */
function mohtawa_add_admin_menu() {
    add_menu_page(
        __('قالب محتوى', 'mohtawa'),
        __('قالب محتوى', 'mohtawa'),
        'manage_options',
        'mohtawa-dashboard',
        'mohtawa_admin_dashboard_page',
        'dashicons-store',
        3
    );
    
    add_submenu_page(
        'mohtawa-dashboard',
        __('لوحة التحكم', 'mohtawa'),
        __('لوحة التحكم', 'mohtawa'),
        'manage_options',
        'mohtawa-dashboard',
        'mohtawa_admin_dashboard_page'
    );
    
    add_submenu_page(
        'mohtawa-dashboard',
        __('إعدادات الخريطة', 'mohtawa'),
        __('إعدادات الخريطة', 'mohtawa'),
        'manage_options',
        'mohtawa-map-settings',
        'mohtawa_map_settings_page'
    );
    
    add_submenu_page(
        'mohtawa-dashboard',
        __('إدارة الفئات', 'mohtawa'),
        __('إدارة الفئات', 'mohtawa'),
        'manage_options',
        'edit-tags.php?taxonomy=store_category&post_type=store'
    );
    
    add_submenu_page(
        'mohtawa-dashboard',
        __('إدارة المواقع', 'mohtawa'),
        __('إدارة المواقع', 'mohtawa'),
        'manage_options',
        'edit-tags.php?taxonomy=store_location&post_type=store'
    );
    
    add_submenu_page(
        'mohtawa-dashboard',
        __('إعدادات متقدمة', 'mohtawa'),
        __('إعدادات متقدمة', 'mohtawa'),
        'manage_options',
        'mohtawa-advanced-settings',
        'mohtawa_advanced_settings_page'
    );
    
    add_submenu_page(
        'mohtawa-dashboard',
        __('التوثيق والمساعدة', 'mohtawa'),
        __('التوثيق والمساعدة', 'mohtawa'),
        'manage_options',
        'mohtawa-help',
        'mohtawa_help_page'
    );
}
add_action('admin_menu', 'mohtawa_add_admin_menu');

/**
 * صفحة لوحة التحكم الرئيسية
 */
function mohtawa_admin_dashboard_page() {
    // جمع الإحصائيات
    $total_stores = wp_count_posts('store')->publish;
    $total_categories = wp_count_terms('store_category');
    $total_locations = wp_count_terms('store_location');
    $total_reviews = get_comments(array('post_type' => 'store', 'count' => true));
    
    // المتاجر المميزة
    $featured_stores = get_posts(array(
        'post_type' => 'store',
        'meta_key' => 'store_featured',
        'meta_value' => '1',
        'posts_per_page' => -1,
        'fields' => 'ids'
    ));
    
    // المتاجر المفتوحة
    $open_stores = get_posts(array(
        'post_type' => 'store',
        'meta_key' => 'store_is_open',
        'meta_value' => '1',
        'posts_per_page' => -1,
        'fields' => 'ids'
    ));
    
    // آخر المتاجر المضافة
    $recent_stores = get_posts(array(
        'post_type' => 'store',
        'posts_per_page' => 5,
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    // آخر التقييمات
    $recent_reviews = get_comments(array(
        'post_type' => 'store',
        'number' => 5,
        'status' => 'approve',
        'orderby' => 'comment_date',
        'order' => 'DESC'
    ));
    
    ?>
    <div class="wrap">
        <h1><?php _e('لوحة تحكم قالب محتوى', 'mohtawa'); ?></h1>
        
        <!-- بطاقات الإحصائيات -->
        <div class="mohtawa-stats-grid">
            <div class="mohtawa-stat-card">
                <div class="mohtawa-stat-icon">
                    <span class="dashicons dashicons-store"></span>
                </div>
                <div class="mohtawa-stat-content">
                    <h3><?php echo number_format($total_stores); ?></h3>
                    <p><?php _e('إجمالي المتاجر', 'mohtawa'); ?></p>
                </div>
            </div>
            
            <div class="mohtawa-stat-card">
                <div class="mohtawa-stat-icon">
                    <span class="dashicons dashicons-category"></span>
                </div>
                <div class="mohtawa-stat-content">
                    <h3><?php echo number_format($total_categories); ?></h3>
                    <p><?php _e('الفئات', 'mohtawa'); ?></p>
                </div>
            </div>
            
            <div class="mohtawa-stat-card">
                <div class="mohtawa-stat-icon">
                    <span class="dashicons dashicons-location"></span>
                </div>
                <div class="mohtawa-stat-content">
                    <h3><?php echo number_format($total_locations); ?></h3>
                    <p><?php _e('المواقع', 'mohtawa'); ?></p>
                </div>
            </div>
            
            <div class="mohtawa-stat-card">
                <div class="mohtawa-stat-icon">
                    <span class="dashicons dashicons-star-filled"></span>
                </div>
                <div class="mohtawa-stat-content">
                    <h3><?php echo number_format($total_reviews); ?></h3>
                    <p><?php _e('التقييمات', 'mohtawa'); ?></p>
                </div>
            </div>
            
            <div class="mohtawa-stat-card">
                <div class="mohtawa-stat-icon">
                    <span class="dashicons dashicons-awards"></span>
                </div>
                <div class="mohtawa-stat-content">
                    <h3><?php echo number_format(count($featured_stores)); ?></h3>
                    <p><?php _e('المتاجر المميزة', 'mohtawa'); ?></p>
                </div>
            </div>
            
            <div class="mohtawa-stat-card">
                <div class="mohtawa-stat-icon">
                    <span class="dashicons dashicons-yes-alt"></span>
                </div>
                <div class="mohtawa-stat-content">
                    <h3><?php echo number_format(count($open_stores)); ?></h3>
                    <p><?php _e('المتاجر المفتوحة', 'mohtawa'); ?></p>
                </div>
            </div>
        </div>
        
        <div class="mohtawa-dashboard-content">
            <div class="mohtawa-dashboard-left">
                
                <!-- آخر المتاجر المضافة -->
                <div class="mohtawa-dashboard-widget">
                    <h2><?php _e('آخر المتاجر المضافة', 'mohtawa'); ?></h2>
                    <div class="mohtawa-recent-stores">
                        <?php if ($recent_stores) : ?>
                            <?php foreach ($recent_stores as $store) : 
                                $store_rating = get_post_meta($store->ID, 'store_rating', true);
                                $store_address = get_post_meta($store->ID, 'store_address', true);
                                $store_featured = get_post_meta($store->ID, 'store_featured', true);
                            ?>
                                <div class="mohtawa-recent-store-item">
                                    <div class="store-info">
                                        <h4>
                                            <a href="<?php echo get_edit_post_link($store->ID); ?>">
                                                <?php echo esc_html($store->post_title); ?>
                                            </a>
                                            <?php if ($store_featured === '1') : ?>
                                                <span class="featured-badge"><?php _e('مميز', 'mohtawa'); ?></span>
                                            <?php endif; ?>
                                        </h4>
                                        <?php if ($store_address) : ?>
                                            <p class="store-address"><?php echo esc_html($store_address); ?></p>
                                        <?php endif; ?>
                                        <?php if ($store_rating) : ?>
                                            <div class="store-rating">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo $i <= $store_rating ? '★' : '☆';
                                                }
                                                ?>
                                                <span>(<?php echo esc_html($store_rating); ?>)</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="store-actions">
                                        <a href="<?php echo get_edit_post_link($store->ID); ?>" class="button button-small">
                                            <?php _e('تحرير', 'mohtawa'); ?>
                                        </a>
                                        <a href="<?php echo get_permalink($store->ID); ?>" class="button button-small" target="_blank">
                                            <?php _e('عرض', 'mohtawa'); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p><?php _e('لا توجد متاجر بعد.', 'mohtawa'); ?></p>
                        <?php endif; ?>
                    </div>
                    <p class="mohtawa-widget-footer">
                        <a href="<?php echo admin_url('edit.php?post_type=store'); ?>" class="button">
                            <?php _e('عرض جميع المتاجر', 'mohtawa'); ?>
                        </a>
                        <a href="<?php echo admin_url('post-new.php?post_type=store'); ?>" class="button button-primary">
                            <?php _e('إضافة متجر جديد', 'mohtawa'); ?>
                        </a>
                    </p>
                </div>
                
                <!-- أدوات سريعة -->
                <div class="mohtawa-dashboard-widget">
                    <h2><?php _e('أدوات سريعة', 'mohtawa'); ?></h2>
                    <div class="mohtawa-quick-tools">
                        <a href="<?php echo admin_url('post-new.php?post_type=store'); ?>" class="mohtawa-quick-tool">
                            <span class="dashicons dashicons-plus-alt"></span>
                            <span><?php _e('إضافة متجر', 'mohtawa'); ?></span>
                        </a>
                        
                        <a href="<?php echo admin_url('edit-tags.php?taxonomy=store_category&post_type=store'); ?>" class="mohtawa-quick-tool">
                            <span class="dashicons dashicons-category"></span>
                            <span><?php _e('إدارة الفئات', 'mohtawa'); ?></span>
                        </a>
                        
                        <a href="<?php echo admin_url('edit-tags.php?taxonomy=store_location&post_type=store'); ?>" class="mohtawa-quick-tool">
                            <span class="dashicons dashicons-location"></span>
                            <span><?php _e('إدارة المواقع', 'mohtawa'); ?></span>
                        </a>
                        
                        <a href="<?php echo admin_url('customize.php'); ?>" class="mohtawa-quick-tool">
                            <span class="dashicons dashicons-admin-customizer"></span>
                            <span><?php _e('تخصيص المظهر', 'mohtawa'); ?></span>
                        </a>
                        
                        <a href="<?php echo admin_url('admin.php?page=mohtawa-map-settings'); ?>" class="mohtawa-quick-tool">
                            <span class="dashicons dashicons-location-alt"></span>
                            <span><?php _e('إعدادات الخريطة', 'mohtawa'); ?></span>
                        </a>
                        
                        <a href="<?php echo home_url(); ?>" class="mohtawa-quick-tool" target="_blank">
                            <span class="dashicons dashicons-external"></span>
                            <span><?php _e('عرض الموقع', 'mohtawa'); ?></span>
                        </a>
                    </div>
                </div>
                
            </div>
            
            <div class="mohtawa-dashboard-right">
                
                <!-- آخر التقييمات -->
                <div class="mohtawa-dashboard-widget">
                    <h2><?php _e('آخر التقييمات', 'mohtawa'); ?></h2>
                    <div class="mohtawa-recent-reviews">
                        <?php if ($recent_reviews) : ?>
                            <?php foreach ($recent_reviews as $review) : 
                                $rating = get_comment_meta($review->comment_ID, 'rating', true);
                                $store_title = get_the_title($review->comment_post_ID);
                            ?>
                                <div class="mohtawa-recent-review-item">
                                    <div class="review-header">
                                        <strong><?php echo esc_html($review->comment_author); ?></strong>
                                        <?php if ($rating) : ?>
                                            <div class="review-rating">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo $i <= $rating ? '★' : '☆';
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="review-content"><?php echo esc_html(wp_trim_words($review->comment_content, 15)); ?></p>
                                    <p class="review-meta">
                                        <?php _e('على متجر:', 'mohtawa'); ?> 
                                        <a href="<?php echo get_edit_post_link($review->comment_post_ID); ?>">
                                            <?php echo esc_html($store_title); ?>
                                        </a>
                                        <span class="review-date"><?php echo human_time_diff(strtotime($review->comment_date), current_time('timestamp')); ?> <?php _e('مضت', 'mohtawa'); ?></span>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p><?php _e('لا توجد تقييمات بعد.', 'mohtawa'); ?></p>
                        <?php endif; ?>
                    </div>
                    <p class="mohtawa-widget-footer">
                        <a href="<?php echo admin_url('edit-comments.php?comment_type=review'); ?>" class="button">
                            <?php _e('عرض جميع التقييمات', 'mohtawa'); ?>
                        </a>
                    </p>
                </div>
                
                <!-- معلومات القالب -->
                <div class="mohtawa-dashboard-widget">
                    <h2><?php _e('معلومات القالب', 'mohtawa'); ?></h2>
                    <div class="mohtawa-theme-info">
                        <p><strong><?php _e('اسم القالب:', 'mohtawa'); ?></strong> محتوى - خريطة المتاجر</p>
                        <p><strong><?php _e('الإصدار:', 'mohtawa'); ?></strong> 1.0.0</p>
                        <p><strong><?php _e('المطور:', 'mohtawa'); ?></strong> Manus AI</p>
                        <p><strong><?php _e('آخر تحديث:', 'mohtawa'); ?></strong> <?php echo date('Y-m-d'); ?></p>
                        
                        <div class="mohtawa-theme-features">
                            <h4><?php _e('المميزات الرئيسية:', 'mohtawa'); ?></h4>
                            <ul>
                                <li><?php _e('خريطة تفاعلية متقدمة', 'mohtawa'); ?></li>
                                <li><?php _e('نظام إدارة المتاجر الشامل', 'mohtawa'); ?></li>
                                <li><?php _e('تصميم متجاوب ومتوافق مع الجوال', 'mohtawa'); ?></li>
                                <li><?php _e('نظام تقييمات ومراجعات', 'mohtawa'); ?></li>
                                <li><?php _e('تحسين محركات البحث (SEO)', 'mohtawa'); ?></li>
                                <li><?php _e('دعم كامل للغة العربية (RTL)', 'mohtawa'); ?></li>
                                <li><?php _e('لوحة تحكم مخصصة', 'mohtawa'); ?></li>
                                <li><?php _e('إعدادات تخصيص شاملة', 'mohtawa'); ?></li>
                            </ul>
                        </div>
                    </div>
                    <p class="mohtawa-widget-footer">
                        <a href="<?php echo admin_url('admin.php?page=mohtawa-help'); ?>" class="button">
                            <?php _e('التوثيق والمساعدة', 'mohtawa'); ?>
                        </a>
                    </p>
                </div>
                
            </div>
        </div>
    </div>
    
    <style>
    .mohtawa-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }
    
    .mohtawa-stat-card {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        display: flex;
        align-items: center;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .mohtawa-stat-icon {
        margin-right: 15px;
        font-size: 24px;
        color: #0073aa;
    }
    
    .mohtawa-stat-content h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #23282d;
    }
    
    .mohtawa-stat-content p {
        margin: 5px 0 0;
        color: #646970;
        font-size: 13px;
    }
    
    .mohtawa-dashboard-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }
    
    .mohtawa-dashboard-widget {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        margin-bottom: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .mohtawa-dashboard-widget h2 {
        margin: 0;
        padding: 15px 20px;
        border-bottom: 1px solid #ccd0d4;
        background: #f9f9f9;
        font-size: 16px;
    }
    
    .mohtawa-recent-stores,
    .mohtawa-recent-reviews {
        padding: 20px;
    }
    
    .mohtawa-recent-store-item,
    .mohtawa-recent-review-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f1;
    }
    
    .mohtawa-recent-store-item:last-child,
    .mohtawa-recent-review-item:last-child {
        border-bottom: none;
    }
    
    .store-info h4 {
        margin: 0 0 5px;
        font-size: 14px;
    }
    
    .store-info h4 a {
        text-decoration: none;
    }
    
    .featured-badge {
        background: #d63638;
        color: #fff;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 11px;
        margin-left: 5px;
    }
    
    .store-address {
        margin: 5px 0;
        color: #646970;
        font-size: 12px;
    }
    
    .store-rating {
        color: #ffb900;
        font-size: 12px;
    }
    
    .store-actions {
        display: flex;
        gap: 5px;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }
    
    .review-rating {
        color: #ffb900;
        font-size: 12px;
    }
    
    .review-content {
        margin: 5px 0;
        font-size: 13px;
        line-height: 1.4;
    }
    
    .review-meta {
        font-size: 12px;
        color: #646970;
        margin: 5px 0 0;
    }
    
    .review-date {
        margin-left: 10px;
    }
    
    .mohtawa-widget-footer {
        padding: 15px 20px;
        border-top: 1px solid #ccd0d4;
        background: #f9f9f9;
        margin: 0;
    }
    
    .mohtawa-quick-tools {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        padding: 20px;
    }
    
    .mohtawa-quick-tool {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #0073aa;
        transition: all 0.2s;
    }
    
    .mohtawa-quick-tool:hover {
        background: #f0f6fc;
        border-color: #0073aa;
        color: #005a87;
    }
    
    .mohtawa-quick-tool .dashicons {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .mohtawa-theme-info ul {
        margin: 10px 0;
        padding-left: 20px;
    }
    
    .mohtawa-theme-info li {
        margin: 5px 0;
        font-size: 13px;
    }
    
    @media (max-width: 768px) {
        .mohtawa-dashboard-content {
            grid-template-columns: 1fr;
        }
        
        .mohtawa-stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
        
        .mohtawa-quick-tools {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        }
    }
    </style>
    <?php
}

/**
 * صفحة إعدادات الخريطة
 */
function mohtawa_map_settings_page() {
    if (isset($_POST['submit'])) {
        // حفظ الإعدادات
        update_option('mohtawa_map_api_key', sanitize_text_field($_POST['map_api_key']));
        update_option('mohtawa_map_default_lat', sanitize_text_field($_POST['map_default_lat']));
        update_option('mohtawa_map_default_lng', sanitize_text_field($_POST['map_default_lng']));
        update_option('mohtawa_map_default_zoom', intval($_POST['map_default_zoom']));
        update_option('mohtawa_map_cluster_enabled', isset($_POST['map_cluster_enabled']) ? '1' : '0');
        update_option('mohtawa_map_user_location', isset($_POST['map_user_location']) ? '1' : '0');
        
        echo '<div class="notice notice-success"><p>' . __('تم حفظ الإعدادات بنجاح.', 'mohtawa') . '</p></div>';
    }
    
    $map_api_key = get_option('mohtawa_map_api_key', '');
    $map_default_lat = get_option('mohtawa_map_default_lat', '24.7136');
    $map_default_lng = get_option('mohtawa_map_default_lng', '46.6753');
    $map_default_zoom = get_option('mohtawa_map_default_zoom', '11');
    $map_cluster_enabled = get_option('mohtawa_map_cluster_enabled', '1');
    $map_user_location = get_option('mohtawa_map_user_location', '1');
    
    ?>
    <div class="wrap">
        <h1><?php _e('إعدادات الخريطة', 'mohtawa'); ?></h1>
        
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('مفتاح API للخريطة', 'mohtawa'); ?></th>
                    <td>
                        <input type="text" name="map_api_key" value="<?php echo esc_attr($map_api_key); ?>" class="regular-text" />
                        <p class="description"><?php _e('مفتاح API لخدمة الخرائط (اختياري - يستخدم OpenStreetMap افتراضياً)', 'mohtawa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('الموقع الافتراضي - خط العرض', 'mohtawa'); ?></th>
                    <td>
                        <input type="text" name="map_default_lat" value="<?php echo esc_attr($map_default_lat); ?>" class="regular-text" />
                        <p class="description"><?php _e('خط العرض للموقع الافتراضي للخريطة', 'mohtawa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('الموقع الافتراضي - خط الطول', 'mohtawa'); ?></th>
                    <td>
                        <input type="text" name="map_default_lng" value="<?php echo esc_attr($map_default_lng); ?>" class="regular-text" />
                        <p class="description"><?php _e('خط الطول للموقع الافتراضي للخريطة', 'mohtawa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('مستوى التكبير الافتراضي', 'mohtawa'); ?></th>
                    <td>
                        <input type="number" name="map_default_zoom" value="<?php echo esc_attr($map_default_zoom); ?>" min="1" max="18" />
                        <p class="description"><?php _e('مستوى التكبير الافتراضي للخريطة (1-18)', 'mohtawa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('تجميع العلامات', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="map_cluster_enabled" value="1" <?php checked($map_cluster_enabled, '1'); ?> />
                            <?php _e('تفعيل تجميع العلامات المتقاربة', 'mohtawa'); ?>
                        </label>
                        <p class="description"><?php _e('تجميع العلامات المتقاربة لتحسين أداء الخريطة', 'mohtawa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('تحديد موقع المستخدم', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="map_user_location" value="1" <?php checked($map_user_location, '1'); ?> />
                            <?php _e('طلب إذن تحديد موقع المستخدم تلقائياً', 'mohtawa'); ?>
                        </label>
                        <p class="description"><?php _e('طلب إذن المستخدم لتحديد موقعه وعرض المتاجر القريبة', 'mohtawa'); ?></p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button(__('حفظ الإعدادات', 'mohtawa')); ?>
        </form>
        
        <div class="mohtawa-map-preview">
            <h2><?php _e('معاينة الخريطة', 'mohtawa'); ?></h2>
            <div id="map-preview" style="height: 400px; border: 1px solid #ddd; border-radius: 4px;"></div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // إنشاء خريطة المعاينة
        const lat = parseFloat('<?php echo $map_default_lat; ?>') || 24.7136;
        const lng = parseFloat('<?php echo $map_default_lng; ?>') || 46.6753;
        const zoom = parseInt('<?php echo $map_default_zoom; ?>') || 11;
        
        const map = L.map('map-preview').setView([lat, lng], zoom);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup('<?php _e("الموقع الافتراضي", "mohtawa"); ?>').openPopup();
        
        // تحديث الخريطة عند تغيير الإعدادات
        document.querySelector('input[name="map_default_lat"]').addEventListener('change', updateMapPreview);
        document.querySelector('input[name="map_default_lng"]').addEventListener('change', updateMapPreview);
        document.querySelector('input[name="map_default_zoom"]').addEventListener('change', updateMapPreview);
        
        function updateMapPreview() {
            const newLat = parseFloat(document.querySelector('input[name="map_default_lat"]').value) || lat;
            const newLng = parseFloat(document.querySelector('input[name="map_default_lng"]').value) || lng;
            const newZoom = parseInt(document.querySelector('input[name="map_default_zoom"]').value) || zoom;
            
            map.setView([newLat, newLng], newZoom);
            marker.setLatLng([newLat, newLng]);
        }
    });
    </script>
    <?php
}

/**
 * صفحة الإعدادات المتقدمة
 */
function mohtawa_advanced_settings_page() {
    if (isset($_POST['submit'])) {
        // حفظ الإعدادات
        update_option('mohtawa_enable_reviews', isset($_POST['enable_reviews']) ? '1' : '0');
        update_option('mohtawa_reviews_moderation', isset($_POST['reviews_moderation']) ? '1' : '0');
        update_option('mohtawa_enable_store_submission', isset($_POST['enable_store_submission']) ? '1' : '0');
        update_option('mohtawa_store_submission_moderation', isset($_POST['store_submission_moderation']) ? '1' : '0');
        update_option('mohtawa_enable_favorites', isset($_POST['enable_favorites']) ? '1' : '0');
        update_option('mohtawa_enable_sharing', isset($_POST['enable_sharing']) ? '1' : '0');
        update_option('mohtawa_google_analytics_id', sanitize_text_field($_POST['google_analytics_id']));
        update_option('mohtawa_facebook_pixel_id', sanitize_text_field($_POST['facebook_pixel_id']));
        
        echo '<div class="notice notice-success"><p>' . __('تم حفظ الإعدادات بنجاح.', 'mohtawa') . '</p></div>';
    }
    
    $enable_reviews = get_option('mohtawa_enable_reviews', '1');
    $reviews_moderation = get_option('mohtawa_reviews_moderation', '1');
    $enable_store_submission = get_option('mohtawa_enable_store_submission', '0');
    $store_submission_moderation = get_option('mohtawa_store_submission_moderation', '1');
    $enable_favorites = get_option('mohtawa_enable_favorites', '1');
    $enable_sharing = get_option('mohtawa_enable_sharing', '1');
    $google_analytics_id = get_option('mohtawa_google_analytics_id', '');
    $facebook_pixel_id = get_option('mohtawa_facebook_pixel_id', '');
    
    ?>
    <div class="wrap">
        <h1><?php _e('الإعدادات المتقدمة', 'mohtawa'); ?></h1>
        
        <form method="post" action="">
            <h2><?php _e('إعدادات التقييمات', 'mohtawa'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('تفعيل التقييمات', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="enable_reviews" value="1" <?php checked($enable_reviews, '1'); ?> />
                            <?php _e('السماح للمستخدمين بإضافة تقييمات للمتاجر', 'mohtawa'); ?>
                        </label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('مراجعة التقييمات', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="reviews_moderation" value="1" <?php checked($reviews_moderation, '1'); ?> />
                            <?php _e('مراجعة التقييمات قبل النشر', 'mohtawa'); ?>
                        </label>
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('إعدادات إرسال المتاجر', 'mohtawa'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('تفعيل إرسال المتاجر', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="enable_store_submission" value="1" <?php checked($enable_store_submission, '1'); ?> />
                            <?php _e('السماح للمستخدمين بإرسال متاجر جديدة', 'mohtawa'); ?>
                        </label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('مراجعة المتاجر المرسلة', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="store_submission_moderation" value="1" <?php checked($store_submission_moderation, '1'); ?> />
                            <?php _e('مراجعة المتاجر المرسلة قبل النشر', 'mohtawa'); ?>
                        </label>
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('إعدادات إضافية', 'mohtawa'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('تفعيل المفضلة', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="enable_favorites" value="1" <?php checked($enable_favorites, '1'); ?> />
                            <?php _e('السماح للمستخدمين بإضافة متاجر للمفضلة', 'mohtawa'); ?>
                        </label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('تفعيل المشاركة', 'mohtawa'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="enable_sharing" value="1" <?php checked($enable_sharing, '1'); ?> />
                            <?php _e('إظهار أزرار المشاركة على وسائل التواصل', 'mohtawa'); ?>
                        </label>
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('أكواد التتبع', 'mohtawa'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('معرف Google Analytics', 'mohtawa'); ?></th>
                    <td>
                        <input type="text" name="google_analytics_id" value="<?php echo esc_attr($google_analytics_id); ?>" class="regular-text" />
                        <p class="description"><?php _e('معرف Google Analytics (مثال: GA-XXXXXXXXX-X)', 'mohtawa'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row"><?php _e('معرف Facebook Pixel', 'mohtawa'); ?></th>
                    <td>
                        <input type="text" name="facebook_pixel_id" value="<?php echo esc_attr($facebook_pixel_id); ?>" class="regular-text" />
                        <p class="description"><?php _e('معرف Facebook Pixel للتتبع والإعلانات', 'mohtawa'); ?></p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button(__('حفظ الإعدادات', 'mohtawa')); ?>
        </form>
    </div>
    <?php
}

/**
 * صفحة التوثيق والمساعدة
 */
function mohtawa_help_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('التوثيق والمساعدة', 'mohtawa'); ?></h1>
        
        <div class="mohtawa-help-content">
            <div class="mohtawa-help-section">
                <h2><?php _e('البدء السريع', 'mohtawa'); ?></h2>
                <ol>
                    <li><?php _e('قم بإضافة فئات المتاجر من قائمة "إدارة الفئات"', 'mohtawa'); ?></li>
                    <li><?php _e('أضف مواقع جغرافية من قائمة "إدارة المواقع"', 'mohtawa'); ?></li>
                    <li><?php _e('ابدأ بإضافة متاجر جديدة مع تحديد مواقعها على الخريطة', 'mohtawa'); ?></li>
                    <li><?php _e('خصص إعدادات الخريطة والألوان من قائمة "تخصيص المظهر"', 'mohtawa'); ?></li>
                    <li><?php _e('راجع إعدادات الخريطة وحدد الموقع الافتراضي', 'mohtawa'); ?></li>
                </ol>
            </div>
            
            <div class="mohtawa-help-section">
                <h2><?php _e('إدارة المتاجر', 'mohtawa'); ?></h2>
                <h3><?php _e('إضافة متجر جديد:', 'mohtawa'); ?></h3>
                <ul>
                    <li><?php _e('اذهب إلى "المتاجر" > "إضافة جديد"', 'mohtawa'); ?></li>
                    <li><?php _e('أدخل اسم المتجر ووصفه', 'mohtawa'); ?></li>
                    <li><?php _e('حدد الفئة والموقع الجغرافي', 'mohtawa'); ?></li>
                    <li><?php _e('أضف معلومات الاتصال (العنوان، الهاتف، الموقع الإلكتروني)', 'mohtawa'); ?></li>
                    <li><?php _e('حدد موقع المتجر على الخريطة', 'mohtawa'); ?></li>
                    <li><?php _e('أضف صورة مميزة ومعرض صور', 'mohtawa'); ?></li>
                    <li><?php _e('حدد ساعات العمل والخدمات المتاحة', 'mohtawa'); ?></li>
                </ul>
                
                <h3><?php _e('الحقول المتاحة:', 'mohtawa'); ?></h3>
                <ul>
                    <li><strong><?php _e('العنوان:', 'mohtawa'); ?></strong> <?php _e('العنوان الكامل للمتجر', 'mohtawa'); ?></li>
                    <li><strong><?php _e('الهاتف:', 'mohtawa'); ?></strong> <?php _e('رقم الهاتف للتواصل', 'mohtawa'); ?></li>
                    <li><strong><?php _e('البريد الإلكتروني:', 'mohtawa'); ?></strong> <?php _e('عنوان البريد الإلكتروني', 'mohtawa'); ?></li>
                    <li><strong><?php _e('الموقع الإلكتروني:', 'mohtawa'); ?></strong> <?php _e('رابط الموقع الإلكتروني للمتجر', 'mohtawa'); ?></li>
                    <li><strong><?php _e('الموقع على الخريطة:', 'mohtawa'); ?></strong> <?php _e('خط العرض وخط الطول', 'mohtawa'); ?></li>
                    <li><strong><?php _e('ساعات العمل:', 'mohtawa'); ?></strong> <?php _e('أوقات فتح وإغلاق المتجر', 'mohtawa'); ?></li>
                    <li><strong><?php _e('الخدمات:', 'mohtawa'); ?></strong> <?php _e('التوصيل، موقف السيارات، واي فاي', 'mohtawa'); ?></li>
                    <li><strong><?php _e('متجر مميز:', 'mohtawa'); ?></strong> <?php _e('إظهار المتجر كمميز', 'mohtawa'); ?></li>
                </ul>
            </div>
            
            <div class="mohtawa-help-section">
                <h2><?php _e('إعدادات الخريطة', 'mohtawa'); ?></h2>
                <p><?php _e('يمكنك تخصيص إعدادات الخريطة من صفحة "إعدادات الخريطة":', 'mohtawa'); ?></p>
                <ul>
                    <li><strong><?php _e('الموقع الافتراضي:', 'mohtawa'); ?></strong> <?php _e('حدد النقطة المركزية للخريطة', 'mohtawa'); ?></li>
                    <li><strong><?php _e('مستوى التكبير:', 'mohtawa'); ?></strong> <?php _e('مستوى التكبير الافتراضي (1-18)', 'mohtawa'); ?></li>
                    <li><strong><?php _e('تجميع العلامات:', 'mohtawa'); ?></strong> <?php _e('تجميع العلامات المتقاربة لتحسين الأداء', 'mohtawa'); ?></li>
                    <li><strong><?php _e('تحديد الموقع:', 'mohtawa'); ?></strong> <?php _e('طلب إذن تحديد موقع المستخدم', 'mohtawa'); ?></li>
                </ul>
            </div>
            
            <div class="mohtawa-help-section">
                <h2><?php _e('التخصيص والمظهر', 'mohtawa'); ?></h2>
                <p><?php _e('يمكنك تخصيص مظهر الموقع من "المظهر" > "تخصيص":', 'mohtawa'); ?></p>
                <ul>
                    <li><strong><?php _e('الهوية والشعار:', 'mohtawa'); ?></strong> <?php _e('رفع شعار الموقع وأيقونة المفضلة', 'mohtawa'); ?></li>
                    <li><strong><?php _e('الألوان:', 'mohtawa'); ?></strong> <?php _e('تخصيص ألوان الموقع والعناصر', 'mohtawa'); ?></li>
                    <li><strong><?php _e('الخطوط:', 'mohtawa'); ?></strong> <?php _e('اختيار خطوط العناوين والنصوص', 'mohtawa'); ?></li>
                    <li><strong><?php _e('وسائل التواصل:', 'mohtawa'); ?></strong> <?php _e('إضافة روابط حسابات التواصل الاجتماعي', 'mohtawa'); ?></li>
                    <li><strong><?php _e('معلومات الاتصال:', 'mohtawa'); ?></strong> <?php _e('إضافة معلومات الاتصال والعنوان', 'mohtawa'); ?></li>
                </ul>
            </div>
            
            <div class="mohtawa-help-section">
                <h2><?php _e('الأسئلة الشائعة', 'mohtawa'); ?></h2>
                
                <h3><?php _e('كيف أضيف موقع متجر على الخريطة؟', 'mohtawa'); ?></h3>
                <p><?php _e('عند إضافة أو تحرير متجر، ستجد خريطة تفاعلية في صندوق "موقع المتجر". انقر على الموقع المطلوب على الخريطة وستتم إضافة الإحداثيات تلقائياً.', 'mohtawa'); ?></p>
                
                <h3><?php _e('كيف أغير الموقع الافتراضي للخريطة؟', 'mohtawa'); ?></h3>
                <p><?php _e('اذهب إلى "قالب محتوى" > "إعدادات الخريطة" وأدخل خط العرض وخط الطول للموقع المطلوب.', 'mohtawa'); ?></p>
                
                <h3><?php _e('كيف أضيف فئات جديدة للمتاجر؟', 'mohtawa'); ?></h3>
                <p><?php _e('اذهب إلى "قالب محتوى" > "إدارة الفئات" أو "المتاجر" > "فئات المتاجر" وأضف فئات جديدة مع تحديد لون وأيقونة لكل فئة.', 'mohtawa'); ?></p>
                
                <h3><?php _e('كيف أتحكم في التقييمات؟', 'mohtawa'); ?></h3>
                <p><?php _e('يمكنك إدارة التقييمات من "التعليقات" في لوحة التحكم، أو تفعيل/إلغاء المراجعة المسبقة من "الإعدادات المتقدمة".', 'mohtawa'); ?></p>
            </div>
            
            <div class="mohtawa-help-section">
                <h2><?php _e('الدعم الفني', 'mohtawa'); ?></h2>
                <p><?php _e('إذا واجهت أي مشاكل أو كان لديك استفسارات:', 'mohtawa'); ?></p>
                <ul>
                    <li><?php _e('تأكد من تحديث ووردبريس إلى آخر إصدار', 'mohtawa'); ?></li>
                    <li><?php _e('تأكد من تفعيل جميع الإضافات المطلوبة', 'mohtawa'); ?></li>
                    <li><?php _e('راجع سجل الأخطاء في لوحة التحكم', 'mohtawa'); ?></li>
                    <li><?php _e('تواصل مع فريق الدعم الفني', 'mohtawa'); ?></li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
    .mohtawa-help-content {
        max-width: 800px;
    }
    
    .mohtawa-help-section {
        background: #fff;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
    }
    
    .mohtawa-help-section h2 {
        margin-top: 0;
        color: #23282d;
        border-bottom: 2px solid #0073aa;
        padding-bottom: 10px;
    }
    
    .mohtawa-help-section h3 {
        color: #0073aa;
        margin-top: 20px;
    }
    
    .mohtawa-help-section ul,
    .mohtawa-help-section ol {
        margin: 10px 0;
        padding-left: 20px;
    }
    
    .mohtawa-help-section li {
        margin: 8px 0;
        line-height: 1.5;
    }
    
    .mohtawa-help-section p {
        line-height: 1.6;
        margin: 10px 0;
    }
    </style>
    <?php
}

/**
 * إضافة أنماط CSS للوحة التحكم
 */
function mohtawa_admin_styles() {
    wp_enqueue_style('mohtawa-admin-styles', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'mohtawa_admin_styles');

/**
 * إضافة سكريبت Leaflet للوحة التحكم
 */
// load Leaflet scripts specifically for dashboard pages
function mohtawa_dashboard_admin_scripts($hook) {
    global $post_type;
    
    if ($post_type === 'store' || strpos($hook, 'mohtawa') !== false) {
        wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true);
        wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4');
    }
}
add_action('admin_enqueue_scripts', 'mohtawa_dashboard_admin_scripts');

