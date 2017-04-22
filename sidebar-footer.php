<?php
    if (   ! is_active_sidebar( 'footer-widget-1'  )
        && ! is_active_sidebar( 'footer-widget-2'  )
        && ! is_active_sidebar( 'footer-widget-3'  )
        && ! is_active_sidebar( 'footer-widget-4'  )
    )
        return;
?>
<div id="footer-w-area" class="footer-w-area">
    <div class="<?php twentytwelve_footer_widget_class(); ?>">
        <?php if ( is_active_sidebar( 'footer-widget-1' ) ) : ?>
        <div id="first" class="widget-area-footer widget-area" role="complementary">
            <?php dynamic_sidebar( 'footer-widget-1' ); ?>
        </div><!-- #footer-widget-1 .widget-area -->
        <?php endif; ?>
      
        <?php if ( is_active_sidebar( 'footer-widget-2' ) ) : ?>
        <div id="second" class="widget-area-footer widget-area" role="complementary">
            <?php dynamic_sidebar( 'footer-widget-2' ); ?>
        </div><!-- #footer-widget-2 .widget-area -->
        <?php endif; ?>
      
        <?php if ( is_active_sidebar( 'footer-widget-3' ) ) : ?>
        <div id="third" class="widget-area-footer widget-area" role="complementary">
            <?php dynamic_sidebar( 'footer-widget-3' ); ?>
        </div><!-- #footer-widget-3 .widget-area -->
        <?php endif; ?>
  
        <?php if ( is_active_sidebar( 'footer-widget-4' ) ) : ?>
        <div id="forth" class="widget-area-footer widget-area" role="complementary">
            <?php dynamic_sidebar( 'footer-widget-4' ); ?>
        </div><!-- #footer-widget-4 .widget-area -->
        <?php endif; ?>
    </div>
</div><!-- #footer-w-area -->
