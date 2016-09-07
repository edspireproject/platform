var editIndex = undefined;
function endEditing(){
    if (editIndex == undefined){return true}
    if ($('#dg').datagrid('validateRow', editIndex)){
        $('#dg').datagrid('endEdit', editIndex);
        editIndex = undefined;
        return true;
    } else {
        return false;
    }
};
function onClickRow(index){
    if (editIndex != index){
        if (endEditing()){
            $('#dg').datagrid('selectRow', index)
                    .datagrid('beginEdit', index);
            editIndex = index;
        } else {
            $('#dg').datagrid('selectRow', editIndex);
        }
    }
};
function cancelEditing(){
    if (editIndex == undefined){return true}
    $('#dg').datagrid('cancelEdit', editIndex);
    editIndex == undefined;
    return false;
};
function downEditing(){
    if (editIndex == undefined){return true}
    var rows = $('#dg').datagrid('getRows');
    if(rows && rows.length > editIndex + 1) {
    	onClickRow(editIndex+1);
    	return false;
    }
    return endEditing();
};
function upEditing(){
    if (editIndex == undefined){return true}
    if(editIndex == 0)
    	return endEditing();
   	 onClickRow(editIndex-1);
   	 return false;
};
function onAfterEdit(index, data, changes) {
	$.each(changes, function(ix, obj) {
		 doUpdateMeta(data.id, 'wpcf-' + ix.replace('_','-'), obj);
	});
};
function doUpdateMeta(id, key, value) {
	$.post('update_meta.php', {
    	post_id: id,
    	meta_key: key,
    	meta_value: value
  	}, function(data) {
		console.log(data);
  	});
};
function updateMeta(index, $div, field, value) {
	if($div.text() == '') {
		$div.text(value);
		var id = $('#dg').datagrid('getRows')[index].id;
		var key =  'wpcf-' + field.replace('_','-');
		doUpdateMeta(id, key, value);
	}
};

function enterEditing() {
	var elms = $('#edg input[type=text]:focus');
	if(elms && elms.length) {
		return endEditing();
	} else {
		$('#edg input[type=text]').first().focus();
		return true;
	}
};

function formatLink(val,row){
    return '<a href="'+val+'" target="_blank">Link</a>';
};

function formatEdspireLink(val,row){
    return '<a href="http://edspire.com/?resource='+val+'" target="_blank">Edspire</a>';
};

