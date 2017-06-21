<?php 

include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}

include 'include/header.php';

if(isset($_POST["operation"]) && $_POST["operation"] != '') {
	$arrCalendars=$_POST["calendars"];
	$qryString = "0";
	for($i=0;$i<count($arrCalendars); $i++) {
		$qryString .= ",".$arrCalendars[$i];
	}
		
	switch($_POST["operation"]) {
		case "publishCalendars":
			$calendarObj->publishCalendars($qryString);
			break;
		case "unpublishCalendars":
			$calendarObj->unpublishCalendars($qryString);
			break;
		case "delCalendars":
			$calendarObj->delCalendars($qryString);
			break;
		case "duplicateCalendars":
			$calendarObj->duplicateCalendars($qryString);
			break;
	}                
	header('Location: calendars.php');
}
$filter = "";

?>

<!-- 
=====================================================================
=====================================================================
-->

<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
        
        	<!-- 
            =======================
            === menu ==
            =======================
            -->
			<?php
            include 'include/menu.php';
            ?>
            <?php
			$arrayCalendars = $listObj->getCalendarsList(); 
			
			?>
            <!-- 
            =======================
            === js - check ==
            =======================
            -->
            <script>
             
                
                function delItem(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("CALENDARS_DELETE_CONFIRM_SINGLE")); ?>")) {
                        $.ajax({
                          url: 'ajax/delCalendarItem.php?item_id='+itemId,
                          success: function(data) {
                              $('#table').hide().html(data).fadeIn(2000);
                             
                            
                          }
                        });
                    } 
                }
                function publishCalendar(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("CALENDARS_PUBLISH_CONFIRM_SINGLE")); ?>")) {
                        $.ajax({
                          url: 'ajax/publishCalendar.php?calendar_id='+itemId,
                          success: function(data) {
                              $('#publish_'+itemId).html('<a href="javascript:unpublishCalendar('+itemId+');"><img src="images/icons/published.png" border=0 /></a>');								 							 
                            
                          }
                        });
                    } 
                }
                function unpublishCalendar(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("CALENDARS_UNPUBLISH_CONFIRM_SINGLE")); ?>")) {
                        $.ajax({
                          url: 'ajax/unpublishCalendar.php?calendar_id='+itemId,
                          success: function(data) {
                              $('#publish_'+itemId).html('<a href="javascript:publishCalendar('+itemId+');"><img src="images/icons/unpublished.png" border=0 /></a>');								 							 
                            
                          }
                        });
                    } 
                }
                
                
                function setDefaultCalendar(calendar,category) {
                    $.ajax({
                      url: 'ajax/setDefaultCalendar.php?calendar_id='+calendar+"&category_id="+category,
                      success: function(data) {
                        document.location.reload();
                      }
                    });
                }
				
				
				
				function showActionBar() {
					$('#action_bar').slideDown();
				}
				function hideActionBar() {
					$('#action_bar').slideUp();
				}
				function filterCalendars() {
					category = document.getElementById('category_filter').options[document.getElementById('category_filter').selectedIndex].value;
					 $.ajax({
                      url: 'ajax/filterCalendars.php?category_id='+category,
                      success: function(data) {
                        $('#table').hide().html(data).fadeIn(2000);
						
                      }
                    });
				}
            </script>
            
           
           
          
            
             <!-- 
            =======================
            === action bar ==
            =======================
            -->
            <?php
			
			?>
            <div id="action_bar">
				<div id="filter">
                	<select name="category_filter" id="category_filter" onchange="javascript:filterCalendars();">
                        <option value="0"><?php echo $langObj->getLabel("NEW_CALENDAR_CHOOSE_CATEGORY"); ?></option>
                        <?php
                        $arrayCategories = $listObj->getCategoriesList();
                        foreach($arrayCategories as $categoryId => $category) {
                            ?>
                            <option value="<?php echo $categoryId; ?>"><?php echo $category["category_name"]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>            
                
            	<div id="action"><a onclick="javascript:delItems('manage_calendars','calendars[]','duplicateCalendars','<?php echo $langObj->getLabel("CALENDARS_DUPLICATE_CONFIRM_MULTIPLE"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')" class="add_calendar_button"><?php echo $langObj->getLabel("CALENDARS_DUPLICATE"); ?></a></div>
                <div id="action"><a onclick="javascript:delItems('manage_calendars','calendars[]','delCalendars','<?php echo $langObj->getLabel("CALENDARS_DELETE_CONFIRM_MULTIPLE"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("CALENDARS_DELETE"); ?></a></div>
                <div id="action"><a onclick="javascript:delItems('manage_calendars','calendars[]','unpublishCalendars','<?php echo $langObj->getLabel("CALENDARS_UNPUBLISH_CONFIRM_MULTIPLE"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("CALENDARS_UNPUBLISH"); ?></a></div>
                <div id="action"><a onclick="javascript:delItems('manage_calendars','calendars[]','publishCalendars','<?php echo $langObj->getLabel("CALENDARS_PUBLISH_CONFIRM_MULTIPLE"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("CALENDARS_PUBLISH"); ?></a></div>
                <div class="title_action"><?php echo $langObj->getLabel("SELECTED_ITEMS"); ?>:</div>
                <div id="add_calendar"><a href="new_calendar.php?calendar_id=0"><?php echo $langObj->getLabel("CALENDARS_ADD"); ?></a></div>
                
            </div>
           
            <!-- 
            =======================
            === table calendars ==
            =======================
            -->
            <form name="manage_calendars" action="" method="post">
                <input type="hidden" name="operation" />
                <input type="hidden" name="calendars[]" value=0 />
                <div id="table_container">
                    <div id="table">
                    	<?php include 'ajax/calendars.php'; ?>
                    </div>
                </div>
            </form>
            
            
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
        </div>
    </div>
</div>

<!-- 
=======================
=== footer ==
=======================
--
<?php
include 'include/footer.php';
?>
