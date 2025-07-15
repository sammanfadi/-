<?php
/**
 * صفحة المتجر الفردية
 *
 * @package Mohtawa
 * @version 1.0.0
 */

get_header(); ?>

<div class="single-store-page">
    <?php while (have_posts()) : the_post(); 
        $store_id = get_the_ID();
        
        // جمع بيانات المتجر
        $store_data = array(
            'address' => get_post_meta($store_id, 'store_address', true),
            'phone' => get_post_meta($store_id, 'store_phone', true),
            'email' => get_post_meta($store_id, 'store_email', true),
            'website' => get_post_meta($store_id, 'store_website', true),
            'latitude' => get_post_meta($store_id, 'store_latitude', true),
            'longitude' => get_post_meta($store_id, 'store_longitude', true),
            'rating' => floatval(get_post_meta($store_id, 'store_rating', true)),
            'reviews_count' => get_post_meta($store_id, 'store_reviews_count', true),
            'is_open' => get_post_meta($store_id, 'store_is_open', true) === '1',
            'opening_hours' => get_post_meta($store_id, 'store_opening_hours', true),
            'delivery' => get_post_meta($store_id, 'store_delivery', true) === '1',
            'parking' => get_post_meta($store_id, 'store_parking', true) === '1',
            'wifi' => get_post_meta($store_id, 'store_wifi', true) === '1',
            'featured' => get_post_meta($store_id, 'store_featured', true) === '1'
        );
        
        // الحصول على الفئات والمواقع
        $categories = get_the_terms($store_id, 'store_category');
        $locations = get_the_terms($store_id, 'store_location');
        
        // الحصول على معرض الصور
        $gallery_ids = get_post_meta($store_id, 'store_gallery', true);
        $gallery_images = array();
        if ($gallery_ids) {
            $gallery_ids = explode(',', $gallery_ids);
            foreach ($gallery_ids as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'store-large');
                $image_thumb = wp_get_attachment_image_url($image_id, 'store-thumbnail');
                if ($image_url) {
                    $gallery_images[] = array(
                        'full' => $image_url,
                        'thumb' => $image_thumb,
                        'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true)
                    );
                }
            }
        }
    ?>
    
    <!-- رأس الصفحة مع معلومات المتجر الأساسية -->
    <section class="store-hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="store-hero-content">
                        <!-- شريط التنقل -->
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>"><?php _e('الرئيسية', 'mohtawa'); ?></a></li>
                                <li class="breadcrumb-item"><a href="<?php echo get_post_type_archive_link('store'); ?>"><?php _e('المتاجر', 'mohtawa'); ?></a></li>
                                <?php if ($categories) : ?>
                                    <li class="breadcrumb-item"><a href="<?php echo get_term_link($categories[0]); ?>"><?php echo esc_html($categories[0]->name); ?></a></li>
                                <?php endif; ?>
                                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                            </ol>
                        </nav>
                        
                        <!-- عنوان المتجر والمعلومات الأساسية -->
                        <div class="store-header">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h1 class="store-title mb-2"><?php the_title(); ?></h1>
                                    
                                    <?php if ($categories) : ?>
                                        <div class="store-categories mb-2">
                                            <?php foreach ($categories as $category) : 
                                                $color = get_term_meta($category->term_id, 'category_color', true);
                                                $icon = get_term_meta($category->term_id, 'category_icon', true);
                                            ?>
                                                <span class="badge me-1" style="background-color: <?php echo esc_attr($color ?: '#3498db'); ?>">
                                                    <i class="fas fa-<?php echo esc_attr($icon ?: 'store'); ?> me-1"></i>
                                                    <?php echo esc_html($category->name); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($store_data['rating']) : ?>
                                        <div class="store-rating">
                                            <div class="stars text-warning d-inline-block">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo $i <= $store_data['rating'] ? '★' : '☆';
                                                }
                                                ?>
                                            </div>
                                            <span class="rating-text ms-2">
                                                <?php echo esc_html($store_data['rating']); ?>/5
                                                <?php if ($store_data['reviews_count']) : ?>
                                                    <small class="text-muted">(<?php echo esc_html($store_data['reviews_count']); ?> <?php _e('تقييم', 'mohtawa'); ?>)</small>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="store-status">
                                    <span class="badge <?php echo $store_data['is_open'] ? 'bg-success' : 'bg-danger'; ?> fs-6">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo $store_data['is_open'] ? __('مفتوح الآن', 'mohtawa') : __('مغلق', 'mohtawa'); ?>
                                    </span>
                                    
                                    <?php if ($store_data['featured']) : ?>
                                        <span class="badge bg-warning text-dark ms-2">
                                            <i class="fas fa-star me-1"></i>
                                            <?php _e('مميز', 'mohtawa'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- معلومات الاتصال السريعة -->
                            <div class="store-quick-info">
                                <div class="row">
                                    <?php if ($store_data['address']) : ?>
                                        <div class="col-md-6 mb-2">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            <span><?php echo esc_html($store_data['address']); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($store_data['phone']) : ?>
                                        <div class="col-md-6 mb-2">
                                            <i class="fas fa-phone text-primary me-2"></i>
                                            <a href="tel:<?php echo esc_attr($store_data['phone']); ?>" class="text-decoration-none">
                                                <?php echo esc_html($store_data['phone']); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- أزرار العمل السريعة -->
                            <div class="store-actions mt-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <?php if ($store_data['phone']) : ?>
                                        <a href="tel:<?php echo esc_attr($store_data['phone']); ?>" class="btn btn-success">
                                            <i class="fas fa-phone me-1"></i>
                                            <?php _e('اتصل الآن', 'mohtawa'); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($store_data['latitude'] && $store_data['longitude']) : ?>
                                        <button type="button" class="btn btn-primary" onclick="showDirections()">
                                            <i class="fas fa-directions me-1"></i>
                                            <?php _e('الحصول على الاتجاهات', 'mohtawa'); ?>
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($store_data['website']) : ?>
                                        <a href="<?php echo esc_url($store_data['website']); ?>" target="_blank" class="btn btn-outline-primary">
                                            <i class="fas fa-globe me-1"></i>
                                            <?php _e('زيارة الموقع', 'mohtawa'); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#shareModal">
                                        <i class="fas fa-share-alt me-1"></i>
                                        <?php _e('مشاركة', 'mohtawa'); ?>
                                    </button>
                                    
                                    <button type="button" class="btn btn-outline-info" onclick="addToFavorites(<?php echo $store_id; ?>)">
                                        <i class="fas fa-heart me-1"></i>
                                        <?php _e('إضافة للمفضلة', 'mohtawa'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="store-featured-image">
                            <?php the_post_thumbnail('store-large', array('class' => 'img-fluid rounded shadow')); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- المحتوى الرئيسي -->
    <section class="store-content-section py-5">
        <div class="container">
            <div class="row">
                <!-- المحتوى الأساسي -->
                <div class="col-lg-8">
                    
                    <!-- وصف المتجر -->
                    <?php if (get_the_content()) : ?>
                        <div class="store-description card mb-4">
                            <div class="card-header">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <?php _e('عن المتجر', 'mohtawa'); ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- معرض الصور -->
                    <?php if (!empty($gallery_images)) : ?>
                        <div class="store-gallery card mb-4">
                            <div class="card-header">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-images me-2"></i>
                                    <?php _e('معرض الصور', 'mohtawa'); ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($gallery_images as $index => $image) : ?>
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <a href="<?php echo esc_url($image['full']); ?>" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#galleryModal"
                                               data-image-index="<?php echo $index; ?>">
                                                <img src="<?php echo esc_url($image['thumb']); ?>" 
                                                     alt="<?php echo esc_attr($image['alt'] ?: get_the_title()); ?>" 
                                                     class="img-fluid rounded gallery-thumb">
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- ساعات العمل -->
                    <?php if ($store_data['opening_hours']) : ?>
                        <div class="store-hours card mb-4">
                            <div class="card-header">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-clock me-2"></i>
                                    <?php _e('ساعات العمل', 'mohtawa'); ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="opening-hours">
                                    <?php echo wp_kses_post(nl2br($store_data['opening_hours'])); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- الخدمات والمميزات -->
                    <div class="store-features card mb-4">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-star me-2"></i>
                                <?php _e('الخدمات والمميزات', 'mohtawa'); ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="feature-item <?php echo $store_data['delivery'] ? 'available' : 'unavailable'; ?>">
                                        <i class="fas fa-truck me-2"></i>
                                        <span><?php _e('خدمة التوصيل', 'mohtawa'); ?></span>
                                        <i class="fas fa-<?php echo $store_data['delivery'] ? 'check text-success' : 'times text-danger'; ?> ms-auto"></i>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <div class="feature-item <?php echo $store_data['parking'] ? 'available' : 'unavailable'; ?>">
                                        <i class="fas fa-parking me-2"></i>
                                        <span><?php _e('موقف سيارات', 'mohtawa'); ?></span>
                                        <i class="fas fa-<?php echo $store_data['parking'] ? 'check text-success' : 'times text-danger'; ?> ms-auto"></i>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <div class="feature-item <?php echo $store_data['wifi'] ? 'available' : 'unavailable'; ?>">
                                        <i class="fas fa-wifi me-2"></i>
                                        <span><?php _e('واي فاي مجاني', 'mohtawa'); ?></span>
                                        <i class="fas fa-<?php echo $store_data['wifi'] ? 'check text-success' : 'times text-danger'; ?> ms-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- التقييمات والمراجعات -->
                    <div class="store-reviews card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-comments me-2"></i>
                                <?php _e('آراء العملاء', 'mohtawa'); ?>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal">
                                <i class="fas fa-plus me-1"></i>
                                <?php _e('إضافة تقييم', 'mohtawa'); ?>
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="reviews-container">
                                <?php
                                $reviews = get_comments(array(
                                    'post_id' => $store_id,
                                    'status' => 'approve',
                                    'type' => 'review',
                                    'number' => 10,
                                    'orderby' => 'comment_date',
                                    'order' => 'DESC'
                                ));
                                
                                if ($reviews) :
                                    foreach ($reviews as $review) :
                                        $rating = get_comment_meta($review->comment_ID, 'rating', true);
                                ?>
                                    <div class="review-item border-bottom pb-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <strong class="reviewer-name"><?php echo esc_html($review->comment_author); ?></strong>
                                                <?php if ($rating) : ?>
                                                    <div class="review-rating text-warning small">
                                                        <?php
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            echo $i <= $rating ? '★' : '☆';
                                                        }
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-muted"><?php echo get_comment_date('j F Y', $review->comment_ID); ?></small>
                                        </div>
                                        <p class="review-content mb-0"><?php echo esc_html($review->comment_content); ?></p>
                                    </div>
                                <?php
                                    endforeach;
                                else :
                                ?>
                                    <div class="text-center py-4">
                                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                        <p class="text-muted"><?php _e('لا توجد تقييمات بعد. كن أول من يقيم هذا المتجر!', 'mohtawa'); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- الشريط الجانبي -->
                <div class="col-lg-4">
                    
                    <!-- معلومات الاتصال -->
                    <div class="contact-info-card card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fas fa-address-card me-2"></i>
                                <?php _e('معلومات الاتصال', 'mohtawa'); ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php if ($store_data['address']) : ?>
                                <div class="contact-item mb-3">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <span><?php echo esc_html($store_data['address']); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($store_data['phone']) : ?>
                                <div class="contact-item mb-3">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <a href="tel:<?php echo esc_attr($store_data['phone']); ?>" class="text-decoration-none">
                                        <?php echo esc_html($store_data['phone']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($store_data['email']) : ?>
                                <div class="contact-item mb-3">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:<?php echo esc_attr($store_data['email']); ?>" class="text-decoration-none">
                                        <?php echo esc_html($store_data['email']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($store_data['website']) : ?>
                                <div class="contact-item mb-3">
                                    <i class="fas fa-globe text-primary me-2"></i>
                                    <a href="<?php echo esc_url($store_data['website']); ?>" target="_blank" class="text-decoration-none">
                                        <?php _e('زيارة الموقع', 'mohtawa'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($locations) : ?>
                                <div class="contact-item">
                                    <i class="fas fa-location-arrow text-primary me-2"></i>
                                    <span>
                                        <?php 
                                        $location_names = array();
                                        foreach ($locations as $location) {
                                            $location_names[] = $location->name;
                                        }
                                        echo esc_html(implode(', ', $location_names));
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- الخريطة -->
                    <?php if ($store_data['latitude'] && $store_data['longitude']) : ?>
                        <div class="store-map-card card mb-4">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-map me-2"></i>
                                    <?php _e('الموقع على الخريطة', 'mohtawa'); ?>
                                </h4>
                            </div>
                            <div class="card-body p-0">
                                <div id="store-map" style="height: 250px; border-radius: 0 0 0.375rem 0.375rem;"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- متاجر مشابهة -->
                    <?php
                    $related_stores = array();
                    if ($categories) {
                        $related_stores = get_posts(array(
                            'post_type' => 'store',
                            'posts_per_page' => 3,
                            'post__not_in' => array($store_id),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'store_category',
                                    'field' => 'term_id',
                                    'terms' => $categories[0]->term_id
                                )
                            )
                        ));
                    }
                    
                    if ($related_stores) :
                    ?>
                        <div class="related-stores-card card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-store me-2"></i>
                                    <?php _e('متاجر مشابهة', 'mohtawa'); ?>
                                </h4>
                            </div>
                            <div class="card-body">
                                <?php foreach ($related_stores as $related_store) : 
                                    $related_rating = get_post_meta($related_store->ID, 'store_rating', true);
                                    $related_address = get_post_meta($related_store->ID, 'store_address', true);
                                ?>
                                    <div class="related-store-item mb-3 pb-3 border-bottom">
                                        <h6 class="mb-1">
                                            <a href="<?php echo get_permalink($related_store->ID); ?>" class="text-decoration-none">
                                                <?php echo esc_html($related_store->post_title); ?>
                                            </a>
                                        </h6>
                                        
                                        <?php if ($related_rating) : ?>
                                            <div class="text-warning small mb-1">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo $i <= $related_rating ? '★' : '☆';
                                                }
                                                ?>
                                                <span class="text-muted ms-1">(<?php echo esc_html($related_rating); ?>)</span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($related_address) : ?>
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?php echo esc_html($related_address); ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </section>
    
    <?php endwhile; ?>
</div>

<!-- نافذة إضافة تقييم -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel"><?php _e('إضافة تقييم', 'mohtawa'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php _e('إغلاق', 'mohtawa'); ?>"></button>
            </div>
            <form id="review-form">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reviewer-name" class="form-label"><?php _e('الاسم', 'mohtawa'); ?> *</label>
                        <input type="text" class="form-control" id="reviewer-name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reviewer-email" class="form-label"><?php _e('البريد الإلكتروني', 'mohtawa'); ?> *</label>
                        <input type="email" class="form-control" id="reviewer-email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><?php _e('التقييم', 'mohtawa'); ?> *</label>
                        <div class="rating-input">
                            <?php for ($i = 5; $i >= 1; $i--) : ?>
                                <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                                <label for="star<?php echo $i; ?>" class="star">★</label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="review-text" class="form-label"><?php _e('تعليقك', 'mohtawa'); ?> *</label>
                        <textarea class="form-control" id="review-text" rows="4" required placeholder="<?php _e('شاركنا تجربتك مع هذا المتجر...', 'mohtawa'); ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php _e('إلغاء', 'mohtawa'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php _e('إرسال التقييم', 'mohtawa'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- نافذة معرض الصور -->
<?php if (!empty($gallery_images)) : ?>
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="galleryModalLabel"><?php _e('معرض الصور', 'mohtawa'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php _e('إغلاق', 'mohtawa'); ?>"></button>
            </div>
            <div class="modal-body p-0">
                <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($gallery_images as $index => $image) : ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo esc_url($image['full']); ?>" 
                                     alt="<?php echo esc_attr($image['alt'] ?: get_the_title()); ?>" 
                                     class="d-block w-100">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (count($gallery_images) > 1) : ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php _e('السابق', 'mohtawa'); ?></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php _e('التالي', 'mohtawa'); ?></span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
// تهيئة خريطة المتجر
<?php if ($store_data['latitude'] && $store_data['longitude']) : ?>
document.addEventListener('DOMContentLoaded', function() {
    const storeMap = L.map('store-map').setView([<?php echo $store_data['latitude']; ?>, <?php echo $store_data['longitude']; ?>], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(storeMap);
    
    const marker = L.marker([<?php echo $store_data['latitude']; ?>, <?php echo $store_data['longitude']; ?>]).addTo(storeMap);
    marker.bindPopup('<?php echo esc_js(get_the_title()); ?>').openPopup();
});
<?php endif; ?>

// إرسال التقييم
document.getElementById('review-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('action', 'add_store_review');
    formData.append('store_id', <?php echo $store_id; ?>);
    formData.append('author_name', document.getElementById('reviewer-name').value);
    formData.append('author_email', document.getElementById('reviewer-email').value);
    formData.append('rating', document.querySelector('input[name="rating"]:checked').value);
    formData.append('review_text', document.getElementById('review-text').value);
    formData.append('nonce', mohtawaTheme.nonce);
    
    fetch(mohtawaTheme.ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.data);
            document.getElementById('review-form').reset();
            bootstrap.Modal.getInstance(document.getElementById('reviewModal')).hide();
        } else {
            alert(data.data || 'حدث خطأ في إرسال التقييم');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في إرسال التقييم');
    });
});

