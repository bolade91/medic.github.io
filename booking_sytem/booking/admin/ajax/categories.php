<!-- 
=======================
=== table header ==
=======================
-->

<div class="category_title_col1">
    <div id="table_cell">#</div>
</div>
<div class="category_title_col2">
    <div id="table_cell"><input type="checkbox" name="selectAll" onclick="javascript:selectCheckbox('manage_categories','categories[]');" /></div>
</div>
<div class="category_title_col3">
    <div id="table_cell"><?php echo $langObj->getLabel("CATEGORY_NAME_LABEL"); ?></div>
</div>
<div class="category_title_col4">
    <div id="table_cell"><?php echo $langObj->getLabel("CATEGORY_LINK_LABEL"); ?></div>
</div>
<div class="category_title_col5">
    <div id="table_cell"><?php echo $langObj->getLabel("CATEGORY_PUBLISHED_LABEL"); ?></div>
</div>
<div class="category_title_col6">
    <div id="table_cell"></div>
</div>
<div class="category_title_col7">
    <div id="table_cell"></div>
</div>
<div class="category_title_col8">
    <div id="table_cell"></div>
</div>
<div id="empty"></div>



<!-- 
=======================
=== table rows ==
=======================
-->
<?php      
$arrayCategories = $listObj->getCategoriesList();    
if(count($arrayCategories)==0) {
	?>
    <script>
		window.parent.hideActionBar();
	</script>
    <?php
}                       
                       
$i=1;
foreach($arrayCategories as $categoryId => $category) {																			
    if($i % 2) {
        $class="alternate_table_row_white";
    } else {
        $class="alternate_table_row_grey";
    }
    
?>
<div id="row_<?php echo $categoryId; ?>">
    
    <!-- row number -->
    <div class="category_row_col1 <?php echo $class; ?>">
        <div id="table_cell"><?php echo $i; ?></div>
    </div>
    
    <!-- check category -->
    <div class="category_row_col2 <?php echo $class; ?>">
        <div id="table_cell"><input type="checkbox" name="categories[]" value="<?php echo $categoryId; ?>" onclick="javascript:disableSelectAll('manage_categories',this.checked);" /></div>
    </div>
    
    <!-- name category -->                   
    <div class="category_row_col3 <?php echo $class; ?>">
        <div id="table_cell">
            <span id="name_display_<?php echo $categoryId; ?>"><?php echo $category["category_name"]; ?></span>
            <span id="name_input_<?php echo $categoryId; ?>" style="display:none !important"><input type="text" name="category_name" id="category_name_<?php echo $categoryId; ?>" value="<?php echo $category["category_name"]; ?>" ></span>
        
        </div>
    </div>
    
    
    <!-- direct link -->
    <div class="category_row_col4 <?php echo $class; ?>">
        <div id="table_cell"><a href="<?php echo $settingObj->getSiteDomain()."/index.php?category_id=".$categoryId; ?>" target="_blank"><?php echo $settingObj->getSiteDomain()."/index.php?category_id=".$categoryId; ?></a></div>
    </div>
    <!-- status icon -->
    <div class="category_row_col5 <?php echo $class; ?>">
        <div id="table_cell"><span id="publish_<?php echo $categoryId; ?>"><?php if($category["category_active"]=='1') { ?><a href="javascript:unpublishCategory(<?php echo $categoryId; ?>);"><img src="images/icons/published.png" border=0 /></a><?php } else { ?><a href="javascript:publishCategory(<?php echo $categoryId; ?>);"><img src="images/icons/unpublished.png" border=0 /></a><?php } ?></span>
        <?php
        if($category["category_order"] > 0) {
        ?>
        <br /><input type="button" value="<?php echo $langObj->getLabel("SET_AS_DEFAULT_CATEGORY"); ?>" onclick="javascript:setDefaultCategory(<?php echo $categoryId; ?>);"/>
        <?php
        }
        ?>
        </div>
    </div> 
    
    <!-- modify name button -->                      
    <div class="category_row_col6 <?php echo $class; ?>">
        <div id="table_cell"><span id="modify_<?php echo $categoryId; ?>"><a href="javascript:editItem(<?php echo $categoryId; ?>);"><?php echo $langObj->getLabel("CATEGORIES_MODIFY_NAME"); ?></a></span></div>
    </div>
    
    <!-- delete button -->
    <div class="category_row_col7 <?php echo $class; ?>">
        <div id="table_cell"><a href="javascript:delItem(<?php echo $categoryId; ?>,'categories','category_id');"><?php echo $langObj->getLabel("CATEGORIES_DELETE"); ?></a></div>
    </div>                            
   
    <div id="empty"></div>
</div>
<?php 
$i++;
} ?>


