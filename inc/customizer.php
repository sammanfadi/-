<?php
/**
 * إعدادات التخصيص لقالب محتوى
 *
 * @package Mohtawa
 * @version 1.0.0
 */

// منع الوصول المباشر
if (!defined('ABSPATH')) {
    exit;
}

/**
 * تسجيل إعدادات التخصيص
 */
function mohtawa_customize_register($wp_customize) {
    
    // إزالة الأقسام غير المرغوب فيها
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('background_image');
    
    // ===== قسم الهوية والشعار =====
    $wp_customize->add_section('mohtawa_branding', array(
        'title' => __('الهوية والشعار', 'mohtawa'),
        'priority' => 30,
        'description' => __('تخصيص شعار الموقع والهوية البصرية', 'mohtawa')
    ));
    
    // شعار الموقع
    $wp_customize->add_setting('mohtawa_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mohtawa_logo', array(
        'label' => __('شعار الموقع', 'mohtawa'),
        'section' => 'mohtawa_branding',
        'settings' => 'mohtawa_logo',
        'description' => __('اختر شعار الموقع (الحد الأقصى: 200x60 بكسل)', 'mohtawa')
    )));
    
    // شعار الموقع للوضع المظلم
    $wp_customize->add_setting('mohtawa_logo_dark', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mohtawa_logo_dark', array(
        'label' => __('شعار الموقع (الوضع المظلم)', 'mohtawa'),
        'section' => 'mohtawa_branding',
        'settings' => 'mohtawa_logo_dark',
        'description' => __('شعار بديل للوضع المظلم', 'mohtawa')
    )));
    
    // أيقونة الموقع (فافيكون)
    $wp_customize->add_setting('mohtawa_favicon', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mohtawa_favicon', array(
        'label' => __('أيقونة الموقع (فافيكون)', 'mohtawa'),
        'section' => 'mohtawa_branding',
        'settings' => 'mohtawa_favicon',
        'description' => __('أيقونة صغيرة تظهر في تبويب المتصفح (32x32 بكسل)', 'mohtawa')
    )));
    
    // ===== قسم الألوان =====
    $wp_customize->add_section('mohtawa_colors', array(
        'title' => __('الألوان', 'mohtawa'),
        'priority' => 40,
        'description' => __('تخصيص ألوان الموقع والعناصر', 'mohtawa')
    ));
    
    // اللون الأساسي
    $wp_customize->add_setting('mohtawa_primary_color', array(
        'default' => '#3498db',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mohtawa_primary_color', array(
        'label' => __('اللون الأساسي', 'mohtawa'),
        'section' => 'mohtawa_colors',
        'settings' => 'mohtawa_primary_color',
        'description' => __('اللون الرئيسي للأزرار والروابط', 'mohtawa')
    )));
    
    // اللون الثانوي
    $wp_customize->add_setting('mohtawa_secondary_color', array(
        'default' => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mohtawa_secondary_color', array(
        'label' => __('اللون الثانوي', 'mohtawa'),
        'section' => 'mohtawa_colors',
        'settings' => 'mohtawa_secondary_color',
        'description' => __('اللون الثانوي للعناوين والنصوص المهمة', 'mohtawa')
    )));
    
    // لون النجاح
    $wp_customize->add_setting('mohtawa_success_color', array(
        'default' => '#27ae60',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mohtawa_success_color', array(
        'label' => __('لون النجاح', 'mohtawa'),
        'section' => 'mohtawa_colors',
        'settings' => 'mohtawa_success_color',
        'description' => __('لون رسائل النجاح والحالات الإيجابية', 'mohtawa')
    )));
    
    // لون التحذير
    $wp_customize->add_setting('mohtawa_warning_color', array(
        'default' => '#f39c12',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mohtawa_warning_color', array(
        'label' => __('لون التحذير', 'mohtawa'),
        'section' => 'mohtawa_colors',
        'settings' => 'mohtawa_warning_color',
        'description' => __('لون رسائل التحذير', 'mohtawa')
    )));
    
    // لون الخطر
    $wp_customize->add_setting('mohtawa_danger_color', array(
        'default' => '#e74c3c',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mohtawa_danger_color', array(
        'label' => __('لون الخطر', 'mohtawa'),
        'section' => 'mohtawa_colors',
        'settings' => 'mohtawa_danger_color',
        'description' => __('لون رسائل الخطأ والحالات السلبية', 'mohtawa')
    )));
    
    // ===== قسم الخطوط =====
    $wp_customize->add_section('mohtawa_typography', array(
        'title' => __('الخطوط', 'mohtawa'),
        'priority' => 50,
        'description' => __('تخصيص خطوط الموقع وأحجامها', 'mohtawa')
    ));
    
    // خط العناوين
    $wp_customize->add_setting('mohtawa_heading_font', array(
        'default' => 'Cairo',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_heading_font', array(
        'label' => __('خط العناوين', 'mohtawa'),
        'section' => 'mohtawa_typography',
        'type' => 'select',
        'choices' => array(
            'Cairo' => 'Cairo',
            'Amiri' => 'Amiri',
            'Tajawal' => 'Tajawal',
            'Almarai' => 'Almarai',
            'Noto Sans Arabic' => 'Noto Sans Arabic',
            'IBM Plex Sans Arabic' => 'IBM Plex Sans Arabic'
        ),
        'description' => __('اختر خط العناوين الرئيسية', 'mohtawa')
    ));
    
    // خط النصوص
    $wp_customize->add_setting('mohtawa_body_font', array(
        'default' => 'Tajawal',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_body_font', array(
        'label' => __('خط النصوص', 'mohtawa'),
        'section' => 'mohtawa_typography',
        'type' => 'select',
        'choices' => array(
            'Tajawal' => 'Tajawal',
            'Cairo' => 'Cairo',
            'Amiri' => 'Amiri',
            'Almarai' => 'Almarai',
            'Noto Sans Arabic' => 'Noto Sans Arabic',
            'IBM Plex Sans Arabic' => 'IBM Plex Sans Arabic'
        ),
        'description' => __('اختر خط النصوص العادية', 'mohtawa')
    ));
    
    // حجم الخط الأساسي
    $wp_customize->add_setting('mohtawa_font_size', array(
        'default' => '16',
        'sanitize_callback' => 'absint'
    ));
    
    $wp_customize->add_control('mohtawa_font_size', array(
        'label' => __('حجم الخط الأساسي (بكسل)', 'mohtawa'),
        'section' => 'mohtawa_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 12,
            'max' => 24,
            'step' => 1
        ),
        'description' => __('حجم الخط الأساسي للنصوص (12-24 بكسل)', 'mohtawa')
    ));
    
    // ===== قسم إعدادات الخريطة =====
    $wp_customize->add_section('mohtawa_map_settings', array(
        'title' => __('إعدادات الخريطة', 'mohtawa'),
        'priority' => 60,
        'description' => __('تخصيص إعدادات الخريطة التفاعلية', 'mohtawa')
    ));
    
    // الموقع الافتراضي للخريطة - خط العرض
    $wp_customize->add_setting('mohtawa_map_default_lat', array(
        'default' => '24.7136',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_map_default_lat', array(
        'label' => __('خط العرض الافتراضي', 'mohtawa'),
        'section' => 'mohtawa_map_settings',
        'type' => 'text',
        'description' => __('خط العرض للموقع الافتراضي للخريطة (مثال: 24.7136)', 'mohtawa')
    ));
    
    // الموقع الافتراضي للخريطة - خط الطول
    $wp_customize->add_setting('mohtawa_map_default_lng', array(
        'default' => '46.6753',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_map_default_lng', array(
        'label' => __('خط الطول الافتراضي', 'mohtawa'),
        'section' => 'mohtawa_map_settings',
        'type' => 'text',
        'description' => __('خط الطول للموقع الافتراضي للخريطة (مثال: 46.6753)', 'mohtawa')
    ));
    
    // مستوى التكبير الافتراضي
    $wp_customize->add_setting('mohtawa_map_default_zoom', array(
        'default' => '11',
        'sanitize_callback' => 'absint'
    ));
    
    $wp_customize->add_control('mohtawa_map_default_zoom', array(
        'label' => __('مستوى التكبير الافتراضي', 'mohtawa'),
        'section' => 'mohtawa_map_settings',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 18,
            'step' => 1
        ),
        'description' => __('مستوى التكبير الافتراضي للخريطة (1-18)', 'mohtawa')
    ));
    
    // تفعيل تحديد الموقع التلقائي
    $wp_customize->add_setting('mohtawa_map_auto_locate', array(
        'default' => true,
        'sanitize_callback' => 'mohtawa_sanitize_checkbox'
    ));
    
    $wp_customize->add_control('mohtawa_map_auto_locate', array(
        'label' => __('تحديد الموقع التلقائي', 'mohtawa'),
        'section' => 'mohtawa_map_settings',
        'type' => 'checkbox',
        'description' => __('طلب إذن المستخدم لتحديد موقعه تلقائياً', 'mohtawa')
    ));
    
    // نمط الخريطة
    $wp_customize->add_setting('mohtawa_map_style', array(
        'default' => 'default',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_map_style', array(
        'label' => __('نمط الخريطة', 'mohtawa'),
        'section' => 'mohtawa_map_settings',
        'type' => 'select',
        'choices' => array(
            'default' => __('افتراضي', 'mohtawa'),
            'satellite' => __('القمر الصناعي', 'mohtawa'),
            'terrain' => __('التضاريس', 'mohtawa'),
            'dark' => __('مظلم', 'mohtawa')
        ),
        'description' => __('اختر نمط عرض الخريطة', 'mohtawa')
    ));
    
    // ===== قسم شريط الأخبار =====
    $wp_customize->add_section('mohtawa_news_ticker', array(
        'title' => __('شريط الأخبار', 'mohtawa'),
        'priority' => 70,
        'description' => __('إعدادات شريط الأخبار المتحرك', 'mohtawa')
    ));
    
    // تفعيل شريط الأخبار
    $wp_customize->add_setting('mohtawa_news_ticker_enable', array(
        'default' => true,
        'sanitize_callback' => 'mohtawa_sanitize_checkbox'
    ));
    
    $wp_customize->add_control('mohtawa_news_ticker_enable', array(
        'label' => __('تفعيل شريط الأخبار', 'mohtawa'),
        'section' => 'mohtawa_news_ticker',
        'type' => 'checkbox',
        'description' => __('إظهار شريط الأخبار المتحرك في أعلى الصفحة', 'mohtawa')
    ));
    
    // عنوان شريط الأخبار
    $wp_customize->add_setting('mohtawa_news_ticker_title', array(
        'default' => __('آخر الأخبار', 'mohtawa'),
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_news_ticker_title', array(
        'label' => __('عنوان شريط الأخبار', 'mohtawa'),
        'section' => 'mohtawa_news_ticker',
        'type' => 'text',
        'description' => __('النص الذي يظهر في بداية شريط الأخبار', 'mohtawa')
    ));
    
    // سرعة التمرير
    $wp_customize->add_setting('mohtawa_news_ticker_speed', array(
        'default' => '50',
        'sanitize_callback' => 'absint'
    ));
    
    $wp_customize->add_control('mohtawa_news_ticker_speed', array(
        'label' => __('سرعة التمرير', 'mohtawa'),
        'section' => 'mohtawa_news_ticker',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 10,
            'max' => 100,
            'step' => 5
        ),
        'description' => __('سرعة تمرير النصوص (10-100)', 'mohtawa')
    ));
    
    // ===== قسم وسائل التواصل الاجتماعي =====
    $wp_customize->add_section('mohtawa_social_media', array(
        'title' => __('وسائل التواصل الاجتماعي', 'mohtawa'),
        'priority' => 80,
        'description' => __('روابط حسابات وسائل التواصل الاجتماعي', 'mohtawa')
    ));
    
    // فيسبوك
    $wp_customize->add_setting('mohtawa_facebook_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control('mohtawa_facebook_url', array(
        'label' => __('رابط فيسبوك', 'mohtawa'),
        'section' => 'mohtawa_social_media',
        'type' => 'url',
        'description' => __('رابط صفحة فيسبوك', 'mohtawa')
    ));
    
    // تويتر
    $wp_customize->add_setting('mohtawa_twitter_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control('mohtawa_twitter_url', array(
        'label' => __('رابط تويتر', 'mohtawa'),
        'section' => 'mohtawa_social_media',
        'type' => 'url',
        'description' => __('رابط حساب تويتر', 'mohtawa')
    ));
    
    // إنستغرام
    $wp_customize->add_setting('mohtawa_instagram_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control('mohtawa_instagram_url', array(
        'label' => __('رابط إنستغرام', 'mohtawa'),
        'section' => 'mohtawa_social_media',
        'type' => 'url',
        'description' => __('رابط حساب إنستغرام', 'mohtawa')
    ));
    
    // لينكد إن
    $wp_customize->add_setting('mohtawa_linkedin_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control('mohtawa_linkedin_url', array(
        'label' => __('رابط لينكد إن', 'mohtawa'),
        'section' => 'mohtawa_social_media',
        'type' => 'url',
        'description' => __('رابط حساب لينكد إن', 'mohtawa')
    ));
    
    // يوتيوب
    $wp_customize->add_setting('mohtawa_youtube_url', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    
    $wp_customize->add_control('mohtawa_youtube_url', array(
        'label' => __('رابط يوتيوب', 'mohtawa'),
        'section' => 'mohtawa_social_media',
        'type' => 'url',
        'description' => __('رابط قناة يوتيوب', 'mohtawa')
    ));
    
    // واتساب
    $wp_customize->add_setting('mohtawa_whatsapp_number', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_whatsapp_number', array(
        'label' => __('رقم واتساب', 'mohtawa'),
        'section' => 'mohtawa_social_media',
        'type' => 'text',
        'description' => __('رقم واتساب مع رمز البلد (مثال: +966501234567)', 'mohtawa')
    ));
    
    // ===== قسم معلومات الاتصال =====
    $wp_customize->add_section('mohtawa_contact_info', array(
        'title' => __('معلومات الاتصال', 'mohtawa'),
        'priority' => 90,
        'description' => __('معلومات الاتصال والعنوان', 'mohtawa')
    ));
    
    // رقم الهاتف
    $wp_customize->add_setting('mohtawa_phone_number', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_phone_number', array(
        'label' => __('رقم الهاتف', 'mohtawa'),
        'section' => 'mohtawa_contact_info',
        'type' => 'text',
        'description' => __('رقم الهاتف الرئيسي', 'mohtawa')
    ));
    
    // البريد الإلكتروني
    $wp_customize->add_setting('mohtawa_email_address', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email'
    ));
    
    $wp_customize->add_control('mohtawa_email_address', array(
        'label' => __('البريد الإلكتروني', 'mohtawa'),
        'section' => 'mohtawa_contact_info',
        'type' => 'email',
        'description' => __('عنوان البريد الإلكتروني', 'mohtawa')
    ));
    
    // العنوان
    $wp_customize->add_setting('mohtawa_address', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    
    $wp_customize->add_control('mohtawa_address', array(
        'label' => __('العنوان', 'mohtawa'),
        'section' => 'mohtawa_contact_info',
        'type' => 'textarea',
        'description' => __('العنوان الكامل للمؤسسة', 'mohtawa')
    ));
    
    // ساعات العمل
    $wp_customize->add_setting('mohtawa_working_hours', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    
    $wp_customize->add_control('mohtawa_working_hours', array(
        'label' => __('ساعات العمل', 'mohtawa'),
        'section' => 'mohtawa_contact_info',
        'type' => 'textarea',
        'description' => __('ساعات العمل الرسمية', 'mohtawa')
    ));
    
    // ===== قسم إعدادات متقدمة =====
    $wp_customize->add_section('mohtawa_advanced_settings', array(
        'title' => __('إعدادات متقدمة', 'mohtawa'),
        'priority' => 100,
        'description' => __('إعدادات متقدمة للموقع', 'mohtawa')
    ));
    
    // تفعيل الوضع المظلم
    $wp_customize->add_setting('mohtawa_dark_mode_enable', array(
        'default' => false,
        'sanitize_callback' => 'mohtawa_sanitize_checkbox'
    ));
    
    $wp_customize->add_control('mohtawa_dark_mode_enable', array(
        'label' => __('تفعيل الوضع المظلم', 'mohtawa'),
        'section' => 'mohtawa_advanced_settings',
        'type' => 'checkbox',
        'description' => __('السماح للمستخدمين بالتبديل للوضع المظلم', 'mohtawa')
    ));
    
    // تفعيل التحميل التدريجي
    $wp_customize->add_setting('mohtawa_lazy_loading', array(
        'default' => true,
        'sanitize_callback' => 'mohtawa_sanitize_checkbox'
    ));
    
    $wp_customize->add_control('mohtawa_lazy_loading', array(
        'label' => __('التحميل التدريجي للصور', 'mohtawa'),
        'section' => 'mohtawa_advanced_settings',
        'type' => 'checkbox',
        'description' => __('تحميل الصور عند الحاجة لتحسين الأداء', 'mohtawa')
    ));
    
    // تفعيل ضغط الصور
    $wp_customize->add_setting('mohtawa_image_compression', array(
        'default' => true,
        'sanitize_callback' => 'mohtawa_sanitize_checkbox'
    ));
    
    $wp_customize->add_control('mohtawa_image_compression', array(
        'label' => __('ضغط الصور تلقائياً', 'mohtawa'),
        'section' => 'mohtawa_advanced_settings',
        'type' => 'checkbox',
        'description' => __('ضغط الصور المرفوعة لتحسين سرعة التحميل', 'mohtawa')
    ));
    
    // كود Google Analytics
    $wp_customize->add_setting('mohtawa_google_analytics', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    
    $wp_customize->add_control('mohtawa_google_analytics', array(
        'label' => __('معرف Google Analytics', 'mohtawa'),
        'section' => 'mohtawa_advanced_settings',
        'type' => 'text',
        'description' => __('معرف Google Analytics (مثال: GA-XXXXXXXXX-X)', 'mohtawa')
    ));
    
    // كود مخصص في الرأس
    $wp_customize->add_setting('mohtawa_custom_head_code', array(
        'default' => '',
        'sanitize_callback' => 'mohtawa_sanitize_code'
    ));
    
    $wp_customize->add_control('mohtawa_custom_head_code', array(
        'label' => __('كود مخصص في الرأس', 'mohtawa'),
        'section' => 'mohtawa_advanced_settings',
        'type' => 'textarea',
        'description' => __('كود HTML/CSS/JS مخصص يتم إدراجه في رأس الصفحة', 'mohtawa')
    ));
    
    // كود مخصص في التذييل
    $wp_customize->add_setting('mohtawa_custom_footer_code', array(
        'default' => '',
        'sanitize_callback' => 'mohtawa_sanitize_code'
    ));
    
    $wp_customize->add_control('mohtawa_custom_footer_code', array(
        'label' => __('كود مخصص في التذييل', 'mohtawa'),
        'section' => 'mohtawa_advanced_settings',
        'type' => 'textarea',
        'description' => __('كود HTML/CSS/JS مخصص يتم إدراجه في تذييل الصفحة', 'mohtawa')
    ));
}
add_action('customize_register', 'mohtawa_customize_register');

/**
 * تنظيف قيم checkbox
 */
function mohtawa_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * تنظيف الكود المخصص
 */
function mohtawa_sanitize_code($input) {
    return wp_kses_post($input);
}

/**
 * إضافة CSS مخصص للمعاينة المباشرة
 */
function mohtawa_customize_preview_js() {
    wp_enqueue_script(
        'mohtawa-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'mohtawa_customize_preview_js');

/**
 * إضافة CSS للتخصيص المباشر
 */
function mohtawa_customize_css() {
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo get_theme_mod('mohtawa_primary_color', '#3498db'); ?>;
            --secondary-color: <?php echo get_theme_mod('mohtawa_secondary_color', '#2c3e50'); ?>;
            --success-color: <?php echo get_theme_mod('mohtawa_success_color', '#27ae60'); ?>;
            --warning-color: <?php echo get_theme_mod('mohtawa_warning_color', '#f39c12'); ?>;
            --danger-color: <?php echo get_theme_mod('mohtawa_danger_color', '#e74c3c'); ?>;
            --heading-font: '<?php echo get_theme_mod('mohtawa_heading_font', 'Cairo'); ?>', sans-serif;
            --body-font: '<?php echo get_theme_mod('mohtawa_body_font', 'Tajawal'); ?>', sans-serif;
            --font-size: <?php echo get_theme_mod('mohtawa_font_size', '16'); ?>px;
        }
        
        body {
            font-family: var(--body-font);
            font-size: var(--font-size);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--heading-font);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            opacity: 0.9;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }
        
        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        a {
            color: var(--primary-color);
        }
        
        a:hover {
            color: var(--primary-color);
            opacity: 0.8;
        }
        
        .navbar-brand {
            font-family: var(--heading-font);
        }
        
        <?php if (get_theme_mod('mohtawa_dark_mode_enable', false)) : ?>
        @media (prefers-color-scheme: dark) {
            body.dark-mode {
                background-color: #1a1a1a;
                color: #ffffff;
            }
            
            body.dark-mode .card {
                background-color: #2d2d2d;
                border-color: #404040;
            }
            
            body.dark-mode .navbar {
                background-color: #2d2d2d !important;
            }
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'mohtawa_customize_css');

/**
 * إضافة الكود المخصص في الرأس
 */
function mohtawa_custom_head_code() {
    $custom_code = get_theme_mod('mohtawa_custom_head_code', '');
    if (!empty($custom_code)) {
        echo $custom_code;
    }
    
    // Google Analytics
    $ga_id = get_theme_mod('mohtawa_google_analytics', '');
    if (!empty($ga_id)) {
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($ga_id); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_attr($ga_id); ?>');
        </script>
        <?php
    }
}
add_action('wp_head', 'mohtawa_custom_head_code');

/**
 * إضافة الكود المخصص في التذييل
 */
function mohtawa_custom_footer_code() {
    $custom_code = get_theme_mod('mohtawa_custom_footer_code', '');
    if (!empty($custom_code)) {
        echo $custom_code;
    }
}
add_action('wp_footer', 'mohtawa_custom_footer_code');

/**
 * إضافة خطوط Google Fonts
 */
function mohtawa_google_fonts() {
    $heading_font = get_theme_mod('mohtawa_heading_font', 'Cairo');
    $body_font = get_theme_mod('mohtawa_body_font', 'Tajawal');
    
    $fonts = array();
    if ($heading_font !== 'inherit') {
        $fonts[] = $heading_font . ':300,400,600,700';
    }
    if ($body_font !== 'inherit' && $body_font !== $heading_font) {
        $fonts[] = $body_font . ':300,400,500,600';
    }
    
    if (!empty($fonts)) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
        wp_enqueue_style('mohtawa-google-fonts', $fonts_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'mohtawa_google_fonts');

/**
 * إضافة متغيرات JavaScript للتخصيص
 */
function mohtawa_customizer_js_vars() {
    $map_config = array(
        'defaultCenter' => array(
            floatval(get_theme_mod('mohtawa_map_default_lat', '24.7136')),
            floatval(get_theme_mod('mohtawa_map_default_lng', '46.6753'))
        ),
        'defaultZoom' => intval(get_theme_mod('mohtawa_map_default_zoom', '11')),
        'autoLocate' => get_theme_mod('mohtawa_map_auto_locate', true),
        'style' => get_theme_mod('mohtawa_map_style', 'default')
    );
    
    $news_ticker_config = array(
        'enabled' => get_theme_mod('mohtawa_news_ticker_enable', true),
        'title' => get_theme_mod('mohtawa_news_ticker_title', __('آخر الأخبار', 'mohtawa')),
        'speed' => intval(get_theme_mod('mohtawa_news_ticker_speed', '50'))
    );
    
    ?>
    <script>
        window.mapConfig = <?php echo json_encode($map_config); ?>;
        window.newsTickerConfig = <?php echo json_encode($news_ticker_config); ?>;
        window.darkModeEnabled = <?php echo get_theme_mod('mohtawa_dark_mode_enable', false) ? 'true' : 'false'; ?>;
    </script>
    <?php
}
add_action('wp_head', 'mohtawa_customizer_js_vars');

