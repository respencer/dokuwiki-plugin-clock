<?php
/**
 * @file       clock/syntax.php
 * @brief      Show a clock in wikipage
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Luis Machuca Bezzaza <luis.machuca [at] gulix.cl>
 * @version    1.5
 * @date       2010-10-15
 * @link       http://www.dokuwiki.org/plugin:clock
 *
 *  This plugin's purpose is to display a clock using both 
 *  CSS and JavaScript techniques normally available.
 *  For a live test point a decent web browser to my wiki.
 *  http://ryan.gulix.cl/dw/desarrollo/
 *
 *  Greetings.
 *        - Luis Machuca Bezzaza a.k.a. 'ryan.chappelle'
 */

if(!defined('DW_LF')) define('DW_LF',"\n");
 
if(!defined('DOKU_INC')) 
define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) 
define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_clock extends DokuWiki_Syntax_Plugin {
 
    /**
     * return some info
     */
    function getInfo() {
        return array(
            'author' => 'Luis Machuca Bezzaza',
            'email'  => 'luis.machuca [at] gulix.cl',
            'date'   => '2010-10-15',
            'name'   => 'Clock Plugin',
            'desc'   => $this->getLang('descr'),
            'url'    => 'http://www.dokuwiki.org/plugin:clock',
        );
    }
 
    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }
 
    /**
     * What can we Do?
     */
    function getAllowedTypes() { 
        return array(); 
    }
 
    /**
     * Where to sort in?
     */
    function getSort(){
        return 290;
    }
 
    /**
     * What's our code layout?
     */    
    function getPType(){ 
        return 'block'; 
    }
 
    /**
     * How do we get to the lexer?
     */
    function connectTo($mode) {
         $this->Lexer->addSpecialPattern (
         '^\{\{clock\}\}$', $mode, 'plugin_clock');
 
    }
 
    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        $data= array();
        $theCS= $this->getConf('clock_style');
        $theJS= $this->getConf('nojs_fallback');
        // if 'nojs_fallback' is set, we get the time from the server
        // if 'clock_infopage' contains a link, we convert it

        /* compose the data array */
        $data['style']   = $theCS;
        $data['text']    = $theJS ? date('H:i:s') : $theCS;
        
        /* Are we ready yet? */
        return $data;
    }  
 
    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
      static $wasrendered= false;

      if ($mode == 'xhtml') {
        if (!$wasrendered) {
          $nl   = DW_LF;
          $cid  = $this->_get_clock_object_ID();
          $html = $this->_clock_createblock_html($data);
          $hbar = ($this->getConf('helpbar')) ? $this->_get_clock_helpbar() : '';
          $renderer->doc .= <<<EOF
<div id="$cid">$nl    $html $hbar$nl    </div><!-- end clock-->
EOF;
          $wasrendered= true;
          }
        else {
          $renderer->doc.= <<<EOF
<p><a href="#$cid" class="wikilink" title="Go To Clock">&#x231a; clock</a></p>
EOF;
          }
        return true;
        }
      else if ($mode == 'odt') {
        return false; // may be implemented in the future
        }
      else if ($mode == 'text') {
        if ($wasrendered) return true;
        $text= ' ['. $this->_get_clock_object_ID(). ' '. date('H:i'). '] ';
        $renderer->doc .= $text;
        $wasrendered= true;
        return true;
        }
      /* That's all about rendering that needs to be done, at the moment */
      return false;
    }

    /**
     * From this point onwards, local (helper) functions are implemented
     */

    /** 
     * @fn          dw_clock_object_ID
     * @brief       returns ID for the clock object
     *  This function sets the name used for the ID of the clock object.
     *  If you change it, you must also update the #id tags in 'style.css'.
     */
    function _get_clock_object_ID () {
      return $this->getConf('clock_id');
      }

    /**
     * @fn          dw_clock_helpbar
     * @brief       Returns the contents of the help bar
     * The helpbar is displayed only when $conf['helpbar'] is set.
     */
    private function _get_clock_helpbar () {
      $p.= '<p class="helpbar" >';
      $link= $this->getConf('clock_infopage');
      if (empty($link) ) { // point to plugin page by default
        $info= '[[doku>plugin:clock|Clock Plugin]]';
        }
      else {
        $info= "[[$link|Info]]";
        }
      $info= p_render('xhtml', p_get_instructions($info), $info);
      $info= trim(substr($info, 4, -5)); // remove <p>, </p>
      $p.= $info;
      $p.= '</p>';       
      return $p;
      }

    /**
     * @fn          _clock_createblock_html
     * @brief       Creates the HTML code for the clock object.
     */
    private function _clock_createblock_html($data) {
        $theStyle   = $data['style'];
        $theText    = $data['text'];
        $theDoLink  = $data['dolink'];
        $theTarget  = $data['target'];
        $codetext.= '<div id="clock_face" class="'. $theStyle. ' face">'. 
                    $theText. '</div>';
        return $codetext;
     }

}
