<?php get_header(); ?>

  <h1><?php single_cat_title(); ?></h1>
  <?php
  if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
  }
?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
      <div class="meta">
        <p>Опубликовано: <?php the_time('j M Y'); ?> в <?php the_time('g:i'); ?></p>
        <p>Категории: <?php the_category(','); ?></p>
      </div>
      <?php if ( has_post_thumbnail() ) the_post_thumbnail(); ?>
      <?php the_content(''); ?>
      <?php the_tags('<p>Метки: ', ', ', '</p>'); ?>
    </article>
  <?php endwhile;
  else: echo '<h1>Записей нет. Либо ошибка, либо категория пуста.</h1>'; endif; ?>  
  <?php showpagination(); ?>
<?php get_footer(); ?>