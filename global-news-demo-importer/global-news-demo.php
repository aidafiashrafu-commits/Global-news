<?php
/**
 * Plugin Name: Global News Demo Content Importer
 * Plugin URI: https://globalnews.example.com
 * Description: Imports demo content with 50 viral articles for Global News theme
 * Version: 1.0.0
 * Author: Global News Team
 * License: GPL v2 or later
 * Domain Path: /languages
 *
 * @package Global_News_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'GLOBAL_NEWS_DEMO_VERSION', '1.0.0' );
define( 'GLOBAL_NEWS_DEMO_DIR', plugin_dir_path( __FILE__ ) );
define( 'GLOBAL_NEWS_DEMO_URI', plugin_dir_url( __FILE__ ) );

/**
 * Get all 50 demo articles
 */
function global_news_demo_get_articles() {
    return include GLOBAL_NEWS_DEMO_DIR . 'articles-data.php';
}

/**
 * Create demo categories
 */
function global_news_demo_create_categories() {
    $categories = array(
        'World' => 'International news from around the globe',
        'Africa' => 'News and stories from the African continent',
        'Business' => 'Business, economics, and finance news',
        'Technology' => 'Technology, innovation, and digital news',
        'Sports' => 'Sports news and athlete stories',
        'Entertainment' => 'Entertainment, celebrity, and pop culture',
        'Health' => 'Health, wellness, and medical news',
    );
    
    foreach ( $categories as $name => $description ) {
        if ( ! term_exists( $name, 'category' ) ) {
            wp_insert_term( $name, 'category', array( 'description' => $description ) );
        }
    }
}

/**
 * Create demo articles
 */
function global_news_demo_create_articles() {
    global_news_demo_create_categories();
    
    $articles = global_news_demo_get_articles();
    $created_count = 0;
    
    foreach ( $articles as $index => $article ) {
        $category = $article['category'];
        $category_slug = sanitize_title( $category );
        $category_obj = get_category_by_slug( $category_slug );
        
        if ( ! $category_obj ) {
            $category_obj = get_category_by_slug( strtolower( str_replace( ' ', '-', $category ) ) );
        }
        
        $post_args = array(
            'post_title'   => $article['title'],
            'post_content' => $article['content'],
            'post_excerpt' => $article['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'post',
            'post_date'    => date( 'Y-m-d H:i:s', strtotime( '-' . ( 50 - $index ) . ' days' ) ),
            'post_author'  => get_current_user_id() ?: 1,
        );
        
        $post_id = wp_insert_post( $post_args );
        
        if ( $post_id && ! is_wp_error( $post_id ) ) {
            if ( $category_obj ) {
                wp_set_post_categories( $post_id, array( $category_obj->term_id ) );
            }
            
            // Mark first 3 as breaking news
            if ( $index < 3 ) {
                update_post_meta( $post_id, 'is_breaking_news', true );
                update_post_meta( $post_id, 'breaking_news_text', 'BREAKING' );
            }
            
            $created_count++;
        }
    }
    
    return $created_count;
}

/**
 * Admin page for importing demo content
 */
function global_news_demo_add_admin_page() {
    add_submenu_page(
        'themes.php',
        __( 'Import Demo Content', 'global-news-demo' ),
        __( 'Import Demo Content', 'global-news-demo' ),
        'manage_options',
        'global-news-demo',
        'global_news_demo_render_page'
    );
}
add_action( 'admin_menu', 'global_news_demo_add_admin_page' );

/**
 * Render admin page
 */
function global_news_demo_render_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    $imported_posts = get_option( 'global_news_demo_imported', false );
    $imported_count = absint( get_option( 'global_news_demo_count', 0 ) );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Import Demo Content', 'global-news-demo' ); ?></h1>
        
        <div style="background: #fff; padding: 20px; border-radius: 5px; margin-top: 20px;">
            <?php if ( $imported_posts ) : ?>
                <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <p><strong><?php esc_html_e( 'Success!', 'global-news-demo' ); ?></strong></p>
                    <p><?php printf( esc_html__( '%d demo articles have been imported. You can now see them on your site.', 'global-news-demo' ), $imported_count ); ?></p>
                </div>
            <?php else : ?>
                <p><?php esc_html_e( 'This will import 50 viral news articles to populate your Global News site with sample content.', 'global-news-demo' ); ?></p>
                <p><strong><?php esc_html_e( 'What will be imported:', 'global-news-demo' ); ?></strong></p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <li><?php esc_html_e( '50 viral news articles', 'global-news-demo' ); ?></li>
                    <li><?php esc_html_e( '7 default news categories', 'global-news-demo' ); ?></li>
                    <li><?php esc_html_e( 'Proper post metadata', 'global-news-demo' ); ?></li>
                    <li><?php esc_html_e( 'Breaking news markers on featured posts', 'global-news-demo' ); ?></li>
                </ul>
                
                <form method="post" style="margin-top: 30px;">
                    <?php wp_nonce_field( 'global_news_demo_import' ); ?>
                    <input type="hidden" name="global_news_demo_action" value="import">
                    <button type="submit" class="button button-primary button-large" onclick="return confirm('<?php esc_attr_e( 'This will import 50 demo articles. Continue?', 'global-news-demo' ); ?>')">
                        <?php esc_html_e( 'Import Demo Content', 'global-news-demo' ); ?>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Handle demo import
 */
function global_news_demo_handle_import() {
    if ( ! isset( $_POST['global_news_demo_action'] ) || $_POST['global_news_demo_action'] !== 'import' ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'global_news_demo_import' ) ) {
        return;
    }
    
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    $count = global_news_demo_create_articles();
    
    update_option( 'global_news_demo_imported', true );
    update_option( 'global_news_demo_count', $count );
}
add_action( 'admin_init', 'global_news_demo_handle_import' );
