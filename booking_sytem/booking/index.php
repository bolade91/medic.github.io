<?php 
/******************************************************/
/******** SECTION 1 TO EMBED AT THE TOP OF YOUR PAGE **/
/******************************************************/
include 'common.php';

$publickey = "";
if($settingObj->getRecaptchaEnabled() == "1") {
	require_once('include/recaptchalib.php');
	$publickey = $settingObj->getRecaptchaPublicKey();
}
//$publickey = $settingObj->getRecaptchaPublicKey();

if((!isset($_GET["calendar_id"]) || $_GET["calendar_id"] == 0) && (!isset($_GET["category_id"]) || $_GET["category_id"] == 0)) {
	//get default category and default calendar of the category
	$categoryObj->getDefaultCategory();
	$calendarObj->getDefaultCalendar($categoryObj->getCategoryId());
} else if(isset($_GET["calendar_id"]) && $_GET["calendar_id"] > 0) {
	$calendarObj->setCalendar($_GET["calendar_id"]);
	$categoryObj->setCategory($calendarObj->getCalendarCategoryId());
} else if(isset($_GET["category_id"]) && $_GET["category_id"]>0) {
	$categoryObj->setCategory($_GET["category_id"]);
	$calendarObj->getDefaultCalendar($categoryObj->getCategoryId());
}

/**************************/
/******** END SECTION 1 ***/
/**************************/
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<?php
/******************************************************/
/******** SECTION 2 TO EMBED IN HEAD TAG OF YOUR PAGE */
/******************************************************/
?>
<title><?php echo $settingObj->getPageTitle(); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
if($settingObj->getMetatagTitle() != '') {
	?>
	<meta content="<?php echo $settingObj->getMetatagTitle(); ?>" name="title">
	<?php
}
if($settingObj->getMetatagDescription() != '') {
	?>
	<meta content="<?php echo $settingObj->getMetatagDescription(); ?>" name="description">
	<?php
}
if($settingObj->getMetatagKeywords() != '') {
	?>
	<meta content="<?php echo $settingObj->getMetatagKeywords(); ?>" name="keywords">
	<?php
}
?>

<link rel="icon" href="favicon.ico" />
<link rel="stylesheet" href="font/font-awesome/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="css/mainstyle.css" type="text/css" />

<?php
if(stripos($_SERVER['HTTP_USER_AGENT'],"iPhone")>-1 || stripos($_SERVER['HTTP_USER_AGENT'],"iPad")>-1 || stripos($_SERVER['HTTP_USER_AGENT'],"iPod")>-1) {
	?>
    <link rel="stylesheet" href="css/style_mobile.css" type="text/css" />
    <?php
}
?>
<!--[if IE 7]>
<link rel="stylesheet" href="css/ie.min.css" type="text/css" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" href="css/ie.min.css" type="text/css" />
<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" href="css/ie.min.css" type="text/css" />
<![endif]-->



