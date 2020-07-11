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
$sort_by = "visitor_id";


//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " visitor_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 2) {
        $sort_by = " visitor_date " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc') . ", visitor_time " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 3) {
        $sort_by = " visitor_ip " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 4) {
        $sort_by = " visitor_city " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 5) {
        $sort_by = " visitor_country " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_analytics_visitors $srch_by_nme $srch_by_id $srch_by_stts $srch_by_date1 $srch_by_date2 ");

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

            $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_analytics_pages WHERE visitor_id in ($multichkbx)");
            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_analytics_visitors WHERE visitor_id in ($multichkbx)");

        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_analytics_visitors order by $sort_by limit $iDisplayStart,$iDisplayLength");

while ($data_retrive = mysql_fetch_array($sql_retrive)) {

    $status = 1;
    $id = $data_retrive['visitor_id'];

    $event_date_from = "";
    if ($data_retrive['visitor_date'] != "") {
        $post_date_lng = date('d-m-Y', strtotime($data_retrive['visitor_date']));
        $visitor_time_lng = date('h:i A', strtotime($data_retrive['visitor_time']));
        $event_date_from = "<div style='text-align:center'><small class='help-block' style='margin:0;padding:0;font-size:75%'><span  dir=ltr>" . $post_date_lng . " &nbsp; " . $visitor_time_lng . "</span></small></div>";
    }

    $flag = "";
    $country_code = strtolower(stripcslashes($data_retrive['visitor_country_code']));
    if ($country_code != "unknown") {
        $flag = "<div class='flag flag-$country_code' style='display: inline-block'></div> ";
    }

    $records["aaData"][] = array(
        '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
        '<div style="text-align:center">' . $id . '</div>',
        $event_date_from,
        '<a href="ip.php?ip=' . stripslashes($data_retrive['visitor_ip']) . '">' . stripslashes($data_retrive['visitor_ip']) . '</a>',
        stripslashes($data_retrive['visitor_city']),
        $flag . stripslashes($data_retrive['visitor_country'])
    );

}


$records["sEcho"] = $sEcho;
$records["iTotalRecords"] = $iTotalRecords;
$records["iTotalDisplayRecords"] = $iTotalRecords;

echo json_encode($records);
?>