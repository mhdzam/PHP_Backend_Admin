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



$affiliate = @$_GET['affiliate'];
$affiliate_srch="";
if($affiliate >0){
    $affiliate_srch=" and affiliate='$affiliate'";
}

$srch_by_nme = "";
$srch_by_id = "";
$srch_by_stts = "";
$srch_by_date1 = "";
$srch_by_date2 = "";
$sort_by = "member_id";

if (!isset($_REQUEST["sGroupActionName"])) {
    //------SEARCH  
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_name"] != "") {
        $srch_by_nme = " AND (member_firstname like '%$_REQUEST[order_name]%' OR member_phone like '%$_REQUEST[order_name]%' OR member_email like '%$_REQUEST[order_name]%')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_id"] != "") {
        $srch_by_id = " AND (member_id = '$_REQUEST[order_id]')";
    }

}

//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " member_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 2) {
        $sort_by = " member_firstname " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 3) {
        $sort_by = " member_phone " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_status"] != "") {
        $srch_by_stts = " AND (member_status = '$_REQUEST[order_status]')";
    }
    if ($_REQUEST['iSortCol_0'] == 4) {
        $sort_by = " member_email " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_members where member_id!='' $srch_by_nme $srch_by_stts $srch_by_id $affiliate_srch ");

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
            $sql_active = mysql_query("UPDATE " . $prefix . "_members SET member_status=1 WHERE member_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_block") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_members SET member_status=0 WHERE member_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_delete") {
            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_members WHERE member_id  in ($multichkbx)");
            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                if ($data_delete_who['member_photo'] != "") {
                    @unlink("../../uploads/members/$data_delete_who[member_photo]");
                }
            }
            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_members WHERE member_id in ($multichkbx)");

        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_members where member_id!='' $srch_by_nme $srch_by_stts $srch_by_id $affiliate_srch order by $sort_by limit $iDisplayStart,$iDisplayLength");

while ($data_retrive = mysql_fetch_array($sql_retrive)) {

    $sql_gc = mysql_query("SELECT * FROM " . $prefix . "_countries  WHERE cnt_id ='$data_retrive[member_country_id]' limit 1 ");
    $data_gc = mysql_fetch_array($sql_gc);
    $member_country_code = strtolower($data_gc['country_code']);
    $member_country_title = $data_gc['country_'.$lang];
    $flag = "";
    if($member_country_code!=""){
        $flag = "<div class='pull-right flag flag-$member_country_code' title='$member_country_title' style='margin: 5px;'></div>";
    }

    $facebook="";
    if($data_retrive['facebook_id']!=""){
        $facebook = "<a class='pull-right' href='https://www.facebook.com/app_scoped_user_id/$data_retrive[facebook_id]' target='_blank'><i class='fa fa-facebook-square'></i></a>";
    }

    $status = 1;
    $id = $data_retrive['member_id'];
    $status = $status_list[$data_retrive['member_status']];


    //affiliate
    $affiliatelinks ="";
    $sql_af1 = mysql_query("SELECT * FROM " . $prefix . "_members  WHERE affiliate ='$id'");
    $affiliate_users = mysql_num_rows($sql_af1);

    $sql_af2 = mysql_query("SELECT * FROM " . $prefix . "_shop_orders  WHERE affiliate ='$id'");
    $affiliate_orders = mysql_num_rows($sql_af2);

    if($affiliate_users>0) {
        $affiliatelinks = $affiliatelinks." <a href='members.php?affiliate=$id'><i class=\"fa fa-users\"></i> $affiliate_users </a>";
    }
    if($affiliate_users>0 && $affiliate_orders>0) {
        $affiliatelinks = $affiliatelinks."   &nbsp; &nbsp; ";
    }
    if($affiliate_orders>0) {
        $affiliatelinks = $affiliatelinks." <a href='shop_orders.php?affiliate=$id'><i class=\"fa fa-list\"></i> $affiliate_orders</a>";
    }
    if($affiliate_users==0 && $affiliate_orders==0) {
        $affiliatelinks .=" - ";
    }

    if ($logged_allow_edit_status == 1) {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            $id,
            stripcslashes($data_retrive['member_firstname']).$facebook,
            stripcslashes($data_retrive['member_phone']),
            "<a href='inbox.php?a=compose&member_id=$id'>".stripcslashes($data_retrive['member_email'])."</a>"."$flag",
            '<div style="text-align:center">'. $affiliatelinks . '</div>',
            '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">' . (current($status)) . '</span></div>',
            '<div style="text-align:center"><a href="?id=' . $id . '&act=update" class="btn btn-xs default"><i class="fa fa-edit"></i> ' . $lang_var_admin_6 . '</a></div>'
        );
    } else {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            $id,
            stripcslashes($data_retrive['member_firstname']).$facebook,
            stripcslashes($data_retrive['member_phone']),
            "<a href='inbox.php?a=compose&member_id=$id'>".stripcslashes($data_retrive['member_email'])."</a>"."$flag",
            '<div style="text-align:center">'. $affiliatelinks . '</div>',
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