// وظائف إضافية
function showDirections() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            const storeLat = <?php echo $store_data['latitude']; ?>;
            const storeLng = <?php echo $store_data['longitude']; ?>;
            
            const url = `https://www.google.com/maps/dir/${userLat},${userLng}/${storeLat},${storeLng}`;
            window.open(url, '_blank');
        }, function() {
            const storeLat = <?php echo $store_data['latitude']; ?>;
            const storeLng = <?php echo $store_data['longitude']; ?>;
            const url = `https://www.google.com/maps/search/?api=1&query=${storeLat},${storeLng}`;
            window.open(url, '_blank');
        });
    } else {
        const storeLat = <?php echo $store_data['latitude']; ?>;
        const storeLng = <?php echo $store_data['longitude']; ?>;
        const url = `https://www.google.com/maps/search/?api=1&query=${storeLat},${storeLng}`;
        window.open(url, '_blank');
    }
}

function addToFavorites(storeId) {
    // تنفيذ إضافة للمفضلة
    alert('تم إضافة المتجر للمفضلة');
}
</script>

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-input input[type="radio"] {
    display: none;
}

.rating-input label.star {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.rating-input input[type="radio"]:checked ~ label.star,
.rating-input label.star:hover,
.rating-input label.star:hover ~ label.star {
    color: #ffc107;
}

.feature-item {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border-radius: 0.375rem;
    background-color: #f8f9fa;
}

.feature-item.available {
    background-color: #d4edda;
}

.feature-item.unavailable {
    background-color: #f8d7da;
}

.gallery-thumb {
    cursor: pointer;
    transition: transform 0.2s;
}

.gallery-thumb:hover {
    transform: scale(1.05);
}

.store-hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2rem 0;
}

.related-store-item:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
</style>

<?php get_footer(); ?>

