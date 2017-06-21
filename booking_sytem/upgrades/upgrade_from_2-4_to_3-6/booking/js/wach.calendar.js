// JavaScript Document

var currentMousePos = { x: -1, y: -1 };
$(document).mousemove(function(event) {
	currentMousePos.x = event.pageX;
	currentMousePos.y = event.pageY;
});

var xhr = new Array();
function getMonthCalendar(month, year, calendar_id,recaptchakey) {
	for(var i = 0; i < xhr.length; i++) {
		xhr[i].abort();
	}
	$('#container_all').parent().prepend('<div id=\"sfondo\" class=\"modal_sfondo\"></div>');
	$('#modal_loading').fadeIn();
	xhr.push($.ajax({
	  url: 'ajax/getMonthCalendar.php?month='+month+'&year='+year+'&calendar_id='+calendar_id+'&publickey='+recaptchakey,
	  success: function(data) {
		$('#modal_loading').fadeOut();
		$('#sfondo').remove();
		$('#calendar_container').html(data);
		$('.day_white a').each(function() {
			if($(this).attr('over')==1) {
				if($(this).attr('popup') == 1) {
					$(this).bind('mouseenter', function(e) {
						
						fillSlotsPopup($(this).attr('year'),$(this).attr('month'),$(this).attr('day'),calendar_id);
						$('#box_slots').stop().fadeIn(0);
					
						$(this).css({'background-color': booking_day_white_bg_hover});
						$(this).children('div.day_number').css({'color':booking_day_white_line1_color_hover});
						$(this).children('div.day_slots').css({'color':booking_day_white_line2_color_hover});
						$(this).children('div.day_book').css({'color':booking_day_white_line1_color_hover});
					
					});
					$(this).bind('mouseleave', function() {
						
						$('#box_slots').hide();
							$(this).css({'background-color': booking_day_white_bg});
							$(this).children('div.day_number').css({'color':booking_day_white_line1_color});
							$(this).children('div.day_slots').css({'color':booking_day_white_line2_color});
							$(this).children('div.day_book').css({'color':booking_day_white_line1_color});
						
					});
					$(this).bind('mousemove',function(e) {
					
						var top;
						var left;
						 
						 pageX = e.pageX- $('#container_all').offset().left;
						 pageY = e.pageY- $('#container_all').offset().top;
						
						 if(pageX-$('#box_slots').width()<0) {
							 newpageX = 0;
						 } else if(pageX+$('#box_slots').width()>$('#container_all').width()) {
							 newpageX = pageX-$('#box_slots').width()-20;
						 } else {
							 newpageX = pageX;
						 }
						 if(pageY<0) {
							 newpageY = 0;
						 } else if(pageY+$('#box_slots').height()+20>$('#container_all').height()) {
							 newpageY = pageY-$('#box_slots').height()-40;
						 } else {
							 newpageY = pageY;
						 }
						 
						 if(newpageY+$('#container_all').offset().top < e.pageY) {
							 top=newpageY+$('#container_all').offset().top -20;
						 } else {
							 top=newpageY+$('#container_all').offset().top +20;
						 }
						 if(newpageX+$('#container_all').offset().left <e.pageX) {
							 left =newpageX+$('#container_all').offset().left -20;
						 } else {
							 left = newpageX+$('#container_all').offset().left +20;
						 }
						 
						 top = (top-$(window).scrollTop());
						 left = (left-$(window).scrollLeft());
						 if(top<0) {
							 top = pageY+40;
						 }
						 $('#box_slots').css({
							top: top+'px',
							left: left+'px'
						 });
					
					
					
					});
				}
				$(this).bind('click', function() {
					$('#box_slots').stop().fadeOut();
					getBookingForm($(this).attr('year'),$(this).attr('month'),$(this).attr('day'),calendar_id,recaptchakey);
				});
			}
		});

		$('#box_slots').resize(function() {
			
			$(this).bind('mouseleave', function() {
				$('#box_slots').hide();
				
			});
			
			var top;
			var left;
			 
			 pageX = currentMousePos.x- $('#container_all').offset().left;
			 pageY = currentMousePos.y- $('#container_all').offset().top;
			
			 if(pageX-$('#box_slots').width()<0) {
				 newpageX = 0;
			 } else if(pageX+$('#box_slots').width()>$('#container_all').width()) {
				 newpageX = pageX-$('#box_slots').width()-20;
			 } else {
				 newpageX = pageX;
			 }
			 if(pageY<0) {
				 newpageY = 0;
			 } else if(pageY+$('#box_slots').height()+20>$('#container_all').height()) {
				 newpageY = pageY-$('#box_slots').height()-40;
			 } else {
				 newpageY = pageY;
			 }
			 
			 if(newpageY+$('#container_all').offset().top < currentMousePos.y) {
				 top=newpageY+$('#container_all').offset().top -20;
			 } else {
				 top=newpageY+$('#container_all').offset().top +20;
			 }
			 if(newpageX+$('#container_all').offset().left <currentMousePos.x) {
				 left =newpageX+$('#container_all').offset().left -20;
			 } else {
				 left = newpageX+$('#container_all').offset().left +20;
			 }
			 
			top = (top-$(window).scrollTop());
			 left = (left-$(window).scrollLeft());
			 if(top<0) {
				 top = pageY+40;
			 }
			 $('#box_slots').css({
				top: top+'px',
				left: left+'px'
			 });
			
		});
	  }
	})
	);
	getMonthName(month,year);
}


