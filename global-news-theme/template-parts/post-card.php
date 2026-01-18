<?php
/**
 * Post Card Template Part
 *
 * @package Global_News
 */

?>
<article class="post-card">
    <!-- Thumbnail -->
    <div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <?php
            if ( has_post_thumbnail() ) {
                echo global_news_get_featured_image( get_the_ID(), 'global-news-card' );
            } else {
                echo '<div style="width: 100%; height: 220px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;"><i class="fas fa-image"></i></div>';
            }
            ?>
        </a>
    </div>
    
    <!-- Content -->
    <div class="post-body">
        <!-- Meta Information -->
        <div class="post-meta">
            <?php
            $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                echo '<span class="post-category">' . esc_html( $categories[0]->name ) . '</span>';
            }
            ?>
            <span><?php echo esc_html( global_news_get_post_date() ); ?></span>
        </div>
        
        <!-- Title -->
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        
        <!-- Excerpt -->
        <p class="post-excerpt">
            <?php echo esc_html( global_news_get_excerpt( 15, get_the_ID() ) ); ?>
        </p>
        
        <!-- Read More Link -->
        <a href="<?php the_permalink(); ?>" class="read-more">
            <?php esc_html_e( 'Read More', 'global-news' ); ?> →
        </a>
    </div>
</article>
