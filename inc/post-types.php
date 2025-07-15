<?php
/**
 * أنواع المحتوى المخصصة لقالب محتوى
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// منع الوصول المباشر للملف
if (!defined('ABSPATH')) {
    exit;
}

/**
 * تسجيل نوع محتوى المتاجر
 */
function mohtawa_register_store_post_type() {
    $labels = array(
        'name'                  => __('المتاجر', 'mohtawa'),
        'singular_name'         => __('متجر', 'mohtawa'),
        'menu_name'            => __('المتاجر', 'mohtawa'),
        'name_admin_bar'       => __('متجر', 'mohtawa'),
        'archives'             => __('أرشيف المتاجر', 'mohtawa'),
        'attributes'           => __('خصائص المتجر', 'mohtawa'),
        'parent_item_colon'    => __('المتجر الأب:', 'mohtawa'),
        'all_items'            => __('جميع المتاجر', 'mohtawa'),
        'add_new_item'         => __('إضافة متجر جديد', 'mohtawa'),
        'add_new'              => __('إضافة جديد', 'mohtawa'),
        'new_item'             => __('متجر جديد', 'mohtawa'),
        'edit_item'            => __('تحرير المتجر', 'mohtawa'),
        'update_item'          => __('تحديث المتجر', 'mohtawa'),
        'view_item'            => __('عرض المتجر', 'mohtawa'),
        'view_items'           => __('عرض المتاجر', 'mohtawa'),
        'search_items'         => __('البحث في المتاجر', 'mohtawa'),
        'not_found'            => __('لم يتم العثور على متاجر', 'mohtawa'),
        'not_found_in_trash'   => __('لم يتم العثور على متاجر في المهملات', 'mohtawa'),
        'featured_image'       => __('صورة المتجر الرئيسية', 'mohtawa'),
        'set_featured_image'   => __('تعيين صورة المتجر الرئيسية', 'mohtawa'),
        'remove_featured_image' => __('إزالة صورة المتجر الرئيسية', 'mohtawa'),
        'use_featured_image'   => __('استخدام كصورة رئيسية', 'mohtawa'),
        'insert_into_item'     => __('إدراج في المتجر', 'mohtawa'),
        'uploaded_to_this_item' => __('تم رفعه لهذا المتجر', 'mohtawa'),
        'items_list'           => __('قائمة المتاجر', 'mohtawa'),
        'items_list_navigation' => __('التنقل في قائمة المتاجر', 'mohtawa'),
        'filter_items_list'    => __('تصفية قائمة المتاجر', 'mohtawa'),
    );

    $args = array(
        'label'                => __('متجر', 'mohtawa'),
        'description'          => __('المتاجر والأعمال التجارية', 'mohtawa'),
        'labels'               => $labels,
        'supports'             => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields'),
        'taxonomies'           => array('store_category', 'store_location'),
        'hierarchical'         => false,
        'public'               => true,
        'show_ui'              => true,
        'show_in_menu'         => true,
        'menu_position'        => 5,
        'menu_icon'            => 'dashicons-store',
        'show_in_admin_bar'    => true,
        'show_in_nav_menus'    => true,
        'can_export'           => true,
        'has_archive'          => true,
        'exclude_from_search'  => false,
        'publicly_queryable'   => true,
        'capability_type'      => 'post',
        'show_in_rest'         => true,
        'rest_base'            => 'stores',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rewrite'              => array(
            'slug'       => 'stores',
            'with_front' => false,
            'pages'      => true,
            'feeds'      => true,
        ),
    );

    register_post_type('store', $args);
}
add_action('init', 'mohtawa_register_store_post_type', 0);

/**
 * تسجيل نوع محتوى الأخبار
 */
