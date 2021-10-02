<?php
/**
 *主题的设置框架
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @docx http://codestarframework.com/documentation/#/
 * @package wpmei
 * @subpackage wpmei
 * @since 1.0.0
 * @version 0.0.1
 * @date 2021.09.16
 */

?>


<?php if ( ! defined( 'ABSPATH' )  ) { die; }
// 检查核心类是否有错误
if( class_exists( 'CSF' ) ) {

    //只有后台才执行此代码
    if (!is_admin()) return;

	// 设置一个独特的类似的 ID
	$prefix = 'mei_options';

    // 引入主题菜单的图标和图片
    $imagepath =  get_template_directory_uri() . '/img/';
    $f_imgpath =  get_template_directory_uri() . '/inc/csf-framework/assets/images/';


	// 创建选项和 主题设置
	CSF::createOptions( $prefix, array(
        'menu_title' => '后台菜单名称',   //如：WPMEI主题
        'menu_slug'  => 'mei_options',
        'framework_title'         => '主题设置title',  //如：WPMEI主题
        'show_in_customizer'      => FALSE, //在wp-customize中也显示相同的选项
        'footer_text'             => '主题版本 V' . wp_get_theme()['Version'], //如：WPMEI主题 V2.0
        'footer_credit'           => '<i class="fa fa-fw fa-heart-o" aria-hidden="true"></i> ',
        'theme'  => 'light'
	) );

	CSF::createSection( $prefix, array(
		'id'      => 'mei_header',
		'title'  => '头部设置',
		'icon'   => 'fa fa-rocket',
		'fields' => array(
            array(
                'id'    => 'mei-nav-logo',
                'type'  => 'media',
                'title' => '名称一',
            ),
            array(
                'id'    => 'mei-nav-tel',
                'type'  => 'text',
                'title' => '名称二',
            )
        )
	) );	

   

   
  }
