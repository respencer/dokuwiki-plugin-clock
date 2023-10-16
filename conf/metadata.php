<?php
/**
 * @brief Configuration-manager metadata for clock plugin
 * @license:    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author:     Luis Machuca <luis.machuca@gulix.cl>
 */

$meta['clock_style']     = array('string');
$meta['helpbar']         = array('onoff');
//$meta['toolbar']         = array('onoff');
$meta['clock_infopage']  = array('string');
$meta['font_fallback']   = array('multichoice',
     '_choices'=> array('serif','sans-serif','cursive','fantasy','monospace')
     );
$meta['nojs_fallback']   = array('onoff');
