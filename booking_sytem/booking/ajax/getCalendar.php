<?php
include '../common.php';
$calendarObj->setCalendar($_GET["calendar_id"]);
?>
<?php echo $calendarObj->getFirstFilledMonth($calendarObj->getCalendarId()); ?>