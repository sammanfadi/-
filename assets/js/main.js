/**
 * قالب محتوى - JavaScript الرئيسي
 * نسخة 1.0.0
 */

(function($) {
    'use strict';

    // متغيرات عامة
    let map;
    let markersGroup;
    let userLocationMarker;
    let currentFilters = {};
    let currentSort = 'distance';
    let currentPage = 1;
    let isLoading = false;
    let userLocation = null;
    let searchTimeout;

    // إعدادات افتراضية
    const defaults = {
        mapCenter: [24.7136, 46.6753],
        mapZoom: 11,
        maxZoom: 18,
        minZoom: 8,
        searchDelay: 300,
        loadMoreLimit: 10,
        clusterDistance: 80
    };

    // تهيئة التطبيق
    $(document).ready(function() {
        initializeApp();
    });

    /**
     * تهيئة التطبيق الرئيسي
     */
    function initializeApp() {
        initializeMap();
        initializeSearch();
        initializeFilters();
        initializeEventListeners();
        initializeUserLocation();
        loadStores();
        initializeAnimations();
        initializeCookieNotice();
        initializeBackToTop();
        initializeTooltips();
        initializeLazyLoading();
    }

    /**
     * تهيئة الخريطة التفاعلية
     */
    function initializeMap() {
        try {
            // إنشاء الخريطة
            map = L.map('interactive-map', {
                center: window.mapConfig?.defaultCenter || defaults.mapCenter,
                zoom: window.mapConfig?.defaultZoom || defaults.mapZoom,
                maxZoom: window.mapConfig?.maxZoom || defaults.maxZoom,
                minZoom: window.mapConfig?.minZoom || defaults.minZoom,
                zoomControl: false,
                attributionControl: true
            });

            // إضافة طبقة الخريطة
            L.tileLayer(window.mapConfig?.tileLayer || 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: window.mapConfig?.attribution || '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: window.mapConfig?.maxZoom || defaults.maxZoom
            }).addTo(map);

            // إنشاء مجموعة العلامات مع التجميع
            markersGroup = L.markerClusterGroup({
                maxClusterRadius: window.mapConfig?.clusterDistance || defaults.clusterDistance,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                iconCreateFunction: function(cluster) {
                    const count = cluster.getChildCount();
                    let className = 'marker-cluster marker-cluster-';
                    
                    if (count < 10) {
                        className += 'small';
                    } else if (count < 100) {
                        className += 'medium';
                    } else {
                        className += 'large';
                    }
                    
                    return L.divIcon({
                        html: '<div><span>' + count + '</span></div>',
                        className: className,
                        iconSize: L.point(40, 40)
                    });
                }
            });

            map.addLayer(markersGroup);

            // إخفاء مؤشر التحميل
            $('#map-loading').hide();

            console.log('تم تهيئة الخريطة بنجاح');
        } catch (error) {
            console.error('خطأ في تهيئة الخريطة:', error);
            showError('فشل في تحميل الخريطة');
        }
    }

    /**
     * تهيئة نظام البحث
     */
    function initializeSearch() {
        const $searchInput = $('#main-search');
        const $suggestionsContainer = $('#search-suggestions-main');

        $searchInput.on('input', function() {
            const query = $(this).val().trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    searchStores(query);
                    loadSearchSuggestions(query);
                }, defaults.searchDelay);
            } else {
                $suggestionsContainer.hide();
                if (query.length === 0) {
                    clearSearch();
                }
            }
        });

        $searchInput.on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = $(this).val().trim();
                if (query) {
                    searchStores(query);
                }
                $suggestionsContainer.hide();
            }
        });

        // إخفاء الاقتراحات عند النقر خارجها
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-search-bar').length) {
                $suggestionsContainer.hide();
            }
        });
    }

    /**
     * تحميل اقتراحات البحث
     */
    function loadSearchSuggestions(query) {
        $.ajax({
            url: mohtawaTheme.ajaxUrl,
            type: 'POST',
            data: {
                action: 'get_search_suggestions',
                query: query,
                nonce: mohtawaTheme.nonce
            },
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    displaySearchSuggestions(response.data);
                } else {
                    $('#search-suggestions-main').hide();
                }
            },
            error: function() {
                console.error('خطأ في تحميل اقتراحات البحث');
            }
        });
    }

    /**
     * عرض اقتراحات البحث
     */
    function displaySearchSuggestions(suggestions) {
        const $container = $('#search-suggestions-main .suggestions-list');
        $container.empty();

        suggestions.forEach(function(suggestion) {
            const $item = $('<div class="suggestion-item">')
                .html(`
                    <div class="d-flex align-items-center">
                        <i class="fas fa-${suggestion.type === 'store' ? 'store' : 'search'} me-2 text-muted"></i>
                        <div>
                            <div class="fw-medium">${suggestion.title}</div>
                            ${suggestion.subtitle ? `<small class="text-muted">${suggestion.subtitle}</small>` : ''}
                        </div>
                    </div>
                `)
                .on('click', function() {
                    $('#main-search').val(suggestion.title);
                    searchStores(suggestion.title);
                    $('#search-suggestions-main').hide();
                });
            
            $container.append($item);
        });

        $('#search-suggestions-main').show();
    }

    /**
     * تهيئة الفلاتر
     */
    function initializeFilters() {
        // تطبيق الفلاتر
        $('#apply-filters').on('click', function() {
            applyFilters();
        });

        // مسح الفلاتر
        $('#clear-filters').on('click', function() {
            clearFilters();
        });

        // تغيير الفلاتر
        $('#category-filter, #location-filter, #rating-filter, #distance-filter, #status-filter').on('change', function() {
            if ($(this).val()) {
                applyFilters();
            }
        });

        // فلاتر الميزات
        $('input[name="features[]"]').on('change', function() {
            applyFilters();
        });

        // ترتيب النتائج
        $('.dropdown-menu a[data-sort]').on('click', function(e) {
            e.preventDefault();
            const sortBy = $(this).data('sort');
            changeSorting(sortBy);
        });
    }

    /**
     * تطبيق الفلاتر
     */
    function applyFilters() {
        currentFilters = {
            category: $('#category-filter').val(),
            location: $('#location-filter').val(),
            rating: $('#rating-filter').val(),
            distance: $('#distance-filter').val(),
            status: $('#status-filter').val(),
            features: $('input[name="features[]"]:checked').map(function() {
                return $(this).val();
            }).get()
        };

        currentPage = 1;
        loadStores();
        
        // إغلاق الفلاتر المتقدمة
        $('#advanced-filters').collapse('hide');
    }

    /**
     * مسح الفلاتر
     */
    function clearFilters() {
        $('#category-filter, #location-filter, #rating-filter, #distance-filter, #status-filter').val('');
        $('input[name="features[]"]').prop('checked', false);
        currentFilters = {};
        currentPage = 1;
        loadStores();
    }

    /**
     * مسح البحث
     */
    function clearSearch() {
        $('#main-search').val('');
        currentFilters.search = '';
        currentPage = 1;
        loadStores();
    }

    /**
     * تغيير طريقة الترتيب
     */
    function changeSorting(sortBy) {
        currentSort = sortBy;
        currentPage = 1;
        loadStores();
        
        // تحديث نص الزر
        const sortText = {
            'distance': 'المسافة',
            'rating': 'التقييم',
            'name': 'الاسم',
            'newest': 'الأحدث'
        };
        
        $('.dropdown-toggle').html(`<i class="fas fa-sort me-1"></i> ${sortText[sortBy]}`);
    }

    /**
     * البحث عن المتاجر
     */
    function searchStores(query) {
        currentFilters.search = query;
        currentPage = 1;
        loadStores();
    }

    /**
     * تحميل المتاجر
     */
    function loadStores(append = false) {
        if (isLoading) return;
        
        isLoading = true;
        
        if (!append) {
            showStoresLoading();
        }

        const data = {
            action: 'get_stores',
            page: currentPage,
            sort: currentSort,
            filters: currentFilters,
            user_location: userLocation,
            nonce: mohtawaTheme.nonce
        };

        $.ajax({
            url: mohtawaTheme.ajaxUrl,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    if (append) {
                        appendStores(response.data.stores);
                    } else {
                        displayStores(response.data.stores);
                    }
                    
                    updateMapMarkers(response.data.stores);
                    updateStoresCount(response.data.total);
                    
                    // إظهار/إخفاء زر تحميل المزيد
                    if (response.data.has_more) {
                        $('#load-more-container').show();
                    } else {
                        $('#load-more-container').hide();
                    }
                } else {
                    showError(response.data || 'خطأ في تحميل المتاجر');
                }
            },
            error: function() {
                showError('خطأ في الاتصال بالخادم');
            },
            complete: function() {
                isLoading = false;
                hideStoresLoading();
            }
        });
    }

    /**
     * عرض مؤشر تحميل المتاجر
     */
    function showStoresLoading() {
        $('#stores-loading').show();
        $('#stores-content').hide();
        $('#stores-empty').hide();
    }

    /**
     * إخفاء مؤشر تحميل المتاجر
     */
    function hideStoresLoading() {
        $('#stores-loading').hide();
    }

    /**
     * عرض المتاجر
     */
    function displayStores(stores) {
        const $container = $('#stores-content');
        $container.empty();

        if (stores.length === 0) {
            $('#stores-empty').show();
            $('#stores-content').hide();
            return;
        }

        stores.forEach(function(store) {
            const $storeItem = createStoreItem(store);
            $container.append($storeItem);
        });

        $('#stores-content').show();
        $('#stores-empty').hide();
    }

    /**
     * إضافة المتاجر (للتحميل التدريجي)
     */
    function appendStores(stores) {
        const $container = $('#stores-content');
        
        stores.forEach(function(store) {
            const $storeItem = createStoreItem(store);
            $container.append($storeItem);
        });
    }

    /**
     * إنشاء عنصر متجر
     */
    function createStoreItem(store) {
        const ratingStars = generateRatingStars(store.rating);
        const distance = store.distance ? `${store.distance.toFixed(1)} كم` : '';
        const statusClass = store.is_open ? 'open' : 'closed';
        const statusText = store.is_open ? 'مفتوح' : 'مغلق';

        return $(`
            <div class="store-item" data-store-id="${store.id}" data-lat="${store.latitude}" data-lng="${store.longitude}">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="store-name mb-0">${store.name}</h6>
                    <span class="store-status ${statusClass}">${statusText}</span>
                </div>
                
                ${store.category ? `<div class="store-category">${store.category}</div>` : ''}
                
                ${store.rating ? `
                    <div class="store-rating">
                        <span class="stars">${ratingStars}</span>
                        <small class="text-muted">(${store.rating}/5)</small>
                    </div>
                ` : ''}
                
                ${store.address ? `<div class="store-address"><i class="fas fa-map-marker-alt me-1"></i>${store.address}</div>` : ''}
                
                <div class="d-flex justify-content-between align-items-center mt-2">
                    ${distance ? `<span class="store-distance">${distance}</span>` : '<span></span>'}
                    <div class="store-actions">
                        <button class="btn btn-sm btn-outline-primary me-1" onclick="viewStoreDetails(${store.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="showStoreOnMap(${store.id})">
                            <i class="fas fa-map-marked-alt"></i>
                        </button>
                        ${store.phone ? `
                            <a href="tel:${store.phone}" class="btn btn-sm btn-outline-success ms-1">
                                <i class="fas fa-phone"></i>
                            </a>
                        ` : ''}
                    </div>
                </div>
            </div>
        `).on('click', function() {
            highlightStore(store.id);
            showStoreOnMap(store.id);
        });
    }

    /**
     * توليد نجوم التقييم
     */
    function generateRatingStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += i <= rating ? '★' : '☆';
        }
        return stars;
    }

    /**
     * تحديث علامات الخريطة
     */
    function updateMapMarkers(stores) {
        // مسح العلامات الحالية
        markersGroup.clearLayers();

        stores.forEach(function(store) {
            if (store.latitude && store.longitude) {
                const marker = createStoreMarker(store);
                markersGroup.addLayer(marker);
            }
        });

        // تحديث عدد المتاجر المرئية
        updateVisibleStoresCount(stores.length);
    }

    /**
     * إنشاء علامة متجر على الخريطة
     */
    function createStoreMarker(store) {
        const icon = L.divIcon({
            className: 'custom-marker',
            html: `
                <div class="marker-pin" style="background-color: ${store.category_color || '#3498db'}">
                    <i class="fas fa-${store.category_icon || 'store'}"></i>
                </div>
            `,
            iconSize: [30, 30],
            iconAnchor: [15, 30]
        });

        const marker = L.marker([store.latitude, store.longitude], { icon: icon });
        
        const popupContent = createMarkerPopup(store);
        marker.bindPopup(popupContent);

        marker.on('click', function() {
            highlightStore(store.id);
            scrollToStore(store.id);
        });

        return marker;
    }

    /**
     * إنشاء محتوى النافذة المنبثقة للعلامة
     */
    function createMarkerPopup(store) {
        const ratingStars = store.rating ? generateRatingStars(store.rating) : '';
        const statusClass = store.is_open ? 'text-success' : 'text-danger';
        const statusText = store.is_open ? 'مفتوح الآن' : 'مغلق';

        return `
            <div class="marker-popup">
                <h6 class="mb-2">${store.name}</h6>
                ${store.category ? `<p class="text-muted small mb-1">${store.category}</p>` : ''}
                ${store.rating ? `<div class="text-warning mb-2">${ratingStars} <small>(${store.rating}/5)</small></div>` : ''}
                <p class="small ${statusClass} mb-2"><i class="fas fa-clock me-1"></i>${statusText}</p>
                ${store.address ? `<p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i>${store.address}</p>` : ''}
                <div class="d-flex gap-1">
                    <button class="btn btn-primary btn-sm flex-fill" onclick="viewStoreDetails(${store.id})">
                        عرض التفاصيل
                    </button>
                    ${store.phone ? `
                        <a href="tel:${store.phone}" class="btn btn-success btn-sm">
                            <i class="fas fa-phone"></i>
                        </a>
                    ` : ''}
                </div>
            </div>
        `;
    }

    /**
     * تحديث عدد المتاجر
     */
    function updateStoresCount(total) {
        $('#total-stores-count').text(total.toLocaleString('ar'));
    }

    /**
     * تحديث عدد المتاجر المرئية
     */
    function updateVisibleStoresCount(count) {
        $('#visible-stores-count').text(count.toLocaleString('ar'));
    }

    /**
     * تهيئة مستمعي الأحداث
     */
    function initializeEventListeners() {
        // أزرار التحكم في الخريطة
        $('#zoom-in').on('click', function() {
            map.zoomIn();
        });

        $('#zoom-out').on('click', function() {
            map.zoomOut();
        });

        $('#center-map').on('click', function() {
            if (userLocation) {
                map.setView(userLocation, 13);
            } else {
                map.setView(defaults.mapCenter, defaults.mapZoom);
            }
        });

        $('#fullscreen-map').on('click', function() {
            toggleFullscreenMap();
        });

        // موقعي
        $('#my-location-btn').on('click', function() {
            getUserLocation();
        });

        // تبديل العرض
        $('#view-toggle').on('click', function() {
            toggleView();
        });

        // تحميل المزيد
        $('#load-more-stores').on('click', function() {
            currentPage++;
            loadStores(true);
        });

        // مسح البحث
        $('#clear-search').on('click', function() {
            clearSearch();
        });

        // تغيير حجم النافذة
        $(window).on('resize', function() {
            if (map) {
                map.invalidateSize();
            }
        });
    }

    /**
     * تهيئة موقع المستخدم
     */
    function initializeUserLocation() {
        if (window.mapConfig?.autoLocate && navigator.geolocation) {
            getUserLocation();
        }
    }

    /**
     * الحصول على موقع المستخدم
     */
    function getUserLocation() {
        if (!navigator.geolocation) {
            showError('المتصفح لا يدعم تحديد الموقع');
            return;
        }

        const $btn = $('#my-location-btn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> جاري التحديد...');

        navigator.geolocation.getCurrentPosition(
            function(position) {
                userLocation = [position.coords.latitude, position.coords.longitude];
                
                // إضافة علامة موقع المستخدم
                if (userLocationMarker) {
                    map.removeLayer(userLocationMarker);
                }

                userLocationMarker = L.marker(userLocation, {
                    icon: L.divIcon({
                        className: 'user-location-marker',
                        html: '<div class="user-location-pin"><i class="fas fa-crosshairs"></i></div>',
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    })
                }).addTo(map);

                userLocationMarker.bindPopup('موقعك الحالي');

                // التحرك إلى موقع المستخدم
                map.setView(userLocation, 13);

                // إعادة تحميل المتاجر مع المسافة
                currentPage = 1;
                loadStores();

                $btn.prop('disabled', false).html('<i class="fas fa-location-arrow me-1"></i> موقعي');
                showSuccess('تم تحديد موقعك بنجاح');
            },
            function(error) {
                let errorMessage = 'فشل في تحديد الموقع';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'تم رفض الإذن للوصول للموقع';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'معلومات الموقع غير متاحة';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'انتهت مهلة تحديد الموقع';
                        break;
                }
                
                showError(errorMessage);
                $btn.prop('disabled', false).html('<i class="fas fa-location-arrow me-1"></i> موقعي');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000
            }
        );
    }

    /**
     * تبديل وضع ملء الشاشة للخريطة
     */
    function toggleFullscreenMap() {
        const $mapContainer = $('#map-container');
        const $storesContainer = $('#stores-list-container');
        const $icon = $('#fullscreen-map i');

        if ($mapContainer.hasClass('fullscreen')) {
            // الخروج من ملء الشاشة
            $mapContainer.removeClass('fullscreen col-12').addClass('col-lg-8 col-md-7');
            $storesContainer.show();
            $icon.removeClass('fa-compress').addClass('fa-expand');
        } else {
            // دخول ملء الشاشة
            $mapContainer.removeClass('col-lg-8 col-md-7').addClass('fullscreen col-12');
            $storesContainer.hide();
            $icon.removeClass('fa-expand').addClass('fa-compress');
        }

        // إعادة تحديد حجم الخريطة
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    }

    /**
     * تبديل العرض بين الخريطة والقائمة
     */
    function toggleView() {
        const $mapContainer = $('#map-container');
        const $storesContainer = $('#stores-list-container');
        const $icon = $('#view-toggle i');

        if (window.innerWidth <= 768) {
            if ($mapContainer.is(':visible')) {
                $mapContainer.hide();
                $storesContainer.show();
                $icon.removeClass('fa-th-large').addClass('fa-map');
            } else {
                $mapContainer.show();
                $storesContainer.hide();
                $icon.removeClass('fa-map').addClass('fa-th-large');
                setTimeout(function() {
                    map.invalidateSize();
                }, 300);
            }
        }
    }

    /**
     * إبراز متجر في القائمة
     */
    function highlightStore(storeId) {
        $('.store-item').removeClass('active');
        $(`.store-item[data-store-id="${storeId}"]`).addClass('active');
    }

    /**
     * التمرير إلى متجر في القائمة
     */
    function scrollToStore(storeId) {
        const $storeItem = $(`.store-item[data-store-id="${storeId}"]`);
        if ($storeItem.length) {
            $('#stores-list').animate({
                scrollTop: $storeItem.offset().top - $('#stores-list').offset().top + $('#stores-list').scrollTop()
            }, 500);
        }
    }

    /**
     * عرض متجر على الخريطة
     */
    window.showStoreOnMap = function(storeId) {
        const $storeItem = $(`.store-item[data-store-id="${storeId}"]`);
        if ($storeItem.length) {
            const lat = parseFloat($storeItem.data('lat'));
            const lng = parseFloat($storeItem.data('lng'));
            
            if (lat && lng) {
                map.setView([lat, lng], 16);
                
                // فتح النافذة المنبثقة للعلامة
                markersGroup.eachLayer(function(layer) {
                    if (layer.getLatLng().lat === lat && layer.getLatLng().lng === lng) {
                        layer.openPopup();
                    }
                });
            }
        }
    };

    /**
     * عرض تفاصيل المتجر
     */
    window.viewStoreDetails = function(storeId) {
        $.ajax({
            url: mohtawaTheme.ajaxUrl,
            type: 'POST',
            data: {
                action: 'get_store_details',
                store_id: storeId,
                nonce: mohtawaTheme.nonce
            },
            beforeSend: function() {
                $('#storeModalBody').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                    </div>
                `);
                $('#storeModal').modal('show');
            },
            success: function(response) {
                if (response.success) {
                    $('#storeModalBody').html(response.data);
                } else {
                    $('#storeModalBody').html('<div class="alert alert-danger">خطأ في تحميل تفاصيل المتجر</div>');
                }
            },
            error: function() {
                $('#storeModalBody').html('<div class="alert alert-danger">خطأ في الاتصال بالخادم</div>');
            }
        });
    };

    /**
     * تهيئة الرسوم المتحركة
     */
    function initializeAnimations() {
        // تحريك الإحصائيات
        if ($('.stat-number').length) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            });

            $('.stat-number').each(function() {
                observer.observe(this);
            });
        }

        // تحريك البطاقات عند الظهور
        if ($('.card').length) {
            const cardObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        $(entry.target).addClass('fade-in');
                        cardObserver.unobserve(entry.target);
                    }
                });
            });

            $('.card').each(function() {
                cardObserver.observe(this);
            });
        }
    }

    /**
     * تحريك العداد
     */
    function animateCounter(element) {
        const $element = $(element);
        const target = parseInt($element.data('count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(function() {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            $element.text(Math.floor(current).toLocaleString('ar'));
        }, 16);
    }

    /**
     * تهيئة إشعار الكوكيز
     */
    function initializeCookieNotice() {
        if (!localStorage.getItem('cookies_accepted') && $('#cookie-notice').length) {
            setTimeout(function() {
                $('#cookie-notice').slideDown();
            }, 2000);
        }

        $('#accept-cookies').on('click', function() {
            localStorage.setItem('cookies_accepted', 'true');
            $('#cookie-notice').slideUp();
        });

        $('#decline-cookies').on('click', function() {
            $('#cookie-notice').slideUp();
        });
    }

    /**
     * تهيئة زر العودة للأعلى
     */
    function initializeBackToTop() {
        const $backToTop = $('#back-to-top');

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });

        $backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 600);
        });
    }

    /**
     * تهيئة التلميحات
     */
    function initializeTooltips() {
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    /**
     * تهيئة التحميل التدريجي للصور
     */
    function initializeLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy-load');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(function(img) {
                img.classList.add('lazy-load');
                imageObserver.observe(img);
            });
        }
    }

    /**
     * عرض رسالة خطأ
     */
    function showError(message) {
        showNotification(message, 'error');
    }

    /**
     * عرض رسالة نجاح
     */
    function showSuccess(message) {
        showNotification(message, 'success');
    }

    /**
     * عرض إشعار
     */
    function showNotification(message, type = 'info') {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        const $notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);

        $('body').append($notification);

        setTimeout(function() {
            $notification.alert('close');
        }, 5000);
    }

    /**
     * تهيئة مشاركة المحتوى
     */
    function initializeSharing() {
        $('#share-facebook').on('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        });

        $('#share-twitter').on('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${title}`, '_blank', 'width=600,height=400');
        });

        $('#share-whatsapp').on('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            window.open(`https://wa.me/?text=${title} ${url}`, '_blank');
        });

        $('#share-telegram').on('click', function(e) {
            e.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent(document.title);
            window.open(`https://t.me/share/url?url=${url}&text=${title}`, '_blank');
        });

        $('#copy-link').on('click', function() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                showSuccess('تم نسخ الرابط');
            }).catch(function() {
                showError('فشل في نسخ الرابط');
            });
        });
    }

    // تهيئة المشاركة عند تحميل الصفحة
    $(document).ready(function() {
        initializeSharing();
    });

    // تصدير الوظائف للاستخدام العام
    window.mohtawaMap = {
        showStoreOnMap: showStoreOnMap,
        viewStoreDetails: viewStoreDetails,
        getUserLocation: getUserLocation,
        searchStores: searchStores,
        applyFilters: applyFilters,
        clearFilters: clearFilters
    };

})(jQuery);

