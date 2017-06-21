<?php 
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}

include 'include/header.php';



?>

<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
			<?php
            include 'include/menu.php';
            ?>
           
            
            <div id="table_container">
                <div id="table">
                    <div class="resindex_title_col1">
                        <div id="table_cell">#</div>
                    </div>
                    <div class="resindex_title_col2">
                        <div id="table_cell"><?php echo $langObj->getLabel("CALENDAR"); ?></div>
                    </div>                    
                    <div class="resindex_title_col3">
                        <div id="table_cell"><?php echo $langObj->getLabel("RESERVATIONS"); ?></div>
                    </div>
                    <div class="resindex_title_col4">
                        <div id="table_cell"><?php echo $langObj->getLabel("RESERVATIONS_PUBLISHED_TITLE"); ?></div>
                    </div>
                    <div class="resindex_title_col5">
                        <div id="table_cell"></div>
                    </div>
                    <div id="empty"></div>
                    <?php                         
                    $arrayCalendars = $listObj->getCalendarsResList();                        
                    $i=1;
                    foreach($arrayCalendars as $calendarId => $calendar) {																			
                        if($i % 2) {
                            $class="alternate_table_row_white";
                        } else {
                            $class="alternate_table_row_grey";
                        }
                        
                    ?>
                    
                    <div class="resindex_row_col1 <?php echo $class; ?>">
                        <div id="table_cell"><?php echo $i; ?></div>
                    </div>                 
                    <div class="resindex_row_col2 <?php echo $class; ?>">
                        <div id="table_cell">
                            <?php echo $calendar["calendar_title"]; ?>                        
                        </div>
                    </div>
                    <div class="resindex_row_col3 <?php echo $class; ?>">
                        <div id="table_cell"><?php echo $calendar["tot_reservation"]; ?></div>
                    </div>
                    <div class="resindex_row_col4 <?php echo $class; ?>">
                        <div id="table_cell">
							<?php if($calendar["calendar_active"]=='1') { ?><img src="images/icons/published.png" border=0 /><?php } else { ?><img src="images/icons/unpublished.png" border=0 /><?php } ?>
                        </div>
                    </div> 
                    <div class="resindex_row_col5 <?php echo $class; ?>">
                        <div id="table_cell">
                        	<?php
							if($calendar["tot_reservation"]>0) {
								?>
								<a href="reservation.php?calendar_id=<?php echo $calendarId; ?>"><?php echo $langObj->getLabel("RESERVATIONS_LIST_BUTTON"); ?></a>
								<?php
							}
							?>
                        </div>
                    </div>                            
                    
                    <div id="empty"></div>
                    
                    <?php 
                    $i++;
                    } ?>
                </div>
            </div>
            
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
        </div>
    </div>
</div>
<?php
include 'include/footer.php';
?>