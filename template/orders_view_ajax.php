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

$lang_var_admin_351 = @$_GET['var_admin_351'];
$lang_var_admin_352 = @$_GET['var_admin_352'];
$lang_var_admin_353 = @$_GET['var_admin_353'];
$lang_var_admin_354 = @$_GET['var_admin_354'];

$affiliate = @$_GET['affiliate'];
$affiliate_srch="";
if($affiliate >0){
    $affiliate_srch=" and affiliate='$affiliate'";
}

$srch_by_nme = "";
$srch_by_id = "";
$srch_by_stts = "";
$srch_by_stts2 = "";
$srch_by_phone = "";
$srch_by_price1 = "";
$srch_by_price2 = "";
$srch_by_date1 = "";
$srch_by_date2 = "";
$sort_by = "order_id";

if (!isset($_REQUEST["sGroupActionName"])) {
    //------SEARCH  
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_name"] != "") {
        $srch_by_nme = " AND (customer_name like '%$_REQUEST[order_name]%' OR customer_phone like '%$_REQUEST[order_name]%' OR customer_phone2 like '%$_REQUEST[order_name]%' OR customer_email like '%$_REQUEST[order_name]%')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_phone"] != "") {
        $srch_by_phone = " AND (customer_phone like '%$_REQUEST[order_phone]%' OR customer_phone2 like '%$_REQUEST[order_phone]%')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_id"] != "") {
        $srch_by_id = " AND (order_id = '$_REQUEST[order_id]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_date_from"] != "" && $_REQUEST["order_date_to"] == "") {
        $srch_by_date1 = " AND (order_date = '$_REQUEST[order_date_from]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_date_from"] != "" && $_REQUEST["order_date_to"] != "") {
        $srch_by_date2 = " AND (order_date >= '$_REQUEST[order_date_from]' AND order_date <= '$_REQUEST[order_date_to]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_price_from"] != "" && $_REQUEST["order_price_to"] == "") {
        $srch_by_price1 = " AND (order_total = '$_REQUEST[order_price_from]')";
    }

    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_price_from"] != "" && $_REQUEST["order_price_to"] != "") {
        $srch_by_price2 = " AND (order_total >= '$_REQUEST[order_price_from]' AND order_total <= '$_REQUEST[order_price_to]')";
    }
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_status"] != "") {
        $srch_by_stts = " AND (order_status = '$_REQUEST[order_status]')";
    }
    if (isset($_REQUEST["sAction"]) && $_REQUEST["order_pay_status"] != "") {
        $srch_by_stts2 = " AND (order_pay_status = '$_REQUEST[order_pay_status]')";
    }
}

//------SORTING
if (isset($_REQUEST['iSortCol_0'])) {
    if ($_REQUEST['iSortCol_0'] == 1) {
        $sort_by = " order_id " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 2) {
        $sort_by = " order_date " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 3) {
        $sort_by = " customer_name " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 4) {
        $sort_by = " customer_phone " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 5) {
        $sort_by = " order_total " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

    if ($_REQUEST['iSortCol_0'] == 6) {
        $sort_by = " order_status " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }
    if ($_REQUEST['iSortCol_0'] == 7) {
        $sort_by = " order_pay_status " . ($_REQUEST['sSortDir_0'] === 'asc' ? 'asc' : 'desc');
    }

}

$sql_retrive0 = mysql_query("SELECT * FROM " . $prefix . "_shop_orders where order_id!='' and temp_status !=0 $srch_by_nme $srch_by_stts $srch_by_stts2 $srch_by_price1 $srch_by_price2 $srch_by_phone $srch_by_id $srch_by_date1 $srch_by_date2 $affiliate_srch ");

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
    array("danger" => "<i class='fa fa-clock-o'></i> $lang_var_admin_351"),
    array("warning" => "<i class='fa fa-star-o'></i> $lang_var_admin_352"),
    array("info" => "<i class='fa fa-plane'></i> $lang_var_admin_353"),
    array("success" => "<i class='fa fa-check'></i> $lang_var_admin_354")
);

