<?php
/**
 * صفحة الخطأ 404
 *
 * @package Mohtawa
 * @version 1.0.0
 */

get_header(); ?>

<main class="main-content">
    <div class="container">
        <div class="error-404-content">
            <div class="error-404-header">
                <h1 class="error-404-title"><?php _e('404', 'mohtawa'); ?></h1>
                <h2 class="error-404-subtitle"><?php _e('الصفحة غير موجودة', 'mohtawa'); ?></h2>
                <p class="error-404-description">
                    <?php _e('عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها إلى موقع آخر.', 'mohtawa'); ?>
                </p>
            </div>
            
            <div class="error-404-search">
                <h3><?php _e('جرب البحث عن المتجر الذي تريده:', 'mohtawa'); ?></h3>
                <?php echo do_shortcode('[mohtawa_search_form layout="horizontal" show_filters="true"]'); ?>
            </div>
            
            <div class="error-404-suggestions">
                <div class="suggestions-grid">
                    <div class="suggestion-item">
                        <h4><?php _e('تصفح الفئات', 'mohtawa'); ?></h4>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'store_category',
                            'hide_empty' => true,
                            'number' => 6
                        ));
                        
                        if ($categories && !is_wp_error($categories)) {
                            echo '<ul class="category-list">';
                            foreach ($categories as $category) {
                                echo '<li><a href="' . get_term_link($category) . '">' . esc_html($category->name) . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>
                    
                    <div class="suggestion-item">
                        <h4><?php _e('المتاجر المميزة', 'mohtawa'); ?></h4>
                        <?php
                        $featured_stores = get_posts(array(
                            'post_type' => 'store',
                            'posts_per_page' => 5,
                            'meta_key' => 'store_featured',
                            'meta_value' => '1'
                        ));
                        
                        if ($featured_stores) {
                            echo '<ul class="store-list">';
                            foreach ($featured_stores as $store) {
                                echo '<li><a href="' . get_permalink($store->ID) . '">' . esc_html($store->post_title) . '</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?>
                    </div>
                    
                    <div class="suggestion-item">
                        <h4><?php _e('روابط مفيدة', 'mohtawa'); ?></h4>
                        <ul class="useful-links">
                            <li><a href="<?php echo home_url(); ?>"><?php _e('الصفحة الرئيسية', 'mohtawa'); ?></a></li>
                            <li><a href="<?php echo get_post_type_archive_link('store'); ?>"><?php _e('دليل المتاجر', 'mohtawa'); ?></a></li>
                            <?php
                            $contact_page = get_page_by_title('اتصل بنا');
                            if ($contact_page) {
                                echo '<li><a href="' . get_permalink($contact_page->ID) . '">' . __('اتصل بنا', 'mohtawa') . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="error-404-actions">
                <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    <?php _e('العودة للرئيسية', 'mohtawa'); ?>
                </a>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    <?php _e('العودة للصفحة السابقة', 'mohtawa'); ?>
                </a>
            </div>
        </div>
    </div>
</main>

<style>
.error-404-content {
    text-align: center;
    padding: 60px 20px;
    max-width: 800px;
    margin: 0 auto;
}

.error-404-title {
    font-size: 120px;
    font-weight: bold;
    color: #e74c3c;
    margin: 0;
    line-height: 1;
}

.error-404-subtitle {
    font-size: 32px;
    color: #2c3e50;
    margin: 20px 0;
}

.error-404-description {
    font-size: 18px;
    color: #7f8c8d;
    margin-bottom: 40px;
    line-height: 1.6;
}

.error-404-search {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 8px;
    margin: 40px 0;
}

.error-404-search h3 {
    margin-bottom: 20px;
    color: #2c3e50;
}

.suggestions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin: 40px 0;
    text-align: right;
}

.suggestion-item h4 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 18px;
}

.category-list,
.store-list,
.useful-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li,
.store-list li,
.useful-links li {
    margin-bottom: 8px;
}

.category-list a,
.store-list a,
.useful-links a {
    color: #3498db;
    text-decoration: none;
    font-size: 14px;
}

.category-list a:hover,
.store-list a:hover,
.useful-links a:hover {
    text-decoration: underline;
}

.error-404-actions {
    margin-top: 40px;
}

.error-404-actions .btn {
    margin: 0 10px;
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
}

.error-404-actions .btn-primary {
    background: #3498db;
    color: white;
}

.error-404-actions .btn-secondary {
    background: #95a5a6;
    color: white;
}

.error-404-actions .btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .error-404-title {
        font-size: 80px;
    }
    
    .error-404-subtitle {
        font-size: 24px;
    }
    
    .suggestions-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .error-404-actions .btn {
        display: block;
        margin: 10px 0;
        text-align: center;
    }
}
</style>

<?php get_footer(); ?>

