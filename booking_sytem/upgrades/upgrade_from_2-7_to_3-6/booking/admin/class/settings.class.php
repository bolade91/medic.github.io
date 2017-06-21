<?php

class setting {

    function __construct($db_conn) {
        $this->db = $db_conn;
    }

	private function doSettingQuery($setting) {
        $settingQry = $this->db->prepare("SELECT * FROM booking_config WHERE config_name=?");
        $settingQry->execute(array($setting));
        $rows = $settingQry->fetchAll(PDO::FETCH_ASSOC);

        return $rows[0]["config_value"];
	}
	
	public function getReservationConfirmationMode() {
		return $this->doSettingQuery('reservation_confirmation_mode');
	}
	
	public function getTimezone() {
		return $this->doSettingQuery('timezone');
	}
	
	public function getEmailReservation() {
		return $this->doSettingQuery('email_reservation');
	}
	
	public function getEmailFromReservation() {
		return $this->doSettingQuery('email_from_reservation');
	}

	public function getNameFromReservation() {
		return $this->doSettingQuery('name_from_reservation');
	}
	
	public function getSiteDomain() {
		return $this->doSettingQuery('site_domain');
	}
	
	public function getRecaptchaPublicKey() {
		return $this->doSettingQuery('recaptcha_public_key');
	}
	
	public function getRecaptchaPrivateKey() {
		return $this->doSettingQuery('recaptcha_private_key');
	}
	
	public function getMandatoryFields() {
		$list=$this->doSettingQuery('mandatory_fields');
		$arrFields = Array();
		$arrFields = explode(",",$list);
		return $arrFields;
	}
	
	public function getVisibleFields() {
		$list=$this->doSettingQuery('visible_fields');
		$arrFields = Array();
		$arrFields = explode(",",$list);
		return $arrFields;
	}
	
	public function getRedirect() {
		return $this->doSettingQuery('redirect_confirmation_path');
	}
	
	public function getRecaptchaEnabled() {
		return $this->doSettingQuery('recaptcha_enabled');
	}
	
	public function getSlotsPopupEnabled() {
		return $this->doSettingQuery('slots_popup_enabled');
	}
	
	public function getSlotsUnlimited() {
		return $this->doSettingQuery('slots_unlimited');
	}
	
	public function getReservationCancel() {
		return $this->doSettingQuery('reservation_cancel');
	}
	
	public function getCancelRedirect() {
		return $this->doSettingQuery('redirect_cancel_path');
	}
	
	public function getSlotSelection() {
		return $this->doSettingQuery('slot_selection');
	}
	
	public function getDateFormat() {
		return $this->doSettingQuery('date_format');
	}
	
	public function getTimeFormat() {
		return $this->doSettingQuery('time_format');
	}
	
	public function getShowBookedSlots() {
		return $this->doSettingQuery('show_booked_slots');
	}

	public function getShowCategorySelection() {
		return $this->doSettingQuery('show_category_selection');
	}
	
	public function getShowCalendarSelection() {
		return $this->doSettingQuery('show_calendar_selection');
	}
	
	public function getShowFirstFilledMonth() {
		return $this->doSettingQuery('show_first_filled_month');
	}	
	
	public function getShowSlotsSeats() {
		return $this->doSettingQuery('show_slots_seats');
	}
	
	public function getCalendarMonthLimitPast() {
		return $this->doSettingQuery('calendar_month_limit_past');
	}
	
	public function getCalendarMonthLimitFuture() {
		return $this->doSettingQuery('calendar_month_limit_future');
	}
	
	public function getShowTerms() {
		return $this->doSettingQuery('show_terms');
	}
	
	public function getTermsLabel() {
		return $this->doSettingQuery('terms_label');
	}
	
	public function getTermsLink() {
		return $this->doSettingQuery('terms_link');
	}
	
	public function getBookFrom() {
		return $this->doSettingQuery('book_from');
	}

	public function getBookTo() {
		return $this->doSettingQuery('book_to');
	}
	
	public function getPaypal() {
		return $this->doSettingQuery('paypal');
	}
	
	public function getPaypalAccount() {
		return $this->doSettingQuery('paypal_account');
	}
	
	public function getPaypalPrice() {
		return $this->doSettingQuery('paypal_price');
	}
	
	public function getPaypalCurrency() {
		return $this->doSettingQuery('paypal_currency');
	}
	
	public function getPaypalLocale() {
		return $this->doSettingQuery('paypal_locale');
	}
	
	public function getPaypalDisplayPrice() {
		return $this->doSettingQuery('paypal_display_price');
	}
	
	public function getFormText() {
		return $this->doSettingQuery('form_text');
	}
	