<?php
if($settingObj->getRecaptchaEnabled() == "1") {
	?>
	<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
    <?php
}
?>
<script language="javascript" type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.bxSlider.min.js"></script>
<script language="javascript" type="text/javascript" src="js/tmt_libs/tmt_core.js"></script>
<script language="javascript" type="text/javascript" src="js/tmt_libs/tmt_form.js"></script>
<script language="javascript" type="text/javascript" src="js/tmt_libs/tmt_validator.js"></script>
<script language="javascript" type="text/javascript" src="js/wach.calendar.js"></script>
<script language="javascript" type="text/javascript" src="js/lib.min.js"></script>
<style>
    *:not(.fa),
    .font_custom,
    body,
    h1 {
        <?php echo str_replace(";","",$settingObj->getGoogleFontCssCode()); ?> !important;
    }
	.month_navigation_button_custom {
        background-color:<?php echo $settingObj->getMonthNavigationButtonBg(); ?> !important;
        color: <?php echo $settingObj->getMonthNavigationButtonColor(); ?> !important;
	}
    .month_navigation_button_custom:hover {
        background-color:<?php echo $settingObj->getMonthNavigationButtonBgHover(); ?> !important;
        color:<?php echo $settingObj->getMonthNavigationButtonColorHover(); ?> !important;
    }
    .month_container_custom {
        background-color:<?php echo $settingObj->getMonthContainerBg(); ?> !important;
    }
    .month_name_custom {
        color: <?php echo $settingObj->getMonthNameColor(); ?> !important;
    }
    .year_name_custom {
        color: <?php echo $settingObj->getYearNameColor(); ?> !important;
    }
    .weekdays_container_custom {
        background-color: <?php echo $settingObj->getDayNamesBg(); ?> !important;
    }
    .weekdays_custom {
        color: <?php echo $settingObj->getDayNamesColor(); ?> !important;
    }
    .field_input_custom {
        background-color: <?php echo $settingObj->getFieldInputBg(); ?> !important;
        color: <?php echo $settingObj->getFieldInputColor(); ?> !important;
    }
    .book_now_custom {
        background-color: <?php echo $settingObj->getBookNowButtonBg(); ?> !important;
        color: <?php echo $settingObj->getBookNowButtonColor(); ?> !important;
    }
    .book_now_custom:hover {
        background-color: <?php echo $settingObj->getBookNowButtonBgHover(); ?> !important;
        color: <?php echo $settingObj->getBookNowButtonColorHover(); ?> !important;
    }
    .clear_custom {
        background-color: <?php echo $settingObj->getClearButtonBg(); ?> !important;
        color: <?php echo $settingObj->getClearButtonColor(); ?> !important;
    }
    .clear_custom:hover {
        background-color: <?php echo $settingObj->getClearButtonBgHover(); ?> !important;
        color: <?php echo $settingObj->getClearButtonColorHover(); ?> !important;
    }
    .day_container_custom a {
        border: 1px <?php echo $settingObj->getDayBorder(); ?> #ccc !important;
    }
</style>
<?php
/**************************/
/******** END SECTION 2 ***/
/**************************/
?>
</head>

<body>
<?php
/******************************************************/
/******** SECTION 3 TO EMBED IN BODY TAG OF YOUR PAGE */
/******************************************************/
?>
<!-- ===============================================================
	js
================================================================ -->

