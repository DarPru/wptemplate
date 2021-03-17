<?php

register_nav_menus( array(
  'header' => 'Меню в шапке',
  'footer' => 'Меню в подвале'
) );

add_theme_support('post-thumbnails');
set_post_thumbnail_size(500, 300);
//add_image_size('gallery', 1600, 1000, true);

// Sidebar
register_sidebar(array(
  'name' => 'Левый сайдбар',
  'id' => "left-sidebar",
  'description' => 'Да, это левый сайдбар',
  'before_widget' => '<div id="%1$s" class="widget-left %2$s">',
  'after_widget' => "</div>\n",
  'before_title' => '<span class="widget-title">',
  'after_title' => "</span>\n",
));

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


add_theme_support( 'custom-logo', [
  'height'      => 90,
  'width'       => 200,
  'flex-width'  => false,
  'flex-height' => false,
  'header-text' => '',
  'unlink-homepage-logo' => false, // WP 5.5
] );

add_theme_support( 'custom-header', array(
  'default-image'          => '',
  'random-default'         => false,
  'width'                  => 728,
  'height'                 => 90,
  'uploads'                => true,
  'wp-head-callback'       => '',
  'admin-head-callback'    => '',
  'admin-preview-callback' => '',
  'video'                  => false, // с 4.7
  'video-active-callback'  => 'is_front_page', // с 4.7
) );

add_filter('show_admin_bar', '__return_false'); // включить
remove_action('wp_head','feed_links_extra', 3); // убирает ссылки на rss категорий
remove_action('wp_head','feed_links', 2); // минус ссылки на основной rss и комментарии
remove_action('wp_head','rsd_link');  // сервис Really Simple Discovery
remove_action('wp_head','wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head','wp_generator');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// хук для регистрации таксономии
add_action( 'init', 'create_taxonomy' );
function create_taxonomy(){
 
  register_taxonomy( 'keys', [ 'testimonials' ], [
    'label'                 => '', 
    'labels'                => [
      'name'              => 'Секция отзывов',
      'singular_name'     => 'Секция отзывов',
      'search_items'      => 'Найти секцию',
      'all_items'         => 'Все секции',
      'view_item '        => 'Посмотреть секцию',
      'edit_item'         => 'Добавить секцию',
      'update_item'       => 'Обновить секцию',
      'add_new_item'      => 'Добавить новую секцию',
      'new_item_name'     => 'Название новой секции',
      'menu_name'         => 'Секция отзывов',
    ],
    'description'           => '', // описание таксономии
    'public'                => true,
    // 'publicly_queryable'    => null, // равен аргументу public
    // 'show_in_nav_menus'     => true, // равен аргументу public
    // 'show_ui'               => true, // равен аргументу public
    // 'show_in_menu'          => true, // равен аргументу show_ui
    // 'show_tagcloud'         => true, // равен аргументу show_ui
    // 'show_in_quick_edit'    => null, // равен аргументу show_ui
    'hierarchical'          => false,

    'rewrite'               => true,
    //'query_var'             => $taxonomy, // название параметра запроса
    'capabilities'          => array(),
    'meta_box_cb'           => 'post_categories_meta_box', // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
    'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
    'show_in_rest'          => null, // добавить в REST API
    'rest_base'             => null, // $taxonomy
    // '_builtin'              => false,
    //'update_count_callback' => '_update_post_term_count',
  ] );
}
add_action( 'init', 'register_post_types' );
function register_post_types(){
    register_post_type( 'testimonals', [
        'label'  => null,
        'labels' => [
            'name'               => 'Отзывы', // основное название для типа записи
            'singular_name'      => 'Отзыв', // название для одной записи этого типа
            'add_new'            => 'Добавить отзыв', // для добавления новой записи
            'add_new_item'       => 'Добавление отзыва', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование отзыва', // для редактирования типа записи
            'new_item'           => 'Новый отзыв', // текст новой записи
            'view_item'          => 'Смотреть отзыв', // для просмотра записи этого типа.
            'search_items'       => 'Искать отзыв', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Отзывы', // название меню
        ],
        'description'         => '',
        'public'              => true,
         'publicly_queryable'  => true, // зависит от public
         'exclude_from_search' => true, // зависит от public
         'show_ui'             => true, // зависит от public
         'show_in_nav_menus'   => true, // зависит от public
        'show_in_menu'        => true, // показывать ли в меню адмнки
         'show_in_admin_bar'   => true, // зависит от show_in_menu
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => 'dashicons-format-chat',
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => ['custom-fields'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => ['keys'],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
}
/* Регистрация виджета */
 
function wpb_load_widget() {
  register_widget( 'danilin_testwidget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

class danilin_testwidget extends WP_Widget {

  function __construct() {
    parent::__construct('danilin_testwidget', 'Блок с конторой', array( 'description' => 'Advanced Custom Fields Example', ));
  }

  public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] ); 
    $widget_id = $args['widget_id']; 

    /* Тело плашки */

   
       $link = get_field('widget_link', 'widget_' . $widget_id); 
        $img = get_field('widget_img', 'widget_' . $widget_id);
        $text = get_field('widget_text', 'widget_' . $widget_id);
        $btn = get_field('widget_btn', 'widget_' . $widget_id);
      $rating = get_field('widget_rating', 'widget_' . $widget_id);
     
    echo '
       <div style="display: none;">
  <svg id="icon-star" height="17px" viewBox="0 -10 511.98685 511" width="17px" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#ffc107"/></svg>
</div> 
       <div class="item item__brand">
          <a href="'. $link .'" class="item__logo js__btn__site">
            <img class="lazy" src="'. $img .'" alt="" data-loaded="true">
          </a>
          <a href="' . $link . '" class="item__name js__btn__site">' . $title . '</a>
          <span class="item__rate"><svg class="icon star-full"><use xlink:href="#icon-star"></use></svg>' . $rating . '</span>
          <div class="item__description">' . $text .'</div>
          <div class="code-wrapper pointer">' . $btn . '
          </div>
      ';
    
  
}
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = 'Тестовый виджет';
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Заголовок</label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
  }
 
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
 
}
add_shortcode( 'mybtn', 'btn_shortcode' );

function btn_shortcode( $atts ){
  $atts = shortcode_atts( [
    'text' => '',
    
  ], $atts );
   return '<button onClick="window.open(&apos;/mirror/&apos;);" class="btn">' . $atts['text'] . '</button>';
}
