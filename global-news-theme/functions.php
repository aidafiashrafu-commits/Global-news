<?php
/**
 * Global News Theme Functions
 *
 * @package Global_News
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define constants
define( 'GLOBAL_NEWS_VERSION', '1.0.0' );
define( 'GLOBAL_NEWS_DIR', get_template_directory() );
define( 'GLOBAL_NEWS_URI', get_template_directory_uri() );

/**
 * Set up theme support and register features
 */
function global_news_theme_setup() {
    // Add theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    
    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'global-news' ),
        'footer' => esc_html__( 'Footer Menu', 'global-news' ),
    ) );
    
    // Set featured image sizes
    set_post_thumbnail_size( 800, 500, true );
    add_image_size( 'global-news-hero', 1200, 600, true );
    add_image_size( 'global-news-card', 400, 300, true );
    add_image_size( 'global-news-thumbnail', 200, 150, true );
}
add_action( 'after_setup_theme', 'global_news_theme_setup' );

/**
 * Enqueue styles and scripts
 */
function global_news_enqueue_assets() {
    // Main stylesheet
    wp_enqueue_style(
        'global-news-main',
        GLOBAL_NEWS_URI . '/style.css',
        array(),
        GLOBAL_NEWS_VERSION
    );
    
    // Google Fonts
    wp_enqueue_style(
        'global-news-fonts',
        'https://fonts.googleapis.com/css2?family=Georgia:wght@400;700&family=Roboto:wght@400;500;700;900&display=swap',
        array(),
        GLOBAL_NEWS_VERSION
    );
    
    // Font Awesome Icons
    wp_enqueue_style(
        'global-news-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
        array(),
        '6.4.0'
    );
    
    // Main script
    wp_enqueue_script(
        'global-news-main',
        GLOBAL_NEWS_URI . '/assets/js/main.js',
        array( 'wp-dom-ready' ),
        GLOBAL_NEWS_VERSION,
        true
    );
    
    // Localize script
    wp_localize_script( 'global-news-main', 'globalNewsData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'global_news_nonce' ),
    ) );
    
    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'global_news_enqueue_assets' );

/**
 * Register widget areas
 */