function mohtawa_register_news_post_type() {
    $labels = array(
        'name'                  => __('الأخبار', 'mohtawa'),
        'singular_name'         => __('خبر', 'mohtawa'),
        'menu_name'            => __('الأخبار', 'mohtawa'),
        'name_admin_bar'       => __('خبر', 'mohtawa'),
        'archives'             => __('أرشيف الأخبار', 'mohtawa'),
        'attributes'           => __('خصائص الخبر', 'mohtawa'),
        'parent_item_colon'    => __('الخبر الأب:', 'mohtawa'),
        'all_items'            => __('جميع الأخبار', 'mohtawa'),
        'add_new_item'         => __('إضافة خبر جديد', 'mohtawa'),
        'add_new'              => __('إضافة جديد', 'mohtawa'),
        'new_item'             => __('خبر جديد', 'mohtawa'),
        'edit_item'            => __('تحرير الخبر', 'mohtawa'),
        'update_item'          => __('تحديث الخبر', 'mohtawa'),
        'view_item'            => __('عرض الخبر', 'mohtawa'),
        'view_items'           => __('عرض الأخبار', 'mohtawa'),
        'search_items'         => __('البحث في الأخبار', 'mohtawa'),
        'not_found'            => __('لم يتم العثور على أخبار', 'mohtawa'),
        'not_found_in_trash'   => __('لم يتم العثور على أخبار في المهملات', 'mohtawa'),
        'featured_image'       => __('صورة الخبر الرئيسية', 'mohtawa'),
        'set_featured_image'   => __('تعيين صورة الخبر الرئيسية', 'mohtawa'),
        'remove_featured_image' => __('إزالة صورة الخبر الرئيسية', 'mohtawa'),
        'use_featured_image'   => __('استخدام كصورة رئيسية', 'mohtawa'),
        'insert_into_item'     => __('إدراج في الخبر', 'mohtawa'),
        'uploaded_to_this_item' => __('تم رفعه لهذا الخبر', 'mohtawa'),
        'items_list'           => __('قائمة الأخبار', 'mohtawa'),
        'items_list_navigation' => __('التنقل في قائمة الأخبار', 'mohtawa'),
        'filter_items_list'    => __('تصفية قائمة الأخبار', 'mohtawa'),
    );

    $args = array(
        'label'                => __('خبر', 'mohtawa'),
        'description'          => __('أخبار المتاجر والعروض', 'mohtawa'),
        'labels'               => $labels,
        'supports'             => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields'),
        'taxonomies'           => array('news_category'),
        'hierarchical'         => false,
        'public'               => true,
        'show_ui'              => true,
        'show_in_menu'         => true,
        'menu_position'        => 6,
        'menu_icon'            => 'dashicons-megaphone',
        'show_in_admin_bar'    => true,
        'show_in_nav_menus'    => true,
        'can_export'           => true,
        'has_archive'          => true,
        'exclude_from_search'  => false,
        'publicly_queryable'   => true,
        'capability_type'      => 'post',
        'show_in_rest'         => true,
        'rest_base'            => 'news',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rewrite'              => array(
            'slug'       => 'news',
            'with_front' => false,
            'pages'      => true,
            'feeds'      => true,
        ),
    );

    register_post_type('news', $args);
}
add_action('init', 'mohtawa_register_news_post_type', 0);

/**
 * تسجيل تصنيف أنواع المتاجر
 */
