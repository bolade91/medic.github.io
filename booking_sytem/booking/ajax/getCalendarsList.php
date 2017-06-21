<?php
include '../common.php';
$category_id=$_GET["category_id"];
$arrayCalendars = $listObj->getCalendarsList('ORDER BY calendar_order',$category_id);
$default = 0;
foreach($arrayCalendars as $calendarId => $calendar) {
	if($calendar["calendar_order"]==0) {
		$default = $calendarId;
		$calendarObj->setCalendar($default);
	}
	?>
	<option value="<?php echo $calendarId; ?>"><?php echo $calendar["calendar_title"]; ?></option>
	<?php
}

?>|<?php echo $default; ?>|<?php echo $calendarObj->getFirstFilledMonth($calendarObj->getCalendarId()); ?>