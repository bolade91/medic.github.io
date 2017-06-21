<?php
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}
if(isset($_POST["reservation_confirmation_mode"])) {	
	$settingObj->updateSettings();
	header('Location: welcome.php');	
}

$arrayTimezones = $listObj->getTimezonesList();

?>
<!-- 
=======================
=== header ==
=======================
-->
<?php
include 'include/header.php';
?>

<!-- 
=======================
=== js ==
=======================
-->
<script language="javascript" type="text/javascript">
	$(function() {
		<?php
		if($settingObj->getReservationConfirmationMode() == "2") {
			?>			
			$('#redirect_path_container').fadeIn();			
			<?php
			if($settingObj->getRedirect()!='') {
				?>
				$('#add_redirect').prop('checked',true);
				$('#redirect_text').slideDown();
				<?php
			}
		}
		if($settingObj->getRecaptchaEnabled() == "1") {
			?>
			$('#recaptcha_enabled').prop("checked",true);
			$('#recaptcha_options').slideDown();
			$('#recaptcha_public_key').attr("tmt:required","true");
			$('#recaptcha_private_key').attr("tmt:required","true");
			<?php
		}
		if($settingObj->getReservationCancel() == "1") {
			?>			
			$('#redirect_cancel_path_container').fadeIn();			
			<?php
			if($settingObj->getCancelRedirect()!='') {
				?>
				$('#add_cancel_redirect').prop("checked",true);
				$('#redirect_cancel_text').slideDown();
				<?php
			}
		}
		?>
		showTermsFields(<?php echo $settingObj->getShowTerms(); ?>);
		showPaypalFields(<?php echo $settingObj->getPaypal(); ?>);
		showCustomOptions(<?php echo $settingObj->getSlotsUnlimited(); ?>);
	});
	function showRedirect(val) {
		if(val == 2) {
			$('#redirect_path_container').fadeIn();
		} else {
			$('#redirect_path_container').fadeOut();
		}
	}
	function showRecaptchaOptions(el) {
		if(el.checked) {
			$('#recaptcha_options').slideDown();
			$('#recaptcha_public_key').attr("tmt:required","true");
			$('#recaptcha_private_key').attr("tmt:required","true");
		} else {
			$('#recaptcha_options').slideUp();
			$('#recaptcha_public_key').attr("tmt:required","false");
			$('#recaptcha_private_key').attr("tmt:required","false");
		}
	}
	
	function showRedirectPath(el) {
		if(el.checked) {
			$('#redirect_text').slideDown();
		} else {
			$('#redirect_text').slideUp();
			$('#redirect_confirmation_path').val('');
		}
	}
	
	function showCancelRedirect(el) {
		if(el.checked) {
			$('#redirect_cancel_path_container').fadeIn();
		} else {
			$('#redirect_cancel_path_container').fadeOut();
		}
	}
	function showCancelRedirectPath(el) {
		if(el.checked) {
			$('#redirect_cancel_text').slideDown();
		} else {
			$('#redirect_cancel_text').slideUp();
			$('#redirect_cancel_path').val('');
		}
	}
	function showTermsFields(val) {
		if(val==1) {
			$('#terms_fields').slideDown();
		} else {
			$('#terms_fields').slideUp();
			
		}
	}
	function showPaypalFields(val) {
		if(val==1) {
			$('#paypal_fields').slideDown();
		} else {
			$('#paypal_fields').slideUp();
			
		}
	}
	
	function showCustomOptions(val) {
		if(val==2) {
			$('#custom_options').slideDown();
		} else {
			$('#custom_options').slideUp();
			
		}
	}
	
	function displayError(formNode,validators) {
		for(var i=0;i<validators.length;i++){
			if(validators[i].name == 'reservation_confirmation_mode') {
				$('#reservation_confirmation_mode_label').css('color','#C00');
			}
		  
		 }
		 var error="";
		 for(var i=0;i<validators.length;i++){
		  error += "\r\n"+validators[i].message;
		 }
		 if(Trim(error)!='') {
		 	alert(error);
		 }
	}
	
