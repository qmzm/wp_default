<?php
class Wpmei_Nav_Walker extends Walker_Nav_Menu {

    /**
     * 修改二级菜单
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent  = str_repeat( $t, $depth );
        $suffix = '<span class=" "></span>'; // 添加的按钮对应的HTML
        $output .= "$indent</ul>{$suffix}{$n}";
    }

    

}