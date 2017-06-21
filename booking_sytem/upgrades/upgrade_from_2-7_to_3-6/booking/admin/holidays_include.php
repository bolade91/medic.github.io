<!-- 
=====================================================================
=====================================================================
-->
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
		
		arrDateFrom=$('#first_date').val().split(",");
		$( "#add_date_to").datepicker({
			altField: "#second_date",
			altFormat: "yy,mm,dd",
			minDate: new Date(arrDateFrom[0],(arrDateFrom[1]-1),arrDateFrom[2]),
			onClose: function(selectedDate) {
				$( "#add_date_from" ).datepicker( "option", "maxDate", selectedDate );
				
			}
			
		 });
		$( "#add_date_from").datepicker({
			altField: "#first_date",
			altFormat: "yy,mm,dd",
			minDate: new Date(),
			 onClose: function(selectedDate) { 
				  $( "#add_date_to" ).datepicker( "option", "minDate", selectedDate );
				  $( "#add_date_to").datepicker({
					altField: "#second_date",
					altFormat: "yy,mm,dd",
					//minDate: selectedDate,
					onClose: function( selectedDate ) {
						$( "#add_date_from" ).datepicker( "option", "maxDate", selectedDate );
					}
		
				 });	
				 
			}

		});
		
	});
	function addDate() {
		if($('#add_dates option:selected').val() == 1) {
			if(Trim($('#add_date_from').val()) != '') {
				//before I check if there are reservation for this date
				$('#result_create').html('<img src="images/loading.gif">');
				$.ajax({
				  url: 'ajax/checkHolidayDate.php?add_dates=1&date_from='+$('#first_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
				  success: function(data) {
					 if(data == 0) {
						 $.ajax({
						  url: 'ajax/addHolidayDate.php?add_dates=1&date_from='+$('#first_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
						  success: function(data) {
							  $(data).hide().appendTo('#table').fadeIn(2000);							 
							  $('#add_date_from').val('');
							  $('#first_date').val('');
							  $('#result_create').html('');
							  openSection('create_div');
							  goToByScroll('goto');
							  $("#add_dates").val(0);
							  showForm(0);

						  }
							  
						  });
					 } else {
						 if(confirm("<?php echo addslashes($langObj->getLabel("HOLIDAYS_RESERVATION_SINGLE_ALERT")); ?>")) {
							 $('#result_create').html('<img src="images/loading.gif">');
							 $.ajax({
							  url: 'ajax/addHolidayDate.php?add_dates=1&date_from='+$('#first_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
							  success: function(data) {
								  $(data).hide().appendTo('#table').fadeIn(2000);							 
								  $('#add_date_from').val('');
								  $('#first_date').val('');
								  $('#result_create').html('');
								  openSection('create_div');
								  goToByScroll('goto');
								  $("#add_dates").val(0);
								  showForm(0);
							  }
								  
							  });
						 } else {
							 $('#result_create').html('');
						 }
					 }
					  
					 
					}
				});
			} else {
				alert("Select a date");
			}
		} else if($('#add_dates option:selected').val() == 2) {
			if(Trim($('#first_date').val()) != '' && Trim($('#second_date').val()) != '') {
				//before I check if there are reservation for this date
				$('#result_create').html('<img src="images/loading.gif">');
				$.ajax({
				  url: "ajax/checkHolidayDate.php?add_dates=2&date_from="+$('#first_date').val()+"&date_to="+$('#second_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
				  success: function(data) {
					 if(data == 0) {
						 $.ajax({
						  url: 'ajax/addHolidayDate.php?add_dates=2&date_from='+$('#first_date').val()+"&date_to="+$('#second_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
						  success: function(data) {
							  $(data).hide().appendTo('#table').fadeIn(2000);							 
							  $('#add_date_from').val('');
							  $('#add_date_to').val('');
							  $('#first_date').val('');
							  $('#second_date').val('');
							  $('#result_create').html('');
							  openSection('create_div');
							  goToByScroll('goto');
							  $("#add_dates").val(0);
							  showForm(0);
						  }
							  
						  });
					 } else {
						 if(confirm("<?php echo addslashes($langObj->getLabel("HOLIDAYS_RESERVATION_MULTIPLE_ALERT")); ?>")) {
							 $('#result_create').html('<img src="images/loading.gif">');
							 $.ajax({
							  url: 'ajax/addHolidayDate.php?add_dates=2&date_from='+$('#first_date').val()+"&date_to="+$('#second_date').val()+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
							  success: function(data) {
								  $(data).hide().appendTo('#table').fadeIn(2000);							 
								  $('#add_date_from').val('');
								  $('#add_date_to').val('');
								  $('#first_date').val('');
								  $('#second_date').val('');
								  $('#result_create').html('');
								  openSection('create_div');
								  goToByScroll('goto');
								  $("#add_dates").val(0);
								  showForm(0);
							  }
								  
							  });
						 } else {
							 $('#result_create').html('');
						 }
					 }
					  
					 
					}
				});
			} else {
				alert("<?php echo addslashes($langObj->getLabel("HOLIDAYS_DATE_ALERT")); ?>");
			}
		}
	}
	function delItem(itemId) {
		if(confirm("<?php echo addslashes($langObj->getLabel("HOLIDAYS_DELETE_SINGLE_ALERT")); ?>")) {
			$.ajax({
			  url: 'ajax/delHolidayItem.php?item_id='+itemId+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
			  success: function(data) {
				  $('#table').hide().html(data).fadeIn(2000);
				 
				
			  }
			});
		}
	}
	function orderby(type) {
		
		$.ajax({
		  url: 'ajax/setHolidayOrderby.php?order_by=date&type='+type+"&calendar_id=<?php echo $_GET["calendar_id"]; ?>",
		  success: function(data) {
			  $('#table').hide().html(data).fadeIn(2000);						 
			
		  }
		});
		
	}
	
	function showForm(value) {
		if(value==1) {
			$('#form_add').slideDown();
			$('#date_to_field').slideUp();
			$('#from_date_label').html('<?php echo addslashes($langObj->getLabel("HOLIDAYS_DAY")); ?>');
		} else if(value==2) {
			$('#form_add').slideDown();
			$('#date_to_field').slideDown();
			$('#from_date_label').html('<?php echo addslashes($langObj->getLabel("HOLIDAYS_FROM")); ?>');
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
</script>

<!-- 
=====================================================================
	Create closing days
=====================================================================
-->

<div class="manage_slot_box_container">
    <div class="manage_slot_box_title"><a href="javascript:openSection('create_div');"><?php echo $langObj->getLabel("CREATE_CLOSING_DAY_TITLE"); ?></a></div>
    <div class="manage_slot_box_container_inside" id="create_div" style="display:none">
        <div id="label_input">
            <div class="label_subtitle"><?php echo $langObj->getLabel("CREATE_CLOSING_DAY_SUBTITLE"); ?></div>
        </div>
    
        <!-- select create closing days -->
        <div class="select_container">
            <div class="input_title"><?php echo $langObj->getLabel("CREATE_CLOSING_DAY_HOW_MANY"); ?></div>
            <div class="input_input">
                <select name="add_dates" id="add_dates" class="filter_by_date" onchange="javascript:showForm(this.options[this.selectedIndex].value);">
                    <option value="0"><?php echo $langObj->getLabel("CREATE_CLOSING_DAY_CHOOSE"); ?></option>
                    <option value="1"><?php echo $langObj->getLabel("CREATE_CLOSING_DAY_SINGLE_DAY"); ?></option>
                    <option value="2"><?php echo $langObj->getLabel("CREATE_CLOSING_DAY_PERIOD"); ?></option>
                </select>
            </div>
        </div>
        <div id="empty"></div>
        <div id="form_add" style="display:none">
            <!-- filter by period of time -->
            <div class="input_boxes_container">
                <div class="input_title" id="from_date_label" style="width: 50px; text-align: right; margin-right: 10px; margin-left: 190px;"><?php echo $langObj->getLabel("HOLIDAYS_FROM"); ?></div>
                <div class="input_input" style="margin-right: 45px;">
                    <input type="text" class="short_input_box" name="add_date_from" id="add_date_from" readonly="readonly" >
                    <input type="hidden" name="first_date" id="first_date">
                </div>
                <div id="date_to_field" style="display:none">
                    <div class="input_title" style="margin-right: 10px;"><?php echo $langObj->getLabel("HOLIDAYS_TO"); ?></div>
                    <div class="input_input">
                        <input type="text" class="short_input_box" name="add_date_to" id="add_date_to"  readonly="readonly">
                        <input type="hidden" name="second_date" id="second_date">
                    </div>
                </div>
            
            </div>
            
            <div id="empty"></div>
                
            <!-- search -->
            <div><input type="button" class="ok_button" style="margin-left: 250px;" name="saveunpublish" value="OK" onclick="javascript:addDate();"><div id="result_create" style="float:left;margin-top:35px"></div></div>
            <div id="empty"></div>
            
        </div>
        <div id="rowspace"></div>
    </div>
    
</div>

<!-- 
=====================================================================
	Closing days list
=====================================================================
-->

<a name="goto" id="goto"></a>
<div id="action_bar"> 
	<div id="action"><a onclick="javascript:delItems('manage_holidays','holidays[]','delHolidays','<?php echo $langObj->getLabel("HOLIDAYS_DELETE_MULTIPLE_ALERT"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("HOLIDAYS_DELETE"); ?></a></div>
</div>


<form name="manage_holidays" action="" method="post">
	<input type="hidden" name="operation" />
	<input type="hidden" name="holidays[]" value=0 />
	<div id="table_container">
		<div id="table">
			<div class="holidays_title_col1">
				<div id="table_cell">#</div>
			</div>
			<div class="holidays_title_col2">
				<div id="table_cell"><input type="checkbox" name="selectAll" onclick="javascript:selectCheckbox('manage_holidays','holidays[]');" /></div>
			</div>
			<div class="holidays_title_col3">
				<div id="table_cell"><?php echo $langObj->getLabel("HOLIDAY_DATE_LABEL"); ?>&nbsp;<a href="javascript:orderby('<?php echo $_SESSION["orderbyHolidayDate"]; ?>');"><img src="images/orderby_<?php echo $_SESSION["orderbyHolidayDate"]; ?>.gif" border=0 /></a></div>
			</div>        
			<div class="holidays_title_col4">
				<div id="table_cell"></div>
			</div>
			<div id="empty"></div>
			<?php                         
			$arrayHolidays = $listObj->getHolidaysList($_SESSION["qryHolidaysOrderString"],$_GET["calendar_id"]);                        
			$i=1;
			foreach($arrayHolidays as $holidayId => $holiday) {							
				if($i % 2) {
					$class="alternate_table_row_white";
				} else {
					$class="alternate_table_row_grey";
				}
			?>
			<div id="row_<?php echo $holidayId; ?>">
				<div class="holidays_row_col1 <?php echo $class; ?>">
					<div id="table_cell"><?php echo $i; ?></div>
				</div>
				<div class="holidays_row_col2 <?php echo $class; ?>">
					<div id="table_cell"><input type="checkbox" name="holidays[]" value="<?php echo $holidayId; ?>" onclick="javascript:disableSelectAll('manage_holidays',this.checked);" /></div>
				</div>                    
				<div class="holidays_row_col3 <?php echo $class; ?>">
					<div id="table_cell">
                    	<?php
						if($settingObj->getDateFormat() == "UK") {
							$dateToSend = strftime('%d/%m/%Y',strtotime($holiday["holiday_date"]));
						} else if($settingObj->getDateFormat() == "EU") {
							$dateToSend = strftime('%Y/%m/%d',strtotime($holiday["holiday_date"]));
						} else {
							$dateToSend = strftime('%m/%d/%Y',strtotime($holiday["holiday_date"]));
						}
						?>
						<?php echo $dateToSend; ?>
                    </div>
				</div>
				<div class="holidays_row_col4 <?php echo $class; ?>">
					<div id="table_cell"><a href="javascript:delItem(<?php echo $holidayId; ?>,'holidays','holiday_id');"><?php echo $langObj->getLabel("HOLIDAYS_DELETE"); ?></a></div>
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