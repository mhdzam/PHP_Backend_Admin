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
$logged_allow_edit_status = @$_GET['logged_allow_edit_status'];
$lang_var_admin_25 = @$_GET['var_admin_25'];

$srch_by_nme = "";
$srch_by_id = "";
$srch_by_stts = "";
$srch_by_date1 = "";
$srch_by_date2 = "";
$sort_by = "nl_id";

if (!isset($_REQUEST["sGroupActionName"])) {
    //------SEARCH  
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_name"] != "") {
        $srch_by_nme = " AND (nl_name like '%$_REQUEST[order_name]%' OR nl_phone like '%$_REQUEST[order_name]%' OR nl_email like '%$_REQUEST[order_name]%')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_id"] != "") {
        $srch_by_id = " AND (nl_id = '$_REQUEST[order_id]')";
    }

}

//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " nl_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 2) {
        $sort_by = " nl_name " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 3) {
        $sort_by = " nl_phone " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

    if ($_REQUEST['iSortCol_0'] == 4) {
        $sort_by = " nl_email " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_newsletter where nl_id!='' $srch_by_nme $srch_by_id ");

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

            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_newsletter WHERE nl_id in ($multichkbx)");

        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_newsletter where nl_id!='' $srch_by_nme $srch_by_id order by $sort_by limit $iDisplayStart,$iDisplayLength");

while ($data_retrive = mysql_fetch_array($sql_retrive)) {

    $status = 1;
    $id = $data_retrive['nl_id'];


    if ($logged_allow_edit_status == 1) {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            $id,
            stripcslashes($data_retrive['nl_name']),
            stripcslashes($data_retrive['nl_phone']),
            stripcslashes($data_retrive['nl_email']),
            '<div style="text-align:center"><a href="?id=' . $id . '&act=update" class="btn btn-xs default"><i class="fa fa-edit"></i> ' . $lang_var_admin_6 . '</a></div>',
        );
    } else {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            $id,
            stripcslashes($data_retrive['nl_name']),
            stripcslashes($data_retrive['nl_phone']),
            stripcslashes($data_retrive['nl_email']),
            ''
        );
    }

}


$records["sEcho"] = $sEcho;
$records["iTotalRecords"] = $iTotalRecords;
$records["iTotalDisplayRecords"] = $iTotalRecords;

echo json_encode($records);
?>