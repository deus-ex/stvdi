<?php

  /**
  *
  * This is the function file handles HTML form tags declaration
  *
  * @version       2.0.0
  * @package       Stvdi
  * @author        Jencube Team
  * @license       http://opensource.org/licenses/gpl-license.php
  *                GNU General Public License (GPL)
  * @copyright     Copyright (c) 2014 - 2015 Jencube
  * @twitter       @deusex0 & @One_Oracle
  * @filesource    includes/functions/form.funct.php
  *
  **/


  /**
  *
  * Check if form element is posted
  *
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
  function posted( $value, $echo = TRUE ) {
    if ( isset( $_POST[$value] ) ) {
      if ( $echo === TRUE )
        echo $_POST[$value];
      else
        return $_POST[$value];

    }
  }

  /**
  *
  * To display the open form tag
  *
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
  function form_start( $attr = NULL ) {
    if ( ! empty( $attr ) ) {
      echo '<form ' . prepare_attributes( $attr ) . ' >';
    } else {
      echo '<form>';
    }

  }

 /**
  *
  * To display the close form tag
  *
  * @return string
  * @since 1.0.0
  *
  **/
  function form_end( $attr = NULL ) {
    echo '</form>';

  }

 /**
  *
  * Return form input attributes
  *
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
  function prepare_attributes( $attr ) {
    $attributes = '';

    foreach ( $attr as $key => $value ) {

      switch ( strtolower( $key ) ) {
        case 'disabled':
        case 'checked':
        case 'autofocus':
        case 'required':
        case 'multiple':
          $attributes .= $key . ' ';
          break;
        case 'name':
        case 'id':
          $attributes .= $key . ' ="' . strtolower( $value ) . '" ';
          break;
        default:
          $attributes .= $key . ' ="' . strtolower( $value ) . '" ';
          break;
      }
    }

    return $attributes;
  }

 /**
  *
  * Create form label
  *
  * @param array $attr -> form tag attributes
  * @param string $input -> HTML form input
  * @return string
  * @since 2.0.0
  *
  **/
  function label( $attr, $input = NULL ) {
    if ( ! is_array ( $attr ) ) {
      return $input;
    }

    // $title = ( empty( $attr['title'] ) ) ? '' : $attr['title'];
    $for = ( empty( $attr['for'] ) ) ? '' : $attr['for'];
    $label = '';

    switch ( strtolower( $attr['type'] ) ) {
      // case 'cover-before':
      //   $label = '<label for="' . $for . '">';
      //   $label .= $title . $input;
      //   $label .= '</label>';
      //   break;
      // case 'cover-after':
      //   $label = '<label for="' . $for . '">';
      //   $label .= $input . $title;
      //   $label .= '</label>';
      //   break;
      case 'cover':
        $label = '<label for="' . $for . '">';
        $label .= $input;
        $label .= '</label>';
        break;
      case 'top':
        $label = '<label for="' . $for . '">' . $attr['title'] . '</label>';
        $label .= $input;
        break;
      case 'bottom':
        $label = $input;
        $label .= '<label for="' . $for . '">' . $attr['title'] . '</label>';
        break;
      default:
        $label = $input;
        break;
    }

    return $label;
  }

 /**
  *
  * Return form HTML input
  *
  * @param array $attr -> form tag attributes
  * @return string
  * @since 2.0.0
  *
  **/
  function input( $attr ) {
    if ( ! isset( $attr['type'] ) ) {
      return FALSE;
    }

    $input = '';
    $input = '<input type="' . $attr['type'] . '" name="' . $attr['name'] . '" ' . prepare_attributes( $attr['attr'] ) . ' />';

    if ( isset( $attr['before'] ) ) {
      $input = $attr['before'] . ' ' . $input;
    }

    if ( isset( $attr['after'] ) ) {
      $input = $input . ' ' . $attr['after'];
    }

    // Label
    if ( isset( $attr['label'] ) && is_array( $attr['label'] ) ) {
      $attr['label']['title'] = $attr['title'];
      $input = label( $attr['label'], $input );
    } else if ( isset( $attr['label'] ) && ! is_array( $attr['label'] ) ) {
      // Default label type
      $attr['label'] = array( 'type' => 'top', 'title' => $attr['title'], 'for' => $attr['attr']['id'] );
      $input = label( $attr['label'], $input );
    }

    echo $input;

    // switch ( $attr['type'] ) {
    //   case 'text':
    //   case 'password':
    //   case 'file':
    //   case 'email':
    //   case 'tel':
    //   case 'number':
    //   case 'url':
    //   case 'color':
    //   case 'date':
    //   case 'datetime':
    //   case 'datetime-local':
    //   case 'hidden':
    //   case 'image':
    //   case 'month':
    //   case 'range':
    //   case 'search':
    //   case 'time':
    //   case 'week':
    //     echo create_input( $attr );
    //     break;
    //   case 'button':
    //   case 'submit':
    //   case 'link':
    //   case 'reset':
    //     echo button( $attr );
    //     break;
    //   case 'checkbox':
    //   case 'checkbox-group':
    //     # code...
    //     break;
    //   case 'radio':
    //   case 'radio-group':
    //     # code...
    //     break;
    //   case 'textarea':
    //     # code...
    //     break;
    // }

  }

 /**
  *
  * Return form HTML input
  *
  * @param array $attr -> form tag attributes
  * @return string
  * @since 2.0.0
  *
  **/
   // function create_input( $attr ) {
   //  $input = '';

   //  $input = '<input type="text" ' . prepare_attributes( $attr['attr'] ) . ' />';

   //  if ( isset( $attr['label'] ) && is_array( $attr['label'] ) ) {
   //    $input .= label( $attr['label'], $input );
   //  } else if ( isset( $attr['label'] ) && ! is_array( $attr['label'] ) ) {
   //    $attr = array( 'type' => 'top', 'name' => $attr['label'], 'id' => $attr['id'] );
   //    $input .= label( $attr['label'], $input );
   //  } else {

   //  }

   // }

 /**
  *
  * Return form HTML select attributes
  *
  * @param array $attr -> form tag attributes
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
 function select( $attr, $option = NULL ) {


 }

 /**
  *
  * Return HTML botton
  *
  * @param array $attr -> Button attributes
  * @param array $type -> Type of button: input | link | button
  * @return string
  * @since 1.0.0
  *
  **/
  function button( $attr, $type = 'input' ) {
    if ( ! is_array( $attr ) ) {
      return FALSE;
    }

    switch ( strtolower( $type ) ) {
      case 'input':
        # code...
        break;
      case 'button':
        # code...
        break;
      case 'link':
        # code...
        break;
    }

    return $button;

  }

 /**
  *
  * Return form input attributes
  *
  * @param array $attr -> form tag attributes
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
 function radio( $attr, $type = 'single' ) {
  // type = single | group
 }

 /**
  *
  * Return form input attributes
  *
  * @param array $attr -> form tag attributes
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
 function checkbox( $attr, $type = 'single' ) {
  // type = single | group

 }

 /**
  *
  * Return form input attributes
  *
  * @param array $attr -> form tag attributes
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
 function textarea( $attr, $type = 'single' ) {
  // type = single | group
 }

 /**
  *
  * Return form input attributes
  *
  * @param array $attr -> form tag attributes
  * @param array $attr -> form tag attributes
  * @return string
  * @since 1.0.0
  *
  **/
 function language( $string ) {
  // $language = new language();
  return $string;
 }

?>
