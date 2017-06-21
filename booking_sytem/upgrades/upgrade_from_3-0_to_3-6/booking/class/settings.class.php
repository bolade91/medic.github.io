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
	
	public function getMetatagTitle() {
		return stripslashes($this->doSettingQuery('metatag_title'));
	}
	
	public function getMetatagDescription() {
		return stripslashes($this->doSettingQuery('metatag_description'));
	}
	
	public function getMetatagKeywords() {
		return stripslashes($this->doSettingQuery('metatag_keywords'));
	}
	
	public function getPageTitle() {
		return stripslashes($this->doSettingQuery('page_title'));
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
	
	public function getShowSlotsSeats() {
		return $this->doSettingQuery('show_slots_seats');
	}	
	
	public function getShowFirstFilledMonth() {
		return $this->doSettingQuery('show_first_filled_month');
	}
	
	public function getShowCategorySelection() {
		return $this->doSettingQuery('show_category_selection');
	}
	
	public function getShowCalendarSelection() {
		return $this->doSettingQuery('show_calendar_selection');
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
		return str_replace(",",".",$this->doSettingQuery('paypal_price'));
	}
	
	public function getPaypalCurrency() {
		return strtoupper($this->doSettingQuery('paypal_currency'));
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
			$type=$rows[0]["reservation_field_type"];
		}
		return $type;
	}

    public function getReservationConfirmationModeOverride() {
        return $this->doSettingQuery('reservation_confirmation_mode_override');
    }

    public function getReservationAfterPayment() {
        return $this->doSettingQuery('reservation_after_payment');
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
	

}

?>
