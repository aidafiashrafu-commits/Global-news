/**
 * Global News Theme - Main JavaScript
 */

(function() {
    'use strict';

    const THEME_KEY = 'global-news-theme';
    const DARK_THEME = 'dark';
    const LIGHT_THEME = 'light';

    /**
     * Initialize theme functionality
     */
    function init() {
        initThemeToggle();
        initBreakingNewsTicker();
        initLazyLoading();
        initSmoothScroll();
        initWhatsAppButton();
        initSocialShare();
        loadUserThemePreference();
    }

    /**
     * Load and apply user's theme preference
     */
    function loadUserThemePreference() {
        const savedTheme = localStorage.getItem(THEME_KEY);
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme || (prefersDark ? DARK_THEME : LIGHT_THEME);
        
        setTheme(theme);
    }

    /**
     * Set the theme
     */
    function setTheme(theme) {
        const html = document.documentElement;
        
        if (theme === DARK_THEME) {
            html.setAttribute('data-theme', DARK_THEME);
            localStorage.setItem(THEME_KEY, DARK_THEME);
        } else {
            html.removeAttribute('data-theme');
            localStorage.setItem(THEME_KEY, LIGHT_THEME);
        }
        
        // Update toggle button text if it exists
        const toggle = document.querySelector('.theme-toggle');
        if (toggle) {
            toggle.innerHTML = theme === DARK_THEME ? '☀️' : '🌙';
            toggle.setAttribute('aria-label', theme === DARK_THEME ? 'Switch to light mode' : 'Switch to dark mode');
        }
    }

    /**
     * Initialize theme toggle button
     */
    function initThemeToggle() {
        const toggle = document.querySelector('.theme-toggle');
        
        if (!toggle) return;
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme') === DARK_THEME ? DARK_THEME : LIGHT_THEME;
            const newTheme = currentTheme === DARK_THEME ? LIGHT_THEME : DARK_THEME;
            
            setTheme(newTheme);
        });
    }

    /**
     * Initialize breaking news ticker animation
     */
    function initBreakingNewsTicker() {
        const ticker = document.querySelector('.ticker-content');
        
        if (!ticker) return;
        
        // Clone ticker items for seamless loop
        const items = ticker.querySelectorAll('.ticker-item');
        items.forEach(item => {
            const clone = item.cloneNode(true);
            ticker.appendChild(clone);
        });
    }

    /**
     * Initialize lazy loading for images
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.src || img.dataset.src;
                        observer.unobserve(img);
                    }
                });
            });
            
            images.forEach(img => imageObserver.observe(img));
        }
    }

    /**
     * Initialize smooth scrolling
     */
    function initSmoothScroll() {
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'A' && e.target.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(e.target.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    }

    /**
     * Initialize floating WhatsApp button
     */
    function initWhatsAppButton() {
        const whatsappBtn = document.querySelector('.whatsapp-float');
        
        if (!whatsappBtn) return;
        
        whatsappBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const phoneNumber = '255717007449';
            const message = encodeURIComponent('Hello, I visited Global News and would like to get in touch!');
            const url = `https://wa.me/${phoneNumber}?text=${message}`;
            window.open(url, '_blank');
        });
    }

    /**
     * Initialize social share buttons
     */
    function initSocialShare() {
        const shareButtons = document.querySelectorAll('[data-share]');
        
        shareButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const network = this.getAttribute('data-share');
                const url = window.location.href;
                const title = document.title;
                
                let shareUrl = '';
                
                switch(network) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
                        break;
                    case 'email':
                        shareUrl = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(url)}`;
                        break;
                }
                
                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            });
        });
    }

    /**
     * Format large numbers (for view counts, likes, etc.)
     */
    function formatNumber(num) {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num;
    }

    /**
     * Search functionality
     */
    function initSearch() {
        const searchForm = document.querySelector('.search-form');
        
        if (!searchForm) return;
        
        searchForm.addEventListener('submit', function(e) {
            const input = this.querySelector('input[type="search"]');
            if (!input.value.trim()) {
                e.preventDefault();
            }
        });
    }

    /**
     * Initialize responsive menu toggle
     */
    function initMenuToggle() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.primary-navigation');
        
        if (!menuToggle || !navMenu) return;
        
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            this.setAttribute('aria-expanded', navMenu.classList.contains('active') ? 'true' : 'false');
        });
        
        // Close menu when a link is clicked
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /**
     * Add animation to elements on scroll
     */
    function initScrollAnimations() {
        if (!('IntersectionObserver' in window)) return;
        
        const animatedElements = document.querySelectorAll('[data-animate]');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        animatedElements.forEach(el => observer.observe(el));
    }

    /**
     * Track page views (optional analytics)
     */
    function trackPageView() {
        if (window.gtag) {
            window.gtag('event', 'page_view', {
                'page_title': document.title,
                'page_location': window.location.href
            });
        }
    }

    /**
     * Generate table of contents for long articles
     */
    function generateTableOfContents() {
        const content = document.querySelector('.post-content');
        if (!content) return;
        
        const headings = content.querySelectorAll('h2, h3');
        if (headings.length < 3) return;
        
        const toc = document.createElement('div');
        toc.className = 'table-of-contents';
        toc.innerHTML = '<h4>Contents</h4><ul></ul>';
        
        const list = toc.querySelector('ul');
        
        headings.forEach((heading, index) => {
            const id = heading.id || `heading-${index}`;
            heading.id = id;
            
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = `#${id}`;
            a.textContent = heading.textContent;
            li.appendChild(a);
            list.appendChild(li);
        });
        
        content.parentNode.insertBefore(toc, content);
    }

    /**
     * Initialize when DOM is ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        init();
        initSearch();
        initMenuToggle();
        initScrollAnimations();
        trackPageView();
        generateTableOfContents();
    });

    /**
     * Expose some functions to global scope for external use
     */
    window.GlobalNews = {
        setTheme: setTheme,
        formatNumber: formatNumber
    };

})();

/**
 * Keyboard shortcuts
 */
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K: Focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('.search-form input[type="search"]');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Esc: Close any open modals/dropdowns
    if (e.key === 'Escape') {
        const activeElement = document.activeElement;
        if (activeElement && activeElement.tagName === 'INPUT') {
            activeElement.blur();
        }
    }
});
