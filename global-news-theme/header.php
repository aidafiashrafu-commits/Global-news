<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <meta name="author" content="Global News">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ); ?>">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <div class="site">
        <!-- Header -->
        <header class="site-header" role="banner">
            <!-- Breaking News Ticker -->
            <?php
            $breaking = global_news_get_breaking_news( 10 );
            if ( $breaking->have_posts() ) {
                echo '<div class="breaking-news-ticker">';
                echo '<span class="breaking-news-label">BREAKING NEWS</span>';
                echo '<div class="ticker-content">';
                while ( $breaking->have_posts() ) {
                    $breaking->the_post();
                    echo '<span class="ticker-item">';
                    echo '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
                    echo '</span>';
                }
                wp_reset_postdata();
                echo '</div>';
                echo '</div>';
            }
            ?>
            
            <!-- Top Header -->
            <div class="container">
                <div class="header-top">
                    <!-- Logo -->
                    <div class="site-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php 
                                if ( is_admin() ) {
                                    echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' );
                                } else {
                                    echo esc_url( get_template_directory_uri() . '/assets/images/logo.svg' );
                                }
                            ?>" alt="<?php esc_attr( bloginfo( 'name' ) ); ?>" style="max-width: 160px; height: auto;">
                        </a>
                    </div>
                    
                    <!-- Right side: Search & Theme toggle -->
                    <div class="header-right">
                        <button class="theme-toggle" aria-label="Toggle dark mode">🌙</button>
                    </div>
                </div>
            </div>
            
            <!-- Primary Navigation -->
            <nav class="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'global-news' ); ?>">
                <div class="container">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'primary-navigation',
                        'container'      => false,
                        'depth'          => 2,
                        'fallback_cb'    => 'wp_page_menu',
                        'link_before'    => '',
                        'link_after'     => '',
                    ) );
                    
                    // Fallback menu with default categories
                    if ( ! has_nav_menu( 'primary' ) ) {
                        echo '<ul class="primary-navigation">';
                        echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
                        
                        $categories = get_categories( array( 'hide_empty' => true, 'number' => 7 ) );
                        foreach ( $categories as $category ) {
                            echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
                        }
                        
                        echo '<li><a href="' . esc_url( get_page_link( get_page_by_path( 'about' ) ) ) . '">About</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </div>
            </nav>
        </header>
        
        <!-- Main Content -->
        <div class="site-content">
