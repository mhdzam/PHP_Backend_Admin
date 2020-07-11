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
$sort_by = "row_no, comment_id";

if (!isset($_REQUEST["sGroupActionName"])) {
    //------SEARCH
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_name"] != "") {
        $srch_by_nme = " AND (comment like '%$_REQUEST[order_name]%')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_id"] != "") {
        $srch_by_id = " AND (comment_id = '$_REQUEST[order_id]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_status"] != "") {
        $srch_by_stts = " AND (comment_status = '$_REQUEST[order_status]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_by"] != "") {
        $srch_by_date1 = " AND (name like '%$_REQUEST[order_by]%' OR email like '%$_REQUEST[order_by]%')";
    }

}

//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " comment_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

    if ($_REQUEST['iSortCol_0'] == 2) {
        $sort_by = " name " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 3) {
        $sort_by = " item_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 4) {
        $sort_by = " comment_status " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_shop_comments where comment_id !='' $srch_by_nme $srch_by_id $srch_by_stts $srch_by_date1 $srch_by_date2");

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

        if ($_REQUEST["sGroupActionName"] == "b_active") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_comments SET comment_status=1 WHERE comment_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_block") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_comments SET comment_status=0 WHERE comment_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_delete") {

            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_shop_comments WHERE comment_id in ($multichkbx)");

        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_comments where comment_id !='' $srch_by_nme $srch_by_id $srch_by_stts $srch_by_date1 $srch_by_date2 order by $sort_by limit $iDisplayStart,$iDisplayLength");

while ($data_retrive = mysql_fetch_array($sql_retrive)) {

    $topic_section_is = "";

    $sql_section = mysql_query("SELECT * FROM " . $prefix . "_shop_items where item_id ='$data_retrive[item_id]'");
    $data_section = mysql_fetch_array($sql_section);
    $sc_nme = stripcslashes($data_section['item_title_' . $lang]);
    $topic_section_is = "<div><small class='help-block' style='margin:0;padding:0;font-size:75%'><a href='shop_items.php?id=$data_retrive[item_id]&act=update'>$sc_nme</a></small></div>";


    $status = $status_list[$data_retrive['comment_status']];
    $id = $data_retrive['comment_id'];
    $comment_email_is = "<div><small class='help-block' style='margin:0;padding:0;font-size:75%'>" . stripcslashes($data_retrive['email']) . "</small></div>";
    $day_mm = date('Y-m-d', strtotime($data_retrive['comment_date']));
    $pd_current_date = date('Y-m-d', $_SERVER['REQUEST_TIME']);
    if ($day_mm == $pd_current_date) {
        $post_date = date('h:i A', strtotime($data_retrive['comment_date']));
    } else {
        $post_date = date('d-m-Y', strtotime($data_retrive['comment_date']));
    }
    $post_date_lng = date('d-m-Y h:i A', strtotime($data_retrive['comment_date']));
    $comment_date_is = "<div title='$post_date_lng'><small class='help-block' style='margin:0;padding:0;font-size:75%'>" . $post_date . "</small></div>";

    if ($logged_allow_edit_status == 1) {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            '<div style="text-align:center">' . $id . '</div>',
            stripcslashes($data_retrive['name']) . $comment_email_is,
            $comment_date_is . substr(strip_tags(stripcslashes($data_retrive['comment'])), 0, 100) . ".." . $topic_section_is,
            '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span></div>',
            '<div style="text-align:center"><a href="?id=' . $id . '&act=update" class="btn btn-xs default"><i class="fa fa-edit"></i> ' . $lang_var_admin_6 . '</a></div>'
        );
    } else {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            '<div style="text-align:center">' . $id . '</div>',
            stripcslashes($data_retrive['name']) . $comment_email_is,
            $comment_date_is . substr(strip_tags(stripcslashes($data_retrive['comment'])), 0, 100) . ".." . $topic_section_is,
            '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span></div>',
            ''
        );
    }

}


$records["sEcho"] = $sEcho;
$records["iTotalRecords"] = $iTotalRecords;
$records["iTotalDisplayRecords"] = $iTotalRecords;

echo json_encode($records);
?>