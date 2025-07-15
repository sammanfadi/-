<?php
/**
 * صفحة نتائج البحث
 *
 * @package Mohtawa
 * @version 1.0.0
 */

get_header(); ?>

<main class="main-content">
    <div class="container">
        
        <?php mohtawa_breadcrumbs(); ?>
        
        <div class="search-results-header">
            <h1 class="search-results-title">
                <?php
                printf(
                    __('نتائج البحث عن: "%s"', 'mohtawa'),
                    '<span class="search-term">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            
            <?php if (have_posts()) : ?>
                <p class="search-results-count">
                    <?php
                    global $wp_query;
                    printf(
                        _n('تم العثور على نتيجة واحدة', 'تم العثور على %d نتيجة', $wp_query->found_posts, 'mohtawa'),
                        number_format_i18n($wp_query->found_posts)
                    );
                    ?>
                </p>
            <?php endif; ?>
        </div>
        
        <div class="search-content">
            <div class="search-main">
                
                <?php if (have_posts()) : ?>
                    
                    <div class="search-results">
                        <?php while (have_posts()) : the_post(); ?>
                            
                            <article class="search-result-item">
                                
                                <?php if (get_post_type() === 'store') : ?>
                                    
                                    <!-- نتيجة بحث متجر -->
                                    <div class="store-search-result">
                                        
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="store-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('medium'); ?>
                                                </a>
                                                
                                                <?php if (get_post_meta(get_the_ID(), 'store_featured', true) === '1') : ?>
                                                    <span class="featured-badge"><?php _e('مميز', 'mohtawa'); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="store-content">
                                            <h2 class="store-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h2>
                                            
                                            <?php
                                            $store_rating = get_post_meta(get_the_ID(), 'store_rating', true);
                                            if ($store_rating) :
                                            ?>
                                                <div class="store-rating">
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        echo $i <= $store_rating ? '★' : '☆';
                                                    }
                                                    ?>
                                                    <span class="rating-number">(<?php echo esc_html($store_rating); ?>)</span>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php
                                            $store_address = get_post_meta(get_the_ID(), 'store_address', true);
                                            if ($store_address) :
                                            ?>
                                                <p class="store-address">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo esc_html($store_address); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if (has_excerpt()) : ?>
                                                <p class="store-excerpt"><?php the_excerpt(); ?></p>
                                            <?php endif; ?>
                                            
                                            <div class="store-meta">
                                                <?php
                                                $categories = get_the_terms(get_the_ID(), 'store_category');
                                                if ($categories && !is_wp_error($categories)) :
                                                ?>
                                                    <span class="store-category">
                                                        <i class="fas fa-tag"></i>
                                                        <?php echo esc_html($categories[0]->name); ?>
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <?php
                                                $store_phone = get_post_meta(get_the_ID(), 'store_phone', true);
                                                if ($store_phone) :
                                                ?>
                                                    <a href="tel:<?php echo esc_attr($store_phone); ?>" class="store-phone">
                                                        <i class="fas fa-phone"></i>
                                                        <?php echo esc_html($store_phone); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php else : ?>
                                    
                                    <!-- نتيجة بحث عادية -->
                                    <div class="post-search-result">
                                        <h2 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <div class="post-meta">
                                            <span class="post-date">
                                                <i class="fas fa-calendar"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            
                                            <span class="post-type">
                                                <i class="fas fa-file"></i>
                                                <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                            </span>
                                        </div>
                                        
                                        <?php if (has_excerpt()) : ?>
                                            <p class="post-excerpt"><?php the_excerpt(); ?></p>
                                        <?php else : ?>
                                            <p class="post-excerpt"><?php echo wp_trim_words(get_the_content(), 25); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    
                                <?php endif; ?>
                                
                            </article>
                            
                        <?php endwhile; ?>
                    </div>
                    
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('السابق', 'mohtawa'),
                        'next_text' => __('التالي', 'mohtawa'),
                    ));
                    ?>
                    
                <?php else : ?>
                    
                    <div class="no-results">
                        <div class="no-results-content">
                            <i class="fas fa-search no-results-icon"></i>
                            <h2><?php _e('لم يتم العثور على نتائج', 'mohtawa'); ?></h2>
                            <p><?php _e('عذراً، لم نتمكن من العثور على أي نتائج تطابق بحثك. جرب استخدام كلمات مختلفة أو أقل تحديداً.', 'mohtawa'); ?></p>
                            
                            <div class="search-suggestions">
                                <h3><?php _e('اقتراحات للبحث:', 'mohtawa'); ?></h3>
                                <ul>
                                    <li><?php _e('تأكد من كتابة الكلمات بشكل صحيح', 'mohtawa'); ?></li>
                                    <li><?php _e('جرب استخدام كلمات أقل أو مرادفات', 'mohtawa'); ?></li>
                                    <li><?php _e('جرب البحث بفئة محددة', 'mohtawa'); ?></li>
                                    <li><?php _e('تصفح الفئات المتاحة', 'mohtawa'); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                <?php endif; ?>
                
            </div>
            
            <aside class="search-sidebar">
                
                <!-- نموذج بحث متقدم -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php _e('بحث متقدم', 'mohtawa'); ?></h3>
                    <?php echo do_shortcode('[mohtawa_search_form layout="vertical" show_filters="true"]'); ?>
                </div>
                
                <!-- الفئات الشائعة -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php _e('الفئات الشائعة', 'mohtawa'); ?></h3>
                    <?php
                    $popular_categories = get_terms(array(
                        'taxonomy' => 'store_category',
                        'hide_empty' => true,
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 8
                    ));
                    
                    if ($popular_categories && !is_wp_error($popular_categories)) :
                    ?>
                        <ul class="category-list">
                            <?php foreach ($popular_categories as $category) : ?>
                                <li>
                                    <a href="<?php echo get_term_link($category); ?>">
                                        <?php echo esc_html($category->name); ?>
                                        <span class="count">(<?php echo $category->count; ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <!-- المتاجر المميزة -->
                <div class="sidebar-widget">
                    <h3 class="widget-title"><?php _e('متاجر مميزة', 'mohtawa'); ?></h3>
                    <?php
                    $featured_stores = get_posts(array(
                        'post_type' => 'store',
                        'posts_per_page' => 5,
                        'meta_key' => 'store_featured',
                        'meta_value' => '1',
                        'orderby' => 'rand'
                    ));
                    
                    if ($featured_stores) :
                    ?>
                        <ul class="featured-stores-list">
                            <?php foreach ($featured_stores as $store) : ?>
                                <li>
                                    <a href="<?php echo get_permalink($store->ID); ?>">
                                        <?php echo esc_html($store->post_title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
            </aside>
            
        </div>
    </div>
</main>

<style>
.search-results-header {
    text-align: center;
    margin: 40px 0;
    padding: 30px 0;
    border-bottom: 2px solid #eee;
}

.search-results-title {
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 10px;
}

.search-term {
    color: #3498db;
    font-weight: bold;
}

.search-results-count {
    color: #7f8c8d;
    font-size: 16px;
}

.search-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    margin: 40px 0;
}

.search-result-item {
    background: white;
    border: 1px solid #eee;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
    transition: box-shadow 0.2s;
}

.search-result-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.store-search-result {
    display: flex;
    padding: 20px;
}

.store-image {
    width: 150px;
    height: 150px;
    margin-left: 20px;
    position: relative;
    flex-shrink: 0;
}

.store-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.featured-badge {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #e74c3c;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.store-content {
    flex: 1;
}

.store-title {
    margin: 0 0 10px;
    font-size: 20px;
}

.store-title a {
    text-decoration: none;
    color: #2c3e50;
}

.store-title a:hover {
    color: #3498db;
}

.store-rating {
    color: #f39c12;
    margin-bottom: 10px;
}

.store-address {
    color: #7f8c8d;
    margin-bottom: 10px;
    font-size: 14px;
}

.store-address i {
    margin-left: 5px;
}

.store-excerpt {
    color: #555;
    line-height: 1.6;
    margin-bottom: 15px;
}

.store-meta {
    display: flex;
    gap: 15px;
    align-items: center;
}

.store-category {
    background: #ecf0f1;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    color: #2c3e50;
}

.store-phone {
    color: #27ae60;
    text-decoration: none;
    font-size: 14px;
}

.store-phone:hover {
    text-decoration: underline;
}

.post-search-result {
    padding: 20px;
}

.post-title {
    margin: 0 0 10px;
    font-size: 18px;
}

.post-title a {
    text-decoration: none;
    color: #2c3e50;
}

.post-title a:hover {
    color: #3498db;
}

.post-meta {
    color: #7f8c8d;
    font-size: 14px;
    margin-bottom: 10px;
}

.post-meta span {
    margin-left: 15px;
}

.post-meta i {
    margin-left: 5px;
}

.no-results {
    text-align: center;
    padding: 60px 20px;
}

.no-results-icon {
    font-size: 64px;
    color: #bdc3c7;
    margin-bottom: 20px;
}

.no-results h2 {
    color: #2c3e50;
    margin-bottom: 15px;
}

.search-suggestions {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-top: 30px;
    text-align: right;
}

.search-suggestions h3 {
    margin-bottom: 15px;
    color: #2c3e50;
}

.search-suggestions ul {
    list-style: none;
    padding: 0;
}

.search-suggestions li {
    margin-bottom: 8px;
    color: #555;
}

.search-sidebar .sidebar-widget {
    background: white;
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.sidebar-widget .widget-title {
    margin: 0 0 15px;
    font-size: 18px;
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

.category-list,
.featured-stores-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li,
.featured-stores-list li {
    margin-bottom: 8px;
}

.category-list a,
.featured-stores-list a {
    text-decoration: none;
    color: #555;
    font-size: 14px;
}

.category-list a:hover,
.featured-stores-list a:hover {
    color: #3498db;
}

.category-list .count {
    color: #999;
    font-size: 12px;
}

@media (max-width: 768px) {
    .search-content {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .store-search-result {
        flex-direction: column;
    }
    
    .store-image {
        width: 100%;
        height: 200px;
        margin-left: 0;
        margin-bottom: 15px;
    }
    
    .store-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>

<?php get_footer(); ?>

