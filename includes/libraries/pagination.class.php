<?php

  /**
  *
  *	This library is a pagination class that works with query result.
  * It can be displayed in three form: Links (<a></a>), List items
  * (<ul></ul>) and select input (<select></select>). It can be
  * easily be customerize with CSS.
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

  class Pagination {

    /**
    *
    * Number of query result to display per page
    *
    * @access private
    * @var integer|string
    *
    **/
    private $listPerPage = 25;

    /**
    *
    * TOtal number of query result
    *
    * @access private
    * @var integer|string
    *
    **/
    private $totalResults;

    /**
    *
    * Current result page being displayed
    *
    * @access private
    * @var integer|string
    *
    **/
    private $currentPage;

    /**
    *
    * Total number of pages
    *
    * @access private
    * @var string
    *
    **/
    private $totalNumPages;

    /**
    *
    * Start page
    *
    * @access private
    * @var integer
    *
    **/
    private $startPage;

    /**
    *
    * Page link
    *
    * @access private
    * @var string
    *
    **/
    private $pageLink;

    /**
    *
    * Type of paginator
    *
    * @access private
    * @var string
    *
    **/
    private $type = 'link';

    /**
    *
    * Display previous button
    *
    * @access private
    * @var bool
    *
    **/
    private $prevBtn = TRUE;

    /**
    *
    * Display next button
    *
    * @access private
    * @var bool
    *
    **/
    private $nextBtn = TRUE;

    /**
    *
    * Display first button
    *
    * @access private
    * @var bool
    *
    **/
    private $firstBtn = TRUE;

    /**
    *
    * Display last button
    *
    * @access private
    * @var bool
    *
    **/
    private $lastBtn = TRUE;

    /**
    *
    * Last button text
    *
    * @access private
    * @var string
    *
    **/
    private $lastBtnText = 'Last';

    /**
    *
    * Previous button text
    *
    * @access private
    * @var string
    *
    **/
    private $prevBtnText = 'Previous';

    /**
    *
    * Next button text
    *
    * @access private
    * @var string
    *
    **/
    private $nextBtnText = 'Next';

    /**
    *
    * First button text
    *
    * @access private
    * @var string
    *
    **/
    private $firstBtnText = 'First';

    /**
    *
    * Load more text
    *
    * @access private
    * @var string
    *
    **/
    private $loadMoreText = 'Load More';

    /**
    *
    * Done loading text
    *
    * @access private
    * @var string
    *
    **/
    private $doneLoadingText = 'Done Loading';

    /**
    *
    * Input span text
    *
    * @access private
    * @var string
    *
    **/
    private $inputSpanText = 'Page: ';

    /**
    *
    * Paging loop
    *
    * @access protected
    * @var array
    *
    **/
    protected $loop = array();

    /**
    *
    * Class constructor initialization to set the class
    * properties
    *
    * @access public
    * @return bool
    *
    **/
    public function __construct( $data = NULL ) {
      if ( !isset( $data['total_results'] ) || empty( $data['total_results'] ) ) {
        $this->errorMsg[] = 'No result found.';
        return FALSE;
      }

      $this->totalResults = $data['total_results'];
      $this->listPerPage = ( ! empty( $data['list_per_page' ] ) ) ? $data['list_per_page'] : $this->listPerPage;
      $this->currentPage = ( ! empty( $data['current_page'] ) ) ? $data['current_page'] : 1;
      $pageNum = $this->currentPage;
      $pageNum -= 1;
      $this->startPage = $pageNum * $this->listPerPage;
      $this->pageLink = ( ! empty( $data['page_url'] ) ) ? $data['page_url'] : '#';
      $this->type = ( ! empty( $data['type'] ) ) ? $data['type'] : $this->type;
      $this->prevBtnText = ( ! empty( $data['prev_btn'] ) ) ? $data['prev_btn'] : $this->prevBtnText;
      $this->nextBtnText = ( ! empty( $data['next_btn'] ) ) ? $data['next_btn'] : $this->nextBtnText;
      $this->firstBtnText = ( ! empty( $data['first_btn'] ) ) ? $data['first_btn'] : $this->firstBtnText;
      $this->lastBtnText = ( ! empty( $data['last_btn'] ) ) ? $data['last_btn'] : $this->lastBtnText;
      $this->loadMoreText = ( ! empty( $data['load_more'] ) ) ? $data['load_more'] : $this->loadMoreText;
      $this->doneLoadingText = ( ! empty( $data['done_loading'] ) ) ? $data['done_loading'] : $this->doneLoadingText;
      $this->inputSpanText = ( ! empty( $data['input_text'] ) ) ? $data['input_text'] : $this->inputSpanText;

    }

    /**
    *
    * Load and initialize pagination
    *
    * @access public
    *
    **/
    public function load( $params ) {
      // Store data
      self::__construct( $params );
    }

    /**
    *
    * Display pagination in either link, list or select input
    *
    * @access public
    * @return string|bool
    * @param string $type -> Type of pagination
    *
    **/
    public function display( $type = NULL ) {
      if ( ! empty( $type ) )
        $this->type = $type;

      if ( empty( $this->totalResults ) ) {
        $this->errorMsg[] = 'No result found.';
        return FALSE;
      }

      $this->totalNumPages = ceil( $this->totalResults / $this->listPerPage );
      // $this->loop = $this->paging( $this->currentPage, $this->totalNumPages );
      $this->loop = $this->paging();

      switch ( strtolower( $this->type ) ) {
        case 'link':
          return $this->get_paging_link();
          break;
        case 'input':
          return $this->get_paging_input();
          break;
        case 'load_more':
          return $this->get_paging_load_more();
          break;
        case 'list_link':
          return $this->get_paging_list_link();
          break;
        case 'input_limit':
          return $this->get_paging_limit();
          break;
          case 'list':
        default:
          return $this->get_paging_list();
          break;
      }
    }

    /**
    *
    * Display pagination in links
    * <div>
    *   <a></a>
    * </div>
    *
    * @access private
    * @return string
    *
    **/
    private function get_paging_link() {
      $paging = '<div id="pagination">';

      // Enabling the first button link
      if ( $this->firstBtn && $this->currentPage > 1 ) {
        $paging .= '<a href="' . $this->pageLink . '?page=1" class="active"  title="' . $this->firstBtnText . '">' . $this->firstBtnText . '</a>';
      } else if ( $this->firstBtn ) {
        $paging .= '<a href="' . $this->pageLink . '?page=1" class="inactive"  title="' . $this->firstBtnText . '">' . $this->firstBtnText . '</a>';
      }

      // Enabling the previous button link
      if ( $this->prevBtn && $this->currentPage > 1 ) {
        $prev = $this->currentPage - 1;
        $paging .= '<a href="' . $this->pageLink . '?page=' . $prev . '" class="active"  title="' . $this->prevBtnText . '">' . $this->prevBtnText . '</a>';
      } else if ( $this->prevBtn ) {
        $paging .= '<a href="#" class="inactive"  title="' . $this->prevBtnText . '">' . $this->prevBtnText . '</a>';
      }

      // Enabling number button link
      for ( $i = $this->loop['start']; $i <= $this->loop['end']; $i++ ) {
        if ( $this->currentPage == $i )
          $paging .= '<a href="' . $this->pageLink . '?page=' . $i . '" class="active current"  title="Page ' . $i . '">' . $i . '</a>';
        else
          $paging .= '<a href="' . $this->pageLink . '?page=' . $i . '" class="active"  title="Page ' . $i . '">' . $i . '</a>';
      }

      // Enabling the next button link
      if ( $this->nextBtn && $this->currentPage < $this->totalNumPages ) {
        $next = $this->currentPage + 1;
        $paging .= '<a href="' . $this->pageLink . '?page=' . $next . '" class="active"  title="' . $this->nextBtnText . '">' . $this->nextBtnText . '</a>';
      } else if ( $this->nextBtn ) {
        $paging .= '<a href="#" class="inactive"  title="' . $this->nextBtnText . '">' . $this->nextBtnText . '</a>';
      }

      // Enabling the last button link
      if ( $this->lastBtn && $this->currentPage < $this->totalNumPages ) {
        $paging .= '<a href="' . $this->pageLink . '?page=' . $this->totalNumPages . '" class="active"  title="' . $this->lastBtnText . '">' . $this->lastBtnText . '</a>';
      } else if ( $this->lastBtn ) {
        $paging .= '<a href="' . $this->pageLink . '?page=' . $this->totalNumPages . '" class="inactive"  title="' . $this->lastBtnText . '">' . $this->lastBtnText . '</a>';
      }

      $paging .= '</div>';

      return $paging;

    }

    /**
    *
    * Display pagination in a single link
    * <div>
    *   <a></a>
    * </div>
    *
    * @access private
    * @return string
    *
    */
    private function get_paging_load_more() {
      $this->currentPage += $this->listPerPage;
      $paging = '<div id="pagination">';
      if ( $this->totalResults >= $this->listPerPage )
          $paging .= '<a href="'.$this->pageLink.'?load=' . $this->currentPage . '" class="active">' . $this->loadMoreText . '</a>';
      else
          $paging .= '<a href="#" class="inactive">' . $this->doneLoadingText . $this->totalNumPages . '</a>';

      $paging .= '</div>';

      return $paging;
    }

    /**
    *
    * Display pagination in select input
    * <span></span>
    *   <select>
    *     <option></option>
    *   </select>
    *
    * @access private
    * @return string
    *
    **/
    private function get_paging_input() {
      $paging = '<span class="pagination-title">' . $this->inputSpanText . '</span>';
      $paging .= '<select id="pagination" onchange="window.location=this.options[this.selectedIndex].value;return false">';

      for ( $i = $this->loop['start']; $i <= $this->loop['end']; $i++ ) {
        if ( $this->currentPage == $i )
          $paging .= '<option value="' . $this->pageLink . '?page=' . $i . '" selected="selected">' . $i . '</option>';
        else
          $paging .= '<option value="' . $this->pageLink . '?page=' . $i . '">' . $i . '</option>';
      }
      $paging .= '</select>';

      return $paging;
    }

    /**
    *
    * Display pagination limit in select input
    * <span></span>
    *   <select>
    *     <option></option>
    *   </select>
    *
    * @access private
    * @return string
    *
    **/
    private function get_paging_limit() {
      $paging = '<span class="pagination-title">' . $this->inputSpanText . '</span>';
      $paging .= '<select id="pagination" onchange="window.location=this.options[this.selectedIndex].value;return false">';

      for ( $i = $this->listPerPage; $i <= $this->totalResults; $i *= 2 ) {
        if ( $this->listPerPage == $i )
          $paging .= '<option value="' . $this->pageLink . '?page=' . $i . '" selected="selected">' . $i . '</option>';
        else
          $paging .= '<option value="' . $this->pageLink . '?page=' . $i . '">' . $i . '</option>';
      }

      $paging .= '<option value="' . $this->pageLink . '?page=' . $this->totalResults . '">All</option>';
      $paging .= '</select>';

      return $paging;
    }

    /**
    *
    * Display pagination in unorder list
    * <ul>
    *   <li></li>
    * </ul>
    *
    * @access private
    * @return string
    *
    **/
    private function get_paging_list() {
      $paging = '<ul id="pagination">';

      // Enabling the first button
      if ( $this->firstBtn && $this->currentPage > 1 ) {
        $paging .= '<li data-url="1" class="active">' . $this->firstBtnText . '</li>';
      } else if ( $this->firstBtn ){
        $paging .= '<li data-url="1" class="inactive">' . $this->firstBtnText . '</li>';
      }

      // Enabling the previous button
      if ( $this->prevBtn && $this->currentPage > 1 ) {
        $prev = $this->currentPage - 1;
        $paging .= '<li data-url="' . $prev . '" class="active">' . $this->prevBtnText . '</li>';
      } else if ( $this->prevBtn ){
        $paging .= '<li class="inactive">' . $this->prevBtnText . '</li>';
      }

      // Enabling the other buttons
      for ( $i = $this->loop['start']; $i <= $this->loop['end']; $i++ ) {
        if ( $this->currentPage == $i ) {
          $paging .= '<li data-url="' . $i . '" class="active current">' . $i . '</li>';
        } else {
          $paging .= '<li data-url="' . $i . '" class="active">' . $i . '</li>';
        }
      }

      // Enabling the next button
      if ( $this->nextBtn && $this->currentPage < $this->totalNumPages ) {
        $next = $this->currentPage + 1;
        $paging .= '<li data-url="' . $next . '" class="active">' . $this->nextBtnText . '</li>';
      } else if ( $this->nextBtn ){
        $paging .= '<li class="inactive">' . $this->nextBtnText . '</li>';
      }


      // Enabling the last button
      if ( $this->lastBtn && $this->currentPage < $this->totalNumPages ) {
        $paging .= '<li data-url="' . $this->totalNumPages . '" class="active">' . $this->lastBtnText . '</li>';
      } else if ( $this->lastBtn ){
        $paging .= '<li data-url="' . $this->totalNumPages . '" class="inactive">' . $this->lastBtnText . '</li>';
      }
      $paging .= '</ul>';

      return $paging;
    }

    /**
    *
    * Display pagination in list and links:
    * <ul>
    *   <li>
    *     <a></a>
    *   </li>
    * </ul>
    *
    * @access private
    * @return string
    *
    **/
    private function get_paging_list_link() {
      $paging = '<ul id="pagination">';

      // Enabling the first button list
      if ( $this->firstBtn && $this->currentPage > 1 ) {
        $paging .= '<li class="first"><a href="' . $this->pageLink . '?page=1" class="active" title="' . $this->firstBtnText . '">' . $this->firstBtnText . '</a></li>';
      } else if ( $this->firstBtn ) {
        $paging .= '<li class="first"><a href="' . $this->pageLink . '?page=1" class="inactive" title="' . $this->firstBtnText . '">' . $this->firstBtnText . '</a></li>';
      }

      // Enabling the previous button link
      if ( $this->prevBtn && $this->currentPage > 1 ) {
        $prev = $this->currentPage - 1;
        $paging .= '<li><a href="' . $this->pageLink . '?page=' . $prev . '" class="active" title="' . $this->prevBtnText . '">' . $this->prevBtnText . '</a></li>';
      } else if ( $this->prevBtn ) {
        $paging .= '<li><a href="#" class="inactive" title="' . $this->prevBtnText . '">' . $this->prevBtnText . '</a></li>';
      }

      // Enabling number button link
      for ( $i = $this->loop['start']; $i <= $this->loop['end']; $i++ ) {
        if ( $this->currentPage == $i )
          $paging .= '<li><a href="' . $this->pageLink . '?page=' . $i . '" class="active current" title="Page ' . $i . '">' . $i . '</a></li>';
        else
          $paging .= '<li><a href="' . $this->pageLink . '?page=' . $i . '" class="active" title="Page ' . $i . '">' . $i . '</a></li>';
      }

      // Enabling the next button link
      if ( $this->nextBtn && $this->currentPage < $this->totalNumPages ) {
        $next = $this->currentPage + 1;
        $paging .= '<li><a href="' . $this->pageLink . '?page=' . $next . '" class="active" title="' . $this->nextBtnText . '">' . $this->nextBtnText . '</a></li>';
      } else if ( $this->nextBtn ) {
        $paging .= '<li><a href="#" class="inactive" title="' . $this->nextBtnText . '">' . $this->nextBtnText . '</a></li>';
      }

      // Enabling the last button link
      if ( $this->lastBtn && $this->currentPage < $this->totalNumPages ) {
        $paging .= '<li class="last"><a href="' . $this->pageLink . '?page=' . $this->totalNumPages . '" class="active" title="' . $this->lastBtnText . '">' . $this->lastBtnText . '</a></li>';
      } else if ( $this->lastBtn ) {
        $paging .= '<li class="last"<a href="' . $this->pageLink . '?page=' . $this->totalNumPages . '" class="inactive" title="' . $this->lastBtnText . '">' . $this->lastBtnText . '</a></li>';
      }

      $paging .= '</ul>';

      return $paging;

    }

    /**
    *
    * Return paging loop for numbering display range
    *
    * @access private
    * @return array
    *
    **/
    private function paging() {
      $page = array();

      if ( $this->currentPage >= 7 ) {
        $page['start'] = $this->currentPage - 3;
        if ( $this->totalNumPages > ( $this->currentPage + 3 ) ):
          $page['end'] = $this->currentPage + 3;
        elseif ( ($this->currentPage <= $this->totalNumPages ) && ( $this->currentPage > ( $this->totalNumPages - 6 ) ) ):
          $page['start'] = $this->totalNumPages - 6;
          $page['end'] = $this->totalNumPages;
        else:
          $page['end'] = $this->totalNumPages;
        endif;
      } else {
        $page['start'] = 1;
        if ( $this->totalNumPages > 7 )
          $page['end'] = 7;
        else
          $page['end'] = $this->totalNumPages;
      }
      return $page;
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