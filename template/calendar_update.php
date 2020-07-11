<?php


require_once("../../includes/connection.php");
require_once("functions.php");
require_once("lang.php");

$eventact = @$_GET['eventact'];
$event_id = @$_GET['id'];
$event_dayes = @$_GET['evdayes'];
if ($event_dayes > 0) {
    $event_dayes = "+$event_dayes";
}
$event_minutes = @$_GET['evminutes'];
if ($event_minutes > 0) {
    $event_minutes = "+$event_dayes";
}

$sql_modify = mysql_query("SELECT * FROM " . $prefix . "_calendar WHERE cal_id ='$event_id' ");
$data_modify = mysql_fetch_array($sql_modify);
$old_from_date = stripcslashes($data_modify['from_date']);
$old_to_date = stripcslashes($data_modify['to_date']);
$event_id = $data_modify['cal_id'];

if ($eventact == "drag" && $event_id != "") {

    $from_date = strtotime("$event_dayes days", strtotime($old_from_date));
    $from_date = strtotime("$event_minutes minutes", $from_date);
    $from_date = date('Y-m-d H:i:s', $from_date);

    $toosave = ",to_date=NULL";
    if ($old_to_date != "") {
        $to_date = strtotime("$event_dayes days", strtotime($old_to_date));
        $to_date = strtotime("$event_minutes minutes", $to_date);
        $to_date = date('Y-m-d H:i:s', $to_date);
        $toosave = ",to_date='$to_date'";
    }

    $sql_update = mysql_query("UPDATE " . $prefix . "_calendar SET from_date='$from_date' $toosave,edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE cal_id='$event_id'") or
    die(mysql_error());


}

if ($eventact == "resize" && $event_id != "") {

    if ($old_to_date != "") {
        $to_date = strtotime("$event_dayes days", strtotime($old_to_date));
        $to_date = strtotime("$event_minutes minutes", $to_date);
        $to_date = date('Y-m-d H:i:s', $to_date);
        $toosave = ",to_date='$to_date'";
    } else {
        $to_date = strtotime("$event_dayes days", strtotime($old_from_date));
        $to_date = strtotime("$event_minutes minutes", $to_date);
        $to_date = date('Y-m-d H:i:s', $to_date);
        $toosave = ",to_date='$to_date'";
    }

    $sql_update = mysql_query("UPDATE " . $prefix . "_calendar SET edit_by='$pd_admin_user_id' $toosave,edit_date=now(),edit_from='$pd_admin_ip' WHERE cal_id='$event_id'") or
    die(mysql_error());


}


?>