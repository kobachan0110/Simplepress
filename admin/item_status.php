<?php

/**
 * @author Manuel Zarat
 */

require_once "../load.php";
require_once "auth.php";

$system = new system();

$id = $_GET['id'];
$status = $_GET['status'];
    
$newstatus = ($status==1) ? 0 : 1;
$response = ($status==1) ? "deaktivieren" : "aktivieren";
    
$system->update( array( "table"=>"item", "set"=>"status=$status WHERE id=$id" ) );

/**
 * Weil die Datei asynchron aufgerufen wird, wird hier ein Rueckgabewert ausgegeben.
 */
echo "<a style='cursor:pointer' onclick=\"update_status('$id','$newstatus')\">$response</a>";		

?>
