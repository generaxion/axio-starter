<?php
if (function_exists('acf_add_local_field_group')) :

  acf_add_local_field_group(array(
    'key' => 'group_5f1a6e3bca0c0',
    'title' => 'Block: Button',
    'fields' => array(
      array(
        'key' => 'field_5f1a6e4533aff',
        'label' => 'Button link',
        'name' => 'button_link',
        'type' => 'link',
        'instructions' => '',
        'required' => 1,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'return_format' => 'array',
      ),
      array(
        'key' => 'field_5f1a6f6233b00',
        'label' => 'Button type',
        'name' => 'button_type',
        'type' => 'button_group',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'choices' => array(
          'primary' => 'Primary',
        ),
        'allow_null' => 0,
        'default_value' => 'primary',
        'layout' => 'horizontal',
        'return_format' => 'value',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/button',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
  ));

endif;
