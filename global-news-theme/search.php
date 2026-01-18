<?php
/**
 * Search Results Template
 *
 * @package Global_News
 */

get_header();
?>

<main class="container" role="main">
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; margin-bottom: 3rem;">
        <!-- Main Content -->
        <div>
            <!-- Search Header -->
            <header style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 3px solid #C40000;">
                <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">
                    <?php printf( esc_html__( 'Search Results for: %s', 'global-news' ), '<strong>' . esc_html( get_search_query() ) . '</strong>' ); ?>
                </h1>
                <p><?php printf( esc_html__( 'Showing %s result(s)', 'global-news' ), intval( $GLOBALS['wp_query']->found_posts ) ); ?></p>
            </header>
            
            <?php
            if ( have_posts() ) {
                ?>
                <!-- Search Results Grid -->
                <div class="posts-grid">
                    <?php
                    while ( have_posts() ) {
                        the_post();
                        
                        if ( get_post_type() === 'post' ) {
                            get_template_part( 'template-parts/post-card' );
                        } else {
                            // For pages and other post types
                            ?>
                            <article class="post-card">
                                <div class="post-body">
                                    <h2 class="post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <p class="post-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'View Page', 'global-news' ); ?> →</a>
                                </div>
                            </article>
                            <?php
                        }
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
                <?php
            } else {
                ?>
                <div style="text-align: center; padding: 3rem 0;">
                    <h2><?php esc_html_e( 'No results found', 'global-news' ); ?></h2>
                    <p><?php esc_html_e( 'Sorry, no posts matched your search. Please try different keywords or browse our categories.', 'global-news' ); ?></p>
                    <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form" role="search" style="margin-top: 1rem;">
                        <input type="search" name="s" placeholder="<?php esc_attr_e( 'Search again...', 'global-news' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" aria-label="<?php esc_attr_e( 'Search for:', 'global-news' ); ?>">
                        <button type="submit" aria-label="<?php esc_attr_e( 'Search', 'global-news' ); ?>">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <?php
            }
            ?>
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
        </aside>
    </div>
</main>

<?php
get_footer();
