<?php
/**
 * Archive Template - Display posts by category, date, etc.
 *
 * @package Global_News
 */

get_header();
?>

<main class="container" role="main">
    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; margin-bottom: 3rem;">
        <!-- Main Content -->
        <div>
            <!-- Archive Header -->
            <header style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 3px solid #C40000;">
                <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">
                    <?php
                    if ( is_category() ) {
                        single_cat_title();
                    } elseif ( is_tag() ) {
                        single_tag_title();
                    } elseif ( is_author() ) {
                        echo 'Articles by ' . esc_html( get_the_author() );
                    } elseif ( is_date() ) {
                        echo 'Archives for ';
                        if ( is_day() ) {
                            echo get_the_date();
                        } elseif ( is_month() ) {
                            echo get_the_date( 'F Y' );
                        } else {
                            echo get_the_date( 'Y' );
                        }
                    } else {
                        echo 'Articles';
                    }
                    ?>
                </h1>
                <?php
                if ( is_category() || is_tag() ) {
                    $description = term_description();
                    if ( $description ) {
                        echo '<p style="font-size: 1.1rem; opacity: 0.8;">' . wp_kses_post( $description ) . '</p>';
                    }
                }
                ?>
            </header>
            
            <?php
            if ( have_posts() ) {
                ?>
                <!-- Posts Grid -->
                <div class="posts-grid">
                    <?php
                    while ( have_posts() ) {
                        the_post();
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
                <?php
            } else {
                ?>
                <div style="text-align: center; padding: 3rem 0;">
                    <h2><?php esc_html_e( 'No posts found', 'global-news' ); ?></h2>
                    <p><?php esc_html_e( 'Sorry, no posts match this criteria. Try a different search or browse our categories.', 'global-news' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn"><?php esc_html_e( 'Back to Home', 'global-news' ); ?></a>
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
            
            <!-- Categories Widget -->
            <div class="widget">
                <h3 class="widget-title"><?php esc_html_e( 'Categories', 'global-news' ); ?></h3>
                <ul class="widget-list">
                    <?php
                    $categories = get_categories( array( 'hide_empty' => true ) );
                    foreach ( $categories as $category ) {
                        $active = is_category( $category->term_id ) ? ' style="font-weight: bold; color: #C40000;"' : '';
                        echo '<li>';
                        echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"' . $active . '>';
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
