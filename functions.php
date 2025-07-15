<?php
/**
 * محتوى - قالب خريطة المتاجر التفاعلية
 * ملف الوظائف الرئيسي
 *
 * @package Mohtawa
 * @version 1.0.0
 * @author Manus AI
 * @link https://manus.ai
 */

// منع الوصول المباشر للملف
if (!defined('ABSPATH')) {
    exit;
}

// تعريف الثوابت الأساسية للقالب
define('MOHTAWA_VERSION', '1.0.0');
define('MOHTAWA_THEME_DIR', get_template_directory());
define('MOHTAWA_THEME_URL', get_template_directory_uri());
define('MOHTAWA_ASSETS_URL', MOHTAWA_THEME_URL . '/assets');
define('MOHTAWA_INC_DIR', MOHTAWA_THEME_DIR . '/inc');

/**
 * إعداد القالب الأساسي
 */
function mohtawa_setup() {
    // دعم اللغات المتعددة
    load_theme_textdomain('mohtawa', get_template_directory() . '/languages');

    // دعم العناوين التلقائية
    add_theme_support('title-tag');

    // دعم الصور المميزة
    add_theme_support('post-thumbnails');

    // دعم HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // دعم تخصيص الشعار
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // دعم تخصيص الخلفية
    add_theme_support('custom-background', array(
        'default-color' => 'f8f9fa',
        'default-image' => '',
    ));

    // دعم تخصيص الألوان
    add_theme_support('custom-header', array(
        'default-text-color' => '333333',
        'width'              => 1200,
        'height'             => 300,
        'flex-height'        => true,
        'flex-width'         => true,
    ));

    // دعم تحديث المحتوى التلقائي
    add_theme_support('automatic-feed-links');

    // دعم تنسيقات المقالات
    add_theme_support('post-formats', array(
        'aside',
        'gallery',
        'link',
        'image',
        'quote',
        'status',
        'video',
        'audio',
        'chat'
    ));

    // دعم محرر الكتل (Gutenberg)
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // دعم الألوان المخصصة في محرر الكتل
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('الأزرق الأساسي', 'mohtawa'),
            'slug'  => 'primary-blue',
            'color' => '#3498db',
        ),
        array(
            'name'  => __('الأخضر الثانوي', 'mohtawa'),
            'slug'  => 'secondary-green',
            'color' => '#27ae60',
        ),
        array(
            'name'  => __('الأحمر التحذيري', 'mohtawa'),
            'slug'  => 'danger-red',
            'color' => '#e74c3c',
        ),
        array(
            'name'  => __('الرمادي الفاتح', 'mohtawa'),
            'slug'  => 'light-gray',
            'color' => '#f8f9fa',
        ),
        array(
            'name'  => __('الرمادي الداكن', 'mohtawa'),
            'slug'  => 'dark-gray',
            'color' => '#343a40',
        ),
    ));

    // تسجيل القوائم
    register_nav_menus(array(
        'primary'   => __('القائمة الرئيسية', 'mohtawa'),
        'footer'    => __('قائمة التذييل', 'mohtawa'),
        'mobile'    => __('قائمة الأجهزة المحمولة', 'mohtawa'),
        'social'    => __('قائمة وسائل التواصل', 'mohtawa'),
    ));

    // أحجام الصور المخصصة
    add_image_size('store-thumbnail', 300, 200, true);
    add_image_size('store-medium', 600, 400, true);
    add_image_size('store-large', 1200, 800, true);
    add_image_size('store-gallery', 800, 600, true);
    add_image_size('news-thumbnail', 150, 100, true);
    add_image_size('hero-banner', 1920, 1080, true);
}
add_action('after_setup_theme', 'mohtawa_setup');

/**
 * تسجيل وتحميل الأنماط والسكريبتات
 */
