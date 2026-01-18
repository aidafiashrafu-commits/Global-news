<?php
/**
 * Index Template - Main template for displaying posts
 *
 * @package Global_News
 */

get_header();
?>

<main class="container" role="main">
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; margin-bottom: 3rem;">
        <!-- Main Content -->
        <div>
            <?php if ( have_posts() ) : ?>
                <!-- Hero Section for Latest Post -->
                <?php
                $args = array(
                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );
                $hero_query = new WP_Query( $args );
                
                if ( $hero_query->have_posts() ) {
                    $hero_query->the_post();
                    ?>
                    <section class="hero-section">
                        <?php echo global_news_get_featured_image( get_the_ID(), 'global-news-hero' ); ?>
                        <div class="hero-overlay"></div>
                        <div class="hero-content">
                            <span class="hero-category">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) {
                                    echo esc_html( $categories[0]->name );
                                } else {
                                    echo esc_html_e( 'Featured', 'global-news' );
                                }
                                ?>
                            </span>
                            <h1 class="hero-title">
                                <a href="<?php the_permalink(); ?>" style="color: white; text-decoration: none;">
                                    <?php the_title(); ?>
                                </a>
                            </h1>
                            <p class="hero-excerpt"><?php echo esc_html( global_news_get_excerpt( 25, get_the_ID() ) ); ?></p>
                            <div class="hero-meta">
                                <span><?php echo esc_html( global_news_get_author_name() ); ?></span>
                                <span><?php echo esc_html( global_news_get_post_date() ); ?></span>
                            </div>
                        </div>
                    </section>
                    <?php
                    wp_reset_postdata();
                }
                ?>
                
                <!-- Featured Posts Section -->
                <section class="featured-section">
                    <h2 class="section-title"><?php esc_html_e( 'Latest News', 'global-news' ); ?></h2>
                    
                    <div class="posts-grid">
                        <?php
                        $posts_query = new WP_Query( array(
                            'posts_per_page' => 9,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                            'offset'         => 1, // Skip the hero post
                        ) );
                        
                        while ( $posts_query->have_posts() ) {
                            $posts_query->the_post();
                            get_template_part( 'template-parts/post-card' );
                        }
                        ?>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="pagination">
                        <?php
                        echo paginate_links( array(
                            'type'      => 'list',
                            'prev_text' => esc_html__( '← Previous', 'global-news' ),
                            'next_text' => esc_html__( 'Next →', 'global-news' ),
                        ) );
                        ?>
                    </div>
                    
                    <?php wp_reset_postdata(); ?>
                </section>
                
                <!-- Category Sections -->
                <?php
                $top_categories = array( 'world', 'africa', 'business', 'technology' );
                
                foreach ( $top_categories as $cat_slug ) {
                    $category = get_category_by_slug( $cat_slug );
                    if ( ! $category ) continue;
                    
                    $cat_posts = global_news_get_posts_by_category( $cat_slug, 3 );
                    if ( $cat_posts->have_posts() ) {
                        ?>
                        <section class="featured-section" style="margin-top: 3rem;">
                            <h2 class="section-title"><?php echo esc_html( $category->name ); ?></h2>
                            
                            <div class="posts-grid">
                                <?php
                                while ( $cat_posts->have_posts() ) {
                                    $cat_posts->the_post();
                                    get_template_part( 'template-parts/post-card' );
                                }
                                ?>
                            </div>
                        </section>
                        <?php
                        wp_reset_postdata();
                    }
                }
                ?>
            <?php else : ?>
                <div style="text-align: center; padding: 3rem 0;">
                    <h1><?php esc_html_e( 'No posts found', 'global-news' ); ?></h1>
                    <p><?php esc_html_e( 'Sorry, we couldn\'t find any posts. Please try again later.', 'global-news' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Search Widget -->
            <div class="widget">
                <h3 class="widget-title"><?php esc_html_e( 'Search', 'global-news' ); ?></h3>
                <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form" role="search">
                    <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search...', 'global-news' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" aria-label="<?php esc_attr_e( 'Search for:', 'global-news' ); ?>">
                    <button type="submit" aria-label="<?php esc_attr_e( 'Search', 'global-news' ); ?>">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Recent Posts -->
            <div class="widget">
                <h3 class="widget-title"><?php esc_html_e( 'Recent Posts', 'global-news' ); ?></h3>
                <ul class="widget-list">
                    <?php
                    $recent_posts = new WP_Query( array(
                        'posts_per_page' => 5,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ) );
                    
                    while ( $recent_posts->have_posts() ) {
                        $recent_posts->the_post();
                        ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <strong><?php the_title(); ?></strong><br>
                                <small><?php echo esc_html( global_news_get_post_date() ); ?></small>
                            </a>
                        </li>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            
            <!-- Top Categories -->
            <div class="widget">
                <h3 class="widget-title"><?php esc_html_e( 'Categories', 'global-news' ); ?></h3>
                <ul class="widget-list">
                    <?php
                    $categories = get_categories( array( 'hide_empty' => true, 'number' => 8 ) );
                    foreach ( $categories as $category ) {
                        echo '<li>';
                        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">';
                        echo esc_html( $category->name );
                        echo ' (' . intval( $category->count ) . ')';
                        echo '</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
            
            <!-- Newsletter Signup -->
            <div class="widget">
                <h3 class="widget-title"><?php esc_html_e( 'Newsletter', 'global-news' ); ?></h3>
                <p><?php esc_html_e( 'Subscribe to get the latest news delivered to your inbox.', 'global-news' ); ?></p>
                <form method="post" action="#" class="newsletter-form">
                    <input type="email" placeholder="<?php esc_attr_e( 'Your email', 'global-news' ); ?>" required style="width: 100%; padding: 0.75rem; margin-bottom: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                    <button type="submit" class="btn" style="width: 100;">
                        <?php esc_html_e( 'Subscribe', 'global-news' ); ?>
                    </button>
                </form>
            </div>
        </aside>
    </div>
</main>

<?php
get_footer();
