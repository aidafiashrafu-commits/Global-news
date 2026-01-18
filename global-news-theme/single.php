<?php
/**
 * Single Post Template
 *
 * @package Global_News
 */

get_header();
?>

<main class="container" role="main">
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
        <!-- Main Content -->
        <article class="single-post">
            <?php
            while ( have_posts() ) {
                the_post();
                
                // Breadcrumb
                ?>
                <nav class="breadcrumb" style="margin-bottom: 1rem; font-size: 14px;">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'global-news' ); ?></a>
                    <?php
                    $categories = get_the_category();
                    if ( ! empty( $categories ) ) {
                        echo ' / <a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                    }
                    ?>
                    / <?php the_title(); ?>
                </nav>
                
                <!-- Post Header -->
                <header class="post-header">
                    <!-- Meta -->
                    <div class="post-header-meta">
                        <span><strong><?php echo esc_html( global_news_get_author_name() ); ?></strong></span>
                        <span><?php echo esc_html( global_news_get_post_date() ); ?></span>
                        <span><?php echo esc_html( reading_time_estimate( get_the_content() ) ); ?> <?php esc_html_e( 'min read', 'global-news' ); ?></span>
                    </div>
                    
                    <!-- Category Badge -->
                    <div style="margin-bottom: 1rem;">
                        <?php
                        $categories = get_the_category();
                        if ( ! empty( $categories ) ) {
                            echo '<span class="post-category" style="display: inline-block;">' . esc_html( $categories[0]->name ) . '</span>';
                        }
                        
                        // Breaking News Badge
                        if ( get_post_meta( get_the_ID(), 'is_breaking_news', true ) ) {
                            echo ' <span class="post-category" style="display: inline-block; background: #ff4444;"> BREAKING NEWS</span>';
                        }
                        ?>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="post-header-title"><?php the_title(); ?></h1>
                </header>
                
                <!-- Featured Image -->
                <?php
                if ( has_post_thumbnail() ) {
                    echo '<figure>';
                    echo get_the_post_thumbnail( get_the_ID(), 'global-news-hero', array( 'class' => 'post-featured-image', 'loading' => 'lazy' ) );
                    echo '<figcaption style="text-align: center; font-size: 13px; color: #666; margin-top: 0.5rem;">';
                    echo esc_html( get_the_post_thumbnail_caption() );
                    echo '</figcaption>';
                    echo '</figure>';
                }
                ?>
                
                <!-- Main Content -->
                <div class="post-content">
                    <?php
                    the_content();
                    
                    wp_link_pages( array(
                        'before' => '<div style="margin: 2rem 0;"><span style="font-weight: bold;">' . esc_html__( 'Pages:', 'global-news' ) . '</span> ',
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>
                
                <!-- Post Footer -->
                <footer class="post-footer">
                    <!-- Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ( $tags ) {
                        echo '<div class="post-tags">';
                        foreach ( $tags as $tag ) {
                            echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="post-tag">#' . esc_html( $tag->name ) . '</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                    
                    <!-- Share Buttons -->
                    <div style="margin: 2rem 0; padding: 1rem; background: #f5f5f5; border-radius: 4px;">
                        <strong><?php esc_html_e( 'Share this post:', 'global-news' ); ?></strong><br>
                        <a href="#" data-share="facebook" class="btn btn-secondary" style="margin-right: 0.5rem; margin-top: 0.5rem; display: inline-block;">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="#" data-share="twitter" class="btn btn-secondary" style="margin-right: 0.5rem; margin-top: 0.5rem; display: inline-block;">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <a href="#" data-share="whatsapp" class="btn btn-secondary" style="margin-right: 0.5rem; margin-top: 0.5rem; display: inline-block;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" data-share="email" class="btn btn-secondary" style="margin-top: 0.5rem; display: inline-block;">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    </div>
                    
                    <!-- Author Box -->
                    <div class="author-box">
                        <div class="author-info">
                            <?php
                            $author_id = get_the_author_meta( 'ID' );
                            $author_avatar = get_avatar( $author_id, 80, '', '', array( 'class' => 'author-avatar' ) );
                            echo $author_avatar;
                            ?>
                            <div class="author-details">
                                <h4><?php echo esc_html( global_news_get_author_name() ); ?></h4>
                                <p class="author-bio">
                                    <?php
                                    $author_bio = get_the_author_meta( 'description', $author_id );
                                    echo $author_bio ?: esc_html__( 'A passionate writer and journalist bringing you the latest news.', 'global-news' );
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
                
                <!-- Related Posts -->
                <?php
                $related = get_posts( array(
                    'category__in'  => wp_get_post_categories( get_the_ID() ),
                    'numberposts'   => 3,
                    'post__not_in'  => array( get_the_ID() ),
                ) );
                
                if ( ! empty( $related ) ) {
                    ?>
                    <section class="related-posts">
                        <h2 class="related-posts-title"><?php esc_html_e( 'Related Articles', 'global-news' ); ?></h2>
                        <div class="related-posts-grid">
                            <?php
                            foreach ( $related as $post ) {
                                setup_postdata( $post );
                                get_template_part( 'template-parts/post-card' );
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </section>
                    <?php
                }
                ?>
                
                <!-- Comments -->
                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
                <?php
            }
            ?>
        </article>
        
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
                    $recent = new WP_Query( array(
                        'posts_per_page' => 5,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ) );
                    
                    while ( $recent->have_posts() ) {
                        $recent->the_post();
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
            
            <!-- Categories -->
            <div class="widget">
                <h3 class="widget-title"><?php esc_html_e( 'Categories', 'global-news' ); ?></h3>
                <ul class="widget-list">
                    <?php
                    $categories = get_categories( array( 'hide_empty' => true ) );
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
        </aside>
    </div>
</main>

<?php
get_footer();

/**
 * Calculate reading time estimate
 */
function reading_time_estimate( $text ) {
    $word_count = str_word_count( strip_tags( $text ) );
    $reading_time = ceil( $word_count / 200 );
    return max( 1, $reading_time );
}
