<?php
/**
 * صفحة أرشيف المتاجر
 *
 * @package Mohtawa
 * @version 1.0.0
 */

get_header(); ?>

<div class="stores-archive-page">
    
    <!-- رأس الصفحة -->
    <section class="archive-hero-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="archive-header text-center">
                        <h1 class="archive-title"><?php _e('دليل المتاجر', 'mohtawa'); ?></h1>
                        <p class="archive-description lead">
                            <?php _e('اكتشف أفضل المتاجر في منطقتك واعثر على ما تحتاجه بسهولة', 'mohtawa'); ?>
                        </p>
                        
                        <!-- إحصائيات سريعة -->
                        <div class="archive-stats">
                            <div class="row justify-content-center">
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <div class="stat-number" data-count="<?php echo wp_count_posts('store')->publish; ?>">0</div>
                                        <div class="stat-label"><?php _e('متجر', 'mohtawa'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <div class="stat-number" data-count="<?php echo wp_count_terms('store_category'); ?>">0</div>
                                        <div class="stat-label"><?php _e('فئة', 'mohtawa'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <div class="stat-number" data-count="<?php echo wp_count_terms('store_location'); ?>">0</div>
                                        <div class="stat-label"><?php _e('منطقة', 'mohtawa'); ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="stat-item">
                                        <div class="stat-number" data-count="<?php echo get_comments(array('post_type' => 'store', 'count' => true)); ?>">0</div>
                                        <div class="stat-label"><?php _e('تقييم', 'mohtawa'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- شريط البحث والفلاتر -->
    <section class="search-filters-section">
        <div class="container">
            <div class="search-filters-card">
                <div class="row">
                    <!-- البحث الرئيسي -->
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="search-group">
                            <label for="archive-search" class="form-label"><?php _e('البحث', 'mohtawa'); ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="archive-search" placeholder="<?php _e('ابحث عن متجر...', 'mohtawa'); ?>">
                                <button class="btn btn-outline-secondary" type="button" id="clear-archive-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- فلتر الفئة -->
                    <div class="col-lg-2 col-md-6 mb-3">
                        <div class="filter-group">
                            <label for="archive-category-filter" class="form-label"><?php _e('الفئة', 'mohtawa'); ?></label>
                            <select class="form-select" id="archive-category-filter">
                                <option value=""><?php _e('جميع الفئات', 'mohtawa'); ?></option>
                                <?php
                                $categories = get_terms(array(
                                    'taxonomy' => 'store_category',
                                    'hide_empty' => true
                                ));
                                foreach ($categories as $category) :
                                ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>">
                                        <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- فلتر المنطقة -->
                    <div class="col-lg-2 col-md-6 mb-3">
                        <div class="filter-group">
                            <label for="archive-location-filter" class="form-label"><?php _e('المنطقة', 'mohtawa'); ?></label>
                            <select class="form-select" id="archive-location-filter">
                                <option value=""><?php _e('جميع المناطق', 'mohtawa'); ?></option>
                                <?php
                                $locations = get_terms(array(
                                    'taxonomy' => 'store_location',
                                    'hide_empty' => true
                                ));
                                foreach ($locations as $location) :
                                ?>
                                    <option value="<?php echo esc_attr($location->slug); ?>">
                                        <?php echo esc_html($location->name); ?> (<?php echo $location->count; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- فلتر التقييم -->
                    <div class="col-lg-2 col-md-6 mb-3">
                        <div class="filter-group">
                            <label for="archive-rating-filter" class="form-label"><?php _e('التقييم', 'mohtawa'); ?></label>
                            <select class="form-select" id="archive-rating-filter">
                                <option value=""><?php _e('جميع التقييمات', 'mohtawa'); ?></option>
                                <option value="5"><?php _e('5 نجوم', 'mohtawa'); ?></option>
                                <option value="4"><?php _e('4 نجوم فأكثر', 'mohtawa'); ?></option>
                                <option value="3"><?php _e('3 نجوم فأكثر', 'mohtawa'); ?></option>
                                <option value="2"><?php _e('نجمتان فأكثر', 'mohtawa'); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- الترتيب -->
                    <div class="col-lg-2 col-md-6 mb-3">
                        <div class="filter-group">
                            <label for="archive-sort" class="form-label"><?php _e('ترتيب حسب', 'mohtawa'); ?></label>
                            <select class="form-select" id="archive-sort">
                                <option value="newest"><?php _e('الأحدث', 'mohtawa'); ?></option>
                                <option value="name"><?php _e('الاسم', 'mohtawa'); ?></option>
                                <option value="rating"><?php _e('التقييم', 'mohtawa'); ?></option>
                                <option value="featured"><?php _e('المميزة', 'mohtawa'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- فلاتر متقدمة -->
                <div class="advanced-filters-toggle">
                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#advanced-filters-archive" aria-expanded="false">
                        <i class="fas fa-sliders-h me-1"></i>
                        <?php _e('فلاتر متقدمة', 'mohtawa'); ?>
                    </button>
                </div>
                
                <div class="collapse" id="advanced-filters-archive">
                    <div class="advanced-filters-content">
                        <div class="row">
                            <!-- حالة المتجر -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"><?php _e('حالة المتجر', 'mohtawa'); ?></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter-open" name="status[]" value="open">
                                    <label class="form-check-label" for="filter-open">
                                        <?php _e('مفتوح الآن', 'mohtawa'); ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter-featured" name="features[]" value="featured">
                                    <label class="form-check-label" for="filter-featured">
                                        <?php _e('متاجر مميزة', 'mohtawa'); ?>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- الخدمات -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label"><?php _e('الخدمات', 'mohtawa'); ?></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter-delivery" name="features[]" value="delivery">
                                    <label class="form-check-label" for="filter-delivery">
                                        <?php _e('خدمة التوصيل', 'mohtawa'); ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter-parking" name="features[]" value="parking">
                                    <label class="form-check-label" for="filter-parking">
                                        <?php _e('موقف سيارات', 'mohtawa'); ?>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filter-wifi" name="features[]" value="wifi">
                                    <label class="form-check-label" for="filter-wifi">
                                        <?php _e('واي فاي مجاني', 'mohtawa'); ?>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- المسافة -->
                            <div class="col-md-3 mb-3">
                                <label for="distance-range" class="form-label"><?php _e('المسافة (كم)', 'mohtawa'); ?></label>
                                <select class="form-select" id="distance-range">
                                    <option value=""><?php _e('جميع المسافات', 'mohtawa'); ?></option>
                                    <option value="1"><?php _e('أقل من 1 كم', 'mohtawa'); ?></option>
                                    <option value="5"><?php _e('أقل من 5 كم', 'mohtawa'); ?></option>
                                    <option value="10"><?php _e('أقل من 10 كم', 'mohtawa'); ?></option>
                                    <option value="25"><?php _e('أقل من 25 كم', 'mohtawa'); ?></option>
                                </select>
                            </div>
                            
                            <!-- أزرار التحكم -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary" id="apply-archive-filters">
                                        <i class="fas fa-search me-1"></i>
                                        <?php _e('تطبيق الفلاتر', 'mohtawa'); ?>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="clear-archive-filters">
                                        <i class="fas fa-times me-1"></i>
                                        <?php _e('مسح الفلاتر', 'mohtawa'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- النتائج -->
    <section class="stores-results-section">
        <div class="container">
            
            <!-- شريط النتائج -->
            <div class="results-bar">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="results-info">
                        <span id="results-count"><?php _e('جاري التحميل...', 'mohtawa'); ?></span>
                    </div>
                    
                    <div class="view-options">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary active" id="grid-view-btn">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="list-view-btn">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- مؤشر التحميل -->
            <div id="archive-loading" class="text-center py-5" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden"><?php _e('جاري التحميل...', 'mohtawa'); ?></span>
                </div>
                <p class="mt-2"><?php _e('جاري تحميل المتاجر...', 'mohtawa'); ?></p>
            </div>
            
            <!-- قائمة المتاجر -->
            <div id="stores-grid" class="stores-grid">
                <!-- سيتم تحميل المتاجر هنا عبر AJAX -->
            </div>
            
            <!-- رسالة عدم وجود نتائج -->
            <div id="no-results" class="text-center py-5" style="display: none;">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3 class="text-muted"><?php _e('لا توجد نتائج', 'mohtawa'); ?></h3>
                <p class="text-muted"><?php _e('لم نجد أي متاجر تطابق معايير البحث الخاصة بك. جرب تعديل الفلاتر أو البحث بكلمات مختلفة.', 'mohtawa'); ?></p>
                <button type="button" class="btn btn-primary" id="reset-search">
                    <i class="fas fa-refresh me-1"></i>
                    <?php _e('إعادة تعيين البحث', 'mohtawa'); ?>
                </button>
            </div>
            
            <!-- زر تحميل المزيد -->
            <div id="load-more-archive-container" class="text-center mt-4" style="display: none;">
                <button type="button" class="btn btn-outline-primary btn-lg" id="load-more-archive">
                    <i class="fas fa-plus me-1"></i>
                    <?php _e('تحميل المزيد', 'mohtawa'); ?>
                </button>
            </div>
            
        </div>
    </section>
    
    <!-- فئات المتاجر -->
    <section class="categories-section py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title"><?php _e('تصفح حسب الفئة', 'mohtawa'); ?></h2>
                <p class="section-description"><?php _e('اكتشف المتاجر حسب الفئات المختلفة', 'mohtawa'); ?></p>
            </div>
            
            <div class="categories-grid">
                <div class="row">
                    <?php
                    $featured_categories = get_terms(array(
                        'taxonomy' => 'store_category',
                        'hide_empty' => true,
                        'number' => 8,
                        'orderby' => 'count',
                        'order' => 'DESC'
                    ));
                    
                    foreach ($featured_categories as $category) :
                        $color = get_term_meta($category->term_id, 'category_color', true) ?: '#3498db';
                        $icon = get_term_meta($category->term_id, 'category_icon', true) ?: 'store';
                        $image = get_term_meta($category->term_id, 'category_image', true);
                    ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="category-card">
                                <a href="<?php echo get_term_link($category); ?>" class="text-decoration-none">
                                    <div class="category-icon" style="background-color: <?php echo esc_attr($color); ?>">
                                        <i class="fas fa-<?php echo esc_attr($icon); ?>"></i>
                                    </div>
                                    <div class="category-info">
                                        <h5 class="category-name"><?php echo esc_html($category->name); ?></h5>
                                        <p class="category-count"><?php echo sprintf(_n('%d متجر', '%d متجر', $category->count, 'mohtawa'), $category->count); ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let isLoading = false;
    let currentView = 'grid';
    let currentFilters = {};
    
    // تحميل المتاجر الأولي
    loadStores();
    
    // مستمعي الأحداث
    document.getElementById('archive-search').addEventListener('input', debounce(handleSearch, 300));
    document.getElementById('archive-category-filter').addEventListener('change', handleFilterChange);
    document.getElementById('archive-location-filter').addEventListener('change', handleFilterChange);
    document.getElementById('archive-rating-filter').addEventListener('change', handleFilterChange);
    document.getElementById('archive-sort').addEventListener('change', handleFilterChange);
    
    document.getElementById('apply-archive-filters').addEventListener('click', applyFilters);
    document.getElementById('clear-archive-filters').addEventListener('click', clearFilters);
    document.getElementById('clear-archive-search').addEventListener('click', clearSearch);
    document.getElementById('reset-search').addEventListener('click', resetSearch);
    
    document.getElementById('grid-view-btn').addEventListener('click', () => switchView('grid'));
    document.getElementById('list-view-btn').addEventListener('click', () => switchView('list'));
    
    document.getElementById('load-more-archive').addEventListener('click', loadMoreStores);
    
    // وظائف البحث والفلترة
    function handleSearch() {
        currentFilters.search = document.getElementById('archive-search').value;
        currentPage = 1;
        loadStores();
    }
    
    function handleFilterChange() {
        applyFilters();
    }
    
    function applyFilters() {
        currentFilters = {
            search: document.getElementById('archive-search').value,
            category: document.getElementById('archive-category-filter').value,
            location: document.getElementById('archive-location-filter').value,
            rating: document.getElementById('archive-rating-filter').value,
            sort: document.getElementById('archive-sort').value,
            distance: document.getElementById('distance-range').value,
            features: Array.from(document.querySelectorAll('input[name="features[]"]:checked')).map(cb => cb.value),
            status: Array.from(document.querySelectorAll('input[name="status[]"]:checked')).map(cb => cb.value)
        };
        
        currentPage = 1;
        loadStores();
    }
    
    function clearFilters() {
        document.getElementById('archive-search').value = '';
        document.getElementById('archive-category-filter').value = '';
        document.getElementById('archive-location-filter').value = '';
        document.getElementById('archive-rating-filter').value = '';
        document.getElementById('distance-range').value = '';
        document.querySelectorAll('input[name="features[]"], input[name="status[]"]').forEach(cb => cb.checked = false);
        
        currentFilters = {};
        currentPage = 1;
        loadStores();
    }
    
    function clearSearch() {
        document.getElementById('archive-search').value = '';
        delete currentFilters.search;
        currentPage = 1;
        loadStores();
    }
    
    function resetSearch() {
        clearFilters();
        document.getElementById('no-results').style.display = 'none';
    }
    
    function switchView(view) {
        currentView = view;
        
        document.getElementById('grid-view-btn').classList.toggle('active', view === 'grid');
        document.getElementById('list-view-btn').classList.toggle('active', view === 'list');
        
        document.getElementById('stores-grid').className = view === 'grid' ? 'stores-grid' : 'stores-list';
        
        // إعادة تحميل المتاجر بالعرض الجديد
        currentPage = 1;
        loadStores();
    }
    
    function loadStores(append = false) {
        if (isLoading) return;
        
        isLoading = true;
        
        if (!append) {
            document.getElementById('archive-loading').style.display = 'block';
            document.getElementById('stores-grid').innerHTML = '';
            document.getElementById('no-results').style.display = 'none';
        }
        
        const formData = new FormData();
        formData.append('action', 'get_stores');
        formData.append('page', currentPage);
        formData.append('filters', JSON.stringify(currentFilters));
        formData.append('view', currentView);
        formData.append('nonce', mohtawaTheme.nonce);
        
        fetch(mohtawaTheme.ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (append) {
                    document.getElementById('stores-grid').insertAdjacentHTML('beforeend', data.data.html);
                } else {
                    document.getElementById('stores-grid').innerHTML = data.data.html;
                }
                
                updateResultsCount(data.data.total, data.data.showing);
                
                if (data.data.has_more) {
                    document.getElementById('load-more-archive-container').style.display = 'block';
                } else {
                    document.getElementById('load-more-archive-container').style.display = 'none';
                }
                
                if (data.data.total === 0) {
                    document.getElementById('no-results').style.display = 'block';
                }
            } else {
                console.error('Error loading stores:', data.data);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            isLoading = false;
            document.getElementById('archive-loading').style.display = 'none';
        });
    }
    
    function loadMoreStores() {
        currentPage++;
        loadStores(true);
    }
    
    function updateResultsCount(total, showing) {
        const resultsText = total === 0 
            ? '<?php _e("لا توجد نتائج", "mohtawa"); ?>'
            : `<?php _e("عرض", "mohtawa"); ?> ${showing} <?php _e("من أصل", "mohtawa"); ?> ${total} <?php _e("متجر", "mohtawa"); ?>`;
        
        document.getElementById('results-count').textContent = resultsText;
    }
    
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // تحريك الإحصائيات
    const statNumbers = document.querySelectorAll('.stat-number');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });
    
    statNumbers.forEach(stat => observer.observe(stat));
    
    function animateCounter(element) {
        const target = parseInt(element.dataset.count);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString('ar');
        }, 16);
    }
});
</script>

<style>
.archive-hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
}

.archive-stats {
    margin-top: 2rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    display: block;
}

.stat-label {
    font-size: 1rem;
    opacity: 0.9;
}

.search-filters-section {
    padding: 2rem 0;
    background-color: #f8f9fa;
}

.search-filters-card {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
}

.stores-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 2rem;
}

.stores-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.category-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
}

.category-card:hover {
    transform: translateY(-0.25rem);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

.category-icon {
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.category-name {
    margin-bottom: 0.5rem;
    color: #333;
}

.category-count {
    color: #666;
    margin: 0;
}

.results-bar {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 1rem;
}

@media (max-width: 768px) {
    .archive-hero-section {
        padding: 2rem 0;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .search-filters-card {
        padding: 1rem;
    }
    
    .stores-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>

