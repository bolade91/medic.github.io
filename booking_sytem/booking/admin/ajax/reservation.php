<div class="reservation_title_col1">
    <div id="table_cell">#</div>
</div>
<div class="reservation_title_col2">
    <div id="table_cell"><input type="checkbox" name="selectAll" onclick="javascript:selectCheckbox('manage_reservations','reservations[]');" /></div>
</div>
<div class="reservation_title_col3">
    <div id="table_cell"><?php echo $langObj->getLabel("RESERVATION_DATE_LABEL");?>&nbsp;<a href="javascript:orderby('date','<?php echo $_SESSION["orderbyReservationDate"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbyReservationDate"];?>.gif" border=0 /></a></div>
</div>
<div class="reservation_title_col4">
    <div id="table_cell"><?php echo $langObj->getLabel("RESERVATION_TIME_LABEL");?>&nbsp;<a href="javascript:orderby('time','<?php echo $_SESSION["orderbyReservationTime"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbyReservationTime"];?>.gif" border=0 /></a></div>
</div>   
<div class="reservation_title_col5">
    <div id="table_cell"><?php echo $langObj->getLabel("RESERVATION_SEATS_LABEL");?></div>
</div>     
<div class="reservation_title_col6">
    <div id="table_cell"><?php echo $langObj->getLabel("RESERVATION_SURNAME_NAME_LABEL");?></div>
</div>
<div class="reservation_title_col7">
    <div id="table_cell"><?php echo $langObj->getLabel("RESERVATION_EMAIL_LABEL");?></div>
</div>
<div class="reservation_title_col8">
    <div id="table_cell"><?php echo $langObj->getLabel("RESERVATION_CONFIRMED_LABEL");?></div>
</div>
<div class="reservation_title_col9">
    <div id="table_cell"></div>
</div>
<div class="reservation_title_col10">
    <div id="table_cell"></div>
</div>
<div id="empty"></div>
<?php                         
$arrayReservations = $listObj->getReservationsList($_SESSION["qryReservationsFilterString"],$_SESSION["qryReservationsOrderString"],$_GET["calendar_id"]);                        
$i=1;
foreach($arrayReservations as $reservationId => $reservation) {		
    if($reservation["slot_active"] == 0) {
        $class="table_row_red";
    } else {													
        if($i % 2) {
            $class="alternate_table_row_white";
        } else {
            $class="alternate_table_row_grey";
        }
    }
?>
<div id="row_<?php echo $reservationId; ?>">
    <div class="reservation_row_col1 <?php echo $class; ?>">
        <div id="table_cell"><?php echo $i; ?></div>
    </div>
    <div class="reservation_row_col2 <?php echo $class; ?>">
        <div id="table_cell"><input type="checkbox" name="reservations[]" value="<?php echo $reservationId; ?>" onclick="javascript:disableSelectAll('manage_reservations',this.checked);" /></div>
    </div>                    
    <div class="reservation_row_col3 <?php echo $class; ?>">
        <div id="table_cell">
        	<?php
			if($settingObj->getDateFormat() == "UK") {
				$dateToSend = strftime('%d/%m/%Y',strtotime($reservation["reservation_date"]));
			} else if($settingObj->getDateFormat() == "EU") {
				$dateToSend = strftime('%Y/%m/%d',strtotime($reservation["reservation_date"]));
			} else {
				$dateToSend = strftime('%m/%d/%Y',strtotime($reservation["reservation_date"]));
			}
			?>
			<?php echo $dateToSend; ?>
			
        </div>
    </div>
    <div class="reservation_row_col4 <?php echo $class; ?>">
        <div id="table_cell">
		<?php
			if($settingObj->getTimeFormat() == "12") {
				echo date('h:i a',strtotime(substr($reservation["reservation_time"],0,5)));
				
			} else {
				echo substr($reservation["reservation_time"],0,5);
				
			}
			
			?>
</div>
    </div>
    <div class="reservation_row_col5 <?php echo $class; ?>">
        <div id="table_cell"><?php echo $reservation["reservation_seats"]; ?></div>
    </div>
    <div class="reservation_row_col6 <?php echo $class; ?>">
        <div id="table_cell"><?php echo $reservation["reservation_surname"].", ".$reservation["reservation_name"]; ?></div>
    </div>
    <div class="reservation_row_col7 <?php echo $class; ?>">
        <div id="table_cell">
        	 <?php
			$user_info = $reservation["reservation_surname"].", ".$reservation["reservation_name"];
			if($settingObj->getDateFormat() == "UK") {
				$dateToSend = strftime('%d/%m/%Y',strtotime($reservation["reservation_date"]));
			} else if($settingObj->getDateFormat() == "EU") {
				$dateToSend = strftime('%Y/%m/%d',strtotime($reservation["reservation_date"]));
			} else {
				$dateToSend = strftime('%m/%d/%Y',strtotime($reservation["reservation_date"]));
			}
			$reservation_info = '<strong>'.$langObj->getLabel("RESERVATION_DATE_LABEL").'</strong>: '.$dateToSend.'<br/><strong>'.$langObj->getLabel("RESERVATION_TIME_LABEL").'</strong>: '.$reservation_time.'<br /><strong>'.$langObj->getLabel("RESERVATION_SEATS_LABEL").'</strong>: '.$reservation["reservation_seats"];
			?>
			<div class="booking_wh_inherit booking_table_cell booking_vertical_middle"><a href="javascript:contactUser('<?php echo $reservation["reservation_email"]; ?>','<?php echo $user_info; ?>','<?php echo $reservation_info; ?>');"><?php echo $reservation["reservation_email"]; ?></a></div>
			
        </div>
    </div>
    <div class="reservation_row_col8 <?php echo $class; ?>">
        <div id="table_cell"><span id="conferma_<?php echo $reservationId; ?>"><?php if($reservation["reservation_confirmed"]=='1' && $reservation["reservation_cancelled"] == 0) { ?><a href="javascript:unconfirmReservation(<?php echo $reservationId; ?>);"><img src="images/icons/published.png" border=0 /></a><?php } else if($reservation["reservation_cancelled"] == 0){ ?><a href="javascript:confirmReservation(<?php echo $reservationId; ?>);"><img src="images/icons/unpublished.png" border=0 /></a><?php } else { ?><?php echo $langObj->getLabel("RESERVATIONS_CANCELLED");?><?php } ?></span></div>
    </div>
    <div class="reservation_row_col9 <?php echo $class; ?>">
        <div id="table_cell"><a href="javascript:delItem(<?php echo $reservationId; ?>,'reservations','reservation_id');"><?php echo $langObj->getLabel("RESERVATIONS_DELETE");?></a></div>
    </div>                            
    <div class="reservation_row_col10 <?php echo $class; ?>">
        <div id="table_cell"><a href="reservation_detail.php?reservation_id=<?php echo $reservationId; ?>"><?php echo $langObj->getLabel("RESERVATIONS_DETAIL");?></a></div>
    </div>
    <div id="empty"></div>
</div>
<?php 
$i++;
} ?>
