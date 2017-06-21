<?php 

include 'common.php';
if(!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] == 0) {
	header('Location: login.php');
}

include 'include/header.php';

if(isset($_POST["operation"]) && $_POST["operation"] != '') {
	$arrCategories=$_POST["categories"];
	$qryString = "0";
	for($i=0;$i<count($arrCategories); $i++) {
		$qryString .= ",".$arrCategories[$i];
	}
		
	switch($_POST["operation"]) {
		case "publishCategories":
			$categoryObj->publishCategories($qryString);
			break;
		case "unpublishCategories":
			$categoryObj->unpublishCategories($qryString);
			break;
		case "delCategories":
			$categoryObj->delCategories($qryString);
			break;
		
	}                
	header('Location: categories.php');
}

?>

<!-- 
=====================================================================
=====================================================================
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
            <?php
			$arrayCategories = $listObj->getCategoriesList(); 
			
			?>
            <!-- 
            =======================
            === js - check ==
            =======================
            -->
            <script>
                
                
               
                function delItem(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("CATEGORIES_DELETE_CONFIRM_SINGLE")); ?>")) {
                        $.ajax({
                          url: 'ajax/delCategoryItem.php?item_id='+itemId,
                          success: function(data) {
                              $('#table').hide().html(data).fadeIn(2000);
                             
                            
                          }
                        });
                    } 
                }
                function publishCategory(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("CATEGORIES_PUBLISH_CONFIRM_SINGLE")); ?>")) {
                        $.ajax({
                          url: 'ajax/publishCategory.php?category_id='+itemId,
                          success: function(data) {
                              $('#publish_'+itemId).html('<a href="javascript:unpublishCategory('+itemId+');"><img src="images/icons/published.png" border=0 /></a>');								 							 
                            
                          }
                        });
                    } 
                }
                function unpublishCategory(itemId) {
                    if(confirm("<?php echo addslashes($langObj->getLabel("CATEGORIES_UNPUBLISH_CONFIRM_SINGLE")); ?>")) {
                        $.ajax({
                          url: 'ajax/unpublishCategory.php?category_id='+itemId,
                          success: function(data) {
                              $('#publish_'+itemId).html('<a href="javascript:publishCategory('+itemId+');"><img src="images/icons/unpublished.png" border=0 /></a>');								 							 
                            
                          }
                        });
                    } 
                }
                
                function addCategory() {
                    if(Trim($('#category_name').val())!= '') {
                        $('#filter_submit').html('<img src="images/loading.gif">');
                        $.ajax({
                          url: 'ajax/addCategory.php?category_name='+$('#category_name').val(),
                          success: function(data) {
                              $('#filter_submit').html('<a href="javascript:addCategory();"><?php echo addslashes($langObj->getLabel("CATEGORIES_ADD")); ?></a>');
                              $('#table').hide().html(data).fadeIn(2000);						 
                              $('#category_name').val('');
                            
                          }
                        });
                    } else {
                        alert("<?php echo addslashes($langObj->getLabel("CATEGORIES_NAME_ALERT")); ?>");
                    }
                }
                function editItem(category) {
                    $('#modify_'+category).html('<a href="javascript:saveItem('+category+');"><?php echo addslashes($langObj->getLabel("CATEGORIES_SAVE")); ?></a>');
                    $('#name_display_'+category).fadeOut(0);
                    $('#name_input_'+category).fadeIn(0);
                    
                }
                function saveItem(category) {
                    if(Trim($('#category_name_'+category).val()) != '') {
						$('#modify_'+category).parent().append('<img id="small_save_loader" src="images/loading.gif" style="display: table-cell;vertical-align:middle" border=0>');
                        $.ajax({
                          url: 'ajax/saveCategory.php?item_id='+category+"&name="+$('#category_name_'+category).val(),
                          success: function(data) {
                             
                              $('#name_display_'+category).fadeIn(0);
                              $('#name_input_'+category).fadeOut(0);
                              $('#name_display_'+category).html($('#category_name_'+category).val());
                              $('#modify_'+category).html('<a href="javascript:editItem('+category+');"><?php echo addslashes($langObj->getLabel("CATEGORIES_MODIFY_NAME")); ?></a>');
							  $('#small_save_loader').remove();
                              $('#row_'+category).hide().fadeIn(2000);
                              
                             
                            
                          }
                        });
                    }
                }
                function setDefaultCategory(category) {
                    $.ajax({
                      url: 'ajax/setDefaultCategory.php?category_id='+category,
                      success: function(data) {
                        document.location.reload();
                      }
                    });
                }
				
				$(function() {
					<?php
					if(count($arrayCategories)>0) {
						?>
						showActionBar();
						<?php
					}
					?>
				});
				
				function showActionBar() {
					$('#action_bar').slideDown();
				}
				function hideActionBar() {
					$('#action_bar').slideUp();
				}
            </script>
            
           
           
            <!-- 
            =======================
            === create category ==
            =======================
            -->
            <div class="add_calendar_container">
            	<div class="create_calendar"><strong><?php echo $langObj->getLabel("CATEGORIES_CREATE_NEW_CATEGORY"); ?></strong>: <?php echo $langObj->getLabel("CATEGORIES_TYPE_THE_NAME"); ?></div> 
                <div class="create_calendar"><input type="text" id="category_name" name="category_name"></div>   
                <div class="create_calendar"><a href="javascript:addCategory();"><?php echo $langObj->getLabel("CATEGORIES_ADD"); ?></a></div>
            </div>
            
             <!-- 
            =======================
            === action bar ==
            =======================
            -->
            <?php
			
			?>
            <div id="action_bar" style="display:none">            
            	
                <div id="action"><a onclick="javascript:delItems('manage_categories','categories[]','delCategories','<?php echo $langObj->getLabel("CATEGORIES_DELETE_CONFIRM_MULTIPLE"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("CATEGORIES_DELETE"); ?></a></div>
                <div id="action"><a onclick="javascript:delItems('manage_categories','categories[]','unpublishCategories','<?php echo $langObj->getLabel("CATEGORIES_UNPUBLISH_CONFIRM_MULTIPLE"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("CATEGORIES_UNPUBLISH"); ?></a></div>
                <div id="action"><a onclick="javascript:delItems('manage_categories','categories[]','publishCategories','<?php echo $langObj->getLabel("CATEGORIES_PUBLISH_CONFIRM_MULTIPLE"); ?>','<?php echo $langObj->getLabel("NO_ITEMS_SELECTED"); ?>')"><?php echo $langObj->getLabel("CATEGORIES_PUBLISH"); ?></a></div>
                <div class="title_action"><?php echo $langObj->getLabel("SELECTED_ITEMS"); ?>:</div>
                
            </div>
           
            <!-- 
            =======================
            === table categories ==
            =======================
            -->
            <form name="manage_categories" action="" method="post">
                <input type="hidden" name="operation" />
                <input type="hidden" name="categories[]" value=0 />
                <div id="table_container">
                    <div id="table">
                    
                    	<?php include 'ajax/categories.php'; ?>
                    </div>
                </div>
            </form>
            
            
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
        </div>
    </div>
</div>

<!-- 
=======================
=== footer ==
=======================
--
<?php
include 'include/footer.php';
?>