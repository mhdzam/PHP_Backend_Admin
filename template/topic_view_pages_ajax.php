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

$wm_section = @$_GET['wm_section'];
$lang = @$_GET['lang'];
$lang_var_admin_6 = @$_GET['var_admin_6'];
$logged_allow_edit_status = @$_GET['logged_allow_edit_status'];
$lang_var_admin_25 = @$_GET['var_admin_25'];

$sql_get_webmaster_sections = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections  WHERE ws_id ='$wm_section'");
$data_get_webmaster_sections = mysql_fetch_array($sql_get_webmaster_sections);
$ws_sections_st = stripcslashes($data_get_webmaster_sections['ws_sections_st']);
$ws_comments_st = stripcslashes($data_get_webmaster_sections['ws_comments_st']);
$ws_type = stripcslashes($data_get_webmaster_sections['ws_type']);
$ws_date_status = stripcslashes($data_get_webmaster_sections['ws_date_status']);
$ws_longtext_status = stripcslashes($data_get_webmaster_sections['ws_longtext_status']);
$ws_editor_status = stripcslashes($data_get_webmaster_sections['ws_editor_status']);
$ws_attachfile_status = stripcslashes($data_get_webmaster_sections['ws_attachfile_status']);

$srch_by_nme = "";
$srch_by_id = "";
$srch_by_stts = "";
$srch_by_date1 = "";
$srch_by_date2 = "";
$sort_by = "row_no, topic_id";

if (!isset($_REQUEST["sGroupActionName"])) {
    //------SEARCH  
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_name"] != "") {
        $srch_by_nme = " AND (topic_title_ar like '%$_REQUEST[order_name]%' OR topic_title_en like '%$_REQUEST[order_name]%' OR topic_extra1 like '%$_REQUEST[order_name]%' OR topic_extra2 like '%$_REQUEST[order_name]%' OR topic_extra3 like '%$_REQUEST[order_name]%' OR topic_extra4 like '%$_REQUEST[order_name]%' OR topic_extra5 like '%$_REQUEST[order_name]%' OR topic_extra6 like '%$_REQUEST[order_name]%'  OR topic_details_ar like '%$_REQUEST[order_name]%' OR topic_details_en like '%$_REQUEST[order_name]%' )";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_id"] != "") {
        $srch_by_id = " AND (topic_id = '$_REQUEST[order_id]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_status"] != "") {
        $srch_by_stts = " AND (topic_status = '$_REQUEST[order_status]')";
    }
    if ($ws_date_status == 1) {
        if (isset($_REQUEST["sAction"]) && $_REQUEST["order_date_from"] != "" && $_REQUEST["order_date_to"] == "") {
            $srch_by_date1 = " AND (topic_date = '$_REQUEST[order_date_from]')";
        }

        if (isset($_REQUEST["sAction"]) && $_REQUEST["order_date_from"] != "" && $_REQUEST["order_date_to"] != "") {
            $srch_by_date2 = " AND (topic_date >= '$_REQUEST[order_date_from]' AND topic_date <= '$_REQUEST[order_date_to]')";
        }
    }

}

//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " topic_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($ws_date_status == 1) {
        if ($_REQUEST['iSortCol_0'] == 2) {
            $sort_by = " topic_date " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
        }
        if ($_REQUEST['iSortCol_0'] == 3) {
            $sort_by = " topic_title_$lang " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
        }
        if ($_REQUEST['iSortCol_0'] == 4) {
            $sort_by = " visits " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
        }
        if ($_REQUEST['iSortCol_0'] == 5) {
            $sort_by = " topic_status " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
        }
    } else {
        if ($_REQUEST['iSortCol_0'] == 2) {
            $sort_by = " topic_title_$lang " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
        }
        if ($_REQUEST['iSortCol_0'] == 3) {
            $sort_by = " visits " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
        }
        if ($_REQUEST['iSortCol_0'] == 4) {
            $sort_by = " topic_status " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
        }
    }
}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_topics where wm_section_id='$wm_section' $srch_by_nme $srch_by_id $srch_by_stts $srch_by_date1 $srch_by_date2");

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
            $sql_active = mysql_query("UPDATE " . $prefix . "_topics SET topic_status=1 WHERE wm_section_id='$wm_section' and topic_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_block") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_topics SET topic_status=0 WHERE wm_section_id='$wm_section' and topic_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_delete") {

            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_topics WHERE wm_section_id='$wm_section' and topic_id  in ($multichkbx)");
            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                if ($data_delete_who['topic_image_file'] != "") {
                    @unlink("../../uploads/topics/$data_delete_who[topic_image_file]");
                }
            }
            $sql_delete1 = mysql_query("DELETE FROM  " . $prefix . "_topics_maps WHERE topic_id in ($multichkbx)");
            $sql_delete2 = mysql_query("DELETE FROM  " . $prefix . "_topics_files WHERE topic_id in ($multichkbx)");
            $sql_delete3 = mysql_query("DELETE FROM  " . $prefix . "_topics_comments WHERE topic_id in ($multichkbx)");
            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_topics WHERE wm_section_id='$wm_section' and topic_id in ($multichkbx)");

        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_topics where wm_section_id='$wm_section' $srch_by_nme $srch_by_id $srch_by_stts $srch_by_date1 $srch_by_date2 order by $sort_by limit $iDisplayStart,$iDisplayLength");

