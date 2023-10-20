/**
 * @file       clock/script.js
 * @brief      Javascript for the Clock Plugin
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Luis Machuca Bezzaza <luis.machuca [at] gulix.cl>
 * @version    1.5
 * @date       2010-10-15
 * @link       http://www.dokuwiki.org/plugin:clock
 */

// id of the clock face. DONT CHANGE THIS UNLESS YOU KNOW WHAT YOU ARE DOING!
var jsclock_id= "clock_face";

if(!document.getElementById("dw__editform")) {
var dwClockTimer = new dwclock_(); // timer object
var dwClockDOMObject; // DOM container
}

/** 
 * @fn     dwClock
 * @brief  Constructs the timer used by the plugin
 */
function dwclock_ () {
  this.hh = 0;
  this.uh = 0;
  this.mm = 0;
  this.ss = 0;
  this.update = dwclock_update;
  }

/**
 * @fn    dwclock_update
 * @brief Updates the clock data
 */
function dwclock_update () {

  // tick the clock
  var cT  = new Date();
  var Ahh = cT.getHours();
  var Amm = cT.getMinutes();
  var Ass = cT.getSeconds();

  // format it as ISO 8601 text
  if (Ahh<=9 && Ahh>=0) Ahh= "0" + Ahh;
  if (Amm<=9 && Amm>=0) Amm= "0" + Amm;
  if (Ass<=9 && Ass>=0) Ass= "0" + Ass;
  timetext= " " + Ahh + ":" + Amm + ":" + Ass + " ";

  // assign text to element with id as 'jsclock_id' variable
  dwClockDOMObject.innerHTML= timetext;
  }

/**
 * @fn    dwclock_update
 * @brief Ticks the clock
 */
function dwclock_tick () {
  dwClockTimer.update();
  setTimeout(dwclock_tick, 500);
  }

jQuery( function() {
  if(document.getElementById("dw__editform")) { return; }
  dwClockDOMObject = jQuery('#' + jsclock_id)[0];
  } );

jQuery( function() {
  if(document.getElementById("dw__editform")) { return; }
  dwclock_tick();
  } );

// end of clock/script.js

