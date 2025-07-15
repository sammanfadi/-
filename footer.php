        <!-- منطقة بعد المحتوى -->
        <?php if (is_active_sidebar('after-content')) : ?>
            <div class="after-content-area py-4 bg-light">
                <div class="container">
                    <?php dynamic_sidebar('after-content'); ?>
                </div>
            </div>
        <?php endif; ?>
        
    </main><!-- #main-content -->
    
    <!-- تذييل الموقع -->
    <footer id="colophon" class="site-footer bg-dark text-light">
        
        <!-- منطقة الودجات الرئيسية -->
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
            <div class="footer-widgets py-5">
                <div class="container">
                    <div class="row">
                        <?php if (is_active_sidebar('footer-1')) : ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <?php dynamic_sidebar('footer-1'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-2')) : ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <?php dynamic_sidebar('footer-2'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-3')) : ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <?php dynamic_sidebar('footer-3'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (is_active_sidebar('footer-4')) : ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <?php dynamic_sidebar('footer-4'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- معلومات الاتصال والروابط السريعة -->
        <div class="footer-main py-4 border-top border-secondary">
            <div class="container">
                <div class="row">
                    <!-- معلومات الموقع -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-about">
                            <?php if (has_custom_logo()) : ?>
                                <div class="footer-logo mb-3">
                                    <?php the_custom_logo(); ?>
                                </div>
                            <?php else : ?>
                                <h5 class="footer-title text-white mb-3"><?php bloginfo('name'); ?></h5>
                            <?php endif; ?>
                            
                            <p class="text-light-gray mb-3">
                                <?php echo esc_html(get_theme_mod('mohtawa_footer_description', get_bloginfo('description'))); ?>
                            </p>
                            
                            <!-- معلومات الاتصال -->
                            <div class="contact-info">
                                <?php if (get_theme_mod('mohtawa_address')) : ?>
                                    <div class="contact-item d-flex align-items-start mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2 mt-1"></i>
                                        <span class="text-light-gray"><?php echo esc_html(get_theme_mod('mohtawa_address')); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_phone')) : ?>
                                    <div class="contact-item d-flex align-items-center mb-2">
                                        <i class="fas fa-phone-alt text-primary me-2"></i>
                                        <a href="tel:<?php echo esc_attr(get_theme_mod('mohtawa_phone')); ?>" class="text-light-gray text-decoration-none">
                                            <?php echo esc_html(get_theme_mod('mohtawa_phone')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_email')) : ?>
                                    <div class="contact-item d-flex align-items-center mb-2">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <a href="mailto:<?php echo esc_attr(get_theme_mod('mohtawa_email')); ?>" class="text-light-gray text-decoration-none">
                                            <?php echo esc_html(get_theme_mod('mohtawa_email')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- الروابط السريعة -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h6 class="footer-title text-white mb-3"><?php _e('روابط سريعة', 'mohtawa'); ?></h6>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu list-unstyled',
                            'container'      => false,
                            'depth'          => 1,
                            'fallback_cb'    => false,
                            'link_before'    => '<i class="fas fa-chevron-left me-2 small"></i>',
                        ));
                        ?>
                    </div>
                    
                    <!-- أنواع المتاجر -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h6 class="footer-title text-white mb-3"><?php _e('أنواع المتاجر', 'mohtawa'); ?></h6>
                        <div class="store-categories">
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'store_category',
                                'hide_empty' => false,
                                'number' => 6,
                            ));
                            
                            if ($categories && !is_wp_error($categories)) :
                                echo '<ul class="list-unstyled">';
                                foreach ($categories as $category) :
                                    $color = get_term_meta($category->term_id, 'category_color', true);
                                    $icon = get_term_meta($category->term_id, 'category_icon', true);
                                    ?>
                                    <li class="mb-2">
                                        <a href="<?php echo esc_url(get_term_link($category)); ?>" class="text-light-gray text-decoration-none d-flex align-items-center">
                                            <?php if ($icon) : ?>
                                                <i class="fas fa-<?php echo esc_attr($icon); ?> me-2" style="color: <?php echo esc_attr($color ?: '#3498db'); ?>"></i>
                                            <?php endif; ?>
                                            <?php echo esc_html($category->name); ?>
                                            <small class="text-muted ms-auto">(<?php echo $category->count; ?>)</small>
                                        </a>
                                    </li>
                                    <?php
                                endforeach;
                                echo '</ul>';
                            endif;
                            ?>
                        </div>
                    </div>
                    
                    <!-- النشرة الإخبارية ووسائل التواصل -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h6 class="footer-title text-white mb-3"><?php _e('ابق على تواصل', 'mohtawa'); ?></h6>
                        
                        <!-- النشرة الإخبارية -->
                        <?php if (get_theme_mod('mohtawa_newsletter_enabled', true)) : ?>
                            <div class="newsletter-signup mb-4">
                                <p class="text-light-gray small mb-3"><?php _e('اشترك في نشرتنا الإخبارية للحصول على آخر الأخبار والعروض', 'mohtawa'); ?></p>
                                <form class="newsletter-form" action="#" method="post">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="<?php _e('بريدك الإلكتروني', 'mohtawa'); ?>" required>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                        
                        <!-- وسائل التواصل الاجتماعي -->
                        <div class="social-media">
                            <h6 class="text-white mb-3"><?php _e('تابعنا', 'mohtawa'); ?></h6>
                            <div class="social-links d-flex flex-wrap">
                                <?php if (get_theme_mod('mohtawa_facebook_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_facebook_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('فيسبوك', 'mohtawa'); ?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_twitter_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_twitter_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('تويتر', 'mohtawa'); ?>">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_instagram_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_instagram_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('إنستغرام', 'mohtawa'); ?>">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_linkedin_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_linkedin_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('لينكد إن', 'mohtawa'); ?>">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_youtube_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_youtube_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('يوتيوب', 'mohtawa'); ?>">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_whatsapp_number')) : ?>
                                    <a href="https://wa.me/<?php echo esc_attr(str_replace(array('+', ' ', '-'), '', get_theme_mod('mohtawa_whatsapp_number'))); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('واتساب', 'mohtawa'); ?>">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_telegram_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_telegram_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('تيليجرام', 'mohtawa'); ?>">
                                        <i class="fab fa-telegram-plane"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_snapchat_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_snapchat_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('سناب شات', 'mohtawa'); ?>">
                                        <i class="fab fa-snapchat-ghost"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (get_theme_mod('mohtawa_tiktok_url')) : ?>
                                    <a href="<?php echo esc_url(get_theme_mod('mohtawa_tiktok_url')); ?>" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm me-2 mb-2" title="<?php _e('تيك توك', 'mohtawa'); ?>">
                                        <i class="fab fa-tiktok"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- شريط حقوق النشر -->
        <div class="footer-bottom py-3 border-top border-secondary">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="copyright text-light-gray">
                            <p class="mb-0">
                                &copy; <?php echo date('Y'); ?> 
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-white text-decoration-none">
                                    <?php bloginfo('name'); ?>
                                </a>
                                <?php _e('جميع الحقوق محفوظة', 'mohtawa'); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-links text-md-end">
                            <div class="d-flex flex-wrap justify-content-md-end">
                                <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="text-light-gray text-decoration-none me-3 small">
                                    <?php _e('سياسة الخصوصية', 'mohtawa'); ?>
                                </a>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>" class="text-light-gray text-decoration-none me-3 small">
                                    <?php _e('شروط الاستخدام', 'mohtawa'); ?>
                                </a>
                                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact'))); ?>" class="text-light-gray text-decoration-none small">
                                    <?php _e('اتصل بنا', 'mohtawa'); ?>
                                </a>
                            </div>
                            
                            <!-- معلومات المطور -->
                            <?php if (get_theme_mod('mohtawa_show_developer_credit', true)) : ?>
                                <div class="developer-credit mt-2">
                                    <small class="text-muted">
                                        <?php _e('تطوير', 'mohtawa'); ?>
                                        <a href="https://manus.ai" target="_blank" rel="noopener" class="text-primary text-decoration-none">
                                            Manus AI
                                        </a>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->
    
    <!-- زر العودة للأعلى -->
    <button id="back-to-top" class="btn btn-primary rounded-circle position-fixed" style="bottom: 20px; left: 20px; z-index: 1000; display: none;" title="<?php _e('العودة للأعلى', 'mohtawa'); ?>">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- نافذة تأكيد الكوكيز -->
    <?php if (get_theme_mod('mohtawa_cookie_notice_enabled', true)) : ?>
        <div id="cookie-notice" class="cookie-notice position-fixed bottom-0 start-0 end-0 bg-dark text-white p-3" style="z-index: 9999; display: none;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <p class="mb-0">
                            <?php echo esc_html(get_theme_mod('mohtawa_cookie_notice_text', __('نحن نستخدم ملفات تعريف الارتباط لتحسين تجربتك على موقعنا. بمتابعة التصفح، فإنك توافق على استخدام هذه الملفات.', 'mohtawa'))); ?>
                            <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="text-primary text-decoration-none">
                                <?php _e('اعرف المزيد', 'mohtawa'); ?>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <button id="accept-cookies" class="btn btn-primary btn-sm me-2">
                            <?php _e('موافق', 'mohtawa'); ?>
                        </button>
                        <button id="decline-cookies" class="btn btn-outline-light btn-sm">
                            <?php _e('رفض', 'mohtawa'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- نافذة تحميل -->
    <div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white" style="z-index: 9999; display: none !important;">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden"><?php _e('جاري التحميل...', 'mohtawa'); ?></span>
            </div>
            <p class="text-muted"><?php _e('جاري التحميل...', 'mohtawa'); ?></p>
        </div>
    </div>
    
    <!-- نافذة مشاركة -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel"><?php _e('مشاركة', 'mohtawa'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php _e('إغلاق', 'mohtawa'); ?>"></button>
                </div>
                <div class="modal-body">
                    <div class="share-buttons d-grid gap-2">
                        <a href="#" class="btn btn-primary" id="share-facebook">
                            <i class="fab fa-facebook-f me-2"></i>
                            <?php _e('فيسبوك', 'mohtawa'); ?>
                        </a>
                        <a href="#" class="btn btn-info" id="share-twitter">
                            <i class="fab fa-twitter me-2"></i>
                            <?php _e('تويتر', 'mohtawa'); ?>
                        </a>
                        <a href="#" class="btn btn-success" id="share-whatsapp">
                            <i class="fab fa-whatsapp me-2"></i>
                            <?php _e('واتساب', 'mohtawa'); ?>
                        </a>
                        <a href="#" class="btn btn-primary" id="share-telegram">
                            <i class="fab fa-telegram-plane me-2"></i>
                            <?php _e('تيليجرام', 'mohtawa'); ?>
                        </a>
                        <button type="button" class="btn btn-secondary" id="copy-link">
                            <i class="fas fa-copy me-2"></i>
                            <?php _e('نسخ الرابط', 'mohtawa'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- سكريبتات إضافية -->
    <script>
        // متغيرات JavaScript للقالب
        window.mohtawaTheme = {
            ajaxUrl: '<?php echo admin_url('admin-ajax.php'); ?>',
            nonce: '<?php echo wp_create_nonce('mohtawa_nonce'); ?>',
            homeUrl: '<?php echo home_url('/'); ?>',
            themeUrl: '<?php echo get_template_directory_uri(); ?>',
            isRTL: <?php echo is_rtl() ? 'true' : 'false'; ?>,
            currentUrl: '<?php echo esc_url(get_permalink()); ?>',
            currentTitle: '<?php echo esc_js(get_the_title()); ?>',
            strings: {
                loading: '<?php _e('جاري التحميل...', 'mohtawa'); ?>',
                error: '<?php _e('حدث خطأ، يرجى المحاولة مرة أخرى', 'mohtawa'); ?>',
                success: '<?php _e('تم بنجاح', 'mohtawa'); ?>',
                confirm: '<?php _e('هل أنت متأكد؟', 'mohtawa'); ?>',
                cancel: '<?php _e('إلغاء', 'mohtawa'); ?>',
                ok: '<?php _e('موافق', 'mohtawa'); ?>',
                close: '<?php _e('إغلاق', 'mohtawa'); ?>',
                noResults: '<?php _e('لا توجد نتائج', 'mohtawa'); ?>',
                loadMore: '<?php _e('تحميل المزيد', 'mohtawa'); ?>',
                showMore: '<?php _e('عرض المزيد', 'mohtawa'); ?>',
                showLess: '<?php _e('عرض أقل', 'mohtawa'); ?>',
                readMore: '<?php _e('اقرأ المزيد', 'mohtawa'); ?>',
                linkCopied: '<?php _e('تم نسخ الرابط', 'mohtawa'); ?>',
                shareTitle: '<?php _e('مشاركة هذه الصفحة', 'mohtawa'); ?>',
                locationError: '<?php _e('لم نتمكن من تحديد موقعك', 'mohtawa'); ?>',
                locationPermission: '<?php _e('يرجى السماح بالوصول للموقع', 'mohtawa'); ?>',
                searchPlaceholder: '<?php _e('ابحث عن متجر...', 'mohtawa'); ?>',
                filterAll: '<?php _e('الكل', 'mohtawa'); ?>',
                sortBy: '<?php _e('ترتيب حسب', 'mohtawa'); ?>',
                sortNewest: '<?php _e('الأحدث', 'mohtawa'); ?>',
                sortOldest: '<?php _e('الأقدم', 'mohtawa'); ?>',
                sortRating: '<?php _e('التقييم', 'mohtawa'); ?>',
                sortDistance: '<?php _e('المسافة', 'mohtawa'); ?>',
                sortName: '<?php _e('الاسم', 'mohtawa'); ?>',
                openNow: '<?php _e('مفتوح الآن', 'mohtawa'); ?>',
                closed: '<?php _e('مغلق', 'mohtawa'); ?>',
                getDirections: '<?php _e('الحصول على الاتجاهات', 'mohtawa'); ?>',
                callNow: '<?php _e('اتصل الآن', 'mohtawa'); ?>',
                visitWebsite: '<?php _e('زيارة الموقع', 'mohtawa'); ?>',
                viewDetails: '<?php _e('عرض التفاصيل', 'mohtawa'); ?>',
                addReview: '<?php _e('إضافة تقييم', 'mohtawa'); ?>',
                writeReview: '<?php _e('كتابة تقييم', 'mohtawa'); ?>',
                submitReview: '<?php _e('إرسال التقييم', 'mohtawa'); ?>',
                thankYou: '<?php _e('شكراً لك', 'mohtawa'); ?>',
                reviewSubmitted: '<?php _e('تم إرسال تقييمك بنجاح', 'mohtawa'); ?>',
                pleaseWait: '<?php _e('يرجى الانتظار...', 'mohtawa'); ?>',
                tryAgain: '<?php _e('حاول مرة أخرى', 'mohtawa'); ?>',
                networkError: '<?php _e('خطأ في الشبكة', 'mohtawa'); ?>',
                serverError: '<?php _e('خطأ في الخادم', 'mohtawa'); ?>',
                invalidInput: '<?php _e('بيانات غير صحيحة', 'mohtawa'); ?>',
                requiredField: '<?php _e('هذا الحقل مطلوب', 'mohtawa'); ?>',
                invalidEmail: '<?php _e('بريد إلكتروني غير صحيح', 'mohtawa'); ?>',
                invalidPhone: '<?php _e('رقم هاتف غير صحيح', 'mohtawa'); ?>',
                passwordTooShort: '<?php _e('كلمة المرور قصيرة جداً', 'mohtawa'); ?>',
                passwordMismatch: '<?php _e('كلمات المرور غير متطابقة', 'mohtawa'); ?>',
                fileTooBig: '<?php _e('حجم الملف كبير جداً', 'mohtawa'); ?>',
                invalidFileType: '<?php _e('نوع ملف غير مدعوم', 'mohtawa'); ?>',
                uploadError: '<?php _e('خطأ في رفع الملف', 'mohtawa'); ?>',
                maxFilesExceeded: '<?php _e('تم تجاوز الحد الأقصى للملفات', 'mohtawa'); ?>',
                connectionLost: '<?php _e('انقطع الاتصال بالإنترنت', 'mohtawa'); ?>',
                connectionRestored: '<?php _e('تم استعادة الاتصال', 'mohtawa'); ?>',
                sessionExpired: '<?php _e('انتهت صلاحية الجلسة', 'mohtawa'); ?>',
                pleaseLogin: '<?php _e('يرجى تسجيل الدخول', 'mohtawa'); ?>',
                accessDenied: '<?php _e('ليس لديك صلاحية للوصول', 'mohtawa'); ?>',
                pageNotFound: '<?php _e('الصفحة غير موجودة', 'mohtawa'); ?>',
                goHome: '<?php _e('العودة للرئيسية', 'mohtawa'); ?>',
                refresh: '<?php _e('تحديث', 'mohtawa'); ?>',
                retry: '<?php _e('إعادة المحاولة', 'mohtawa'); ?>',
                skip: '<?php _e('تخطي', 'mohtawa'); ?>',
                next: '<?php _e('التالي', 'mohtawa'); ?>',
                previous: '<?php _e('السابق', 'mohtawa'); ?>',
                finish: '<?php _e('إنهاء', 'mohtawa'); ?>',
                save: '<?php _e('حفظ', 'mohtawa'); ?>',
                edit: '<?php _e('تحرير', 'mohtawa'); ?>',
                delete: '<?php _e('حذف', 'mohtawa'); ?>',
                update: '<?php _e('تحديث', 'mohtawa'); ?>',
                create: '<?php _e('إنشاء', 'mohtawa'); ?>',
                add: '<?php _e('إضافة', 'mohtawa'); ?>',
                remove: '<?php _e('إزالة', 'mohtawa'); ?>',
                clear: '<?php _e('مسح', 'mohtawa'); ?>',
                reset: '<?php _e('إعادة تعيين', 'mohtawa'); ?>',
                apply: '<?php _e('تطبيق', 'mohtawa'); ?>',
                submit: '<?php _e('إرسال', 'mohtawa'); ?>',
                send: '<?php _e('إرسال', 'mohtawa'); ?>',
                publish: '<?php _e('نشر', 'mohtawa'); ?>',
                draft: '<?php _e('مسودة', 'mohtawa'); ?>',
                preview: '<?php _e('معاينة', 'mohtawa'); ?>',
                print: '<?php _e('طباعة', 'mohtawa'); ?>',
                download: '<?php _e('تحميل', 'mohtawa'); ?>',
                upload: '<?php _e('رفع', 'mohtawa'); ?>',
                browse: '<?php _e('تصفح', 'mohtawa'); ?>',
                select: '<?php _e('اختيار', 'mohtawa'); ?>',
                choose: '<?php _e('اختر', 'mohtawa'); ?>',
                pick: '<?php _e('انتقاء', 'mohtawa'); ?>',
                search: '<?php _e('بحث', 'mohtawa'); ?>',
                filter: '<?php _e('تصفية', 'mohtawa'); ?>',
                sort: '<?php _e('ترتيب', 'mohtawa'); ?>',
                view: '<?php _e('عرض', 'mohtawa'); ?>',
                hide: '<?php _e('إخفاء', 'mohtawa'); ?>',
                show: '<?php _e('إظهار', 'mohtawa'); ?>',
                expand: '<?php _e('توسيع', 'mohtawa'); ?>',
                collapse: '<?php _e('طي', 'mohtawa'); ?>',
                open: '<?php _e('فتح', 'mohtawa'); ?>',
                close: '<?php _e('إغلاق', 'mohtawa'); ?>',
                enable: '<?php _e('تفعيل', 'mohtawa'); ?>',
                disable: '<?php _e('تعطيل', 'mohtawa'); ?>',
                on: '<?php _e('تشغيل', 'mohtawa'); ?>',
                off: '<?php _e('إيقاف', 'mohtawa'); ?>',
                yes: '<?php _e('نعم', 'mohtawa'); ?>',
                no: '<?php _e('لا', 'mohtawa'); ?>',
                true: '<?php _e('صحيح', 'mohtawa'); ?>',
                false: '<?php _e('خطأ', 'mohtawa'); ?>',
                all: '<?php _e('الكل', 'mohtawa'); ?>',
                none: '<?php _e('لا شيء', 'mohtawa'); ?>',
                any: '<?php _e('أي', 'mohtawa'); ?>',
                other: '<?php _e('أخرى', 'mohtawa'); ?>',
                more: '<?php _e('المزيد', 'mohtawa'); ?>',
                less: '<?php _e('أقل', 'mohtawa'); ?>',
                new: '<?php _e('جديد', 'mohtawa'); ?>',
                old: '<?php _e('قديم', 'mohtawa'); ?>',
                recent: '<?php _e('حديث', 'mohtawa'); ?>',
                popular: '<?php _e('شائع', 'mohtawa'); ?>',
                featured: '<?php _e('مميز', 'mohtawa'); ?>',
                recommended: '<?php _e('موصى به', 'mohtawa'); ?>',
                trending: '<?php _e('رائج', 'mohtawa'); ?>',
                hot: '<?php _e('ساخن', 'mohtawa'); ?>',
                top: '<?php _e('الأعلى', 'mohtawa'); ?>',
                best: '<?php _e('الأفضل', 'mohtawa'); ?>',
                latest: '<?php _e('الأحدث', 'mohtawa'); ?>',
                oldest: '<?php _e('الأقدم', 'mohtawa'); ?>',
                first: '<?php _e('الأول', 'mohtawa'); ?>',
                last: '<?php _e('الأخير', 'mohtawa'); ?>',
                today: '<?php _e('اليوم', 'mohtawa'); ?>',
                yesterday: '<?php _e('أمس', 'mohtawa'); ?>',
                tomorrow: '<?php _e('غداً', 'mohtawa'); ?>',
                thisWeek: '<?php _e('هذا الأسبوع', 'mohtawa'); ?>',
                thisMonth: '<?php _e('هذا الشهر', 'mohtawa'); ?>',
                thisYear: '<?php _e('هذا العام', 'mohtawa'); ?>',
                now: '<?php _e('الآن', 'mohtawa'); ?>',
                soon: '<?php _e('قريباً', 'mohtawa'); ?>',
                later: '<?php _e('لاحقاً', 'mohtawa'); ?>',
                never: '<?php _e('أبداً', 'mohtawa'); ?>',
                always: '<?php _e('دائماً', 'mohtawa'); ?>',
                sometimes: '<?php _e('أحياناً', 'mohtawa'); ?>',
                often: '<?php _e('غالباً', 'mohtawa'); ?>',
                rarely: '<?php _e('نادراً', 'mohtawa'); ?>',
                maybe: '<?php _e('ربما', 'mohtawa'); ?>',
                probably: '<?php _e('على الأرجح', 'mohtawa'); ?>',
                definitely: '<?php _e('بالتأكيد', 'mohtawa'); ?>',
                certainly: '<?php _e('بالطبع', 'mohtawa'); ?>',
                absolutely: '<?php _e('تماماً', 'mohtawa'); ?>',
                exactly: '<?php _e('بالضبط', 'mohtawa'); ?>',
                approximately: '<?php _e('تقريباً', 'mohtawa'); ?>',
                about: '<?php _e('حوالي', 'mohtawa'); ?>',
                around: '<?php _e('حول', 'mohtawa'); ?>',
                near: '<?php _e('قريب', 'mohtawa'); ?>',
                far: '<?php _e('بعيد', 'mohtawa'); ?>',
                here: '<?php _e('هنا', 'mohtawa'); ?>',
                there: '<?php _e('هناك', 'mohtawa'); ?>',
                everywhere: '<?php _e('في كل مكان', 'mohtawa'); ?>',
                nowhere: '<?php _e('في أي مكان', 'mohtawa'); ?>',
                somewhere: '<?php _e('في مكان ما', 'mohtawa'); ?>',
                anywhere: '<?php _e('في أي مكان', 'mohtawa'); ?>',
                inside: '<?php _e('داخل', 'mohtawa'); ?>',
                outside: '<?php _e('خارج', 'mohtawa'); ?>',
                above: '<?php _e('أعلى', 'mohtawa'); ?>',
                below: '<?php _e('أسفل', 'mohtawa'); ?>',
                left: '<?php _e('يسار', 'mohtawa'); ?>',
                right: '<?php _e('يمين', 'mohtawa'); ?>',
                center: '<?php _e('وسط', 'mohtawa'); ?>',
                middle: '<?php _e('منتصف', 'mohtawa'); ?>',
                front: '<?php _e('أمام', 'mohtawa'); ?>',
                back: '<?php _e('خلف', 'mohtawa'); ?>',
                side: '<?php _e('جانب', 'mohtawa'); ?>',
                corner: '<?php _e('زاوية', 'mohtawa'); ?>',
                edge: '<?php _e('حافة', 'mohtawa'); ?>',
                border: '<?php _e('حدود', 'mohtawa'); ?>',
                boundary: '<?php _e('حدود', 'mohtawa'); ?>',
                limit: '<?php _e('حد', 'mohtawa'); ?>',
                maximum: '<?php _e('الحد الأقصى', 'mohtawa'); ?>',
                minimum: '<?php _e('الحد الأدنى', 'mohtawa'); ?>',
                average: '<?php _e('متوسط', 'mohtawa'); ?>',
                total: '<?php _e('المجموع', 'mohtawa'); ?>',
                sum: '<?php _e('مجموع', 'mohtawa'); ?>',
                count: '<?php _e('عدد', 'mohtawa'); ?>',
                number: '<?php _e('رقم', 'mohtawa'); ?>',
                amount: '<?php _e('كمية', 'mohtawa'); ?>',
                quantity: '<?php _e('كمية', 'mohtawa'); ?>',
                size: '<?php _e('حجم', 'mohtawa'); ?>',
                length: '<?php _e('طول', 'mohtawa'); ?>',
                width: '<?php _e('عرض', 'mohtawa'); ?>',
                height: '<?php _e('ارتفاع', 'mohtawa'); ?>',
                depth: '<?php _e('عمق', 'mohtawa'); ?>',
                weight: '<?php _e('وزن', 'mohtawa'); ?>',
                speed: '<?php _e('سرعة', 'mohtawa'); ?>',
                time: '<?php _e('وقت', 'mohtawa'); ?>',
                date: '<?php _e('تاريخ', 'mohtawa'); ?>',
                day: '<?php _e('يوم', 'mohtawa'); ?>',
                week: '<?php _e('أسبوع', 'mohtawa'); ?>',
                month: '<?php _e('شهر', 'mohtawa'); ?>',
                year: '<?php _e('سنة', 'mohtawa'); ?>',
                hour: '<?php _e('ساعة', 'mohtawa'); ?>',
                minute: '<?php _e('دقيقة', 'mohtawa'); ?>',
                second: '<?php _e('ثانية', 'mohtawa'); ?>',
                morning: '<?php _e('صباح', 'mohtawa'); ?>',
                afternoon: '<?php _e('بعد الظهر', 'mohtawa'); ?>',
                evening: '<?php _e('مساء', 'mohtawa'); ?>',
                night: '<?php _e('ليل', 'mohtawa'); ?>',
                midnight: '<?php _e('منتصف الليل', 'mohtawa'); ?>',
                noon: '<?php _e('ظهر', 'mohtawa'); ?>',
                sunrise: '<?php _e('شروق الشمس', 'mohtawa'); ?>',
                sunset: '<?php _e('غروب الشمس', 'mohtawa'); ?>',
                dawn: '<?php _e('فجر', 'mohtawa'); ?>',
                dusk: '<?php _e('غسق', 'mohtawa'); ?>',
                spring: '<?php _e('ربيع', 'mohtawa'); ?>',
                summer: '<?php _e('صيف', 'mohtawa'); ?>',
                autumn: '<?php _e('خريف', 'mohtawa'); ?>',
                winter: '<?php _e('شتاء', 'mohtawa'); ?>',
                weather: '<?php _e('طقس', 'mohtawa'); ?>',
                temperature: '<?php _e('درجة الحرارة', 'mohtawa'); ?>',
                hot: '<?php _e('حار', 'mohtawa'); ?>',
                cold: '<?php _e('بارد', 'mohtawa'); ?>',
                warm: '<?php _e('دافئ', 'mohtawa'); ?>',
                cool: '<?php _e('بارد', 'mohtawa'); ?>',
                sunny: '<?php _e('مشمس', 'mohtawa'); ?>',
                cloudy: '<?php _e('غائم', 'mohtawa'); ?>',
                rainy: '<?php _e('ممطر', 'mohtawa'); ?>',
                snowy: '<?php _e('مثلج', 'mohtawa'); ?>',
                windy: '<?php _e('عاصف', 'mohtawa'); ?>',
                stormy: '<?php _e('عاصف', 'mohtawa'); ?>',
                clear: '<?php _e('صافي', 'mohtawa'); ?>',
                foggy: '<?php _e('ضبابي', 'mohtawa'); ?>',
                humid: '<?php _e('رطب', 'mohtawa'); ?>',
                dry: '<?php _e('جاف', 'mohtawa'); ?>',
                wet: '<?php _e('مبلل', 'mohtawa'); ?>',
                clean: '<?php _e('نظيف', 'mohtawa'); ?>',
                dirty: '<?php _e('متسخ', 'mohtawa'); ?>',
                fresh: '<?php _e('طازج', 'mohtawa'); ?>',
                stale: '<?php _e('قديم', 'mohtawa'); ?>',
                new: '<?php _e('جديد', 'mohtawa'); ?>',
                used: '<?php _e('مستعمل', 'mohtawa'); ?>',
                broken: '<?php _e('مكسور', 'mohtawa'); ?>',
                fixed: '<?php _e('مُصلح', 'mohtawa'); ?>',
                working: '<?php _e('يعمل', 'mohtawa'); ?>',
                notWorking: '<?php _e('لا يعمل', 'mohtawa'); ?>',
                available: '<?php _e('متاح', 'mohtawa'); ?>',
                unavailable: '<?php _e('غير متاح', 'mohtawa'); ?>',
                online: '<?php _e('متصل', 'mohtawa'); ?>',
                offline: '<?php _e('غير متصل', 'mohtawa'); ?>',
                connected: '<?php _e('متصل', 'mohtawa'); ?>',
                disconnected: '<?php _e('منقطع', 'mohtawa'); ?>',
                active: '<?php _e('نشط', 'mohtawa'); ?>',
                inactive: '<?php _e('غير نشط', 'mohtawa'); ?>',
                enabled: '<?php _e('مفعل', 'mohtawa'); ?>',
                disabled: '<?php _e('معطل', 'mohtawa'); ?>',
                visible: '<?php _e('مرئي', 'mohtawa'); ?>',
                hidden: '<?php _e('مخفي', 'mohtawa'); ?>',
                public: '<?php _e('عام', 'mohtawa'); ?>',
                private: '<?php _e('خاص', 'mohtawa'); ?>',
                secure: '<?php _e('آمن', 'mohtawa'); ?>',
                insecure: '<?php _e('غير آمن', 'mohtawa'); ?>',
                safe: '<?php _e('آمن', 'mohtawa'); ?>',
                dangerous: '<?php _e('خطير', 'mohtawa'); ?>',
                easy: '<?php _e('سهل', 'mohtawa'); ?>',
                difficult: '<?php _e('صعب', 'mohtawa'); ?>',
                simple: '<?php _e('بسيط', 'mohtawa'); ?>',
                complex: '<?php _e('معقد', 'mohtawa'); ?>',
                fast: '<?php _e('سريع', 'mohtawa'); ?>',
                slow: '<?php _e('بطيء', 'mohtawa'); ?>',
                quick: '<?php _e('سريع', 'mohtawa'); ?>',
                instant: '<?php _e('فوري', 'mohtawa'); ?>',
                immediate: '<?php _e('فوري', 'mohtawa'); ?>',
                delayed: '<?php _e('مؤجل', 'mohtawa'); ?>',
                pending: '<?php _e('معلق', 'mohtawa'); ?>',
                processing: '<?php _e('قيد المعالجة', 'mohtawa'); ?>',
                completed: '<?php _e('مكتمل', 'mohtawa'); ?>',
                failed: '<?php _e('فشل', 'mohtawa'); ?>',
                cancelled: '<?php _e('ملغي', 'mohtawa'); ?>',
                expired: '<?php _e('منتهي الصلاحية', 'mohtawa'); ?>',
                valid: '<?php _e('صالح', 'mohtawa'); ?>',
                invalid: '<?php _e('غير صالح', 'mohtawa'); ?>',
                correct: '<?php _e('صحيح', 'mohtawa'); ?>',
                incorrect: '<?php _e('غير صحيح', 'mohtawa'); ?>',
                right: '<?php _e('صحيح', 'mohtawa'); ?>',
                wrong: '<?php _e('خطأ', 'mohtawa'); ?>',
                good: '<?php _e('جيد', 'mohtawa'); ?>',
                bad: '<?php _e('سيء', 'mohtawa'); ?>',
                excellent: '<?php _e('ممتاز', 'mohtawa'); ?>',
                poor: '<?php _e('ضعيف', 'mohtawa'); ?>',
                great: '<?php _e('رائع', 'mohtawa'); ?>',
                terrible: '<?php _e('فظيع', 'mohtawa'); ?>',
                amazing: '<?php _e('مذهل', 'mohtawa'); ?>',
                awful: '<?php _e('مروع', 'mohtawa'); ?>',
                wonderful: '<?php _e('رائع', 'mohtawa'); ?>',
                horrible: '<?php _e('مروع', 'mohtawa'); ?>',
                beautiful: '<?php _e('جميل', 'mohtawa'); ?>',
                ugly: '<?php _e('قبيح', 'mohtawa'); ?>',
                nice: '<?php _e('لطيف', 'mohtawa'); ?>',
                nasty: '<?php _e('سيء', 'mohtawa'); ?>',
                pleasant: '<?php _e('ممتع', 'mohtawa'); ?>',
                unpleasant: '<?php _e('غير ممتع', 'mohtawa'); ?>',
                comfortable: '<?php _e('مريح', 'mohtawa'); ?>',
                uncomfortable: '<?php _e('غير مريح', 'mohtawa'); ?>',
                convenient: '<?php _e('مناسب', 'mohtawa'); ?>',
                inconvenient: '<?php _e('غير مناسب', 'mohtawa'); ?>',
                useful: '<?php _e('مفيد', 'mohtawa'); ?>',
                useless: '<?php _e('عديم الفائدة', 'mohtawa'); ?>',
                helpful: '<?php _e('مفيد', 'mohtawa'); ?>',
                unhelpful: '<?php _e('غير مفيد', 'mohtawa'); ?>',
                important: '<?php _e('مهم', 'mohtawa'); ?>',
                unimportant: '<?php _e('غير مهم', 'mohtawa'); ?>',
                necessary: '<?php _e('ضروري', 'mohtawa'); ?>',
                unnecessary: '<?php _e('غير ضروري', 'mohtawa'); ?>',
                required: '<?php _e('مطلوب', 'mohtawa'); ?>',
                optional: '<?php _e('اختياري', 'mohtawa'); ?>',
                mandatory: '<?php _e('إجباري', 'mohtawa'); ?>',
                voluntary: '<?php _e('طوعي', 'mohtawa'); ?>',
                automatic: '<?php _e('تلقائي', 'mohtawa'); ?>',
                manual: '<?php _e('يدوي', 'mohtawa'); ?>',
                free: '<?php _e('مجاني', 'mohtawa'); ?>',
                paid: '<?php _e('مدفوع', 'mohtawa'); ?>',
                premium: '<?php _e('مميز', 'mohtawa'); ?>',
                basic: '<?php _e('أساسي', 'mohtawa'); ?>',
                advanced: '<?php _e('متقدم', 'mohtawa'); ?>',
                professional: '<?php _e('احترافي', 'mohtawa'); ?>',
                standard: '<?php _e('قياسي', 'mohtawa'); ?>',
                custom: '<?php _e('مخصص', 'mohtawa'); ?>',
                default: '<?php _e('افتراضي', 'mohtawa'); ?>',
                original: '<?php _e('أصلي', 'mohtawa'); ?>',
                copy: '<?php _e('نسخة', 'mohtawa'); ?>',
                duplicate: '<?php _e('مكرر', 'mohtawa'); ?>',
                unique: '<?php _e('فريد', 'mohtawa'); ?>',
                common: '<?php _e('شائع', 'mohtawa'); ?>',
                rare: '<?php _e('نادر', 'mohtawa'); ?>',
                special: '<?php _e('خاص', 'mohtawa'); ?>',
                normal: '<?php _e('عادي', 'mohtawa'); ?>',
                regular: '<?php _e('منتظم', 'mohtawa'); ?>',
                irregular: '<?php _e('غير منتظم', 'mohtawa'); ?>',
                frequent: '<?php _e('متكرر', 'mohtawa'); ?>',
                infrequent: '<?php _e('غير متكرر', 'mohtawa'); ?>',
                daily: '<?php _e('يومي', 'mohtawa'); ?>',
                weekly: '<?php _e('أسبوعي', 'mohtawa'); ?>',
                monthly: '<?php _e('شهري', 'mohtawa'); ?>',
                yearly: '<?php _e('سنوي', 'mohtawa'); ?>',
                hourly: '<?php _e('كل ساعة', 'mohtawa'); ?>',
                once: '<?php _e('مرة واحدة', 'mohtawa'); ?>',
                twice: '<?php _e('مرتين', 'mohtawa'); ?>',
                multiple: '<?php _e('متعدد', 'mohtawa'); ?>',
                single: '<?php _e('واحد', 'mohtawa'); ?>',
                double: '<?php _e('مضاعف', 'mohtawa'); ?>',
                triple: '<?php _e('ثلاثي', 'mohtawa'); ?>',
                half: '<?php _e('نصف', 'mohtawa'); ?>',
                quarter: '<?php _e('ربع', 'mohtawa'); ?>',
                full: '<?php _e('كامل', 'mohtawa'); ?>',
                empty: '<?php _e('فارغ', 'mohtawa'); ?>',
                partial: '<?php _e('جزئي', 'mohtawa'); ?>',
                complete: '<?php _e('كامل', 'mohtawa'); ?>',
                incomplete: '<?php _e('غير كامل', 'mohtawa'); ?>',
                finished: '<?php _e('منتهي', 'mohtawa'); ?>',
                unfinished: '<?php _e('غير منتهي', 'mohtawa'); ?>',
                started: '<?php _e('بدأ', 'mohtawa'); ?>',
                stopped: '<?php _e('توقف', 'mohtawa'); ?>',
                paused: '<?php _e('متوقف مؤقتاً', 'mohtawa'); ?>',
                resumed: '<?php _e('استؤنف', 'mohtawa'); ?>',
                continued: '<?php _e('استمر', 'mohtawa'); ?>',
                ended: '<?php _e('انتهى', 'mohtawa'); ?>',
                beginning: '<?php _e('بداية', 'mohtawa'); ?>',
                middle: '<?php _e('وسط', 'mohtawa'); ?>',
                end: '<?php _e('نهاية', 'mohtawa'); ?>',
                start: '<?php _e('بداية', 'mohtawa'); ?>',
                stop: '<?php _e('توقف', 'mohtawa'); ?>',
                pause: '<?php _e('توقف مؤقت', 'mohtawa'); ?>',
                play: '<?php _e('تشغيل', 'mohtawa'); ?>',
                record: '<?php _e('تسجيل', 'mohtawa'); ?>',
                rewind: '<?php _e('إرجاع', 'mohtawa'); ?>',
                forward: '<?php _e('تقديم', 'mohtawa'); ?>',
                backward: '<?php _e('للخلف', 'mohtawa'); ?>',
                up: '<?php _e('أعلى', 'mohtawa'); ?>',
                down: '<?php _e('أسفل', 'mohtawa'); ?>',
                left: '<?php _e('يسار', 'mohtawa'); ?>',
                right: '<?php _e('يمين', 'mohtawa'); ?>',
                north: '<?php _e('شمال', 'mohtawa'); ?>',
                south: '<?php _e('جنوب', 'mohtawa'); ?>',
                east: '<?php _e('شرق', 'mohtawa'); ?>',
                west: '<?php _e('غرب', 'mohtawa'); ?>',
                northeast: '<?php _e('شمال شرق', 'mohtawa'); ?>',
                northwest: '<?php _e('شمال غرب', 'mohtawa'); ?>',
                southeast: '<?php _e('جنوب شرق', 'mohtawa'); ?>',
                southwest: '<?php _e('جنوب غرب', 'mohtawa'); ?>',
                location: '<?php _e('موقع', 'mohtawa'); ?>',
                address: '<?php _e('عنوان', 'mohtawa'); ?>',
                city: '<?php _e('مدينة', 'mohtawa'); ?>',
                country: '<?php _e('دولة', 'mohtawa'); ?>',
                region: '<?php _e('منطقة', 'mohtawa'); ?>',
                area: '<?php _e('منطقة', 'mohtawa'); ?>',
                district: '<?php _e('حي', 'mohtawa'); ?>',
                neighborhood: '<?php _e('حي', 'mohtawa'); ?>',
                street: '<?php _e('شارع', 'mohtawa'); ?>',
                road: '<?php _e('طريق', 'mohtawa'); ?>',
                avenue: '<?php _e('جادة', 'mohtawa'); ?>',
                boulevard: '<?php _e('شارع رئيسي', 'mohtawa'); ?>',
                lane: '<?php _e('ممر', 'mohtawa'); ?>',
                alley: '<?php _e('زقاق', 'mohtawa'); ?>',
                square: '<?php _e('ميدان', 'mohtawa'); ?>',
                plaza: '<?php _e('ساحة', 'mohtawa'); ?>',
                park: '<?php _e('حديقة', 'mohtawa'); ?>',
                garden: '<?php _e('حديقة', 'mohtawa'); ?>',
                building: '<?php _e('مبنى', 'mohtawa'); ?>',
                house: '<?php _e('منزل', 'mohtawa'); ?>',
                apartment: '<?php _e('شقة', 'mohtawa'); ?>',
                office: '<?php _e('مكتب', 'mohtawa'); ?>',
                shop: '<?php _e('متجر', 'mohtawa'); ?>',
                store: '<?php _e('متجر', 'mohtawa'); ?>',
                market: '<?php _e('سوق', 'mohtawa'); ?>',
                mall: '<?php _e('مول', 'mohtawa'); ?>',
                center: '<?php _e('مركز', 'mohtawa'); ?>',
                complex: '<?php _e('مجمع', 'mohtawa'); ?>',
                tower: '<?php _e('برج', 'mohtawa'); ?>',
                floor: '<?php _e('طابق', 'mohtawa'); ?>',
                room: '<?php _e('غرفة', 'mohtawa'); ?>',
                suite: '<?php _e('جناح', 'mohtawa'); ?>',
                unit: '<?php _e('وحدة', 'mohtawa'); ?>',
                entrance: '<?php _e('مدخل', 'mohtawa'); ?>',
                exit: '<?php _e('مخرج', 'mohtawa'); ?>',
                door: '<?php _e('باب', 'mohtawa'); ?>',
                window: '<?php _e('نافذة', 'mohtawa'); ?>',
                stairs: '<?php _e('درج', 'mohtawa'); ?>',
                elevator: '<?php _e('مصعد', 'mohtawa'); ?>',
                escalator: '<?php _e('سلم متحرك', 'mohtawa'); ?>',
                parking: '<?php _e('موقف', 'mohtawa'); ?>',
                garage: '<?php _e('كراج', 'mohtawa'); ?>',
                driveway: '<?php _e('ممر سيارات', 'mohtawa'); ?>',
                sidewalk: '<?php _e('رصيف', 'mohtawa'); ?>',
                crosswalk: '<?php _e('معبر مشاة', 'mohtawa'); ?>',
                intersection: '<?php _e('تقاطع', 'mohtawa'); ?>',
                junction: '<?php _e('تقاطع', 'mohtawa'); ?>',
                roundabout: '<?php _e('دوار', 'mohtawa'); ?>',
                bridge: '<?php _e('جسر', 'mohtawa'); ?>',
                tunnel: '<?php _e('نفق', 'mohtawa'); ?>',
                highway: '<?php _e('طريق سريع', 'mohtawa'); ?>',
                freeway: '<?php _e('طريق سريع', 'mohtawa'); ?>',
                expressway: '<?php _e('طريق سريع', 'mohtawa'); ?>',
                motorway: '<?php _e('طريق سريع', 'mohtawa'); ?>',
                bypass: '<?php _e('طريق التفافي', 'mohtawa'); ?>',
                detour: '<?php _e('طريق بديل', 'mohtawa'); ?>',
                shortcut: '<?php _e('طريق مختصر', 'mohtawa'); ?>',
                route: '<?php _e('طريق', 'mohtawa'); ?>',
                path: '<?php _e('مسار', 'mohtawa'); ?>',
                trail: '<?php _e('مسار', 'mohtawa'); ?>',
                track: '<?php _e('مسار', 'mohtawa'); ?>',
                way: '<?php _e('طريق', 'mohtawa'); ?>',
                direction: '<?php _e('اتجاه', 'mohtawa'); ?>',
                destination: '<?php _e('وجهة', 'mohtawa'); ?>',
                origin: '<?php _e('نقطة البداية', 'mohtawa'); ?>',
                departure: '<?php _e('مغادرة', 'mohtawa'); ?>',
                arrival: '<?php _e('وصول', 'mohtawa'); ?>',
                journey: '<?php _e('رحلة', 'mohtawa'); ?>',
                trip: '<?php _e('رحلة', 'mohtawa'); ?>',
                travel: '<?php _e('سفر', 'mohtawa'); ?>',
                transport: '<?php _e('نقل', 'mohtawa'); ?>',
                transportation: '<?php _e('مواصلات', 'mohtawa'); ?>',
                vehicle: '<?php _e('مركبة', 'mohtawa'); ?>',
                car: '<?php _e('سيارة', 'mohtawa'); ?>',
                bus: '<?php _e('حافلة', 'mohtawa'); ?>',
                train: '<?php _e('قطار', 'mohtawa'); ?>',
                subway: '<?php _e('مترو', 'mohtawa'); ?>',
                metro: '<?php _e('مترو', 'mohtawa'); ?>',
                taxi: '<?php _e('تاكسي', 'mohtawa'); ?>',
                uber: '<?php _e('أوبر', 'mohtawa'); ?>',
                bike: '<?php _e('دراجة', 'mohtawa'); ?>',
                bicycle: '<?php _e('دراجة هوائية', 'mohtawa'); ?>',
                motorcycle: '<?php _e('دراجة نارية', 'mohtawa'); ?>',
                scooter: '<?php _e('سكوتر', 'mohtawa'); ?>',
                truck: '<?php _e('شاحنة', 'mohtawa'); ?>',
                van: '<?php _e('فان', 'mohtawa'); ?>',
                suv: '<?php _e('سيارة دفع رباعي', 'mohtawa'); ?>',
                sedan: '<?php _e('سيدان', 'mohtawa'); ?>',
                coupe: '<?php _e('كوبيه', 'mohtawa'); ?>',
                convertible: '<?php _e('قابل للتحويل', 'mohtawa'); ?>',
                hatchback: '<?php _e('هاتشباك', 'mohtawa'); ?>',
                wagon: '<?php _e('عربة', 'mohtawa'); ?>',
                pickup: '<?php _e('بيك أب', 'mohtawa'); ?>',
                minivan: '<?php _e('ميني فان', 'mohtawa'); ?>',
                limousine: '<?php _e('ليموزين', 'mohtawa'); ?>',
                ambulance: '<?php _e('إسعاف', 'mohtawa'); ?>',
                firetruck: '<?php _e('سيارة إطفاء', 'mohtawa'); ?>',
                police: '<?php _e('شرطة', 'mohtawa'); ?>',
                airplane: '<?php _e('طائرة', 'mohtawa'); ?>',
                helicopter: '<?php _e('هليكوبتر', 'mohtawa'); ?>',
                boat: '<?php _e('قارب', 'mohtawa'); ?>',
                ship: '<?php _e('سفينة', 'mohtawa'); ?>',
                ferry: '<?php _e('عبارة', 'mohtawa'); ?>',
                yacht: '<?php _e('يخت', 'mohtawa'); ?>',
                cruise: '<?php _e('رحلة بحرية', 'mohtawa'); ?>',
                flight: '<?php _e('رحلة طيران', 'mohtawa'); ?>',
                airport: '<?php _e('مطار', 'mohtawa'); ?>',
                station: '<?php _e('محطة', 'mohtawa'); ?>',
                terminal: '<?php _e('محطة', 'mohtawa'); ?>',
                platform: '<?php _e('رصيف', 'mohtawa'); ?>',
                gate: '<?php _e('بوابة', 'mohtawa'); ?>',
                checkpoint: '<?php _e('نقطة تفتيش', 'mohtawa'); ?>',
                border: '<?php _e('حدود', 'mohtawa'); ?>',
                customs: '<?php _e('جمارك', 'mohtawa'); ?>',
                immigration: '<?php _e('هجرة', 'mohtawa'); ?>',
                passport: '<?php _e('جواز سفر', 'mohtawa'); ?>',
                visa: '<?php _e('تأشيرة', 'mohtawa'); ?>',
                ticket: '<?php _e('تذكرة', 'mohtawa'); ?>',
                reservation: '<?php _e('حجز', 'mohtawa'); ?>',
                booking: '<?php _e('حجز', 'mohtawa'); ?>',
                schedule: '<?php _e('جدول', 'mohtawa'); ?>',
                timetable: '<?php _e('جدول زمني', 'mohtawa'); ?>',
                calendar: '<?php _e('تقويم', 'mohtawa'); ?>',
                appointment: '<?php _e('موعد', 'mohtawa'); ?>',
                meeting: '<?php _e('اجتماع', 'mohtawa'); ?>',
                conference: '<?php _e('مؤتمر', 'mohtawa'); ?>',
                event: '<?php _e('حدث', 'mohtawa'); ?>',
                party: '<?php _e('حفلة', 'mohtawa'); ?>',
                celebration: '<?php _e('احتفال', 'mohtawa'); ?>',
                festival: '<?php _e('مهرجان', 'mohtawa'); ?>',
                concert: '<?php _e('حفل موسيقي', 'mohtawa'); ?>',
                show: '<?php _e('عرض', 'mohtawa'); ?>',
                performance: '<?php _e('أداء', 'mohtawa'); ?>',
                exhibition: '<?php _e('معرض', 'mohtawa'); ?>',
                fair: '<?php _e('معرض', 'mohtawa'); ?>',
                market: '<?php _e('سوق', 'mohtawa'); ?>',
                sale: '<?php _e('تخفيض', 'mohtawa'); ?>',
                discount: '<?php _e('خصم', 'mohtawa'); ?>',
                offer: '<?php _e('عرض', 'mohtawa'); ?>',
                deal: '<?php _e('صفقة', 'mohtawa'); ?>',
                promotion: '<?php _e('ترويج', 'mohtawa'); ?>',
                advertisement: '<?php _e('إعلان', 'mohtawa'); ?>',
                commercial: '<?php _e('إعلان تجاري', 'mohtawa'); ?>',
                marketing: '<?php _e('تسويق', 'mohtawa'); ?>',
                business: '<?php _e('عمل', 'mohtawa'); ?>',
                company: '<?php _e('شركة', 'mohtawa'); ?>',
                corporation: '<?php _e('مؤسسة', 'mohtawa'); ?>',
                organization: '<?php _e('منظمة', 'mohtawa'); ?>',
                institution: '<?php _e('مؤسسة', 'mohtawa'); ?>',
                agency: '<?php _e('وكالة', 'mohtawa'); ?>',
                firm: '<?php _e('شركة', 'mohtawa'); ?>',
                enterprise: '<?php _e('مؤسسة', 'mohtawa'); ?>',
                startup: '<?php _e('شركة ناشئة', 'mohtawa'); ?>',
                brand: '<?php _e('علامة تجارية', 'mohtawa'); ?>',
                logo: '<?php _e('شعار', 'mohtawa'); ?>',
                trademark: '<?php _e('علامة تجارية', 'mohtawa'); ?>',
                copyright: '<?php _e('حقوق النشر', 'mohtawa'); ?>',
                patent: '<?php _e('براءة اختراع', 'mohtawa'); ?>',
                license: '<?php _e('رخصة', 'mohtawa'); ?>',
                permit: '<?php _e('تصريح', 'mohtawa'); ?>',
                certificate: '<?php _e('شهادة', 'mohtawa'); ?>',
                diploma: '<?php _e('دبلوم', 'mohtawa'); ?>',
                degree: '<?php _e('درجة', 'mohtawa'); ?>',
                qualification: '<?php _e('مؤهل', 'mohtawa'); ?>',
                skill: '<?php _e('مهارة', 'mohtawa'); ?>',
                ability: '<?php _e('قدرة', 'mohtawa'); ?>',
                talent: '<?php _e('موهبة', 'mohtawa'); ?>',
                expertise: '<?php _e('خبرة', 'mohtawa'); ?>',
                experience: '<?php _e('تجربة', 'mohtawa'); ?>',
                knowledge: '<?php _e('معرفة', 'mohtawa'); ?>',
                education: '<?php _e('تعليم', 'mohtawa'); ?>',
                training: '<?php _e('تدريب', 'mohtawa'); ?>',
                course: '<?php _e('دورة', 'mohtawa'); ?>',
                class: '<?php _e('فصل', 'mohtawa'); ?>',
                lesson: '<?php _e('درس', 'mohtawa'); ?>',
                tutorial: '<?php _e('درس تعليمي', 'mohtawa'); ?>',
                workshop: '<?php _e('ورشة عمل', 'mohtawa'); ?>',
                seminar: '<?php _e('ندوة', 'mohtawa'); ?>',
                webinar: '<?php _e('ندوة عبر الإنترنت', 'mohtawa'); ?>',
                lecture: '<?php _e('محاضرة', 'mohtawa'); ?>',
                presentation: '<?php _e('عرض تقديمي', 'mohtawa'); ?>',
                speech: '<?php _e('خطاب', 'mohtawa'); ?>',
                talk: '<?php _e('حديث', 'mohtawa'); ?>',
                discussion: '<?php _e('نقاش', 'mohtawa'); ?>',
                debate: '<?php _e('مناقشة', 'mohtawa'); ?>',
                argument: '<?php _e('جدال', 'mohtawa'); ?>',
                conversation: '<?php _e('محادثة', 'mohtawa'); ?>',
                chat: '<?php _e('دردشة', 'mohtawa'); ?>',
                message: '<?php _e('رسالة', 'mohtawa'); ?>',
                email: '<?php _e('بريد إلكتروني', 'mohtawa'); ?>',
                letter: '<?php _e('رسالة', 'mohtawa'); ?>',
                note: '<?php _e('ملاحظة', 'mohtawa'); ?>',
                memo: '<?php _e('مذكرة', 'mohtawa'); ?>',
                report: '<?php _e('تقرير', 'mohtawa'); ?>',
                document: '<?php _e('وثيقة', 'mohtawa'); ?>',
                file: '<?php _e('ملف', 'mohtawa'); ?>',
                folder: '<?php _e('مجلد', 'mohtawa'); ?>',
                directory: '<?php _e('دليل', 'mohtawa'); ?>',
                archive: '<?php _e('أرشيف', 'mohtawa'); ?>',
                backup: '<?php _e('نسخة احتياطية', 'mohtawa'); ?>',
                restore: '<?php _e('استعادة', 'mohtawa'); ?>',
                recovery: '<?php _e('استرداد', 'mohtawa'); ?>',
                repair: '<?php _e('إصلاح', 'mohtawa'); ?>',
                maintenance: '<?php _e('صيانة', 'mohtawa'); ?>',
                service: '<?php _e('خدمة', 'mohtawa'); ?>',
                support: '<?php _e('دعم', 'mohtawa'); ?>',
                help: '<?php _e('مساعدة', 'mohtawa'); ?>',
                assistance: '<?php _e('مساعدة', 'mohtawa'); ?>',
                guidance: '<?php _e('إرشاد', 'mohtawa'); ?>',
                advice: '<?php _e('نصيحة', 'mohtawa'); ?>',
                suggestion: '<?php _e('اقتراح', 'mohtawa'); ?>',
                recommendation: '<?php _e('توصية', 'mohtawa'); ?>',
                tip: '<?php _e('نصيحة', 'mohtawa'); ?>',
                hint: '<?php _e('تلميح', 'mohtawa'); ?>',
                clue: '<?php _e('دليل', 'mohtawa'); ?>',
                sign: '<?php _e('علامة', 'mohtawa'); ?>',
                signal: '<?php _e('إشارة', 'mohtawa'); ?>',
                indicator: '<?php _e('مؤشر', 'mohtawa'); ?>',
                warning: '<?php _e('تحذير', 'mohtawa'); ?>',
                alert: '<?php _e('تنبيه', 'mohtawa'); ?>',
                notification: '<?php _e('إشعار', 'mohtawa'); ?>',
                reminder: '<?php _e('تذكير', 'mohtawa'); ?>',
                announcement: '<?php _e('إعلان', 'mohtawa'); ?>',
                news: '<?php _e('أخبار', 'mohtawa'); ?>',
                update: '<?php _e('تحديث', 'mohtawa'); ?>',
                upgrade: '<?php _e('ترقية', 'mohtawa'); ?>',
                downgrade: '<?php _e('تخفيض', 'mohtawa'); ?>',
                install: '<?php _e('تثبيت', 'mohtawa'); ?>',
                uninstall: '<?php _e('إلغاء التثبيت', 'mohtawa'); ?>',
                setup: '<?php _e('إعداد', 'mohtawa'); ?>',
                configuration: '<?php _e('تكوين', 'mohtawa'); ?>',
                settings: '<?php _e('إعدادات', 'mohtawa'); ?>',
                preferences: '<?php _e('تفضيلات', 'mohtawa'); ?>',
                options: '<?php _e('خيارات', 'mohtawa'); ?>',
                choices: '<?php _e('اختيارات', 'mohtawa'); ?>',
                alternatives: '<?php _e('بدائل', 'mohtawa'); ?>',
                possibilities: '<?php _e('إمكانيات', 'mohtawa'); ?>',
                opportunities: '<?php _e('فرص', 'mohtawa'); ?>',
                chances: '<?php _e('فرص', 'mohtawa'); ?>',
                probability: '<?php _e('احتمال', 'mohtawa'); ?>',
                likelihood: '<?php _e('احتمالية', 'mohtawa'); ?>',
                possibility: '<?php _e('إمكانية', 'mohtawa'); ?>',
                potential: '<?php _e('إمكانات', 'mohtawa'); ?>',
                capacity: '<?php _e('سعة', 'mohtawa'); ?>',
                capability: '<?php _e('قدرة', 'mohtawa'); ?>',
                power: '<?php _e('قوة', 'mohtawa'); ?>',
                strength: '<?php _e('قوة', 'mohtawa'); ?>',
                weakness: '<?php _e('ضعف', 'mohtawa'); ?>',
                advantage: '<?php _e('ميزة', 'mohtawa'); ?>',
                disadvantage: '<?php _e('عيب', 'mohtawa'); ?>',
                benefit: '<?php _e('فائدة', 'mohtawa'); ?>',
                drawback: '<?php _e('عيب', 'mohtawa'); ?>',
                pro: '<?php _e('إيجابي', 'mohtawa'); ?>',
                con: '<?php _e('سلبي', 'mohtawa'); ?>',
                positive: '<?php _e('إيجابي', 'mohtawa'); ?>',
                negative: '<?php _e('سلبي', 'mohtawa'); ?>',
                neutral: '<?php _e('محايد', 'mohtawa'); ?>',
                balanced: '<?php _e('متوازن', 'mohtawa'); ?>',
                unbalanced: '<?php _e('غير متوازن', 'mohtawa'); ?>',
                stable: '<?php _e('مستقر', 'mohtawa'); ?>',
                unstable: '<?php _e('غير مستقر', 'mohtawa'); ?>',
                steady: '<?php _e('ثابت', 'mohtawa'); ?>',
                unsteady: '<?php _e('غير ثابت', 'mohtawa'); ?>',
                consistent: '<?php _e('متسق', 'mohtawa'); ?>',
                inconsistent: '<?php _e('غير متسق', 'mohtawa'); ?>',
                reliable: '<?php _e('موثوق', 'mohtawa'); ?>',
                unreliable: '<?php _e('غير موثوق', 'mohtawa'); ?>',
                trustworthy: '<?php _e('جدير بالثقة', 'mohtawa'); ?>',
                untrustworthy: '<?php _e('غير جدير بالثقة', 'mohtawa'); ?>',
                honest: '<?php _e('صادق', 'mohtawa'); ?>',
                dishonest: '<?php _e('غير صادق', 'mohtawa'); ?>',
                fair: '<?php _e('عادل', 'mohtawa'); ?>',
                unfair: '<?php _e('غير عادل', 'mohtawa'); ?>',
                just: '<?php _e('عادل', 'mohtawa'); ?>',
                unjust: '<?php _e('غير عادل', 'mohtawa'); ?>',
                equal: '<?php _e('متساوي', 'mohtawa'); ?>',
                unequal: '<?php _e('غير متساوي', 'mohtawa'); ?>',
                same: '<?php _e('نفس', 'mohtawa'); ?>',
                different: '<?php _e('مختلف', 'mohtawa'); ?>',
                similar: '<?php _e('مشابه', 'mohtawa'); ?>',
                dissimilar: '<?php _e('غير مشابه', 'mohtawa'); ?>',
                alike: '<?php _e('متشابه', 'mohtawa'); ?>',
                unlike: '<?php _e('غير متشابه', 'mohtawa'); ?>',
                identical: '<?php _e('متطابق', 'mohtawa'); ?>',
                distinct: '<?php _e('مميز', 'mohtawa'); ?>',
                separate: '<?php _e('منفصل', 'mohtawa'); ?>',
                together: '<?php _e('معاً', 'mohtawa'); ?>',
                apart: '<?php _e('منفصل', 'mohtawa'); ?>',
                close: '<?php _e('قريب', 'mohtawa'); ?>',
                distant: '<?php _e('بعيد', 'mohtawa'); ?>',
                nearby: '<?php _e('قريب', 'mohtawa'); ?>',
                faraway: '<?php _e('بعيد', 'mohtawa'); ?>',
                adjacent: '<?php _e('مجاور', 'mohtawa'); ?>',
                neighboring: '<?php _e('مجاور', 'mohtawa'); ?>',
                surrounding: '<?php _e('محيط', 'mohtawa'); ?>',
                enclosed: '<?php _e('محاط', 'mohtawa'); ?>',
                open: '<?php _e('مفتوح', 'mohtawa'); ?>',
                closed: '<?php _e('مغلق', 'mohtawa'); ?>',
                locked: '<?php _e('مقفل', 'mohtawa'); ?>',
                unlocked: '<?php _e('غير مقفل', 'mohtawa'); ?>',
                sealed: '<?php _e('مختوم', 'mohtawa'); ?>',
                unsealed: '<?php _e('غير مختوم', 'mohtawa'); ?>',
                covered: '<?php _e('مغطى', 'mohtawa'); ?>',
                uncovered: '<?php _e('غير مغطى', 'mohtawa'); ?>',
                protected: '<?php _e('محمي', 'mohtawa'); ?>',
                unprotected: '<?php _e('غير محمي', 'mohtawa'); ?>',
                guarded: '<?php _e('محروس', 'mohtawa'); ?>',
                unguarded: '<?php _e('غير محروس', 'mohtawa'); ?>',
                supervised: '<?php _e('تحت الإشراف', 'mohtawa'); ?>',
                unsupervised: '<?php _e('غير مُشرف عليه', 'mohtawa'); ?>',
                monitored: '<?php _e('مراقب', 'mohtawa'); ?>',
                unmonitored: '<?php _e('غير مراقب', 'mohtawa'); ?>',
                controlled: '<?php _e('مُتحكم فيه', 'mohtawa'); ?>',
                uncontrolled: '<?php _e('غير مُتحكم فيه', 'mohtawa'); ?>',
                managed: '<?php _e('مُدار', 'mohtawa'); ?>',
                unmanaged: '<?php _e('غير مُدار', 'mohtawa'); ?>',
                organized: '<?php _e('منظم', 'mohtawa'); ?>',
                disorganized: '<?php _e('غير منظم', 'mohtawa'); ?>',
                structured: '<?php _e('منظم', 'mohtawa'); ?>',
                unstructured: '<?php _e('غير منظم', 'mohtawa'); ?>',
                planned: '<?php _e('مخطط', 'mohtawa'); ?>',
                unplanned: '<?php _e('غير مخطط', 'mohtawa'); ?>',
                scheduled: '<?php _e('مجدول', 'mohtawa'); ?>',
                unscheduled: '<?php _e('غير مجدول', 'mohtawa'); ?>',
                arranged: '<?php _e('مرتب', 'mohtawa'); ?>',
                unarranged: '<?php _e('غير مرتب', 'mohtawa'); ?>',
                prepared: '<?php _e('مُعد', 'mohtawa'); ?>',
                unprepared: '<?php _e('غير مُعد', 'mohtawa'); ?>',
                ready: '<?php _e('جاهز', 'mohtawa'); ?>',
                unready: '<?php _e('غير جاهز', 'mohtawa'); ?>',
                set: '<?php _e('مُعد', 'mohtawa'); ?>',
                unset: '<?php _e('غير مُعد', 'mohtawa'); ?>',
                done: '<?php _e('منجز', 'mohtawa'); ?>',
                undone: '<?php _e('غير منجز', 'mohtawa'); ?>',
                complete: '<?php _e('مكتمل', 'mohtawa'); ?>',
                incomplete: '<?php _e('غير مكتمل', 'mohtawa'); ?>',
                perfect: '<?php _e('مثالي', 'mohtawa'); ?>',
                imperfect: '<?php _e('غير مثالي', 'mohtawa'); ?>',
                flawless: '<?php _e('خالي من العيوب', 'mohtawa'); ?>',
                flawed: '<?php _e('معيب', 'mohtawa'); ?>',
                ideal: '<?php _e('مثالي', 'mohtawa'); ?>',
                realistic: '<?php _e('واقعي', 'mohtawa'); ?>',
                unrealistic: '<?php _e('غير واقعي', 'mohtawa'); ?>',
                practical: '<?php _e('عملي', 'mohtawa'); ?>',
                impractical: '<?php _e('غير عملي', 'mohtawa'); ?>',
                logical: '<?php _e('منطقي', 'mohtawa'); ?>',
                illogical: '<?php _e('غير منطقي', 'mohtawa'); ?>',
                reasonable: '<?php _e('معقول', 'mohtawa'); ?>',
                unreasonable: '<?php _e('غير معقول', 'mohtawa'); ?>',
                sensible: '<?php _e('حكيم', 'mohtawa'); ?>',
                nonsensical: '<?php _e('غير منطقي', 'mohtawa'); ?>',
                wise: '<?php _e('حكيم', 'mohtawa'); ?>',
                unwise: '<?php _e('غير حكيم', 'mohtawa'); ?>',
                smart: '<?php _e('ذكي', 'mohtawa'); ?>',
                stupid: '<?php _e('غبي', 'mohtawa'); ?>',
                intelligent: '<?php _e('ذكي', 'mohtawa'); ?>',
                unintelligent: '<?php _e('غير ذكي', 'mohtawa'); ?>',
                clever: '<?php _e('ماهر', 'mohtawa'); ?>',
                foolish: '<?php _e('أحمق', 'mohtawa'); ?>',
                brilliant: '<?php _e('لامع', 'mohtawa'); ?>',
                dull: '<?php _e('باهت', 'mohtawa'); ?>',
                bright: '<?php _e('مشرق', 'mohtawa'); ?>',
                dim: '<?php _e('خافت', 'mohtawa'); ?>',
                sharp: '<?php _e('حاد', 'mohtawa'); ?>',
                blunt: '<?php _e('كليل', 'mohtawa'); ?>',
                quick: '<?php _e('سريع', 'mohtawa'); ?>',
                slow: '<?php _e('بطيء', 'mohtawa'); ?>',
                fast: '<?php _e('سريع', 'mohtawa'); ?>',
                rapid: '<?php _e('سريع', 'mohtawa'); ?>',
                swift: '<?php _e('سريع', 'mohtawa'); ?>',
                speedy: '<?php _e('سريع', 'mohtawa'); ?>',
                hasty: '<?php _e('متسرع', 'mohtawa'); ?>',
                rushed: '<?php _e('مستعجل', 'mohtawa'); ?>',
                urgent: '<?php _e('عاجل', 'mohtawa'); ?>',
                emergency: '<?php _e('طوارئ', 'mohtawa'); ?>',
                critical: '<?php _e('حرج', 'mohtawa'); ?>',
                serious: '<?php _e('جدي', 'mohtawa'); ?>',
                severe: '<?php _e('شديد', 'mohtawa'); ?>',
                mild: '<?php _e('خفيف', 'mohtawa'); ?>',
                gentle: '<?php _e('لطيف', 'mohtawa'); ?>',
                soft: '<?php _e('ناعم', 'mohtawa'); ?>',
                hard: '<?php _e('صلب', 'mohtawa'); ?>',
                tough: '<?php _e('قاسي', 'mohtawa'); ?>',
                rough: '<?php _e('خشن', 'mohtawa'); ?>',
                smooth: '<?php _e('ناعم', 'mohtawa'); ?>',
                bumpy: '<?php _e('وعر', 'mohtawa'); ?>',
                flat: '<?php _e('مسطح', 'mohtawa'); ?>',
                curved: '<?php _e('منحني', 'mohtawa'); ?>',
                straight: '<?php _e('مستقيم', 'mohtawa'); ?>',
                crooked: '<?php _e('معوج', 'mohtawa'); ?>',
                bent: '<?php _e('منحني', 'mohtawa'); ?>',
                twisted: '<?php _e('ملتوي', 'mohtawa'); ?>',
                round: '<?php _e('دائري', 'mohtawa'); ?>',
                square: '<?php _e('مربع', 'mohtawa'); ?>',
                rectangular: '<?php _e('مستطيل', 'mohtawa'); ?>',
                triangular: '<?php _e('مثلث', 'mohtawa'); ?>',
                circular: '<?php _e('دائري', 'mohtawa'); ?>',
                oval: '<?php _e('بيضاوي', 'mohtawa'); ?>',
                spherical: '<?php _e('كروي', 'mohtawa'); ?>',
                cylindrical: '<?php _e('أسطواني', 'mohtawa'); ?>',
                conical: '<?php _e('مخروطي', 'mohtawa'); ?>',
                cubic: '<?php _e('مكعب', 'mohtawa'); ?>',
                linear: '<?php _e('خطي', 'mohtawa'); ?>',
                angular: '<?php _e('زاوي', 'mohtawa'); ?>',
                diagonal: '<?php _e('قطري', 'mohtawa'); ?>',
                horizontal: '<?php _e('أفقي', 'mohtawa'); ?>',
                vertical: '<?php _e('عمودي', 'mohtawa'); ?>',
                parallel: '<?php _e('متوازي', 'mohtawa'); ?>',
                perpendicular: '<?php _e('عمودي', 'mohtawa'); ?>',
                intersecting: '<?php _e('متقاطع', 'mohtawa'); ?>',
                overlapping: '<?php _e('متداخل', 'mohtawa'); ?>',
                adjacent: '<?php _e('مجاور', 'mohtawa'); ?>',
                opposite: '<?php _e('مقابل', 'mohtawa'); ?>',
                facing: '<?php _e('مواجه', 'mohtawa'); ?>',
                backward: '<?php _e('للخلف', 'mohtawa'); ?>',
                forward: '<?php _e('للأمام', 'mohtawa'); ?>',
                upward: '<?php _e('للأعلى', 'mohtawa'); ?>',
                downward: '<?php _e('للأسفل', 'mohtawa'); ?>',
                inward: '<?php _e('للداخل', 'mohtawa'); ?>',
                outward: '<?php _e('للخارج', 'mohtawa'); ?>',
                sideways: '<?php _e('جانبياً', 'mohtawa'); ?>',
                clockwise: '<?php _e('باتجاه عقارب الساعة', 'mohtawa'); ?>',
                counterclockwise: '<?php _e('عكس عقارب الساعة', 'mohtawa'); ?>',
                ascending: '<?php _e('تصاعدي', 'mohtawa'); ?>',
                descending: '<?php _e('تنازلي', 'mohtawa'); ?>',
                increasing: '<?php _e('متزايد', 'mohtawa'); ?>',
                decreasing: '<?php _e('متناقص', 'mohtawa'); ?>',
                growing: '<?php _e('نامي', 'mohtawa'); ?>',
                shrinking: '<?php _e('متقلص', 'mohtawa'); ?>',
                expanding: '<?php _e('متوسع', 'mohtawa'); ?>',
                contracting: '<?php _e('متقلص', 'mohtawa'); ?>',
                stretching: '<?php _e('ممتد', 'mohtawa'); ?>',
                compressing: '<?php _e('مضغوط', 'mohtawa'); ?>',
                extending: '<?php _e('ممتد', 'mohtawa'); ?>',
                retracting: '<?php _e('منكمش', 'mohtawa'); ?>',
                opening: '<?php _e('فاتح', 'mohtawa'); ?>',
                closing: '<?php _e('مغلق', 'mohtawa'); ?>',
                entering: '<?php _e('داخل', 'mohtawa'); ?>',
                exiting: '<?php _e('خارج', 'mohtawa'); ?>',
                arriving: '<?php _e('واصل', 'mohtawa'); ?>',
                departing: '<?php _e('مغادر', 'mohtawa'); ?>',
                coming: '<?php _e('قادم', 'mohtawa'); ?>',
                going: '<?php _e('ذاهب', 'mohtawa'); ?>',
                staying: '<?php _e('باقي', 'mohtawa'); ?>',
                leaving: '<?php _e('مغادر', 'mohtawa'); ?>',
                remaining: '<?php _e('باقي', 'mohtawa'); ?>',
                moving: '<?php _e('متحرك', 'mohtawa'); ?>',
                stationary: '<?php _e('ثابت', 'mohtawa'); ?>',
                mobile: '<?php _e('متنقل', 'mohtawa'); ?>',
                immobile: '<?php _e('غير متحرك', 'mohtawa'); ?>',
                portable: '<?php _e('محمول', 'mohtawa'); ?>',
                fixed: '<?php _e('ثابت', 'mohtawa'); ?>',
                permanent: '<?php _e('دائم', 'mohtawa'); ?>',
                temporary: '<?php _e('مؤقت', 'mohtawa'); ?>',
                lasting: '<?php _e('دائم', 'mohtawa'); ?>',
                brief: '<?php _e('قصير', 'mohtawa'); ?>',
                long: '<?php _e('طويل', 'mohtawa'); ?>',
                short: '<?php _e('قصير', 'mohtawa'); ?>',
                tall: '<?php _e('طويل', 'mohtawa'); ?>',
                high: '<?php _e('عالي', 'mohtawa'); ?>',
                low: '<?php _e('منخفض', 'mohtawa'); ?>',
                deep: '<?php _e('عميق', 'mohtawa'); ?>',
                shallow: '<?php _e('ضحل', 'mohtawa'); ?>',
                wide: '<?php _e('واسع', 'mohtawa'); ?>',
                narrow: '<?php _e('ضيق', 'mohtawa'); ?>',
                broad: '<?php _e('عريض', 'mohtawa'); ?>',
                thin: '<?php _e('رفيع', 'mohtawa'); ?>',
                thick: '<?php _e('سميك', 'mohtawa'); ?>',
                fat: '<?php _e('سمين', 'mohtawa'); ?>',
                skinny: '<?php _e('نحيف', 'mohtawa'); ?>',
                slim: '<?php _e('نحيل', 'mohtawa'); ?>',
                lean: '<?php _e('نحيل', 'mohtawa'); ?>',
                heavy: '<?php _e('ثقيل', 'mohtawa'); ?>',
                light: '<?php _e('خفيف', 'mohtawa'); ?>',
                dense: '<?php _e('كثيف', 'mohtawa'); ?>',
                sparse: '<?php _e('متناثر', 'mohtawa'); ?>',
                crowded: '<?php _e('مزدحم', 'mohtawa'); ?>',
                empty: '<?php _e('فارغ', 'mohtawa'); ?>',
                full: '<?php _e('ممتلئ', 'mohtawa'); ?>',
                packed: '<?php _e('محشو', 'mohtawa'); ?>',
                stuffed: '<?php _e('محشو', 'mohtawa'); ?>',
                loaded: '<?php _e('محمل', 'mohtawa'); ?>',
                unloaded: '<?php _e('غير محمل', 'mohtawa'); ?>',
                filled: '<?php _e('مملوء', 'mohtawa'); ?>',
                unfilled: '<?php _e('غير مملوء', 'mohtawa'); ?>',
                occupied: '<?php _e('مشغول', 'mohtawa'); ?>',
                vacant: '<?php _e('شاغر', 'mohtawa'); ?>',
                busy: '<?php _e('مشغول', 'mohtawa'); ?>',
                free: '<?php _e('حر', 'mohtawa'); ?>',
                available: '<?php _e('متاح', 'mohtawa'); ?>',
                unavailable: '<?php _e('غير متاح', 'mohtawa'); ?>',
                accessible: '<?php _e('قابل للوصول', 'mohtawa'); ?>',
                inaccessible: '<?php _e('غير قابل للوصول', 'mohtawa'); ?>',
                reachable: '<?php _e('قابل للوصول', 'mohtawa'); ?>',
                unreachable: '<?php _e('غير قابل للوصول', 'mohtawa'); ?>',
                approachable: '<?php _e('قابل للاقتراب', 'mohtawa'); ?>',
                unapproachable: '<?php _e('غير قابل للاقتراب', 'mohtawa'); ?>',
                friendly: '<?php _e('ودود', 'mohtawa'); ?>',
                unfriendly: '<?php _e('غير ودود', 'mohtawa'); ?>',
                kind: '<?php _e('لطيف', 'mohtawa'); ?>',
                unkind: '<?php _e('غير لطيف', 'mohtawa'); ?>',
                polite: '<?php _e('مهذب', 'mohtawa'); ?>',
                impolite: '<?php _e('غير مهذب', 'mohtawa'); ?>',
                rude: '<?php _e('وقح', 'mohtawa'); ?>',
                courteous: '<?php _e('مهذب', 'mohtawa'); ?>',
                discourteous: '<?php _e('غير مهذب', 'mohtawa'); ?>',
                respectful: '<?php _e('محترم', 'mohtawa'); ?>',
                disrespectful: '<?php _e('غير محترم', 'mohtawa'); ?>',
                patient: '<?php _e('صبور', 'mohtawa'); ?>',
                impatient: '<?php _e('غير صبور', 'mohtawa'); ?>',
                calm: '<?php _e('هادئ', 'mohtawa'); ?>',
                agitated: '<?php _e('مضطرب', 'mohtawa'); ?>',
                peaceful: '<?php _e('مسالم', 'mohtawa'); ?>',
                violent: '<?php _e('عنيف', 'mohtawa'); ?>',
                gentle: '<?php _e('لطيف', 'mohtawa'); ?>',
                harsh: '<?php _e('قاسي', 'mohtawa'); ?>',
                tender: '<?php _e('رقيق', 'mohtawa'); ?>',
                rough: '<?php _e('خشن', 'mohtawa'); ?>',
                delicate: '<?php _e('رقيق', 'mohtawa'); ?>',
                sturdy: '<?php _e('قوي', 'mohtawa'); ?>',
                fragile: '<?php _e('هش', 'mohtawa'); ?>',
                strong: '<?php _e('قوي', 'mohtawa'); ?>',
                weak: '<?php _e('ضعيف', 'mohtawa'); ?>',
                powerful: '<?php _e('قوي', 'mohtawa'); ?>',
                powerless: '<?php _e('عاجز', 'mohtawa'); ?>',
                mighty: '<?php _e('جبار', 'mohtawa'); ?>',
                feeble: '<?php _e('ضعيف', 'mohtawa'); ?>',
                robust: '<?php _e('قوي', 'mohtawa'); ?>',
                frail: '<?php _e('هزيل', 'mohtawa'); ?>',
                healthy: '<?php _e('صحي', 'mohtawa'); ?>',
                unhealthy: '<?php _e('غير صحي', 'mohtawa'); ?>',
                fit: '<?php _e('لائق', 'mohtawa'); ?>',
                unfit: '<?php _e('غير لائق', 'mohtawa'); ?>',
                well: '<?php _e('بخير', 'mohtawa'); ?>',
                sick: '<?php _e('مريض', 'mohtawa'); ?>',
                ill: '<?php _e('مريض', 'mohtawa'); ?>',
                diseased: '<?php _e('مريض', 'mohtawa'); ?>',
                injured: '<?php _e('مصاب', 'mohtawa'); ?>',
                wounded: '<?php _e('جريح', 'mohtawa'); ?>',
                hurt: '<?php _e('مؤذى', 'mohtawa'); ?>',
                damaged: '<?php _e('تالف', 'mohtawa'); ?>',
                broken: '<?php _e('مكسور', 'mohtawa'); ?>',
                cracked: '<?php _e('متشقق', 'mohtawa'); ?>',
                torn: '<?php _e('ممزق', 'mohtawa'); ?>',
                ripped: '<?php _e('ممزق', 'mohtawa'); ?>',
                split: '<?php _e('منقسم', 'mohtawa'); ?>',
                separated: '<?php _e('منفصل', 'mohtawa'); ?>',
                divided: '<?php _e('مقسم', 'mohtawa'); ?>',
                united: '<?php _e('متحد', 'mohtawa'); ?>',
                joined: '<?php _e('متصل', 'mohtawa'); ?>',
                connected: '<?php _e('متصل', 'mohtawa'); ?>',
                linked: '<?php _e('مرتبط', 'mohtawa'); ?>',
                attached: '<?php _e('مرفق', 'mohtawa'); ?>',
                detached: '<?php _e('منفصل', 'mohtawa'); ?>',
                bound: '<?php _e('مربوط', 'mohtawa'); ?>',
                unbound: '<?php _e('غير مربوط', 'mohtawa'); ?>',
                tied: '<?php _e('مربوط', 'mohtawa'); ?>',
                untied: '<?php _e('غير مربوط', 'mohtawa'); ?>',
                fastened: '<?php _e('مثبت', 'mohtawa'); ?>',
                unfastened: '<?php _e('غير مثبت', 'mohtawa'); ?>',
                secured: '<?php _e('مؤمن', 'mohtawa'); ?>',
                unsecured: '<?php _e('غير مؤمن', 'mohtawa'); ?>',
                anchored: '<?php _e('مثبت', 'mohtawa'); ?>',
                loose: '<?php _e('فضفاض', 'mohtawa'); ?>',
                tight: '<?php _e('ضيق', 'mohtawa'); ?>',
                snug: '<?php _e('محكم', 'mohtawa'); ?>',
                relaxed: '<?php _e('مسترخي', 'mohtawa'); ?>',
                tense: '<?php _e('متوتر', 'mohtawa'); ?>',
                stressed: '<?php _e('مضغوط', 'mohtawa'); ?>',
                unstressed: '<?php _e('غير مضغوط', 'mohtawa'); ?>',
                compressed: '<?php _e('مضغوط', 'mohtawa'); ?>',
                expanded: '<?php _e('موسع', 'mohtawa'); ?>',
                stretched: '<?php _e('ممدود', 'mohtawa'); ?>',
                contracted: '<?php _e('منقبض', 'mohtawa'); ?>',
                extended: '<?php _e('ممتد', 'mohtawa'); ?>',
                retracted: '<?php _e('منكمش', 'mohtawa'); ?>',
                inflated: '<?php _e('منفوخ', 'mohtawa'); ?>',
                deflated: '<?php _e('منكمش', 'mohtawa'); ?>',
                swollen: '<?php _e('منتفخ', 'mohtawa'); ?>',
                shrunken: '<?php _e('منكمش', 'mohtawa'); ?>',
                enlarged: '<?php _e('مكبر', 'mohtawa'); ?>',
                reduced: '<?php _e('مصغر', 'mohtawa'); ?>',
                magnified: '<?php _e('مكبر', 'mohtawa'); ?>',
                minimized: '<?php _e('مصغر', 'mohtawa'); ?>',
                maximized: '<?php _e('مكبر', 'mohtawa'); ?>',
                optimized: '<?php _e('محسن', 'mohtawa'); ?>',
                improved: '<?php _e('محسن', 'mohtawa'); ?>',
                enhanced: '<?php _e('محسن', 'mohtawa'); ?>',
                upgraded: '<?php _e('محدث', 'mohtawa'); ?>',
                downgraded: '<?php _e('مخفض', 'mohtawa'); ?>',
                advanced: '<?php _e('متقدم', 'mohtawa'); ?>',
                primitive: '<?php _e('بدائي', 'mohtawa'); ?>',
                modern: '<?php _e('حديث', 'mohtawa'); ?>',
                ancient: '<?php _e('قديم', 'mohtawa'); ?>',
                contemporary: '<?php _e('معاصر', 'mohtawa'); ?>',
                traditional: '<?php _e('تقليدي', 'mohtawa'); ?>',
                conventional: '<?php _e('تقليدي', 'mohtawa'); ?>',
                unconventional: '<?php _e('غير تقليدي', 'mohtawa'); ?>',
                innovative: '<?php _e('مبتكر', 'mohtawa'); ?>',
                creative: '<?php _e('إبداعي', 'mohtawa'); ?>',
                original: '<?php _e('أصلي', 'mohtawa'); ?>',
                unique: '<?php _e('فريد', 'mohtawa'); ?>',
                special: '<?php _e('خاص', 'mohtawa'); ?>',
                ordinary: '<?php _e('عادي', 'mohtawa'); ?>',
                common: '<?php _e('شائع', 'mohtawa'); ?>',
                rare: '<?php _e('نادر', 'mohtawa'); ?>',
                unusual: '<?php _e('غير عادي', 'mohtawa'); ?>',
                typical: '<?php _e('نموذجي', 'mohtawa'); ?>',
                atypical: '<?php _e('غير نموذجي', 'mohtawa'); ?>',
                standard: '<?php _e('قياسي', 'mohtawa'); ?>',
                nonstandard: '<?php _e('غير قياسي', 'mohtawa'); ?>',
                regular: '<?php _e('منتظم', 'mohtawa'); ?>',
                irregular: '<?php _e('غير منتظم', 'mohtawa'); ?>',
                normal: '<?php _e('طبيعي', 'mohtawa'); ?>',
                abnormal: '<?php _e('غير طبيعي', 'mohtawa'); ?>',
                natural: '<?php _e('طبيعي', 'mohtawa'); ?>',
                artificial: '<?php _e('اصطناعي', 'mohtawa'); ?>',
                synthetic: '<?php _e('صناعي', 'mohtawa'); ?>',
                genuine: '<?php _e('أصلي', 'mohtawa'); ?>',
                fake: '<?php _e('مزيف', 'mohtawa'); ?>',
                real: '<?php _e('حقيقي', 'mohtawa'); ?>',
                imaginary: '<?php _e('خيالي', 'mohtawa'); ?>',
                fictional: '<?php _e('خيالي', 'mohtawa'); ?>',
                factual: '<?php _e('واقعي', 'mohtawa'); ?>',
                actual: '<?php _e('فعلي', 'mohtawa'); ?>',
                virtual: '<?php _e('افتراضي', 'mohtawa'); ?>',
                digital: '<?php _e('رقمي', 'mohtawa'); ?>',
                analog: '<?php _e('تناظري', 'mohtawa'); ?>',
                electronic: '<?php _e('إلكتروني', 'mohtawa'); ?>',
                mechanical: '<?php _e('ميكانيكي', 'mohtawa'); ?>',
                manual: '<?php _e('يدوي', 'mohtawa'); ?>',
                automatic: '<?php _e('تلقائي', 'mohtawa'); ?>',
                automated: '<?php _e('آلي', 'mohtawa'); ?>',
                computerized: '<?php _e('محوسب', 'mohtawa'); ?>',
                technological: '<?php _e('تقني', 'mohtawa'); ?>',
                technical: '<?php _e('تقني', 'mohtawa'); ?>',
                scientific: '<?php _e('علمي', 'mohtawa'); ?>',
                academic: '<?php _e('أكاديمي', 'mohtawa'); ?>',
                educational: '<?php _e('تعليمي', 'mohtawa'); ?>',
                instructional: '<?php _e('تعليمي', 'mohtawa'); ?>',
                informational: '<?php _e('إعلامي', 'mohtawa'); ?>',
                entertaining: '<?php _e('ترفيهي', 'mohtawa'); ?>',
                recreational: '<?php _e('ترفيهي', 'mohtawa'); ?>',
                commercial: '<?php _e('تجاري', 'mohtawa'); ?>',
                industrial: '<?php _e('صناعي', 'mohtawa'); ?>',
                residential: '<?php _e('سكني', 'mohtawa'); ?>',
                agricultural: '<?php _e('زراعي', 'mohtawa'); ?>',
                medical: '<?php _e('طبي', 'mohtawa'); ?>',
                legal: '<?php _e('قانوني', 'mohtawa'); ?>',
                financial: '<?php _e('مالي', 'mohtawa'); ?>',
                economic: '<?php _e('اقتصادي', 'mohtawa'); ?>',
                political: '<?php _e('سياسي', 'mohtawa'); ?>',
                social: '<?php _e('اجتماعي', 'mohtawa'); ?>',
                cultural: '<?php _e('ثقافي', 'mohtawa'); ?>',
                religious: '<?php _e('ديني', 'mohtawa'); ?>',
                spiritual: '<?php _e('روحي', 'mohtawa'); ?>',
                physical: '<?php _e('جسدي', 'mohtawa'); ?>',
                mental: '<?php _e('عقلي', 'mohtawa'); ?>',
                emotional: '<?php _e('عاطفي', 'mohtawa'); ?>',
                psychological: '<?php _e('نفسي', 'mohtawa'); ?>',
                personal: '<?php _e('شخصي', 'mohtawa'); ?>',
                private: '<?php _e('خاص', 'mohtawa'); ?>',
                public: '<?php _e('عام', 'mohtawa'); ?>',
                official: '<?php _e('رسمي', 'mohtawa'); ?>',
                unofficial: '<?php _e('غير رسمي', 'mohtawa'); ?>',
                formal: '<?php _e('رسمي', 'mohtawa'); ?>',
                informal: '<?php _e('غير رسمي', 'mohtawa'); ?>',
                casual: '<?php _e('عادي', 'mohtawa'); ?>',
                serious: '<?php _e('جدي', 'mohtawa'); ?>',
                professional: '<?php _e('مهني', 'mohtawa'); ?>',
                amateur: '<?php _e('هاوي', 'mohtawa'); ?>',
                expert: '<?php _e('خبير', 'mohtawa'); ?>',
                novice: '<?php _e('مبتدئ', 'mohtawa'); ?>',
                beginner: '<?php _e('مبتدئ', 'mohtawa'); ?>',
                intermediate: '<?php _e('متوسط', 'mohtawa'); ?>',
                advanced: '<?php _e('متقدم', 'mohtawa'); ?>',
                master: '<?php _e('خبير', 'mohtawa'); ?>',
                skilled: '<?php _e('ماهر', 'mohtawa'); ?>',
                unskilled: '<?php _e('غير ماهر', 'mohtawa'); ?>',
                qualified: '<?php _e('مؤهل', 'mohtawa'); ?>',
                unqualified: '<?php _e('غير مؤهل', 'mohtawa'); ?>',
                certified: '<?php _e('معتمد', 'mohtawa'); ?>',
                uncertified: '<?php _e('غير معتمد', 'mohtawa'); ?>',
                licensed: '<?php _e('مرخص', 'mohtawa'); ?>',
                unlicensed: '<?php _e('غير مرخص', 'mohtawa'); ?>',
                authorized: '<?php _e('مخول', 'mohtawa'); ?>',
                unauthorized: '<?php _e('غير مخول', 'mohtawa'); ?>',
                approved: '<?php _e('موافق عليه', 'mohtawa'); ?>',
                unapproved: '<?php _e('غير موافق عليه', 'mohtawa'); ?>',
                accepted: '<?php _e('مقبول', 'mohtawa'); ?>',
                rejected: '<?php _e('مرفوض', 'mohtawa'); ?>',
                confirmed: '<?php _e('مؤكد', 'mohtawa'); ?>',
                unconfirmed: '<?php _e('غير مؤكد', 'mohtawa'); ?>',
                verified: '<?php _e('محقق', 'mohtawa'); ?>',
                unverified: '<?php _e('غير محقق', 'mohtawa'); ?>',
                validated: '<?php _e('مصدق', 'mohtawa'); ?>',
                invalidated: '<?php _e('غير مصدق', 'mohtawa'); ?>',
                authenticated: '<?php _e('مصادق عليه', 'mohtawa'); ?>',
                unauthenticated: '<?php _e('غير مصادق عليه', 'mohtawa'); ?>',
                registered: '<?php _e('مسجل', 'mohtawa'); ?>',
                unregistered: '<?php _e('غير مسجل', 'mohtawa'); ?>',
                enrolled: '<?php _e('مسجل', 'mohtawa'); ?>',
                unenrolled: '<?php _e('غير مسجل', 'mohtawa'); ?>',
                subscribed: '<?php _e('مشترك', 'mohtawa'); ?>',
                unsubscribed: '<?php _e('غير مشترك', 'mohtawa'); ?>',
                member: '<?php _e('عضو', 'mohtawa'); ?>',
                nonmember: '<?php _e('غير عضو', 'mohtawa'); ?>',
                participant: '<?php _e('مشارك', 'mohtawa'); ?>',
                nonparticipant: '<?php _e('غير مشارك', 'mohtawa'); ?>',
                attendee: '<?php _e('حاضر', 'mohtawa'); ?>',
                absentee: '<?php _e('غائب', 'mohtawa'); ?>',
                present: '<?php _e('حاضر', 'mohtawa'); ?>',
                absent: '<?php _e('غائب', 'mohtawa'); ?>',
                attending: '<?php _e('حاضر', 'mohtawa'); ?>',
                missing: '<?php _e('مفقود', 'mohtawa'); ?>',
                found: '<?php _e('موجود', 'mohtawa'); ?>',
                lost: '<?php _e('مفقود', 'mohtawa'); ?>',
                discovered: '<?php _e('مكتشف', 'mohtawa'); ?>',
                hidden: '<?php _e('مخفي', 'mohtawa'); ?>',
                revealed: '<?php _e('مكشوف', 'mohtawa'); ?>',
                exposed: '<?php _e('مكشوف', 'mohtawa'); ?>',
                concealed: '<?php _e('مخفي', 'mohtawa'); ?>',
                visible: '<?php _e('مرئي', 'mohtawa'); ?>',
                invisible: '<?php _e('غير مرئي', 'mohtawa'); ?>',
                apparent: '<?php _e('واضح', 'mohtawa'); ?>',
                obvious: '<?php _e('واضح', 'mohtawa'); ?>',
                clear: '<?php _e('واضح', 'mohtawa'); ?>',
                unclear: '<?php _e('غير واضح', 'mohtawa'); ?>',
                vague: '<?php _e('غامض', 'mohtawa'); ?>',
                ambiguous: '<?php _e('غامض', 'mohtawa'); ?>'
            }
        };
    </script>

    <?php wp_footer(); ?>
</body>
</html>


