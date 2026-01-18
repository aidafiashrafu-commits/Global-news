        </div><!-- .site-content -->
        
        <!-- Floating WhatsApp Button -->
        <a href="https://wa.me/255717007449?text=Hello%20Global%20News" class="whatsapp-float" title="<?php esc_attr_e( 'Chat with us on WhatsApp', 'global-news' ); ?>">
            <i class="fab fa-whatsapp"></i>
        </a>
        
        <!-- Footer -->
        <footer class="site-footer" role="contentinfo">
            <div class="container">
                <div class="footer-content">
                    <!-- Footer Section 1: About -->
                    <div class="footer-section">
                        <h3><?php esc_html_e( 'About Global News', 'global-news' ); ?></h3>
                        <p><?php echo wp_kses_post( get_bloginfo( 'description' ) ); ?></p>
                        <p><?php esc_html_e( 'Trusted News From Around the World - Your source for breaking news, in-depth analysis, and stories that matter.', 'global-news' ); ?></p>
                    </div>
                    
                    <!-- Footer Section 2: Categories -->
                    <div class="footer-section">
                        <h3><?php esc_html_e( 'Categories', 'global-news' ); ?></h3>
                        <ul class="footer-links">
                            <?php
                            $categories = get_categories( array( 'hide_empty' => true, 'number' => 7 ) );
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
                    
                    <!-- Footer Section 3: Follow Us -->
                    <div class="footer-section">
                        <h3><?php esc_html_e( 'Follow Us', 'global-news' ); ?></h3>
                        <ul class="social-links">
                            <li><a href="https://www.facebook.com/share/1DAqbgWgGS/" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'Facebook', 'global-news' ); ?>"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://www.tiktok.com/@music.lovers395?_r=1&_t=ZM-93BYcRAiqOB" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'TikTok', 'global-news' ); ?>"><i class="fab fa-tiktok"></i></a></li>
                            <li><a href="https://wa.me/255717007449" target="_blank" rel="noopener noreferrer" title="<?php esc_attr_e( 'WhatsApp', 'global-news' ); ?>"><i class="fab fa-whatsapp"></i></a></li>
                            <li><a href="mailto:lingendea@gmail.com" title="<?php esc_attr_e( 'Email', 'global-news' ); ?>"><i class="fas fa-envelope"></i></a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Footer Bottom -->
                <div class="footer-bottom">
                    <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <strong><?php esc_html_e( 'Global News', 'global-news' ); ?></strong> | 
                    <?php esc_html_e( 'Trusted News From Around the World', 'global-news' ); ?> | 
                    <a href="<?php echo esc_url( get_page_link( get_page_by_path( 'about' ) ) ); ?>">About</a> | 
                    <a href="<?php echo esc_url( get_page_link( get_page_by_path( 'contact' ) ) ); ?>">Contact</a> | 
                    <a href="<?php echo esc_url( get_page_link( get_page_by_path( 'privacy' ) ) ); ?>">Privacy Policy</a>
                    </p>
                    <p><?php printf( esc_html__( 'Powered by %s', 'global-news' ), '<a href="https://wordpress.org/" target="_blank" rel="noopener noreferrer">WordPress</a>' ); ?></p>
                </div>
            </div>
        </footer>
    </div><!-- .site -->
    
    <?php wp_footer(); ?>
</body>
</html>
