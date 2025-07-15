<?php
/**
 * تحسين محركات البحث والسيو المحلي لقالب محتوى
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// منع الوصول المباشر
if (!defined('ABSPATH')) {
    exit;
}

/**
 * إضافة Meta Tags للسيو
 */
function mohtawa_add_meta_tags() {
    global $post;
    
    // Meta Description
    $meta_description = '';
    if (is_single() && $post->post_type === 'store') {
        $store_address = get_post_meta($post->ID, 'store_address', true);
        $store_category = get_the_terms($post->ID, 'store_category');
        $category_name = $store_category && !is_wp_error($store_category) ? $store_category[0]->name : '';
        
        $meta_description = sprintf(
            __('%s - %s في %s. اكتشف المزيد من التفاصيل والمعلومات والتقييمات.', 'mohtawa'),
            get_the_title(),
            $category_name,
            $store_address
        );
    } elseif (is_home() || is_front_page()) {
        $meta_description = get_bloginfo('description') ?: __('اكتشف أفضل المتاجر والخدمات في منطقتك مع خريطة تفاعلية شاملة', 'mohtawa');
    } elseif (is_category() || is_tax()) {
        $term = get_queried_object();
        $meta_description = $term->description ?: sprintf(__('اكتشف جميع المتاجر في فئة %s', 'mohtawa'), $term->name);
    }
    
    if ($meta_description) {
        echo '<meta name="description" content="' . esc_attr(wp_trim_words($meta_description, 25)) . '">' . "\n";
    }
    
    // Open Graph Tags
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta property="og:locale" content="ar_SA">' . "\n";
    
    if (is_single() && $post->post_type === 'store') {
        echo '<meta property="og:type" content="business.business">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($meta_description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        
        $featured_image = get_the_post_thumbnail_url($post->ID, 'large');
        if ($featured_image) {
            echo '<meta property="og:image" content="' . esc_url($featured_image) . '">' . "\n";
        }
        
        // Business-specific Open Graph
        $store_address = get_post_meta($post->ID, 'store_address', true);
        $store_phone = get_post_meta($post->ID, 'store_phone', true);
        $store_latitude = get_post_meta($post->ID, 'store_latitude', true);
        $store_longitude = get_post_meta($post->ID, 'store_longitude', true);
        
        if ($store_address) {
            echo '<meta property="business:contact_data:street_address" content="' . esc_attr($store_address) . '">' . "\n";
        }
        if ($store_phone) {
            echo '<meta property="business:contact_data:phone_number" content="' . esc_attr($store_phone) . '">' . "\n";
        }
        if ($store_latitude && $store_longitude) {
            echo '<meta property="place:location:latitude" content="' . esc_attr($store_latitude) . '">' . "\n";
            echo '<meta property="place:location:longitude" content="' . esc_attr($store_longitude) . '">' . "\n";
        }
    } else {
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($meta_description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
    }
    
    // Twitter Card Tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '">' . "\n";
    
    // Canonical URL
    echo '<link rel="canonical" href="' . esc_url(get_permalink()) . '">' . "\n";
    
    // Geo Tags for local SEO
    if (is_single() && $post->post_type === 'store') {
        $store_latitude = get_post_meta($post->ID, 'store_latitude', true);
        $store_longitude = get_post_meta($post->ID, 'store_longitude', true);
        
        if ($store_latitude && $store_longitude) {
            echo '<meta name="geo.position" content="' . esc_attr($store_latitude . ';' . $store_longitude) . '">' . "\n";
            echo '<meta name="geo.placename" content="' . esc_attr(get_the_title()) . '">' . "\n";
            echo '<meta name="ICBM" content="' . esc_attr($store_latitude . ', ' . $store_longitude) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'mohtawa_add_meta_tags', 1);

/**
 * إضافة Schema Markup للمتاجر المحلية
 */
function mohtawa_add_local_business_schema() {
    global $post;
    
    if (!is_single() || $post->post_type !== 'store') {
        return;
    }
    
    // جمع بيانات المتجر
    $store_name = get_the_title();
    $store_description = get_the_excerpt() ?: wp_trim_words(get_the_content(), 25);
    $store_address = get_post_meta($post->ID, 'store_address', true);
    $store_phone = get_post_meta($post->ID, 'store_phone', true);
    $store_email = get_post_meta($post->ID, 'store_email', true);
    $store_website = get_post_meta($post->ID, 'store_website', true);
    $store_latitude = get_post_meta($post->ID, 'store_latitude', true);
    $store_longitude = get_post_meta($post->ID, 'store_longitude', true);
    $store_rating = get_post_meta($post->ID, 'store_rating', true);
    $store_hours = get_post_meta($post->ID, 'store_hours', true);
    $store_services = get_post_meta($post->ID, 'store_services', true);
    $featured_image = get_the_post_thumbnail_url($post->ID, 'large');
    
    // تحديد نوع العمل
    $business_type = 'LocalBusiness';
    $categories = get_the_terms($post->ID, 'store_category');
    if ($categories && !is_wp_error($categories)) {
        $category_name = strtolower($categories[0]->name);
        
        // تحديد نوع العمل بناءً على الفئة
        $business_types = array(
            'مطعم' => 'Restaurant',
            'مقهى' => 'CafeOrCoffeeShop',
            'متجر' => 'Store',
            'صيدلية' => 'Pharmacy',
            'مستشفى' => 'Hospital',
            'بنك' => 'BankOrCreditUnion',
            'محطة وقود' => 'GasStation',
            'فندق' => 'LodgingBusiness',
            'صالون' => 'BeautySalon',
            'رياضة' => 'SportsActivityLocation'
        );
        
        foreach ($business_types as $arabic => $english) {
            if (strpos($category_name, $arabic) !== false) {
                $business_type = $english;
                break;
            }
        }
    }
    
    // بناء Schema Markup
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => $business_type,
        'name' => $store_name,
        'description' => $store_description,
        'url' => get_permalink(),
        '@id' => get_permalink() . '#business'
    );
    
    // إضافة الصورة
    if ($featured_image) {
        $schema['image'] = array(
            '@type' => 'ImageObject',
            'url' => $featured_image,
            'width' => 1200,
            'height' => 630
        );
    }
    
    // إضافة العنوان
    if ($store_address) {
        $schema['address'] = array(
            '@type' => 'PostalAddress',
            'streetAddress' => $store_address,
            'addressCountry' => 'SA',
            'addressLocality' => 'المملكة العربية السعودية'
        );
    }
    
    // إضافة الإحداثيات الجغرافية
    if ($store_latitude && $store_longitude) {
        $schema['geo'] = array(
            '@type' => 'GeoCoordinates',
            'latitude' => floatval($store_latitude),
            'longitude' => floatval($store_longitude)
        );
    }
    
    // إضافة معلومات الاتصال
    if ($store_phone || $store_email) {
        $contact_point = array(
            '@type' => 'ContactPoint',
            'contactType' => 'customer service'
        );
        
        if ($store_phone) {
            $contact_point['telephone'] = $store_phone;
        }
        
        if ($store_email) {
            $contact_point['email'] = $store_email;
        }
        
        $schema['contactPoint'] = $contact_point;
    }
    
    // إضافة ساعات العمل
    if ($store_hours && is_array($store_hours)) {
        $opening_hours = array();
        $days_map = array(
            'monday' => 'Mo',
            'tuesday' => 'Tu',
            'wednesday' => 'We',
            'thursday' => 'Th',
            'friday' => 'Fr',
            'saturday' => 'Sa',
            'sunday' => 'Su'
        );
        
        foreach ($store_hours as $day => $hours) {
            if (!empty($hours['open']) && !empty($hours['close']) && isset($days_map[$day])) {
                $opening_hours[] = $days_map[$day] . ' ' . $hours['open'] . '-' . $hours['close'];
            }
        }
        
        if (!empty($opening_hours)) {
            $schema['openingHours'] = $opening_hours;
        }
    }
    
    // إضافة التقييم
    if ($store_rating) {
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => floatval($store_rating),
            'bestRating' => 5,
            'worstRating' => 1,
            'ratingCount' => 1
        );
    }
    
    // إضافة الخدمات المتاحة
    if ($store_services && is_array($store_services)) {
        $services = array();
        foreach ($store_services as $service => $enabled) {
            if ($enabled) {
                $services[] = $service;
            }
        }
        
        if (!empty($services)) {
            $schema['hasOfferCatalog'] = array(
                '@type' => 'OfferCatalog',
                'name' => 'الخدمات المتاحة',
                'itemListElement' => array_map(function($service) {
                    return array(
                        '@type' => 'Offer',
                        'itemOffered' => array(
                            '@type' => 'Service',
                            'name' => $service
                        )
                    );
                }, $services)
            );
        }
    }
    
    // إضافة الموقع الإلكتروني
    if ($store_website) {
        $schema['sameAs'] = array($store_website);
    }
    
    // إضافة معرف المكان
    $schema['identifier'] = array(
        '@type' => 'PropertyValue',
        'name' => 'Store ID',
        'value' => $post->ID
    );
    
    // طباعة Schema Markup
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}
add_action('wp_head', 'mohtawa_add_local_business_schema', 5);

/**
 * إضافة Schema Markup للموقع الرئيسي
 */
function mohtawa_add_website_schema() {
    if (!is_home() && !is_front_page()) {
        return;
    }
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url(),
        '@id' => home_url() . '#website',
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}')
            ),
            'query-input' => 'required name=search_term_string'
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url(),
            '@id' => home_url() . '#organization'
        )
    );
    
    // إضافة الشعار
    $logo = get_theme_mod('mohtawa_logo', '');
    if ($logo) {
        $schema['publisher']['logo'] = array(
            '@type' => 'ImageObject',
            'url' => $logo,
            'width' => 200,
            'height' => 60
        );
    }
    
    // إضافة معلومات الاتصال
    $phone = get_theme_mod('mohtawa_phone_number', '');
    $email = get_theme_mod('mohtawa_email_address', '');
    $address = get_theme_mod('mohtawa_address', '');
    
    if ($phone || $email || $address) {
        $contact_point = array(
            '@type' => 'ContactPoint',
            'contactType' => 'customer service'
        );
        
        if ($phone) {
            $contact_point['telephone'] = $phone;
        }
        
        if ($email) {
            $contact_point['email'] = $email;
        }
        
        $schema['publisher']['contactPoint'] = $contact_point;
        
        if ($address) {
            $schema['publisher']['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressCountry' => 'SA'
            );
        }
    }
    
    // إضافة وسائل التواصل الاجتماعي
    $social_links = array();
    $social_platforms = array(
        'mohtawa_facebook_url',
        'mohtawa_twitter_url',
        'mohtawa_instagram_url',
        'mohtawa_linkedin_url',
        'mohtawa_youtube_url'
    );
    
    foreach ($social_platforms as $platform) {
        $url = get_theme_mod($platform, '');
        if ($url) {
            $social_links[] = $url;
        }
    }
    
    if (!empty($social_links)) {
        $schema['publisher']['sameAs'] = $social_links;
    }
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}
add_action('wp_head', 'mohtawa_add_website_schema', 5);

