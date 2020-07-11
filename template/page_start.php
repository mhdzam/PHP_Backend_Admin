<?php
// make it or break it
error_reporting(E_ALL);

// begin output buffering
ob_start();

require_once("../includes/connection.php");
require_once("template/functions.php");
require_once("template/lang.php");

// check login

$pd_admin_user_id = base64_decode( base64_decode($_COOKIE["pd_admin_user_id"]));
$pd_admin_user_name = base64_decode( base64_decode($_COOKIE["pd_admin_user_name"]));
$pd_admin_user_password = base64_decode( base64_decode($_COOKIE["pd_admin_user_password"]));

$sql_adminlog_check = mysql_query("SELECT * FROM " . $prefix .
    "_users  where user_id='$pd_admin_user_id' and user_password='$pd_admin_user_password' and user_status=1");
$row_check_adminlog = mysql_num_rows($sql_adminlog_check);

$sql_adminlog_check2 = mysql_query("SELECT * FROM " . $prefix .
    "_users  where user_id='$pd_admin_user_id' and user_status=1");
$row_check_adminlog2 = mysql_num_rows($sql_adminlog_check2);

if ($row_check_adminlog != 0) {
    $data_adminlog_check = mysql_fetch_array($sql_adminlog_check);
    $logged_admin_user_name = stripcslashes($data_adminlog_check['user_name']);
    $logged_admin_control_type = stripcslashes($data_adminlog_check['control_type']);
    $logged_admin_user_photo = stripcslashes($data_adminlog_check['user_photo']);
    $logged_admin_user_fullname = stripcslashes($data_adminlog_check['user_fullname']);
    if ($logged_admin_user_fullname == "") {
        $logged_admin_user_fullname = $logged_admin_user_name;
    }
    $logged_admin_user_email = stripcslashes($data_adminlog_check['user_email']);

    if ($logged_admin_control_type == 0) { //  webmaster
        $logged_full_control_status = 1;
        $logged_allow_add_status = 1;
        $logged_allow_edit_status = 1;
        $logged_allow_delete_status = 1;
        $logged_allow_view_status = 1;
    } elseif ($logged_admin_control_type == 1) { //  site manager
        $logged_full_control_status = 0;
        $logged_allow_add_status = 1;
        $logged_allow_edit_status = 1;
        $logged_allow_delete_status = 1;
        $logged_allow_view_status = 1;
    } elseif ($logged_admin_control_type == 2) { //  normal user
        $logged_full_control_status = 0;
        $logged_allow_add_status = 1;
        $logged_allow_edit_status = 1;
        $logged_allow_delete_status = 0;
        $logged_allow_view_status = 1;
    } else { //  view only
        $logged_full_control_status = 0;
        $logged_allow_add_status = 0;
        $logged_allow_edit_status = 0;
        $logged_allow_delete_status = 0;
        $logged_allow_view_status = 1;
    }


} else if ($row_check_adminlog2 != 0 && $pd_admin_user_password == "") {
    $data_adminlog_check = mysql_fetch_array($sql_adminlog_check2);
    $logged_admin_user_name = stripcslashes($data_adminlog_check['user_name']);
    $logged_admin_control_type = stripcslashes($data_adminlog_check['control_type']);
    $logged_admin_user_photo = stripcslashes($data_adminlog_check['user_photo']);
    $logged_admin_user_fullname = stripcslashes($data_adminlog_check['user_fullname']);
    if ($logged_admin_user_fullname == "") {
        $logged_admin_user_fullname = $logged_admin_user_name;
    }
    $logged_admin_user_email = stripcslashes($data_adminlog_check['user_email']);

    if ($pd_current_page_php != "lock.php") {
        header("Location: lock.php?act=lock");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
// End of check login

$wm_section = @$_GET['wm_section'];

$sql_get_site_settings = mysql_query("SELECT * FROM " . $prefix . "_webmaster_settings  WHERE set_id ='1' ");
$data_get_site_settings = mysql_fetch_array($sql_get_site_settings);
$site_ar_box_status = stripcslashes($data_get_site_settings['ar_box_status']);
$site_en_box_status = stripcslashes($data_get_site_settings['en_box_status']);
$site_seo_status = stripcslashes($data_get_site_settings['seo_status']);
$site_analytics_status = stripcslashes($data_get_site_settings['analytics_status']);
$site_banars_status = stripcslashes($data_get_site_settings['banars_status']);
$site_inbox_status = stripcslashes($data_get_site_settings['inbox_status']);
$site_calendar_status = stripcslashes($data_get_site_settings['calendar_status']);
$site_settings_status = stripcslashes($data_get_site_settings['settings_status']);
$site_newsletter_status = stripcslashes($data_get_site_settings['newsletter_status']);
$site_members_status = stripcslashes($data_get_site_settings['members_status']);
$site_orders_status = stripcslashes($data_get_site_settings['orders_status']);
$site_shop_settings_status = stripcslashes($data_get_site_settings['shop_settings_status']);
$site_shop_status = stripcslashes($data_get_site_settings['shop_status']);
$site_defult_currency_id = stripcslashes($data_get_site_settings['defult_currency_id']);
$site_timezone = stripcslashes($data_get_site_settings['site_timezone']);

$sql_get_site_currency = mysql_query("SELECT * FROM " . $prefix . "_shop_currencies  WHERE currency_id ='$site_defult_currency_id' ");
$data_get_site_currency = mysql_fetch_array($sql_get_site_currency);
$defult_currency = stripcslashes($data_get_site_currency['currency_shorttitle']);

$ar_lang_icon = "";
$en_lang_icon = "";
if ($site_ar_box_status != 0 && $site_en_box_status != 0) {
    $ar_lang_icon = " <small style='color:gray'>[العربية]</small>";
    $en_lang_icon = " <small style='color:gray'>[English]</small>";
}

?>