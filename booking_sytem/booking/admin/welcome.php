<?php
include 'common.php';

if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}
include 'include/header.php';
?>

<div id="top_bg_container_all">
    <div id="container_all">
        <div id="container_content">
        	<?php
            include 'include/menu.php';
			?>        
            <!-- welcome -->
            <div id="welcome_container">
                <div class="logo_admin"><img src="images/logo_admin.gif"  /></div>
                <div class="welcome_text"><p><?php echo $langObj->getLabel("WELCOME_TEXT1"); ?><br /><?php echo $langObj->getLabel("WELCOME_TEXT2"); ?></p></div>
                <?php
				if(($settingObj->getReservationConfirmationMode() == 0 && $settingObj->getTimezone() == '' && $settingObj->getSiteDomain() == '') || count($listObj->getCalendarsList()) == 0 ) {
					?>
                    <div class="welcome_text" style="padding: 15px; background-color: #ccc; color: #000;">
                    <p>
					<?php echo $langObj->getLabel("WELCOME_TEXT3"); ?><br />
					<?php echo $langObj->getLabel("WELCOME_TEXT4"); ?><br />
                    <?php echo $langObj->getLabel("WELCOME_TEXT5"); ?><br />
                    <?php echo $langObj->getLabel("WELCOME_TEXT6"); ?><br />
                    <?php echo $langObj->getLabel("WELCOME_TEXT7"); ?><br />
					<?php echo $langObj->getLabel("WELCOME_TEXT8"); ?><strong><?php echo $langObj->getLabel("WELCOME_TEXT9"); ?></strong><br />
                    <?php echo $langObj->getLabel("WELCOME_TEXT10"); ?>
                    </p></div>
                    <?php
				}
				?>
            </div>
        
        
        </div>
    </div>
</div>
<?php 
include 'include/footer.php';
?>