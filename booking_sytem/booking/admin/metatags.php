<?php
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}
if(isset($_POST["metatag_title"])) {	
	$settingObj->updateMetatags();
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
        	<form name="editsettings" action="" method="post" enctype="multipart/form-data">           
                <!-- 
                =======================
                === Page Title ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="page_title"><?php echo $langObj->getLabel("METATAGS_PAGE_TITLE_LABEL"); ?></label></div>
                    <div class="label_subtitle"></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="page_title" name="page_title" value="<?php echo $settingObj->getPageTitle(); ?>">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                <!-- 
                =======================
                === Title ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="metatag_title"><?php echo $langObj->getLabel("METATAGS_METATAG_TITLE_LABEL"); ?></label></div>
                    <div class="label_subtitle"></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="metatag_title" name="metatag_title" value="<?php echo $settingObj->getMetatagTitle(); ?>">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === Description ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="metatag_description"><?php echo $langObj->getLabel("METATAGS_METATAG_DESCRIPTION_LABEL"); ?></label></div>
                    <div class="label_subtitle"></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="metatag_description" name="metatag_description" value="<?php echo $settingObj->getMetatagDescription(); ?>">
                   
                </div>
                <div id="rowspace"></div>
                <div id="rowline"></div>
                <div id="rowspace"></div>
                
                <!-- 
                =======================
                === Keywords ==
                =======================
                -->
                <div id="label_input">
                    <div class="label_title"><label for="metatag_keywords"><?php echo $langObj->getLabel("METATAGS_METATAG_KEYWORDS_LABEL"); ?></label></div>
                    <div class="label_subtitle"></div>
                </div>
                <div id="input_box">
                    <input type="text" class="long_input_box" id="metatag_keywords" name="metatag_keywords" value="<?php echo $settingObj->getMetatagKeywords(); ?>">
                   
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
                    <div ><a href="javascript:document.location.href='welcome.php';" class="cancel_button"><?php echo $langObj->getLabel("METATAGS_CANCEL_BUTTON"); ?></a></div>
                    
                    <!-- save -->
                    <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("METATAGS_SAVE_BUTTON"); ?>"></div>
                    
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