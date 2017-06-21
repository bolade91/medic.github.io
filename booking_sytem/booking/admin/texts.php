<?php
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}

if(isset($_POST["text_label"])) {	
	$langObj->updateTexts();
	header('Location: welcome.php');	
	

}
if(isset($_POST["import_lang"])) {
	$result=$langObj->importLang();
	?>
    <script>
		<?php
		if($result == 1) {
			?>
			alert("Texts successfully imported.");
			<?php
		} else {
			?>
			alert("No texts imported. Upload the files.");
			<?php
		}
		?>
		document.location.href="";
	</script>
    <?php
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
	function showTexts(num) {
		if($('#texts_'+num).css("display") == "none") {
			$('#texts_'+num).fadeIn();
		} else {
			$('#texts_'+num).fadeOut();
		}
	}
	
	function showLoader() {
		$('body').prepend('<div id="sfondo" class="modal_sfondo"><div id="modal_loading" class="modal_loading"><img src="images/loading.png" border=0 /></div></div>');
		return true;
	}
	
	function hideLoader() {
		$('#sfondo').remove();
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
       	<div style="background-color:#FFC; padding:10px;width:900px;margin-top:10px">
        <form name="uploadtexts" action="" method="post" enctype="multipart/form-data">
        	<input type="hidden" name="import_lang" value="1" />
        	<div id="label_input">
            	If you have the old "lang.php" files, upload them here so the most of the texts you've already changed will be imported. Then check carefully the texts in this page as some of them won't be imported.
            </div>
            <div id="input_box">
            	Admin file:&nbsp;<input type="file" name="admin_file" /><br />
                Public file:&nbsp;<input type="file" name="public_file" />
            </div>
            
            <div id="input_box" style="float:right;margin-right:500px;margin-bottom:20px"><input type="submit" value="Import" /></div>
            <div class="cleardiv"></div>
            
        </form>
        </div>
        <div id="form_container">
                
                
              
                
        <!-- 
        =======================
        === Events calendar ==
        =======================
        -->
       
       
        <div id="label_input" class="pointer" onclick="javascript:showTexts(1);">
            <div class="label_title"><?php echo $langObj->getLabel("TEXT_ADMIN_MENU_AND_HEADER"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
        <div id="texts_1" style="display:none !important">
        	<?php
            $arrayTexts = $listObj->getTextsList(1);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
        	<div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(13);">
            <div class="label_title"><?php echo $langObj->getLabel("TEXT_LOGIN_PAGE"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
        <div id="texts_13" style="display:none !important">
        	<?php
            $arrayTexts = $listObj->getTextsList(13);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
        	<div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        </form>
        <div id="label_input" class="pointer" onclick="javascript:showTexts(2);">
            <div class="label_title"><?php echo $langObj->getLabel("TEXT_WELCOME_PAGE"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
        <div id="texts_2" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(2);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(3);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_SETTINGS"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
       <div id="texts_3" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(3);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(4);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_BG_AND_COLORS"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
        <div id="texts_4" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(4);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        <div id="label_input" class="pointer" onclick="javascript:showTexts(5);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_TEXT_MANAGEMENT"); ?></div>
        </div>
       <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
        <div id="texts_5" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(12);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(14);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_CATEGORIES"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
       <div id="texts_14" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(14);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(6);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_CALENDARS"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
       <div id="texts_6" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(5);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(7);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_RESERVATIONS"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">  
        <div id="texts_7" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(6);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(8);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_MANAGE_MAIL"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">
        <div id="texts_8" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(7);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(9);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_FORM_MANAGEMENT"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">
       <div id="texts_9" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(8);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(10);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_CHANGE_ADMIN_PASSWORD"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">
        <div id="texts_10" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(9);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(11);">
            <div class="label_title"><?php echo $langObj->getLabel("MENU_META_TAGS"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">
        <div id="texts_11" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(10);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
        <div id="rowspace"></div>
        <div id="rowline"></div>
        <div id="rowspace"></div>
        
        <div id="label_input" class="pointer" onclick="javascript:showTexts(12);">
            <div class="label_title"><?php echo $langObj->getLabel("TEXT_PUBLIC_SECTION"); ?></div>
        </div>
        <form name="edittexts" action="ajax/saveTexts.php" method="post" tmt:validate="true" enctype="multipart/form-data" target="iframe_submit" onsubmit="return showLoader();">
       <div id="texts_12" style="display:none !important">
			<?php
            $arrayTexts = $listObj->getTextsList(11);
            foreach($arrayTexts as $textId => $text) {
                ?>
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $text["text_label"]; ?>:</div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                        <input type="hidden" name="text_label[]" value="<?php echo $text["text_label"]; ?>" />
                        <textarea name="text_value[]" class="width_570" style="width:500px;"><?php echo $text["text_value"]; ?></textarea>
                    </div>
                    
                    <div class="cleardiv"></div>
                </div>
                <?php
            }
            ?>
            <div class="bridge_buttons_container" style="margin-top:10px">
                
                <!-- save -->
                <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("TEXTS_SAVE_BUTTON"); ?>"></div>
                
            </div>
        </div>
        </form>
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
            <div ><a href="javascript:document.location.href='welcome.php';" class="cancel_button"><?php echo $langObj->getLabel("TEXTS_CANCEL_BUTTON"); ?></a></div>
            
            
        </div>
        <div id="rowspace"></div>
        
          
         </div>
        </div>
    </div>

</div>
<iframe style="border:none;width:0px;height:0px" id="iframe_submit" name="iframe_submit"></iframe>