function global_news_register_widgets() {
    register_sidebar( array(
        'name'          => esc_html__( 'Primary Sidebar', 'global-news' ),
        'id'            => 'primary-sidebar',
        'description'   => esc_html__( 'Main sidebar', 'global-news' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 1', 'global-news' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Footer widget area 1', 'global-news' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 2', 'global-news' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Footer widget area 2', 'global-news' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widget Area 3', 'global-news' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Footer widget area 3', 'global-news' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'global_news_register_widgets' );

/**
 * Register post categories if not using standard categories
 */
function global_news_register_taxonomies() {
    // News categories are handled by WordPress default categories
    // But we can add custom meta for breaking news
}
add_action( 'init', 'global_news_register_taxonomies' );

/**
 * Add custom post meta for breaking news
 */
function global_news_add_breaking_news_meta() {
    register_post_meta( 'post', 'is_breaking_news', array(
        'type'          => 'boolean',
        'single'        => true,
        'show_in_rest'  => true,
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
    ) );
    
    register_post_meta( 'post', 'breaking_news_text', array(
        'type'          => 'string',
        'single'        => true,
        'show_in_rest'  => true,
        'auth_callback' => function() {
            return current_user_can( 'edit_posts' );
        },
    ) );
}
add_action( 'init', 'global_news_add_breaking_news_meta' );

/**
 * Get the post's featured image with lazy loading
 *
 * @param int $post_id Post ID.
 * @param string $size Image size.
 * @return string HTML.
 */
function global_news_get_featured_image( $post_id = 0, $size = 'post-thumbnail' ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    if ( has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail( $post_id, $size, array(
            'loading' => 'lazy',
            'alt'     => get_the_title( $post_id ),
        ) );
    }
    
    return '';
}

/**
 * Get breaking news posts
 *
 * @param int $limit Number of posts to retrieve.
 * @return WP_Query Breaking news query.
 */
function global_news_get_breaking_news( $limit = 5 ) {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'     => 'is_breaking_news',
                'value'   => true,
                'compare' => '=',
            ),
        ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    return new WP_Query( $args );
}

/**
 * Get featured posts by category
 *
 * @param string $category Category slug.
 * @param int $limit Number of posts.
 * @return WP_Query Posts query.
 */
function global_news_get_posts_by_category( $category = '', $limit = 3 ) {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    if ( $category ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        );
    }
    
    return new WP_Query( $args );
}

/**
 * Get post author name
 *
 * @param int $post_id Post ID.
 * @return string Author name.
 */
function global_news_get_author_name( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $author_id = get_post_field( 'post_author', $post_id );
    return get_the_author_meta( 'display_name', $author_id );
}

/**
 * Get post date formatted
 *
 * @param int $post_id Post ID.
 * @return string Formatted date.
 */
function global_news_get_post_date( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    return get_the_date( 'F j, Y', $post_id );
}

/**
 * Get post excerpt with specified length
 *
 * @param int $length Excerpt length in words.
 * @param int $post_id Post ID.
 * @return string Excerpt.
 */
function global_news_get_excerpt( $length = 20, $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $post = get_post( $post_id );
    $excerpt = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
    $excerpt = wp_strip_all_tags( $excerpt );
    $excerpt = wp_trim_words( $excerpt, $length );
    
    return $excerpt;
}

/**
 * Add schema.org NewsArticle structured data
 */
function global_news_add_schema_markup() {
    if ( is_single() ) {
        $post = get_post();
        $author = get_the_author_meta( 'display_name', $post->post_author );
        
        $schema = array(
            '@context'       => 'https://schema.org',
            '@type'          => 'NewsArticle',
            'headline'       => get_the_title(),
            'description'    => wp_trim_words( $post->post_content, 20 ),
            'image'          => has_post_thumbnail() ? get_the_post_thumbnail_url() : '',
            'datePublished'  => get_the_date( 'c' ),
            'dateModified'   => get_the_modified_date( 'c' ),
            'author'         => array(
                '@type' => 'Person',
                'name'  => $author,
            ),
            'publisher'      => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo( 'name' ),
                'logo'  => array(
                    '@type' => 'ImageObject',
                    'url'   => GLOBAL_NEWS_URI . '/assets/images/logo.svg',
                ),
            ),
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
    }
}
add_action( 'wp_head', 'global_news_add_schema_markup' );

/**
 * Add Open Graph meta tags
 */
function global_news_add_og_tags() {
    if ( is_single() ) {
        $post = get_post();
        $image = has_post_thumbnail() ? get_the_post_thumbnail_url() : GLOBAL_NEWS_URI . '/assets/images/logo.svg';
        
        echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( wp_trim_words( $post->post_content, 20 ) ) . '">' . "\n";
        echo '<meta property="og:image" content="' . esc_attr( $image ) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_attr( get_permalink() ) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr( get_the_title() ) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr( wp_trim_words( $post->post_content, 20 ) ) . '">' . "\n";
        echo '<meta name="twitter:image" content="' . esc_attr( $image ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'global_news_add_og_tags' );

/**
 * Modify the excerpt length
 *
 * @param int $length Current length.
 * @return int Modified length.
 */
function global_news_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'global_news_excerpt_length' );

/**
 * Modify the excerpt more text
 *
 * @param string $more Current more text.
 * @return string Modified more text.
 */
function global_news_excerpt_more( $more ) {
    return ' ...';
}
add_filter( 'excerpt_more', 'global_news_excerpt_more' );

/**
 * Add custom class to body tag
 *
 * @param array $classes Existing classes.
 * @return array Modified classes.
 */
function global_news_body_classes( $classes ) {
    if ( is_singular( 'post' ) ) {
        $classes[] = 'single-post-view';
    }
    
    if ( is_archive() ) {
        $classes[] = 'archive-view';
    }
    
    return $classes;
}
add_filter( 'body_class', 'global_news_body_classes' );

/**
 * Disable comments on old posts (customizable)
 */
function global_news_close_old_comments( $open, $post_id ) {
    $post = get_post( $post_id );
    $days = 30; // Close comments after 30 days
    
    if ( strtotime( $post->post_date_gmt ) < strtotime( '-' . $days . ' days' ) ) {
        return false;
    }
    
    return $open;
}
add_filter( 'comments_open', 'global_news_close_old_comments', 10, 2 );

/**
 * Add favicon and Apple touch icon to head
 */
function global_news_add_favicons() {
    echo '<link rel="icon" type="image/svg+xml" href="' . esc_url( GLOBAL_NEWS_URI . '/assets/images/favicon.svg' ) . '">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url( GLOBAL_NEWS_URI . '/assets/images/favicon.svg' ) . '">' . "\n";
}
add_action( 'wp_head', 'global_news_add_favicons' );

/**
 * Add custom admin styles
 */
function global_news_admin_styles() {
    wp_enqueue_style(
        'global-news-admin',
        GLOBAL_NEWS_URI . '/assets/css/admin.css',
        array(),
        GLOBAL_NEWS_VERSION
    );
}
add_action( 'admin_enqueue_scripts', 'global_news_admin_styles' );

/**
 * Register REST API extensions
 */
function global_news_register_rest_fields() {
    register_rest_field( 'post', 'featured_image_url', array(
        'get_callback' => function( $post ) {
            return has_post_thumbnail( $post['id'] ) ? get_the_post_thumbnail_url( $post['id'] ) : null;
        },
    ) );
    
    register_rest_field( 'post', 'author_name', array(
        'get_callback' => function( $post ) {
            return global_news_get_author_name( $post['id'] );
        },
    ) );
}
add_action( 'rest_api_init', 'global_news_register_rest_fields' );

/**
 * Customize login page
 */
function global_news_custom_login_logo() {
    echo '<style type="text/css">
        .login h1 a {
            background-image: url(' . esc_url( GLOBAL_NEWS_URI . '/assets/images/logo.svg' ) . ') !important;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        #login {
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        }
        .login form {
            background: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>';
}
add_action( 'login_enqueue_scripts', 'global_news_custom_login_logo' );

/**
 * Ensure featured image is set for all posts
 */
function global_news_ensure_featured_image() {
    if ( is_admin() ) {
        return;
    }
    
    if ( ! has_post_thumbnail() && is_singular( 'post' ) ) {
        // Use a placeholder image
    }
}
add_action( 'template_include', 'global_news_ensure_featured_image' );
