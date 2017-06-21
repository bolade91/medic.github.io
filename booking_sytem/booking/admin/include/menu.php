<script>
	$().ready(
		  function() {
			// nascondo tutti i sottomenu
			$("#s1").hide();
			$("#s2").hide();
			// mostro i sottomenu del blocco principale 1
			$("#p1").mouseenter(
			  function() {
				if ($("#s1").is(":hidden")) $("#s1").slideDown(); else $("#s1").slideUp();
			  }
			);	
			$("#p2").mouseenter(
			  function() {
				if ($("#s2").is(":hidden")) $("#s2").slideDown(); else $("#s2").slideUp();
			  }
			);	
			
			// mostro i sottomenu del blocco principale 1
			$("#p1").mouseleave(
			  function() {
				$("#s1").slideUp();
			  }
			);	
			$("#p2").mouseleave(
			  function() {
				$("#s2").slideUp();
			  }
			);	
					
		  }
		);
</script>
<!-- header -->
<div id="header_container">    
	<?php
    if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != 0) { 
	?>    
        <div class="header_left">
            <div class="header_title"><h1><?php echo $langObj->getLabel("MENU_CONTROL_PANEL_TITLE"); ?></h1></div>
            <div class="link_website"><a href="../" target="_blank"><?php echo $langObj->getLabel("MENU_GO_TO_SITE"); ?></a></div>
        </div>
        <div class="header_identity_container">
            <div class="header_identity"><?php echo $langObj->getLabel("MENU_LOGGED_AS"); ?> <strong><?php echo $_SESSION["admin_name"]?></strong></div>
            <div class="header_logout"><strong><a href="logout.php"><?php echo $langObj->getLabel("MENU_LOGOUT"); ?></a></strong></div>
        </div>        
        <div id="cleardiv"></div>        
        <div class="line_dotted"></div>
    
    <?php
	} else { 
	?>
        <div class="header_left">
            <div class="header_title"><h1><?php echo $langObj->getLabel("MENU_CONTROL_PANEL_TITLE"); ?></h1></div>
        </div>        
        <div id="cleardiv"></div>        
        <div class="line_dotted"></div>    
    <?php 
	} 
	?>    
</div>
<div id="cleardiv"></div>    
<!-- menu -->
<div id="menu_container">
    <div id="menu">
    <ul>
    	
        <?php
        if(isset($_SESSION["admin_id"]) && $_SESSION["admin_id"] != 0) { 
		?>
        	<li><a href="welcome.php" class="home_button"></a></li>
            
            <?php
			if($settingObj->getReservationConfirmationMode() == 0 && $settingObj->getSiteDomain() == '') {
				?>
                <li><a href="configuration.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"configuration.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_SETTINGS"); ?></a></li>
                <li><a href="#" style='color: #666;'><?php echo $langObj->getLabel("MENU_CATEGORIES"); ?></a></li>
                <li><a href="#" style='color: #666;'><?php echo $langObj->getLabel("MENU_CALENDARS"); ?></a></li>
				<li><a href="#" style='color: #666;'><?php echo $langObj->getLabel("MENU_RESERVATIONS"); ?></a></li>
                <li><a href="#" style='color: #666;'><?php echo $langObj->getLabel("MENU_MANAGE_MAIL"); ?></a></li>
				<li><a href="#" style='color: #666;'><?php echo $langObj->getLabel("MENU_FORM_MANAGEMENT"); ?></a></li>
				<li><a href="#" style='color: #666;'><?php echo $langObj->getLabel("MENU_CHANGE_ADMIN_PASSWORD"); ?></a></li>
                <li><a href="#" style='color: #666;'><?php echo $langObj->getLabel("MENU_META_TAGS"); ?></a></li>
                <?php
			} else {
				?>
                
                <li id="p1"><a href="#" <?php if(stristr($_SERVER["SCRIPT_NAME"],"styles.php") || stristr($_SERVER["SCRIPT_NAME"],"configuration.php") || stristr($_SERVER["SCRIPT_NAME"],"texts_management.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_SETTINGS"); ?></a>
                	<ul id="s1">
                    	<li><a href="configuration.php"><?php echo $langObj->getLabel("MENU_GENERAL_SETTINGS"); ?></a></li>
                    	<li><a href="styles.php"><?php echo $langObj->getLabel("MENU_BG_AND_COLORS"); ?></a></li>
                        <li><a href="texts.php"><?php echo $langObj->getLabel("MENU_TEXT_MANAGEMENT"); ?></a></li>
                    </ul>
                </li>
                <li><a href="categories.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"categories.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_CATEGORIES"); ?></a></li>
				<li><a href="calendars.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"calendars.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_CALENDARS"); ?></a></li>
				<li><a href="reservations.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"reservations.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_RESERVATIONS"); ?></a></li>
                <li><a href="mails.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"mails.php") || stristr($_SERVER["SCRIPT_NAME"],"new_mail.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_MANAGE_MAIL"); ?></a></li>
				<li><a href="form_management.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"form_management.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_FORM_MANAGEMENT"); ?></a></li>
				<li><a href="password.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"password.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_CHANGE_ADMIN_PASSWORD"); ?></a></li>
                <li><a href="metatags.php" <?php if(stristr($_SERVER["SCRIPT_NAME"],"metatags.php")) { echo "style='background-color: #666;'"; }?>><?php echo $langObj->getLabel("MENU_META_TAGS"); ?></a></li>
				<?php
			}
			?>
            
        <?php
		}
		?>
    </ul>
   </div>
</div>
