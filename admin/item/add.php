<?php

/**
 * @author Manuel Zarat
 */

if( !@$_GET['type'] && !@$_POST['title'] ) { die("sorry, wrong query."); }

$posttype = $_GET['type'];

if(!empty($_POST['title'])) { 

    $title = !empty( $_POST['title'] ) ? htmlentities($_POST['title'], ENT_QUOTES, 'utf-8') : "";
    $date = !empty($_POST['date']) ? strtotime( $_POST['date'] ) : time();
    $keywords = !empty( $_POST['keywords'] ) ? htmlentities($_POST['keywords'], ENT_QUOTES, 'utf-8') : "";  
    $description = !empty( $_POST['description'] ) ? htmlentities($_POST['description'], ENT_QUOTES, 'utf-8') : "";
    $category = !empty( $_POST['category'] ) ? $_POST['category'] : 0;    
    $content = !empty( $_POST['content'] ) ? htmlentities($_POST['content'], ENT_QUOTES, 'utf-8') : "";
        
    $cfg = array("insert"=>"item (type, title, date, keywords, description, category, content, status)","values"=>"('$posttype', '$title', $date, '$keywords', '$description', $category, '$content', 1)");
    $system->insert($cfg);
    
    $last = $system->last_insert_id();

    echo "<div class=\"sp-content\">\n";
    echo "<div class=\"sp-content-item\">\n";
    echo "<div class=\"sp-content-item-head\">" . $system->_t('item_modify') . "</div>\n";
    echo "<div class=\"sp-content-item-body\">\n";   
    echo "Dein Inhalt wurde gespeichert. Du kannst ihn <a href='../?type=$posttype&id=$last'>hier ansehen</a>, <a href='../admin/item.php?action=modify&id=$last'>weiter bearbeiten</a> oder <a href=\"../admin/item.php?action=add&type=$posttype\">neu anlegen</a>.";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";       
	
} else {

echo "<script type=\"text/javascript\" src=\"../admin/js/suneditor.js\"></script>\n";
echo "<script type=\"text/javascript\" src=\"../admin/js/datepicker.js\"></script>\n";
echo "<link rel=\"stylesheet\" href=\"../admin/css/suneditor.css\">\n";
echo "<link rel=\"stylesheet\" href=\"../admin/css/datepicker.css\">\n";

?>

<div class="sp-content">

    <div class="sp-content-item">
    
    <div class="sp-content-item-head"><?php echo $system->_t('item_add'); ?></div>
    
    <div class="sp-content-item-body">
    
        <form id="frm" method="post">
        
            <p><?php echo $system->_t('item_add_title'); ?> <a onclick="toggle('more');" href="#">weitere Optionen</a></p>    
            <p><input name="title" type="text"></p> 
               
            <div id="more" style="display:none;">
                
                <p><?php echo $system->_t('item_add_date'); ?></p>
                <p><input type="text" name="date" class="datepicker"></p>        
                
                <p><?php echo $system->_t('item_add_category'); ?></p>
                <p><select name="category">
                    <?php
                    $cfg = array('select'=>'*','from'=>'item','where'=>'type="category"');
                    $a = $system->archive($cfg);
                    for($i=0;$i<count($a);$i++) {
                        echo "<option value='" . $a[$i]['id'] . "'>" . $a[$i]['title'] . "</option>";
                    }
                    ?>
                </select></p>
                        
                <p><?php echo $system->_t('item_add_keywords'); ?></p>
                <p><input name="keywords" type="text"></p>  
                      
                <p><?php echo $system->_t('item_add_description'); ?></p>
                <p><input name="description" type="text"></p>
                   
            </div>
               
            <p><?php echo $system->_t('item_add_content'); ?></p>
            <p><textarea id="editor" name="content" style="width:100% !important;" rows="20"></textarea></p>
            
            <p><a style="cursor:pointer;" onclick="sun_save();">speichern</a></p> 
               
        </form>
    
    </div>
    
    </div>

</div>

<div style="clear:both;"></div>
 
<script>
var suneditor = SUNEDITOR.create('editor', {});
document.getElementById("datepicker").datepicker();
function sun_save() {
    suneditor.save();
    document.getElementById('frm').submit();
};   
</script>

<?php } ?>