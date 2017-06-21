<?php
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}
if(isset($_POST["password_confirm"])) {	
	$adminObj->updatePassword();
	?>
    <script>
		alert("<?php echo addslashes($langObj->getLabel("PASSWORD_CHANGED_ALERT")); ?>");
		document.location.href="welcome.php";
	</script>
    <?php	
}

include 'include/header.php';
?>
<script language="javascript" type="text/javascript">
	function checkData(frm) {
		with(frm) {
			if(Trim(old_password.value)== '') {
				alert("<?php echo addslashes($langObj->getLabel("PASSWORD_OLD_ALERT")); ?>");
				return false;
			} else if(Trim(password.value) == '' || Trim(password_confirm.value) == '' || Trim(password.value) != Trim(password_confirm.value)) {
				alert("<?php echo addslashes($langObj->getLabel("PASSWORD_NEW_CONFIRM_ALERT")); ?>");
				return false;
			} else {
				$.ajax({
				  url: 'ajax/checkOldPassword.php?old='+old_password.value,
				  success: function(data) {
					if(data == 1) {
						frm.submit();
					} else {
						alert("<?php echo addslashes($langObj->getLabel("PASSWORD_OLD_INCORRECT_ALERT")); ?>");
					}
				  }
				});
				return false;
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
        	<form name="editsettings" action="" method="post" onsubmit="return checkData(this);">           
                
                <div id="label_input">
                    <div class="label_title"><label for="old_password"><?php echo $langObj->getLabel("PASSWORD_OLD_LABEL"); ?></label><br /><span id="span_description"><?php echo $langObj->getLabel("PASSWORD_OLD_SUBLABEL"); ?></span></div>
                </div>
                <div id="input_box">
                    <input type="password" class="long_input_box" id="old_password" name="old_password" value="">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <div id="label_input">
                    <div class="label_title"><label for="password"><?php echo $langObj->getLabel("PASSWORD_NEW_LABEL"); ?></label></div>
                </div>
                <div id="input_box">
                    <input type="password" class="long_input_box" id="password" name="password" value="">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <div id="label_input">
                    <div class="label_title"><label for="password_confirm"><?php echo $langObj->getLabel("PASSWORD_CONFIRM_LABEL"); ?></label><br /><span id="span_description"><?php echo $langObj->getLabel("PASSWORD_CONFIRM_SUBLABEL"); ?></span></div>
                </div>
                <div id="input_box">
                    <input type="password" class="long_input_box" id="password_confirm" name="password_confirm" value="">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                
               
                <div class="bridge_buttons_container">
                    <!-- cancel -->
                    <div ><a href="javascript:document.location.href='';" class="cancel_button"><?php echo $langObj->getLabel("PASSWORD_CANCEL_BUTTON"); ?></a></div>
                    
                    <!-- save -->
                    <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("PASSWORD_SAVE_BUTTON"); ?>"></div>
                    
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