/**
 * إضافة Schema Markup لقائمة المتاجر
 */
function mohtawa_add_itemlist_schema() {
    if (!is_post_type_archive('store') && !is_tax('store_category') && !is_tax('store_location')) {
        return;
    }
    
    global $wp_query;
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'numberOfItems' => $wp_query->found_posts,
        'itemListElement' => array()
    );
    
    if (is_tax()) {
        $term = get_queried_object();
        $schema['name'] = $term->name;
        $schema['description'] = $term->description;
    } else {
        $schema['name'] = __('دليل المتاجر', 'mohtawa');
        $schema['description'] = __('دليل شامل للمتاجر والخدمات المحلية', 'mohtawa');
    }
    
    $position = 1;
    while (have_posts()) {
        the_post();
        global $post;
        
        $item = array(
            '@type' => 'ListItem',
            'position' => $position,
            'item' => array(
                '@type' => 'LocalBusiness',
                'name' => get_the_title(),
                'url' => get_permalink(),
                '@id' => get_permalink() . '#business'
            )
        );
        
        $store_address = get_post_meta($post->ID, 'store_address', true);
        if ($store_address) {
            $item['item']['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $store_address,
                'addressCountry' => 'SA'
            );
        }
        
        $store_rating = get_post_meta($post->ID, 'store_rating', true);
        if ($store_rating) {
            $item['item']['aggregateRating'] = array(
                '@type' => 'AggregateRating',
                'ratingValue' => floatval($store_rating),
                'bestRating' => 5
            );
        }
        
        $schema['itemListElement'][] = $item;
        $position++;
    }
    
    wp_reset_postdata();
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}
add_action('wp_head', 'mohtawa_add_itemlist_schema', 5);

