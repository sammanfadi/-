<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- تحسين SEO -->
    <meta name="description" content="<?php echo esc_attr(get_bloginfo('description')); ?>">
    <meta name="keywords" content="<?php echo esc_attr(get_theme_mod('mohtawa_seo_keywords', 'متاجر، خريطة، أعمال، محلات، تسوق')); ?>">
    <meta name="author" content="<?php echo esc_attr(get_theme_mod('mohtawa_site_author', 'Manus AI')); ?>">
    
    <!-- Open Graph Tags -->
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:locale" content="<?php echo get_locale(); ?>">
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:site" content="<?php echo esc_attr(get_theme_mod('mohtawa_twitter_handle', '@mohtawa')); ?>">
    
    <!-- Favicon -->
    <?php if (get_theme_mod('mohtawa_favicon')) : ?>
        <link rel="icon" type="image/x-icon" href="<?php echo esc_url(get_theme_mod('mohtawa_favicon')); ?>">
    <?php endif; ?>
    
    <!-- Apple Touch Icon -->
    <?php if (get_theme_mod('mohtawa_apple_icon')) : ?>
        <link rel="apple-touch-icon" href="<?php echo esc_url(get_theme_mod('mohtawa_apple_icon')); ?>">
    <?php endif; ?>
    
    <!-- Preconnect للخطوط -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- DNS Prefetch للخدمات الخارجية -->
    <link rel="dns-prefetch" href="//unpkg.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">
    
    <!-- RSS Feed -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>">
    
    <!-- Pingback -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    
    <?php wp_head(); ?>
    
    <!-- متغيرات CSS المخصصة -->
    <style>
        :root {
            --primary-color: <?php echo esc_attr(get_theme_mod('mohtawa_primary_color', '#3498db')); ?>;
            --secondary-color: <?php echo esc_attr(get_theme_mod('mohtawa_secondary_color', '#2c3e50')); ?>;
            --accent-color: <?php echo esc_attr(get_theme_mod('mohtawa_accent_color', '#e74c3c')); ?>;
            --text-color: <?php echo esc_attr(get_theme_mod('mohtawa_text_color', '#333333')); ?>;
            --background-color: <?php echo esc_attr(get_theme_mod('mohtawa_background_color', '#f8f9fa')); ?>;
            --header-height: <?php echo esc_attr(get_theme_mod('mohtawa_header_height', '80')); ?>px;
            --border-radius: <?php echo esc_attr(get_theme_mod('mohtawa_border_radius', '8')); ?>px;
            --box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        <?php if (get_theme_mod('mohtawa_custom_css')) : ?>
            <?php echo wp_strip_all_tags(get_theme_mod('mohtawa_custom_css')); ?>
        <?php endif; ?>
    </style>
    
    <!-- Google Analytics -->
    <?php if (get_theme_mod('mohtawa_google_analytics')) : ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr(get_theme_mod('mohtawa_google_analytics')); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo esc_attr(get_theme_mod('mohtawa_google_analytics')); ?>');
        </script>
    <?php endif; ?>
    
    <!-- Facebook Pixel -->
    <?php if (get_theme_mod('mohtawa_facebook_pixel')) : ?>
        <!-- Facebook Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '<?php echo esc_attr(get_theme_mod('mohtawa_facebook_pixel')); ?>');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=<?php echo esc_attr(get_theme_mod('mohtawa_facebook_pixel')); ?>&ev=PageView&noscript=1"
        /></noscript>
    <?php endif; ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Skip to content للوصولية -->
    <a class="sr-only sr-only-focusable" href="#main-content"><?php _e('تخطي إلى المحتوى الرئيسي', 'mohtawa'); ?></a>
    
    <!-- شريط الإعلانات العلوي -->
    <?php if (get_theme_mod('mohtawa_top_bar_enabled', true)) : ?>
        <div class="top-bar bg-primary text-white py-2 d-none d-md-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="top-bar-left d-flex align-items-center">
                            <?php if (get_theme_mod('mohtawa_phone')) : ?>
                                <span class="me-3">
                                    <i class="fas fa-phone-alt me-1"></i>
                                    <a href="tel:<?php echo esc_attr(get_theme_mod('mohtawa_phone')); ?>" class="text-white text-decoration-none">
                                        <?php echo esc_html(get_theme_mod('mohtawa_phone')); ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('mohtawa_email')) : ?>
                                <span class="me-3">
                                    <i class="fas fa-envelope me-1"></i>
                                    <a href="mailto:<?php echo esc_attr(get_theme_mod('mohtawa_email')); ?>" class="text-white text-decoration-none">
                                        <?php echo esc_html(get_theme_mod('mohtawa_email')); ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="top-bar-right text-end">
                            <!-- روابط وسائل التواصل الاجتماعي -->
                            <div class="social-links d-inline-flex">
                                <?php if (get_theme_mod('mohtawa_facebook_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_facebook_url')); ?>" target="_blank" rel="noopener" class="text-white me-2" title="<?php _e('فيسبوك', 'mohtawa'); ?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_twitter_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_twitter_url')); ?>" target="_blank" rel="noopener" class="text-white me-2" title="<?php _e('تويتر', 'mohtawa'); ?>">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_instagram_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_instagram_url')); ?>" target="_blank" rel="noopener" class="text-white me-2" title="<?php _e('إنستغرام', 'mohtawa'); ?>">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_linkedin_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_linkedin_url')); ?>" target="_blank" rel="noopener" class="text-white me-2" title="<?php _e('لينكد إن', 'mohtawa'); ?>">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_youtube_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_youtube_url')); ?>" target="_blank" rel="noopener" class="text-white me-2" title="<?php _e('يوتيوب', 'mohtawa'); ?>">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_whatsapp_number')) : ?>
                                    <a href="https://wa.me/<?php echo esc_attr(str_replace(array('+', ' ', '-'), '', get_theme_mod('mohtawa_whatsapp_number'))); ?>" target="_blank" rel="noopener" class="text-white me-2" title="<?php _e('واتساب', 'mohtawa'); ?>">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- الهيدر الرئيسي -->
    <header id="masthead" class="site-header bg-white shadow-sm sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light py-3">
                <!-- الشعار -->
                <div class="navbar-brand">
                    <?php if (has_custom_logo()) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none">
                            <h1 class="site-title h3 mb-0 text-primary fw-bold">
                                <?php bloginfo('name'); ?>
                            </h1>
                            <?php if (get_bloginfo('description')) : ?>
                                <p class="site-description small text-muted mb-0">
                                    <?php bloginfo('description'); ?>
                                </p>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- زر القائمة للأجهزة المحمولة -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#primary-navigation" aria-controls="primary-navigation" aria-expanded="false" aria-label="<?php _e('تبديل التنقل', 'mohtawa'); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- القائمة الرئيسية -->
                <div class="collapse navbar-collapse" id="primary-navigation">
                    <div class="navbar-nav ms-auto">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'navbar-nav',
                            'container'      => false,
                            'depth'          => 2,
                            'fallback_cb'    => 'mohtawa_bootstrap_navwalker::fallback',
                            'walker'         => new mohtawa_bootstrap_navwalker(),
                        ));
                        ?>
                    </div>
                    
                    <!-- أدوات إضافية -->
                    <div class="navbar-tools d-flex align-items-center ms-3">
                        <!-- زر البحث -->
                        <button type="button" class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#searchModal" title="<?php _e('البحث', 'mohtawa'); ?>">
                            <i class="fas fa-search"></i>
                            <span class="d-none d-md-inline ms-1"><?php _e('البحث', 'mohtawa'); ?></span>
                        </button>
                        
                        <!-- زر الوضع المظلم -->
                        <button type="button" id="dark-mode-toggle" class="btn btn-outline-secondary btn-sm me-2" title="<?php _e('تبديل الوضع المظلم', 'mohtawa'); ?>">
                            <i class="fas fa-moon"></i>
                        </button>
                        
                        <!-- زر إضافة متجر -->
                        <?php if (get_theme_mod('mohtawa_enable_store_submission', true)) : ?>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('add-store'))); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>
                                <?php _e('إضافة متجر', 'mohtawa'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- شريط الأخبار المتحرك -->
    <?php if (get_theme_mod('mohtawa_news_ticker_enabled', true)) : ?>
        <?php
        $news_posts = get_posts(array(
            'post_type' => 'news',
            'posts_per_page' => 5,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'news_show_in_ticker',
                    'value' => '1',
                    'compare' => '='
                )
            )
        ));
        ?>
        
        <?php if ($news_posts) : ?>
            <div class="news-ticker bg-light border-bottom py-2">
                <div class="container">
                    <div class="d-flex align-items-center">
                        <div class="news-ticker-label bg-primary text-white px-3 py-1 rounded me-3 flex-shrink-0">
                            <i class="fas fa-bullhorn me-1"></i>
                            <?php _e('أخبار', 'mohtawa'); ?>
                        </div>
                        <div class="news-ticker-content flex-grow-1 overflow-hidden">
                            <div class="news-ticker-scroll">
                                <?php foreach ($news_posts as $news_post) : ?>
                                    <span class="news-item me-5">
                                        <a href="<?php echo esc_url(get_permalink($news_post->ID)); ?>" class="text-decoration-none text-dark">
                                            <?php echo esc_html($news_post->post_title); ?>
                                        </a>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    
    <!-- نافذة البحث المنبثقة -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="searchModalLabel"><?php _e('البحث في الموقع', 'mohtawa'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php _e('إغلاق', 'mohtawa'); ?>"></button>
                </div>
                <div class="modal-body">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
                        <div class="input-group input-group-lg">
                            <input type="search" class="form-control" placeholder="<?php _e('ابحث عن متجر، منتج، أو موقع...', 'mohtawa'); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                                <?php _e('بحث', 'mohtawa'); ?>
                            </button>
                        </div>
                        
                        <!-- فلاتر البحث السريع -->
                        <div class="search-filters mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="search_category" class="form-label small"><?php _e('نوع المتجر', 'mohtawa'); ?></label>
                                    <select name="store_category" id="search_category" class="form-select form-select-sm">
                                        <option value=""><?php _e('جميع الأنواع', 'mohtawa'); ?></option>
                                        <?php
                                        $categories = get_terms(array(
                                            'taxonomy' => 'store_category',
                                            'hide_empty' => false,
                                        ));
                                        foreach ($categories as $category) {
                                            echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="search_location" class="form-label small"><?php _e('الموقع', 'mohtawa'); ?></label>
                                    <select name="store_location" id="search_location" class="form-select form-select-sm">
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
                            </div>
                        </div>
                        
                        <!-- اقتراحات البحث -->
                        <div class="search-suggestions mt-3" id="search-suggestions" style="display: none;">
                            <h6 class="small text-muted mb-2"><?php _e('اقتراحات البحث', 'mohtawa'); ?></h6>
                            <div class="suggestions-list"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- بداية المحتوى الرئيسي -->
    <main id="main-content" class="site-main">
        
        <!-- شريط التنقل (Breadcrumb) -->
        <?php if (!is_front_page() && get_theme_mod('mohtawa_breadcrumb_enabled', true)) : ?>
            <div class="breadcrumb-section bg-light py-3">
                <div class="container">
                    <?php mohtawa_breadcrumb(); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- منطقة قبل المحتوى -->
        <?php if (is_active_sidebar('before-content')) : ?>
            <div class="before-content-area py-4">
                <div class="container">
                    <?php dynamic_sidebar('before-content'); ?>
                </div>
            </div>
        <?php endif; ?>

<?php
/**
 * دالة شريط التنقل (Breadcrumb)
 */
function mohtawa_breadcrumb() {
    $separator = '<i class="fas fa-chevron-left mx-2 text-muted"></i>';
    $home_title = __('الرئيسية', 'mohtawa');
    
    echo '<nav aria-label="breadcrumb">';
    echo '<ol class="breadcrumb mb-0">';
    
    // الرابط الرئيسي
    if (!is_home()) {
        echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '" class="text-decoration-none">' . $home_title . '</a></li>';
    }
    
    if (is_category() || is_single()) {
        $category = get_the_category();
        if ($category) {
            foreach ($category as $cat) {
                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($cat->term_id)) . '" class="text-decoration-none">' . esc_html($cat->name) . '</a></li>';
            }
        }
        if (is_single()) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
        }
    } elseif (is_page()) {
        if ($post = get_post()) {
            if ($post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($page->ID)) . '" class="text-decoration-none">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo $crumb;
                }
            }
            echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
        }
    } elseif (is_search()) {
        echo '<li class="breadcrumb-item active" aria-current="page">' . sprintf(__('نتائج البحث عن: %s', 'mohtawa'), get_search_query()) . '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumb-item active" aria-current="page">' . __('الصفحة غير موجودة', 'mohtawa') . '</li>';
    } elseif (is_archive()) {
        echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_archive_title() . '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * Bootstrap NavWalker للقوائم
 */
class mohtawa_bootstrap_navwalker extends Walker_Nav_Menu {
    
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $link_classes = array('nav-link');
        if (in_array('menu-item-has-children', $classes)) {
            $link_classes[] = 'dropdown-toggle';
        }
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        if (in_array('menu-item-has-children', $classes)) {
            $attributes .= ' data-bs-toggle="dropdown" aria-expanded="false"';
        }
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a class="' . implode(' ', $link_classes) . '"' . $attributes .'>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
    
    public static function fallback($args) {
        if (current_user_can('edit_theme_options')) {
            echo '<ul class="navbar-nav">';
            echo '<li class="nav-item"><a class="nav-link" href="' . esc_url(admin_url('nav-menus.php')) . '">' . __('إضافة قائمة', 'mohtawa') . '</a></li>';
            echo '</ul>';
        }
    }
}
?>

