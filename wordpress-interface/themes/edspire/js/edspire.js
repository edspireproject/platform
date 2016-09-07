function loadScriptThen(src, fn) {
	
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');
	script.type= 'text/javascript';
	script.onreadystatechange= function () {
		if (this.readyState == 'complete' && fn) fn();
	}
	script.onload = fn;
	script.src= src;
	head.appendChild(script);
};

var cb = function() {
    var l = document.createElement('link'); l.rel = 'stylesheet';
    l.href = '/wp-content/themes/edspire/css/edspire-min.css?v=1.13';
    var h = document.getElementsByTagName('head')[0]; h.appendChild(l);
};

var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;

if (raf) raf(cb);
else window.addEventListener('load', cb);

loadScriptThen('//ajax.googleapis.com/ajax/libs/webfont/1.5.3/webfont.js', function() {
	WebFont.load({
	    google: {
	      families: ['Lato:300,400'] //, 'Nothing You Could Do', 'Open Sans:300,400']
	    }
	  });
	
	loadScriptThen('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', scoped);
});

function scoped() {
	// onload function where you've got jQuery and WebFont
	window.loaded = true;
	
	window.subjects = [
	                   
	                   ];
	
	$('#i1').focus(function(e) {
		$('#l1').css('display', 'none');
	}).blur(function(e) {
		if( $('#i1').val() == '')
			$('#l1').css('display', 'inline');	
	});
	
	$('section.isCC').each(function(ix, obj) {
		$section = $(obj);
		var title = $section.attr('title');
		if(!title) return;
		var ixLink = title.indexOf('Link: ');
		var span = title.substring(0, ixLink - 2);
		var href = title.substring(ixLink + 6);
		$section.append( $('<a>').addClass('cc').attr('href', href).attr('target', '_blank').append( $('<span>').html('&nbsp; ' + span + ' &nbsp;') ) );
		$section.removeAttr('title');
	});
	
	$('.sg').each(function(ix, obj) {
		var $sg7 = $('<div>').addClass('sg7');
		$sg7.after('section.ssh');
		$(obj).addClass('sg8').appendTo('.sg7');
		var $sg9 = $('<div>').addClass('sg9');
		$sg9.appendTo('.sg7');
		// now fade them all in
		$('.sg8 .sg0').each(function(jx, obj) {
			$(obj).find('h3').addClass('fade' + jx);
			$(obj).find('h4').each(function(kx, h4) {
				$(h4).addClass('fade' + (1 + jx + kx) );
			})
		});
		$sg9.animate({opacity: 0.6}, 1000);
		$('.sg8').removeClass('sg');
		fadeSgIn(0);
	});
	
	$('#i0').each(function(ix, obj) {
		$(obj).on('blur', function() {
			var $obj = $(this);
			if($obj.val() == '') {
				$('#l0').removeClass('hidelabel');
			} else {
				$('#l0').addClass('hidelabel');
			}
		});
		$(obj).blur();
	});
	
	$('.as_ajax_post').each(function(ix, obj) {
		$(obj).on('click', function(e) {
			e.preventDefault();
			var $a = $(this);
			var parsed = getToPost($a.attr('href'));
			ajaxPost($a, parsed.url, parsed.post);
		});
	});

	function ajaxPost($elm, url, post) {
		if($elm.hasClass('thinking'))
			return;
		$elm.blur();
		$elm.addClass('thinking');
		$.ajax({
			type: "POST",
			url: url,
			data: post,
			complete: function() {
				$elm.removeClass('thinking');
			},
			success: function(data) {
				console.log(data);
				if(data.result) {
					ajaxCallback($elm, url, post, data);
				}
			},
			dataType: 'json'
		});
	}
	
	function ajaxCallback($elm, url, post, data) {
		if(post.action == 'fav') {
			$elm.addClass('unfav');
			$elm.attr('title', 'Remove this from your favourites');
			$elm.removeClass('fav');
			$elm.unbind('click').bind('click', function(e) {
				e.preventDefault();
				post.action = 'unfav';
				post.nonce = data.nonce;
				ajaxPost($elm, url, post);
			});
		} else if(post.action == 'unfav') {
			$elm.addClass('fav');
			$elm.attr('title', 'Save this to your favourites');
			$elm.removeClass('unfav');
			$elm.unbind('click').bind('click', function(e) {
				e.preventDefault();
				post.action = 'fav';
				post.nonce = data.nonce;
				ajaxPost($elm, url, post);
			});
		} else if(post.action == 'del') {
			$elm.closest('article').hide();
			$div = $('<div class="undo">').append('<span>We won\'t show you that resource again - </span>').append(
					$('<a href="#">Undo</a>').click(function(e) {
						e.preventDefault();
						post.action = 'undel';
						post.nonce = data.nonce;
						ajaxPost($elm, url, post);
					})
			);
			$elm.closest('article').before($div);
		} else if(post.action == 'undel') {
			$elm.closest('article').show();
			$elm.closest('article').siblings('div').remove();
		}
	}
	
	function getToPost(url) {
		var parsed = { url: '', post: {}};
		var s1 = url.split('?');
		parsed.url = s1[0];
		if(s1.length > 1) {
			var s2 = s1[1].split('&');
			for(var ix = 0; ix < s2.length; ix++) {
				var s3 = s2[ix].split('=');
				console.log(s3);
				if(s3.length == 2) {
					parsed.post[s3[0]] = s3[1];
				}
			}
		}
		return parsed;
	};
	
	function fadeSgIn(ix) {
		if($('.fade' + ix).length > 0) {
			$('.fade' + ix).animate({opacity: 1}, 500);
			setTimeout(function() {
				fadeSgIn(ix+1);
			}, 100);
		}
	};
	
	$('.slabs div').each(function(ix, obj) {
		var $div = $(obj);
		if($div.find('a').length > 0) {
			$div.contents().filter(function() {
				return this.nodeType == 3; //Node.TEXT_NODE
			}).remove();
			$div.find('a').addClass('hid');
			$div.find('a').each(function(jx, a) {
				var $a = $(a);
				$a.addClass('slab');
				var cls = $a.attr('href').replace(/\//g, '');
				$a.addClass('s-' + cls);
				var txt = $a.text();
				$a.text('');
				var credit = attribution[cls][1].length > 32 ? attribution[cls][1].substring(0, 32) + '...' : attribution[cls][1];
				var licence = '[' + attribution[cls][0] + '] ' + credit;
				var title = 'Licence: ' + attribution[cls][0] + '; Credit: ' + attribution[cls][1];
				$a.append( $('<span>').addClass('a').text(txt) ).append( $('<span>').addClass('b').text(' ') ).append( $('<a>').addClass('cc').attr('href', attribution[cls][2]).attr('target', '_blank').append( $('<span>').attr('title', title).html('&nbsp; ' + licence + ' &nbsp;') ) );
				$a.removeClass('hid');
			});
		}
	});
	
	var $filters = $('#ffi');
	if($filters.length > 0) {
		$.ajax({
			type: "POST",
			url: '/filters/',
			data: $filters.serialize(),
			success: function(data) {
				update_filters(data);
			},
			dataType: 'json'
		});
	}
	
	function update_filters(data) {
		$('#rys0 > div').each(function(ix, div) {
			var $div = $(div);
			var $lbl = $div.find('label');
			$lbl.html( $lbl.html() + ' <span>&nbsp;&#9656;</span>').click(function(e) {
				e.preventDefault();
				var $l = $(this);
				if($l.parent().find('ul').css('display') == 'none') {
					$l.parent().find('ul').css('display', 'block');
					$l.find('span').html('&nbsp;&#9662;')
				} else {
					$l.parent().find('ul').css('display', 'none');
					$l.find('span').html('&nbsp;&#9656;')
				}
			});
			var field = $div.attr('id').substring(1);
			var $inps = $div.find('input').add( $div.find('select') );
			var name = $inps.attr('name'); 
			if($div.find('input[type="hidden"]').length == 0) {
				var $ul = $('<ul>');
				for(var jx in data[field]) {
					var line = data[field][jx];
					var $li = $('<li>').attr('data-val',(line.id ? line.id : line.meta_value)).html( (line.meta_value == '' ? '&lt;none&gt;' : line.meta_value) + ' (' + line.cnt + ')' );
					if( line.cnt > 0 ) {
						$li.addClass('cl').click(function(e) {
							e.preventDefault();
							var $li = $(this);
							var $div = $li.closest('div');
							$div.find('input').val( $li.attr('data-val') );
							$div.closest('form').submit();
						});
					}
					$ul.append( $li );
				}
				collapse_filters($ul);
				$div.append($ul);
				$div.append( $('<input type="hidden" name="' + name + '"/>') );
				$inps.remove();
			}
		});
		$('#ffi input[type="submit"]').remove();
	};
	
	function collapse_filters($ul) {
		var topN = 7;
		var arr$Children = $ul.children('li');
		if( arr$Children.length > topN + 2) {
			// get counts for all children
			var counts={};
			var $items=[];
			for( var i=0; i<arr$Children.length; i++ ) {
				var $li=$(arr$Children[i]);
				$items.push($li);
				var count=$li.find('.cnt').text();
				counts[$li.text()]=count;
			}
			// sort and get top topN
			var $items=$items.sort(function(a,b){ return counts[b.text()]-counts[a.text()];});
			
			for( var ix = 0; ix < topN; ix++ )
				$($items[ix]).addClass('topN');

			for( var ix = topN; ix < $items.length; ix++ )
				$($items[ix]).hide();

			var $shower = $('<li><span>show ' + (arr$Children.length - topN) + ' more...</span></li>').addClass('fsm0');
			var $hider = $('<li><span>hide</span></li>').addClass('fhm0');
    		$shower.click(function() {
    			$(this).parent().children('li').not('.topN').not('.fsm0').show( 500 );
    			$(this).hide();
    			$(this).siblings('.fhm0').show();
    		});
    		$hider.click(function() {
    			$(this).parent().children('li').not('.topN').not('.fsm0').hide( 500 );
    			$(this).hide();
    			$(this).siblings('.fsm0').show();
    		});
    		$hider.hide();
    		$ul.append( $hider );
    		$ul.append( $shower );
		}
	}
};

// TODO come up with a better way than this
var attribution = {
		'humanities':['','',''],
		'history':['','',''],
		'linguistics':['','',''],
		'literature':['','',''],
		'theatre-music-dance':['','',''],
		'philosophy':['','',''],
		'religion':['','',''],
		'archaeology':['','',''],
		'anthropology':['','',''],
		'social-sciences':['','',''],
		'geography':['','',''],
		'military':['','',''],
		'environment':['','',''],
		'politics':['','',''],
		'psychology':['','',''],
		'sociology':['','',''],
		'cultural-ethnic-studies':['','',''],
		'gender-sexuality':['','',''],
		'library-museum-studies':['','',''],
		'professional':['','',''],
		'agriculture':['','',''],
		'business':['','',''],
		'education':['','',''],
		'economics':['','',''],
		'transportation':['','',''],
		'journalism-media':['','',''],
		'law':['','',''],
		'finance-accountancy':['','',''],
		'science':['','',''],
		'architecture-design':['','',''],
		'chemistry':['','',''],
		'biology':['','',''],
		'physics':['','',''],
		'computing':['','',''],
		'mathematics':['','',''],
		'statistics':['','',''],
		'earth-sciences':['','',''],
		'space-astronomy':['','',''],
		'engineering':['','',''],
		'lifestyle':['','',''],
		'cooking':['','',''],
		'sport':['','',''],
		'health':['','',''],
		'arts-crafts':['','',''],
		'hobbies':['','',''],
		'discovereducation':['','',''],
		'discoverenjoy':['','',''],
		'discoverprofessional':['','',''],
		'discoverhobbies':['','','']
};