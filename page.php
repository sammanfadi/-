<?php
/**
 * قالب الصفحات العادية
 *
 * @package Mohtawa
 * @version 1.0.0
 */

get_header(); ?>

<main class="main-content">
    <div class="container">
        
        <?php mohtawa_breadcrumbs(); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
                
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    
                    <?php if (has_excerpt()) : ?>
                        <div class="page-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="page-content-area">
                    <?php
                    the_content();
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('الصفحات:', 'mohtawa'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>
                
                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="page-comments">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>
                
            </article>
            
        <?php endwhile; ?>
        
    </div>
</main>

<style>
.page-content {
    background: white;
    border-radius: 8px;
    padding: 40px;
    margin: 20px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 2px solid #eee;
}

.page-title {
    font-size: 36px;
    color: #2c3e50;
    margin: 0 0 20px;
    font-weight: 700;
}

.page-excerpt {
    font-size: 18px;
    color: #7f8c8d;
    line-height: 1.6;
    max-width: 600px;
    margin: 0 auto;
}

.page-featured-image {
    margin: 30px 0;
    text-align: center;
}

.page-featured-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.page-content-area {
    font-size: 16px;
    line-height: 1.8;
    color: #333;
}

.page-content-area h1,
.page-content-area h2,
.page-content-area h3,
.page-content-area h4,
.page-content-area h5,
.page-content-area h6 {
    color: #2c3e50;
    margin: 30px 0 15px;
    font-weight: 600;
}

.page-content-area h2 {
    font-size: 28px;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

.page-content-area h3 {
    font-size: 24px;
}

.page-content-area h4 {
    font-size: 20px;
}

.page-content-area p {
    margin-bottom: 20px;
}

.page-content-area ul,
.page-content-area ol {
    margin: 20px 0;
    padding-right: 30px;
}

.page-content-area li {
    margin-bottom: 8px;
}

.page-content-area blockquote {
    background: #f8f9fa;
    border-right: 4px solid #3498db;
    padding: 20px;
    margin: 30px 0;
    font-style: italic;
    border-radius: 4px;
}

.page-content-area table {
    width: 100%;
    border-collapse: collapse;
    margin: 30px 0;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.page-content-area th,
.page-content-area td {
    padding: 12px 15px;
    text-align: right;
    border-bottom: 1px solid #eee;
}

.page-content-area th {
    background: #f8f9fa;
    font-weight: 600;
    color: #2c3e50;
}

.page-content-area img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin: 20px 0;
}

.page-content-area a {
    color: #3498db;
    text-decoration: none;
}

.page-content-area a:hover {
    text-decoration: underline;
}

.page-links {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 30px 0;
    text-align: center;
}

.page-links a {
    display: inline-block;
    padding: 8px 15px;
    margin: 0 5px;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 600;
}

.page-links a:hover {
    background: #2980b9;
}

.page-links .current {
    display: inline-block;
    padding: 8px 15px;
    margin: 0 5px;
    background: #2c3e50;
    color: white;
    border-radius: 4px;
    font-weight: 600;
}

.page-comments {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 2px solid #eee;
}

/* تحسينات للأجهزة المحمولة */
@media (max-width: 768px) {
    .page-content {
        padding: 20px;
        margin: 10px;
        border-radius: 4px;
    }
    
    .page-title {
        font-size: 28px;
    }
    
    .page-excerpt {
        font-size: 16px;
    }
    
    .page-content-area {
        font-size: 15px;
    }
    
    .page-content-area h2 {
        font-size: 24px;
    }
    
    .page-content-area h3 {
        font-size: 20px;
    }
    
    .page-content-area ul,
    .page-content-area ol {
        padding-right: 20px;
    }
    
    .page-content-area table {
        font-size: 14px;
    }
    
    .page-content-area th,
    .page-content-area td {
        padding: 8px 10px;
    }
}

/* تحسينات للطباعة */
@media print {
    .page-content {
        box-shadow: none;
        border: 1px solid #ddd;
    }
    
    .page-featured-image img {
        box-shadow: none;
    }
    
    .page-content-area a {
        color: #000;
        text-decoration: underline;
    }
    
    .page-links {
        display: none;
    }
}
</style>

<?php get_footer(); ?>