/**
 * تحسين عناوين الصفحات للسيو
 */
function mohtawa_custom_document_title($title) {
    global $post;
    
    if (is_single() && $post->post_type === 'store') {
        $store_address = get_post_meta($post->ID, 'store_address', true);
        $store_category = get_the_terms($post->ID, 'store_category');
        $category_name = $store_category && !is_wp_error($store_category) ? $store_category[0]->name : '';
        
        $custom_title = get_the_title();
        
        if ($category_name) {
            $custom_title .= ' - ' . $category_name;
        }
        
        if ($store_address) {
            $custom_title .= ' في ' . $store_address;
        }
        
        $custom_title .= ' | ' . get_bloginfo('name');
        
        return $custom_title;
    }
    
    if (is_tax('store_category')) {
        $term = get_queried_object();
        return $term->name . ' - دليل المتاجر | ' . get_bloginfo('name');
    }
    
    if (is_tax('store_location')) {
        $term = get_queried_object();
        return 'متاجر ' . $term->name . ' | ' . get_bloginfo('name');
    }
    
    if (is_post_type_archive('store')) {
        return 'دليل المتاجر | ' . get_bloginfo('name');
    }
    
    return $title;
}
add_filter('pre_get_document_title', 'mohtawa_custom_document_title');

/**
 * إضافة Sitemap XML للمتاجر
 */
