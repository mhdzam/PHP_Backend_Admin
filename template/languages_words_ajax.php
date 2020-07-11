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
$sort_by = "word_id desc";

if (!isset($_REQUEST["sGroupActionName"])) {
    //------SEARCH  
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_name"] != "") {
        $srch_by_nme = " AND (word_text like '%$_REQUEST[order_name]%')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_id"] != "") {
        $srch_by_id = " AND (word_variable = '$_REQUEST[order_id]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_status"] != "") {
        $srch_by_stts = " AND (word_type = '$_REQUEST[order_status]')";
    }

}

//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " word_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

    if ($_REQUEST['iSortCol_0'] == 2) {
        $sort_by = " word_text " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 3) {
        $sort_by = " word_type " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_languages_words  where word_id!='' $srch_by_nme $srch_by_id $srch_by_stts group by word_variable");

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
            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix .
                "_languages_words where word_variable  in (SELECT word_variable FROM " . $prefix .
                "_languages_words where word_id in ($multichkbx))");
            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                    "_languages_words where word_id ='$data_delete_who[word_id]'");
                if ($sql_delete) {
                    $actin_done = 1;
                }
            }
        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_languages_words where word_id!='' $srch_by_nme $srch_by_id $srch_by_stts group by word_variable order by $sort_by limit $iDisplayStart,$iDisplayLength");


while ($data_retrive = mysql_fetch_array($sql_retrive)) {
    if ($data_retrive['word_type'] == 1) {
        $active_icn = "<div style='text-align:center'><span class='label label-sm label-info'>Public site</span></div>";
    } else {
        $active_icn = "<div style='text-align:center'><span class='label label-default'>Admin</span></div>";
    }
    $lang_txt_1 = "";
    $lang_txt_2 = "";
    $lang_txt_dir_1 = "";
    $lang_txt_dir_2 = "";
    $sql_word_text = mysql_query("SELECT word_text FROM " . $prefix . "_languages_words where word_variable ='$data_retrive[word_variable]' and lang_id='1' limit 1");
    $data_word_text = mysql_fetch_array($sql_word_text);
    $lang_txt_1 = nl2br(stripslashes($data_word_text['word_text']));
    $lang_txt_dir_1 = "dir=ltr";
    $sql_word_text = mysql_query("SELECT word_text FROM " . $prefix . "_languages_words where word_variable ='$data_retrive[word_variable]' and lang_id='2' limit 1");
    $data_word_text = mysql_fetch_array($sql_word_text);
    $lang_txt_2 = nl2br(stripslashes($data_word_text['word_text']));
    $lang_txt_dir_2 = "dir=rtl";

    $status = $status_list[$data_retrive['word_type']];
    $id = $data_retrive['word_id'];

    $records["aaData"][] = array(
        '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
        '<div style="text-align:center">' . $data_retrive['word_variable'] . '</div>',
        '<div style="float:left;text-align:left;direction:ltr;max-width:600px;overflow:hidden"' . $lang_txt_dir_1 . '>' . $lang_txt_1 . '</div><div style="float:right;max-width:600px;overflow:hidden" ' . $lang_txt_dir_2 . '>' . $lang_txt_2 . '</div>',
        $active_icn,
        '<div style="text-align:center"><a href="?id=' . $id . '&act=update" class="btn btn-xs default"><i class="fa fa-edit"></i> ' . $lang_var_admin_6 . '</a></div>',
    );

}


$records["sEcho"] = $sEcho;
$records["iTotalRecords"] = $iTotalRecords;
$records["iTotalDisplayRecords"] = $iTotalRecords;

echo json_encode($records);
?>