<script language="javascript" type="text/javascript">
	var currentMonth;
	var currentYear;
	var pageX;
	var pageY;
	var today= new Date();
	<?php 
	if($settingObj->getShowFirstFilledMonth() == 0) {
		?>
		var newday= new Date();
		<?php
	} else {
		?>
		var newday = new Date(<?php echo $calendarObj->getFirstFilledMonth($calendarObj->getCalendarId()); ?>);
		<?php
	}
	?>
	
	var booking_day_white_bg = '<?php echo $settingObj->getDayWhiteBg(); ?>';
	var booking_day_white_bg_hover = '<?php echo $settingObj->getDayWhiteBgHover(); ?>';
	var booking_day_white_line1_color = '<?php echo $settingObj->getDayWhiteLine1Color(); ?>';
	var booking_day_white_line1_color_hover = '<?php echo $settingObj->getDayWhiteLine1ColorHover(); ?>';
	var booking_day_white_line2_color = '<?php echo $settingObj->getDayWhiteLine2Color(); ?>';
	var booking_day_white_line2_color_hover = '<?php echo $settingObj->getDayWhiteLine2ColorHover(); ?>';
    var booking_day_white_line2_bg = '<?php echo $settingObj->getDayWhiteLine2Bg(); ?>';
    var booking_day_white_line2_bg_hover = '<?php echo $settingObj->getDayWhiteLine2BgHover(); ?>';
	var booking_recaptcha_style = '<?php echo $settingObj->getRecaptchaStyle(); ?>';
	
	$(function() {
		$('#back_today').fadeOut(0);
		getMonthCalendar((newday.getMonth()+1),newday.getFullYear(),'<?php echo $calendarObj->getCalendarId(); ?>','<?php echo $publickey; ?>');
		<?php
		if($settingObj->getRecaptchaEnabled() == "1") {
			?>
			Recaptcha.create("<?php echo $publickey; ?>",
				"captcha",
				{
				  theme: "<?php echo $settingObj->getRecaptchaStyle();?>",
				  callback: Recaptcha.focus_response_field
				}
		   );	
	  <?php
		}
		?>
        //check all months days
        setWeekdays();
        $(window).on('resize', function(){
            setWeekdays();
        });
	});

    function setWeekdays() {
        $('.day_name').each(function() {
            console.log($(this).width());
            if($(this).width() < 70){
                $(this).html($(this).data('abbr'));
            } else {
                $(this).html($(this).data('full'));
            }
        });
    }
	
	function getMonthName(month,year) {
		var m = new Array();
		m[0] ="<?php echo addslashes($langObj->getLabel("JANUARY")); ?>";
		m[1] ="<?php echo addslashes($langObj->getLabel("FEBRUARY")); ?>";
		m[2] ="<?php echo addslashes($langObj->getLabel("MARCH")); ?>";
		m[3] ="<?php echo addslashes($langObj->getLabel("APRIL")); ?>";
		m[4] ="<?php echo addslashes($langObj->getLabel("MAY")); ?>";
		m[5] ="<?php echo addslashes($langObj->getLabel("JUNE")); ?>";
		m[6] ="<?php echo addslashes($langObj->getLabel("JULY")); ?>";
		m[7] ="<?php echo addslashes($langObj->getLabel("AUGUST")); ?>";
		m[8] ="<?php echo addslashes($langObj->getLabel("SEPTEMBER")); ?>";
		m[9] ="<?php echo addslashes($langObj->getLabel("OCTOBER")); ?>";
		m[10] ="<?php echo addslashes($langObj->getLabel("NOVEMBER")); ?>";
		m[11] ="<?php echo addslashes($langObj->getLabel("DECEMBER")); ?>";
        $('#month_name').html(m[(month-1)]+'<span class="year_name_custom month_year margin_l_10">'+year+'</span>');
        currentYear = year;
		currentMonth = month;
		
		if((today.getMonth()+1)!=(month)) {
			$('#back_today').fadeIn();
		} else {
			$('#back_today').fadeOut(0);
		}
	}
	
	
	function showResponse(calendar_id) {
		$('#container_all').parent().prepend('<div id="sfondo" class="modal_sfondo" onclick="hideResponse('+calendar_id+',\'<?php echo $publickey; ?>\','+newday.getFullYear()+','+(newday.getMonth()+1)+')"></div>');
		$('#ok_response').attr("href","javascript:hideResponse("+calendar_id+",'<?php echo $publickey; ?>',"+newday.getFullYear()+","+(newday.getMonth()+1)+");");
		$('#modal_response').fadeIn('slow');
		$('#submit_button').removeAttr("disabled");
	}
	
	function showCaptchaError() {
		$('#captcha_error').fadeIn();
		$('#submit_button').removeAttr("disabled");
	}
	
	function clearForm() {
		var formObj = document.forms[0];
		<?php
		if(in_array("reservation_name",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_name.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_surname",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_surname.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_email",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_email.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_phone",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_phone.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_message",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_message.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_field1",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_field1.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_field2",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_field2.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_field3",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_field3.value='';
			<?php
		}
		?>
		<?php
		if(in_array("reservation_field4",$settingObj->getVisibleFields())) { 
			?>
			formObj.reservation_field4.value='';
			<?php
		}
		?>
		
		$('#captcha_error').fadeOut();
	}
	
	function updateCalendarSelect(category) {
		$.ajax({
		  url: 'ajax/getCalendarsList.php?category_id='+category,
		  success: function(data) {
			  arrData = data.split('|');
			  $('#calendar_select_input').html(arrData[0]);
			  $("#calendar_select_input").val($("#calendar_select_input option:first").val());
			  <?php 
			if($settingObj->getShowFirstFilledMonth() == 0) {
				?>
				var newday= today;
				<?php
			} else {
				?>
				monthData = arrData[2].split(",");
				var newday = new Date(monthData[0],monthData[1],monthData[2]);
				
				<?php
			}
			?>
			$('#calendar_id').val($("#calendar_select_input option:first").val());
			 getMonthCalendar((newday.getMonth()+1),newday.getFullYear(),arrData[1],'<?php echo $publickey; ?>');
		  }
		});
	}
	function updateCalendar(calendar_id) {
		$.ajax({
		  url: 'ajax/getCalendar.php?calendar_id='+calendar_id,
		  success: function(data) {
			  
			  <?php 
			if($settingObj->getShowFirstFilledMonth() == 0) {
				?>
				var newday= today;
				<?php
			} else {
				?>
				
				monthData = data.split(",");
				var newday = new Date(monthData[0],monthData[1],monthData[2]);
				
				<?php
			}
			?>
			$('#calendar_id').val(calendar_id);
			 getMonthCalendar((newday.getMonth()+1),newday.getFullYear(),calendar_id,'<?php echo $publickey; ?>');
		  }
		});
		
	}
	<?php
	if($settingObj->getPaypal() == 1 && $settingObj->getPaypalAccount()!='' && $settingObj->getPaypalCurrency()!='' && $settingObj->getPaypalLocale() != '') {
		?>
		$(function() {
			$('#submit_button').bind('click',function() {
				paypalSubmit();
			});
		});
		function addToPaypalForm() {

			
		}
		
		function paypalSubmit() {

			if(tmt.validator.validateForm("slot_reservation")) {
                if($('#slots_purchased').html().trim()!='') {
					$('#slot_reservation').submit();
				} else {
					//$('#with_paypal').remove();
					document.forms["slot_reservation"].submit();
				}
			} 
		}
		function submitPaypal() {
			$('#container_all').parent().prepend('<div id="sfondo" class="modal_sfondo"></div>');
			$('#modal_loading').fadeIn();
			document.forms["paypal_form"].submit();
		}
		<?php
	}
	?>
	
</script>

<!-- ===============================================================
	box preview available time slots
================================================================ -->
<div class="box_preview_container_all" id="box_slots" style="display:none">
    <div class="box_preview_title" id="popup_title"><?php echo $calendarObj->getCalendarTitle(); ?></div>
    <div class="box_preview_slots_container" id="slots_popup">
        
    </div>
</div>

<!-- ===============================================================
	booking calendar begins here
================================================================ -->
<div class="main_container" id="container_all">
    <a name="calendar"></a>
    <!-- =======================================
    	header (month + navigation + select)
	======================================== -->
   
	<div class="header_container">
        <div class="select_calendar_container">
            <?php
            if($settingObj->getShowCategorySelection() == 1 && (!isset($_GET["calendar_id"]) || $_GET["calendar_id"] == 0) && (!isset($_GET["category_id"]) || $_GET["category_id"] == 0)) {
                ?>
                <!-- select calendar -->

                <div class="float_left font_13" id="category_select_label"><?php echo $langObj->getLabel("SELECT_CATEGORY"); ?></div>
                <!-- select -->
                <div class="float_right margin_b_10" id="category_select">
                    <?php
                    $arrayCategories = $listObj->getCategoriesList('ORDER BY category_order');
                    if(count($arrayCategories) > 0) {
                        ?>
                        <select name="category" onchange="javascript:updateCalendarSelect(this.options[this.selectedIndex].value);">
                            <?php
                            foreach($arrayCategories as $categoryId => $category) {
                                ?>
                                <option value="<?php echo $categoryId; ?>" <?php if($categoryId == $categoryObj->getCategoryId()) { echo 'selected="selected"'; }?>><?php echo $category["category_name"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php
                    }
                    ?>
                </div>

                <div class="cleardiv"></div>


            <?php
            }
            ?>

            <?php
            if($settingObj->getShowCalendarSelection() == 1 && (!isset($_GET["calendar_id"]) || $_GET["calendar_id"] == 0)) {
                ?>
                <!-- select calendar -->
                <!-- select message -->
                <div class="float_left font_13 margin_r_10" id="calendar_select_label"><?php echo $langObj->getLabel("SELECT_CALENDAR"); ?></div>
                <!-- select -->
                <div class="float_left" id="calendar_select">
                    <?php

                    $arrayCalendars = $listObj->getCalendarsList('ORDER BY calendar_order',$categoryObj->getCategoryId());
                    if(count($arrayCalendars) > 0) {
                        ?>
                        <select name="calendar" id="calendar_select_input" onchange="javascript:updateCalendar(this.options[this.selectedIndex].value);">
                            <?php
                            foreach($arrayCalendars as $calendarId => $calendar) {
                                ?>
                                <option value="<?php echo $calendarId; ?>" <?php if($calendarId == $calendarObj->getCalendarId()) { echo "selected"; }?>><?php echo $calendar["calendar_title"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php
                    }
                    ?>
                </div>

                <div class="cleardiv"></div>




            <?php
            }
            ?>
        </div>
        <div class="cleardiv"></div>
    	<!-- month and navigation -->
        <div class="month_container_all month_container_custom">
            <!-- previous month -->
            <div class="mont_nav_button_container_prev" id="month_nav_prev"><a href="javascript:getPreviousMonth(<?php echo $calendarObj->getCalendarId(); ?>,'<?php echo $publickey; ?>',<?php echo $settingObj->getCalendarMonthLimitPast(); ?>);" class="month_nav_button month_navigation_button_custom"><</a></div>

            <!-- month -->
            <div class="month_container">
                <div class="font_custom month_name month_name_custom" id="month_name"></div>
                <div class="cleardiv"></div>
                <div class="back_today" id="back_today"><a href="javascript:getMonthCalendar((today.getMonth()+1),today.getFullYear(),'<?php echo $calendarObj->getCalendarId(); ?>','<?php echo $publickey; ?>');"><?php echo $langObj->getLabel("BACK_TODAY"); ?></a></div>
            </div>

            <!-- next month -->
            <div class="mont_nav_button_container_next" id="month_nav_next"><a href="javascript:getNextMonth(<?php echo $calendarObj->getCalendarId(); ?>,'<?php echo $publickey; ?>',<?php echo $settingObj->getCalendarMonthLimitFuture(); ?>);" class="month_nav_button month_navigation_button_custom">></a></div>

            <!-- navigation -->
            <div class="month_nav_container" id="month_nav">


            </div>
            <div class="cleardiv"></div>

        </div>

        
    </div>
    
    <div class="cleardiv"></div>
    
    <!-- =======================================
    	calendar
	======================================== -->
    <div class="calendar_container_all">
        <!-- days name -->
        <div class="name_days_container weekdays_container_custom" id="name_days_container">
            <?php
            if($settingObj->getDateFormat() == "UK" || $settingObj->getDateFormat() == "EU") {
                ?>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("MON"); ?>" data-full="<?php echo $langObj->getLabel("MONDAY"); ?>"><?php echo $langObj->getLabel("MONDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("TUE"); ?>" data-full="<?php echo $langObj->getLabel("TUESDAY"); ?>"><?php echo $langObj->getLabel("TUESDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("WED"); ?>" data-full="<?php echo $langObj->getLabel("WEDNESDAY"); ?>"><?php echo $langObj->getLabel("WEDNESDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("THU"); ?>" data-full="<?php echo $langObj->getLabel("THURSDAY"); ?>"><?php echo $langObj->getLabel("THURSDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("FRI"); ?>" data-full="<?php echo $langObj->getLabel("FRIDAY"); ?>"><?php echo $langObj->getLabel("FRIDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("SAT"); ?>" data-full="<?php echo $langObj->getLabel("SATURDAY"); ?>"><?php echo $langObj->getLabel("SATURDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("SUN"); ?>" data-full="<?php echo $langObj->getLabel("SUNDAY"); ?>" style="margin-right: 0px;"><?php echo $langObj->getLabel("SUNDAY"); ?></div>
            <?php
            } else {
                ?>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("SUN"); ?>" data-full="<?php echo $langObj->getLabel("SUNDAY"); ?>"><?php echo $langObj->getLabel("SUNDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("MON"); ?>" data-full="<?php echo $langObj->getLabel("MONDAY"); ?>"><?php echo $langObj->getLabel("MONDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("TUE"); ?>" data-full="<?php echo $langObj->getLabel("TUESDAY"); ?>"><?php echo $langObj->getLabel("TUESDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("WED"); ?>" data-full="<?php echo $langObj->getLabel("WEDNESDAY"); ?>"><?php echo $langObj->getLabel("WEDNESDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("THU"); ?>" data-full="<?php echo $langObj->getLabel("THURSDAY"); ?>"><?php echo $langObj->getLabel("THURSDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("FRI"); ?>" data-full="<?php echo $langObj->getLabel("FRIDAY"); ?>"><?php echo $langObj->getLabel("FRIDAY"); ?></div>
                <div class="font_custom day_name weekdays_custom" data-abbr="<?php echo $langObj->getLabel("SAT"); ?>" data-full="<?php echo $langObj->getLabel("SATURDAY"); ?>" style="margin-right: 0px;"><?php echo $langObj->getLabel("SATURDAY"); ?></div>
            <?php
            }
            ?>
        </div>

        <!-- days -->
        <div class="days_container_all" id="calendar_container">
            <!-- content by js -->
        </div>
        <div class="cleardiv"></div>
    </div>

    
    <!-- =======================================
    	booking form. It appears once user clicked on a day
	======================================== -->
    <form name="slot_reservation" id="slot_reservation" action="ajax/doReservation.php" method="post" target="iframe_submit" tmt:validate="true">
    <div id="booking_container" style="display:none">
        <div class="width_100p margin_t_30">
            <div id="slot_form">

            </div>
            <input type="hidden" name="calendar_id" id="calendar_id" value="<?php echo $calendarObj->getCalendarId(); ?>" />
            <!-- rightside -->
            <div class="bg_567 mark_fff padding_10 margin_t_20" style="background-color:<?php echo $settingObj->getFormBg(); ?>;color:<?php echo $settingObj->getFormColor(); ?>">
                <?php
                if(in_array("reservation_name",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- name -->

                        <?php
                        if($settingObj->getReservationFieldType('reservation_name') == 'text') {
                            ?>
                            <div class="form_input_container">
                                <div><?php echo $langObj->getLabel("INDEX_NAME"); ?></div>
                                <input type="text" name="reservation_name" id="reservation_name" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_name",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_NAME_ALERT").'"'; }?> value=""/>
                            </div>
                            <?php
                        } else if($settingObj->getReservationFieldType('reservation_name') == 'textarea') {
                            ?>
                            <div class="form_textarea_container">
                                <div><?php echo $langObj->getLabel("INDEX_NAME"); ?></div>
                                <textarea name="reservation_name" id="reservation_name" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_name",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_NAME_ALERT").'"'; }?>></textarea>
                            </div>
                            <?php
                        }
                        ?>

                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_name" value="" />
                    <?php
                }
                if(in_array("reservation_surname",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- surname -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_surname') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_SURNAME"); ?></div>
                                    <input type="text" name="reservation_surname" id="reservation_surname" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_surname",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_SURNAME_ALERT").'"'; }?> value=""/>
                                </div>
                                <?php
                            } else if($settingObj->getReservationFieldType('reservation_surname') == 'textarea') {
                                ?>
                                <div class="float_left margin_r_2p width_98p">
                                    <div><?php echo $langObj->getLabel("INDEX_SURNAME"); ?></div>
                                    <textarea name="reservation_surname" id="reservation_surname" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_surname",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_SURNAME_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>


                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_surname" value="" />
                    <?php
                }
                if(in_array("reservation_email",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- name -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_email') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_EMAIL"); ?></div>
                                    <input type="text"  name="reservation_email" id="reservation_email" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_email",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:pattern="email" tmt:message="'.$langObj->getLabel("INDEX_EMAIL_ALERT").'"'; }?> value=""/>
                                </div>
                                <?php
                            } else if($settingObj->getReservationFieldType('reservation_email') == 'textarea') {
                                ?>
                                <div class="float_left margin_r_2p width_98p">
                                    <div><?php echo $langObj->getLabel("INDEX_EMAIL"); ?></div>
                                    <textarea  name="reservation_email" id="reservation_email" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_email",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:pattern="email" tmt:message="'.$langObj->getLabel("INDEX_EMAIL_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>


                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_email" value="" />
                    <?php
                }
                if(in_array("reservation_phone",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- name -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_phone') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_PHONE"); ?></div>
                                    <input type="text" name="reservation_phone" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_phone",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_PHONE_ALERT").'"'; }?>/>
                                </div>
                                <?php
                            } else if($settingObj->getReservationFieldType('reservation_phone') == 'textarea') {
                                ?>
                                <div class="float_left margin_r_2p width_98p">
                                    <div><?php echo $langObj->getLabel("INDEX_PHONE"); ?></div>
                                    <textarea name="reservation_phone" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_phone",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_PHONE_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>



                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_phone" value="" />
                    <?php
                }
                if(in_array("reservation_message",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- message -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_message') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_MESSAGE"); ?></div>
                                    <input type="text" class="field_input_custom width_90p border_none" name="reservation_message" <?php if(in_array("reservation_message",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_MESSAGE_ALERT").'"'; }?>/>
                                </div>
                                <?php
                            } else if($settingObj->getReservationFieldType('reservation_message') == 'textarea') {
                                ?>
                                <div class="form_textarea_container">
                                    <div><?php echo $langObj->getLabel("INDEX_MESSAGE"); ?></div>
                                    <textarea class="field_input_custom width_100p height_25 border_none" name="reservation_message" <?php if(in_array("reservation_message",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_MESSAGE_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>

                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_message" value="" />
                    <?php
                }
                if(in_array("reservation_field1",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- name -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_field1') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD1"); ?></div>
                                    <input type="text" name="reservation_field1" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_field1",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD1_ALERT").'"'; }?>/>
                                </div>
                                <?php
                            } else if($settingObj->getReservationFieldType('reservation_field1') == 'textarea') {
                                ?>
                                <div class="form_textarea_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD1"); ?></div>
                                    <textarea name="reservation_field1" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_field1",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD1_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>


                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_field1" value="" />
                    <?php
                }
                if(in_array("reservation_field2",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- name -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_field2') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD2"); ?></div>
                                    <input type="text" name="reservation_field2" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_field2",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD2_ALERT").'"'; }?>/>
                                </div>
                            <?php
                            } else if($settingObj->getReservationFieldType('reservation_field2') == 'textarea') {
                                ?>
                                <div class="form_textarea_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD2"); ?></div>
                                    <textarea name="reservation_field2" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_field2",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD2_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>


                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_field2" value="" />
                    <?php
                }
                if(in_array("reservation_field3",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- name -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_field3') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD3"); ?></div>
                                    <input type="text" name="reservation_field3" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_field3",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD3_ALERT").'"'; }?>/>
                                </div>
                            <?php
                            } else if($settingObj->getReservationFieldType('reservation_field3') == 'textarea') {
                                ?>
                                <div class="form_textarea_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD3"); ?></div>
                                    <textarea name="reservation_field3" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_field3",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD3_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>


                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_field3" value="" />
                    <?php
                }
                if(in_array("reservation_field4",$settingObj->getVisibleFields())) {
                    ?>
                    <!-- name -->

                            <?php
                            if($settingObj->getReservationFieldType('reservation_field4') == 'text') {
                                ?>
                                <div class="form_input_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD4"); ?></div>
                                    <input type="text" name="reservation_field4" class="field_input_custom width_90p border_none" <?php if(in_array("reservation_field4",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD4_ALERT").'"'; }?>/>
                                </div>
                            <?php
                            } else if($settingObj->getReservationFieldType('reservation_field4') == 'textarea') {
                                ?>
                                <div class="form_textarea_container">
                                    <div><?php echo $langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD4"); ?></div>
                                    <textarea name="reservation_field4" class="field_input_custom width_100p height_25 border_none" <?php if(in_array("reservation_field4",$settingObj->getMandatoryFields())) { echo 'tmt:required="true" tmt:message="'.$langObj->getLabel("INDEX_RESERVATION_ADDITIONAL_FIELD4_ALERT").'"'; }?>></textarea>
                                </div>
                                <?php
                            }
                            ?>


                    <?php
                } else {
                    ?>
                    <input type="hidden" name="reservation_field4" value="" />
                    <?php
                }
                ?>
                <?php
                if($settingObj->getShowTerms() == 1 && $settingObj->getTermsLabel() != '') {
                    ?>
                    <!-- terms -->
                    <div class="cleardiv"></div>
                    <div class="margin_t_10">
                        <div class="float_left"><input type="checkbox" name="reservation_terms" value="checked" tmt:minchecked="1" tmt:message="<?php echo $langObj->getLabel("INDEX_TERMS_AND_CONDITIONS_ALERT");?>"/></div>
                        <div class="float_left margin_l_10"><a href="<?php echo $settingObj->getTermsLink(); ?>" class="mark_fff font_size_12 no_decoration" target="_blank"><?php echo $settingObj->getTermsLabel(); ?></a></div>
                        <div class="cleardiv"></div>
                        <div class="form_input"></div>
                    </div>

                    <?php
                }
                ?>
                <!-- google capthca -->
                <?php
                if($settingObj->getRecaptchaEnabled() == 1) {
                ?>
                    <div class="margin_t_10">
                        <div id="captcha_error" style="display:none !important"><?php echo $langObj->getLabel("INDEX_INVALID_CODE");?></div>
                        <div id="captcha"></div>
                    </div>

                <?php
                }
                ?>
                <div class="cleardiv"></div>
                <!-- book now button and clear -->
                <div class="margin_t_20">
                     <?php
                    if($settingObj->getPaypal()==1 && $settingObj->getPaypalAccount() != '' && $settingObj->getPaypalLocale() != '' && $settingObj->getPaypalCurrency() != '') {
                        ?>
                        <div class="booknow_btn">
                            <input type="hidden" name="with_paypal" id="with_paypal" value="1" />
                            <input type="button" class="book_now_custom" id="submit_button" value="<?php echo $langObj->getLabel("INDEX_BOOK_NOW"); ?>" style="cursor:pointer" />
                        </div>
                        <div class="cleardiv"></div>

                        <?php
                    } else {
                        ?>
                        <div class="booknow_btn">
                            <input type="submit" class="book_now_custom" id="submit_button" value="<?php echo $langObj->getLabel("INDEX_BOOK_NOW"); ?>" style="cursor:pointer" />
                        </div>

                        <?php
                    }
                    ?>

                    <div class="clear_btn"><a href="javascript:clearForm();" class="clear_custom public_button grey_button"><?php echo $langObj->getLabel("INDEX_CLEAR"); ?></a></div>

                    <div class="cleardiv"></div>

                </div>
            </div>

        </div>
    </div>
    </form>
    
    <?php
	if($settingObj->getPaypal()==1 && $settingObj->getPaypalAccount() != '' && $settingObj->getPaypalLocale() != '' && $settingObj->getPaypalCurrency() != '') {
		?>
        <!-- paypal form -->
        <form action='https://www.paypal.com/cgi-bin/webscr' METHOD='POST' name="paypal_form" style="display:inline">

            <!-- PayPal Configuration -->
            <input type="hidden" name="business" value="<?php echo $settingObj->getPaypalAccount(); ?>">
            
            <input type="hidden" name="upload" value="1" />

            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="charset" value="utf-8">
            
            <!--slots purchased-->
            <div id="slots_purchased">
            	
            </div>
            
            <input type="hidden" name="notify_url" value="<?php echo $settingObj->getSiteDomain(); ?>/paypal_ipn_notice.php">
           
           
            <input type="hidden" name="return" value="<?php echo $settingObj->getSiteDomain(); ?>/paypal_confirm.php">
            <input type="hidden" name="cancel_return" value="<?php echo $settingObj->getSiteDomain(); ?>/paypal_cancel.php">
            
            <input type="hidden" name="rm" value="POST">
            <input type="hidden" name="currency_code" value="<?php echo $settingObj->getPaypalCurrency();?>">
            <input type="hidden" name="lc" value="<?php echo $settingObj->getPaypalLocale(); ?>">
            
           
            
                            
                            
                            
        </form>
        <?php
	}
	?>
	<div style="clear:both"></div>
</div>


<!-- ===============================================================
	box after booking
================================================================ -->
<div id="modal_response" class="modal" style="display:none">
	<?php
	if($settingObj->getReservationConfirmationMode() == 1) {
		echo $langObj->getLabel("INDEX_CONFIRM1");
	} else if($settingObj->getReservationConfirmationMode() == 2) {
		echo $langObj->getLabel("INDEX_CONFIRM2");
	} else if($settingObj->getReservationConfirmationMode() == 3) {
		echo $langObj->getLabel("INDEX_CONFIRM3");
	}
	?>
    <br /><a href="javascript:hideResponse(<?php echo $calendarObj->getCalendarId(); ?>,'<?php echo $publickey; ?>');" class="booking_button ok_button book_now_custom" id="ok_response">OK</a>
</div>

<!-- preloader -->
<div id="modal_loading" class="modal_loading" style="display:none">
	<img src="images/loading.png" border=0 />
</div>
<!-- necessary to submit form without reload the page -->
<iframe style="border:none;width:0px;height:0px" id="iframe_submit" name="iframe_submit"></iframe>
<?php
/**************************/
/******** END SECTION 3 ***/
/**************************/
?>

</body>
</html>
