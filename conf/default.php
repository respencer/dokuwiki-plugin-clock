<?php
/**
 * @brief Default configuration for clock plugin
 * @license:    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author:     Luis Machuca Bezzaza <luis.machuca [at] gulix.cl>
 */

/* default clock object ID 
  Note 1: this can't be changed from Config Manager
  Note 2: if you change this value, you must change the IDs for 
          the CSS styles as well! (Javascript will update itself)
 */
$conf['clock_id']        = 'dw_clock_object';
/* clock_style: base CSS style used */
$conf['clock_style']     = 'default';
/* helpbar: controls whether the helpbar will be visible */
$conf['helpbar']         = 1;
/* toolbar: controls whether the toolbar will be visible - not yet used! */
$conf['toolbar']         = 0;
/* clock_infopage: wikilink for helpbar (the official plugin page if empty) */
$conf['clock_infopage']  = ':wiki:clock';
/* nojs_fallback: behaviour when JavaScript is not enabled */
$conf['nojs_fallback']   = 0;
/* font_fallback: fallback CSS family for clock font 
   (this property is currently unused) */
$conf['font_fallback']   = 'monospace';
