<?php 
include 'common.php';
require_once(dirname(__FILE__).'/libs/PHPMailer/class.phpmailer.php');
$reservationsList = urldecode($_POST["custom"]);
$orderResult = 0;

// Build the required acknowledgement message out of the notification just received
  $req = 'cmd=_notify-validate';               // Add 'cmd=_notify-validate' to beginning of the acknowledgement

  foreach ($_POST as $key => $value) {         // Loop through the notification NV pairs
    $value = urlencode(stripslashes($value));  // Encode these values
    $req  .= "&$key=$value";                   // Add the NV pairs to the acknowledgement
  }
  
   // Set up the acknowledgement request headers
  $header  = "POST /cgi-bin/webscr HTTP/1.1\r\n";                    // HTTP POST request
  $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
  $header .= "Host: www.paypal.com\r\n";
  $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

  // Open a socket for the acknowledgement request
  $fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

  // Send the HTTP POST request back to PayPal for validation
  fputs($fp, $header . $req);
  
   while (!feof($fp)) {                     // While not EOF
    $res = fgets($fp, 1024);   
	
	
	              // Get the acknowledgement response
       if (strcmp (trim($res), "VERIFIED") == 0) {  // Response contains VERIFIED - process notification
           $orderResult = 1;
           if($settingObj->getPaypal() == 1 && $settingObj->getReservationAfterPayment() == 1) {
               $reservationsArray = explode(",",$reservationsList);
               $slotsArray = Array();
               for($i=0;$i<count($reservationsArray);$i++) {
                   $reservationObj->setReservationByMD5($reservationsArray[$i]);
                   $calendar_id = $reservationObj->getReservationCalendarId();
                   array_push($slotsArray,$reservationObj->getReservationSlotId());
               }
               //check if reservations are already unfaked



               //send email to administrator to confirm the reservation
               $calendarObj->setCalendar($calendar_id);
               if($calendarObj->getCalendarEmail() != '') {
                   $to = $calendarObj->getCalendarEmail();
               } else {
                   $to = $settingObj->getEmailReservation();
               }

               $subject = $langObj->getLabel("DORESERVATION_MAIL_ADMIN_SUBJECT");
               $message=$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE1")."<br>";

               if(in_array("reservation_name",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE2")."</strong>: ".$reservationObj->getReservationName()."<br>";
               }
               if(in_array("reservation_surname",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE3")."</strong>: ".$reservationObj->getReservationSurname()."<br>";
               }
               if(in_array("reservation_email",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE4")."</strong>: ".$reservationObj->getReservationEmail()."<br>";
               }
               if(in_array("reservation_phone",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE5")."</strong>: ".$reservationObj->getReservationPhone()."<br>";
               }

               if(in_array("reservation_message",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE6")."</strong>: ".$reservationObj->getReservationMessage()."<br>";
               }
               if(in_array("reservation_field1",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE10")."</strong>: ".$reservationObj->getReservationField1()."<br>";
               }
               if(in_array("reservation_field2",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE11")."</strong>: ".$reservationObj->getReservationField2()."<br>";
               }
               if(in_array("reservation_field3",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE12")."</strong>: ".$reservationObj->getReservationField3()."<br>";
               }
               if(in_array("reservation_field4",$settingObj->getVisibleFields())) {
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE13")."</strong>: ".$reservationObj->getReservationField4()."<br>";
               }
               $message.="<br><strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE7")."</strong>:<br>";

               $message.="<ul type='disc'>";
               //loop through slots

               for($i=0;$i<count($slotsArray);$i++) {
                   $slotsObj->setSlot($slotsArray[$i]);
                   $calendarObj->setCalendar($calendar_id);
                   $reservationObj->setReservationByMD5($reservationsArray[$i]);

                   $message.="<li>";
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_CALENDAR")."</strong>: ".$calendarObj->getCalendarTitle()."<br>";
                   $dateToSend = strftime('%B %d %Y',strtotime($slotsObj->getSlotDate()));
                   if($settingObj->getDateFormat() == "UK") {
                       $dateToSend = strftime('%d/%m/%Y',strtotime($slotsObj->getSlotDate()));
                   } else if($settingObj->getDateFormat() == "EU") {
                       $dateToSend = strftime('%Y/%m/%d',strtotime($slotsObj->getSlotDate()));
                   } else {
                       $dateToSend = strftime('%m/%d/%Y',strtotime($slotsObj->getSlotDate()));
                   }
                   $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_DATE")."</strong>: ".$dateToSend."<br>";
                   if($settingObj->getTimeFormat() == "12") {
                       $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_TIME")."</strong>: ".$slotsObj->getSlotTimeFromAMPM()."-".$slotsObj->getSlotTimeToAMPM()."<br>";
                   } else {
                       $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_TIME")."</strong>: ".$slotsObj->getSlotTimeFrom()."-".$slotsObj->getSlotTimeTo()."<br>";
                   }
                   if($settingObj->getSlotsUnlimited() == 2) {
                       $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_SEATS")."</strong>: ".$reservationObj->getReservationSeats()."<br>";
                   }
                   if($settingObj->getPaypalDisplayPrice() == 1) {
                       if($slotsObj->getSlotDiscountPrice()>0 || $slotsObj->getSlotPercPrice()>0) {
                           switch($slotsObj->getSlotShowPrice()) {
                               case 0:
                                   $price = money_format('%!.2n',$slotsObj->getSlotPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                                   break;
                               case 1:
                                   if($slotsObj->getSlotDiscountPrice()>0) {
                                       $price = money_format('%!.2n',$slotsObj->getSlotDiscountPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                                   } else if($slotsObj->getSlotPercPrice()>0) {
                                       $price = money_format('%!.2n',($slotsObj->getSlotPrice()/100*$slotsObj->getSlotPercPrice()))."&nbsp;".$settingObj->getPaypalCurrency();
                                   }
                                   break;
                               case 2:
                                   $price =  '<span style="text-decoration: line-through; color: #900;">'.money_format('%!.2n',$slotsObj->getSlotPrice())."&nbsp;".$settingObj->getPaypalCurrency().'</span><span>&nbsp;';
                                   if($slotsObj->getSlotDiscountPrice()>0) {
                                       $price.= money_format('%!.2n',$slotsObj->getSlotDiscountPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                                   } else if($slotsObj->getSlotPercPrice()>0) {
                                       $price.= money_format('%!.2n',($slotsObj->getSlotPrice()/100*$slotsObj->getSlotPercPrice()))."&nbsp;".$settingObj->getPaypalCurrency();
                                   }
                                   $price.= '</span>';
                                   break;
                           }
                       } else {
                           $price= money_format('%!.2n',$slotsObj->getSlotPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                       }
                       $message.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_ADMIN_PRICE")."</strong>: ".$price."<br>";
                   }
                   $message.="</li>";

               }
               $message.="</ul>";
               if($settingObj->getReservationConfirmationMode() == 3) {

                   $message.=$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE8").'<a href="'.$settingObj->getSiteDomain().'/admin/">'.$langObj->getLabel("DORESERVATION_MAIL_ADMIN_MESSAGE9").'</a>';
               }

               $mail             = new PHPMailer(); // defaults to using php "mail()"

               $mail->CharSet = 'UTF-8';
               $body             = $message;
               @$body             = eregi_replace("[\]",'',$body);

               $mail->AddReplyTo($settingObj->getEmailFromReservation(),$settingObj->getNameFromReservation());

               $mail->SetFrom($settingObj->getEmailFromReservation(), $settingObj->getNameFromReservation());

               $address = $to;
               $mail->AddAddress($address, $address);

               $mail->Subject    = $subject;

               $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

               $mail->MsgHTML($body);


               $mail->Send();


               //send reservation email to user
               $to = $reservationObj->getReservationEmail();

               //WARNING!! static mail record ids, if deleted/changed, must be changed here also
               switch($settingObj->getReservationConfirmationMode()) {
                   case "1":
                       $mailObj->setMail(1);
                       break;
                   case "2":
                       $mailObj->setMail(2);
                       break;
                   case "3":
                       $mailObj->setMail(3);
                       break;
               }
               if($settingObj->getPaypal()==1 && $settingObj->getPaypalAccount() != '' && $settingObj->getPaypalLocale() != '' && $settingObj->getPaypalCurrency() != '' && $settingObj->getReservationConfirmationModeOverride() == 1) {
                   $mailObj->setMail(1);
               }
               $subject = $mailObj->getMailSubject();
               //setting username in message
               $message=str_replace("[customer-name]",$reservationObj->getReservationName(),$mailObj->getMailText());
               //check if cancellation is enabled id email is 1
               if($mailObj->getMailId() == 1 && $settingObj->getReservationCancel() == "1") {
                   $message.=$mailObj->getMailCancelText();
               }
               //setting reservation detail in message
               //loop through slots
               $res_details = "";
               for($i=0;$i<count($slotsArray);$i++) {
                   $slotsObj->setSlot($slotsArray[$i]);

                   $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_VENUE")."</strong>: ".$calendarObj->getCalendarTitle()."<br>";
                   $dateToSend = strftime('%B %d %Y',strtotime($slotsObj->getSlotDate()));
                   if($settingObj->getDateFormat() == "UK") {
                       $dateToSend = strftime('%d/%m/%Y',strtotime($slotsObj->getSlotDate()));
                   } else if($settingObj->getDateFormat() == "EU") {
                       $dateToSend = strftime('%Y/%m/%d',strtotime($slotsObj->getSlotDate()));
                   } else {
                       $dateToSend = strftime('%m/%d/%Y',strtotime($slotsObj->getSlotDate()));
                   }
                   $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_DATE")."</strong>: ".$dateToSend."<br>";
                   if($slotsObj->getSlotSpecialMode() == 1) {
                       if($settingObj->getTimeFormat() == "12") {
                           $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFromAMPM()."-".$slotsObj->getSlotTimeToAMPM();
                       } else {
                           $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFrom()."-".$slotsObj->getSlotTimeTo();
                       }
                       if($slotsObj->getSlotSpecialText()!='') {
                           $res_details.=" - ".$slotsObj->getSlotSpecialText();
                       }
                       $res_details.="<br>";
                   } else if($slotsObj->getSlotSpecialMode() == 0 && $slotsObj->getSlotSpecialText() != '') {
                       $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>:".$slotsObj->getSlotSpecialText()."<br>";
                   } else {
                       if($settingObj->getTimeFormat() == "12") {
                           $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFromAMPM()."-".$slotsObj->getSlotTimeToAMPM()."<br>";
                       } else {
                           $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_TIME")."</strong>: ".$slotsObj->getSlotTimeFrom()."-".$slotsObj->getSlotTimeTo()."<br>";
                       }
                   }
                   if($settingObj->getSlotsUnlimited() == 2) {
                       $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_SEATS")."</strong>: ".$reservationObj->getReservationSeats()."<br>";
                   }
                   if($settingObj->getPaypalDisplayPrice() == 1) {
                       if($slotsObj->getSlotDiscountPrice()>0 || $slotsObj->getSlotPercPrice()>0) {
                           switch($slotsObj->getSlotShowPrice()) {
                               case 0:
                                   $price = money_format('%!.2n',$slotsObj->getSlotPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                                   break;
                               case 1:
                                   if($slotsObj->getSlotDiscountPrice()>0) {
                                       $price = money_format('%!.2n',$slotsObj->getSlotDiscountPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                                   } else if($slotsObj->getSlotPercPrice()>0) {
                                       $price = money_format('%!.2n',($slotsObj->getSlotPrice()/100*$slotsObj->getSlotPercPrice()))."&nbsp;".$settingObj->getPaypalCurrency();
                                   }
                                   break;
                               case 2:
                                   $price =  '<span style="text-decoration: line-through; color: #900;">'.money_format('%!.2n',$slotsObj->getSlotPrice())."&nbsp;".$settingObj->getPaypalCurrency().'</span><span>&nbsp;';
                                   if($slotsObj->getSlotDiscountPrice()>0) {
                                       $price.= money_format('%!.2n',$slotsObj->getSlotDiscountPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                                   } else if($slotsObj->getSlotPercPrice()>0) {
                                       $price.= money_format('%!.2n',($slotsObj->getSlotPrice()/100*$slotsObj->getSlotPercPrice()))."&nbsp;".$settingObj->getPaypalCurrency();
                                   }
                                   $price.= '</span>';
                                   break;
                           }
                       } else {
                           $price= money_format('%!.2n',$slotsObj->getSlotPrice())."&nbsp;".$settingObj->getPaypalCurrency();
                       }

                       $res_details.="<strong>".$langObj->getLabel("DORESERVATION_MAIL_USER_PRICE")."</strong>: ".$price."<br>";
                   }
                   $res_details.="<br><br>";

               }
               $message=str_replace("[reservation-details]",$res_details,$message);


               if($mailObj->getMailId() == 2) {
                   //setting reservation confirmation link in message
                   //if he must confirm it via mail, I send the link
                   $message=str_replace("[confirmation-link]","<a href='".CALENDAR_PATH."/confirm.php?reservations=".$listReservations."'>".$langObj->getLabel("DORESERVATION_MAIL_USER_MESSAGE3")."</a>",$message);
                   $message=str_replace("[confirmation-link-url]",CALENDAR_PATH."/confirm.php?reservations=".$listReservations,$message);
               }

               if($mailObj->getMailId() == 1 && $settingObj->getReservationCancel() == "1") {
                   $message=str_replace("[cancellation-link]","<a href='".CALENDAR_PATH."/cancel.php?reservations=".$listReservations."'>".$langObj->getLabel("DORESERVATION_MAIL_USER_MESSAGE4")."</a>",$message);
                   $message=str_replace("[cancellation-link-url]",CALENDAR_PATH."/cancel.php?reservations=".$listReservations,$message);
               }
               $message.="<br><br>".$mailObj->getMailSignature();


               $mail             = new PHPMailer(); // defaults to using php "mail()"

               $mail->CharSet = 'UTF-8';
               $body             = $message;
               @$body             = eregi_replace("[\]",'',$body);

               $mail->AddReplyTo($settingObj->getEmailFromReservation(),$settingObj->getNameFromReservation());

               $mail->SetFrom($settingObj->getEmailFromReservation(), $settingObj->getNameFromReservation());

               $address = $to;
               $mail->AddAddress($address, $address);

               $mail->Subject    = $subject;

               $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

               $mail->MsgHTML($body);


               $mail->Send();

               $reservationObj->unfakeReservations($reservationsList);
           }
           if($settingObj->getReservationConfirmationModeOverride() == 1) {
               $reservationObj->confirmReservations($reservationsList);
           }
           // Send an email announcing the IPN message is VERIFIED
           /*$mail_From    = "IPN@example.com";
           $mail_To      = "d.romeo@wachipi.com";
           $mail_Subject = "VERIFIED IPN";
           $mail_Body    = $req."-".$reservationsList;
           mail($mail_To, $mail_Subject, $mail_Body, $mail_From);*/



           // Authentication protocol is complete - OK to process notification contents

           // Possible processing steps for a payment include the following:

           // Check that the payment_status is Completed
           // Check that txn_id has not been previously processed
           // Check that receiver_email is your Primary PayPal email
           // Check that payment_amount/payment_currency are correct
           // Process payment

       }
       else if (strcmp (trim($res), "INVALID") == 0) {
           $orderResult = 0;
           $reservationObj->deleteReservations($reservationsList);
           //Response contains INVALID - reject notification

           // Authentication protocol is complete - begin error handling

           // Send an email announcing the IPN message is INVALID
           /*$mail_From    = "IPN@example.com";
           $mail_To      = "d.romeo@wachipi.com";
           $mail_Subject = "INVALID IPN";
           $mail_Body    = $req."-".$reservationsList;
     
           mail($mail_To, $mail_Subject, $mail_Body, $mail_From);*/
       }
  }
 

  
   fclose($fp);  // Close the file


/*if($orderResult == 1) {
	
	 //confirm reservation
	 $reservationObj->confirmReservations($reservationsList);
	 $mail_From    = "IPN@example.com";
      $mail_To      = "d.romeo@wachipi.com";
      $mail_Subject = "IPN";
      $mail_Body    = "order result 1".mysql_error();

      mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
 } else {
	 //if payment failed delete reservation to free slot
	 $reservationObj->deleteReservations($reservationsList);
	 $mail_From    = "IPN@example.com";
      $mail_To      = "d.romeo@wachipi.com";
      $mail_Subject = "IPN";
      $mail_Body    = "order result 0".mysql_error();

      mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
 }*/


?>