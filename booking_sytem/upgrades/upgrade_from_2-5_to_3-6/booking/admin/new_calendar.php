<?php
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}
if(isset($_POST["category_id"])) {
	if($_POST["calendar_id"] > 0) {
		$calendarObj->updateCalendar();
	} else {
		$calendarObj->addCalendar();
	}
	?>
    <script>
		document.location.href="calendars.php";
	</script>
    <?php
}
$calendarObj->setCalendar($_GET["calendar_id"]);
include 'include/header.php';
?>


<script>
	
	
	function checkData(frm) {
		with(frm) {
			if(category_id.options[category_id.selectedIndex].value==0) {
				alert("<?php echo addslashes($langObj->getLabel("NEW_CALENDAR_CATEGORY_ALERT")); ?>");
				return false;
			} else if(Trim(calendar_title.value) == '') {
				alert("<?php echo addslashes($langObj->getLabel("NEW_CALENDAR_TITLE_ALERT")); ?>");
				return false;
			} else {
				return true;
			}
		}
	}
	
</script>

<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
        <?php
        include 'include/menu.php'; 
        ?>
        
        <div id="form_container">

        <form name="addcalendar" action="" method="post" onsubmit="return checkData(this);" style="display:inline;">
            <input type="hidden" name="calendar_id" value="<?php echo $_GET["calendar_id"]; ?>" />
          	<div id="label_input">
                <div class="label_title"><label for="category_id"><?php echo $langObj->getLabel("NEW_CALENDAR_CATEGORY_LABEL"); ?></label></div>
            </div>
            <div id="input_box">
                <select name="category_id" id="category_id">
                    <option value="0"><?php echo $langObj->getLabel("NEW_CALENDAR_CHOOSE_CATEGORY"); ?></option>
                    <?php
                    $arrayCategories = $listObj->getCategoriesList();
                    foreach($arrayCategories as $categoryId => $category) {
                        ?>
                        <option value="<?php echo $categoryId; ?>" <?php if($_GET["calendar_id"]>0 && $calendarObj->getCalendarCategoryId() == $categoryId) { echo "selected"; } ?>><?php echo $category["category_name"]; ?></option>
                        <?php
                    }
                    ?>
                </select>                
            </div>
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
            <div id="label_input">
                <div class="label_title"><label for="calendar_title"><?php echo $langObj->getLabel("NEW_CALENDAR_NAME_LABEL"); ?></label></div>
            </div>
            <div id="input_box">
                <input type="text" name="calendar_title" class="long_input_box" value="<?php echo $calendarObj->getCalendarTitle(); ?>" />          
            </div>
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
            <div id="label_input">
                <div class="label_title"><label for="calendar_email"><?php echo $langObj->getLabel("NEW_CALENDAR_EMAIL_LABEL"); ?></label></div>
            </div>
            <div id="input_box">
                <input type="text" name="calendar_email" class="long_input_box" value="<?php echo $calendarObj->getCalendarEmail(); ?>" />        
            </div>
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
            
            <div class="bridge_buttons_container">
                <!-- cancel -->
                <div ><a href="javascript:document.location.href='calendars.php';" class="cancel_button"><?php echo $langObj->getLabel("NEW_CALENDAR_CANCEL_BUTTON"); ?></a></div>
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("NEW_CALENDAR_SAVE_BUTTON"); ?>"></div>
                
            </div>
            <div id="rowspace"></div>
            
            
            </form>
            
         </div>
		</div>
	</div>
</div>
<?php 
include 'include/footer.php';
?>
      
