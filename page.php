<?php get_header() ?>
<?php
if ( function_exists( 'yoast_breadcrumb' ) ) :
   yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' );
endif;
?>
<?php get_sidebar() ?>
<?php the_content() ?>
<?php get_footer() ?>