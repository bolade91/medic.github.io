<?php
include '../common.php';
//check what date format in settings
if($settingObj->getDateFormat() == "UK" || $settingObj->getDateFormat() == "EU") {
	$startDay=1;
	$weekday_format="N";
	$lastWeekDay=7;
} else {
	$startDay=0;
	$weekday_format="w";
	$lastWeekDay=6;
}
$slots_popup_enabled = $settingObj->getSlotsPopupEnabled();
if($_GET["calendar_id"] > 0) {
	
	$calendarObj->setCalendar($_GET["calendar_id"]);
	$arrayMonth = $listObj->getMonthCalendar($_GET["month"],$_GET["year"],$weekday_format);
	
	$i = 0;
	
	foreach($arrayMonth as $daynum => $daydata) {
		if($i == 0) {
			//check what's first week day and add cells
			for($j=$startDay;$j<$daydata["dayofweek"];$j++) {
                if($j == $lastWeekDay) {
                    ?>
                    <div class="day_container day_container_custom day_grey" style="margin-right: 0px;"><a style="background-color:<?php echo $settingObj->getDayGreyBg(); ?>"></a></div>

                <?php
                } else {
                    ?>
                    <div class="day_container day_container_custom day_grey"><a style="background-color:<?php echo $settingObj->getDayGreyBg(); ?>"></a></div>
                <?php
                }
				
				
			}
		}
		
		$numslots = $listObj->getSlotsPerDay($_GET["year"],$_GET["month"],$daynum,$_GET["calendar_id"],$settingObj);
		
		//get default background color from style options, have to maintain classes for js to work
		$background = "day_white";
		$background_color = $settingObj->getDayWhiteBg();
        $daynumstyle = 'style="color:'.$settingObj->getDayWhiteLine1Color().'"';
        $newstyle2 = 'style="color:'.$settingObj->getDayWhiteLine2Color().';background-color:'.$settingObj->getDayWhiteLine2Bg().'"';
		$over=1;
		//if it's a past day and there are no slots
		$date = date_create(date('Y-m-d'));
		
		if(function_exists("date_add")) {
			date_add($date, date_interval_create_from_date_string($settingObj->getBookFrom().' days'));
		} else {
			date_modify($date, '+'.$settingObj->getBookFrom().' day');
		}
		//date_add($date, date_interval_create_from_date_string($settingObj->getBookFrom().' days'));
		$bookfromdate = date_format($date, 'Ymd');

		if($settingObj->getBookTo() > 0) {
			$date = date_create(date('Y-m-d'));
			if(function_exists("date_add")) {
				date_add($date, date_interval_create_from_date_string($settingObj->getBookTo().' days'));
			} else {
				date_modify($date, '+'.$settingObj->getBookTo().' day');
			}
			
			//date_add($date, date_interval_create_from_date_string($settingObj->getBookFrom().' days'));
			$booktodate = date_format($date, 'Ymd');
		} else {
			$booktodate = '30001010';
		}

        if($daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] < $bookfromdate || $numslots == -1 || $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] > $booktodate) {
            $background_color = $settingObj->getDayWhiteBgDisabled();
            $daynumstyle = 'style="color:'.$settingObj->getDayWhiteLine1DisabledColor().'"';
            $newstyle2 = 'style="color:'.$settingObj->getDayWhiteLine2DisabledColor().';background-color:'.$settingObj->getDayWhiteLine2DisabledBg().'"';
            $over=0;

		}
		//no slots, it's day greater or equal to today, but it's red because it's sold out
        if($numslots == 0 && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] >= date('Ymd')) {
            $background="day_red";
            $background_color = $settingObj->getDayRedBg();
            $daynumstyle = 'style="color:'.$settingObj->getDayRedLine1Color().'"';
            $newstyle2 = 'style="color:'.$settingObj->getDayRedLine2Color().';background-color:'.$settingObj->getDayRedLine2Bg().'"';

		} else if($daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] == date('Ymd')) {
			// today without sold out
            $daynumstyle = 'style="color:#000000;font-weight:bold"';
		} else if($numslots == -1) {
			//no slots but not sold out
            $background_color = $settingObj->getDayWhiteBgDisabled();
            $daynumstyle = 'style="color:'.$settingObj->getDayWhiteLine1DisabledColor().'"';
            $newstyle2 = 'style="color:'.$settingObj->getDayWhiteLine2DisabledColor().';background-color:'.$settingObj->getDayWhiteLine2DisabledBg().'"';

		}
		// last day of week
		if($daydata["dayofweek"] == $lastWeekDay) {
			
			?>
            <div class="day_container day_container_custom <?php echo $background; ?>" style="margin-right: 0px;"><a style="cursor:pointer;background-color:<?php echo $background_color; ?>" year="<?php echo $_GET["year"]; ?>" month="<?php echo $_GET["month"]; ?>" day="<?php echo $daynum; ?>" popup="<?php echo $slots_popup_enabled; ?>" over="<?php echo $over; ?>">
                    <div class="day_number" <?php echo $daynumstyle; ?>><?php echo $daynum; ?></div>

                    <div class="cleardiv"></div>
                    <div class="day_slots" <?php echo $newstyle2; ?>>

                        <?php
                        // if there are slots: slots number text
                        if($numslots>0 && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] >= $bookfromdate && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] <= $booktodate) {
                            ?>
                            <i class="fa fa-calendar-check-o"></i>
                            <?php
                            echo $numslots;

                        } else if($numslots == 0)  {
                            echo $langObj->getLabel("GETMONTHCALENDAR_SOLDOUT");
                        }
                        ?>
                    </div>

                </a>
            </div>

			<?php
		// all other days
		} else {
			?>
            <div class="day_container day_container_custom <?php echo $background; ?>"><a style="cursor:pointer;background-color:<?php echo $background_color; ?>" year="<?php echo $_GET["year"]; ?>" month="<?php echo $_GET["month"]; ?>" day="<?php echo $daynum; ?>" popup="<?php echo $slots_popup_enabled; ?>" over="<?php echo $over; ?>">
                    <div class="day_number" <?php echo $daynumstyle; ?>><?php echo $daynum; ?></div>

                    <div class="cleardiv"></div>
                    <!-- time slots available -->
                    <div class="day_slots" <?php echo $newstyle2; ?>>

                        <?php
                        if($numslots>0 && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] >= $bookfromdate && $daydata["yearnum"].$daydata["monthnum"].$daydata["daynum"] <= $booktodate) {
                            ?>
                            <i class="fa fa-calendar-check-o"></i>
                            <?php
                            echo $numslots;

                        } else if($numslots == 0)  {
                            echo $langObj->getLabel("GETMONTHCALENDAR_SOLDOUT");
                        }
                        ?>
                    </div>

                </a>
            </div>

			<?php
		}
		
		$i++;
		if($i == count($arrayMonth)) {
			$lastDay=$daydata["dayofweek"];
		}
	}
	//check what's last week day and add cells
	for($j=$lastWeekDay;$j>$lastDay;$j--) {
        if($j == ($lastDay+1)) {
            ?>
            <div class="day_container day_container_custom day_grey" style="margin-right: 0px;"><a style="background-color:<?php echo $settingObj->getDayGreyBg(); ?>"></a></div>

        <?php
        } else {
            ?>
            <div class="day_container day_container_custom day_grey"><a style="background-color:<?php echo $settingObj->getDayGreyBg(); ?>"></a></div>
        <?php
        }
	}
	?>
	<script>
		$(function() {
			
			$('#month_nav_prev').html("<a href=\"javascript:getPreviousMonth(<?php echo $calendarObj->getCalendarId(); ?>,'<?php echo $_GET["publickey"]; ?>',<?php echo $settingObj->getCalendarMonthLimitPast(); ?>);\" class=\"month_nav_button month_navigation_button_custom fa fa-angle-left\"></a>");
			$('#month_nav_next').html("<a href=\"javascript:getNextMonth(<?php echo $calendarObj->getCalendarId(); ?>,'<?php echo $_GET["publickey"]; ?>',<?php echo $settingObj->getCalendarMonthLimitFuture(); ?>);\" class=\"month_nav_button month_navigation_button_custom fa fa-angle-right\"></a>");
		});
	</script>