while ($data_retrive = mysql_fetch_array($sql_retrive)) {
    $topic_image_show = "";
    if ($data_retrive['topic_image_file'] != '') {
        $topic_image_show = "<div class='pull-right'><a class='mix-preview fancybox-button' href='../uploads/topics/$data_retrive[topic_image_file]' data-rel='fancybox-button'><img src='../uploads/topics/$data_retrive[topic_image_file]' style='max-height: 50px;'></a></div>";
    }

    $topic_section_is = "";
    if ($ws_sections_st != 0) {
        $sql_section = mysql_query("SELECT * FROM " . $prefix . "_sections where wm_section_id='$wm_section' and section_id ='$data_retrive[cat_id]'");
        $data_section = mysql_fetch_array($sql_section);
        $sc_nme = stripcslashes($data_section['section_title_' . $lang]);
        $topic_section_is = "<div><small class='help-block' style='margin:0;padding:0;font-size:75%'>$sc_nme</small></div>";
    }

    $status = $status_list[$data_retrive['topic_status']];
    $id = $data_retrive['topic_id'];
    if ($logged_allow_edit_status == 1) {
        if ($ws_date_status == 1) {

            $records["aaData"][] = array(
                '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
                '<div style="text-align:center">' . $id . '</div>',
                $data_retrive['topic_date'],
                $topic_image_show . stripcslashes($data_retrive['topic_title_' . $lang]) . $topic_section_is,
                '<div style="text-align:center">' . $data_retrive['visits'] . '</div>',
                '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span></div>',
                '<div style="text-align:center"><a href="?wm_section=' . $wm_section . '&id=' . $id . '&act=update" class="btn btn-xs default"><i class="fa fa-edit"></i> ' . $lang_var_admin_6 . '</a></div>'
            );
        } else {
            $records["aaData"][] = array(
                '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
                '<div style="text-align:center">' . $id . '</div>',
                $topic_image_show . stripcslashes($data_retrive['topic_title_' . $lang]) . $topic_section_is,
                '<div style="text-align:center">' . $data_retrive['visits'] . '</div>',
                '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span></div>',
                '<div style="text-align:center"><a href="?wm_section=' . $wm_section . '&id=' . $id . '&act=update" class="btn btn-xs default"><i class="fa fa-edit"></i> ' . $lang_var_admin_6 . '</a></div>'
            );
        }
    } else {
        if ($ws_date_status == 1) {

            $records["aaData"][] = array(
                '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
                '<div style="text-align:center">' . $id . '</div>',
                $data_retrive['topic_date'],
                $topic_image_show . stripcslashes($data_retrive['topic_title_' . $lang]) . $topic_section_is,
                '<div style="text-align:center">' . $data_retrive['visits'] . '</div>',
                '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span></div>',
                ''
            );
        } else {
            $records["aaData"][] = array(
                '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
                '<div style="text-align:center">' . $id . '</div>',
                $topic_image_show . stripcslashes($data_retrive['topic_title_' . $lang]) . $topic_section_is,
                '<div style="text-align:center">' . $data_retrive['visits'] . '</div>',
                '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span></div>',
                ''
            );
        }
    }
}


$records["sEcho"] = $sEcho;
$records["iTotalRecords"] = $iTotalRecords;
$records["iTotalDisplayRecords"] = $iTotalRecords;

echo json_encode($records);
?>