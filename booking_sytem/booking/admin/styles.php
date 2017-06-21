<?php
include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 20000) {
	header('Location: login.php');
}
if(isset($_POST["day_grey_bg"])) {	
	$settingObj->updateStyles();
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
=== js ==
=======================
-->
<script language="javascript" type="text/javascript">
	
	$(function() {
		<?php
		if($settingObj->getRecaptchaEnabled() == 1) {
			?>
			$('#recaptcha_style').fadeIn();
			<?php
		}
		?>
		$('.color_code_form_calendar_name_color').simpleColor({ 
		 	defaultColor: $('#form_calendar_name_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#form_calendar_name_color').val('#'+hex);
			  
			}
		 });
		$('.color_code_month_container_bg').simpleColor({ 
		 	defaultColor: $('#month_container_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#month_container_bg').val('#'+hex);
			  
			}
		 });
		 $('.color_code_month_name_color').simpleColor({ 
		 	defaultColor: $('#month_name_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#month_name_color').val('#'+hex);
			  
			}
		 });
		 $('.color_code_year_name_color').simpleColor({ 
		 	defaultColor: $('#year_name_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#year_name_color').val('#'+hex);
			  
			}
		 });
		 $('.color_code_day_names_color').simpleColor({ 
		 	defaultColor: $('#day_names_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_names_color').val('#'+hex);
			  
			}
		 });
        $('.color_code_day_names_bg').simpleColor({
            defaultColor: $('#day_names_bg').val(),
            onSelect: function( hex ) {
                //put code in input cell
                $('#day_names_bg').val('#'+hex);

            }
        });
		 
		 $('.color_code_field_input_bg').simpleColor({ 
		 	defaultColor: $('#field_input_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#field_input_bg').val('#'+hex);
			  
			}
		 });
		 $('.color_code_field_input_color').simpleColor({ 
		 	defaultColor: $('#field_input_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#field_input_color').val('#'+hex);
			  
			}
		 });
		 $('.color_code_book_now_button_bg').simpleColor({ 
		 	defaultColor: $('#book_now_button_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#book_now_button_bg').val('#'+hex);
			  
			}
		 });
		  $('.color_code_book_now_button_bg_hover').simpleColor({ 
		 	defaultColor: $('#book_now_button_bg_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#book_now_button_bg_hover').val('#'+hex);
			  
			}
		 });
		  $('.color_code_book_now_button_color').simpleColor({ 
		 	defaultColor: $('#book_now_button_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#book_now_button_color').val('#'+hex);
			  
			}
		 });
		  $('.color_code_book_now_button_color_hover').simpleColor({ 
		 	defaultColor: $('#book_now_button_color_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#book_now_button_color_hover').val('#'+hex);
			  
			}
		 });
		 
		  $('.color_code_month_navigation_button_bg').simpleColor({ 
		 	defaultColor: $('#month_navigation_button_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#month_navigation_button_bg').val('#'+hex);
			  
			}
		 });
		 $('.color_code_month_navigation_button_bg_hover').simpleColor({ 
		 	defaultColor: $('#month_navigation_button_bg_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#month_navigation_button_bg_hover').val('#'+hex);
			  
			}
		 });

        $('.color_code_month_navigation_button_color').simpleColor({
            defaultColor: $('#month_navigation_button_color').val(),
            onSelect: function( hex ) {
                //put code in input cell
                $('#month_navigation_button_color').val('#'+hex);

            }
        });
        $('.color_code_month_navigation_button_color_hover').simpleColor({
            defaultColor: $('#month_navigation_button_color_hover').val(),
            onSelect: function( hex ) {
                //put code in input cell
                $('#month_navigation_button_color_hover').val('#'+hex);

            }
        });
		 $('.color_code_clear_button_bg').simpleColor({ 
		 	defaultColor: $('#clear_button_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#clear_button_bg').val('#'+hex);
			  
			}
		 });
		  $('.color_code_clear_button_bg_hover').simpleColor({ 
		 	defaultColor: $('#clear_button_bg_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#clear_button_bg_hover').val('#'+hex);
			  
			}
		 });
		  $('.color_code_clear_button_color').simpleColor({ 
		 	defaultColor: $('#clear_button_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#clear_button_color').val('#'+hex);
			  
			}
		 });
		  $('.color_code_clear_button_color_hover').simpleColor({ 
		 	defaultColor: $('#clear_button_color_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#clear_button_color_hover').val('#'+hex);
			  
			}
		 });
		 
		
		 $('.color_code_day_grey_bg').simpleColor({ 
		 	defaultColor: $('#day_grey_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_grey_bg').val('#'+hex);
			  
			}
		 });
		 $('.color_code_day_white_bg').simpleColor({ 
		 	defaultColor: $('#day_white_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_bg').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_white_bg_hover').simpleColor({ 
		 	defaultColor: $('#day_white_bg_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_bg_hover').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_white_line1_color').simpleColor({ 
		 	defaultColor: $('#day_white_line1_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_line1_color').val('#'+hex);
			  
			}
		 });
		 
		 
		 $('.color_code_day_white_line1_color_hover').simpleColor({ 
		 	defaultColor: $('#day_white_line1_color_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_line1_color_hover').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_white_line2_color').simpleColor({ 
		 	defaultColor: $('#day_white_line2_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_line2_color').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_white_line2_color_hover').simpleColor({ 
		 	defaultColor: $('#day_white_line2_color_hover').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_line2_color_hover').val('#'+hex);
			  
			}
		 });

        $('.color_code_day_white_line2_bg').simpleColor({
            defaultColor: $('#day_white_line2_bg').val(),
            onSelect: function( hex ) {
                //put code in input cell
                $('#day_white_line2_bg').val('#'+hex);

            }
        });

        $('.color_code_day_white_line2_bg_hover').simpleColor({
            defaultColor: $('#day_white_line2_bg_hover').val(),
            onSelect: function( hex ) {
                //put code in input cell
                $('#day_white_line2_bg_hover').val('#'+hex);

            }
        });
		 
		 $('.color_code_day_red_bg').simpleColor({ 
		 	defaultColor: $('#day_red_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_red_bg').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_red_line1_color').simpleColor({ 
		 	defaultColor: $('#day_red_line1_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_red_line1_color').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_red_line2_color').simpleColor({ 
		 	defaultColor: $('#day_red_line2_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_red_line2_color').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_white_bg_disabled').simpleColor({ 
		 	defaultColor: $('#day_white_bg_disabled').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_bg_disabled').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_white_line1_disabled_color').simpleColor({ 
		 	defaultColor: $('#day_white_line1_disabled_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_line1_disabled_color').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_day_white_line2_disabled_color').simpleColor({ 
		 	defaultColor: $('#day_white_line2_disabled_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_line2_disabled_color').val('#'+hex);
			  
			}
		 });

        $('.color_code_day_white_line2_disabled_bg').simpleColor({
            defaultColor: $('#day_white_line2_disabled_bg').val(),
            onSelect: function( hex ) {
                //put code in input cell
                $('#day_white_line2_disabled_bg').val('#'+hex);

            }
        });
		 
		  $('.color_code_day_white_bg_line1_disabled_color').simpleColor({ 
		 	defaultColor: $('#day_white_line1_disabled_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#day_white_line1_disabled_color').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_form_bg').simpleColor({ 
		 	defaultColor: $('#form_bg').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#form_bg').val('#'+hex);
			  
			}
		 });
		 
		 $('.color_code_form_color').simpleColor({ 
		 	defaultColor: $('#form_color').val(),
			onSelect: function( hex ) {
			  //put code in input cell
			  $('#form_color').val('#'+hex);
			  
			}
		 });
		 
	});
	function onManuallyChangeColor(color,div_class,input_id) { 
		if(color.length==7) {
			$('.'+div_class).parent().children('div').eq(1).children('div').eq(0).css('background-color',$('#'+input_id).val());
		}
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
        <div id="form_container">
        
            <form name="editstyles" action="" method="post" tmt:validate="true" enctype="multipart/form-data">           
               
		     <!-- 
            =======================
            === Month container ==
            =======================
            -->
            
           
            
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_MONTH_CONTAINER_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_MONTH_CONTAINER_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="month_container_bg" name="month_container_bg" maxlength="7" value="<?php echo $settingObj->getMonthContainerBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_month_container_bg','month_container_bg');">
                    <div class="float_left width_20"><div class="color_code_month_container_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_MONTH_NAME_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="month_name_color" name="month_name_color" maxlength="7" value="<?php echo $settingObj->getMonthNameColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_month_name_color','month_name_color');">
                    <div class="float_left width_20"><div class="color_code_month_name_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_YEAR_NAME_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="year_name_color" name="year_name_color" maxlength="7" value="<?php echo $settingObj->getYearNameColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_year_name_color','year_name_color');">
                    <div class="float_left width_20"><div class="color_code_year_name_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
             <!-- 
            =======================
            === Navigation buttons==
            =======================
            -->
            
                    
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_MONTH_NAVIGATION_BUTTONS_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_MONTH_NAVIGATION_BUTTONS_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="month_navigation_button_bg" name="month_navigation_button_bg" maxlength="7" value="<?php echo $settingObj->getMonthNavigationButtonBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_month_navigation_button_bg','month_navigation_button_bg');">
                    <div class="float_left width_20"><div class="color_code_month_navigation_button_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_MONTH_NAVIGATION_BUTTONS_BACKGROUND_HOVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="month_navigation_button_bg_hover" name="month_navigation_button_bg_hover" maxlength="7" value="<?php echo $settingObj->getMonthNavigationButtonBgHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_month_navigation_button_bg_hover','month_navigation_button_bg_hover');">
                    <div class="float_left width_20"><div class="color_code_month_navigation_button_bg_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>

             <div id="input_box">
                 <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_MONTH_NAVIGATION_BUTTONS_COLOR"); ?></div>
                 <div class="float_left margin_t_20 margin_l_10 font_12">
                     <input type="text" class="width_100 float_left" id="month_navigation_button_color" name="month_navigation_button_color" maxlength="7" value="<?php echo $settingObj->getMonthNavigationButtonColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_month_navigation_button_color','month_navigation_button_color');">
                     <div class="float_left width_20"><div class="color_code_month_navigation_button_color"></div></div>
                 </div>
                 <div class="cleardiv"></div>

             </div>

             <div id="input_box">
                 <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_MONTH_NAVIGATION_BUTTONS_COLOR_HOVER"); ?></div>
                 <div class="float_left margin_t_20 margin_l_10 font_12">
                     <input type="text" class="width_100 float_left" id="month_navigation_button_color_hover" name="month_navigation_button_color_hover" maxlength="7" value="<?php echo $settingObj->getMonthNavigationButtonColorHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_month_navigation_button_color_hover','month_navigation_button_color_hover');">
                     <div class="float_left width_20"><div class="color_code_month_navigation_button_color_hover"></div></div>
                 </div>
                 <div class="cleardiv"></div>

             </div>
            
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
            
               
            <!-- 
            =======================
            === Days names color ==
            =======================
            -->
            
           
            
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_DAY_NAMES_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_DAY_NAMES_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_names_color" name="day_names_color" maxlength="7" value="<?php echo $settingObj->getDayNamesColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_names_color','day_names_color');">
                    <div class="float_left width_20"><div class="color_code_day_names_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>

             <div id="input_box">
                 <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_DAY_NAMES_BG"); ?></div>
                 <div class="float_left margin_t_20 margin_l_10 font_12">
                     <input type="text" class="width_100 float_left" id="day_names_bg" name="day_names_bg" maxlength="7" value="<?php echo $settingObj->getDayNamesBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_names_bg','day_names_bg');">
                     <div class="float_left width_20"><div class="color_code_day_names_bg"></div></div>
                 </div>
                 <div class="cleardiv"></div>

             </div>

             <div class="booking_margin_tb_20 booking_border_dotted booking_border_t_1 booking_border_666 booking_height_1"></div>

            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>


                 <!--
            =======================
            === Calendar cells: general ==
            =======================
            -->
             <div id="label_input">
                 <div class="label_title"><?php echo $langObj->getLabel("STYLES_CALENDAR_CELLS_ALL"); ?></div>
             </div>
             <div id="input_box">
                 <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_CALENDAR_CELLS_BORDER_STYLE"); ?></div>
                 <div class="float_left margin_t_20 margin_l_10 font_12">
                     <select name="day_border">
                         <option value="dashed" <?php if($settingObj->getDayBorder() == "dashed") { echo "selected"; }?>><?php echo $langObj->getLabel("STYLES_DASHED"); ?></option>
                         <option value="dotted" <?php if($settingObj->getDayBorder() == "dotted") { echo "selected"; }?>><?php echo $langObj->getLabel("STYLES_DOTTED"); ?></option>
                         <option value="solid" <?php if($settingObj->getDayBorder() == "solid") { echo "selected"; }?>><?php echo $langObj->getLabel("STYLES_SOLID"); ?></option>
                     </select>
                 </div>
                 <div class="cleardiv"></div>

             </div>
             <div id="rowspace"></div>
             <div id="rowline"></div>
             <div id="rowspace"></div>

             <!--
             =======================
             === Calendar empty cells ==
             =======================
             -->
            
           
            
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_EMPTY_CELLS_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_EMPTY_CELLS_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_grey_bg" name="day_grey_bg" maxlength="7" value="<?php echo $settingObj->getDayGreyBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_grey_bg','day_grey_bg');">
                    <div class="float_left width_20"><div class="color_code_day_grey_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
           
            
            <!-- 
            =======================
            === Calendar avalaible cells ==
            =======================
            -->
            
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_bg" name="day_white_bg" maxlength="7" value="<?php echo $settingObj->getDayWhiteBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_bg','day_white_bg');">
                    <div class="float_left width_20"><div class="color_code_day_white_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>            
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_BACKGROUND_OVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_bg_hover" name="day_white_bg_hover" maxlength="7" value="<?php echo $settingObj->getDayWhiteBgHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_bg_hover','day_white_bg_hover');">
                    <div class="float_left width_20"><div class="color_code_day_white_bg_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_LINE_1_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_line1_color" name="day_white_line1_color" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine1Color(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line1_color','day_white_line1_color');">
                    <div class="float_left width_20"><div class="color_code_day_white_line1_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_LINE_1_COLOR_OVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_line1_color_hover" name="day_white_line1_color_hover" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine1ColorHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line1_color_hover','day_white_line1_color_hover');">
                    <div class="float_left width_20"><div class="color_code_day_white_line1_color_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_LINE_2_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_line2_color" name="day_white_line2_color" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine2Color(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line2_color','day_white_line2_color');">
                    <div class="float_left width_20"><div class="color_code_day_white_line2_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_LINE_2_COLOR_OVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_line2_color_hover" name="day_white_line2_color_hover" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine2ColorHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line2_color_hover','day_white_line2_color_hover');">
                    <div class="float_left width_20"><div class="color_code_day_white_line2_color_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>

             <div id="input_box">
                 <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_LINE_2_BG"); ?></div>
                 <div class="float_left margin_t_20 margin_l_10 font_12">
                     <input type="text" class="width_100 float_left" id="day_white_line2_bg" name="day_white_line2_bg" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine2Bg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line2_bg','day_white_line2_bg');">
                     <div class="float_left width_20"><div class="color_code_day_white_line2_bg"></div></div>
                 </div>
                 <div class="cleardiv"></div>

             </div>

             <div id="input_box">
                 <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_AVAILABLE_CELLS_LINE_2_BG_OVER"); ?></div>
                 <div class="float_left margin_t_20 margin_l_10 font_12">
                     <input type="text" class="width_100 float_left" id="day_white_line2_bg_hover" name="day_white_line2_bg_hover" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine2BgHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line2_bg_hover','day_white_line2_bg_hover');">
                     <div class="float_left width_20"><div class="color_code_day_white_line2_bg_hover"></div></div>
                 </div>
                 <div class="cleardiv"></div>

             </div>

             <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
            
            

            <!-- 
            =======================
            === Calendar sold out cells ==
            =======================
            -->
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_SOLDOUT_CELLS_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_SOLDOUT_CELLS_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_red_bg" name="day_red_bg" maxlength="7" value="<?php echo $settingObj->getDayRedBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_red_bg','day_red_bg');">
                    <div class="float_left width_20"><div class="color_code_day_red_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>  
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_SOLDOUT_CELLS_LINE_1_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_red_line1_color" name="day_red_line1_color" maxlength="7" value="<?php echo $settingObj->getDayRedLine1Color(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_red_line1_color','day_red_line1_color');">
                    <div class="float_left width_20"><div class="color_code_day_red_line1_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>  
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_SOLDOUT_CELLS_LINE_2_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_red_line2_color" name="day_red_line2_color" maxlength="7" value="<?php echo $settingObj->getDayRedLine2Color(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_red_line2_color','day_red_line2_color');">
                    <div class="float_left width_20"><div class="color_code_day_red_line2_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>  
            
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
            <!-- 
            =======================
            === Calendar not available cells ==
            =======================
            -->
            
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_NOTAVAILABLE_CELLS_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_NOTAVAILABLE_CELLS_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_bg_disabled" name="day_white_bg_disabled" maxlength="7" value="<?php echo $settingObj->getDayWhiteBgDisabled(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_bg_disabled','day_white_bg_disabled');">
                    <div class="float_left width_20"><div class="color_code_day_white_bg_disabled"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>  
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_NOTAVAILABLE_CELLS_LINE_1_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_line1_disabled_color" name="day_white_line1_disabled_color" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine1DisabledColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line1_disabled_color','day_white_line1_disabled_color');">
                    <div class="float_left width_20"><div class="color_code_day_white_line1_disabled_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>  
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_NOTAVAILABLE_CELLS_LINE_2_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="day_white_line2_disabled_color" name="day_white_line2_disabled_color" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine2DisabledColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line2_disabled_color','day_white_line2_disabled_color');">
                    <div class="float_left width_20"><div class="color_code_day_white_line2_disabled_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>

             <div id="input_box">
                 <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_NOTAVAILABLE_CELLS_LINE_2_BG_COLOR"); ?></div>
                 <div class="float_left margin_t_20 margin_l_10 font_12">
                     <input type="text" class="width_100 float_left" id="day_white_line2_disabled_bg" name="day_white_line2_disabled_bg" maxlength="7" value="<?php echo $settingObj->getDayWhiteLine2DisabledBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_day_white_line2_disabled_bg','day_white_line2_disabled_bg');">
                     <div class="float_left width_20"><div class="color_code_day_white_line2_disabled_bg"></div></div>
                 </div>
                 <div class="cleardiv"></div>

             </div>
            
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>
            
            <!-- 
             =======================
             === form style bg color ==
             =======================
             -->
             
            <div id="label_input">
                <div class="label_title"><?php echo $langObj->getLabel("STYLES_FORM_TITLE"); ?></div>
            </div>
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_FORM_CALENDAR_NAME_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="form_calendar_name_color" name="form_calendar_name_color" maxlength="7" value="<?php echo $settingObj->getFormCalendarNameColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_form_calendar_name_color','form_calendar_name_color');">
                    <div class="float_left width_20"><div class="color_code_form_calendar_name_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>  
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_FORM_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="form_bg" name="form_bg" maxlength="7" value="<?php echo $settingObj->getFormBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_form_bg','form_bg');">
                    <div class="float_left width_20"><div class="color_code_form_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>  
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_FORM_LABELS_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="form_color" name="form_color" maxlength="7" value="<?php echo $settingObj->getFormColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_form_color','form_color');">
                    <div class="float_left width_20"><div class="color_code_form_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
         
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_FORM_FIELD_INPUT_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="field_input_bg" name="field_input_bg" maxlength="7" value="<?php echo $settingObj->getFieldInputBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_field_input_bg','field_input_bg');">
                    <div class="float_left width_20"><div class="color_code_field_input_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
		
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_FORM_FIELD_INPUT_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="field_input_color" name="field_input_color" maxlength="7" value="<?php echo $settingObj->getFieldInputColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_field_input_color','field_input_color');">
                    <div class="float_left width_20"><div class="color_code_field_input_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
            
            <div id="recaptcha_style" style="display:none !important">
                <div id="input_box">
                    <div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_FORM_RECAPTCHA"); ?></div>
                    <div class="float_left margin_t_20 margin_l_10 font_12">
                         <select name="recaptcha_style">
                            <option value="white" <?php if($settingObj->getRecaptchaStyle() == "white") { echo "selected"; }?>><?php echo $langObj->getLabel("STYLES_FORM_RECAPTCHA_WHITE"); ?></option>
                            <option value="red" <?php if($settingObj->getRecaptchaStyle() == "red") { echo "selected"; }?>><?php echo $langObj->getLabel("STYLES_FORM_RECAPTCHA_RED"); ?></option>
                            <option value="blackglass" <?php if($settingObj->getRecaptchaStyle() == "blackglass") { echo "selected"; }?>><?php echo $langObj->getLabel("STYLES_FORM_RECAPTCHA_BLACK"); ?></option>
                        </select>
                    </div>
                    <div class="cleardiv"></div>
                   
                </div>  
            </div>
            
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_BOOK_NOW_BUTTON_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="book_now_button_bg" name="book_now_button_bg" maxlength="7" value="<?php echo $settingObj->getBookNowButtonBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_book_now_button_bg','book_now_button_bg');">
                    <div class="float_left width_20"><div class="color_code_book_now_button_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
            <div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_BOOK_NOW_BUTTON_BACKGROUND_HOVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="book_now_button_bg_hover" name="book_now_button_bg_hover" maxlength="7" value="<?php echo $settingObj->getBookNowButtonBgHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_book_now_button_bg_hover','book_now_button_bg_hover');">
                    <div class="float_left width_20"><div class="color_code_book_now_button_bg_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_BOOK_NOW_BUTTON_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="book_now_button_color" name="book_now_button_color" maxlength="7" value="<?php echo $settingObj->getBookNowButtonColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_book_now_button_color','book_now_button_color');">
                    <div class="float_left width_20"><div class="color_code_book_now_button_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
		 
		 	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_BOOK_NOW_BUTTON_COLOR_HOVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="book_now_button_color_hover" name="book_now_button_color_hover" maxlength="7" value="<?php echo $settingObj->getBookNowButtonColorHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_book_now_button_color_hover','book_now_button_color_hover');">
                    <div class="float_left width_20"><div class="color_code_book_now_button_color_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
		 
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_CLEAR_BUTTON_BACKGROUND"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="clear_button_bg" name="clear_button_bg" maxlength="7" value="<?php echo $settingObj->getClearButtonBg(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_clear_button_bg','clear_button_bg');">
                    <div class="float_left width_20"><div class="color_code_clear_button_bg"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
		 
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_CLEAR_BUTTON_BACKGROUND_HOVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="clear_button_bg_hover" name="clear_button_bg_hover" maxlength="7" value="<?php echo $settingObj->getClearButtonBgHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_clear_button_bg_hover','clear_button_bg_hover');">
                    <div class="float_left width_20"><div class="color_code_clear_button_bg_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
		 
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_CLEAR_BUTTON_COLOR"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="clear_button_color" name="clear_button_color" maxlength="7" value="<?php echo $settingObj->getClearButtonColor(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_clear_button_color','clear_button_color');">
                    <div class="float_left width_20"><div class="color_code_clear_button_color"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
		  
         	<div id="input_box">
            	<div class="float_left margin_t_24 font_12 width_350"><?php echo $langObj->getLabel("STYLES_CLEAR_BUTTON_COLOR_HOVER"); ?></div>
                <div class="float_left margin_t_20 margin_l_10 font_12">
                    <input type="text" class="width_100 float_left" id="clear_button_color_hover" name="clear_button_color_hover" maxlength="7" value="<?php echo $settingObj->getClearButtonColorHover(); ?>" onKeyUp="javascript:onManuallyChangeColor(this.value,'color_code_clear_button_color_hover','clear_button_color_hover');">
                    <div class="float_left width_20"><div class="color_code_clear_button_color_hover"></div></div>
                </div>
                <div class="cleardiv"></div>
               
            </div>
            <div id="rowspace"></div>
            <div id="rowline"></div>
            <div id="rowspace"></div>


             <div id="input_box">
                 <div class="font_bold"><label for="google_font_link_code"><?php echo $langObj->getLabel("STYLES_CUSTOM_GOOGLE_FONT_LINK"); ?></label></div>
                 <div class="booking_font_12"><?php echo $langObj->getLabel("STYLES_CUSTOM_GOOGLE_FONT_LINK_SUBTITLE"); ?> https://fonts.googleapis.com/css?family=Robot</div>
                 <div class="margin_t_10 margin_b_10 font_12">
                     <input type="text" id="google_font_link_code" class="width_250 height_30" name="google_font_link_code" value="<?php echo $settingObj->getGoogleFontLinkCode(); ?>">
                 </div>
                 <div class="cleardiv"></div>

             </div>
             <div id="input_box">
                 <div class="font_bold"><label for="google_font_css_code"><?php echo $langObj->getLabel("STYLES_CUSTOM_GOOGLE_FONT_CSS_CODE"); ?></label></div>
                 <div class="booking_font_12"><?php echo $langObj->getLabel("STYLES_CUSTOM_GOOGLE_FONT_CSS_CODE_SUBTITLE"); ?> font-family: 'Roboto'</div>
                 <div class="margin_t_10 margin_b_10 font_12">
                     <input type="text" id="google_font_css_code" class="width_250 height_30" name="google_font_css_code" value="<?php echo $settingObj->getGoogleFontCssCode(); ?>">
                 </div>
                 <div class="cleardiv"></div>

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
                    <div ><a href="javascript:document.location.href='welcome.php';" class="cancel_button"><?php echo $langObj->getLabel("STYLES_CANCEL_BUTTON"); ?></a></div>
                    
                    <!-- save -->
                    <div style="margin-left:750px"><input type="submit" id="apply_button" name="saveunpublish" value="<?php echo $langObj->getLabel("STYLES_SAVE_BUTTON"); ?>"></div>
                    
                </div>
                <div id="rowspace"></div>
            
                
            </form>
         </div>
       </div>
    </div> 

</div>