<?php
} else {
	$arrayMonth = $listObj->getMonthCalendar($_GET["month"],$_GET["year"],$weekday_format);
	
	$i = 0;
	foreach($arrayMonth as $daynum => $daydata) {
		if($i == 0) {
			//check what's first week day and add cells
			for($j=$startDay;$j<$daydata["dayofweek"];$j++) {
                ?>
                <div class="day_container day_container_custom day_grey"><a style="background-color:<?php echo $settingObj->getDayGreyBg(); ?>" ></a></div>
                <?php

			}
		}
		
		$background = "day_white";
		$background_color = $settingObj->getDayWhiteBgDisabled();
		$newstyle='';
		$newstyle1='';
		$newstyle2='';
		$over=0;
		
		if($daydata["dayofweek"] == $lastWeekDay) {
			
			?>
            <div class="day_container day_container_custom <?php echo $background; ?>" style="margin-right: 0px;"><a style="cursor:pointer;background-color:<?php echo $background_color; ?>" year="<?php echo $_GET["year"]; ?>" month="<?php echo $_GET["month"]; ?>" day="<?php echo $daynum; ?>" popup="<?php echo $slots_popup_enabled; ?>" over="<?php echo $over; ?>">
                    <div class="day_number" <?php echo $newstyle; ?>><?php echo $daynum; ?></div>
                    <div class="day_slots" <?php echo $newstyle; ?>>

                    </div>
                    <div class="day_book">

                    </div>
                </a>
            </div>

			<?php
		} else {
			?>
            <div class="day_container day_container_custom <?php echo $background; ?>"><a style="cursor:pointer;background-color:<?php echo $background_color; ?>" year="<?php echo $_GET["year"]; ?>" month="<?php echo $_GET["month"]; ?>" day="<?php echo $daynum; ?>" over="<?php echo $over; ?>">
                    <div class="day_number" <?php echo $newstyle; ?>><?php echo $daynum; ?></div>
                    <div class="day_slots" <?php echo $newstyle; ?>>

                    </div>
                    <div class="day_book">

                    </div>
                </a>
            </div>

			<?php
		}
		
		$i++;
		if($i == count($arrayMonth)) {
			$lastDay=$daydata["dayofweek"];
		}
	}
	//check what's last week day and add cells
	for($j=$lastWeekDay;$j>$lastDay;$j--) {
        if($j == ($lastDay+1)) {
            ?>
            <div class="day_container day_container_custom day_grey" style="margin-right: 0px;"><a style="background-color:<?php echo $settingObj->getDayGreyBg(); ?>"></a></div>

        <?php
        } else {
            ?>
            <div class="day_container day_container_custom day_grey"><a style="background-color:<?php echo $settingObj->getDayGreyBg(); ?>"></a></div>
        <?php
        }

	}
	?>
	<script>
		$(function() {
			$('#month_nav_prev').html("<a href=\"javascript:getPreviousMonth('<?php echo $calendarObj->getCalendarId(); ?>','<?php echo $_GET["publickey"]; ?>',<?php echo $settingObj->getCalendarMonthLimitPast(); ?>);\" class=\"month_nav_button month_navigation_button_custom  fa fa-angle-left\"></a>");
			$('#month_nav_next').html("<a href=\"javascript:getNextMonth('<?php echo $calendarObj->getCalendarId(); ?>','<?php echo $_GET["publickey"]; ?>',<?php echo $settingObj->getCalendarMonthLimitFuture(); ?>);\" class=\"month_nav_button month_navigation_button_custom  fa fa-angle-right\"></a>");
		});
	</script>
    <?php
}
?>
<div class="cleardiv"></div>