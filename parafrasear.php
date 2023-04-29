<?php
/**
 * Plugin Name:       Parafrasear
 * Plugin URI:        https://parafrasear.org/
 * Description:       Parafrasear proporciona la mejor solución para parafrasear
 * Version:           1.0
 * Author:            ASKSEO
 * Author URI:        https://askseo.me/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       parafrasear
 */


 if (!defined('ABSPATH')) {
  echo 'Activate plugin first';
  exit;
}



  // enqueue scripts start

 function enqueue_scripts_parafrasear() {

  $directory = plugin_dir_url(__FILE__);

    if (get_current_screen()->id === 'post' || get_current_screen()->id === 'page') {

      wp_enqueue_style(
        'style-parafrasear',
        $directory . 'css/style.css',
        array(),
        1,
        'all'
    );

      wp_enqueue_script('script-parafrasear', $directory . 'js/main.js', array('wp-editor'), '1.0', true);
      wp_localize_script('script-parafrasear', 'parafrasear_param', array(
        'pluginsUrl' => plugins_url(),
    ));

    }
  }
  add_action('admin_enqueue_scripts', 'enqueue_scripts_parafrasear');

  // enqueue scripts end




 
 // Add a custom meta box to the post and page editor screens
function add_meta_box_parafrasear() {
    add_meta_box(
      'meta-box-parafrasear', // Unique ID
      'Parafrasear', // Box title
      'meta_box_callback_parafrasear', // Callback function
      array('post', 'page'), // Post and pages types to display the meta box
      'side', // Context
      'high' // Priority
    );
  }
  add_action('add_meta_boxes', 'add_meta_box_parafrasear');
  
  // Define the content of the meta box
  function meta_box_callback_parafrasear($post) {
    
    // Output your meta box content here
    require plugin_dir_path( __FILE__ ). 'views/front.php';

  }