$(function() {
	$(document).keydown(function(e) {
		if (e.keyCode == 13) return enterEditing();     // enter
		else if (e.keyCode == 27) return cancelEditing();   // esc
		else if (e.keyCode == 40) return downEditing(); // down
		else if (e.keyCode == 38) return upEditing(); // down
	});
	$('input#filter').click(function(e) {
		e.preventDefault();
		var newUrl = getUrl();
		$('#dg').datagrid({
	        url:newUrl 
	     });
	});
	$('button#datefix').click(function(e) {
		$('#edg .datagrid-view2 tr.datagrid-row').each(function(ix, obj) {
			var $tr = $(obj);
			var $availability = $tr.children('td[field=availability]').children();
			var $next = $tr.children('td[field=next_start]').children();
			var $duration = $tr.children('td[field=duration]').children();
			var $schedule = $tr.children('td[field=schedule]').children();
			var availability = $availability.text();
			var duration = '', schedule = '';
			if(availability != '') {
				// get rid of noise
				if(availability.indexOf('Date to be announced') > -1) {
					availability = availability.replace('Date to be announced','');
					if($next.text() == '' )
						updateMeta(ix, $schedule, 'schedule', 'w'); // waiting to be scheduled;
				} else if(availability.indexOf('There are no upcoming sessions at this time') > -1) {
					availability = availability.replace('There are no upcoming sessions at this time','');
					if($next.text() == '' )
						updateMeta(ix, $schedule, 'schedule', 'd'); // dormant - no plans to be scheduled.
				} else if(availability.indexOf('Always available') > -1) {
					availability = availability.replace('Always available','');
					if($next.text() == '' )
						updateMeta(ix, $schedule, 'schedule', 'a');
				}
				// look for a text duration
				if(availability.indexOf('(') > -1 && availability.indexOf('long') > availability.indexOf('(')) {
					duration = availability.substring(availability.indexOf('(') + 1, availability.indexOf('long')-1);
					updateMeta(ix, $duration, 'duration', duration);
					availability = availability.substring(0, availability.indexOf('(') - 1);
				} else if(availability.match(/\d+ weeks?/)) {
					duration = availability.match(/\d+ weeks?/)[0];
					updateMeta(ix, $duration, 'duration', duration);
					availability = availability.replace(/\d+ weeks?/g, '');					
				}
				//lose padding and case
				availability = $.trim(availability.toLowerCase());
				if(availability != '') {
					//console.log(availability);
					availability = availability.replace(' - ', ' to ');
					if(availability.indexOf(' to ') > -1) {
						// start and end dates?
						var sDate =  parseDate( availability.substring(0, availability.indexOf(' to ')) );
						var eDate = parseDate( availability.substring(availability.indexOf(' to ') + 4) );

						if(sDate) {
							updateMeta(ix, $next, 'next_start', sDate);
							updateMeta(ix, $schedule, 'schedule', 's');
							if(eDate) {
								var dDiff = daysDiff(eDate, sDate);
								if(dDiff < 14) {
									duration = '' + (dDiff + 1) + ' days';
								} else {
									duration = '' + (parseInt(dDiff/7,10)) + ' weeks';
								}
								updateMeta(ix, $duration, 'duration', duration);
							}
						}
						
					} else {
						// try and get a start date out of it
						var sDate = parseDate( availability );
						//console.log(sDate);
						if(sDate) {
							updateMeta(ix, $next, 'next_start', sDate);
							updateMeta(ix, $schedule, 'schedule', 's');
						}
					}
				}
				if($next.text() != '' )
					updateMeta(ix, $schedule, 'schedule', 's');
			} else if($next.text() == '' && $schedule.text() == '') {
				// special case: Coursera
				if($tr.children('td[field=provider]').children().text() == 'Coursera')
					updateMeta(ix, $schedule, 'schedule', 'd'); // dormant - no upcoming sessions
				else
					updateMeta(ix, $schedule, 'schedule', 'a'); // probably always available
			}
		});
	});
	$('button#costfix').click(function(e) {
		$('#edg .datagrid-view2 tr.datagrid-row').each(function(ix, obj) {
			var $tr = $(obj);
			var $cost = $tr.children('td[field=cost]').children();
			var $cost_cur = $tr.children('td[field=cost_cur]').children();
			var $cost_val = $tr.children('td[field=cost_val]').children();
			var $cost_sub = $tr.children('td[field=cost_sub]').children();
			var cost = $cost.text();
			var cost_val = '', cost_cur = '', cost_sub = '';
			if(cost != '') {
				if(!isNaN(cost)) {
					cost_val = parseFloat(cost).toFixed(2);
					cost_val = cost_val.replace(/\.00$/,'');
					updateMeta(ix, $cost_val, 'cost_val', cost_val);
				} else {
					var chars = cost.split('');
					var lastChar = 'B';
					for(var ixChar = 0; ixChar < cost.length; ixChar++) {
						if(isNaN(chars[ixChar])) {
							if(chars[ixChar] == ',') {
								// ignore
							} else if(chars[ixChar] == '.') {
								cost_val += '.';
							} else if(cost_val == '') {
								cost_cur += chars[ixChar];
							} else {
								cost_sub += chars[ixChar];
							}
						} else {
							cost_val += chars[ixChar];
						}
					}
				}
				if(cost_cur.toLowerCase() == 'free') {
					cost_cur = '';
					cost_val = '0';
				}
				if(cost_sub == 'pcm') {
					cost_sub = 'm';
				}
				if(cost_cur != '')
					updateMeta(ix, $cost_cur, 'cost_cur', cost_cur);
				if(cost_val != '')
					updateMeta(ix, $cost_val, 'cost_val', cost_val);
				if(cost_sub != '')
					updateMeta(ix, $cost_sub, 'cost_sub', cost_sub);
			} else {
				if($cost_val.text() == '')
					updateMeta(ix, $cost_val, 'cost_val', '0');
			}
		});
	});
	$('button#workloadfix').click(function(e) {
		$('#edg .datagrid-view2 tr.datagrid-row').each(function(ix, obj) {
			var $tr = $(obj);
			var $workload = $tr.children('td[field=workload]').children();
			var $workload_min = $tr.children('td[field=workload_min]').children();
			var $workload_max = $tr.children('td[field=workload_max]').children();
			var workload_min = '', workload_max = '', workload_last = '', workload_before_last = '';
			var workload = $workload.text();
			if(workload != '') {
				workload = workload.toLowerCase().replace(' per ', '/').replace(/hours/g,'hour');
				var terms = workload.split(' ');
				for(var ixTerm = 0; ixTerm < terms.length; ixTerm++) {
					if(terms[ixTerm].indexOf('-') > -1) {
						var hrs = terms[ixTerm].split('-');
						if(hrs.length==2) {
							workload_min = hrs[0];
							workload_max = hrs[1];
						}
					} else if(terms[ixTerm] == 'hour/week') {
						// indicates we should have parsed them;
						if(!isNaN(workload_last)) {
							if(workload_min == '')
								workload_min = workload_last;
							if(workload_max == '' && workload_before_last != 'least')
								workload_max = workload_last;
						}
						break;
					} else {
						workload_before_last = workload_last;
						workload_last = terms[ixTerm];
					}
				}
				if(workload_min != '')
					updateMeta(ix, $workload_min, 'workload_min', workload_min);
				if(workload_max != '')
					updateMeta(ix, $workload_max, 'workload_max', workload_max);
			}
			
		});
	});	
});
function daysDiff(strDate1, strDate2) {
	// correct for ending in "00";
	strDate1 = strDate1.replace(/00$/,'01');
	strDate2 = strDate2.replace(/00$/,'01');
    var datediff = Date.parse(strDate1) - Date.parse(strDate2); //store the getTime diff - or +
    return (datediff / (24*60*60*1000)); //Convert values to -/+ days and return value      
}
function parseMonth(str) {
	if( str.indexOf('jan') === 0 ) return 1;
	if( str.indexOf('feb') === 0 ) return 2;
	if( str.indexOf('mar') === 0 ) return 3;
	if( str.indexOf('apr') === 0 ) return 4;
	if( str.indexOf('may') === 0 ) return 5;
	if( str.indexOf('jun') === 0 ) return 6;
	if( str.indexOf('jul') === 0 ) return 7;
	if( str.indexOf('aug') === 0 ) return 8;
	if( str.indexOf('sep') === 0 ) return 9;
	if( str.indexOf('oct') === 0 ) return 10;
	if( str.indexOf('nov') === 0 ) return 11;
	if( str.indexOf('dec') === 0 ) return 12;
	return false;
};
function parseDay(str) {
	var test = str.replace('st','').replace('nd','').replace('rd','').replace('th','');
	if(/\d/.test(test)) {
		var num = parseInt(test, 10);
		if( num > 0 && num < 32 )
			return num;
	}
	return false;
};
function formatDate( yyyy, mm, dd ) {
	yyyy = yyyy.toString();
	mm = mm.toString();
	dd = dd.toString();
	if(yyyy.length == 2) yyyy = '20' + yyyy;
	if(mm.length == 1) mm = '0' + mm;
	if(dd.length == 1) dd = '0' + dd;
	return yyyy + '-' + mm + '-' + dd;
};
function parseDate( str ) {
	var bits = str.replace(/[^0-9A-Za-z \/-]+/g,'').split(' ');
	console.log(bits);
	var sD = -1, sM = -1, sY = -1;
	$.each(bits, function(ix, obj) {
		
		if(obj.match(/^20\d\d-(0[1-9]|1[012])-(0[0-9]|[12][0-9]|3[01])$/)) {
			// check for preparsed date in our format
			var lef = obj.split('-');
			sY = lef[0];
			sM = lef[1];
			sD = lef[2];
		} else if(obj.indexOf('/') > 1) {
			// check for an actual date
			
			// try it as a date
			if(!isNaN( Date.parse(obj) ) ) {
				var date = new Date(Date.parse(obj));
				// it's a parsed date so replace what we have
				sY = date.getFullYear();
				if(sY < 2000) sY = sY + 100;
				sM = date.getMonth()+1;
				sD = date.getDate(); 
			}
		} else {
			if(/^\d+$/.test(obj)) {
				// it's a number
				if(obj > 2000) {
					// it's a year
					if(sY == -1)
						sY = obj;
				} else if(obj < 32) {
					if(obj > 12) {
						// it's a day
						if(sD == -1)
							sD = obj;
					} else {
						// day or month
						if(sM == -1 && sD > -1)
							sM = obj;
						else if(sD == -1 && sM > -1)
							sD = obj;
						else if(sM == -1) {
							// assume US syntax and put in month first
							sM = obj;
						} else {
							// still don't know! 
							// console.log('Day or month? ' + obj);
						}
					}
				} else {
					// dunno what this is
					// console.log('Irrelevant? ' + obj);
				}
			} else if(/^\w+$/.test(obj) && ! /\_/.test(obj)) {
				if(/\d/.test(obj)) {
					// it's a mix - probably a day
					// console.log('mix? ' + obj);
					var isDay = parseDay(obj);
					if(isDay && sD == -1)
						sD = isDay;
				} else {
					// it's just letters - probably a month
					// console.log('str? ' + obj);
					var isMonth = parseMonth(obj);
					if(isMonth) {
						if(sM == -1) {
							sM = isMonth;
						} else if(sD == -1) { // we eagerly assume first digit is a month so if it's been set and day hasn't then swap them
							sD = sM;
							sM = isMonth;
						}
					}
				}
			} else {
				// dunno what this is
				// console.log('Irrelevant? ' + obj);
			}
		}
		// TODO check if we have a parsed date and put to one side to look for another one?
	});
	if(sY > -1 && sM > -1 && sD == -1)
		sD = 0;
	if(sY > -1 && sM > -1 && sD > -1) {
		return formatDate(sY, sM, sD);
	}
	return false;
};
function getUrl() {
	var base = 'get_courses.php';
	var s = $('input#custom').val();
	if(s != '') {
		base += '?field=' + $('select#field').val() + '&s=' + s; 
	}
	return base;
};
function formatTick(val,row){
	var i = parseInt(val,10);
	if(i < 0)
		return '<a class="makeajax unchecked" href="update_tax.php?post_id=' + row['id'] + '&term_id=' + i + '">☆</a>';
	else
		return '<a class="makeajax checked" href="update_tax.php?post_id=' + row['id'] + '&term_id=' + i + '">★</a>';
};
function loadSuccess(data) {
	$('.makeajax').click(function(e) {
		e.preventDefault();
		var $a = $(this);
		var href = $a.attr('href');
		if($a.hasClass('unchecked')) {
			$a.text('★');
		} else {
			$a.text('☆');
		}
		$.get(href, function(data) {
			console.log(data);
			if($a.hasClass('unchecked')) {
				$a.removeClass('unchecked').addClass('checked');
			} else {
				$a.removeClass('checked').addClass('unchecked');
			};
	  	});
	});
}
