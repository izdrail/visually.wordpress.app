<?php

namespace Visually\WPBones\Html;

class Html
{

  protected static $htmlTags = [
    'a'        => '\Visually\WPBones\Html\HtmlTagA',
    'button'   => '\Visually\WPBones\Html\HtmlTagButton',
    'checkbox' => '\Visually\WPBones\Html\HtmlTagCheckbox',
    'datetime' => '\Visually\WPBones\Html\HtmlTagDatetime',
    'fieldset' => '\Visually\WPBones\Html\HtmlTagFieldSet',
    'form'     => '\Visually\WPBones\Html\HtmlTagForm',
    'input'    => '\Visually\WPBones\Html\HtmlTagInput',
    'label'    => '\Visually\WPBones\Html\HtmlTagLabel',
    'optgroup' => '\Visually\WPBones\Html\HtmlTagOptGroup',
    'option'   => '\Visually\WPBones\Html\HtmlTagOption',
    'select'   => '\Visually\WPBones\Html\HtmlTagSelect',
    'textarea' => '\Visually\WPBones\Html\HtmlTagTextArea',
  ];

  public static function __callStatic( $name, $arguments )
  {
    if ( in_array( $name, array_keys( self::$htmlTags ) ) ) {
      $args = ( isset( $arguments[ 0 ] ) && ! is_null( $arguments[ 0 ] ) ) ? $arguments[ 0 ] : [];

      return new self::$htmlTags[ $name ]( $args );
    }
  }
}