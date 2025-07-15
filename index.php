<?php
/**
 * الصفحة الرئيسية لقالب محتوى
 * تعرض الخريطة التفاعلية والمتاجر
 *
 * @package Mohtawa
 * @version 1.0.0
 */

get_header(); ?>

<div class="main-content">
    
    <!-- قسم البحث والفلاتر -->
    <section class="search-filters-section bg-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    <!-- شريط البحث الرئيسي -->
                    <div class="main-search-bar">
                        <form class="search-form d-flex" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="search" 
                                       class="form-control border-start-0 ps-0" 
                                       placeholder="<?php _e('ابحث عن متجر، منتج، أو خدمة...', 'mohtawa'); ?>" 
                                       value="<?php echo get_search_query(); ?>" 
                                       name="s" 
                                       id="main-search"
                                       autocomplete="off">
                                <button class="btn btn-primary px-4" type="submit">
                                    <?php _e('بحث', 'mohtawa'); ?>
                                </button>
                            </div>
                        </form>
                        
                        <!-- اقتراحات البحث -->
                        <div class="search-suggestions" id="search-suggestions-main" style="display: none;">
                            <div class="suggestions-dropdown bg-white border rounded shadow-sm mt-1">
                                <div class="suggestions-list"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-5">
                    <!-- أزرار التحكم السريع -->
                    <div class="quick-controls d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary flex-fill" id="my-location-btn">
                            <i class="fas fa-location-arrow me-1"></i>
                            <?php _e('موقعي', 'mohtawa'); ?>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="filters-toggle" data-bs-toggle="collapse" data-bs-target="#advanced-filters">
                            <i class="fas fa-filter me-1"></i>
                            <?php _e('فلاتر', 'mohtawa'); ?>
                        </button>
                        <button type="button" class="btn btn-outline-info" id="view-toggle" title="<?php _e('تبديل العرض', 'mohtawa'); ?>">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- الفلاتر المتقدمة -->
            <div class="collapse mt-3" id="advanced-filters">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="category-filter" class="form-label"><?php _e('نوع المتجر', 'mohtawa'); ?></label>
                            <select class="form-select" id="category-filter" name="category">
                                <option value=""><?php _e('جميع الأنواع', 'mohtawa'); ?></option>
                                <?php
                                $categories = get_terms(array(
                                    'taxonomy' => 'store_category',
                                    'hide_empty' => false,
                                ));
                                foreach ($categories as $category) {
                                    $color = get_term_meta($category->term_id, 'category_color', true);
                                    $icon = get_term_meta($category->term_id, 'category_icon', true);
                                    echo '<option value="' . esc_attr($category->slug) . '" data-color="' . esc_attr($color) . '" data-icon="' . esc_attr($icon) . '">' . esc_html($category->name) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="location-filter" class="form-label"><?php _e('الموقع', 'mohtawa'); ?></label>
                            <select class="form-select" id="location-filter" name="location">
                                <option value=""><?php _e('جميع المواقع', 'mohtawa'); ?></option>
                                <?php
                                $locations = get_terms(array(
                                    'taxonomy' => 'store_location',
                                    'hide_empty' => false,
                                    'parent' => 0,
                                ));
                                foreach ($locations as $location) {
                                    echo '<option value="' . esc_attr($location->slug) . '">' . esc_html($location->name) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="rating-filter" class="form-label"><?php _e('التقييم', 'mohtawa'); ?></label>
                            <select class="form-select" id="rating-filter" name="rating">
                                <option value=""><?php _e('جميع التقييمات', 'mohtawa'); ?></option>
                                <option value="5">★★★★★ (5)</option>
                                <option value="4">★★★★☆ (4+)</option>
                                <option value="3">★★★☆☆ (3+)</option>
                                <option value="2">★★☆☆☆ (2+)</option>
                                <option value="1">★☆☆☆☆ (1+)</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="distance-filter" class="form-label"><?php _e('المسافة', 'mohtawa'); ?></label>
                            <select class="form-select" id="distance-filter" name="distance">
                                <option value=""><?php _e('أي مسافة', 'mohtawa'); ?></option>
                                <option value="1"><?php _e('1 كم', 'mohtawa'); ?></option>
                                <option value="5"><?php _e('5 كم', 'mohtawa'); ?></option>
                                <option value="10"><?php _e('10 كم', 'mohtawa'); ?></option>
                                <option value="25"><?php _e('25 كم', 'mohtawa'); ?></option>
                                <option value="50"><?php _e('50 كم', 'mohtawa'); ?></option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="status-filter" class="form-label"><?php _e('الحالة', 'mohtawa'); ?></label>
                            <select class="form-select" id="status-filter" name="status">
                                <option value=""><?php _e('جميع الحالات', 'mohtawa'); ?></option>
                                <option value="open"><?php _e('مفتوح الآن', 'mohtawa'); ?></option>
                                <option value="closed"><?php _e('مغلق', 'mohtawa'); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="has-delivery" name="features[]" value="delivery">
                                <label class="form-check-label" for="has-delivery">
                                    <i class="fas fa-truck me-1"></i>
                                    <?php _e('يوفر توصيل', 'mohtawa'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="has-parking" name="features[]" value="parking">
                                <label class="form-check-label" for="has-parking">
                                    <i class="fas fa-parking me-1"></i>
                                    <?php _e('يوفر موقف سيارات', 'mohtawa'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" id="apply-filters">
                                    <i class="fas fa-check me-1"></i>
                                    <?php _e('تطبيق الفلاتر', 'mohtawa'); ?>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="clear-filters">
                                    <i class="fas fa-times me-1"></i>
                                    <?php _e('مسح الفلاتر', 'mohtawa'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- القسم الرئيسي - الخريطة والقائمة -->
    <section class="main-map-section">
        <div class="container-fluid p-0">
            <div class="row g-0">
                
                <!-- الخريطة التفاعلية -->
                <div class="col-lg-8 col-md-7" id="map-container">
                    <div class="map-wrapper position-relative">
                        <div id="interactive-map" style="height: 600px; min-height: 500px;"></div>
                        
                        <!-- أدوات التحكم في الخريطة -->
                        <div class="map-controls position-absolute top-0 end-0 m-3">
                            <div class="btn-group-vertical" role="group">
                                <button type="button" class="btn btn-light btn-sm" id="zoom-in" title="<?php _e('تكبير', 'mohtawa'); ?>">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-light btn-sm" id="zoom-out" title="<?php _e('تصغير', 'mohtawa'); ?>">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-light btn-sm" id="fullscreen-map" title="<?php _e('ملء الشاشة', 'mohtawa'); ?>">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-light btn-sm" id="center-map" title="<?php _e('توسيط الخريطة', 'mohtawa'); ?>">
                                    <i class="fas fa-crosshairs"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- مؤشر التحميل -->
                        <div class="map-loading position-absolute top-50 start-50 translate-middle" id="map-loading" style="display: none;">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-2" role="status">
                                    <span class="visually-hidden"><?php _e('جاري تحميل الخريطة...', 'mohtawa'); ?></span>
                                </div>
                                <p class="text-muted small"><?php _e('جاري تحميل الخريطة...', 'mohtawa'); ?></p>
                            </div>
                        </div>
                        
                        <!-- إحصائيات سريعة -->
                        <div class="map-stats position-absolute bottom-0 start-0 m-3">
                            <div class="bg-white rounded shadow-sm p-2">
                                <small class="text-muted">
                                    <span id="visible-stores-count">0</span> <?php _e('متجر ظاهر', 'mohtawa'); ?>
                                    <span class="mx-2">|</span>
                                    <span id="total-stores-count">
                                        <?php
                                        $total_stores = wp_count_posts('store');
                                        echo $total_stores->publish;
                                        ?>
                                    </span> <?php _e('إجمالي', 'mohtawa'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- قائمة المتاجر -->
                <div class="col-lg-4 col-md-5" id="stores-list-container">
                    <div class="stores-list-wrapper h-100">
                        
                        <!-- رأس القائمة -->
                        <div class="stores-list-header bg-white border-bottom p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><?php _e('المتاجر القريبة', 'mohtawa'); ?></h5>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-sort me-1"></i>
                                        <?php _e('ترتيب', 'mohtawa'); ?>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" data-sort="distance"><?php _e('المسافة', 'mohtawa'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" data-sort="rating"><?php _e('التقييم', 'mohtawa'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" data-sort="name"><?php _e('الاسم', 'mohtawa'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" data-sort="newest"><?php _e('الأحدث', 'mohtawa'); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- قائمة المتاجر -->
                        <div class="stores-list" id="stores-list" style="height: 550px; overflow-y: auto;">
                            <div class="stores-loading text-center py-5" id="stores-loading">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="visually-hidden"><?php _e('جاري التحميل...', 'mohtawa'); ?></span>
                                </div>
                                <p class="text-muted"><?php _e('جاري تحميل المتاجر...', 'mohtawa'); ?></p>
                            </div>
                            
                            <div class="stores-content" id="stores-content" style="display: none;">
                                <!-- سيتم تحميل المتاجر هنا عبر AJAX -->
                            </div>
                            
                            <div class="stores-empty text-center py-5" id="stores-empty" style="display: none;">
                                <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted"><?php _e('لا توجد متاجر', 'mohtawa'); ?></h6>
                                <p class="text-muted small"><?php _e('لم يتم العثور على متاجر تطابق معايير البحث', 'mohtawa'); ?></p>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="clear-search">
                                    <?php _e('مسح البحث', 'mohtawa'); ?>
                                </button>
                            </div>
                        </div>
                        
                        <!-- تحميل المزيد -->
                        <div class="stores-list-footer bg-light border-top p-3 text-center" id="load-more-container" style="display: none;">
                            <button type="button" class="btn btn-primary btn-sm" id="load-more-stores">
                                <i class="fas fa-plus me-1"></i>
                                <?php _e('تحميل المزيد', 'mohtawa'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- قسم الإحصائيات السريعة -->
    <section class="quick-stats-section bg-primary text-white py-4">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-item">
                        <h3 class="stat-number mb-1" data-count="<?php echo wp_count_posts('store')->publish; ?>">0</h3>
                        <p class="stat-label mb-0"><?php _e('متجر مسجل', 'mohtawa'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-item">
                        <h3 class="stat-number mb-1" data-count="<?php echo wp_count_terms('store_category'); ?>">0</h3>
                        <p class="stat-label mb-0"><?php _e('فئة متجر', 'mohtawa'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-item">
                        <h3 class="stat-number mb-1" data-count="<?php echo wp_count_terms('store_location'); ?>">0</h3>
                        <p class="stat-label mb-0"><?php _e('موقع مغطى', 'mohtawa'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-item">
                        <h3 class="stat-number mb-1" data-count="<?php echo get_comments(array('post_type' => 'store', 'count' => true)); ?>">0</h3>
                        <p class="stat-label mb-0"><?php _e('تقييم وتعليق', 'mohtawa'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- قسم الفئات الشائعة -->
    <section class="popular-categories-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center mb-5">
                        <h2 class="section-title"><?php _e('تصفح حسب الفئة', 'mohtawa'); ?></h2>
                        <p class="section-subtitle text-muted"><?php _e('اكتشف المتاجر والخدمات حسب الفئة التي تهمك', 'mohtawa'); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <?php
                $popular_categories = get_terms(array(
                    'taxonomy' => 'store_category',
                    'hide_empty' => true,
                    'number' => 8,
                    'orderby' => 'count',
                    'order' => 'DESC'
                ));
                
                foreach ($popular_categories as $category) :
                    $color = get_term_meta($category->term_id, 'category_color', true) ?: '#3498db';
                    $icon = get_term_meta($category->term_id, 'category_icon', true) ?: 'store';
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-card text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm category-item" data-category="<?php echo esc_attr($category->slug); ?>">
                                <div class="card-body text-center p-4">
                                    <div class="category-icon mb-3" style="color: <?php echo esc_attr($color); ?>">
                                        <i class="fas fa-<?php echo esc_attr($icon); ?> fa-3x"></i>
                                    </div>
                                    <h5 class="category-name mb-2"><?php echo esc_html($category->name); ?></h5>
                                    <p class="category-count text-muted small mb-0">
                                        <?php printf(_n('%s متجر', '%s متجر', $category->count, 'mohtawa'), number_format_i18n($category->count)); ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="row">
                <div class="col-12 text-center">
                    <a href="<?php echo esc_url(get_post_type_archive_link('store')); ?>" class="btn btn-outline-primary">
                        <?php _e('عرض جميع الفئات', 'mohtawa'); ?>
                        <i class="fas fa-arrow-left ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- قسم المتاجر المميزة -->
    <section class="featured-stores-section bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-header text-center mb-5">
                        <h2 class="section-title"><?php _e('متاجر مميزة', 'mohtawa'); ?></h2>
                        <p class="section-subtitle text-muted"><?php _e('اكتشف أفضل المتاجر الموصى بها في منطقتك', 'mohtawa'); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <?php
                $featured_stores = get_posts(array(
                    'post_type' => 'store',
                    'posts_per_page' => 6,
                    'meta_query' => array(
                        array(
                            'key' => 'store_featured',
                            'value' => '1',
                            'compare' => '='
                        )
                    )
                ));
                
                foreach ($featured_stores as $store) :
                    $store_id = $store->ID;
                    $rating = get_post_meta($store_id, 'store_rating', true);
                    $address = get_post_meta($store_id, 'store_address', true);
                    $phone = get_post_meta($store_id, 'store_phone', true);
                    $is_open = get_post_meta($store_id, 'store_is_open', true);
                    $categories = get_the_terms($store_id, 'store_category');
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card store-card h-100 border-0 shadow-sm">
                            <?php if (has_post_thumbnail($store_id)) : ?>
                                <div class="store-image position-relative">
                                    <?php echo get_the_post_thumbnail($store_id, 'store-medium', array('class' => 'card-img-top')); ?>
                                    <div class="store-status position-absolute top-0 end-0 m-2">
                                        <span class="badge <?php echo $is_open ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $is_open ? __('مفتوح', 'mohtawa') : __('مغلق', 'mohtawa'); ?>
                                        </span>
                                    </div>
                                    <?php if ($categories) : ?>
                                        <div class="store-category position-absolute bottom-0 start-0 m-2">
                                            <?php foreach (array_slice($categories, 0, 1) as $category) :
                                                $color = get_term_meta($category->term_id, 'category_color', true);
                                                $icon = get_term_meta($category->term_id, 'category_icon', true);
                                            ?>
                                                <span class="badge" style="background-color: <?php echo esc_attr($color ?: '#3498db'); ?>">
                                                    <i class="fas fa-<?php echo esc_attr($icon ?: 'store'); ?> me-1"></i>
                                                    <?php echo esc_html($category->name); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <h5 class="store-name mb-2">
                                    <a href="<?php echo esc_url(get_permalink($store_id)); ?>" class="text-decoration-none text-dark">
                                        <?php echo esc_html($store->post_title); ?>
                                    </a>
                                </h5>
                                
                                <?php if ($rating) : ?>
                                    <div class="store-rating mb-2">
                                        <div class="stars text-warning">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $rating ? '★' : '☆';
                                            }
                                            ?>
                                        </div>
                                        <small class="text-muted">
                                            (<?php echo esc_html($rating); ?>/5)
                                        </small>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($address) : ?>
                                    <p class="store-address text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <?php echo esc_html($address); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <p class="store-excerpt text-muted small">
                                    <?php echo wp_trim_words($store->post_excerpt ?: $store->post_content, 15); ?>
                                </p>
                            </div>
                            
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <div class="d-flex gap-2">
                                    <a href="<?php echo esc_url(get_permalink($store_id)); ?>" class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-eye me-1"></i>
                                        <?php _e('عرض التفاصيل', 'mohtawa'); ?>
                                    </a>
                                    <?php if ($phone) : ?>
                                        <a href="tel:<?php echo esc_attr($phone); ?>" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-outline-info btn-sm" data-store-id="<?php echo $store_id; ?>" onclick="showOnMap(this)">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
            
            <div class="row">
                <div class="col-12 text-center">
                    <a href="<?php echo esc_url(get_post_type_archive_link('store')); ?>" class="btn btn-primary">
                        <?php _e('عرض جميع المتاجر', 'mohtawa'); ?>
                        <i class="fas fa-arrow-left ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- قسم الأخبار والعروض -->
    <?php
    $news_posts = get_posts(array(
        'post_type' => 'news',
        'posts_per_page' => 4,
        'post_status' => 'publish'
    ));
    
    if ($news_posts) :
    ?>
        <section class="news-offers-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-header text-center mb-5">
                            <h2 class="section-title"><?php _e('أحدث الأخبار والعروض', 'mohtawa'); ?></h2>
                            <p class="section-subtitle text-muted"><?php _e('تابع آخر الأخبار والعروض الحصرية من المتاجر', 'mohtawa'); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <?php foreach ($news_posts as $news) : ?>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card news-card h-100 border-0 shadow-sm">
                                <?php if (has_post_thumbnail($news->ID)) : ?>
                                    <div class="news-image">
                                        <?php echo get_the_post_thumbnail($news->ID, 'news-thumbnail', array('class' => 'card-img-top')); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h6 class="news-title mb-2">
                                        <a href="<?php echo esc_url(get_permalink($news->ID)); ?>" class="text-decoration-none text-dark">
                                            <?php echo esc_html($news->post_title); ?>
                                        </a>
                                    </h6>
                                    
                                    <p class="news-excerpt text-muted small mb-3">
                                        <?php echo wp_trim_words($news->post_excerpt ?: $news->post_content, 10); ?>
                                    </p>
                                    
                                    <div class="news-meta d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?php echo get_the_date('j F Y', $news->ID); ?>
                                        </small>
                                        <a href="<?php echo esc_url(get_permalink($news->ID)); ?>" class="btn btn-outline-primary btn-sm">
                                            <?php _e('اقرأ المزيد', 'mohtawa'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- قسم دعوة للعمل -->
    <section class="cta-section bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="cta-title mb-2"><?php _e('هل تملك متجراً أو عملاً تجارياً؟', 'mohtawa'); ?></h3>
                    <p class="cta-subtitle mb-0"><?php _e('انضم إلى منصتنا واعرض متجرك لآلاف العملاء المحتملين في منطقتك', 'mohtawa'); ?></p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo esc_url(get_permalink(get_page_by_path('add-store'))); ?>" class="btn btn-light btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        <?php _e('أضف متجرك مجاناً', 'mohtawa'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
</div>

<!-- نافذة تفاصيل المتجر المنبثقة -->
<div class="modal fade" id="storeModal" tabindex="-1" aria-labelledby="storeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="storeModalLabel"><?php _e('تفاصيل المتجر', 'mohtawa'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php _e('إغلاق', 'mohtawa'); ?>"></button>
            </div>
            <div class="modal-body" id="storeModalBody">
                <!-- سيتم تحميل المحتوى عبر AJAX -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden"><?php _e('جاري التحميل...', 'mohtawa'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// متغيرات JavaScript للخريطة
window.mapConfig = {
    defaultCenter: [<?php echo get_theme_mod('mohtawa_map_center_lat', '24.7136'); ?>, <?php echo get_theme_mod('mohtawa_map_center_lng', '46.6753'); ?>],
    defaultZoom: <?php echo get_theme_mod('mohtawa_map_default_zoom', '11'); ?>,
    maxZoom: <?php echo get_theme_mod('mohtawa_map_max_zoom', '18'); ?>,
    minZoom: <?php echo get_theme_mod('mohtawa_map_min_zoom', '8'); ?>,
    tileLayer: '<?php echo get_theme_mod('mohtawa_map_tile_layer', 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'); ?>',
    attribution: '<?php echo get_theme_mod('mohtawa_map_attribution', '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'); ?>',
    clusterDistance: <?php echo get_theme_mod('mohtawa_map_cluster_distance', '80'); ?>,
    showUserLocation: <?php echo get_theme_mod('mohtawa_map_show_user_location', true) ? 'true' : 'false'; ?>,
    autoLocate: <?php echo get_theme_mod('mohtawa_map_auto_locate', false) ? 'true' : 'false'; ?>
};

// بيانات المتاجر للخريطة
window.storesData = [];

// تحميل بيانات المتاجر
jQuery(document).ready(function($) {
    loadStoresData();
    initializeMap();
    initializeFilters();
    initializeSearch();
    animateStats();
});

function loadStoresData() {
    jQuery.ajax({
        url: mohtawaTheme.ajaxUrl,
        type: 'POST',
        data: {
            action: 'get_stores_for_map',
            nonce: mohtawaTheme.nonce
        },
        success: function(response) {
            if (response.success) {
                window.storesData = response.data;
                updateMap();
                updateStoresList();
            }
        },
        error: function() {
            console.error('خطأ في تحميل بيانات المتاجر');
        }
    });
}

function animateStats() {
    jQuery('.stat-number').each(function() {
        const $this = jQuery(this);
        const countTo = parseInt($this.attr('data-count'));
        
        jQuery({ countNum: 0 }).animate({
            countNum: countTo
        }, {
            duration: 2000,
            easing: 'swing',
            step: function() {
                $this.text(Math.floor(this.countNum).toLocaleString('ar'));
            },
            complete: function() {
                $this.text(countTo.toLocaleString('ar'));
            }
        });
    });
}
</script>

<?php get_footer(); ?>

