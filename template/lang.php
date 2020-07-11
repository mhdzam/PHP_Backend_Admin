<?php
$act = @$_GET['act'];
$lang_id = 1; // if no lang selected
$settings_lang = @$_POST['settings_lang'];
$pd_admin_user_id = @base64_decode( base64_decode($_COOKIE["pd_admin_user_id"]));

if ($settings_lang != "") {
    $settings_color = @$_POST['settings_color'];
    $settings_layout = @$_POST['settings_layout'];
    $settings_header = @$_POST['settings_header'];
    $settings_sidebar = @$_POST['settings_sidebar'];
    $settings_sidebar_position = @$_POST['settings_sidebar_position'];
	if($settings_color!=""){
    $sql_settings_update = mysql_query("UPDATE " . $prefix . "_users SET settings_color='$settings_color',settings_layout='$settings_layout',settings_header='$settings_header',settings_sidebar='$settings_sidebar',settings_sidebar_position='$settings_sidebar_position',settings_lang='$settings_lang' WHERE user_id='$pd_admin_user_id'") or die(mysql_error());
	}else{
	$sql_settings_update = mysql_query("UPDATE " . $prefix . "_users SET settings_layout='$settings_layout',settings_header='$settings_header',settings_sidebar='$settings_sidebar',settings_sidebar_position='$settings_sidebar_position',settings_lang='$settings_lang' WHERE user_id='$pd_admin_user_id'") or die(mysql_error());	
	}

}

$sql_get_settings = mysql_query("SELECT * FROM " . $prefix . "_users  WHERE user_id ='$pd_admin_user_id'");
$data_get_settings = mysql_fetch_array($sql_get_settings);
$settings_color = stripcslashes($data_get_settings['settings_color']);
$settings_layout = stripcslashes($data_get_settings['settings_layout']);
$settings_header = stripcslashes($data_get_settings['settings_header']);
$settings_sidebar = stripcslashes($data_get_settings['settings_sidebar']);
$settings_sidebar_position = stripcslashes($data_get_settings['settings_sidebar_position']);
$lang_id = stripcslashes($data_get_settings['settings_lang']);


$sql_choose_lang = mysql_query("SELECT * FROM " . $prefix . "_languages where lang_id ='$lang_id'");
$count_lang_check = mysql_num_rows($sql_choose_lang);
if ($count_lang_check == 0) {
    // defult language  1=en
    $sql_choose_lang = mysql_query("SELECT * FROM " . $prefix . "_languages where lang_id ='1'");
}

$data_choose_lang = mysql_fetch_array($sql_choose_lang);
//genral lang settings
$lang = stripcslashes($data_choose_lang['lang_code']);
$site_lang_id = stripcslashes($data_choose_lang['lang_id']);
$site_lang_title = stripcslashes($data_choose_lang['lang_title']);
$site_lang_charset = stripcslashes($data_choose_lang['lang_charset']);
$site_lang_dir = stripcslashes($data_choose_lang['lang_dir']);
$site_lang_align_right = stripcslashes($data_choose_lang['lang_align_right']);
$site_lang_align_left = stripcslashes($data_choose_lang['lang_align_left']);
$site_lang_status = stripcslashes($data_choose_lang['lang_status']);
$site_lang_icon = stripcslashes($data_choose_lang['lang_icon']);

// load all languages words
$lang_var = "0"; // 0=admin, 1=public site
$sql_choose_vars_lang = mysql_query("SELECT * FROM " . $prefix . "_languages_words where lang_id ='$site_lang_id' and word_type='$lang_var'");
while ($data_choose_vars_lang = mysql_fetch_array($sql_choose_vars_lang)) {
    $$data_choose_vars_lang['word_variable'] = nl2br(stripcslashes($data_choose_vars_lang['word_text']));
}

$sql_get_site_settings = mysql_query("SELECT * FROM " . $prefix . "_settings  WHERE settings_id ='1' ");
$data_get_site_settings = mysql_fetch_array($sql_get_site_settings);
$site_title = stripcslashes($data_get_site_settings['site_title_' . $lang]);

?>
