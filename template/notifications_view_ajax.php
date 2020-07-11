<?php

require_once("../../includes/configuration.php");
//db connect
$conn = @mysql_connect($dbhost, $dbuname, $dbpass);
$db = @mysql_select_db($dbname, $conn) or die (mysql_error());
//---------------
mysql_query("SET NAMES 'utf8'");
mysql_query('SET CHARACTER SET utf8');
mysql_set_charset('utf8', $conn);

// Timezone
$sql_get_tz = mysql_query("SELECT * FROM " . $prefix . "_webmaster_settings  WHERE set_id ='1' ");
$data_get_site_tz = mysql_fetch_array($sql_get_tz);
$site_timezone = stripcslashes($data_get_site_tz['site_timezone']);
if($site_timezone!="") {
// Update PHP Timezone
    date_default_timezone_set($site_timezone);
// Update Mysql
    $now = new DateTime();
    $mins = $now->getOffset() / 60;
    $sgn = ($mins < 0 ? -1 : 1);
    $mins = abs($mins);
    $hrs = floor($mins / 60);
    $mins -= $hrs * 60;
    $offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);
    mysql_query("SET time_zone = '$offset'");
}

$lang = @$_GET['lang'];
$lang_var_admin_6 = @$_GET['var_admin_6'];
$lang_var_admin_25 = @$_GET['var_admin_25'];

$srch_by_nme = "";
$srch_by_id = "";
$srch_by_stts = "";
$srch_by_date1 = "";
$srch_by_date2 = "";
$sort_by = "note_id";

if (!isset($_REQUEST["sGroupActionName"])) {
    //------SEARCH  
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_name"] != "") {
        $srch_by_nme = " AND (note_title_ar like '%$_REQUEST[order_name]%' OR note_title_en like '%$_REQUEST[order_name]%')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_id"] != "") {
        $srch_by_id = " AND (note_id = '$_REQUEST[order_id]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_date_from"] != "" && $_REQUEST["order_date_to"] == "") {
        $srch_by_date1 = " AND (note_date = '$_REQUEST[order_date_from]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_date_from"] != "" && $_REQUEST["order_date_to"] != "") {
        $srch_by_date2 = " AND (note_date >= '$_REQUEST[order_date_from]' AND note_date <= '$_REQUEST[order_date_to]')";
    }

}

//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " note_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 2) {
        $sort_by = " edit_by " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 3) {
        $sort_by = " note_date " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 4) {
        $sort_by = " note_title_$lang " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_notifications where note_id!='' $srch_by_nme $srch_by_id $srch_by_stts $srch_by_date1 $srch_by_date2 ");

$iTotalRecords = mysql_num_rows($sql_retrive0);
$iDisplayLength = intval($_REQUEST['iDisplayLength']);
$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
$iDisplayStart = intval($_REQUEST['iDisplayStart']);
$sEcho = intval($_REQUEST['sEcho']);

$records = array();
$records["aaData"] = array();

$end = $iDisplayStart + $iDisplayLength;
$end = $end > $iTotalRecords ? $iTotalRecords : $end;

$status_list = array(
    array("default" => "<i class='fa fa-times'></i>"),
    array("info" => "<i class='fa fa-check'></i>")

);

if (isset($_REQUEST["sAction"]) && $_REQUEST["sAction"] == "group_action") {

    $multichkbx = @$_REQUEST["id"];
    $all_multichkbx = "";
    if ($multichkbx != "") {
        while (list($key, $val) = @each($multichkbx)) {
            $all_multichkbx .= "$val,";
        }
        $multichkbx = substr($all_multichkbx, 0, -1);

        if ($_REQUEST["sGroupActionName"] == "b_delete") {

            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_notifications WHERE note_id in ($multichkbx)");

        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_notifications where note_id!='' $srch_by_nme $srch_by_id $srch_by_stts $srch_by_date1 $srch_by_date2 order by $sort_by limit $iDisplayStart,$iDisplayLength");

while ($data_retrive = mysql_fetch_array($sql_retrive)) {

    $status = 1;
    $id = $data_retrive['note_id'];
    $note_icon = str_replace("label-sm", "label-icon", stripslashes($data_retrive['note_icon']));

    $event_date_from = "";
    if ($data_retrive['note_date'] != "") {
        $post_date_lng = date('d-m-Y h:i A', strtotime($data_retrive['note_date']));
        $event_date_from = "<div style='text-align:center'><small class='help-block' style='margin:0;padding:0;font-size:75%'><span  dir=ltr>" . $post_date_lng . "</span></small></div>";
    }

    $sql_usr_get = mysql_query("SELECT * FROM " . $prefix . "_users  where user_id='$data_retrive[edit_by]'");
    $data_usr_get = mysql_fetch_array($sql_usr_get);
    $user_name = stripcslashes($data_usr_get['user_name']);

    $records["aaData"][] = array(
        '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
        $id,
        $event_date_from,
        $note_icon . " " . '<a href="' . stripslashes($data_retrive['note_url']) . '">' . stripcslashes($data_retrive['note_title_' . $lang]) . '</a>',
        '<div style="text-align:center">' . $user_name . '</div>'
    );

}


$records["sEcho"] = $sEcho;
$records["iTotalRecords"] = $iTotalRecords;
$records["iTotalDisplayRecords"] = $iTotalRecords;

echo json_encode($records);
?>