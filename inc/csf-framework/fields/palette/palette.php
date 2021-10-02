<?php if (!defined('ABSPATH')) {
  die;
} // Cannot access directly.

/*
 * @Author        : wpmei
 * @Url           : wpmei.cn
 * @Date          : 2021-09-15 15:50:59
 * @LastEditTime:   2021-09-20 09:15:30
 * @Email         : 415589243@qq.com
 * @Project       : wordpress主题 开发框架
 * @Description   : 由青梅工作室搭建的快速开发wordpress的通用框架
 * @Read me       : 良好的开发环境需要每一个开发人员共同创造，欢迎提交lssues。
 * @link          : https://gitee.com/qmzm/wp-th-default
 */

/**
 *
 * Field: palette
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */


if (!class_exists('CSF_Field_palette')) {
  class CSF_Field_palette extends CSF_Fields
  {

    public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
    {
      parent::__construct($field, $value, $unique, $where, $parent);
    }

    public function render()
    {

      $palette = (!empty($this->field['options'])) ? $this->field['options'] : array();

      echo $this->field_before();

      if (!empty($palette)) {

        echo '<div class="csf-siblings csf--palettes">';

        foreach ($palette as $key => $colors) {

          $active  = ($key === $this->value) ? ' csf--active' : '';
          $checked = ($key === $this->value) ? ' checked' : '';

          echo '<div class="csf--sibling csf--palette' . esc_attr($active) . '">';

          if (!empty($colors)) {

            foreach ($colors as $color) {

              echo '<span style="background: ' . esc_attr($color) . ';"></span>';
            }
          }

          echo '<input type="radio" name="' . esc_attr($this->field_name()) . '" value="' . esc_attr($key) . '"' . $this->field_attributes() . esc_attr($checked) . '/>';
          echo '</div>';
        }

        echo '</div>';
      }

      echo $this->field_after();
    }
  }
}
