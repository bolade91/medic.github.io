<?php 
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}

include 'include/header.php';

$reservationObj->setReservation($_GET["reservation_id"]);
$slotsObj->setSlot($reservationObj->getReservationSlotId());
?>
<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
			<?php
			include 'include/menu.php'; 
			?>
            <script language="javascript" type="text/javascript">
			
				function printDiv() {
					var docprint = window.open("about:blank", "_blank"); 
					var oTable = document.getElementById("detail_page");
					docprint.document.open(); 
					docprint.document.write('<html><head><title>Reservation detail</title><style>#detail_page {margin:auto;width:920px;background-color:#F6F6F5;border: 1px solid #CCCCCC;margin-top:15px;margin-bottom:0px;height:auto;}#title_row_detail {padding-left: 10px;width: 350px;height: 35px;float: left;line-height: 35px;font-weight:bold;}#row_detail {width:560px;height:35px;line-height: 35px;float: left;}#empty { clear: both; }.alternate_table_row_white {background-color:#FFFFFF;}.alternate_table_row_grey {background-color:#F6F6F5;}</style>'); 
					docprint.document.write('</head><body>');
					docprint.document.write(oTable.parentNode.innerHTML);
					docprint.document.write('</body></html>'); 
					docprint.document.close(); 
					docprint.print();
					docprint.close();
				}
                
			
            </script>
            <div id="action_bar">
                <div id="action"><a href="reservation.php?calendar_id=<?php echo $reservationObj->getReservationCalendarId(); ?>"><?php echo $langObj->getLabel("RESERVATIONS_CLOSE"); ?></a></div>
                <div id="action"><a onClick="printDiv('detail_page')"><?php echo $langObj->getLabel("RESERVATIONS_PRINT"); ?></a></div>
            </div>
            <div>
            <div class="detail_page" id="detail_page">
            	<?php
				
				if(in_array("reservation_surname",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_white">
                        <div id="title_row_detail">
                            <?php echo $langObj->getLabel("RESERVATION_SURNAME_LABEL"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_white">
                            <?php echo $reservationObj->getReservationSurname(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				if(in_array("reservation_name",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_grey">
                        <div id="title_row_detail" class="alternate_table_row_grey">
                           <?php echo $langObj->getLabel("RESERVATION_NAME_LABEL"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_grey">
                            <?php echo $reservationObj->getReservationName(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
                    <?php
				}
				if(in_array("reservation_email",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_white">
                        <div id="title_row_detail" class="alternate_table_row_white">
                            <?php echo $langObj->getLabel("RESERVATION_EMAIL_LABEL"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_white">
                            <a href="mailto:<?php echo $reservationObj->getReservationEmail(); ?>"><?php echo $reservationObj->getReservationEmail(); ?></a>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				if(in_array("reservation_phone",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_grey">
                        <div id="title_row_detail" class="alternate_table_row_grey">
                           <?php echo $langObj->getLabel("RESERVATION_PHONE_LABEL"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_grey">
                            <?php echo $reservationObj->getReservationPhone(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				if(in_array("reservation_message",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_white">
                        <div id="title_row_detail" class="alternate_table_row_white">
                           <?php echo $langObj->getLabel("RESERVATION_MESSAGE_LABEL"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_white">
                            <?php echo $reservationObj->getReservationMessage(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				if(in_array("reservation_field1",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_grey">
                        <div id="title_row_detail" class="alternate_table_row_grey">
                           <?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD1"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_grey">
                            <?php echo $reservationObj->getReservationField1(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				if(in_array("reservation_field2",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_white">
                        <div id="title_row_detail" class="alternate_table_row_white">
                           <?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD2"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_white">
                            <?php echo $reservationObj->getReservationField2(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				if(in_array("reservation_field3",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_grey">
                        <div id="title_row_detail" class="alternate_table_row_grey">
                           <?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD3"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_grey">
                            <?php echo $reservationObj->getReservationField3(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				if(in_array("reservation_field4",$settingObj->getVisibleFields())) { 
					?>
                    <div class="alternate_table_row_white">
                        <div id="title_row_detail" class="alternate_table_row_white">
                           <?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD4"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_white">
                            <?php echo $reservationObj->getReservationField4(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				?>
                <div class="alternate_table_row_grey">
                    <div id="title_row_detail" class="alternate_table_row_grey">
                       <?php echo $langObj->getLabel("RESERVATION_DATE_LABEL"); ?>
                    </div>
                    <div id="row_detail" class="alternate_table_row_grey">
                        <?php
                        if($settingObj->getDateFormat() == "UK") {
                            $dateToSend = strftime('%d/%m/%Y',strtotime($slotsObj->getSlotDate()));
                        } else if($settingObj->getDateFormat() == "EU") {
                            $dateToSend = strftime('%Y/%m/%d',strtotime($slotsObj->getSlotDate()));
                        } else {
                            $dateToSend = strftime('%m/%d/%Y',strtotime($slotsObj->getSlotDate()));
                        }
                        ?>
                        <?php echo $dateToSend; ?>
                    </div>
                    <div id="empty"></div>
                </div>
                <div class="alternate_table_row_white">
                    <div id="title_row_detail" class="alternate_table_row_white">
                       <?php echo $langObj->getLabel("RESERVATION_TIME_LABEL"); ?>
                    </div>
                    <div id="row_detail" class="alternate_table_row_white">
                <?php
                        if($settingObj->getTimeFormat() == "12") {
                            $slotTimeFrom = date('h:i a',strtotime(substr($slotsObj->getSlotTimeFrom(),0,5)));
                            
                        } else {
                            $slotTimeFrom = substr($slotsObj->getSlotTimeFrom(),0,5);
                            
                        }
                        if($settingObj->getTimeFormat() == "12") {
                            $slotTimeTo = date('h:i a',strtotime(substr($slotsObj->getSlotTimeTo(),0,5)));
                            
                        } else {
                            $slotTimeTo = substr($slotsObj->getSlotTimeTo(),0,5);
                            
                        }
                        echo $slotTimeFrom." - ".$slotTimeTo;
                        if($slotsObj->getSlotSpecialText() != '') {
                            echo " - ".$slotsObj->getSlotSpecialText();
                        }
                        ?>
                       
                    </div>
                    <div id="empty"></div>
                </div>
                <?php
				if($settingObj->getSlotsUnlimited() == 2) {
					?>
                    <div class="alternate_table_row_grey">
                        <div id="title_row_detail" class="alternate_table_row_grey">
                           <?php echo $langObj->getLabel("RESERVATION_SEATS_LABEL"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_grey">
                            <?php echo $reservationObj->getReservationSeats(); ?>
                        </div>
                        <div id="empty"></div>
                    </div>
					<?php
				}
				?>
                <?php
				if($slotsObj->getSlotPrice() >0) {
					?>
                    <div class="alternate_table_row_grey">
                        <div id="title_row_detail" class="alternate_table_row_grey">
                           <?php echo $langObj->getLabel("RESERVATION_PRICE_LABEL"); ?>
                        </div>
                        <div id="row_detail" class="alternate_table_row_grey">
                            <?php echo money_format('%!.2n',$slotsObj->getSlotPrice()); ?>&nbsp;<?php echo $settingObj->getPaypalCurrency(); ?>
                        </div>
                        <div id="empty"></div>
					</div>
					<?php
				}
				?>
                <div class="alternate_table_row_white">
                    <div id="title_row_detail" class="alternate_table_row_white">
                       <?php echo $langObj->getLabel("RESERVATION_CONFIRMED_LABEL"); ?>
                    </div>
                    <div id="row_detail" class="alternate_table_row_white">
                        <?php 
                        if($reservationObj->getReservationConfirmed() == 1) {
                            echo $langObj->getLabel("RESERVATION_CONFIRMED_YES");
                        } else {
                            echo $langObj->getLabel("RESERVATION_CONFIRMED_NO");
                        }
                        ?>
                    </div>
                    <div id="empty"></div>
                </div>
                <div class="alternate_table_row_grey">
                    <div id="title_row_detail" class="alternate_table_row_grey">
                       <?php echo $langObj->getLabel("RESERVATIONS_CANCELLED"); ?>
                    </div>
                    <div id="row_detail" class="alternate_table_row_grey">
                        <?php 
                        if($reservationObj->getReservationCancelled() == 1) {
                            echo $langObj->getLabel("RESERVATION_CONFIRMED_YES");
                        } else {
                            echo $langObj->getLabel("RESERVATION_CONFIRMED_NO");
                        }
                        ?>
                    </div>
                    <div id="empty"></div>
                </div>
                </div>
             </div>
        	<div id="rowspace"></div>
        </div>
    </div>
</div>
<?php
include 'include/footer.php';
?>
