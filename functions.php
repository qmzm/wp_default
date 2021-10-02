<?php

/**
 * @ functions
 * @author wpmei
 * @subpackage wpmei
 * @since 1.0.0
 * @version 0.0.1
 * @date 2021.09.15
 */


/**
 * 引入css,js文件
 */
function wpmei_style(){

    // 引入css
    wp_enqueue_style('main-css',get_theme_file_uri(). '/assets/css/XX.css');



    //引入js
    wp_enqueue_script('jquery',get_theme_file_uri(). '/assets/js/XX.js');


    //调取官方原生回复评论跳转函数
    //（是否是文章页 && 文章是否开启评论 && 后台是否开启嵌套评论）
    if(is_singular() && comments_open() && get_option('thread_comments')){
        wp_enqueue_script('comment-reply');
    }

}

add_action('wp_enqueue_scripts','wpmei_style');



/**
 *
 * 开启页面标题功能
 * 开启特色图像
 * 注册导航菜单
 *
 **/


function wpmei_setup(){

    // 开启页面标题功能
    add_theme_support('title_tag');

    //开启特色图像
    add_theme_support('post-thumbnails');

    //注册导航菜单
    register_nav_menus(array(
        'header_menu' => '顶部导航',
        'footer_menu' => '底部导航'
    ));
}

 add_action('after_setup_theme','wpmei_setup');




/**
 *
 * 注册边栏小工具
 *
 **/


function wpmei_sidebar(){
    register_sidebar( array(
        'name' => '边栏1',
        //小工具的区域名称，默认是 'Sidebar' 加 数字 ID
        'id'=> 'sidebar-1',
        //区域的ID，默认是一个自动递增的数字 ID
        'description'=> '第1个边栏',
        //区域的描述，默认为空
        'before_widget' => '<div id="%1$s" class="%2$s my-class">',
        //区域的内容前的HTML代码，默认： ''）
        'after_widget'=> '</div>',
        //区域内容后的HTML代码，默认： "\n"
        'before_title'=> '<h3 class="my-widget-title">',
        //区域标题前的HTML代码，默认：
        'after_title'=> '</h3>',
        //区域标题后的HTML代码，默认："\n"
    ));
}
add_action( 'widgets_init', 'wpmei_sidebar' );




/**
 * 获取用户当前访问的网址
 */
function wpmei_get_current_url() {
    global $wp, $wp_rewrite;

    // 获取重写规则，朴素模式规则为空
    $rewrite = $wp_rewrite->wp_rewrite_rules();

    // 非朴素模式下，返回当前网址
    if ( !empty($rewrite) ) {
        return home_url( $wp->request );
    }

    // 在朴素模式下，返回当前网址
    return home_url( '?' . $wp->query_string );

}


/**
 * 修改二级菜单
 */

function wpmei_load_self_nav_walker() {
    // 加载walker类
    include get_theme_file_path() . '/inc/class-my-nav-walker.php';
}
add_action( 'after_setup_theme', 'wpmei_load_self_nav_walker' );




/**
 * 处理嵌套评论回复的函数
 * 增加谁回复谁
 * 所有用到的钩子信息——
 *  apply_filters( 'get_comment_author_link', $return, $author, $comment->comment_ID );
 * @param string $out 未修改的评论数据，即wordpress默认提供的数据
 * @param int $comment_id 评论的编号
 * @return string
 */
function wpktcore_who_resp_who($out, $author, $comment_id) {
    $comment = get_comment($comment_id);
    // 如果没有父级评论，则正常返回，因为没有回复关系
    if ( empty($comment->comment_parent) ) {
        return $out;
    }

    //如果有父级评论，则添加回复关系
     
    // 获取父（原）评论
    $parent = get_comment($comment->comment_parent);
    // 获取父（原）评论作者
    $pauthor = get_comment_author($parent);
    // 构件回复关系
    $pcid = '#comment-' . $parent->comment_ID;
    $new = $out . ' 回复 '. "<a href='{$pcid}'>{$pauthor}</a>";
    // 返回修改后的评论数据
    return $new;
}
add_filter('get_comment_author_link', 'wpktcore_who_resp_who', 10, 3);




/**
 * 截取正文方法函数
 * @param int $len   要截取的字符数量
 * @param string $suffix    如果发生截取，添加什么标记
 * @return string
 */


function wpmei_strim_post_content($len = 100, $suffix = '...') {

    // 获取正文信息，并做必要处理
    $content = get_the_content();
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );

    // 去除正文中的HTML标签
    $content = strip_tags($content);

    if ( mb_strlen($content) <= $len ) {
        // 字符数量少于要截取的长度，则展示全部
        return $content;
    } else {
        // 截取指定长度的字符
        return $content = mb_substr( $content, 0, $len ) . $suffix;
    }
}



/**
 * 设置文章/页面 浏览次数
 * _wpmei_postviews是自定义栏目的名字
 * @param int $post_id  文章的ID编号
 */


function wpmei_set_postviews($post_id) {
    // 详情页才处理
    if ( is_singular() && ! empty( $post_id ) ) {
        $views = get_post_meta($post_id, '_wpmei_postviews', true);
        $views = ! empty( $views ) ? $views : 0;
        $views++;
        update_post_meta($post_id, '_wpmei_postviews', $views);
    }
}




/**
 * 获取文章/页面 浏览次数
 * @param int 文章的ID编号
 * @return int 浏览次数
 */



function wpmei_get_postviews( $post_id ) {
    if ( ! empty( $post_id ) ) {
        $views = get_post_meta($post_id, '_wpmei_postviews', true);
        $views = ! empty( $views ) ? (int)$views : 0;
        return $views;
    }
}




/**
 *
 * 登录注册页面的美化
 * get_theme_file_uri()
 * get_stylesheet_directory_uri()
 * 
 **/



function custom_login_style() {
    //echo '<link rel="stylesheet" id="wp-admin-css" href="'.get_bloginfo('template_directory').'/assets/css/admin-style.css" type="text/css" />';
    wp_enqueue_style('main-css',get_theme_file_uri(). '/assets/css/admin-style.css');
}
add_action('login_head', 'custom_login_style');




/**
 *
 * WordPress 更换登录界面URL
 *
 **/
add_filter('login_headerurl', create_function(false,"return get_bloginfo('url');"));





/***
 * 
 * 引入cs-framework框架
 * 主题自定义设置
 * 引入 setting,是主题设置选项
 * options 里面是framework框架改变的样式和js功能
 * 
 */


require_once get_theme_file_path() .'/inc/codestar-framework/codestar-framework.php';
require get_template_directory() .'/inc/setting.php';
require get_template_directory() .'/inc/options/options.php';