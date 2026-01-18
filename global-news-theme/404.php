<?php
/**
 * 404 Not Found Template
 *
 * @package Global_News
 */

get_header();
?>

<main class="container" role="main">
    <div style="text-align: center; padding: 6rem 2rem;">
        <!-- 404 Icon -->
        <div style="font-size: 120px; margin-bottom: 1rem; opacity: 0.3;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <!-- Heading -->
        <h1 style="font-size: 4rem; font-weight: bold; margin-bottom: 1rem; color: #C40000;">404</h1>
        
        <!-- Message -->
        <h2 style="font-size: 2rem; margin-bottom: 1rem;"><?php esc_html_e( 'Page Not Found', 'global-news' ); ?></h2>
        
        <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.8;">
            <?php esc_html_e( 'Sorry, the page you are looking for does not exist. It might have been moved or deleted.', 'global-news' ); ?>
        </p>
        
        <!-- Search Form -->
        <div style="margin: 2rem 0;">
            <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form" role="search" style="max-width: 500px; margin: 0 auto;">
                <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search for articles...', 'global-news' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" aria-label="<?php esc_attr_e( 'Search for:', 'global-news' ); ?>" style="flex: 1;">
                <button type="submit" aria-label="<?php esc_attr_e( 'Search', 'global-news' ); ?>">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn">
                <?php esc_html_e( '← Back to Home', 'global-news' ); ?>
            </a>
        </div>
        
        <!-- Suggested Categories -->
        <div style="margin-top: 3rem; padding: 2rem; background: #f5f5f5; border-radius: 4px;">
            <h3><?php esc_html_e( 'Browse by Category', 'global-news' ); ?></h3>
            <ul style="list-style: none; display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center; margin-top: 1rem;">
                <?php
                $categories = get_categories( array( 'hide_empty' => true, 'number' => 6 ) );
                foreach ( $categories as $category ) {
                    echo '<li>';
                    echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="btn btn-secondary">';
                    echo esc_html( $category->name );
                    echo '</a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</main>

<?php
get_footer();