function getPreviousMonth(calendar_id,recaptchakey,limit) {
	if(limit == -1) {
		 if(currentMonth == 1) {
			 newYear = currentYear-1;
			 newMonth = 12;
		 } else {
			 newYear = currentYear;
			 newMonth = currentMonth-1;
		 }
		 getMonthCalendar(newMonth,newYear,calendar_id,recaptchakey);
	} else {
		var today = new Date();
		 var year = today.getFullYear();
		 var month = today.getMonth()+1;
		 var newlimit = limit;
		/* if(month<10) {
			 month = "0"+month;
		 }
		 todaynum = ''+year+''+month;
		 */
		 if(month == 1) {
			 todaynum = ''+(year-1)+'10';
		 } else {
			 var newm = month-newlimit;
			 var newy = year;
			 if(month<10) {
				 month = "0"+month;
			 }
			 if(newm<1) {
				 newy--;
				 diff=0-newm;
				 newm=12-diff;
				 if(newm<10) {
					 newm='0'+newm;
				 }
			 } else if(newm<10) {
				 newm = "0"+newm;
			 } 
			 
			 todaynum = ''+newy+''+newm;		 
		 }	
		  
		 if(currentMonth == 1) {
			 newYear = currentYear-1;
			 newMonth = 12;
		 } else {
			 newYear = currentYear;
			 newMonth = currentMonth-1;
		 }
		 var newnumyear = newYear;
		 var newnummonth = newMonth;
		 if(newnummonth<10) {
			 newnummonth = "0"+newnummonth;
		 }
		 newnum = ''+newnumyear+''+newnummonth;
		
		 if(newnum>=todaynum) {
			getMonthCalendar(newMonth,newYear,calendar_id,recaptchakey);
		 } else {
			 getMonthCalendar(month,year,calendar_id,recaptchakey);
		 }

	}
}
function getNextMonth( calendar_id,recaptchakey, limit) {
	if(limit == -1) {
		 if(currentMonth == 12) {
			 newYear = currentYear+1;
			 newMonth = 1;
		 } else {
			 newYear = currentYear;
			 newMonth = currentMonth+1;
		 }
		 getMonthCalendar(newMonth,newYear,calendar_id,recaptchakey);
	} else {
		var today = new Date();
		 var year = today.getFullYear();
		 var month = today.getMonth()+1;
		var newlimit = limit;
		 
		 if(month == 12) {
			 todaynum = ''+(year+1)+'0'+newlimit;
		 } else {
			 var newm = ''+parseInt(month+newlimit);
			 var newy = year;
			 
			 
			 
			 if(newm<10) {
				 newm = "0"+newm;
			 } else if(newm>12) {
				 diff=newm-12;
				 newm = diff;
				 if(diff<10) {
					 newm = '0'+diff;
				 }
				 newy++;
			 }
			 todaynum = ''+newy+''+newm;
			 //alert(todaynum);		 
		 }
		 if(currentMonth == 12) {
			 newYear = currentYear+1;
			 newMonth = 1;
		 } else {
			 newYear = currentYear;
			 newMonth = currentMonth+1;
		 }
		 
		 var newnumyear = newYear;
		 var newnummonth = newMonth;
		 if(newnummonth<10) {
			 newnummonth = "0"+newnummonth;
		 }
		 newnum = ''+newnumyear+''+newnummonth;
		 if(newnum<=todaynum) {
			getMonthCalendar(newMonth,newYear,calendar_id,recaptchakey);
		 } else {
			 getMonthCalendar(month,year,calendar_id,recaptchakey);
		 }
	}
}

