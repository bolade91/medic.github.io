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
           
            
            <div id="table_container">
                <div id="table">
                    <div class="mails_title_col1">
                        <div id="table_cell">#</div>
                    </div>
                    <div class="mails_title_col2">
                        <div id="table_cell"><?php echo $langObj->getLabel("MAIL_DESCRIPTION_LABEL"); ?></div>
                    </div>                    
                    <div class="mails_title_col3">
                        <div id="table_cell"></div>
                    </div>
                    <div id="empty"></div>
                    <?php                         
                    $arrayMails = $listObj->getMailsList();                        
                    $i=1;
                    foreach($arrayMails as $mailId => $mail) {																			
                        if($i % 2) {
                            $class="alternate_table_row_white";
                        } else {
                            $class="alternate_table_row_grey";
                        }
                        
                    ?>
                    
                    <div class="mails_row_col1 <?php echo $class; ?>">
                        <div id="table_cell"><?php echo $i; ?></div>
                    </div>                 
                    <div class="mails_row_col2 <?php echo $class; ?>">
                        <div id="table_cell">
                            <?php echo $mail["email_name"]; ?>                        
                        </div>
                    </div>
                    
                    <div class="mails_row_col3 <?php echo $class; ?>">
                        <div id="table_cell">
							<a href="new_mail.php?mail_id=<?php echo $mailId; ?>"><?php echo $langObj->getLabel("MAIL_MODIFY"); ?></a>
                        </div>
                    </div>                            
                    
                    <div id="empty"></div>
                    
                    <?php 
                    $i++;
                    } ?>
                </div>
            </div>
            
            <div id="cleardiv"></div>
            <div id="rowspace"></div>
        </div>
    </div>
</div>
<?php
include 'include/footer.php';
?>