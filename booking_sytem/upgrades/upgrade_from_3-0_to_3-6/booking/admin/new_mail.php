<?php
include 'common.php';

if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}

$mail_id=$_GET["mail_id"];

$mailObj->setMail($mail_id);
if(isset($_POST["mail_text"])) {	
	$mailObj->updateMail();	
	header('Location: mails.php');
}

include 'include/header.php';
?>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "mail_text, mail_signature, mail_cancel_text",
		theme : "advanced",
		plugins:"paste",
		theme_advanced_buttons1 : "pastetext,|,bold,italic,underline,strikethrough,|,bullist,numlist,|,indent,outdent,|,undo,redo,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,charmap",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 :"",
		theme_advanced_disable : "image,anchor,cleanup,help,code,hr,removeformat,sub,sup",
		paste_text_use_dialog : true,
		relative_urls : false,
		remove_script_host : false

	});
	
	function checkData(frm) {
		with(frm) {
			if(mail_subject.value=='') {
				alert("<?php echo addslashes($langObj->getLabel("MAIL_SUBJECT_ALERT")); ?>");
				return false;
			} else if(mail_text.value=='') {
				alert("<?php echo addslashes($langObj->getLabel("MAIL_TEXT_ALERT")); ?>");
				return false;
			} else {
				return true;
			}
		}
	}
</script>

<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
        <?php
        include 'include/menu.php'; 
        ?>
        
        <div id="form_container">
        	<form name="editsettings" action="" method="post" onsubmit="return checkData(this);" tmt:validate="true"> 
                <div id="label_input">
                    <div class="label_title"><label for="mail_name"><?php echo $langObj->getLabel("MAIL_NAME_LABEL"); ?></label></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="mail_name" name="mail_name" value="<?php echo $mailObj->getMailName(); ?>">                   
                </div>
                
                
            	<div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
        		        
                
                <div id="label_input">
                    <div class="label_title"><label for="mail_subject"><?php echo $langObj->getLabel("MAIL_SUBJECT_LABEL"); ?></label></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="mail_subject" name="mail_subject" value="<?php echo $mailObj->getMailSubject(); ?>" tmt:required="true" tmt:message="<?php echo $langObj->getLabel("MAIL_SUBJECT_ALERT"); ?>">                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <div id="label_input">
                    <div class="label_title"><label for="mail_text"><?php echo $langObj->getLabel("MAIL_TEXT_LABEL"); ?></label></div>
                    <div class="label_subtitle" style="padding: 10px 0; font-size: 13px;"><?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL1"); ?><br /><strong><?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL2"); ?></strong>:<?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL3"); ?><br /><strong><?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL4"); ?></strong>:<?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL5"); ?><br />
                    <?php
					if($mail_id==2) {
						?>
						<strong><?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL6"); ?></strong>:<?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL7"); ?><br /><strong><?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL8"); ?></strong>:<?php echo $langObj->getLabel("MAIL_TEXT_SUBLABEL9"); ?>
                        <?php
					}
					?>
                    </div>
                </div>
                <div id="input_box">
                    <textarea class="long_input_box" id="mail_text" name="mail_text" style="height: 160px;"><?php echo $mailObj->getMailText(); ?></textarea>
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <?php
				if($mailObj->getMailId() == 1 || $mailObj->getMailId() == 4) {
				?>
                
                <div id="label_input">
                    <div class="label_title"><label for="mail_cancel_text"><?php echo $langObj->getLabel("MAIL_CANCEL_TEXT_LABEL"); ?></label> <?php echo $langObj->getLabel("MAIL_CANCEL_TEXT_SUBLABEL1"); ?> <?php if($settingObj->getReservationCancel() == "1") { echo "<span style='color:#669900'>".$langObj->getLabel("MAIL_ENABLED")."</span>"; } else { echo "<span style='color:#990000'>".$langObj->getLabel("MAIL_DISABLED")."</span>"; }?></div>
                    <div class="label_subtitle" style="padding: 10px 0; font-size: 13px;"><?php echo $langObj->getLabel("MAIL_CANCEL_TEXT_SUBLABEL2"); ?><br /><strong><?php echo $langObj->getLabel("MAIL_CANCEL_TEXT_SUBLABEL3"); ?></strong>:<?php echo $langObj->getLabel("MAIL_CANCEL_TEXT_SUBLABEL4"); ?><br /><strong><?php echo $langObj->getLabel("MAIL_CANCEL_TEXT_SUBLABEL5"); ?></strong>:<?php echo $langObj->getLabel("MAIL_CANCEL_TEXT_SUBLABEL6"); ?><br />
                    
                </div>
                <div id="input_box">
                    <textarea class="long_input_box" id="mail_cancel_text" name="mail_cancel_text" style="height: 160px;"><?php echo $mailObj->getMailCancelText(); ?></textarea>
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <?php
				} 
				?>
                <div id="label_input">
                    <div class="label_title"><label for="mail_signature"><?php echo $langObj->getLabel("MAIL_SIGNATURE_LABEL"); ?></label></div>
                </div>
                <div id="input_box">
                    <textarea class="long_input_box" id="mail_signature" name="mail_signature"><?php echo $mailObj->getMailSignature(); ?></textarea>
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                
                <!-- bridge buttons -->
                <div class="bridge_buttons_container">
                    <!-- cancel -->
                    <div ><a href="javascript:document.location.href='mails.php';" class="cancel_button"><?php echo $langObj->getLabel("MAIL_CANCEL_BUTTON"); ?></a></div>
                    
                    <!-- save -->
                    <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("MAIL_SAVE_BUTTON"); ?>"></div>
                    
                </div>
                <div id="rowspace"></div>
             </form>
            
         </div>
        
        
        </div>
    </div>
</div>
<?php 
include 'include/footer.php';
?>