function mohtawa_register_store_category_taxonomy() {
    $labels = array(
        'name'                       => __('أنواع المتاجر', 'mohtawa'),
        'singular_name'              => __('نوع المتجر', 'mohtawa'),
        'menu_name'                  => __('أنواع المتاجر', 'mohtawa'),
        'all_items'                  => __('جميع الأنواع', 'mohtawa'),
        'parent_item'                => __('النوع الأب', 'mohtawa'),
        'parent_item_colon'          => __('النوع الأب:', 'mohtawa'),
        'new_item_name'              => __('اسم النوع الجديد', 'mohtawa'),
        'add_new_item'               => __('إضافة نوع جديد', 'mohtawa'),
        'edit_item'                  => __('تحرير النوع', 'mohtawa'),
        'update_item'                => __('تحديث النوع', 'mohtawa'),
        'view_item'                  => __('عرض النوع', 'mohtawa'),
        'separate_items_with_commas' => __('فصل الأنواع بفواصل', 'mohtawa'),
        'add_or_remove_items'        => __('إضافة أو إزالة أنواع', 'mohtawa'),
        'choose_from_most_used'      => __('اختيار من الأكثر استخداماً', 'mohtawa'),
        'popular_items'              => __('الأنواع الشائعة', 'mohtawa'),
        'search_items'               => __('البحث في الأنواع', 'mohtawa'),
        'not_found'                  => __('لم يتم العثور على أنواع', 'mohtawa'),
        'no_terms'                   => __('لا توجد أنواع', 'mohtawa'),
        'items_list'                 => __('قائمة الأنواع', 'mohtawa'),
        'items_list_navigation'      => __('التنقل في قائمة الأنواع', 'mohtawa'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'store-categories',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
        'rewrite'                    => array(
            'slug'         => 'store-category',
            'with_front'   => false,
            'hierarchical' => true,
        ),
    );

    register_taxonomy('store_category', array('store'), $args);
}
add_action('init', 'mohtawa_register_store_category_taxonomy', 0);

/**
 * تسجيل تصنيف المواقع الجغرافية
 */
function mohtawa_register_store_location_taxonomy() {
    $labels = array(
        'name'                       => __('المواقع الجغرافية', 'mohtawa'),
        'singular_name'              => __('الموقع الجغرافي', 'mohtawa'),
        'menu_name'                  => __('المواقع', 'mohtawa'),
        'all_items'                  => __('جميع المواقع', 'mohtawa'),
        'parent_item'                => __('الموقع الأب', 'mohtawa'),
        'parent_item_colon'          => __('الموقع الأب:', 'mohtawa'),
        'new_item_name'              => __('اسم الموقع الجديد', 'mohtawa'),
        'add_new_item'               => __('إضافة موقع جديد', 'mohtawa'),
        'edit_item'                  => __('تحرير الموقع', 'mohtawa'),
        'update_item'                => __('تحديث الموقع', 'mohtawa'),
        'view_item'                  => __('عرض الموقع', 'mohtawa'),
        'separate_items_with_commas' => __('فصل المواقع بفواصل', 'mohtawa'),
        'add_or_remove_items'        => __('إضافة أو إزالة مواقع', 'mohtawa'),
        'choose_from_most_used'      => __('اختيار من الأكثر استخداماً', 'mohtawa'),
        'popular_items'              => __('المواقع الشائعة', 'mohtawa'),
        'search_items'               => __('البحث في المواقع', 'mohtawa'),
        'not_found'                  => __('لم يتم العثور على مواقع', 'mohtawa'),
        'no_terms'                   => __('لا توجد مواقع', 'mohtawa'),
        'items_list'                 => __('قائمة المواقع', 'mohtawa'),
        'items_list_navigation'      => __('التنقل في قائمة المواقع', 'mohtawa'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'store-locations',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
        'rewrite'                    => array(
            'slug'         => 'location',
            'with_front'   => false,
            'hierarchical' => true,
        ),
    );

    register_taxonomy('store_location', array('store'), $args);
}
add_action('init', 'mohtawa_register_store_location_taxonomy', 0);

/**
 * تسجيل تصنيف أنواع الأخبار
 */
function mohtawa_register_news_category_taxonomy() {
    $labels = array(
        'name'                       => __('أنواع الأخبار', 'mohtawa'),
        'singular_name'              => __('نوع الخبر', 'mohtawa'),
        'menu_name'                  => __('أنواع الأخبار', 'mohtawa'),
        'all_items'                  => __('جميع الأنواع', 'mohtawa'),
        'parent_item'                => __('النوع الأب', 'mohtawa'),
        'parent_item_colon'          => __('النوع الأب:', 'mohtawa'),
        'new_item_name'              => __('اسم النوع الجديد', 'mohtawa'),
        'add_new_item'               => __('إضافة نوع جديد', 'mohtawa'),
        'edit_item'                  => __('تحرير النوع', 'mohtawa'),
        'update_item'                => __('تحديث النوع', 'mohtawa'),
        'view_item'                  => __('عرض النوع', 'mohtawa'),
        'separate_items_with_commas' => __('فصل الأنواع بفواصل', 'mohtawa'),
        'add_or_remove_items'        => __('إضافة أو إزالة أنواع', 'mohtawa'),
        'choose_from_most_used'      => __('اختيار من الأكثر استخداماً', 'mohtawa'),
        'popular_items'              => __('الأنواع الشائعة', 'mohtawa'),
        'search_items'               => __('البحث في الأنواع', 'mohtawa'),
        'not_found'                  => __('لم يتم العثور على أنواع', 'mohtawa'),
        'no_terms'                   => __('لا توجد أنواع', 'mohtawa'),
        'items_list'                 => __('قائمة الأنواع', 'mohtawa'),
        'items_list_navigation'      => __('التنقل في قائمة الأنواع', 'mohtawa'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'news-categories',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
        'rewrite'                    => array(
            'slug'         => 'news-category',
            'with_front'   => false,
            'hierarchical' => true,
        ),
    );

    register_taxonomy('news_category', array('news'), $args);
}
add_action('init', 'mohtawa_register_news_category_taxonomy', 0);

/**
 * إضافة التصنيفات الافتراضية للمتاجر
 */
function mohtawa_add_default_store_categories() {
    $categories = array(
        'restaurants' => array(
            'name' => __('مطاعم ومأكولات', 'mohtawa'),
            'description' => __('المطاعم والمقاهي وأماكن تقديم الطعام', 'mohtawa'),
            'color' => '#e74c3c',
            'icon' => 'utensils'
        ),
        'clothing' => array(
            'name' => __('ملابس وإكسسوارات', 'mohtawa'),
            'description' => __('متاجر الملابس والأحذية والإكسسوارات', 'mohtawa'),
            'color' => '#3498db',
            'icon' => 'tshirt'
        ),
        'electronics' => array(
            'name' => __('إلكترونيات وتقنية', 'mohtawa'),
            'description' => __('متاجر الأجهزة الإلكترونية والتقنية', 'mohtawa'),
            'color' => '#27ae60',
            'icon' => 'laptop'
        ),
        'pharmacy' => array(
            'name' => __('صيدليات ومستلزمات طبية', 'mohtawa'),
            'description' => __('الصيدليات والمستلزمات الطبية', 'mohtawa'),
            'color' => '#9b59b6',
            'icon' => 'prescription-bottle-alt'
        ),
        'cafes' => array(
            'name' => __('مقاهي ومشروبات', 'mohtawa'),
            'description' => __('المقاهي وأماكن تقديم المشروبات', 'mohtawa'),
            'color' => '#f39c12',
            'icon' => 'coffee'
        ),
        'services' => array(
            'name' => __('خدمات عامة', 'mohtawa'),
            'description' => __('الخدمات العامة والمهنية', 'mohtawa'),
            'color' => '#34495e',
            'icon' => 'tools'
        ),
        'shopping' => array(
            'name' => __('تسوق وهدايا', 'mohtawa'),
            'description' => __('متاجر التسوق العامة والهدايا', 'mohtawa'),
            'color' => '#e67e22',
            'icon' => 'gift'
        ),
        'beauty' => array(
            'name' => __('تجميل وعناية', 'mohtawa'),
            'description' => __('صالونات التجميل ومراكز العناية', 'mohtawa'),
            'color' => '#f1c40f',
            'icon' => 'spa'
        ),
        'automotive' => array(
            'name' => __('سيارات وقطع غيار', 'mohtawa'),
            'description' => __('معارض السيارات وقطع الغيار', 'mohtawa'),
            'color' => '#95a5a6',
            'icon' => 'car'
        ),
        'sports' => array(
            'name' => __('رياضة ولياقة', 'mohtawa'),
            'description' => __('النوادي الرياضية ومتاجر المعدات الرياضية', 'mohtawa'),
            'color' => '#16a085',
            'icon' => 'dumbbell'
        )
    );

    foreach ($categories as $slug => $category) {
        if (!term_exists($category['name'], 'store_category')) {
            $term = wp_insert_term(
                $category['name'],
                'store_category',
                array(
                    'description' => $category['description'],
                    'slug' => $slug
                )
            );

            if (!is_wp_error($term)) {
                // إضافة البيانات الإضافية للتصنيف
                add_term_meta($term['term_id'], 'category_color', $category['color']);
                add_term_meta($term['term_id'], 'category_icon', $category['icon']);
            }
        }
    }
}
add_action('init', 'mohtawa_add_default_store_categories');

/**
 * إضافة المواقع الافتراضية
 */
function mohtawa_add_default_locations() {
    $locations = array(
        'riyadh' => array(
            'name' => __('الرياض', 'mohtawa'),
            'description' => __('العاصمة الرياض', 'mohtawa'),
            'children' => array(
                'olaya' => __('العليا', 'mohtawa'),
                'malaz' => __('الملز', 'mohtawa'),
                'tahlia' => __('التحلية', 'mohtawa'),
                'king_fahd' => __('شارع الملك فهد', 'mohtawa'),
                'diplomatic_quarter' => __('الحي الدبلوماسي', 'mohtawa')
            )
        ),
        'jeddah' => array(
            'name' => __('جدة', 'mohtawa'),
            'description' => __('مدينة جدة', 'mohtawa'),
            'children' => array(
                'corniche' => __('الكورنيش', 'mohtawa'),
                'balad' => __('البلد', 'mohtawa'),
                'tahlia_jeddah' => __('التحلية', 'mohtawa'),
                'rawdah' => __('الروضة', 'mohtawa')
            )
        ),
        'dammam' => array(
            'name' => __('الدمام', 'mohtawa'),
            'description' => __('مدينة الدمام', 'mohtawa'),
            'children' => array(
                'corniche_dammam' => __('الكورنيش', 'mohtawa'),
                'ferdous' => __('الفردوس', 'mohtawa'),
                'shatea' => __('الشاطئ', 'mohtawa')
            )
        ),
        'makkah' => array(
            'name' => __('مكة المكرمة', 'mohtawa'),
            'description' => __('مكة المكرمة', 'mohtawa'),
            'children' => array(
                'haram' => __('الحرم', 'mohtawa'),
                'aziziyah' => __('العزيزية', 'mohtawa'),
                'misfalah' => __('المسفلة', 'mohtawa')
            )
        )
    );

    foreach ($locations as $slug => $location) {
        if (!term_exists($location['name'], 'store_location')) {
            $parent_term = wp_insert_term(
                $location['name'],
                'store_location',
                array(
                    'description' => $location['description'],
                    'slug' => $slug
                )
            );

            if (!is_wp_error($parent_term) && isset($location['children'])) {
                foreach ($location['children'] as $child_slug => $child_name) {
                    wp_insert_term(
                        $child_name,
                        'store_location',
                        array(
                            'parent' => $parent_term['term_id'],
                            'slug' => $child_slug
                        )
                    );
                }
            }
        }
    }
}
add_action('init', 'mohtawa_add_default_locations');

/**
 * إضافة أنواع الأخبار الافتراضية
 */
function mohtawa_add_default_news_categories() {
    $categories = array(
        'offers' => __('عروض وخصومات', 'mohtawa'),
        'openings' => __('افتتاحات جديدة', 'mohtawa'),
        'events' => __('فعاليات وأحداث', 'mohtawa'),
        'updates' => __('تحديثات وأخبار', 'mohtawa'),
        'announcements' => __('إعلانات مهمة', 'mohtawa')
    );

    foreach ($categories as $slug => $name) {
        if (!term_exists($name, 'news_category')) {
            wp_insert_term(
                $name,
                'news_category',
                array('slug' => $slug)
            );
        }
    }
}
add_action('init', 'mohtawa_add_default_news_categories');

/**
 * تخصيص أعمدة قائمة المتاجر في لوحة الإدارة
 */
function mohtawa_store_admin_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        if ($key === 'title') {
            $new_columns['store_image'] = __('الصورة', 'mohtawa');
            $new_columns['store_category'] = __('النوع', 'mohtawa');
            $new_columns['store_location'] = __('الموقع', 'mohtawa');
            $new_columns['store_rating'] = __('التقييم', 'mohtawa');
            $new_columns['store_status'] = __('الحالة', 'mohtawa');
        }
    }
    
    return $new_columns;
}
add_filter('manage_store_posts_columns', 'mohtawa_store_admin_columns');

/**
 * عرض محتوى الأعمدة المخصصة للمتاجر
 */
function mohtawa_store_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'store_image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, array(50, 50));
            } else {
                echo '<span class="dashicons dashicons-format-image" style="color: #ccc; font-size: 30px;"></span>';
            }
            break;
            
        case 'store_category':
            $categories = get_the_terms($post_id, 'store_category');
            if ($categories && !is_wp_error($categories)) {
                $category_names = array();
                foreach ($categories as $category) {
                    $color = get_term_meta($category->term_id, 'category_color', true);
                    $style = $color ? 'style="color: ' . esc_attr($color) . '"' : '';
                    $category_names[] = '<span ' . $style . '>' . esc_html($category->name) . '</span>';
                }
                echo implode(', ', $category_names);
            } else {
                echo '<span style="color: #999;">' . __('غير محدد', 'mohtawa') . '</span>';
            }
            break;
            
        case 'store_location':
            $locations = get_the_terms($post_id, 'store_location');
            if ($locations && !is_wp_error($locations)) {
                $location_names = array();
                foreach ($locations as $location) {
                    $location_names[] = esc_html($location->name);
                }
                echo implode(', ', $location_names);
            } else {
                echo '<span style="color: #999;">' . __('غير محدد', 'mohtawa') . '</span>';
            }
            break;
            
        case 'store_rating':
            $rating = get_post_meta($post_id, 'store_rating', true);
            if ($rating) {
                $stars = str_repeat('★', intval($rating)) . str_repeat('☆', 5 - intval($rating));
                echo '<span style="color: #ffc107;">' . $stars . '</span> (' . $rating . ')';
            } else {
                echo '<span style="color: #999;">' . __('لا يوجد تقييم', 'mohtawa') . '</span>';
            }
            break;
            
        case 'store_status':
            $is_open = get_post_meta($post_id, 'store_is_open', true);
            if ($is_open === '1') {
                echo '<span style="color: #28a745; font-weight: bold;">● ' . __('مفتوح', 'mohtawa') . '</span>';
            } elseif ($is_open === '0') {
                echo '<span style="color: #dc3545; font-weight: bold;">● ' . __('مغلق', 'mohtawa') . '</span>';
            } else {
                echo '<span style="color: #999;">' . __('غير محدد', 'mohtawa') . '</span>';
            }
            break;
    }
}
add_action('manage_store_posts_custom_column', 'mohtawa_store_admin_column_content', 10, 2);

