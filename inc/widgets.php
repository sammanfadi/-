<?php
/**
 * ودجات مخصصة لقالب محتوى
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// منع الوصول المباشر
if (!defined('ABSPATH')) {
    exit;
}


/**
 * ودجة المتاجر المميزة
 */
class Mohtawa_Featured_Stores_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mohtawa_featured_stores',
            __('المتاجر المميزة', 'mohtawa'),
            array('description' => __('عرض قائمة بالمتاجر المميزة', 'mohtawa'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('المتاجر المميزة', 'mohtawa');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        
        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        $featured_stores = get_posts(array(
            'post_type' => 'store',
            'posts_per_page' => $number,
            'meta_key' => 'store_featured',
            'meta_value' => '1',
            'orderby' => 'rand'
        ));
        
        if ($featured_stores) {
            echo '<div class="featured-stores-widget">';
            foreach ($featured_stores as $store) {
                $store_rating = get_post_meta($store->ID, 'store_rating', true);
                $store_address = get_post_meta($store->ID, 'store_address', true);
                $store_image = get_the_post_thumbnail_url($store->ID, 'thumbnail');
                
                echo '<div class="featured-store-item">';
                
                if ($store_image) {
                    echo '<div class="store-image">';
                    echo '<img src="' . esc_url($store_image) . '" alt="' . esc_attr($store->post_title) . '">';
                    echo '</div>';
                }
                
                echo '<div class="store-info">';
                echo '<h4><a href="' . get_permalink($store->ID) . '">' . esc_html($store->post_title) . '</a></h4>';
                
                if ($store_rating) {
                    echo '<div class="store-rating">';
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $store_rating ? '★' : '☆';
                    }
                    echo ' <span>(' . esc_html($store_rating) . ')</span>';
                    echo '</div>';
                }
                
                if ($store_address) {
                    echo '<p class="store-address">' . esc_html($store_address) . '</p>';
                }
                
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>' . __('لا توجد متاجر مميزة حالياً.', 'mohtawa') . '</p>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('المتاجر المميزة', 'mohtawa');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'mohtawa'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('عدد المتاجر:', 'mohtawa'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        return $instance;
    }
}

/**
 * ودجة فئات المتاجر
 */
class Mohtawa_Store_Categories_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mohtawa_store_categories',
            __('فئات المتاجر', 'mohtawa'),
            array('description' => __('عرض قائمة بفئات المتاجر', 'mohtawa'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('فئات المتاجر', 'mohtawa');
        $show_count = !empty($instance['show_count']) ? $instance['show_count'] : false;
        $show_icons = !empty($instance['show_icons']) ? $instance['show_icons'] : false;
        
        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        $categories = get_terms(array(
            'taxonomy' => 'store_category',
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC'
        ));
        
        if ($categories && !is_wp_error($categories)) {
            echo '<ul class="store-categories-widget">';
            foreach ($categories as $category) {
                $icon = get_term_meta($category->term_id, 'category_icon', true);
                $color = get_term_meta($category->term_id, 'category_color', true);
                
                echo '<li class="category-item">';
                echo '<a href="' . get_term_link($category) . '">';
                
                if ($show_icons && $icon) {
                    echo '<i class="fas fa-' . esc_attr($icon) . '" style="color: ' . esc_attr($color ?: '#3498db') . ';"></i> ';
                }
                
                echo esc_html($category->name);
                
                if ($show_count) {
                    echo ' <span class="count">(' . $category->count . ')</span>';
                }
                
                echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>' . __('لا توجد فئات متاحة.', 'mohtawa') . '</p>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('فئات المتاجر', 'mohtawa');
        $show_count = !empty($instance['show_count']) ? $instance['show_count'] : false;
        $show_icons = !empty($instance['show_icons']) ? $instance['show_icons'] : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'mohtawa'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_count); ?> id="<?php echo esc_attr($this->get_field_id('show_count')); ?>" name="<?php echo esc_attr($this->get_field_name('show_count')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_count')); ?>"><?php _e('إظهار عدد المتاجر', 'mohtawa'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_icons); ?> id="<?php echo esc_attr($this->get_field_id('show_icons')); ?>" name="<?php echo esc_attr($this->get_field_name('show_icons')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_icons')); ?>"><?php _e('إظهار الأيقونات', 'mohtawa'); ?></label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_count'] = (!empty($new_instance['show_count'])) ? 1 : 0;
        $instance['show_icons'] = (!empty($new_instance['show_icons'])) ? 1 : 0;
        return $instance;
    }
}

/**
 * ودجة البحث المتقدم
 */
class Mohtawa_Advanced_Search_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mohtawa_advanced_search',
            __('البحث المتقدم', 'mohtawa'),
            array('description' => __('نموذج بحث متقدم للمتاجر', 'mohtawa'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('البحث المتقدم', 'mohtawa');
        
        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        ?>
        <form class="advanced-search-widget" method="get" action="<?php echo esc_url(get_post_type_archive_link('store')); ?>">
            <div class="search-field">
                <label for="widget-search-text"><?php _e('البحث:', 'mohtawa'); ?></label>
                <input type="text" id="widget-search-text" name="s" placeholder="<?php _e('ابحث عن متجر...', 'mohtawa'); ?>" value="<?php echo get_search_query(); ?>">
            </div>
            
            <div class="search-field">
                <label for="widget-search-category"><?php _e('الفئة:', 'mohtawa'); ?></label>
                <select id="widget-search-category" name="store_category">
                    <option value=""><?php _e('جميع الفئات', 'mohtawa'); ?></option>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'store_category',
                        'hide_empty' => true
                    ));
                    foreach ($categories as $category) {
                        $selected = (isset($_GET['store_category']) && $_GET['store_category'] === $category->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($category->slug) . '" ' . $selected . '>' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="search-field">
                <label for="widget-search-location"><?php _e('المنطقة:', 'mohtawa'); ?></label>
                <select id="widget-search-location" name="store_location">
                    <option value=""><?php _e('جميع المناطق', 'mohtawa'); ?></option>
                    <?php
                    $locations = get_terms(array(
                        'taxonomy' => 'store_location',
                        'hide_empty' => true
                    ));
                    foreach ($locations as $location) {
                        $selected = (isset($_GET['store_location']) && $_GET['store_location'] === $location->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($location->slug) . '" ' . $selected . '>' . esc_html($location->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="search-field">
                <label for="widget-search-rating"><?php _e('التقييم:', 'mohtawa'); ?></label>
                <select id="widget-search-rating" name="min_rating">
                    <option value=""><?php _e('جميع التقييمات', 'mohtawa'); ?></option>
                    <option value="5" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '5'); ?>><?php _e('5 نجوم', 'mohtawa'); ?></option>
                    <option value="4" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '4'); ?>><?php _e('4 نجوم فأكثر', 'mohtawa'); ?></option>
                    <option value="3" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '3'); ?>><?php _e('3 نجوم فأكثر', 'mohtawa'); ?></option>
                    <option value="2" <?php selected(isset($_GET['min_rating']) ? $_GET['min_rating'] : '', '2'); ?>><?php _e('نجمتان فأكثر', 'mohtawa'); ?></option>
                </select>
            </div>
            
            <div class="search-features">
                <label><?php _e('الخدمات:', 'mohtawa'); ?></label>
                <div class="feature-checkboxes">
                    <label>
                        <input type="checkbox" name="features[]" value="delivery" <?php checked(in_array('delivery', isset($_GET['features']) ? $_GET['features'] : array())); ?>>
                        <?php _e('توصيل', 'mohtawa'); ?>
                    </label>
                    <label>
                        <input type="checkbox" name="features[]" value="parking" <?php checked(in_array('parking', isset($_GET['features']) ? $_GET['features'] : array())); ?>>
                        <?php _e('موقف سيارات', 'mohtawa'); ?>
                    </label>
                    <label>
                        <input type="checkbox" name="features[]" value="wifi" <?php checked(in_array('wifi', isset($_GET['features']) ? $_GET['features'] : array())); ?>>
                        <?php _e('واي فاي', 'mohtawa'); ?>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="search-submit"><?php _e('بحث', 'mohtawa'); ?></button>
        </form>
        <?php
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('البحث المتقدم', 'mohtawa');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'mohtawa'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * ودجة معلومات الاتصال
 */
class Mohtawa_Contact_Info_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mohtawa_contact_info',
            __('معلومات الاتصال', 'mohtawa'),
            array('description' => __('عرض معلومات الاتصال والعنوان', 'mohtawa'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('معلومات الاتصال', 'mohtawa');
        
        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        $phone = get_theme_mod('mohtawa_phone_number', '');
        $email = get_theme_mod('mohtawa_email_address', '');
        $address = get_theme_mod('mohtawa_address', '');
        $working_hours = get_theme_mod('mohtawa_working_hours', '');
        
        echo '<div class="contact-info-widget">';
        
        if ($phone) {
            echo '<div class="contact-item">';
            echo '<i class="fas fa-phone"></i>';
            echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
            echo '</div>';
        }
        
        if ($email) {
            echo '<div class="contact-item">';
            echo '<i class="fas fa-envelope"></i>';
            echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            echo '</div>';
        }
        
        if ($address) {
            echo '<div class="contact-item">';
            echo '<i class="fas fa-map-marker-alt"></i>';
            echo '<span>' . esc_html($address) . '</span>';
            echo '</div>';
        }
        
        if ($working_hours) {
            echo '<div class="contact-item">';
            echo '<i class="fas fa-clock"></i>';
            echo '<span>' . nl2br(esc_html($working_hours)) . '</span>';
            echo '</div>';
        }
        
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('معلومات الاتصال', 'mohtawa');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'mohtawa'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p><?php _e('يتم جلب المعلومات من إعدادات التخصيص.', 'mohtawa'); ?></p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * ودجة وسائل التواصل الاجتماعي
 */
class Mohtawa_Social_Media_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mohtawa_social_media',
            __('وسائل التواصل الاجتماعي', 'mohtawa'),
            array('description' => __('عرض روابط وسائل التواصل الاجتماعي', 'mohtawa'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('تابعنا', 'mohtawa');
        $show_labels = !empty($instance['show_labels']) ? $instance['show_labels'] : false;
        
        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        $social_links = array(
            'facebook' => array(
                'url' => get_theme_mod('mohtawa_facebook_url', ''),
                'icon' => 'fab fa-facebook-f',
                'label' => __('فيسبوك', 'mohtawa')
            ),
            'twitter' => array(
                'url' => get_theme_mod('mohtawa_twitter_url', ''),
                'icon' => 'fab fa-twitter',
                'label' => __('تويتر', 'mohtawa')
            ),
            'instagram' => array(
                'url' => get_theme_mod('mohtawa_instagram_url', ''),
                'icon' => 'fab fa-instagram',
                'label' => __('إنستغرام', 'mohtawa')
            ),
            'linkedin' => array(
                'url' => get_theme_mod('mohtawa_linkedin_url', ''),
                'icon' => 'fab fa-linkedin-in',
                'label' => __('لينكد إن', 'mohtawa')
            ),
            'youtube' => array(
                'url' => get_theme_mod('mohtawa_youtube_url', ''),
                'icon' => 'fab fa-youtube',
                'label' => __('يوتيوب', 'mohtawa')
            ),
            'whatsapp' => array(
                'url' => get_theme_mod('mohtawa_whatsapp_number', ''),
                'icon' => 'fab fa-whatsapp',
                'label' => __('واتساب', 'mohtawa')
            )
        );
        
        echo '<div class="social-media-widget">';
        
        foreach ($social_links as $platform => $data) {
            if (!empty($data['url'])) {
                $url = $data['url'];
                
                // تنسيق رابط واتساب
                if ($platform === 'whatsapp') {
                    $url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $data['url']);
                }
                
                echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener" class="social-link social-' . esc_attr($platform) . '">';
                echo '<i class="' . esc_attr($data['icon']) . '"></i>';
                
                if ($show_labels) {
                    echo '<span>' . esc_html($data['label']) . '</span>';
                }
                
                echo '</a>';
            }
        }
        
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('تابعنا', 'mohtawa');
        $show_labels = !empty($instance['show_labels']) ? $instance['show_labels'] : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'mohtawa'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_labels); ?> id="<?php echo esc_attr($this->get_field_id('show_labels')); ?>" name="<?php echo esc_attr($this->get_field_name('show_labels')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_labels')); ?>"><?php _e('إظهار أسماء المنصات', 'mohtawa'); ?></label>
        </p>
        <p><?php _e('يتم جلب الروابط من إعدادات التخصيص.', 'mohtawa'); ?></p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_labels'] = (!empty($new_instance['show_labels'])) ? 1 : 0;
        return $instance;
    }
}

/**
 * تسجيل الودجات المخصصة
 */
function mohtawa_register_widgets() {
    register_widget('Mohtawa_Featured_Stores_Widget');
    register_widget('Mohtawa_Store_Categories_Widget');
    register_widget('Mohtawa_Advanced_Search_Widget');
    register_widget('Mohtawa_Contact_Info_Widget');
    register_widget('Mohtawa_Social_Media_Widget');
}
add_action('widgets_init', 'mohtawa_register_widgets');

/**
 * إضافة أنماط CSS للودجات
 */
function mohtawa_widgets_styles() {
    ?>
    <style>
    /* أنماط ودجة المتاجر المميزة */
    .featured-stores-widget .featured-store-item {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .featured-stores-widget .featured-store-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .featured-stores-widget .store-image {
        width: 60px;
        height: 60px;
        margin-right: 10px;
        flex-shrink: 0;
    }
    
    .featured-stores-widget .store-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }
    
    .featured-stores-widget .store-info h4 {
        margin: 0 0 5px;
        font-size: 14px;
    }
    
    .featured-stores-widget .store-info h4 a {
        text-decoration: none;
        color: #333;
    }
    
    .featured-stores-widget .store-rating {
        color: #ffb900;
        font-size: 12px;
        margin-bottom: 5px;
    }
    
    .featured-stores-widget .store-address {
        font-size: 12px;
        color: #666;
        margin: 0;
    }
    
    /* أنماط ودجة فئات المتاجر */
    .store-categories-widget {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .store-categories-widget .category-item {
        margin-bottom: 8px;
    }
    
    .store-categories-widget .category-item a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        padding: 5px 0;
    }
    
    .store-categories-widget .category-item a:hover {
        color: #0073aa;
    }
    
    .store-categories-widget .category-item i {
        margin-right: 8px;
        width: 16px;
    }
    
    .store-categories-widget .count {
        margin-right: auto;
        color: #666;
        font-size: 12px;
    }
    
    /* أنماط ودجة البحث المتقدم */
    .advanced-search-widget .search-field {
        margin-bottom: 15px;
    }
    
    .advanced-search-widget label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 13px;
    }
    
    .advanced-search-widget input[type="text"],
    .advanced-search-widget select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .advanced-search-widget .feature-checkboxes {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .advanced-search-widget .feature-checkboxes label {
        display: flex;
        align-items: center;
        font-weight: normal;
        margin-bottom: 0;
    }
    
    .advanced-search-widget .feature-checkboxes input[type="checkbox"] {
        margin-right: 8px;
        width: auto;
    }
    
    .advanced-search-widget .search-submit {
        width: 100%;
        padding: 10px;
        background-color: #0073aa;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        margin-top: 10px;
    }
    
    .advanced-search-widget .search-submit:hover {
        background-color: #005a87;
    }
    
    /* أنماط ودجة معلومات الاتصال */
    .contact-info-widget .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
        font-size: 14px;
    }
    
    .contact-info-widget .contact-item:last-child {
        margin-bottom: 0;
    }
    
    .contact-info-widget .contact-item i {
        margin-right: 10px;
        margin-top: 2px;
        color: #0073aa;
        width: 16px;
        flex-shrink: 0;
    }
    
    .contact-info-widget .contact-item a {
        text-decoration: none;
        color: #333;
    }
    
    .contact-info-widget .contact-item a:hover {
        color: #0073aa;
    }
    
    /* أنماط ودجة وسائل التواصل */
    .social-media-widget {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .social-media-widget .social-link {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        font-size: 14px;
        transition: opacity 0.2s;
    }
    
    .social-media-widget .social-link:hover {
        opacity: 0.8;
    }
    
    .social-media-widget .social-link i {
        margin-right: 6px;
    }
    
    .social-media-widget .social-facebook { background-color: #1877f2; }
    .social-media-widget .social-twitter { background-color: #1da1f2; }
    .social-media-widget .social-instagram { background-color: #e4405f; }
    .social-media-widget .social-linkedin { background-color: #0077b5; }
    .social-media-widget .social-youtube { background-color: #ff0000; }
    .social-media-widget .social-whatsapp { background-color: #25d366; }
    
    /* تحسينات للأجهزة المحمولة */
    @media (max-width: 768px) {
        .featured-stores-widget .featured-store-item {
            flex-direction: column;
        }
        
        .featured-stores-widget .store-image {
            width: 100%;
            height: 150px;
            margin-right: 0;
            margin-bottom: 10px;
        }
        
        .social-media-widget {
            justify-content: center;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'mohtawa_widgets_styles');

