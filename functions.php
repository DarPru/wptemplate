<?php

// ===================ОБЯЗАТЕЛЬНЫЙ БЛОК=================================

// поддрежка темой функций вордпресс

add_theme_support('title-tag'); // разрешает переписывать загаловки меты (например, плагинами)
add_theme_support('post-thumbnails'); // возможность добавлять изображение - миниатюру
add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',]); // добавляет поддерку некоторых новых фич для темы - подробнее: wp-kama.ru/function/add_theme_support


// подключение/отключение скриптов и стилей
function my_scripts() // придумываем название сами (лучще начать с названия темы, чтобы случайно не переопределить уже существующий функционал)
{
  // отключаем лишнее
    // отключает скрипты и стили гутенберга
  wp_dequeue_style('global-styles');
  wp_dequeue_style('wp-block-library'); 
    // отключает jquery
  wp_dequeue_script('jquery');
  wp_deregister_script('jquery');

  // подключаем css
  wp_enqueue_style('main-style',  get_template_directory_uri() . '/assets/css/main.min.css', [], true, 'all');
  /*
    - 'main-style' - имя стиля, любое уникальное название,Ю в нижнем регистре через тире
    - get_template_directory_uri - прописывет путь до папки темы, далее указывается пenm до css файла 
    - [] - массив других стилей, которыен должны быть подключены ДО текущего стиля, в массив передаем имя стиля (первый параметр)
    - true - будет ли указываться версия файла стилей, можно задать null если не надо (версия стиля это так: style.css?ver=3.5.1, число меняется автоматически если вносятся правки в css)
    - 'all' -  значение атрибута media? для каких расширений предназначен данный стиль

    ПОДРОБНЕЕ: wp-kama.ru/function/wp_enqueue_style
  */
  
    //подключаем скрипт
  wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.min.js', [], false, true);
   /*
    - 'main-js' - имя скрипта, любое уникальное название,Ю в нижнем регистре через тире
    - get_template_directory_uri - прописывет путь до папки темы, далее указывается пenm до css файла 
    - [] - массив других скриптов, которые должны быть подключены ДО текущего скрипта, в массив передаем имя скрипта (первый параметр)
    - true - будет ли указываться версия файла скритов, можно задать null если не надо
    - true - подкличается ли скрипт в футтере, если false, то скрипт подключится в хедере

    ПОДРОБНЕЕ: wp-kama.ru/function/wp_enqueue_script
  */

  // скрипты и стили можно подключать на конкретной странице, например только на главной
  if (is_front_page()) {
    wp_enqueue_style('slider', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css', [], null);
  }
  // ЕЩЕ ТИПЫ УСЛОВИЙ: wp-kama.ru/function-tag/conditionals
}
add_action('wp_enqueue_scripts', 'my_scripts'); // второй параметр - название нашей функции

// отключение всего барахла, что тянет за собой хук wp_head

function plug_disable_emoji()
{
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_filter('the_content_feed', 'wp_staticize_emoji');
  remove_filter('comment_text_rss', 'wp_staticize_emoji');
  remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'plug_disable_emoji', 1);

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

// отключение всего барахла, что тянет за собой хук wp_head */


// менюшки 

register_nav_menus([
  'header' => 'Меню в шапке', // первый парамерт id по которому мы вызываем меню в верстке, второй - его название в админке 
  'footer' => 'Меню в подвале'
]);

// глобальные настройки темы через ACF

if (function_exists('acf_add_options_page')) {

  acf_add_options_page([
    'page_title'  => 'Название вкладки для глобальных настроек',
    'menu_title'  => 'Заголовок в самой вкладке',
  ]);
}
  /* позволяют создавать пользовательскую вкладку с любыми полями, например пожно настроить текст копирайта в футтере и он будет выводится глобально во всей теме */

// Pagination
function showpagination() {
  global $wp_query;
  $big = 999999999;
  echo paginate_links(array(
    'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))),
    'format' => '?paged=%#%',
    'current' => max(1, get_query_var('paged')),
    'type' => 'list',
    'prev_text'    => 'Назад',
    'next_text'    => 'Вперед',
    'total' => $wp_query->max_num_pages,
    'show_all'     => false,
    'end_size'     => 15,
    'mid_size'     => 15,
    'add_args'     => false,
    'add_fragment' => '',
    'before_page_number' => '',
    'after_page_number' => ''
  ));
}
  /*
  пагинацию вызываем в верстке, где нужно по названию функции
  */


// хлебные крошки

function windigoBreadcrumbs()
{
  if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
  }
}

// ========================== ПРОДВИНУТЫЕ НАСТРОЙКИ=============================

// добавляет возможность загрузки лого через админку
add_theme_support( 'custom-logo', [
  'height'      => 90,
  'width'       => 200,
  'flex-width'  => false,
  'flex-height' => false,
  'header-text' => '',
  'unlink-homepage-logo' => false, // WP 5.5
] );

// добавляет изображение в шапку админки
add_theme_support( 'custom-header', array(
  'default-image'          => '',
  'random-default'         => false,
  'width'                  => 728,
  'height'                 => 90,
  'uploads'                => true,
  'wp-head-callback'       => '',
  'admin-head-callback'    => '',
  'admin-preview-callback' => '',
  'video'                  => false, 
  'video-active-callback'  => 'is_front_page',
) );


