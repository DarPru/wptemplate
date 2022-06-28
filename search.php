<?php get_header(); ?>
<section>
	 <div class="white-space-container">
        <div class="c-container top-text-block">
  <h1><?php echo 'Поиск по запросу: ' . get_search_query(); ?></h1>
  <?php showbreadcrumb(); ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php get_template_part('loop'); ?>
  <?php endwhile;
  else: echo '<h1>К сожалению, по вашему запросу ничего не найдено</h1>'; endif; ?>  
  <?php showpagination(); ?>
</div>
</div>
</section>

<?php get_footer(); ?>