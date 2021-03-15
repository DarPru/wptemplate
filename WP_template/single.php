<?php get_header() ?>
<?php
	if ( function_exists('yoast_breadcrumb') ) {
	  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
?>
		
<?php the_content() ?>
<? 
 $query = new WP_Query( [
	'posts_per_page' => 4,
	'orderby'        => 'post_date'
] );

global $post;

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();?>
		<article>
  <?the_post_thumbnail_url() ?>
  <?php the_permalink() ?>
  <?php the_title() ?>
  <?php the_excerpt() ?>
  <?php the_date() ?>
	</article>
		<?
	}
} else {
	// Постов не найдено
}

wp_reset_postdata();?>			 
<?php get_footer() ?>