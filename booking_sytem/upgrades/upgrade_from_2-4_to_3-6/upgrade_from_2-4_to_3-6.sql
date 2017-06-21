ALTER TABLE `booking_reservation` ADD `admin_confirmed_cancelled` INT NOT NULL AFTER `calendar_id` ;
ALTER TABLE `booking_slots` ADD `slot_av_max` INT NOT NULL AFTER `slot_av` ;
UPDATE booking_slots SET slot_av_max = slot_av WHERE slot_av>0 AND slot_av_max = 0;
INSERT INTO `booking_texts` ( `page_id`, `text_label`, `text_value`)
VALUES
(3,'CONFIGURATION_CANCEL_BUTTON','CANCEL'),
	(3,'CONFIGURATION_SAVE_BUTTON','SAVE'),
	(4,'STYLES_CANCEL_BUTTON','CANCEL'),
	(4,'STYLES_SAVE_BUTTON','SAVE'),
	(12,'TEXTS_CANCEL_BUTTON','CANCEL'),
	(12,'TEXTS_SAVE_BUTTON','SAVE'),
	(5,'NEW_CALENDAR_CANCEL_BUTTON','CANCEL'),
	(5,'NEW_CALENDAR_SAVE_BUTTON','SAVE'),
	(5,'SLOT_CANCEL_BUTTON','CANCEL'),
	(5,'SLOT_SAVE_BUTTON','SAVE'),
	(7,'MAIL_CANCEL_BUTTON','CANCEL'),
	(7,'MAIL_SAVE_BUTTON','SAVE'),
	(8,'FORM_CANCEL_BUTTON','CANCEL'),
	(8,'FORM_SAVE_BUTTON','SAVE'),
	(9,'PASSWORD_CANCEL_BUTTON','CANCEL'),
	(9,'PASSWORD_SAVE_BUTTON','SAVE'),
	(10,'METATAGS_CANCEL_BUTTON','CANCEL'),
	(10,'METATAGS_SAVE_BUTTON','SAVE'),
	(6,'RESERVATIONS_SEARCH','SEARCH'),
	(5,'SLOT_SEARCH','SEARCH'),
	(7,'MAIL_NAME_LABEL','Mail type'),
	(11,'PAYPAL_CONFIRM_NOT_CONFIRMED_1','We\'re sorry'),
	(11,'PAYPAL_CONFIRM_NOT_CONFIRMED_2','There\'s been a problem with your payment and your reservation has been cancelled.'),
	(3,'CONFIGURATION_PAYPAL_SUBLABEL1','Activate this option if you want people to pay the booking fee with Paypal. You must complete all the fields below to activate this service.'),
	(3,'CONFIGURATION_PAYPAL_SUBLABEL2','Note that if you activate IPN'),
	(3,'CONFIGURATION_PAYPAL_SUBLABEL3','in your Paypal profile the system will automatically confirm reservations after payments even if the user closes the browser before being redirected to the Booking Calendar. In the Notification URL text box just put your site address.'),
	(5,'SLOT_AV_MAX_LABEL','Maximum number of bookable seats at once'),
	(5,'SLOT_AV_MAX_SUBLABEL','Choose the maximum number of bookable seats at once by a customer'),
	(6,'RESERVATION_USER_CONTACT_TO_ALERT','You must add at least an email address to send the email'),
	(6,'RESERVATION_USER_CONTACT_SUBJECT_ALERT','Insert a subject for the message'),
	(6,'RESERVATION_USER_CONTACT_MESSAGE_ALERT','Insert a message for the user'),
	(6,'RESERVATION_USER_CONTACT_MODAL_TEXT1','Message to'),
	(6,'RESERVATION_USER_CONTACT_MODAL_TEXT2','Reservation info:'),
	(6,'RESERVATION_USER_CONTACT_TO','To (multiple addresses must be separated by comma)'),
	(6,'RESERVATION_USER_CONTACT_CC','Cc (multiple addresses must be separated by comma)'),
	(6,'RESERVATION_USER_CONTACT_BCC','Bcc (multiple addresses must be separated by comma)'),
	(6,'RESERVATION_USER_CONTACT_SUBJECT','Subject'),
	(6,'RESERVATION_USER_CONTACT_MESSAGE','Message'),
	(6,'RESERVATION_USER_CONTACT_BUTTON','Send'),
	(6,'RESERVATION_PRICE_LABEL','Price'),
	(5,'SLOT_MODIFY_NEW_AV_MAX','New maximum bookable slot seats'),
	(6,'RESERVATION_USER_CONTACT_MESSAGE_SENT','Message successfully sent!'),
	(6,'RESERVATION_USER_CONTACT_MESSAGE_ERROR','An error has occurred. Retry'),
	(5,'SLOTS_AV_MAX_LABEL','Max bookable'),
	(11,'DORESERVATION_MAIL_ADMIN_PRICE','Price'),
	(11,'DORESERVATION_MAIL_USER_PRICE','Price'),
	(11, 'DORESERVATION_ERROR', 'An error occurred. This time slot may be already reserved. Please try again'),
	(3, 'CONFIGURATION_BOOK_TO_SUBLABEL', 'Insert the maximum number of days that a user can book when landing on the calendar. Leave 0 if he can book at any date.'),
	(3, 'CONFIGURATION_NAME_FROM_RESERVATION_SIDE_LABEL', 'Sender name'),
	(3, 'CONFIGURATION_EMAIL_FROM_RESERVATION_SIDE_LABEL', 'E-mail address'),
	(5, 'SLOT_SUBTITLE', 'Remember to limit the time period to a maximum of 3 months at once if you have many slots in a day as there is a limit which prevent to insert more than 2000 slots at once to avoid your  website to crash or block during slots creation'),
	(5, 'SLOT_CUSTOM_TIME_LABEL', 'Even if you want to set a fixed hour (i.e. 6:00), please remember to select minutes too (00) or you\'ll get the error "Duplicated slots"'),
	(11, 'MON', 'MON'), 
	( 11, 'TUE', 'TUE'), 
	(11, 'WED', 'WED'), 
	(11, 'THU', 'THU'),
	(11, 'FRI', 'FRI'), 
	(11, 'SAT', 'SAT'), 
	(11, 'SUN', 'SUN'), 
	(3, 'CONFIGURATION_PAYPAL_CONFIRMATION_MODE_OVERRIDE', 'Do you want the reservations to be automatically confirmed after Paypal payment?'), 
	(3, 'CONFIGURATION_PAYPAL_AFTER_PAYMENT_LABEL', 'Do you want the reservations to be stored in the system only after Paypal Payment?'), 
	(3, 'CONFIGURATION_PAYPAL_AFTER_PAYMENT_SUBLABEL', 'Activating this option, the reservations will be stored into the system ONLY after payment. If Paypal doesn\'t return the payment result, whether the connection is lost, or due to a malfunction, a breakdown, the reservation will be lost and the slot will still be available.'), 
	( 5, 'SLOT_SHOW_DIFFERENT_PRICE_LABEL', 'Do you want to let people pay a discounted price or only a percentage on the total price?'), 
	(5, 'SLOT_PERC_OR_DISCOUNT_LABEL', 'Percentage or discounted price in'), 
	(5, 'SLOT_PERCENTAGE', 'Percentage'), 
	(5, 'SLOT_DISCOUNT', 'Discounted price in'), 
	(5, 'SLOT_SHOW_PRICE', 'Choose what you want to show to customers'), 
	(5, 'SLOT_SHOW_ONLY_FULL_PRICE', 'Show just full price'), 
	(5, 'SLOT_SHOW_ONLY_DISCOUNT_PRICE', 'Show just discounted price'), 
	(5, 'SLOT_SHOW_BOTH_PRICES', 'Show both full and discounted prices'), 
	( 4, 'STYLES_MONTH_NAVIGATION_BUTTONS_COLOR', 'Buttons color:'), 
	( 4, 'STYLES_MONTH_NAVIGATION_BUTTONS_COLOR_HOVER', 'Buttons color on mouse over:'), 
	( 4, 'STYLES_DAY_NAMES_BG', 'Weekdays background color:'), 
	( 4, 'STYLES_CALENDAR_CELLS_ALL', 'Calendar cells (All)'), 
	( 4, 'STYLES_DASHED', 'dashed'), 
	( 4, 'STYLES_DASHED', 'dotted'), 
	( 4, 'STYLES_SOLID', 'solid'), 
	( 4, 'STYLES_AVAILABLE_CELLS_LINE_2_BG', 'Available day second line background color:'), 
	( 4, 'STYLES_AVAILABLE_CELLS_LINE_2_BG_OVER', 'Available day second line background color on mouse over:'), 
	( 4, 'STYLES_NOTAVAILABLE_CELLS_LINE_2_BG_COLOR', 'Not available day second line background color:'), 
	( 4, 'STYLES_CUSTOM_GOOGLE_FONT_LINK', 'Custom Google font link'), 
	( 4, 'STYLES_CUSTOM_GOOGLE_FONT_LINK_SUBTITLE', 'Paste ONLY the url you find in the &lt;link&gt; tag. Example:'), 
	( 4, 'STYLES_CUSTOM_GOOGLE_FONT_CSS_CODE', 'Custom Google font CSS code'), 
	( 4, 'STYLES_CUSTOM_GOOGLE_FONT_CSS_CODE_SUBTITLE', 'Paste here the CSS rule necessary to apply the font. Example:'),
	( 4, 'STYLES_CALENDAR_CELLS_BORDER_STYLE', 'Border style:');

