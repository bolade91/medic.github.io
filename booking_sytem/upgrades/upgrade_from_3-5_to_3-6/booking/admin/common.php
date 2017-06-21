<?php 
error_reporting(0);
ini_set('show_errors',0);
ini_set("memory_limit",-1);
@set_time_limit(0);
include_once dirname(__FILE__).'/include/db_conn.php';
include_once dirname(__FILE__).'/../include/lang.php';
include_once dirname(__FILE__).'/include/lang.php';
include_once dirname(__FILE__).'/class/settings.class.php';
$settingObj = new setting($db);
date_default_timezone_set($settingObj->getTimezone());
define('CALENDAR_PATH',$settingObj->getSiteDomain());
include_once dirname(__FILE__).'/class/admin.class.php';
include_once dirname(__FILE__).'/class/list.class.php';
include_once dirname(__FILE__).'/class/holiday.class.php';
include_once dirname(__FILE__).'/class/slot.class.php';
include_once dirname(__FILE__).'/class/reservation.class.php';
include_once dirname(__FILE__).'/class/calendar.class.php';
include_once dirname(__FILE__).'/class/mail.class.php';
include_once dirname(__FILE__).'/class/lang.class.php';
include_once dirname(__FILE__).'/class/category.class.php';
include_once dirname(__FILE__).'/class/utils.class.php';

$listObj = new lists($db);
$adminObj = new admin($db);
$holidayObj = new holiday($db);
$slotsObj = new slot($db);
$reservationObj = new reservation($db);
$calendarObj = new calendar($db);
$mailObj = new email($db);
$langObj = new lang($db);
$categoryObj = new category($db);
$utilsObj = new utils($db);

session_start();

?>
