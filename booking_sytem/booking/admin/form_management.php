<?php
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}
if(isset($_POST["mandatory_fields"])) {	
	$settingObj->updateFormSettings();
	header('Location: welcome.php');	
}


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
		showHideMandatory();
	});
	function showHideMandatory() {
		var data = '';
		$('.field_types').fadeOut(0);
		$('#visible_fields option:not(:selected)').each(function() {
			
			$('#mandatory_fields option[value="'+$(this).val()+'"]').fadeOut(0);
			$('#mandatory_fields option[value="'+$(this).val()+'"]').removeAttr("selected");
			
			
		}); 
		$('#visible_fields option:selected').each(function() {
			$('#mandatory_fields option[value="'+$(this).val()+'"]').fadeIn(0);
			$('#field_type_'+$(this).val()).fadeIn(0);
		});
		
		
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
        	<form name="editsettings" action="" method="post" tmt:validate="true" enctype="multipart/form-data">           
                
                <!-- 
                =======================
                === visible fields ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="visible_fields"><?php echo $langObj->getLabel("FORM_VISIBLE_FIELDS_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("FORM_VISIBLE_FIELDS_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <select name="visible_fields[]" id="visible_fields" multiple="multiple" style="width:350px;height:140px" onchange="javascript:showHideMandatory();">
                    	<option value="reservation_name" <?php if(in_array("reservation_name",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_NAME_LABEL"); ?></option>
                        <option value="reservation_surname" <?php if(in_array("reservation_surname",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_SURNAME_LABEL"); ?></option>
                        <option value="reservation_email" <?php if(in_array("reservation_email",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_EMAIL_LABEL"); ?></option>
                        <option value="reservation_phone" <?php if(in_array("reservation_phone",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_PHONE_LABEL"); ?></option>
                        <option value="reservation_message" <?php if(in_array("reservation_message",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_MESSAGE_LABEL"); ?></option>
                        <option value="reservation_field1" <?php if(in_array("reservation_field1",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD1"); ?> </option>
                        <option value="reservation_field2" <?php if(in_array("reservation_field2",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD2"); ?></option>
                         <option value="reservation_field3" <?php if(in_array("reservation_field3",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD3"); ?></option>
                         <option value="reservation_field4" <?php if(in_array("reservation_field4",$settingObj->getVisibleFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD4"); ?></option>
                    </select>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === mandatory fields ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="mandatory_fields"><?php echo $langObj->getLabel("FORM_MANDATORY_FIELDS_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("FORM_MANDATORY_FIELDS_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <select name="mandatory_fields[]" id="mandatory_fields" multiple="multiple" style="width:350px;height:140px">
                    	<option value="reservation_name" <?php if(in_array("reservation_name",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_NAME_LABEL"); ?></option>
                        <option value="reservation_surname" <?php if(in_array("reservation_surname",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_SURNAME_LABEL"); ?></option>
                        <option value="reservation_email" <?php if(in_array("reservation_email",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_EMAIL_LABEL"); ?></option>
                        <option value="reservation_phone" <?php if(in_array("reservation_phone",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_PHONE_LABEL"); ?></option>
                        <option value="reservation_message" <?php if(in_array("reservation_message",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_MESSAGE_LABEL"); ?></option>
                        <option value="reservation_field1" <?php if(in_array("reservation_field1",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD1"); ?></option>
                          <option value="reservation_field2" <?php if(in_array("reservation_field2",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD2"); ?></option> 																																						                         <option value="reservation_field3" <?php if(in_array("reservation_field3",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD3"); ?></option>
                         <option value="reservation_field4" <?php if(in_array("reservation_field4",$settingObj->getMandatoryFields())) { echo 'selected'; }?>><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD4"); ?></option>
                    </select>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <!-- 
                =======================
                === fields type ==
                =======================
                -->
                
                <div id="label_input">
                    <div class="label_title"><label for="field_type"><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_LABEL"); ?></label></div>
                    <div class="label_subtitle"><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_SUBLABEL"); ?></div>
                </div>
                <div id="input_box">
                    <div id="fields_type_container">
                        
                        <div id="field_type_reservation_name" class="field_types">
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_NAME_LABEL"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_name" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_name')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_name')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                        
                        
                        <div id="field_type_reservation_surname" class="field_types">
                            
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_SURNAME_LABEL"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_surname" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_surname')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_surname')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                            
                        </div>
                        
                                                     
                        <div id="field_type_reservation_email" class="field_types">
                        
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_EMAIL_LABEL"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_email" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_email')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_email')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                        
                        
                        
                        <div id="field_type_reservation_phone" class="field_types">
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_PHONE_LABEL"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_phone" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_phone')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_phone')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                        
                        
                        <div id="field_type_reservation_message" class="field_types">
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_MESSAGE_LABEL"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_message" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_message')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_message')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                        
                        
                        
                        <div id="field_type_reservation_field1" class="field_types">
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD1"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_field1" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_field1')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_field1')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                        
                        
                        
                        <div id="field_type_reservation_field2" class="field_types">
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD2"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_field2" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_field2')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_field2')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                        
                        
                        
                        <div id="field_type_reservation_field3" class="field_types">
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD3"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_field3" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_field3')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_field3')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                        
                        
                        
                        <div id="field_type_reservation_field4" class="field_types">
                            <div class="float_left width_150 height_30 line_30 margin_t_10"><?php echo $langObj->getLabel("RESERVATION_ADDITIONAL_FIELD4"); ?>:</div>
                            <div class="float_left margin_t_16"><input type="hidden" name="reservation_field_name[]" value="reservation_field4" />
                                <select name="field_type[]">
                                    <option value="text" <?php if($settingObj->getReservationFieldType('reservation_field4')== 'text') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_TEXT"); ?></option>
                                    <option value="textarea" <?php if($settingObj->getReservationFieldType('reservation_field4')== 'textarea') { echo 'selected'; } ?>><?php echo $langObj->getLabel("FORM_FIELDS_TYPE_AREA"); ?></option>
                                </select>
                            </div>
                            <div class="cleardiv"></div>
                        </div>
                            
                    </div>
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                
                 <!-- 
                =======================
                === control buttons ==
                =======================
                -->
                
                <div class="bridge_buttons_container">
                    <!-- cancel -->
                    <div ><a href="javascript:document.location.href='welcome.php';" class="cancel_button"><?php echo $langObj->getLabel("FORM_CANCEL_BUTTON"); ?></a></div>
                    
                    <!-- save -->
                    <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("FORM_SAVE_BUTTON"); ?>"></div>
                    
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