</script>

 <!-- 
=======================
=== main content ==
=======================
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
        
        <!-- 
        =======================
        === form ==
        =======================
        -->
        <div id="form_container">
        	<form name="editsettings" action="" method="post" tmt:validate="true" enctype="multipart/form-data" tmt:callback="displayError">           
                
                <!-- 
                =======================
                === Absolute path ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="site_domain"><?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_LABEL"); ?></label></div>
                    <div class="label_subtitle">
						<?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_SUBLABEL1"); ?> <strong><?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_SUBLABEL2"); ?></strong><br />
                        <?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_SUBLABEL3"); ?> <strong><?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_SUBLABEL4"); ?></strong> <?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_SUBLABEL5"); ?><strong> <?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_SUBLABEL6"); ?></strong> <?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_SUBLABEL7"); ?>
                    </div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="site_domain" name="site_domain" value="<?php echo $settingObj->getSiteDomain(); ?>" tmt:required="true" tmt:message="<?php echo $langObj->getLabel("CONFIGURATION_SITE_DOMAIN_ALERT"); ?>">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === Timezone ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="timezone"><?php echo $langObj->getLabel("CONFIGURATION_TIMEZONE_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_TIMEZONE_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                	<select name="timezone" id="timezone" tmt:invalidvalue="" tmt:required="true" tmt:message="<?php echo $langObj->getLabel("CONFIGURATION_TIMEZONE_ALERT"); ?>">
                    	<option value=""><?php echo $langObj->getLabel("CONFIGURATION_TIMEZONE_SELECT"); ?></option>
                    	<?php
						foreach($arrayTimezones as $timezoneid => $timezone) {
						?>
                        	<option value="<?php echo $timezone["timezone_value"]; ?>" <?php if(trim($settingObj->getTimezone()) == trim($timezone["timezone_value"])) { echo 'selected="selected"'; }?>><?php echo $timezone["timezone_name"]; ?></option>
						<?php
						}
						?>
                    </select>
                  
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <!-- 
                =======================
                === Date format ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="date_format"><?php echo $langObj->getLabel("CONFIGURATION_DATE_FORMAT_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_DATE_FORMAT_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                   <select name="date_format" style="width:300px">
                   	 <option value="UK" <?php if($settingObj->getDateFormat()=="UK") { echo "selected"; }?>><?php echo $langObj->getLabel("CONFIGURATION_DATE_FORMAT_UK"); ?></option>
                     <option value="US" <?php if($settingObj->getDateFormat()=="US") { echo "selected"; }?>><?php echo $langObj->getLabel("CONFIGURATION_DATE_FORMAT_US"); ?></option>
                     <option value="EU" <?php if($settingObj->getDateFormat()=="EU") { echo "selected"; }?>><?php echo $langObj->getLabel("CONFIGURATION_DATE_FORMAT_EU"); ?></option>
                   </select>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <!-- 
                =======================
                === Time format ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="time_format"><?php echo $langObj->getLabel("CONFIGURATION_TIME_FORMAT_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_TIME_FORMAT_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                   <select name="time_format" style="width:300px">
                   	 <option value="12" <?php if($settingObj->getTimeFormat()=="12") { echo "selected"; }?>><?php echo $langObj->getLabel("CONFIGURATION_TIME_FORMAT_12"); ?></option>
                     <option value="24" <?php if($settingObj->getTimeFormat()=="24") { echo "selected"; }?>><?php echo $langObj->getLabel("CONFIGURATION_TIME_FORMAT_24"); ?></option>
                   </select>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <!-- 
                =======================
                === Email Admin ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="email_reservation"><?php echo $langObj->getLabel("CONFIGURATION_EMAIL_RESERVATION_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_EMAIL_RESERVATION_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="email_reservation" name="email_reservation" value="<?php echo $settingObj->getEmailReservation(); ?>" tmt:required="true" tmt:message="<?php echo $langObj->getLabel("CONFIGURATION_EMAIL_RESERVATION_ALERT"); ?>">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === Email From ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="email_from_reservation"><?php echo $langObj->getLabel("CONFIGURATION_EMAIL_FROM_RESERVATION_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_EMAIL_FROM_RESERVATION_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <?php echo $langObj->getLabel("CONFIGURATION_NAME_FROM_RESERVATION_SIDE_LABEL"); ?>&nbsp;<input type="text" class="long_input_box" id="name_from_reservation" name="name_from_reservation" value="<?php echo $settingObj->getNameFromReservation(); ?>">
                   
                </div>
		<div id="input_box">
                    <?php echo $langObj->getLabel("CONFIGURATION_EMAIL_FROM_RESERVATION_SIDE_LABEL"); ?>&nbsp;<input type="text" class="long_input_box" id="email_from_reservation" name="email_from_reservation" value="<?php echo $settingObj->getEmailFromReservation(); ?>" tmt:required="true" tmt:message="<?php echo $langObj->getLabel("CONFIGURATION_EMAIL_FROM_RESERVATION_ALERT"); ?>">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                ===============================
                === confirmation mode select ==
                ===============================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="reservation_confirmation_mode"  id="reservation_confirmation_mode_label"><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CONFIRMATION_MODE_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CONFIRMATION_MODE_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                	<select name="reservation_confirmation_mode" id="reservation_confirmation_mode" onchange="javascript:showRedirect(this.options[this.selectedIndex].value);" style="width:700px" tmt:invalidvalue="0" tmt:required="true" tmt:message="<?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CONFIRMATION_MODE_ALERT"); ?>">
                    	<option value="0"><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CONFIRMATION_MODE_SELECT"); ?></option>
                    	<option value="1" <?php if($settingObj->getReservationConfirmationMode() == "1") { echo 'selected="selected"'; }?>><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CONFIRMATION_MODE_1"); ?></option>
                        <option value="2" <?php if($settingObj->getReservationConfirmationMode() == "2") { echo 'selected="selected"'; }?>><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CONFIRMATION_MODE_2"); ?></option>
                        <option value="3" <?php if($settingObj->getReservationConfirmationMode() == "3") { echo 'selected="selected"'; }?>><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CONFIRMATION_MODE_3"); ?></option>
                    </select>
                    <div id="redirect_path_container" style="display:none">
                    	<div class="redirect_text"><?php echo $langObj->getLabel("CONFIGURATION_REDIRECT_CONFIRMATION_PATH_LABEL"); ?> <input type="checkbox" name="add_redirect" id="add_redirect" value="1" onclick="javascript:showRedirectPath(this);" /></div>
                    	<div class="redirect_text" style="display:none" id="redirect_text"><?php echo $langObj->getLabel("CONFIGURATION_REDIRECT_CONFIRMATION_PATH_SUBLABEL"); ?>&nbsp;<input type="text" class="short_input_box" name="redirect_confirmation_path" id="redirect_confirmation_path" value="<?php echo $settingObj->getRedirect(); ?>"/></div>
                    </div>
                        
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =================================
                === cancel reservation setting ==
                =================================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="reservation_cancel"><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CANCEL_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CANCEL_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                	<input type="checkbox" name="reservation_cancel" id="reservation_cancel" value ="1" <?php if($settingObj->getReservationCancel() == "1") { echo "checked"; } ?> onclick="javascript:showCancelRedirect(this);"/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_RESERVATION_CANCEL_ENABLED"); ?>
                    <div id="redirect_cancel_path_container" style="display:none">
                    	<div class="redirect_text"><?php echo $langObj->getLabel("CONFIGURATION_REDIRECT_CANCEL_PATH_LABEL"); ?> <input type="checkbox" name="add_cancel_redirect" id="add_cancel_redirect" value="1" onclick="javascript:showCancelRedirectPath(this);" /></div>
                    	<div class="redirect_text" style="display:none" id="redirect_cancel_text"><?php echo $langObj->getLabel("CONFIGURATION_REDIRECT_CANCEL_PATH_SUBLABEL"); ?>&nbsp;<input type="text" class="short_input_box" name="redirect_cancel_path" id="redirect_cancel_path" value="<?php echo $settingObj->getCancelRedirect(); ?>"/></div>
                    </div>
                        
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === google recaptcha ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="recaptcha_enabled"><?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_ENABLED_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_ENABLED_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div >
                	<input type="checkbox" name="recaptcha_enabled" id="recaptcha_enabled" value="1" onclick="javascript:showRecaptchaOptions(this);"/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_ENABLED_ENABLED"); ?>
                </div>
                
                <div id="recaptcha_options" style="display:none">
                    <div id="label_input" style="margin-top: 20px;">
                        <div class="label_title" style="font-weight:normal;"><label for="recaptcha_public_key"><?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_PUBLIC_KEY_LABEL"); ?></label></div>
                        <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_PUBLIC_KEY_SUBLABEL"); ?> <a href="http://www.google.com/recaptcha">http://www.google.com/recaptcha</a></div>
                    </div>
                    <div id="input_box">
                        <input type="text" class="long_input_box" id="recaptcha_public_key" name="recaptcha_public_key" value="<?php echo $settingObj->getRecaptchaPublicKey(); ?>" tmt:required="false" tmt:message="<?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_PUBLIC_KEY_ALERT"); ?>" onblur="javascript:checkRecaptchaPublic();">
                    </div>
                
                    <div id="label_input" style="margin-top: 20px;">
                        <div class="label_title" style="font-weight:normal;"><label for="recaptcha_private_key"><?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_PRIVATE_KEY_LABEL"); ?></label></div>
                        <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_PRIVATE_KEY_SUBLABEL"); ?> <a href="http://www.google.com/recaptcha">http://www.google.com/recaptcha</a></div>
                    </div>
                    <div id="input_box">
                        <input type="text" class="long_input_box" id="recaptcha_private_key" name="recaptcha_private_key" value="<?php echo $settingObj->getRecaptchaPrivateKey(); ?>" tmt:required="false" tmt:message="<?php echo $langObj->getLabel("CONFIGURATION_RECAPTCHA_PRIVATE_KEY_ALERT"); ?>">
                       
                    </div>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                
                
                <!-- 
                ====================================
                === add terms and condition check ==
                ====================================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="show_terms"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_TERMS_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_TERMS_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div>
                	<input type="radio" name="show_terms" value="1" <?php if($settingObj->getShowTerms() == 1) { echo "checked"; }?> onclick="javascript:showTermsFields(1);"/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_TERMS_YES"); ?>&nbsp;<input type="radio" name="show_terms" value="0" <?php if($settingObj->getShowTerms() == 0) { echo "checked"; }?> onclick="javascript:showTermsFields(0);"/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_TERMS_NO"); ?>
                    <div id="terms_fields" class="redirect_text" style="display:none">
                    	<div class="float_left width_300 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_TERMS_LABEL_LABEL"); ?></div>
                        <div class="float_left margin_t_10"><input type="text" class="short_input_box" name="terms_label" id="terms_label" value="<?php echo $settingObj->getTermsLabel(); ?>"/></div>
                        <div class="cleardiv"></div>
                        <div class="float_left width_300 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_TERMS_LINK_LABEL"); ?></div>
                        <div class="float_left margin_t_10"><input type="text" class="short_input_box" name="terms_link" id="terms_link" value="<?php echo $settingObj->getTermsLink(); ?>"/></div>
                    </div>
                </div>
                
                
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                 <!-- 
                =======================
                === slots selection ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="slot_selection"><?php echo $langObj->getLabel("CONFIGURATION_SLOT_SELECTION_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SLOT_SELECTION_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <select name="slot_selection" id="slot_selection">
                    	<option value="0" <?php if($settingObj->getSlotSelection()=="0") { echo 'selected'; }?>><?php echo $langObj->getLabel("CONFIGURATION_SLOT_SELECTION_MULTIPLE"); ?></option>
                        <option value="1" <?php if($settingObj->getSlotSelection()=="1") { echo 'selected'; }?>><?php echo $langObj->getLabel("CONFIGURATION_SLOT_SELECTION_ONE"); ?></option>
                        
                    </select>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === slots unlimited ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="slots_unlimited"><?php echo $langObj->getLabel("CONFIGURATION_SLOTS_UNLIMITED_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SLOTS_UNLIMITED_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div >
                	<select name="slots_unlimited" id="slots_unlimited" onchange="javascript:showCustomOptions(this.options[this.selectedIndex].value);">
                    	<option value="0" <?php if($settingObj->getSlotsUnlimited()=="0") { echo 'selected'; }?>><?php echo $langObj->getLabel("CONFIGURATION_SLOTS_UNLIMITED_ONE"); ?></option>
                        <option value="2" <?php if($settingObj->getSlotsUnlimited()=="2") { echo 'selected'; }?>><?php echo $langObj->getLabel("CONFIGURATION_SLOTS_UNLIMITED_CUSTOM"); ?></option>
                        <option value="1" <?php if($settingObj->getSlotsUnlimited()=="1") { echo 'selected'; }?>><?php echo $langObj->getLabel("CONFIGURATION_SLOTS_UNLIMITED_UNLIMITED"); ?></option>
                        
                        
                    </select>
                    <div id="custom_options" class="redirect_text" style="display:none">
                    	<div class="float_left width_400 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_SLOTS_SEATS_LABEL"); ?>:</div>
                        <div class="float_left margin_t_10"><input type="radio" name="show_slots_seats" value="1" <?php if($settingObj->getShowSlotsSeats() == 1) { echo "checked"; }?> />&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_SLOTS_SEATS_YES"); ?>&nbsp;<input type="radio" name="show_slots_seats" value="0" <?php if($settingObj->getShowSlotsSeats() == 0) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_SLOTS_SEATS_NO"); ?></div>
                        
                        <div class="cleardiv"></div>
                    </div>
                </div>
                
                
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                ========================
                === show booked slots ==
                ========================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="show_booked_slots"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_BOOKED_SLOTS_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_BOOKED_SLOTS_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div >
                	<input type="radio" name="show_booked_slots" value="1" <?php if($settingObj->getShowBookedSlots() == 1) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_BOOKED_SLOTS_YES"); ?>&nbsp;<input type="radio" name="show_booked_slots" value="0" <?php if($settingObj->getShowBookedSlots() == 0) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_BOOKED_SLOTS_NO"); ?>
                </div>
                
                
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === slots popup ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="slots_popup_enabled"><?php echo $langObj->getLabel("CONFIGURATION_SLOTS_POPUP_ENABLED_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SLOTS_POPUP_ENABLED_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div >
                	<input type="radio" name="slots_popup_enabled" id="slots_popup_enabled" value="1" <?php if($settingObj->getSlotsPopupEnabled() == 1) { echo "checked"; } ?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SLOTS_POPUP_ENABLED_ENABLED"); ?>&nbsp;&nbsp;<input type="radio" name="slots_popup_enabled" id="slots_popup_enabled" value="0" <?php if($settingObj->getSlotsPopupEnabled() == 0) { echo "checked"; } ?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SLOTS_POPUP_ENABLED_DISABLED"); ?>
                </div>
                
                
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                ==============================
                === show category selection ==
                ==============================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="show_category_selection"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_CATEGORY_SELECTION_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_CATEGORY_SELECTION_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div >
                	<input type="radio" name="show_category_selection" value="1" <?php if($settingObj->getShowCategorySelection() == 1) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_CATEGORY_SELECTION_YES"); ?>&nbsp;<input type="radio" name="show_category_selection" value="0" <?php if($settingObj->getShowCategorySelection() == 0) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_CATEGORY_SELECTION_NO"); ?>
                </div>
                
                
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                 <!-- 
                ==============================
                === show calendar selection ==
                ==============================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="show_calendar_selection"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_CALENDAR_SELECTION_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_CALENDAR_SELECTION_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div >
                	<input type="radio" name="show_calendar_selection" value="1" <?php if($settingObj->getShowCalendarSelection() == 1) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_CALENDAR_SELECTION_YES"); ?>&nbsp;<input type="radio" name="show_calendar_selection" value="0" <?php if($settingObj->getShowCalendarSelection() == 0) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_CALENDAR_SELECTION_NO"); ?>
                </div>
                
                
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                ===========================
                === Calendar first month ==
                ===========================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="show_first_filled_month"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_FIRST_FILLED_MONTH_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_SHOW_FIRST_FILLED_MONTH_SUBLABEL"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div >
                	<input type="radio" name="show_first_filled_month" value="1" <?php if($settingObj->getShowFirstFilledMonth() == 1) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_FIRST_FILLED_MONTH_YES"); ?>&nbsp;<input type="radio" name="show_first_filled_month" value="0" <?php if($settingObj->getShowFirstFilledMonth() == 0) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_SHOW_FIRST_FILLED_MONTH_NO"); ?>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                ===========================
                === Calendar month limit ==
                ===========================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="calendar_month_limit"><?php echo $langObj->getLabel("CONFIGURATION_CALENDAR_MONTH_LIMIT_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_CALENDAR_MONTH_LIMIT_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_CALENDAR_MONTH_LIMIT_PAST"); ?></div>
                    <div class="float_left margin_t_10"><input type="text" class="long_input_box" style="width: 60px;" id="calendar_month_limit_past" name="calendar_month_limit_past" value="<?php echo $settingObj->getCalendarMonthLimitPast(); ?>"></div>
                    <div class="cleardiv"></div>
                    
                    <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_CALENDAR_MONTH_LIMIT_FUTURE"); ?></div>
                    <div class="float_left margin_t_10"><input type="text" class="long_input_box"  style="width: 60px;" id="calendar_month_limit_future" name="calendar_month_limit_future" value="<?php echo $settingObj->getCalendarMonthLimitFuture(); ?>"></div>
                    <div class="cleardiv"></div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                ================
                === book from and to ==
                ================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="book_from"><?php echo $langObj->getLabel("CONFIGURATION_BOOK_FROM_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_BOOK_FROM_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" style="width: 60px;" id="book_from" name="book_from" value="<?php echo $settingObj->getBookFrom(); ?>">
                </div>
		
				<div id="label_input">
                    <div class="label_subtitle margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_BOOK_TO_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" style="width: 60px;" id="book_to" name="book_to" value="<?php echo $settingObj->getBookTo(); ?>">
                </div>
                
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                ===========================
                === Show price ==
                ===========================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="paypal_display_price"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_DISPLAY_PRICE"); ?>:</label></div>
                    
                </div>
                <div id="rowspace"></div>
                <div >
                	<input type="radio" name="paypal_display_price" value="1" <?php if($settingObj->getPaypalDisplayPrice() == 1) { echo "checked"; }?> />&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_YES"); ?>&nbsp;<input type="radio" name="paypal_display_price" value="0" <?php if($settingObj->getPaypalDisplayPrice() == 0) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_NO"); ?>
                </div>
                <div class="cleardiv"></div>
                <div class="float_left height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_CURRENCY"); ?>:</div>
                <div class="float_left margin_t_10 margin_l_10">
                    <select name="paypal_currency">
                        <option value=""><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_CURRENCY_CHOOSE"); ?></option>
                        <?php
                        $arrayCurrencies = $listObj->getPaypalCurrencyList();
                        foreach($arrayCurrencies as $currencyId => $currency) {
                            ?>
                            <option value="<?php echo $currency["currency_code"]; ?>" <?php if($settingObj->getPaypalCurrency() == $currency["currency_code"]) { echo "selected"; }?>><?php echo $currency["currency_name"]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                 </div>
                <div class="cleardiv"></div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <!-- 
                =============
                === paypal ==
                =============
                -->
                <div id="label_input">
                    <div class="label_title"><label for="show_terms"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_SUBLABEL1"); ?><br /><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_SUBLABEL2"); ?> (<a href="http://www.paypalobjects.com/en_US/ebook/PP_OrderManagement_IntegrationGuide/ipn.html#1071087" target="_blank">Instant Payment Notification</a>) <?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_SUBLABEL3"); ?></div>
                </div>
                <div id="rowspace"></div>
                <div>
                	<div class="float_left">
                	<input type="radio" name="paypal" value="1" <?php if($settingObj->getPaypal() == 1) { echo "checked"; }?> onclick="javascript:showPaypalFields(1);"/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_YES"); ?>&nbsp;<input type="radio" name="paypal" value="0" <?php if($settingObj->getPaypal() == 0) { echo "checked"; }?> onclick="javascript:showPaypalFields(0);"/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_NO"); ?>
                    <div id="paypal_fields" class="redirect_text" style="display:none">
                    	<div class="float_left width_300 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_ACCOUNT"); ?>:</div>
                        <div class="float_left margin_t_10"><input type="text" class="short_input_box" name="paypal_account" id="paypal_account" value="<?php echo $settingObj->getPaypalAccount(); ?>"/></div>
                        <div class="cleardiv"></div>
                        
                        <div class="float_left width_300 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_LOCALE"); ?>:</div>
                        <div class="float_left margin_t_10">
                        	<select name="paypal_locale">
                                <option value=""><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_LOCALE_CHOOSE"); ?></option>
                                <?php
                                $arrayLocales = $listObj->getPaypalLocaleList();
                                foreach($arrayLocales as $localeId => $locale) {
                                    ?>
                                    <option value="<?php echo $locale["locale_code"]; ?>" <?php if($settingObj->getPaypalLocale() == $locale["locale_code"]) { echo "selected"; }?>><?php echo $locale["locale_country"]; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="cleardiv"></div>

                        <div class="float_left width_300 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_CONFIRMATION_MODE_OVERRIDE"); ?></div>

                        <div class="float_left margin_t_10">
                            <input type="radio" name="reservation_confirmation_mode_override" value="1" <?php if($settingObj->getReservationConfirmationModeOverride() == 1) { echo "checked"; }?> />&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_YES"); ?>&nbsp;<input type="radio" name="reservation_confirmation_mode_override" value="0" <?php if($settingObj->getReservationConfirmationModeOverride() == 0) { echo "checked"; }?> />&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_NO"); ?>

                        </div>
                        <div id="rowspace"></div>
                        <div class="cleardiv"></div>

                        <div id="label_input" class="margin_t_10">
                            <div class="label_title"><label for="reservation_after_payment"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_AFTER_PAYMENT_LABEL"); ?></label></div>
                            <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_AFTER_PAYMENT_SUBLABEL"); ?></div>
                        </div>
                        <div id="rowspace"></div>
                        <div>
                            <div class="float_left">
                                <input type="radio" name="reservation_after_payment" value="1" <?php if($settingObj->getReservationAfterPayment() == 1) { echo "checked"; }?>/>&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_YES"); ?>&nbsp;<input type="radio" name="reservation_after_payment" value="0" <?php if($settingObj->getReservationAfterPayment() == 0) { echo "checked"; }?> />&nbsp;<?php echo $langObj->getLabel("CONFIGURATION_PAYPAL_NO"); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="cleardiv"></div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <!-- 
                ================
                === form text ==
                ================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="form_text"><?php echo $langObj->getLabel("CONFIGURATION_FORM_TEXT_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("CONFIGURATION_FORM_TEXT_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="form_text" name="form_text" value="<?php echo $settingObj->getFormText(); ?>">
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                 <!-- 
                =======================
                === control buttons ==
                =======================
                -->
                <!-- bridge buttons -->
                <div class="bridge_buttons_container">
                    <!-- cancel -->
                    <div ><a href="javascript:document.location.href='welcome.php';" class="cancel_button"><?php echo $langObj->getLabel("CONFIGURATION_CANCEL_BUTTON"); ?></a></div>
                    
                    <!-- save -->
                    <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("CONFIGURATION_SAVE_BUTTON"); ?>"></div>
                    
                </div>
                <div id="rowspace"></div>
                
            
            </form>
         </div>
        
        
        </div>
    </div>
</div>

<!-- 
=======================
=== footer ==
=======================
-->
<?php 
include 'include/footer.php';
?>