// создаем пользовательский тип данных 

function create_post_type()
{
  $labels = array(
    'name' => __('Slots'),
    'singular_name' => __('Slots'),
    'add_new' => __('New Slots'),
    'add_new_item' => __('Add New Slots'),
    'edit_item' => __('Edit Slots'),
    'new_item' => __('New Slots'),
    'view_item' => __('View Slots'),
    'search_items' => __('Search Slots'),
    'not_found' =>  __('No Slots Found'),
    'not_found_in_trash' => __('No Slots found in Trash'),
  );
  $args = array(
    'taxonomies' => array('slots_category'),
    'publicly_queryable' => true,
    'labels' => $labels,
    'has_archive' => true,
    'public' => true,
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array(
      'title',
      'editor',
      'custom-fields',
      'thumbnail'
    ),
  );
  register_post_type('slots', $args);
}
add_action('init', 'create_post_type');

// создаем пользовательскую таксономию 

function my_register_taxonomy()
{
  register_taxonomy(
    'slots_category',
    'slots',
    array(
      'labels' => array(
        'name'              => 'Slots Categories',
        'singular_name'     => 'Slots Category',
        'search_items'      => 'Search Slots Categories',
        'all_items'         => 'All Slots Categories',
        'edit_item'         => 'Edit Slots Categories',
        'update_item'       => 'Update Slots Category',
        'add_new_item'      => 'Add New Slots Category',
        'new_item_name'     => 'New Slots Category Name',
        'menu_name'         => 'Category',
      ),
      'hierarchical' => true,
      'sort' => true,
      'args' => array('orderby' => 'term_order'),
      'rewrite' => array('slug' => 'slots_category', 'hierarchical' => true),
      'show_admin_column' => true
    )
  );
}
add_action('init', 'my_register_taxonomy');

// создаем шорткод

add_shortcode( 'mybtn', 'btn_shortcode' );

function btn_shortcode( $atts ){
  $atts = shortcode_atts( [
    'text' => '',
    
  ], $atts );
   return '<button onClick="window.open(&apos;/mirror/&apos;);" class="btn">' . $atts['text'] . '</button>';
}


// убираем категорию кастомной таксономии из урла

add_filter('request', 'rudr_change_term_request', 1, 1);
function rudr_change_term_request($query)
{
  $tax_name = 'slots_category';
  if ($query['attachment']) :
    $include_children = true;
    $name = $query['attachment'];
  else :
    $include_children = false;
    $name = $query['name'];
  endif;
  $term = get_term_by('slug', $name, $tax_name);
  if (isset($name) && $term && !is_wp_error($term)) :
    if ($include_children) {
      unset($query['attachment']);
      $parent = $term->parent;
      while ($parent) {
        $parent_term = get_term($parent, $tax_name);
        $name = $parent_term->slug . '/' . $name;
        $parent = $parent_term->parent;
      }
    } else {
      unset($query['name']);
    }

    switch ($tax_name):
      case 'category': {
          $query['category_name'] = $name; // for categories
          break;
        }
      case 'post_tag': {
          $query['tag'] = $name; // for post tags
          break;
        }
      default: {
          $query[$tax_name] = $name; // for another taxonomies
          break;
        }
    endswitch;
  endif;
  return $query;
}

add_filter('term_link', 'rudr_term_permalink', 10, 3);
function rudr_term_permalink($url, $term, $taxonomy)
{

  $taxonomy_name = 'slots_category';
  $taxonomy_slug = 'slots_category';
  if (strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name) return $url;
  $url = str_replace('/' . $taxonomy_slug, '', $url);
  return $url;
}

// редирект на нижний регистр

if (($_SERVER['REQUEST_URI'] != strtolower($_SERVER['REQUEST_URI'])) && (!strpos($_SERVER['REQUEST_URI'], 'wp-admin'))) {
  header('Location: https://' . $_SERVER['HTTP_HOST'] .
    strtolower($_SERVER['REQUEST_URI']), true, 301);
  exit();
}
// убираем микроразметку от yoast 

function windigo_remove_yoast_schema($data)
{
  $data = array();
  return $data;
}
add_filter('wpseo_json_ld_output', 'windigo_remove_yoast_schema', 10, 1);

// опен глаф изображение 

function add_images($object)
{
  if (get_field('img')) {
    $image = esc_url(get_field('img')['url']);
  } else if (get_field('image')) {
    $image = get_field('image');
  } else {
    $image = esc_url(get_field('banner')['url']);
  }

  $object->add_image($image);
}
add_action('wpseo_add_opengraph_images', 'add_images');

// noindex для страниц пагинации 

add_filter( 'wp_robots', 'windigo_noindex_paged' );

function windigo_noindex_paged( $robots ) {
   if ( is_paged() ){
      $robots['follow'] = true;
      $robots['noindex'] = true;
      $robots['index'] = false;
    } 
  return $robots;
}

// canonical для страниц пагинации  

add_filter( 'get_canonical_url', 'remove_pagination_canonical');
add_filter( 'wpseo_canonical', 'remove_pagination_canonical' );
function remove_pagination_canonical( $canonical_url ){
   if ( is_paged() ) {
    return $_SERVER["SERVER_NAME"] . str_replace('page', '', rtrim($_SERVER['REQUEST_URI'], '/0..9/'));
   } else
  return $canonical_url;
}

