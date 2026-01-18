<?php
/**
 * Page Template
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
                
                // Featured Image
                if ( has_post_thumbnail() ) {
                    echo '<figure>';
                    echo get_the_post_thumbnail( get_the_ID(), 'global-news-hero', array( 'class' => 'post-featured-image', 'loading' => 'lazy' ) );
                    echo '</figure>';
                }
                
                // Title
                echo '<h1 class="post-header-title">' . get_the_title() . '</h1>';
                
                // Content
                echo '<div class="post-content">';
                the_content();
                wp_link_pages( array(
                    'before' => '<div style="margin: 2rem 0;"><span style="font-weight: bold;">' . esc_html__( 'Pages:', 'global-news' ) . '</span> ',
                    'after'  => '</div>',
                ) );
                echo '</div>';
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