/**
 * جعل الأعمدة المخصصة قابلة للترتيب
 */
function mohtawa_store_sortable_columns($columns) {
    $columns['store_rating'] = 'store_rating';
    $columns['store_status'] = 'store_is_open';
    return $columns;
}
add_filter('manage_edit-store_sortable_columns', 'mohtawa_store_sortable_columns');

/**
 * تخصيص استعلام الترتيب للأعمدة المخصصة
 */
function mohtawa_store_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'store_rating') {
        $query->set('meta_key', 'store_rating');
        $query->set('orderby', 'meta_value_num');
    } elseif ($orderby === 'store_is_open') {
        $query->set('meta_key', 'store_is_open');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'mohtawa_store_orderby');

/**
 * إضافة فلاتر للمتاجر في لوحة الإدارة
 */
function mohtawa_store_admin_filters() {
    global $typenow;

    if ($typenow === 'store') {
        // فلتر حسب نوع المتجر
        $selected_category = isset($_GET['store_category']) ? $_GET['store_category'] : '';
        $categories = get_terms(array(
            'taxonomy' => 'store_category',
            'hide_empty' => false,
        ));

        if ($categories) {
            echo '<select name="store_category">';
            echo '<option value="">' . __('جميع الأنواع', 'mohtawa') . '</option>';
            foreach ($categories as $category) {
                printf(
                    '<option value="%s"%s>%s</option>',
                    $category->slug,
                    selected($selected_category, $category->slug, false),
                    $category->name
                );
            }
            echo '</select>';
        }

        // فلتر حسب الموقع
        $selected_location = isset($_GET['store_location']) ? $_GET['store_location'] : '';
        $locations = get_terms(array(
            'taxonomy' => 'store_location',
            'hide_empty' => false,
            'parent' => 0, // المدن الرئيسية فقط
        ));

        if ($locations) {
            echo '<select name="store_location">';
            echo '<option value="">' . __('جميع المواقع', 'mohtawa') . '</option>';
            foreach ($locations as $location) {
                printf(
                    '<option value="%s"%s>%s</option>',
                    $location->slug,
                    selected($selected_location, $location->slug, false),
                    $location->name
                );
            }
            echo '</select>';
        }

        // فلتر حسب حالة المتجر
        $selected_status = isset($_GET['store_status']) ? $_GET['store_status'] : '';
        echo '<select name="store_status">';
        echo '<option value="">' . __('جميع الحالات', 'mohtawa') . '</option>';
        echo '<option value="open"' . selected($selected_status, 'open', false) . '>' . __('مفتوح', 'mohtawa') . '</option>';
        echo '<option value="closed"' . selected($selected_status, 'closed', false) . '>' . __('مغلق', 'mohtawa') . '</option>';
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'mohtawa_store_admin_filters');

/**
 * تطبيق الفلاتر على استعلام المتاجر
 */
function mohtawa_store_admin_filter_query($query) {
    global $pagenow, $typenow;

    if ($pagenow === 'edit.php' && $typenow === 'store') {
        // فلتر حسب نوع المتجر
        if (!empty($_GET['store_category'])) {
            $query->query_vars['tax_query'] = array(
                array(
                    'taxonomy' => 'store_category',
                    'field' => 'slug',
                    'terms' => $_GET['store_category']
                )
            );
        }

        // فلتر حسب الموقع
        if (!empty($_GET['store_location'])) {
            $tax_query = isset($query->query_vars['tax_query']) ? $query->query_vars['tax_query'] : array();
            $tax_query[] = array(
                'taxonomy' => 'store_location',
                'field' => 'slug',
                'terms' => $_GET['store_location']
            );
            $query->query_vars['tax_query'] = $tax_query;
        }

        // فلتر حسب حالة المتجر
        if (!empty($_GET['store_status'])) {
            $meta_value = $_GET['store_status'] === 'open' ? '1' : '0';
            $query->query_vars['meta_query'] = array(
                array(
                    'key' => 'store_is_open',
                    'value' => $meta_value,
                    'compare' => '='
                )
            );
        }
    }
}
add_filter('parse_query', 'mohtawa_store_admin_filter_query');

/**
 * تخصيص رسائل التحديث للمتاجر
 */
function mohtawa_store_updated_messages($messages) {
    $post = get_post();
    $post_type = get_post_type($post);
    $post_type_object = get_post_type_object($post_type);

    $messages['store'] = array(
        0  => '', // غير مستخدم
        1  => __('تم تحديث المتجر.', 'mohtawa'),
        2  => __('تم تحديث الحقل المخصص.', 'mohtawa'),
        3  => __('تم حذف الحقل المخصص.', 'mohtawa'),
        4  => __('تم تحديث المتجر.', 'mohtawa'),
        5  => isset($_GET['revision']) ? sprintf(__('تم استعادة المتجر من المراجعة المؤرخة %s', 'mohtawa'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6  => __('تم نشر المتجر.', 'mohtawa'),
        7  => __('تم حفظ المتجر.', 'mohtawa'),
        8  => __('تم إرسال المتجر للمراجعة.', 'mohtawa'),
        9  => sprintf(
            __('تم جدولة المتجر للنشر في: <strong>%1$s</strong>.', 'mohtawa'),
            date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date))
        ),
        10 => __('تم تحديث مسودة المتجر.', 'mohtawa')
    );

    $messages['news'] = array(
        0  => '', // غير مستخدم
        1  => __('تم تحديث الخبر.', 'mohtawa'),
        2  => __('تم تحديث الحقل المخصص.', 'mohtawa'),
        3  => __('تم حذف الحقل المخصص.', 'mohtawa'),
        4  => __('تم تحديث الخبر.', 'mohtawa'),
        5  => isset($_GET['revision']) ? sprintf(__('تم استعادة الخبر من المراجعة المؤرخة %s', 'mohtawa'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6  => __('تم نشر الخبر.', 'mohtawa'),
        7  => __('تم حفظ الخبر.', 'mohtawa'),
        8  => __('تم إرسال الخبر للمراجعة.', 'mohtawa'),
        9  => sprintf(
            __('تم جدولة الخبر للنشر في: <strong>%1$s</strong>.', 'mohtawa'),
            date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date))
        ),
        10 => __('تم تحديث مسودة الخبر.', 'mohtawa')
    );

    return $messages;
}
add_filter('post_updated_messages', 'mohtawa_store_updated_messages');

/**
 * إضافة دعم للبحث في الحقول المخصصة
 */
function mohtawa_search_custom_fields($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('meta_query', array(
            'relation' => 'OR',
            array(
                'key' => 'store_address',
                'value' => $query->get('s'),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'store_phone',
                'value' => $query->get('s'),
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'store_description',
                'value' => $query->get('s'),
                'compare' => 'LIKE'
            )
        ));
    }
}
add_action('pre_get_posts', 'mohtawa_search_custom_fields');

