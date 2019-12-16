<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
      get_stylesheet_directory_uri() . '/style.css',
      array('parent-style'),
      wp_get_theme()->get('Version')
    );
}

function recipe_titles($title, $id=null) {
  if (in_category('recipes', $id)) {
    $title = "Recipe" . $title;
  }
  return $title;
}

add_filter('the_title', 'recipe_titles', 10, 2);

function remove_parent_functionality() {
  remove_action('widgets_init', 'twentytwenty_widgets_init');
}

add_action('after_setup_theme', remove_parent_functionality);
