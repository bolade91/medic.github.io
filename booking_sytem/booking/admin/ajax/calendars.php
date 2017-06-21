<!-- 
=======================
=== table header ==
=======================
-->

<div class="calendar_title_col1">
    <div id="table_cell">#</div>
</div>
<div class="calendar_title_col2">
    <div id="table_cell"><input type="checkbox" name="selectAll" onclick="javascript:selectCheckbox('manage_calendars','calendars[]');" /></div>
</div>
<div class="calendar_title_col3">
    <div id="table_cell"><?php echo $langObj->getLabel("CALENDAR_TITLE_LABEL"); ?></div>
</div>
<div class="calendar_title_col4">
    <div id="table_cell"><?php echo $langObj->getLabel("CALENDAR_CATEGORY_LABEL"); ?></div>
</div>
<div class="calendar_title_col5">
    <div id="table_cell"><?php echo $langObj->getLabel("CALENDAR_DIRECT_LINK_LABEL"); ?></div>
</div>
<div class="calendar_title_col6">
    <div id="table_cell"><?php echo $langObj->getLabel("CALENDAR_PUBLISHED_LABEL"); ?></div>
</div>
<div class="calendar_title_col7">
    <div id="table_cell"></div>
</div>
<div class="calendar_title_col8">
    <div id="table_cell"></div>
</div>
<div class="calendar_title_col9">
    <div id="table_cell"></div>
</div>
<div id="empty"></div>



<!-- 
=======================
=== table rows ==
=======================
-->
<?php      
$arrayCalendars = $listObj->getCalendarsList($filter);    
                  
$i=1;
foreach($arrayCalendars as $calendarId => $calendar) {																			
    if($i % 2) {
        $class="alternate_table_row_white";
    } else {
        $class="alternate_table_row_grey";
    }
    
?>
<div id="row_<?php echo $calendarId; ?>">
    
    <!-- row number -->
    <div class="calendar_row_col1 <?php echo $class; ?>">
        <div id="table_cell"><?php echo $i; ?></div>
    </div>
    
    <!-- check calendar -->
    <div class="calendar_row_col2 <?php echo $class; ?>">
        <div id="table_cell"><input type="checkbox" name="calendars[]" value="<?php echo $calendarId; ?>" onclick="javascript:disableSelectAll('manage_calendars',this.checked);" /></div>
    </div>
    
    <!-- name calendar -->                   
    <div class="calendar_row_col3 <?php echo $class; ?>">
        <div id="table_cell">
            <?php echo $calendar["calendar_title"]; ?>
        
        </div>
    </div>
    <div class="calendar_row_col4 <?php echo $class; ?>">
        <div id="table_cell">
            <?php 
			$categoryObj->setCategory($calendar["category_id"]);
			echo $categoryObj->getCategoryName(); ?>
        
        </div>
    </div>
    
    
    <!-- direct link -->
    <div class="calendar_row_col5 <?php echo $class; ?>">
        <div id="table_cell"><a href="<?php echo $settingObj->getSiteDomain()."/index.php?calendar_id=".$calendarId; ?>" target="_blank"><?php echo $settingObj->getSiteDomain()."/index.php?calendar_id=".$calendarId; ?></a></div>
    </div>
    <!-- status icon -->
    <div class="calendar_row_col6 <?php echo $class; ?>">
        <div id="table_cell"><span id="publish_<?php echo $calendarId; ?>"><?php if($calendar["calendar_active"]=='1') { ?><a href="javascript:unpublishCalendar(<?php echo $calendarId; ?>);"><img src="images/icons/published.png" border=0 /></a><?php } else { ?><a href="javascript:publishCalendar(<?php echo $calendarId; ?>);"><img src="images/icons/unpublished.png" border=0 /></a><?php } ?></span>
        <?php
        if($calendar["calendar_order"] > 0) {
        ?>
        <br /><input type="button" value="<?php echo $langObj->getLabel("SET_AS_DEFAULT_CALENDAR"); ?>" onclick="javascript:setDefaultCalendar(<?php echo $calendarId; ?>,<?php echo $calendar["category_id"]; ?>);"/>
        <?php
        }
        ?>
        </div>
    </div> 
    
    <!-- modify name button -->                      
    <div class="calendar_row_col7 <?php echo $class; ?>">
        <div id="table_cell"><span id="modify_<?php echo $calendarId; ?>"><a href="new_calendar.php?calendar_id=<?php echo $calendarId; ?>"><?php echo $langObj->getLabel("CALENDARS_MODIFY"); ?></a></span></div>
    </div>
    
    <!-- manage button -->
     <div class="calendar_row_col8 <?php echo $class; ?>">
        <div id="table_cell"><a href="calendar_manage.php?calendar_id=<?php echo $calendarId; ?>&ref=slots"><?php echo $langObj->getLabel("CALENDARS_MANAGE"); ?></a></div>
    </div>
    
    <!-- delete button -->
    <div class="calendar_row_col9 <?php echo $class; ?>">
        <div id="table_cell"><a href="javascript:delItem(<?php echo $calendarId; ?>,'calendars','calendar_id');"><?php echo $langObj->getLabel("CALENDARS_DELETE"); ?></a></div>
    </div>                            
   
    <div id="empty"></div>
</div>
<?php 
$i++;
} ?>