function mohtawa_scripts() {
    // تحميل الأنماط الأساسية
    wp_enqueue_style('mohtawa-style', get_stylesheet_uri(), array(), MOHTAWA_VERSION);
    wp_enqueue_style('mohtawa-main', MOHTAWA_ASSETS_URL . '/css/main.css', array('mohtawa-style'), MOHTAWA_VERSION);
    
    // تحميل Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // تحميل مكتبة Leaflet للخرائط
    wp_enqueue_style('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4');
    wp_enqueue_style('leaflet-markercluster', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css', array('leaflet'), '1.4.1');
    wp_enqueue_style('leaflet-markercluster-default', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css', array('leaflet-markercluster'), '1.4.1');
    wp_enqueue_style('leaflet-routing', 'https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css', array('leaflet'), '3.2.12');

    // تحميل السكريبتات الأساسية
    wp_enqueue_script('mohtawa-main', MOHTAWA_ASSETS_URL . '/js/main.js', array('jquery'), MOHTAWA_VERSION, true);
    
    // تحميل مكتبة Leaflet
    wp_enqueue_script('leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true);
    wp_enqueue_script('leaflet-markercluster', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', array('leaflet'), '1.4.1', true);
    wp_enqueue_script('leaflet-routing', 'https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js', array('leaflet'), '3.2.12', true);
    
    // تحميل سكريبت الخرائط المخصص
    wp_enqueue_script('mohtawa-map', MOHTAWA_ASSETS_URL . '/js/map.js', array('leaflet', 'leaflet-markercluster', 'leaflet-routing'), MOHTAWA_VERSION, true);

    // تمرير البيانات للسكريبتات
    wp_localize_script('mohtawa-main', 'mohtawa_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('mohtawa_nonce'),
        'strings'  => array(
            'loading'           => __('جاري التحميل...', 'mohtawa'),
            'error'            => __('حدث خطأ، يرجى المحاولة مرة أخرى', 'mohtawa'),
            'no_results'       => __('لا توجد نتائج', 'mohtawa'),
            'location_error'   => __('لم نتمكن من تحديد موقعك', 'mohtawa'),
            'confirm_delete'   => __('هل أنت متأكد من الحذف؟', 'mohtawa'),
        ),
    ));

    // تحميل سكريبت التعليقات إذا لزم الأمر
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // تحميل أنماط الاستجابة
    wp_enqueue_style('mohtawa-responsive', MOHTAWA_ASSETS_URL . '/css/responsive.css', array('mohtawa-main'), MOHTAWA_VERSION);

    // تحميل أنماط الطباعة
    wp_enqueue_style('mohtawa-print', MOHTAWA_ASSETS_URL . '/css/print.css', array('mohtawa-main'), MOHTAWA_VERSION, 'print');
}
add_action('wp_enqueue_scripts', 'mohtawa_scripts');

/**
 * تسجيل أنماط وسكريبتات لوحة الإدارة
 */
function mohtawa_admin_scripts($hook) {
    // تحميل أنماط لوحة الإدارة
    wp_enqueue_style('mohtawa-admin', MOHTAWA_ASSETS_URL . '/css/admin.css', array(), MOHTAWA_VERSION);
    
    // تحميل سكريبتات لوحة الإدارة
    wp_enqueue_script('mohtawa-admin', MOHTAWA_ASSETS_URL . '/js/admin.js', array('jquery'), MOHTAWA_VERSION, true);
    
    // تحميل مكتبات إضافية لصفحات معينة
    if (in_array($hook, array('post.php', 'post-new.php'))) {
        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');
    }
}
add_action('admin_enqueue_scripts', 'mohtawa_admin_scripts');

/**
 * تسجيل مناطق الودجات
 */
function mohtawa_widgets_init() {
    // الشريط الجانبي الرئيسي
    register_sidebar(array(
        'name'          => __('الشريط الجانبي الرئيسي', 'mohtawa'),
        'id'            => 'sidebar-main',
        'description'   => __('الشريط الجانبي الرئيسي للموقع', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // شريط جانبي للمتاجر
    register_sidebar(array(
        'name'          => __('شريط جانبي المتاجر', 'mohtawa'),
        'id'            => 'sidebar-stores',
        'description'   => __('شريط جانبي خاص بصفحات المتاجر', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // تذييل الموقع - العمود الأول
    register_sidebar(array(
        'name'          => __('تذييل الموقع - العمود الأول', 'mohtawa'),
        'id'            => 'footer-1',
        'description'   => __('العمود الأول في تذييل الموقع', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // تذييل الموقع - العمود الثاني
    register_sidebar(array(
        'name'          => __('تذييل الموقع - العمود الثاني', 'mohtawa'),
        'id'            => 'footer-2',
        'description'   => __('العمود الثاني في تذييل الموقع', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // تذييل الموقع - العمود الثالث
    register_sidebar(array(
        'name'          => __('تذييل الموقع - العمود الثالث', 'mohtawa'),
        'id'            => 'footer-3',
        'description'   => __('العمود الثالث في تذييل الموقع', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // تذييل الموقع - العمود الرابع
    register_sidebar(array(
        'name'          => __('تذييل الموقع - العمود الرابع', 'mohtawa'),
        'id'            => 'footer-4',
        'description'   => __('العمود الرابع في تذييل الموقع', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));

    // منطقة قبل المحتوى
    register_sidebar(array(
        'name'          => __('قبل المحتوى', 'mohtawa'),
        'id'            => 'before-content',
        'description'   => __('منطقة تظهر قبل المحتوى الرئيسي', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // منطقة بعد المحتوى
    register_sidebar(array(
        'name'          => __('بعد المحتوى', 'mohtawa'),
        'id'            => 'after-content',
        'description'   => __('منطقة تظهر بعد المحتوى الرئيسي', 'mohtawa'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'mohtawa_widgets_init');

/**
 * تضمين الملفات المطلوبة
 */
require_once MOHTAWA_INC_DIR . '/post-types.php';      // أنواع المحتوى المخصصة
require_once MOHTAWA_INC_DIR . '/meta-boxes.php';      // الحقول المخصصة
require_once MOHTAWA_INC_DIR . '/customizer.php';      // تخصيص المظهر
require_once MOHTAWA_INC_DIR . '/admin-panel.php';     // لوحة الإدارة المخصصة
require_once MOHTAWA_INC_DIR . '/widgets.php';         // الودجات المخصصة
require_once MOHTAWA_INC_DIR . '/shortcodes.php';      // الرموز المختصرة
require_once MOHTAWA_INC_DIR . '/ajax-handlers.php';   // معالجات AJAX

/**
 * إضافة دعم RTL للغة العربية
 */
function mohtawa_rtl_support() {
    if (is_rtl()) {
        wp_enqueue_style('mohtawa-rtl', MOHTAWA_ASSETS_URL . '/css/rtl.css', array('mohtawa-style'), MOHTAWA_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'mohtawa_rtl_support');

/**
 * تخصيص طول المقتطف
 */
function mohtawa_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'mohtawa_excerpt_length');

/**
 * تخصيص نص "اقرأ المزيد"
 */
function mohtawa_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '" class="read-more">' . __('اقرأ المزيد', 'mohtawa') . '</a>';
}
add_filter('excerpt_more', 'mohtawa_excerpt_more');

/**
 * إضافة فئات CSS للجسم
 */
function mohtawa_body_classes($classes) {
    // إضافة فئة للصفحة الرئيسية
    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    // إضافة فئة للمتاجر
    if (is_singular('store') || is_post_type_archive('store')) {
        $classes[] = 'stores-page';
    }

    // إضافة فئة للأجهزة المحمولة
    if (wp_is_mobile()) {
        $classes[] = 'mobile-device';
    }

    // إضافة فئة للشريط الجانبي
    if (is_active_sidebar('sidebar-main')) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'mohtawa_body_classes');

/**
 * تخصيص عنوان الصفحة
 */
function mohtawa_document_title_parts($title) {
    if (is_front_page()) {
        $title['title'] = get_bloginfo('name');
        $title['tagline'] = get_bloginfo('description');
    }

    return $title;
}
add_filter('document_title_parts', 'mohtawa_document_title_parts');

/**
 * إضافة البيانات المنظمة (Schema.org)
 */
function mohtawa_add_schema() {
    if (is_singular('store')) {
        global $post;
        
        $store_data = array(
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => get_the_title(),
            'description' => get_the_excerpt(),
            'url' => get_permalink(),
            'image' => get_the_post_thumbnail_url($post->ID, 'large'),
        );

        // إضافة العنوان إذا كان متوفراً
        $address = get_post_meta($post->ID, 'store_address', true);
        if ($address) {
            $store_data['address'] = array(
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
            );
        }

        // إضافة رقم الهاتف إذا كان متوفراً
        $phone = get_post_meta($post->ID, 'store_phone', true);
        if ($phone) {
            $store_data['telephone'] = $phone;
        }

        // إضافة ساعات العمل إذا كانت متوفرة
        $hours = get_post_meta($post->ID, 'store_hours', true);
        if ($hours) {
            $store_data['openingHours'] = $hours;
        }

        // إضافة التقييم إذا كان متوفراً
        $rating = get_post_meta($post->ID, 'store_rating', true);
        if ($rating) {
            $store_data['aggregateRating'] = array(
                '@type' => 'AggregateRating',
                'ratingValue' => $rating,
                'bestRating' => '5',
            );
        }

        echo '<script type="application/ld+json">' . json_encode($store_data, JSON_UNESCAPED_UNICODE) . '</script>';
    }
}
add_action('wp_head', 'mohtawa_add_schema');

/**
 * تحسين الأداء - تأجيل تحميل الصور
 */
function mohtawa_lazy_load_images($content) {
    if (is_admin() || is_feed() || is_preview()) {
        return $content;
    }

    $content = preg_replace('/<img(.*?)src=/', '<img$1loading="lazy" src=', $content);
    return $content;
}
add_filter('the_content', 'mohtawa_lazy_load_images');

/**
 * إضافة أحجام الصور إلى محرر الوسائط
 */
function mohtawa_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'store-thumbnail' => __('صورة مصغرة للمتجر', 'mohtawa'),
        'store-medium' => __('صورة متوسطة للمتجر', 'mohtawa'),
        'store-large' => __('صورة كبيرة للمتجر', 'mohtawa'),
        'store-gallery' => __('صورة معرض المتجر', 'mohtawa'),
    ));
}
add_filter('image_size_names_choose', 'mohtawa_custom_image_sizes');

/**
 * تحسين الأمان - إزالة معلومات الإصدار
 */
function mohtawa_remove_version() {
    return '';
}
add_filter('the_generator', 'mohtawa_remove_version');

/**
 * تحسين الأمان - إزالة RSD link
 */
remove_action('wp_head', 'rsd_link');

/**
 * تحسين الأمان - إزالة Windows Live Writer
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * تحسين الأمان - إزالة روابط الإصدارات السابقة والتالية
 */
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

/**
 * تحسين SEO - إضافة Open Graph tags
 */
function mohtawa_add_og_tags() {
    if (is_singular()) {
        global $post;
        
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(get_the_excerpt()) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        
        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            echo '<meta property="og:image" content="' . esc_url($image[0]) . '">' . "\n";
            echo '<meta property="og:image:width" content="' . esc_attr($image[1]) . '">' . "\n";
            echo '<meta property="og:image:height" content="' . esc_attr($image[2]) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'mohtawa_add_og_tags');

/**
 * تحسين SEO - إضافة Twitter Card tags
 */
function mohtawa_add_twitter_cards() {
    if (is_singular()) {
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr(get_the_excerpt()) . '">' . "\n";
        
        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            echo '<meta name="twitter:image" content="' . esc_url($image[0]) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'mohtawa_add_twitter_cards');

/**
 * تخصيص استعلام المتاجر الرئيسي
 */
function mohtawa_modify_main_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_home()) {
            $query->set('post_type', array('post', 'store'));
        }
    }
}
add_action('pre_get_posts', 'mohtawa_modify_main_query');

/**
 * إضافة دعم للتعليقات على المتاجر
 */
function mohtawa_add_comments_support() {
    add_post_type_support('store', 'comments');
}
add_action('init', 'mohtawa_add_comments_support');

/**
 * تخصيص نموذج التعليقات
 */
function mohtawa_comment_form_defaults($defaults) {
    $defaults['comment_field'] = '<p class="comment-form-comment">
        <label for="comment">' . __('تعليقك', 'mohtawa') . ' <span class="required">*</span></label>
        <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="' . __('اكتب تعليقك هنا...', 'mohtawa') . '"></textarea>
    </p>';
    
    $defaults['submit_button'] = '<input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary" value="%4$s" />';
    
    return $defaults;
}
add_filter('comment_form_defaults', 'mohtawa_comment_form_defaults');

/**
 * تخصيص قائمة التعليقات
 */
function mohtawa_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 60, '', '', array('class' => 'avatar rounded-circle')); ?>
                    <cite class="fn"><?php comment_author_link(); ?></cite>
                </div>
                <div class="comment-metadata">
                    <time datetime="<?php comment_time('c'); ?>">
                        <?php comment_date(); ?> في <?php comment_time(); ?>
                    </time>
                    <?php edit_comment_link(__('تحرير', 'mohtawa'), '<span class="edit-link">', '</span>'); ?>
                </div>
            </div>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <div class="comment-reply">
                <?php comment_reply_link(array_merge($args, array(
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'reply_text' => __('رد', 'mohtawa')
                ))); ?>
            </div>
        </div>
    <?php
}

/**
 * إضافة دعم للبحث في المتاجر
 */
function mohtawa_search_filter($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search()) {
            $query->set('post_type', array('post', 'page', 'store'));
        }
    }
}
add_action('pre_get_posts', 'mohtawa_search_filter');

/**
 * تحسين الأداء - ضغط HTML
 */
function mohtawa_compress_html($buffer) {
    if (!is_admin()) {
        $buffer = preg_replace('/<!--(?!<!)[^\[>].*?-->/s', '', $buffer);
        $buffer = preg_replace('/\s+/', ' ', $buffer);
        $buffer = preg_replace('/>\s+</', '><', $buffer);
    }
    return $buffer;
}

if (!is_admin()) {
    ob_start('mohtawa_compress_html');
}

/**
 * إضافة دعم للترجمة التلقائية
 */
function mohtawa_load_textdomain() {
    load_theme_textdomain('mohtawa', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'mohtawa_load_textdomain');

/**
 * تخصيص رسائل الخطأ
 */
function mohtawa_custom_login_errors() {
    return __('اسم المستخدم أو كلمة المرور غير صحيحة.', 'mohtawa');
}
add_filter('login_errors', 'mohtawa_custom_login_errors');

/**
 * إضافة دعم للتحديثات التلقائية
 */
function mohtawa_enable_auto_updates($update, $item) {
    if ($item->slug === 'mohtawa') {
        return true;
    }
    return $update;
}
add_filter('auto_update_theme', 'mohtawa_enable_auto_updates', 10, 2);

/**
 * تنظيف قاعدة البيانات عند إلغاء تفعيل القالب
 */
function mohtawa_deactivation_cleanup() {
    // حذف الخيارات المؤقتة
    delete_transient('mohtawa_stores_cache');
    delete_transient('mohtawa_news_cache');
    
    // تنظيف الجدولة المؤقتة
    wp_clear_scheduled_hook('mohtawa_daily_cleanup');
}
register_deactivation_hook(__FILE__, 'mohtawa_deactivation_cleanup');

/**
 * مهمة تنظيف يومية
 */
function mohtawa_daily_cleanup() {
    // حذف البيانات المؤقتة القديمة
    delete_expired_transients();
    
    // تحسين جداول قاعدة البيانات
    global $wpdb;
    $wpdb->query("OPTIMIZE TABLE {$wpdb->posts}");
    $wpdb->query("OPTIMIZE TABLE {$wpdb->postmeta}");
}
add_action('mohtawa_daily_cleanup', 'mohtawa_daily_cleanup');

// جدولة المهمة اليومية
if (!wp_next_scheduled('mohtawa_daily_cleanup')) {
    wp_schedule_event(time(), 'daily', 'mohtawa_daily_cleanup');
}

/**
 * إضافة دعم للتخزين المؤقت
 */
function mohtawa_cache_stores() {
    $cached_stores = get_transient('mohtawa_stores_cache');
    
    if (false === $cached_stores) {
        $stores = get_posts(array(
            'post_type' => 'store',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'store_latitude',
                    'compare' => 'EXISTS'
                ),
                array(
                    'key' => 'store_longitude',
                    'compare' => 'EXISTS'
                )
            )
        ));
        
        set_transient('mohtawa_stores_cache', $stores, HOUR_IN_SECONDS);
        return $stores;
    }
    
    return $cached_stores;
}

/**
 * مسح التخزين المؤقت عند تحديث المتاجر
 */
function mohtawa_clear_stores_cache($post_id) {
    if (get_post_type($post_id) === 'store') {
        delete_transient('mohtawa_stores_cache');
    }
}
add_action('save_post', 'mohtawa_clear_stores_cache');

/**
 * إضافة دعم للإشعارات
 */
function mohtawa_admin_notices() {
    // التحقق من وجود الإضافات المطلوبة
    if (!class_exists('ACF')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p>' . sprintf(
            __('قالب محتوى يتطلب إضافة Advanced Custom Fields. %s', 'mohtawa'),
            '<a href="' . admin_url('plugin-install.php?s=advanced+custom+fields&tab=search&type=term') . '">' . __('تثبيت الآن', 'mohtawa') . '</a>'
        ) . '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'mohtawa_admin_notices');

/**
 * إضافة معلومات القالب لصفحة الإدارة
 */
function mohtawa_theme_info() {
    $theme = wp_get_theme();
    echo '<div class="wrap">';
    echo '<h1>' . $theme->get('Name') . '</h1>';
    echo '<p>' . $theme->get('Description') . '</p>';
    echo '<p><strong>' . __('الإصدار:', 'mohtawa') . '</strong> ' . $theme->get('Version') . '</p>';
    echo '<p><strong>' . __('المطور:', 'mohtawa') . '</strong> ' . $theme->get('Author') . '</p>';
    echo '</div>';
}

/**
 * تسجيل خطافات التفعيل
 */
function mohtawa_activation_hook() {
    // إنشاء الصفحات الأساسية
    mohtawa_create_default_pages();
    
    // تعيين الصفحة الرئيسية
    mohtawa_set_homepage();
    
    // تحديث قواعد إعادة الكتابة
    flush_rewrite_rules();
}

/**
 * إنشاء الصفحات الافتراضية
 */
function mohtawa_create_default_pages() {
    $pages = array(
        'map' => array(
            'title' => __('خريطة المتاجر', 'mohtawa'),
            'content' => '[mohtawa_map]',
            'template' => 'templates/map-page.php'
        ),
        'stores' => array(
            'title' => __('جميع المتاجر', 'mohtawa'),
            'content' => '[mohtawa_stores_list]',
            'template' => 'templates/store-archive.php'
        ),
        'contact' => array(
            'title' => __('اتصل بنا', 'mohtawa'),
            'content' => __('صفحة الاتصال', 'mohtawa'),
            'template' => 'page.php'
        )
    );
    
    foreach ($pages as $slug => $page) {
        $existing_page = get_page_by_path($slug);
        
        if (!$existing_page) {
            $page_id = wp_insert_post(array(
                'post_title' => $page['title'],
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug
            ));
            
            if ($page_id && isset($page['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page['template']);
            }
        }
    }
}

/**
 * تعيين الصفحة الرئيسية
 */
function mohtawa_set_homepage() {
    $homepage = get_page_by_path('map');
    
    if ($homepage) {
        update_option('page_on_front', $homepage->ID);
        update_option('show_on_front', 'page');
    }
}

// تشغيل خطاف التفعيل عند تفعيل القالب
add_action('after_switch_theme', 'mohtawa_activation_hook');

/**
 * إضافة دعم للتصدير والاستيراد
 */
function mohtawa_export_settings() {
    $settings = array(
        'theme_options' => get_option('mohtawa_options', array()),
        'customizer_settings' => get_theme_mods(),
        'widgets' => get_option('widget_mohtawa_widgets', array())
    );
    
    return json_encode($settings, JSON_UNESCAPED_UNICODE);
}

function mohtawa_import_settings($json_data) {
    $settings = json_decode($json_data, true);
    
    if ($settings && is_array($settings)) {
        if (isset($settings['theme_options'])) {
            update_option('mohtawa_options', $settings['theme_options']);
        }
        
        if (isset($settings['customizer_settings'])) {
            foreach ($settings['customizer_settings'] as $key => $value) {
                set_theme_mod($key, $value);
            }
        }
        
        if (isset($settings['widgets'])) {
            update_option('widget_mohtawa_widgets', $settings['widgets']);
        }
        
        return true;
    }
    
    return false;
}

/**
 * إضافة دعم للنسخ الاحتياطية التلقائية
 */
function mohtawa_auto_backup() {
    $backup_data = array(
        'timestamp' => current_time('timestamp'),
        'settings' => mohtawa_export_settings(),
        'version' => MOHTAWA_VERSION
    );
    
    update_option('mohtawa_backup_' . date('Y_m_d'), $backup_data);
    
    // الاحتفاظ بآخر 7 نسخ احتياطية فقط
    $backups = get_option('mohtawa_backups_list', array());
    $backups[] = 'mohtawa_backup_' . date('Y_m_d');
    
    if (count($backups) > 7) {
        $old_backup = array_shift($backups);
        delete_option($old_backup);
    }
    
    update_option('mohtawa_backups_list', $backups);
}

// جدولة النسخ الاحتياطية الأسبوعية
if (!wp_next_scheduled('mohtawa_weekly_backup')) {
    wp_schedule_event(time(), 'weekly', 'mohtawa_weekly_backup');
}
add_action('mohtawa_weekly_backup', 'mohtawa_auto_backup');



/**
 * تسجيل الأحداث المهمة
 */
function mohtawa_log_event($event, $data = array()) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $log_entry = array(
            'timestamp' => current_time('mysql'),
            'event' => $event,
            'data' => $data,
            'user_id' => get_current_user_id(),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        );
        
        error_log('MOHTAWA: ' . json_encode($log_entry, JSON_UNESCAPED_UNICODE));
    }
}

/**
 * إضافة دعم للصيانة
 */
function mohtawa_maintenance_mode() {
    if (get_option('mohtawa_maintenance_mode', false) && !current_user_can('administrator')) {
        wp_die(
            __('الموقع تحت الصيانة. سنعود قريباً!', 'mohtawa'),
            __('صيانة الموقع', 'mohtawa'),
            array('response' => 503)
        );
    }
}
add_action('get_header', 'mohtawa_maintenance_mode');

/**
 * نهاية ملف functions.php
 */



// تضمين الملفات المطلوبة
require_once MOHTAWA_INC_DIR . '/post-types.php';
require_once MOHTAWA_INC_DIR . '/ajax-handlers.php';
require_once MOHTAWA_INC_DIR . '/customizer.php';
require_once MOHTAWA_INC_DIR . '/admin-dashboard.php';
require_once MOHTAWA_INC_DIR . '/widgets.php';
require_once MOHTAWA_INC_DIR . '/shortcodes.php';
require_once MOHTAWA_INC_DIR . '/seo.php';

/**
 * تحسين الأداء والأمان
 */
function mohtawa_performance_optimizations() {
    // إزالة الإصدارات من CSS و JS
    add_filter('style_loader_src', 'mohtawa_remove_version_strings');
    add_filter('script_loader_src', 'mohtawa_remove_version_strings');
    
    // تأجيل تحميل JavaScript غير الضروري
    add_filter('script_loader_tag', 'mohtawa_defer_scripts', 10, 2);
    
    // تنظيف wp_head
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'mohtawa_performance_optimizations');

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
 * تأجيل تحميل السكريبتات
 */
function mohtawa_defer_scripts($tag, $handle) {
    $defer_scripts = array('mohtawa-main', 'leaflet-markercluster');
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace('<script ', '<script defer ', $tag);
    }
    
    return $tag;
}



/**
 * تحسين استعلامات قاعدة البيانات
 */
function mohtawa_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_post_type_archive('store')) {
            $query->set('posts_per_page', 12);
            $query->set('meta_key', 'store_featured');
            $query->set('orderby', array('meta_value_num' => 'DESC', 'date' => 'DESC'));
        }
        
        if (is_tax('store_category') || is_tax('store_location')) {
            $query->set('posts_per_page', 12);
        }
    }
}
add_action('pre_get_posts', 'mohtawa_optimize_queries');



/**
 * إضافة معلومات القالب للوحة التحكم
 */
function mohtawa_admin_footer_text($footer_text) {
    $current_screen = get_current_screen();
    
    if (strpos($current_screen->id, 'mohtawa') !== false) {
        $footer_text = sprintf(
            __('قالب محتوى %s | تطوير %s', 'mohtawa'),
            MOHTAWA_VERSION,
            '<a href="https://manus.ai" target="_blank">Manus AI</a>'
        );
    }
    
    return $footer_text;
}
add_filter('admin_footer_text', 'mohtawa_admin_footer_text');



// تضمين ملفات القوالب
require_once MOHTAWA_THEME_DIR . 
    '/templates/store-single.php';
require_once MOHTAWA_THEME_DIR . 
    '/templates/store-archive.php';
require_once MOHTAWA_THEME_DIR . 
    '/templates/map-page.php';
require_once MOHTAWA_THEME_DIR . 
    '/templates/news-ticker.php';

// تضمين أجزاء القالب
require_once MOHTAWA_THEME_DIR . 
    '/parts/store-card.php';
require_once MOHTAWA_THEME_DIR . 
    '/parts/map-controls.php';
require_once MOHTAWA_THEME_DIR . 
    '/parts/filter-sidebar.php';
require_once MOHTAWA_THEME_DIR . 
    '/parts/search-suggestions.php';

// تضمين ملفات الترجمة
require_once MOHTAWA_THEME_DIR . 
    '/languages/mohtawa.pot';
require_once MOHTAWA_THEME_DIR . 
    '/languages/ar.po';
require_once MOHTAWA_THEME_DIR . 
    '/languages/ar.mo';


