<?php

  /**
  *
  *	This library is a form class that help create form inputs
  *
  *	@version:       2.1.15
  * @package        Stvdi
  *	@author:        Jencube Team
  *	@license:       http://opensource.org/licenses/gpl-license.php
  *                 GNU General Public License (GPL)
  * @copyright:     Copyright (c) 2013 - 2015 Jencube
  * @twitter:       @deusex0 & @One_Oracle
  * @filesource     includes/libraries/form.class.php
  *
  **/

  class FormBuilder {

    /**
    *
    * Non attributes key
    *
    * @access private
    * @var array
    *
    **/
    private $notAttributes = array(
                              'title',
                              'label',
                              'selected',
                              'button',
                              'options',
                              'option_title',
                              'group_sep'
                          );

    /**
    *
    * Error messages constants
    *
    */
    const ERROR_ATTRIBUTES = 'Values must be an array( key => value ).';
    const ERROR_LABEL_ATTRI = 'Label values must be an array( key => value ).';

    /**
    *
    * Error messages
    *
    * @access protected
    * @var array
    *
    **/
    protected $errorMsg = array();

    /**
    *
    * Class constructor initialization to set the class
    * properties
    *
    * @access public
    *
    **/
    public function __construct() {

    }

    /**
    *
    * Open form tag
    *
    * @access public
    * @return string
    * @param array $attributes -> Form attributes
    * @param bool $echo -> True to echo tag and false to return tag
    *
    **/
    public function open_tag( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $attributes = $this->extract( $attributes );
        $form = '<form ' . $attributes . '>';
      } else {
        $form = '<form>';
      }

      if ( $echo )
        echo $form;
      else
        return $form;
    }

    /**
    *
    * Close form tag
    *
    * @access public
    * @return string
    * @param bool $echo -> True to echo tag and false to return tag
    *
    **/
    public function close_tag( $echo = TRUE ) {
      if ( $echo )
        echo '</form>';
      else
        return '</form>';
    }

    /**
    *
    * Extract element attributes
    *
    * @access public
    * @return string
    * @param array $attributes -> array of element attributes
    *
    **/
    private function extract_attr( $attributes ) {
      if ( ! is_array( $attributes ) ) {
        $this->errorMsg[] = self::ERROR_ATTRIBUTES;
        return FALSE;
      }

      $attr = array();
      foreach ( $attributes as $key => $value ) {
        $key = strtolower( $key );
        // if ( $key != 'title' && $key != 'label' && $key != 'selected' && $key != 'options' && $key != 'list' ) {
      if ( ! in_array( $key, $this->notAttributes ) ) {
        //   $key = strtolower( $key );
        //   $attr[] = $key . '="' . $value . '" ';
        // }
          switch ( $key ) {
            case 'disabled':
            case 'checked':
            case 'autofocus':
            case 'required':
            case 'multiple':
              $attr[] = $key . ' ';
              break;
            case 'name':
            case 'id':
            default:
              $attr[] = $key . '="' . $value . '" ';
              break;
          }
        }
      }

      return implode('', $attr );
    }

    /**
    *
    * Create a <label></label> element
    *
    * @access public
    * @return string
    * @param array $attr -> element attributes
    * @param bool $formInput -> HTML form element
    *
    **/
    private function label( $attr = NULL, $formInput = NULL ) {
      if ( ! empty( $attr ) && ! is_array( $attr ) ) {
        $this->errorMsg[] = self::ERROR_LABEL_ATTRI;
        return FALSE;
      }

      $type = ( ! empty( $attr['label']['type'] ) ) ? strtolower( $attr['label']['type'] ) : 'cover';
      $id = ( ! empty( $attr['id'] ) ) ? ' for ="' . $attr['id'] . '"' : '';
      $for = ( ! empty( $attr['label']['for'] ) ) ? ' for ="' . $attr['label']['for'] . '"' : $id;
      $title = ( ! empty( $attr['label']['title'] ) ) ? $attr['label']['title'] : $attr['title'];
      $input = '';

      switch ( strtolower( $type ) ) {
        case 'top':
          $input = '<label' . $for . '>' . '<span>' . $title . '</span>' . '</label>';
          $input .= $formInput;
          break;
        case 'bottom':
          $input = $formInput;
          $input .= '<label' . $for . '>' . '<span>' . $title . '</span>' . '</label>';
          break;
        case 'cover-after':
          $input = '<label' . $for . '>';
          $input .= $formInput;
          $input .= '<span>' . $title . '</span>';
          $input .= '</label>';
          break;
        case 'cover-before':
          $input = '<label' . $for . '>';
          $input .= '<span>' . $title . '</span>';
          $input .= $formInput;
          $input .= '</label>';
          break;
        case 'cover':
        default:
          $input = '<label' . $for . '>';
          $input .= $formInput;
          $input .= '</label>';
          break;
      }

      return $input;

    }

    /**
    *
    * Create a <button></button> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function button( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $title = ( ! empty( $attributes['title'] ) ) ? $attributes['title'] : '';
        $attr = $this->extract_attr( $attributes );
        $button = '<button ' . $attr . '>' . $title . '</button>';
      } else {
        $button = '<button></button>';
      }

      if ( ! empty( $attributes['label'] ) )
        $button = $this->label( $attributes, $button );

      $this->display( $button, $echo );
    }

    /**
    *
    * Create a <a></a> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function link_button( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $title = ( ! empty( $attributes['title'] ) ) ? $attributes['title'] : '';
        $attr = $this->extract_attr( $attributes );
        $button = '<a ' . $attr . '>' . $title . '</a>';
      } else {
        $button = '<a></a>';
      }

      if ( ! empty( $attributes['label'] ) )
        $button = $this->label( $attributes, $button );

      $this->display( $button, $echo );
    }

    /**
    *
    * Create a <input type="reset" /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function reset_button( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $attr = $this->extract_attr( $attributes );
        $reset = '<input type="reset" ' . $attr . ' />';
      } else {
        $reset = '<input type="reset" />';
      }

      if ( ! empty( $attributes['label'] ) )
        $reset = $this->label( $attributes, $reset );

      $this->display( $reset, $echo );
    }

    /**
    *
    * Create a <input type="submit" /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function submit( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $attr = $this->extract_attr( $attributes );
        $submit = '<input type="submit" ' . $attr . ' />';
      } else {
        $submit = '<input type="submit" />';
      }

      if ( ! empty( $attributes['label'] ) )
        $submit = $this->label( $attributes, $submit );

      $this->display( $submit, $echo );
    }

    /**
    *
    * Create a <input /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function input( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $attr = $this->extract_attr( $attributes );
        $input = '<input ' . $attr . ' />';
      } else {
        $input = '<input type="text" />';
      }

      if ( ! empty( $attributes['label'] ) )
        $input = $this->label( $attributes, $input );

      $this->display( $input, $echo );
    }

    /**
    *
    * Create a <input type="checkbox" /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function checkbox( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $attr = $this->extract_attr( $attributes );
        $input = '<input type="checkbox" ' . $attr . ' />';
      } else {
        $input = '<input type="checkbox" />';
      }

      if ( ! empty( $attributes['label'] ) )
        $input = $this->label( $attributes, $input );

      $this->display( $input, $echo );
    }

    /**
    *
    * Create a <input type="checkbox" /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function radio( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $attr = $this->extract_attr( $attributes );
        $input = '<input type="radio" ' . $attr . ' />';
      } else {
        $input = '<input type="radio" />';
      }

      if ( ! empty( $attributes['label'] ) )
        $input = $this->label( $attributes, $input );

      $this->display( $input, $echo );
    }

    /**
    *
    * Create a search <input /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function search_input( $btnSrc = NULL ){
      $input = '';
      $search = '';
      $input .= $this->input(
        array(
          'type' => 'text',
          'name' => 'searchInput',
          'id' => 'searchInput',
          'placeholder' => "Enter Search",
          'onfocus' => 'this.value = ( this.value == "Enter Search" ) ? "" : this.value;',
          'onblur' => 'this.value = ( this.value == "" ) ? "Enter Search" : this.value;',
          'value' => "Enter Search",
          'maxLength' => '50',
          'class' => 'search',
          'autofocus' => 'autofocus',
          'size' => '30'
        )
      );
      if ( empty( $btnSrc ) ):
        $search .= $input;
      elseif ( $btnSrc == 'link' ):
        $search .= $input.'<a id="searchBtn" class="searchBtn" title="Click to search">Search</a>';
      elseif ( $btnSrc == 'button' ):
        $search .= $input.'<input type="button" class="searchBtn" value="Search" />';
      endif;

      echo $search;
    }

    /**
    *
    * Create a <textarea></textarea> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function textarea( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $title = ( ! empty( $attributes['title'] ) ) ? $attributes['title'] : '';
        $attr = $this->extract_attr( $attributes );
        $textarea = '<textarea ' . $attr . '>' . $title . '</textarea>';
      } else {
        $textarea = '<textarea></textarea>';
      }

      if ( ! empty( $attributes['label'] ) )
        $textarea = $this->label( $attributes, $textarea );

      $this->display( $textarea, $echo );
    }

    /**
    *
    * Create a <select><option></option></select> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function select( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $title = ( ! empty( $attributes['title'] ) ) ? $attributes['title'] : '';
        $attr = $this->extract_attr( $attributes );
        $select = '<select ' . $attr . '>' . $title;
        // $optionTitle = '';
        // $selected = '';
        if ( ! empty( $attributes['option_title'] ) ) {
          $optionTitle = ( strtolower( $attributes['option_title'] ) == 'title' ) ? $attributes['title'] : $attributes['option_title'];
          $select .= '<option value="">' . $optionTitle . '</option>';
        }
        foreach ( $attributes['options'] as $key => $value ) {
          if ( ! empty( $attributes['selected'] ) )
            $selected = ( $attributes['selected'] == $key ) ? 'selected="selected"' : '';

          $select .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
        }
        $select .= '</select>';
      } else {
        $select = '<select><option></option></select>';
      }

      if ( ! empty( $attributes['label'] ) )
        $select = $this->label( $attributes, $select );

      $this->display( $select, $echo );
    }


    /**
    *
    * Create a <select><optgroup></optgroup></select> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function optgroup( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $title = ( ! empty( $attributes['title'] ) ) ? $attributes['title'] : '';
        $attr = $this->extract_attr( $attributes );
        $select = '<select ' . $attr . '>' . $title;
        foreach ( $attributes['options'] as $label => $options ) {
          $select .= '<optgroup label="' . $label . '">';
          foreach( $options as $key => $value ) {
            if ( ! empty( $attributes['selected'] ) )
              $selected = ( $attributes['selected'] == $key ) ? 'selected="selected"' : '';

            $select .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
          }
          $select .= '</optgroup>';
        }
        $select .= '</select>';
      } else {
        $select = '<select><optgroup></optgroup></select>';
      }

      if ( ! empty( $attributes['label'] ) )
        $select = $this->label( $attributes, $select );

      $this->display( $select, $echo );
    }

    /**
    *
    * Create a <input /><datalist><option /></datalist> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function datalist( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {

        $attr = $this->extract_attr( $attributes );
        $datalist = '<input ' . $attr . '>';
        $datalist .= '<datalist id="' . $attributes['list'] . '">';

        foreach ( $attributes['options'] as $key ) {
          $datalist .= '<option value="' . $key . '" />';
        }
        $datalist .= '</datalist>';
      } else {
        $datalist = '<datalist></datalist>';
      }

      if ( ! empty( $attributes['label'] ) )
        $datalist = $this->label( $attributes, $datalist );

      $this->display( $datalist, $echo );
    }

    /**
    *
    * Put a seperator for individual group element
    *
    * @access private
    * @return string
    * @param stirng $input -> HTML element
    * @param string $sep -> Seperator type for group element
    *
    **/
    private function group_sep( $input, $sep = 'label' ) {
      $seperator = '';
      switch ( strtolower( $sep ) ) {
        case 'br':
        case 'nl':
        case 'newline':
          $seperator = $input;
          $seperator .= '<br />';
          break;
        case 'li':
          $seperator = '<li>';
          $seperator .= $input;
          $seperator .= '</li>';
          break;
        case 'label':
        default:
          $seperator = $this->label( NULL, $input );
          break;
      }
      return $seperator;
    }

    /**
    *
    * Create group <input type="checkbox" name="name[]" /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function checkbox_group( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $name = $attributes['name'] . '[]';
        unset( $attributes['name'] );
        $attr = $this->extract_attr( $attributes );
        $input = '';
        foreach ( $attributes['options'] as $key => $value ) {
          $sep = '<input type="checkbox" name="' . $name . '" ' . $attr . ' value="' . $key . '" />';
          $sep .= '<span>' . $value . '</span>';
          if ( ! empty( $attributes['group_sep'] ) ) {
            $input .= $this->group_sep( $sep, $attributes['group_sep'] );
          } else {
            $input .= $this->group_sep( $sep );
          }
        }
      } else {
        $input = '<input type="checkbox" />';
      }

      if ( ! empty( $attributes['label'] ) )
        $input = $this->label( $attributes, $input );

      $this->display( $input, $echo );
    }

    /**
    *
    * Create group <input type="checkbox" name="name[]" /> element
    *
    * @access public
    * @return string
    * @param array $attributes -> Element attributes
    * @param bool $echo -> True to echo element and false to return element
    *
    **/
    public function radio_group( $attributes = NULL, $echo = TRUE ) {
      if ( ! empty( $attributes ) ) {
        $name = $attributes['name'] . '[]';
        unset( $attributes['name'] );
        $attr = $this->extract_attr( $attributes );
        $input = '';
        foreach ( $attributes['options'] as $key => $value ) {
          $sep .= '<input type="radio" name="' . $name . '" ' . $attr . ' value="' . $key . '" />';
          $sep .= '<span>' . $value . '</span>';
          if ( ! empty( $attributes['group_sep'] ) ) {
            $input .= $this->group_sep( $sep, $attributes['group_sep'] );
          } else {
            $input .= $this->group_sep( $sep );
          }
        }
      } else {
        $input = '<input type="radio" />';
      }

      if ( ! empty( $attributes['label'] ) )
        $input = $this->label( $attributes, $input );

      $this->display( $input, $echo );
    }

    /**
    *
    * Create a <fieldset><legend></legend></fieldset> element
    *
    * @access public
    * @return string
    * @param stirng $input -> HTML element
    * @param array $attributes -> Element attributes
    *
    **/
    public function fieldset( $input, $attr = NULL ) {
      $fieldset = '';
      $attributes = '';
      if ( empty( $attr ) ) {
        $fieldset = '<fieldset>';
        $fieldset .= $input;
        $fieldset .= '</fieldset>';
      } else if ( is_array( $attr ) ) {
        $attributes .= ( ! empty( $attr['form_id'] ) ) ? 'form="' . $attr['form_id'] . '" ' : NULL;
        $attributes .= ( ! empty( $attr['name'] ) ) ? 'name="' . $attr['name'] . '" ' : NULL;
        $attributes .= ( ! empty( $attr['disabled'] ) ) ? 'disabled="' . $attr['disabled'] . '" ' : NULL;
        $fieldset = '<fieldset ' . $attributes . '>';
        if ( ! empty( $attr['legend'] ) ) {
          $fieldset .= '<legend>';
          $fieldset .= $attr['legend'];
          $fieldset .= '</legend>';
        }
        $fieldset .= $input;
      }

      $this->display( $fieldset, $echo );
    }

    /**
    *
    * Display option
    *
    * @access public
    * @return mixed
    * @param mized $content -> Content to display
    * @param bool $echo -> True to echo content and false to return content
    *
    **/
    public function display( $content, $echo = TRUE ) {
      if ( $echo )
        echo $content;
      else
        return $content;
    }

    /**
    *
    * Return validation errors
    *
    * @access public
    * @return array
    *
    **/
    public function errors() {
      return $this->errorMsg;
    // foreach( $this->errorMsg as $key => $value )
    //   return $value;
    }



  }

?>