	public function getReservationFieldType($field) {
		$type="text";
        $typeQry = $this->db->prepare("SELECT * FROM booking_fields_types WHERE reservation_field_name=?");
        $typeQry->execute(array($field));

		if($typeQry->rowCount()>0) {
            $rows = $typeQry->fetchAll(PDO::FETCH_ASSOC);
            $type = $rows[0]["reservation_field_type"];
		}
		return $type;
	}

    public function getReservationConfirmationModeOverride() {
        return $this->doSettingQuery('reservation_confirmation_mode_override');
    }

    public function getReservationAfterPayment() {
        return $this->doSettingQuery('reservation_after_payment');
    }
	
	public function updateSettings() {
        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='reservation_confirmation_mode'");
        $query->execute(array($_POST["reservation_confirmation_mode"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='reservation_confirmation_mode_override'");
        $query->execute(array($_POST["reservation_confirmation_mode_override"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='reservation_after_payment'");
        $query->execute(array($_POST["reservation_after_payment"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='timezone'");
        $query->execute(array($_POST["timezone"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='email_reservation'");
        $query->execute(array($_POST["email_reservation"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='email_from_reservation'");
        $query->execute(array($_POST["email_from_reservation"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='name_from_reservation'");
        $query->execute(array($_POST["name_from_reservation"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='site_domain'");
        $query->execute(array($_POST["site_domain"]));

		if(isset($_POST["recaptcha_enabled"]) && $_POST["recaptcha_enabled"] == "1") {
            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='recaptcha_enabled'");
            $query->execute(array($_POST["recaptcha_enabled"]));
		} else {
            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='recaptcha_enabled'");
            $query->execute(array(0));
		}

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='recaptcha_public_key'");
        $query->execute(array($_POST["recaptcha_public_key"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='recaptcha_private_key'");
        $query->execute(array($_POST["recaptcha_private_key"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='slots_popup_enabled'");
        $query->execute(array($_POST["slots_popup_enabled"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='redirect_confirmation_path'");
        $query->execute(array($_POST["redirect_confirmation_path"]));

		if(isset($_POST["reservation_cancel"]) && $_POST["reservation_cancel"] == "1") {
            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='reservation_cancel'");
            $query->execute(array($_POST["reservation_cancel"]));

            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='redirect_cancel_path'");
            $query->execute(array($_POST["redirect_cancel_path"]));
		} else {
            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='reservation_cancel'");
            $query->execute(array(0));

            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='redirect_cancel_path'");
            $query->execute(array(''));
			
		}

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='slot_selection'");
        $query->execute(array($_POST["slot_selection"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='date_format'");
        $query->execute(array($_POST["date_format"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='time_format'");
        $query->execute(array($_POST["time_format"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='slots_unlimited'");
        $query->execute(array($_POST["slots_unlimited"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='show_booked_slots'");
        $query->execute(array($_POST["show_booked_slots"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='show_category_selection'");
        $query->execute(array($_POST["show_category_selection"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='show_calendar_selection'");
        $query->execute(array($_POST["show_calendar_selection"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='calendar_month_limit_past'");
        $query->execute(array($_POST["calendar_month_limit_past"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='calendar_month_limit_future'");
        $query->execute(array($_POST["calendar_month_limit_future"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='show_terms'");
        $query->execute(array($_POST["show_terms"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='terms_label'");
        $query->execute(array($_POST["terms_label"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='terms_link'");
        $query->execute(array($_POST["terms_link"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='book_from'");
        $query->execute(array($_POST["book_from"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='book_to'");
        $query->execute(array($_POST["book_to"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='paypal'");
        $query->execute(array($_POST["paypal"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='paypal_account'");
        $query->execute(array($_POST["paypal_account"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='paypal_currency'");
        $query->execute(array($_POST["paypal_currency"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='paypal_locale'");
        $query->execute(array($_POST["paypal_locale"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='paypal_display_price'");
        $query->execute(array($_POST["paypal_display_price"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='form_text'");
        $query->execute(array($_POST["form_text"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='show_first_filled_month'");
        $query->execute(array($_POST["show_first_filled_month"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='show_slots_seats'");
        $query->execute(array($_POST["show_slots_seats"]));
	}
	
	
	public function updateFormSettings() {
		if(isset($_POST["mandatory_fields"])) {
			$stringMandatory = "";
			for($i=0;$i<count($_POST["mandatory_fields"]);$i++) {
				if($stringMandatory == "") {
					$stringMandatory.=$_POST["mandatory_fields"][$i];
				} else {
					$stringMandatory.=",".$_POST["mandatory_fields"][$i];
				}
			}

            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='mandatory_fields'");
            $query->execute(array($stringMandatory));

		}
		
		if(isset($_POST["visible_fields"])) {
			$stringVisible = "";
			for($i=0;$i<count($_POST["visible_fields"]);$i++) {
				if($stringVisible == "") {
					$stringVisible.=$_POST["visible_fields"][$i];
				} else {
					$stringVisible.=",".$_POST["visible_fields"][$i];
				}
			}
            $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='visible_fields'");
            $query->execute(array($stringVisible));
		}
		
		//update fields type
		$arrayFields = $_POST["reservation_field_name"];
		$arrayTypes = $_POST["field_type"];
		for($i=0;$i<count($arrayFields);$i++) {
            $query = $this->db->prepare("UPDATE booking_fields_types SET reservation_field_type=? WHERE reservation_field_name=?");
            $query->execute(array($arrayTypes[$i],$arrayFields[$i]));
		}
	}
	
	/***METATAGS SECTION***/
	public function getPageTitle() {
		return stripslashes($this->doSettingQuery('page_title'));
	}
	
	public function getMetatagTitle() {
		return stripslashes($this->doSettingQuery('metatag_title'));
	}
	
	public function getMetatagDescription() {
		return stripslashes($this->doSettingQuery('metatag_description'));
	}
	
	public function getMetatagKeywords() {
		return stripslashes($this->doSettingQuery('metatag_keywords'));
	}
	
	public function updateMetatags() {
        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='page_title'");
        $query->execute(array($_POST["page_title"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='metatag_title'");
        $query->execute(array($_POST["metatag_title"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='metatag_description'");
        $query->execute(array($_POST["metatag_description"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='metatag_keywords'");
        $query->execute(array($_POST["metatag_keywords"]));

	}

	/****styles section****/
	
	public function getMonthContainerBg() {
		return stripslashes($this->doSettingQuery('month_container_bg'));
	}
	
	public function getMonthNameColor() {
		return stripslashes($this->doSettingQuery('month_name_color'));
	}
	
	public function getYearNameColor() {
		return stripslashes($this->doSettingQuery('year_name_color'));
	}
	
	public function getDayNamesColor() {
		return stripslashes($this->doSettingQuery('day_names_color'));
	}

    public function getDayNamesBg() {
        return stripslashes($this->doSettingQuery('day_names_bg'));
    }

    public function getDayBorder() {
        return stripslashes($this->doSettingQuery('day_border'));
    }
		
	public function getDayGreyBg() {
		return stripslashes($this->doSettingQuery('day_grey_bg'));
	}
	
	public function getDayWhiteBg() {
		return stripslashes($this->doSettingQuery('day_white_bg'));
	}
	
	public function getDayWhiteBgHover() {
		return stripslashes($this->doSettingQuery('day_white_bg_hover'));
	}
	
	public function getDayWhiteLine1DisabledColor() {
		return stripslashes($this->doSettingQuery('day_white_line1_disabled_color'));
	}
	
	public function getDayWhiteLine2DisabledColor() {
		return stripslashes($this->doSettingQuery('day_white_line2_disabled_color'));
	}

    public function getDayWhiteLine2DisabledBg() {
        return stripslashes($this->doSettingQuery('day_white_line2_disabled_bg'));
    }
	
	public function getDayWhiteLine1Color() {
		return stripslashes($this->doSettingQuery('day_white_line1_color'));
	}
	
	public function getDayWhiteLine1ColorHover() {
		return stripslashes($this->doSettingQuery('day_white_line1_color_hover'));
	}
	
	public function getDayWhiteLine2Color() {
		return stripslashes($this->doSettingQuery('day_white_line2_color'));
	}
	
	public function getDayWhiteLine2ColorHover() {
		return stripslashes($this->doSettingQuery('day_white_line2_color_hover'));
	}

    public function getDayWhiteLine2Bg() {
        return stripslashes($this->doSettingQuery('day_white_line2_bg'));
    }

    public function getDayWhiteLine2BgHover() {
        return stripslashes($this->doSettingQuery('day_white_line2_bg_hover'));
    }

	public function getFormBg() {
		return stripslashes($this->doSettingQuery('form_bg'));
	}
	
	public function getFormColor() {
		return stripslashes($this->doSettingQuery('form_color'));
	}
	
	public function getFieldInputBg() {
		return stripslashes($this->doSettingQuery('field_input_bg'));
	}
	
	public function getFieldInputColor() {
		return stripslashes($this->doSettingQuery('field_input_color'));
	}
	
	public function getRecaptchaStyle() {
		return stripslashes($this->doSettingQuery('recaptcha_style'));
	}
	
	public function getDayRedBg() {
		return stripslashes($this->doSettingQuery('day_red_bg'));
	}
	
	public function getDayRedLine1Color() {
		return stripslashes($this->doSettingQuery('day_red_line1_color'));
	}
	
	public function getDayRedLine2Color() {
		return stripslashes($this->doSettingQuery('day_red_line2_color'));
	}
	
	public function getDayWhiteBgDisabled() {
		return stripslashes($this->doSettingQuery('day_white_bg_disabled'));
	}
	
	public function getMonthNavigationButtonBg() {
		return stripslashes($this->doSettingQuery('month_navigation_button_bg'));
	}
	
	public function getMonthNavigationButtonBgHover() {
		return stripslashes($this->doSettingQuery('month_navigation_button_bg_hover'));
	}

    public function getMonthNavigationButtonColor() {
        return stripslashes($this->doSettingQuery('month_navigation_button_color'));
    }

    public function getMonthNavigationButtonColorHover() {
        return stripslashes($this->doSettingQuery('month_navigation_button_color_hover'));
    }
	
	public function getBookNowButtonBg() {
		return stripslashes($this->doSettingQuery('book_now_button_bg'));
	}
	
	public function getBookNowButtonBgHover() {
		return stripslashes($this->doSettingQuery('book_now_button_bg_hover'));
	}
	
	public function getBookNowButtonColor() {
		return stripslashes($this->doSettingQuery('book_now_button_color'));
	}
	
	public function getBookNowButtonColorHover() {
		return stripslashes($this->doSettingQuery('book_now_button_color_hover'));
	}
	
	public function getClearButtonBg() {
		return stripslashes($this->doSettingQuery('clear_button_bg'));
	}
	
	public function getClearButtonBgHover() {
		return stripslashes($this->doSettingQuery('clear_button_bg_hover'));
	}
	
	public function getClearButtonColor() {
		return stripslashes($this->doSettingQuery('clear_button_color'));
	}
	
	public function getClearButtonColorHover() {
		return stripslashes($this->doSettingQuery('clear_button_color_hover'));
	}
	
	public function getFormCalendarNameColor() {
		return stripslashes($this->doSettingQuery('form_calendar_name_color'));
	}

    public function getGoogleFontCssCode() {
        return stripslashes($this->doSettingQuery('google_font_css_code'));
    }

    public function getGoogleFontLinkCode() {
        return stripslashes($this->doSettingQuery('google_font_link_code'));
    }
	
	public function updateStyles() {
        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='month_container_bg'");
        $query->execute(array($_POST["month_container_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='month_name_color'");
        $query->execute(array($_POST["month_name_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='year_name_color'");
        $query->execute(array($_POST["year_name_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_names_color'");
        $query->execute(array($_POST["day_names_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_grey_bg'");
        $query->execute(array($_POST["day_grey_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_bg'");
        $query->execute(array($_POST["day_white_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_bg_hover'");
        $query->execute(array($_POST["day_white_bg_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_line1_disabled_color'");
        $query->execute(array($_POST["day_white_line1_disabled_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_line2_disabled_color'");
        $query->execute(array($_POST["day_white_line2_disabled_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_line1_color'");
        $query->execute(array($_POST["day_white_line1_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_line1_color_hover'");
        $query->execute(array($_POST["day_white_line1_color_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_line2_color'");
        $query->execute(array($_POST["day_white_line2_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_line2_color_hover'");
        $query->execute(array($_POST["day_white_line2_color_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='form_bg'");
        $query->execute(array($_POST["form_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='form_color'");
        $query->execute(array($_POST["form_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='field_input_bg'");
        $query->execute(array($_POST["field_input_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='field_input_color'");
        $query->execute(array($_POST["field_input_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='recaptcha_style'");
        $query->execute(array($_POST["recaptcha_style"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_red_bg'");
        $query->execute(array($_POST["day_red_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_red_line1_color'");
        $query->execute(array($_POST["day_red_line1_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_red_line2_color'");
        $query->execute(array($_POST["day_red_line2_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='day_white_bg_disabled'");
        $query->execute(array($_POST["day_white_bg_disabled"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='month_navigation_button_bg'");
        $query->execute(array($_POST["month_navigation_button_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='month_navigation_button_bg_hover'");
        $query->execute(array($_POST["month_navigation_button_bg_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='book_now_button_bg'");
        $query->execute(array($_POST["book_now_button_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='book_now_button_bg_hover'");
        $query->execute(array($_POST["book_now_button_bg_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='book_now_button_color'");
        $query->execute(array($_POST["book_now_button_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='book_now_button_color_hover'");
        $query->execute(array($_POST["book_now_button_color_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='clear_button_bg'");
        $query->execute(array($_POST["clear_button_bg"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='clear_button_bg_hover'");
        $query->execute(array($_POST["clear_button_bg_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='clear_button_color'");
        $query->execute(array($_POST["clear_button_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='clear_button_color_hover'");
        $query->execute(array($_POST["clear_button_color_hover"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='form_calendar_name_color'");
        $query->execute(array($_POST["form_calendar_name_color"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='google_font_css_code'");
        $query->execute(array($_POST["google_font_css_code"]));

        $query = $this->db->prepare("UPDATE booking_config SET config_value=? WHERE config_name='google_font_link_code'");
        $query->execute(array($_POST["google_font_link_code"]));

	}
}

?>