$status_list2 = array(
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

        if ($_REQUEST["sGroupActionName"] == "b_pay") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_orders SET order_pay_status=1 WHERE order_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_nopay") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_orders SET order_pay_status=0 WHERE order_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_new") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_orders SET order_status=0 WHERE order_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_ok") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_orders SET order_status=1 WHERE order_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_chip") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_orders SET order_status=2 WHERE order_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_done") {
            $sql_active = mysql_query("UPDATE " . $prefix . "_shop_orders SET order_status=3 WHERE order_id in ($multichkbx)") or die(mysql_error
            ());

        } elseif ($_REQUEST["sGroupActionName"] == "b_delete") {
            $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_shop_orders_items WHERE order_id in ($multichkbx)");
            $sql_delete = mysql_query("DELETE FROM  " . $prefix . "_shop_orders WHERE order_id in ($multichkbx)");

        }
        $records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
        $records["sMessage"] = $lang_var_admin_25;
    }
}


$sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_orders where order_id!='' and temp_status !=0 $srch_by_nme $srch_by_stts $srch_by_stts2 $srch_by_price1 $srch_by_price2 $srch_by_phone $srch_by_id $srch_by_date1 $srch_by_date2 $affiliate_srch order by $sort_by limit $iDisplayStart,$iDisplayLength");

while ($data_retrive = mysql_fetch_array($sql_retrive)) {

    $status = 1;
    $id = $data_retrive['order_id'];
    $status = $status_list[$data_retrive['order_status']];
    $status2 = $status_list2[$data_retrive['order_pay_status']];
    $day_mm = date('Y-m-d', strtotime($data_retrive['order_date']));
    $pd_current_date = date('Y-m-d', $_SERVER['REQUEST_TIME']);
    if ($day_mm == $pd_current_date) {
        $post_date = date('h:i A', strtotime($data_retrive['order_date']));
    } else {
        $post_date = date('d-m-Y', strtotime($data_retrive['order_date']));
    }
    $post_date_lng = date('d-m-Y h:i A', strtotime($data_retrive['order_date']));
    $order_date_is = "<div title='$post_date_lng'>" . $post_date . "</div>";
    if ($logged_allow_edit_status == 1) {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            $id,
            '<div style="text-align:center">' . $order_date_is . '</div>',
            stripcslashes($data_retrive['customer_name']) . "<div><small>" . stripcslashes($data_retrive['customer_email']) . "</small></div>",
            '<div style="text-align:center">' . stripcslashes($data_retrive['customer_phone']) . "<div><small>" . stripcslashes($data_retrive['customer_phone2']) . "</small></div>" . '</div>',
            '<div style="text-align:center">' . stripcslashes($data_retrive['order_total']) . '</div>',
            '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">&nbsp;' . (current($status)) . '&nbsp;</span></div>',
            '<div style="text-align:center"><span class="label label-sm label-' . (key($status2)) . '">' . (current($status2)) . '</span></div>',
            '<div style="text-align:center"><a href="?id=' . $id . '&act=update" class="btn btn-xs default"><i class="fa fa-edit"></i> ' . $lang_var_admin_6 . '</a></div>'
        );
    } else {
        $records["aaData"][] = array(
            '<div style="text-align:center"><input type="checkbox" name="id[]" value="' . $id . '"></div>',
            $id,
            '<div style="text-align:center">' . $order_date_is . '</div>',
            stripcslashes($data_retrive['customer_name']) . "<div><small>" . stripcslashes($data_retrive['customer_email']) . "</small></div>",
            '<div style="text-align:center">' . stripcslashes($data_retrive['customer_phone']) . "<div><small>" . stripcslashes($data_retrive['customer_phone2']) . "</small></div>" . '</div>',
            '<div style="text-align:center">' . stripcslashes($data_retrive['order_total']) . '</div>',
            '<div style="text-align:center"><span class="label label-sm label-' . (key($status)) . '">&nbsp;' . (current($status)) . '&nbsp;</span></div>',
            '<div style="text-align:center"><span class="label label-sm label-' . (key($status2)) . '">' . (current($status2)) . '</span></div>',
            ''
        );
    }

}


$records["sEcho"] = $sEcho;
$records["iTotalRecords"] = $iTotalRecords;
$records["iTotalDisplayRecords"] = $iTotalRecords;

echo json_encode($records);
?>