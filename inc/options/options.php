<?php


//使用Font Awesome 4
add_filter('csf_fa4', '__return_true');

//定义文件夹
function csf_custom_csf_override()
{
    return 'inc/csf-framework';
}
add_filter('csf_override', 'csf_custom_csf_override');


//自定义css、js
function csf_add_custom_wp_enqueue()
{
    // Style
    wp_enqueue_style('csf_custom_css', get_template_directory_uri() . '/inc/csf-framework/assets/css/style.min.css');
    // Script
    wp_enqueue_script('csf_custom_js', get_template_directory_uri() . '/inc/csf-framework/assets/js/main.min.js', array('jquery'));
}
add_action('csf_enqueue', 'csf_add_custom_wp_enqueue');