INSERT INTO `booking_config` ( `config_name`, `config_value`)
VALUES 	
	('book_to', '0'),
	('name_from_reservation', 'Booking Calendar'),
	('day_names_bg', '#333333'),
	('day_border', 'dashed'),
	('day_white_line2_bg', '#56c477'),
	('day_white_line2_bg_hover', '#56c477'),
	('month_navigation_button_color', '#FFFFFF'),
	('month_navigation_button_color_hover', '#FFFFFF'),
	('google_font_css_code', ''),
	('google_font_link_code', ''),
	('day_white_line2_disabled_bg','#FFFFFF'),
	('reservation_confirmation_mode_override','0'),
	('reservation_after_payment','0');
	
ALTER TABLE booking_reservation
ADD KEY calendar_id (calendar_id),
ADD KEY slot_cancelled (reservation_cancelled,slot_id) USING BTREE;

ALTER TABLE booking_slots
ADD KEY slot_time_from (slot_time_from),
ADD KEY date_active_cal (slot_active,calendar_id,slot_date) USING BTREE;

ALTER TABLE `booking_reservation` ADD `reservation_fake` INT NOT NULL AFTER `reservation_cancelled` ;
ALTER TABLE `booking_slots` ADD `slot_perc_price` INT NOT NULL AFTER `slot_price` ;
ALTER TABLE `booking_slots` ADD `slot_discount_price` INT NOT NULL AFTER `slot_perc_price` ;
ALTER TABLE `booking_slots` ADD `slot_show_price` INT NOT NULL AFTER `calendar_id` ;