<?php 
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}

//manage reservation operations
if(isset($_POST["operation"]) && $_POST["operation"] != '' && isset($_POST["reservations"])) {
	$arrReservation=$_POST["reservations"];
	$qryString = "0";
	for($i=0;$i<count($arrReservation); $i++) {
		$qryString .= ",".$arrReservation[$i];
	}
		
	switch($_POST["operation"]) {
		case "delReservations":
			$reservationObj->delReservations($qryString);
			break;
	}                
	header('Location: reservation.php?calendar_id='.$_GET["calendar_id"]);
}





include 'include/header.php';

$calendarObj->setCalendar($_GET["calendar_id"]);


?>

<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
			<?php
            include 'include/menu.php';
            ?>
           
            <div id="action_bar">
            	<div class="breadcrumb"><strong><?php echo $langObj->getLabel("RESERVATION_YOU_ARE_IN");?></strong>: <a href="reservations.php"><?php echo $langObj->getLabel("RESERVATIONS");?></a> > <?php echo $langObj->getLabel("CALENDAR");?>: <?php echo $calendarObj->getCalendarTitle(); ?> > <?php echo $langObj->getLabel("RESERVATIONS_LIST");?></div>
            </div>
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
			<script>
                $(function() {
                    
                    <?php
					if($settingObj->getDateFormat() == "UK") {
						?>
						$.datepicker.setDefaults( $.datepicker.regional[ "en-GB" ] );
						<?php
					} else if($settingObj->getDateFormat() == "EU") {
						?>
						$.datepicker.setDefaults( $.datepicker.regional[ "eu-EU" ] );
						<?php
					} else {
						?>
						$.datepicker.setDefaults( $.datepicker.regional[ "us-US" ] );
						<?php
					}
					?>
                    $( "#date_to").datepicker({
						altField: "#second_date",
						altFormat: "yy,mm,dd",
						onClose: function( selectedDate ) {
							$( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
						}
					});
                    $( "#date_from").datepicker({
                        altField: "#first_date",
                        altFormat: "yy,mm,dd",
                        
                        onClose: function(selectedDate) { 
                            $( "#date_to" ).datepicker( "option", "minDate", selectedDate );
                            $( "#date_to").datepicker({
                                altField: "#second_date",
                                altFormat: "yy,mm,dd",
                                //minDate: selectedDate,
								onClose: function( selectedDate ) {
									$( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
								}
                            });
                        }
                    });
                    
                    
                });
                
                function orderby(column,type) {
                
                    $.ajax({
                      url: 'ajax/setReservationOrderby.php?order_by='+column+'&type='+type+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
                      success: function(data) {
                          $('#table').hide().html(data).fadeIn(2000);						 
                        
                      }
                    });
                    
                }
                function filterReservations() {
					if($('#search_date option:selected').val() == 1) {
						if(Trim($('#first_date').val()) != '') {
							$('#result_search').html('<img src="images/loading.gif">');
							$.ajax({
							  url: 'ajax/filterReservations.php?date_from='+$('#first_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
							  success: function(data) {
								  $('#date_from').val('');
								  $('#first_date').val('');
								  $('#table').hide().html(data).fadeIn(2000);
								  $('#result_search').html('');
								  goToByScroll("results");
								  $('.action_reset').fadeIn(0);
							  }
							});
						} else {
							alert("<?php echo addslashes($langObj->getLabel("RESERVATION_SELECT_DATE_ALERT"));?>");
						}
					} else if($('#search_date option:selected').val() == 2) {
						if(Trim($('#first_date').val()) != '' && Trim($('#second_date').val()) != '') {
							$('#result_search').html('<img src="images/loading.gif">');
							$.ajax({
							  url: 'ajax/filterReservations.php?date_from='+$('#first_date').val()+"&date_to="+$('#second_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
							  success: function(data) {
								  $('#date_from').val('');
								  $('#date_to').val('');
								  $('#first_date').val('');
								  $('#second_date').val('');
								  $('#table').hide().html(data).fadeIn(2000);
								  $('#result_search').html('');
								  goToByScroll("results");
								  $('.action_reset').fadeIn(0);
							  }
							});
						} else {
							alert("<?php echo addslashes($langObj->getLabel("RESERVATION_SELECT_DATE_RANGE_ALERT"));?>");
						}
					}
                }
                function delItem(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("RESERVATION_DELETE_SINGLE_ALERT"));?>")) {
                        $.ajax({
                          url: 'ajax/delReservationItem.php?item_id='+itemId+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
                          success: function(data) {
                              $('#table').hide().html(data).fadeIn(2000);
                             
                            
                          }
                        });
                    } 
                }
                function confirmReservation(itemId) {
					//have to check if paypal is active and this reservation has a price, if it has, warn the admin that it could not be payed
					<?php
					if($settingObj->getPaypal()==1 && $settingObj->getPaypalAccount() != '' && $settingObj->getPaypalLocale() != '' && $settingObj->getPaypalCurrency() != '') {
						?>
						$.ajax({
						  url: 'ajax/checkSlotPrice.php?reservation_id='+itemId,
						  success: function(data) {
							  if(data>0) {
								  //there's a price
								  if(confirm("<?php echo addslashes($langObj->getLabel("RESERVATION_PAYPAL_CONFIRM_SINGLE_ALERT"));?>")) {
										$.ajax({
										  url: 'ajax/confirmReservation.php?reservation_id='+itemId,
										  success: function(data) {
											  $('#conferma_'+itemId).html('<a href="javascript:unconfirmReservation('+itemId+');"><img src="images/icons/published.png" border=0 /></a>');								 							 
											
										  }
										});
									} 
							  } else {
								  if(confirm("<?php echo addslashes($langObj->getLabel("RESERVATION_CONFIRM_SINGLE_ALERT"));?>")) {
										$.ajax({
										  url: 'ajax/confirmReservation.php?reservation_id='+itemId,
										  success: function(data) {
											  $('#conferma_'+itemId).html('<a href="javascript:unconfirmReservation('+itemId+');"><img src="images/icons/published.png" border=0 /></a>');								 							 
											
										  }
										});
									} 
							  }
							
						  }
						});
						<?php
					} else {
						?>
						if(confirm("<?php echo addslashes($langObj->getLabel("RESERVATION_CONFIRM_SINGLE_ALERT"));?>")) {
							$.ajax({
							  url: 'ajax/confirmReservation.php?reservation_id='+itemId,
							  success: function(data) {
								  $('#conferma_'+itemId).html('<a href="javascript:unconfirmReservation('+itemId+');"><img src="images/icons/published.png" border=0 /></a>');								 							 
								
							  }
							});
						} 
						<?php
					}
					?>
                }
                function unconfirmReservation(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("RESERVATION_UNCONFIRM_SINGLE_ALERT"));?>")) {
                        $.ajax({
                          url: 'ajax/unconfirmReservation.php?reservation_id='+itemId,
                          success: function(data) {
                              $('#conferma_'+itemId).html('<a href="javascript:confirmReservation('+itemId+');"><img src="images/icons/unpublished.png" border=0 /></a>');								 							 
                            
                          }
                        });
                    } 
                }
				
				function showForm(value) {
					if(value==1) {
						$('#form_add').slideDown();
						$('#date_to_field').slideUp();
						$('#from_date_label').html('<?php echo addslashes($langObj->getLabel("RESERVATIONS_DAY"));?>');
					} else if(value==2) {
						$('#form_add').slideDown();
						$('#date_to_field').slideDown();
						$('#from_date_label').html('<?php echo addslashes($langObj->getLabel("RESERVATIONS_FROM"));?>');
					} else {
						$('#form_add').slideUp();
					}
				}
				
				function openSection(div) {
					if(document.getElementById(div).style.display=="none") {
						$('#'+div).slideDown();
					} else {
						$('#'+div).slideUp();
					}
				}
				
				function goToByScroll(id){
					  $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
				}
				
				function resetSearch() {
					 $.ajax({
                          url: 'ajax/resetReservationSearch.php?&calendar_id=<?php echo $_GET["calendar_id"]; ?>',
                          success: function(data) {
                              $('#table').hide().html(data).fadeIn(2000);
                              goToByScroll("results");
							  $('.action_reset').fadeOut(0);
                          }
                        });
				}
				
				function CSVexport() {
					 $.ajax({
					  url: 'ajax/csvExport.php?calendar_id=<?php echo $_GET["calendar_id"]; ?>',
					  success: function(data) {
						  document.location.href = "ajax/reservation.csv";
					  }
					});
				}
                
				
				function contactUser(email,user_info,reservation_info) {
					$('body').prepend('<div id="sfondo" class="modal_sfondo" onclick="hideModal()"></div>');
					$('#contact_modal').fadeIn();
					$('#user_contact_email').val(email);
					$('#user_contact_info').html(user_info);
					$('#reservation_contact_info').html(reservation_info);
				}
				
				function hideModal() {
					$('#sfondo').remove();
					$('#contact_modal').fadeOut();
				}
				
				function checkContactData(frm) {
					with(frm) {
						if(Trim(user_contact_email.value) == '' || !isEmailAddr(user_contact_email,true,'')) {
							alert("<?php echo addslashes($langObj->getLabel("RESERVATION_USER_CONTACT_TO_ALERT"));?>");
							return false;
						} else if(Trim(user_contact_subject.value) == '') {
							alert("<?php echo addslashes($langObj->getLabel("RESERVATION_USER_CONTACT_SUBJECT_ALERT"));?>");
							return false;
						} else if(Trim(user_contact_message.value) == '') {
							alert("<?php echo addslashes($langObj->getLabel("RESERVATION_USER_CONTACT_MESSAGE_ALERT"));?>");
							return false;
						} else {
							return true;
						}
					}
				}
            </script>
            <div id="contact_modal" class="modal_contact" style="display:none !important">
                <div class="margin_b_10"><?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_MODAL_TEXT1");?> <span id="user_contact_info" class="font_bold"></span><br /><br /><?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_MODAL_TEXT2");?><br /><span id="reservation_contact_info"></span></div>
                <form style="display:inline !important" action="ajax/sendUserEmail.php" method="post" target="iframe_submit" onsubmit="return checkContactData(this);">
                    <div><?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_TO");?></div>
                    <div class="margin_t_5"><input type="text" name="user_contact_email" id="user_contact_email" class="width_70p" value="" /></div>
                    <div class="bold margin_t_20"><?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_CC");?></div>
                    <div class="margin_t_5"><input type="text" name="user_contact_cc" class="width_70p" value="" /></div>
                    <div class="bold margin_t_20"><?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_BCC");?></div>
                    <div class="margin_t_5"><input type="text" name="user_contact_bcc" class="width_70p" value="" /></div>
                    <div class="bold margin_t_20"><?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_SUBJECT");?></div>
                    <div class="margin_t_5"><input type="text" name="user_contact_subject" class="width_70p" /></div>
                    <div class="bold margin_t_20"><?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_MESSAGE");?></div>
                    <div class="margin_t_10"><textarea name="user_contact_message" class="width_70p" ></textarea></div>
                    <div class="margin_t_10"><input type="submit" value="<?php echo $langObj->getLabel("RESERVATION_USER_CONTACT_BUTTON");?>" class="send_btn" /></div>
                </form>
            </div>
            <div class="manage_slot_box_container">
                <div class="manage_slot_box_title"><a href="javascript:openSection('create_div');"><?php echo $langObj->getLabel("RESERVATION_SEARCH_RESERVATION_LABEL");?></a></div>
                <div class="manage_slot_box_container_inside" id="create_div" style="display:none">
                    <div id="label_input">
                        <div class="label_subtitle"><?php echo $langObj->getLabel("RESERVATION_SEARCH_RESERVATION_SUBLABEL");?></div>
                    </div>
                
                    <!-- select create closing days -->
                    <div class="select_container">
                        <div class="input_title"><?php echo $langObj->getLabel("RESERVATION_SEARCH_FILTER_DATE_LABEL");?></div>
                        <div class="input_input">
                            <select name="search_date" id="search_date" class="filter_by_date" onchange="javascript:showForm(this.options[this.selectedIndex].value);">
                                <option value="0"><?php echo $langObj->getLabel("RESERVATION_SEARCH_FILTER_DATE_CHOOSE");?></option>
                                <option value="1"><?php echo $langObj->getLabel("RESERVATION_SEARCH_FILTER_DATE_ONE_DAY");?></option>
                                <option value="2"><?php echo $langObj->getLabel("RESERVATION_SEARCH_FILTER_DATE_PERIOD");?></option>
                            </select>
                        </div>
                    </div>
                    <div id="empty"></div>
                    <div id="form_add" style="display:none">
                        <!-- filter by period of time -->
                        <div class="input_boxes_container">
                            <div class="input_title" id="from_date_label" style="width: 50px; text-align:right; margin-right: 10px; margin-left: 30px;"><?php echo $langObj->getLabel("RESERVATIONS_FROM");?></div>
                            <div class="input_input" style="margin-right: 45px;">
                                <input type="text" class="short_input_box" name="date_from" id="date_from" readonly="readonly" >
                                <input type="hidden" name="first_date" id="first_date">
                            </div>
                            <div id="date_to_field" style="display:none">
                                <div class="input_title" style="margin-right: 10px;"><?php echo $langObj->getLabel("RESERVATIONS_TO");?></div>
                                <div class="input_input">
                                    <input type="text" class="short_input_box" name="date_to" id="date_to"  readonly="readonly">
                                    <input type="hidden" name="second_date" id="second_date">
                                </div>
                            </div>
                        
                        </div>
                        
                        <div id="empty"></div>
                            
                        <!-- search -->
                        <div><input type="button" id="search_button" name="saveunpublish" value="<?php echo $langObj->getLabel("RESERVATIONS_SEARCH"); ?>" onclick="javascript:filterReservations();"><div id="result_search" style="float:left;margin-top:35px"></div></div>
                        <div id="empty"></div>
                        
                    </div>
                    <div id="rowspace"></div>
                </div>
                
            </div>
			<a id="results" name="results"></a>
            <div id="action_bar">                 
                <div id="action"><a onclick="javascript:delItems('manage_reservations','reservations[]','delReservations','<?php echo $langObj->getLabel("RESERVATION_DELETE_MULTIPLE_ALERT");?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("RESERVATIONS_DELETE");?></a></div>
                <div id="action"><a onclick="javascript:CSVexport()"><?php echo $langObj->getLabel("CSV_EXPORT");?></a></div>
                <div id="action" class="action_reset" style="display:none"><a onclick="javascript:resetSearch();"><?php echo $langObj->getLabel("RESERVATION_RESET_LABEL");?></a></div>
                <div id="action" style="float:left; padding-left: 5px; font-weight: normal;"><?php echo $langObj->getLabel("RESERVATION_RED_LABEL");?></div>
            </div>
            <form name="manage_reservations" action="" method="post">
                <input type="hidden" name="operation" />
                <input type="hidden" name="reservations[]" value=0 />
                <div id="table_container">
                    <div id="table">
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
							
							$reservation_time = substr($reservation["reservation_time"],0,5);
							if($settingObj->getTimeFormat() == "12") {
								$reservation_time =date('h:i a',strtotime(substr($reservation["reservation_time"],0,5)));
								
							} 
							echo $reservation_time;
							
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
									<a href="javascript:contactUser('<?php echo $reservation["reservation_email"]; ?>','<?php echo $user_info; ?>','<?php echo $reservation_info; ?>');"><?php echo $reservation["reservation_email"]; ?></a>
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
                    </div>
                </div>
            </form>
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
        </div>
    </div>
</div>
<?php 
include 'include/footer.php';
?>
  <iframe name="iframe_submit" id="iframe_submit" style="border:none;display:none;height:0;width:0"></iframe>