function mohtawa_add_stores_to_sitemap($provider, $name) {
    if ('posts' !== $name) {
        return $provider;
    }
    
    $provider->add_sitemap('stores', array(
        'loc' => home_url('/wp-sitemap-stores.xml'),
        'lastmod' => get_lastpostmodified('gmt', 'store')
    ));
    
    return $provider;
}
add_filter('wp_sitemaps_add_provider', 'mohtawa_add_stores_to_sitemap', 10, 2);

/**
 * تحسين URLs للمتاجر
 */
function mohtawa_store_permalink_structure($post_link, $post) {
    if ($post->post_type !== 'store') {
        return $post_link;
    }
    
    // إضافة فئة المتجر إلى الرابط
    $categories = get_the_terms($post->ID, 'store_category');
    if ($categories && !is_wp_error($categories)) {
        $category = $categories[0];
        $post_link = str_replace('%store_category%', $category->slug, $post_link);
    } else {
        $post_link = str_replace('%store_category%/', '', $post_link);
    }
    
    return $post_link;
}
add_filter('post_type_link', 'mohtawa_store_permalink_structure', 10, 2);

/**
 * إضافة Breadcrumbs للسيو
 */
function mohtawa_breadcrumbs() {
    if (is_home() || is_front_page()) {
        return;
    }
    
    $breadcrumbs = array();
    $breadcrumbs[] = array(
        'title' => __('الرئيسية', 'mohtawa'),
        'url' => home_url()
    );
    
    if (is_single() && get_post_type() === 'store') {
        global $post;
        
        $breadcrumbs[] = array(
            'title' => __('دليل المتاجر', 'mohtawa'),
            'url' => get_post_type_archive_link('store')
        );
        
        $categories = get_the_terms($post->ID, 'store_category');
        if ($categories && !is_wp_error($categories)) {
            $category = $categories[0];
            $breadcrumbs[] = array(
                'title' => $category->name,
                'url' => get_term_link($category)
            );
        }
        
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => ''
        );
    } elseif (is_post_type_archive('store')) {
        $breadcrumbs[] = array(
            'title' => __('دليل المتاجر', 'mohtawa'),
            'url' => ''
        );
    } elseif (is_tax()) {
        $term = get_queried_object();
        $breadcrumbs[] = array(
            'title' => __('دليل المتاجر', 'mohtawa'),
            'url' => get_post_type_archive_link('store')
        );
        $breadcrumbs[] = array(
            'title' => $term->name,
            'url' => ''
        );
    }
    
    if (count($breadcrumbs) > 1) {
        echo '<nav class="breadcrumbs" aria-label="' . __('مسار التنقل', 'mohtawa') . '">';
        echo '<ol class="breadcrumb-list">';
        
        foreach ($breadcrumbs as $index => $crumb) {
            echo '<li class="breadcrumb-item">';
            
            if (!empty($crumb['url'])) {
                echo '<a href="' . esc_url($crumb['url']) . '">' . esc_html($crumb['title']) . '</a>';
            } else {
                echo '<span>' . esc_html($crumb['title']) . '</span>';
            }
            
            if ($index < count($breadcrumbs) - 1) {
                echo '<span class="breadcrumb-separator"> / </span>';
            }
            
            echo '</li>';
        }
        
        echo '</ol>';
        echo '</nav>';
        
        // إضافة Schema Markup للـ Breadcrumbs
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array()
        );
        
        foreach ($breadcrumbs as $index => $crumb) {
            $schema['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $crumb['title'],
                'item' => !empty($crumb['url']) ? $crumb['url'] : null
            );
        }
        
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE);
        echo "\n" . '</script>' . "\n";
    }
}