function fillSlotsPopup( year,month,day,calendar_id) {
	for(var i = 0; i < xhr.length; i++) {
		xhr[i].abort();
	}
	$('#slots_popup').html('<img src="images/loading.gif">');
	xhr.push($.ajax({
	  url: 'ajax/fillSlotsPopup.php?year='+year+'&month='+month+'&day='+day+'&calendar_id='+calendar_id,
	  success: function(data) {
		arrData=data.split('|');
		$('#slots_popup').html(arrData[0]);
		$('#popup_title').html(arrData[1]);
		$('#slots_popup').parent().resize();
	  }
	}));
	
}
function hideSlotsPopup() {
	$('#box_slots').fadeOut('slow');
	
}
function closeBookingPage(calendar_id,recaptchakey,year,month) {
	if(navigator.appName == 'Microsoft Internet Explorer') {
		var target = $('#booking_container');
			  var h = target.height();
				var cssHeight=target.css('height');
				target.animate( 
				{ height: '1px' }, 100, function() { 
				  target.hide();
				  target.height(h);
				  target.css('height',cssHeight);
				  
				} 
				);
		$('#calendar_container').fadeIn();
	} else {
		$('#calendar_container').slideDown();
		$('#booking_container').slideUp();
	}
	$('#month_nav').fadeIn();
	$('#calendar_select').fadeIn();
	$('#calendar_select_label').fadeIn();
	$('#category_select').fadeIn();
	$('#category_select_label').fadeIn();
	$('#name_days_container').fadeIn();
	var today= new Date();
	if(month>-1 && year>0) {
		getMonthCalendar(month,year,calendar_id,recaptchakey);
	} else {
		getMonthCalendar((today.getMonth()+1),today.getFullYear(),calendar_id,recaptchakey);
	}
	
	
}

function hideResponse(calendar_id,recaptchakey,year,month) {
	$('#modal_response').fadeOut('slow');
	$('#sfondo').remove();
	document.forms[0].reset();
	closeBookingPage(calendar_id,recaptchakey,year,month);
}

function getBookingForm(year,month,day,calendar_id,recaptchakey) {
	for(var i = 0; i < xhr.length; i++) {
		xhr[i].abort();
	}
	$('#container_all').parent().prepend('<div id=\"sfondo\" class=\"modal_sfondo\"></div>');
	$('#modal_loading').fadeIn();
	xhr.push($.ajax({
	  url: 'ajax/getBookingForm.php?year='+year+'&month='+month+'&day='+day+'&calendar_id='+calendar_id,
	  success: function(data) {
		  $('#modal_loading').fadeOut();
		  $('#sfondo').remove();		  
		  if(navigator.appName == 'Microsoft Internet Explorer') {
			  var target = $('#calendar_container');
			  var h = target.height();
				var cssHeight=target.css('height');
				target.animate( 
				{ height: '1px' }, 100, function() { 
				  target.hide();
				  target.height(h);
				  target.css('height',cssHeight);
				} 
				);
			
			  $('#booking_container').fadeIn();
		  } else {
			  $('#calendar_container').slideUp();
			  $('#booking_container').slideDown();
		  }
		 
		  
		  dataArr=data.split('|');
		 
		  $('#slot_form').html(dataArr[0]);
		  if(dataArr[1] == 1) {
			  $('#prev').html('');
			  $('#next').html('<a href=\"#\"></a>');
		  } 
		  $('#month_nav').fadeOut();
		  $('#calendar_select').fadeOut();
		  $('#calendar_select_label').fadeOut();
		  $('#category_select').fadeOut();
		  $('#category_select_label').fadeOut();
		  $('#name_days_container').fadeOut();
		  $('#captcha_error').fadeOut();
		  if(recaptchakey != '') {
			  Recaptcha.create(recaptchakey,
				'captcha',
				{
				  theme: booking_recaptcha_style,
				  callback: function() { 
					$('#recaptcha_response_field').attr('tmt:required','true');
					$('#recaptcha_response_field').attr('tmt:message',dataArr[2]);
				  }
				});
		  }
			
			
	  }
	}));
}