/**
 * تحديث عدد المشاهدات للمتاجر
 */
function mohtawa_update_store_views($post_id) {
    if (get_post_type($post_id) === 'store') {
        $views = get_post_meta($post_id, 'store_views', true);
        $views = $views ? intval($views) + 1 : 1;
        update_post_meta($post_id, 'store_views', $views);
    }
}
add_action('wp_head', function() {
    if (is_singular('store')) {
        mohtawa_update_store_views(get_the_ID());
    }
});

/**
 * إضافة دعم للتصدير والاستيراد
 */
function mohtawa_export_stores() {
    $stores = get_posts(array(
        'post_type' => 'store',
        'posts_per_page' => -1,
        'post_status' => 'any'
    ));

    $export_data = array();
    
    foreach ($stores as $store) {
        $store_data = array(
            'title' => $store->post_title,
            'content' => $store->post_content,
            'excerpt' => $store->post_excerpt,
            'status' => $store->post_status,
            'meta' => get_post_meta($store->ID),
            'categories' => wp_get_post_terms($store->ID, 'store_category', array('fields' => 'slugs')),
            'locations' => wp_get_post_terms($store->ID, 'store_location', array('fields' => 'slugs')),
            'featured_image' => get_post_thumbnail_id($store->ID)
        );
        
        $export_data[] = $store_data;
    }

    return json_encode($export_data, JSON_UNESCAPED_UNICODE);
}