/**
 * تحسين الصور للسيو
 */
function mohtawa_optimize_images_for_seo($attr, $attachment, $size) {
    $alt_text = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
    
    if (empty($alt_text)) {
        // إنشاء alt text تلقائي بناءً على اسم الملف
        $alt_text = pathinfo($attachment->post_title, PATHINFO_FILENAME);
        $alt_text = str_replace(array('-', '_'), ' ', $alt_text);
        $alt_text = ucwords($alt_text);
    }
    
    $attr['alt'] = $alt_text;
    $attr['title'] = $attachment->post_title;
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'mohtawa_optimize_images_for_seo', 10, 3);

/**
 * إضافة robots.txt مخصص
 */
function mohtawa_custom_robots_txt($output) {
    $custom_rules = "
# قواعد مخصصة لقالب محتوى
User-agent: *
Allow: /wp-content/uploads/
Disallow: /wp-admin/
Disallow: /wp-includes/
Disallow: /wp-content/plugins/
Disallow: /wp-content/themes/
Disallow: /trackback/
Disallow: /feed/
Disallow: /comments/
Disallow: /category/*/*
Disallow: */trackback/
Disallow: */feed/
Disallow: */comments/
Disallow: /*?*
Disallow: /*?

# Sitemap
Sitemap: " . home_url('/sitemap.xml') . "
Sitemap: " . home_url('/wp-sitemap.xml') . "
";
    
    return $output . $custom_rules;
}
add_filter('robots_txt', 'mohtawa_custom_robots_txt');

/**
 * تحسين سرعة التحميل للسيو
 */
function mohtawa_optimize_loading_speed() {
    // إزالة الإصدارات من CSS و JS
    add_filter('style_loader_src', 'mohtawa_remove_version_strings');
    add_filter('script_loader_src', 'mohtawa_remove_version_strings');
    
    // تفعيل ضغط GZIP
    if (!ob_get_level()) {
        ob_start('ob_gzhandler');
    }
    
    // إضافة Cache Headers
    if (!is_admin()) {
        header('Cache-Control: public, max-age=31536000');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    }
}
add_action('init', 'mohtawa_optimize_loading_speed');

/**
 * إزالة أرقام الإصدارات من الملفات
 */
function mohtawa_remove_version_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

/**
 * تحسين قاعدة البيانات للسيو
 */
function mohtawa_optimize_database_queries() {
    // تحسين استعلامات المتاجر
    add_action('pre_get_posts', function($query) {
        if (!is_admin() && $query->is_main_query()) {
            if (is_post_type_archive('store') || is_tax('store_category') || is_tax('store_location')) {
                $query->set('posts_per_page', 12);
                $query->set('meta_key', 'store_featured');
                $query->set('orderby', array('meta_value_num' => 'DESC', 'date' => 'DESC'));
            }
        }
    });
}
add_action('init', 'mohtawa_optimize_database_queries');

/**
 * إضافة أنماط CSS للـ Breadcrumbs
 */
function mohtawa_breadcrumbs_styles() {
    ?>
    <style>
    .breadcrumbs {
        margin: 20px 0;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .breadcrumb-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .breadcrumb-item {
        display: flex;
        align-items: center;
    }
    
    .breadcrumb-item a {
        color: #0073aa;
        text-decoration: none;
        font-size: 14px;
    }
    
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    
    .breadcrumb-item span {
        font-size: 14px;
        color: #666;
    }
    
    .breadcrumb-separator {
        margin: 0 8px;
        color: #999;
    }
    
    @media (max-width: 768px) {
        .breadcrumb-list {
            font-size: 12px;
        }
        
        .breadcrumb-separator {
            margin: 0 4px;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'mohtawa_breadcrumbs_styles');

