<?php

use dokuwiki\Extension\SyntaxPlugin;
use dokuwiki\Extension\PluginInterface;

/**
 * Clock Plugin: Show a clock in wikipages
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Luis Machuca Bezzaza <luis.machuca [at] gulix.cl>
 */

class syntax_plugin_clock extends SyntaxPlugin
{
    /**
     * What kind of syntax are we?
     */
    public function getType()
    {
        return 'substition';
    }

    /**
     * Where to sort in?
     */
    public function getSort()
    {
        return 290;
    }

    /**
     * What's our code layout?
     */
    public function getPType()
    {
        return 'block';
    }

    /**
     * How do we get to the lexer?
     */
    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern('^\{\{clock\}\}$', $mode, 'plugin_clock');

    }

    /**
     * Handle the match
     *
     * @param   string $match         The text matched by the patterns
     * @param   int $state            The lexer state for the match
     * @param   int $pos              The character position of the matched text
     * @param   Doku_Handler $handler The Doku_Handler object
     * @return  array                 Return an array with all data you want to use in render
     */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
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
     *
     * @param   string $format          String output format being rendered
     * @param   Doku_Renderer $renderer The current renderer object
     * @param   array $data             Data created by handler()
     * @return  boolean                 Rendered correctly?
     */
    public function render($format, Doku_Renderer $renderer, $data)
    {
        static $wasrendered= false;

        if ($format == 'xhtml') {
          if (!$wasrendered) {
            $cid  = $this->_get_clock_object_ID();
            $html = $this->_clock_createblock_html($data);
            $hbar = ($this->getConf('helpbar')) ? $this->_get_clock_helpbar() : '';
            $renderer->doc .= <<<EOF
<div id="$cid">
    $html $hbar
</div><!-- end clock-->
EOF;
            $wasrendered= true;
          } else {
            $renderer->doc .= <<<EOF
<p><a href="#$cid" class="wikilink" title="Go To Clock">&#x231a; clock</a></p>
EOF;
          }
          return true;
        } elseif ($format == 'odt') {
          return false; // may be implemented in the future
        } elseif ($format == 'text') {
          if ($wasrendered) return true;
          $text = ' [' . $this->_get_clock_object_ID() . ' ' . date('H:i') . '] ';
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
     * Returns ID for the clock object
     *
     * This function sets the name used for the ID of the clock object.
     * If you change it, you must also update the #id tags in 'style.css'.
     */
    private function _get_clock_object_ID()
    {
        return $this->getConf('clock_id');
    }

    /**
     * Returns the contents of the help bar
     *
     * The helpbar is displayed only when $conf['helpbar'] is set.
     */
    private function _get_clock_helpbar()
    {
        $p .= '<p class="helpbar" >';
        $link = $this->getConf('clock_infopage');
        if (empty($link)) { // point to plugin page by default
          $info= '[[doku>plugin:clock|Clock Plugin]]';
        } else {
          $info= "[[$link|Info]]";
        }
        $info= p_render('xhtml', p_get_instructions($info), $info);
        $info= trim(substr($info, 4, -5)); // remove <p>, </p>
        $p .= $info;
        $p .= '</p>';
        return $p;
    }

    /**
     * Creates the HTML code for the clock object
     *
     * @param  array $data  Data created by handler()
     */
    private function _clock_createblock_html($data)
    {
        $theStyle  = $data['style'];
        $theText   = $data['text'];
        $theDoLink = $data['dolink'];
        $theTarget = $data['target'];
        $codetext .= '<div id="clock_face" class="'. $theStyle . ' face">' . $theText . '</div>';
        return $codetext;
    }

}