/**
 * تحديث قواعد إعادة الكتابة للمتاجر
 */
function mohtawa_rewrite_rules() {
    add_rewrite_rule(
        '^stores/([^/]*)/page/?([0-9]{1,})/?$',
        'index.php?post_type=store&store_category=$matches[1]&paged=$matches[2]',
        'top'
    );
    
    add_rewrite_rule(
        '^stores/([^/]*)/?$',
        'index.php?post_type=store&store_category=$matches[1]',
        'top'
    );
    
    add_rewrite_rule(
        '^location/([^/]*)/page/?([0-9]{1,})/?$',
        'index.php?post_type=store&store_location=$matches[1]&paged=$matches[2]',
        'top'
    );
    
    add_rewrite_rule(
        '^location/([^/]*)/?$',
        'index.php?post_type=store&store_location=$matches[1]',
        'top'
    );
}
add_action('init', 'mohtawa_rewrite_rules');

/**
 * إضافة متغيرات الاستعلام المخصصة
 */
function mohtawa_query_vars($vars) {
    $vars[] = 'store_category';
    $vars[] = 'store_location';
    $vars[] = 'store_rating';
    $vars[] = 'store_distance';
    return $vars;
}
add_filter('query_vars', 'mohtawa_query_vars');

/**
 * تحديث قواعد إعادة الكتابة عند تفعيل القالب
 */
function mohtawa_flush_rewrite_rules() {
    mohtawa_register_store_post_type();
    mohtawa_register_news_post_type();
    mohtawa_register_store_category_taxonomy();
    mohtawa_register_store_location_taxonomy();
    mohtawa_register_news_category_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'mohtawa_flush_rewrite_rules');

/**
 * نهاية ملف post-types.php
 */

