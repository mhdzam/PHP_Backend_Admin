<?php
require_once("template/page_start.php");
if ($logged_full_control_status == 1) {
//--------
    $ar_box_status = (@$_POST['ar_box_status']);
    $en_box_status = (@$_POST['en_box_status']);
    $seo_status = (@$_POST['seo_status']);
    $analytics_status = (@$_POST['analytics_status']);
    $banars_status = (@$_POST['banars_status']);
    $inbox_status = (@$_POST['inbox_status']);
    $calendar_status = (@$_POST['calendar_status']);
    $settings_status = (@$_POST['settings_status']);
    $newsletter_status = (@$_POST['newsletter_status']);
    $members_status = (@$_POST['members_status']);
    $orders_status = (@$_POST['orders_status']);
    $shop_settings_status = (@$_POST['shop_settings_status']);
    $shop_status = (@$_POST['shop_status']);
    $defult_currency_id = (@$_POST['defult_currency_id']);
    $site_timezone = @$_POST['site_timezone'];


    ?>

    <!DOCTYPE html>
    <!--[if IE 8]>
    <html lang="en" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]>
    <html lang="en" class="ie9 no-js"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <?php require_once("template/include_header.php"); ?>
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_<?php echo $site_lang_dir; ?>.css"/>
        <link rel="stylesheet" type="text/css"
              href="assets/plugins/select2/select2-metronic_<?php echo $site_lang_dir; ?>.css"/>
        <link rel="stylesheet" href="assets/plugins/data-tables/DT_bootstrap_<?php echo $site_lang_dir; ?>.css"/>
        <!-- END PAGE LEVEL STYLES -->
    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body class="page-header-fixed">
    <!-- BEGIN HEADER -->
    <?php require_once("template/header.php"); ?>
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <?php require_once("template/menu.php"); ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN STYLE CUSTOMIZER -->
                <?php require_once("template/settings.php"); ?>
                <!-- END STYLE CUSTOMIZER -->
                <!-- BEGIN PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title"><?php echo $lang_var_admin_59; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_37; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_59; ?></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        //   ----------- PAGE START

                        if ($act == "clearallsite") {

                            // Empty ALL SUB Folders
                            $dirs = array_filter(glob('../uploads/*'), 'is_dir');
                            foreach ($dirs as $subdir) {
                                $files = glob('../uploads/' . $subdir . '/*'); // get all file names
                                foreach ($files as $file) {
                                    $flatdot = substr($file, -5, 5);
                                    if ($flatdot != ".html") {
                                        if (is_file($file))
                                            unlink($file); // delete file
                                    }
                                }
                            }

                            // Empty Tables
                            $tables_names = array("banars", "calendar", "members", "newsletter", "notifications", "sections", "shop_brands", "shop_comments", "shop_coupons", "shop_items", "shop_items_colors", "shop_items_images", "shop_items_sizes", "shop_orders", "shop_orders_items", "shop_sections", "shop_shipping", "topics", "topics_comments", "topics_files", "topics_maps", "users_chats", "webmail", "webmail_files");
                            foreach ($tables_names as $table) {
                                $sql_empty = mysql_query("DELETE FROM  " . $prefix . "_$table");
                            }

                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $lang_var_admin_417; ?>
                            </div>
                            <?php

                        }

                        if ($act == "clearallvisitors") {

                            // Empty Tables
                            $tables_names = array("analytics_pages", "analytics_visitors");
                            foreach ($tables_names as $table) {
                                $sql_empty = mysql_query("DELETE FROM  " . $prefix . "_$table");
                            }

                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $lang_var_admin_417; ?>
                            </div>
                            <?php

                        }

                        if ($act == "insertfakedata") {
                            require_once("faker/autoload.php");
                            $fakerows = (@$_POST['rows_count']);

                            if ($fakerows < 1) {
                                $fakerows = 30;
                            }

                            $faker = Faker\Factory::create('en_US');
                            $faker->seed(5);
                            $faker_ar = Faker\Factory::create('ar_JO');
                            $faker_ar->seed(5);

                            for ($i = 1; $i <= $fakerows; $i++) {
                                $fake_en_firstName = $faker->firstName;
                                $fake_en_lastName = $faker->lastName;
                                $fake_en_fullname = $faker->name;
                                $fake_en_email = $faker->email;
                                $fake_en_phoneNumber = $faker->phoneNumber;
                                $fake_en_date_Y_m_d = $faker->dateTimeThisCentury->format('Y-m-d');
                                $fake_en_date_time = $faker->dateTimeThisCentury->format('Y-m-d H:i:s');
                                $fake_en_city = $faker->city;
                                $fake_en_streetAddress = $faker->streetAddress;
                                $fake_en_postcode = $faker->postcode;
                                $fake_en_state = $faker->state;
                                $fake_en_company = $faker->company;
                                $fake_en_company_slogan = $faker->catchPhrase;
                                $fake_en_company_desc = $faker->bs;
                                $fake_en_long_text = $faker->text(300);
                                $fake_en_long_text2 = $faker->text(600);
                                $fake_randomDigit = $faker->randomDigit;
                                $fake_randomDigit_long = $faker->randomNumber($nbDigits = NULL); // 79907610
                                $fake_ip = $faker->numberBetween($min = 0, $max = 256) . "." . $faker->numberBetween($min = 0, $max = 256) . "." . $faker->numberBetween($min = 0, $max = 256) . "." . $faker->numberBetween($min = 0, $max = 256);
                                $fake_price1 = $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL);
                                $fake_price2 = $faker->randomFloat($nbMaxDecimals = NULL, $min = $fake_price1, $max = NULL);

                                $fake_ar_firstName = $faker_ar->firstName;
                                $fake_ar_lastName = $faker_ar->lastName;
                                $fake_ar_fullname = $faker_ar->name;
                                $fake_ar_email = $faker_ar->email;
                                $fake_ar_phoneNumber = $faker_ar->phoneNumber;
                                $fake_ar_date_Y_m_d = $faker_ar->dateTimeThisCentury->format('Y-m-d');
                                $fake_ar_date_time = $faker_ar->dateTimeThisCentury->format('Y-m-d H:i:s');
                                $fake_ar_city = $faker_ar->city;
                                $fake_ar_streetAddress = $faker_ar->streetAddress;
                                $fake_ar_postcode = $faker_ar->postcode;
                                $fake_ar_state = $faker_ar->state;
                                $fake_ar_company = $faker_ar->company;
                                $fake_ar_company_slogan = $faker_ar->catchPhrase;
                                $fake_ar_company_desc = $faker_ar->bs;
                                $fake_ar_long_text = $faker_ar->text(300);
                                $fake_ar_long_text2 = $faker_ar->text(600);

                                $fake_item_id = $faker->numberBetween($min = 1, $max = $fakerows);
                                $fake_comment_status = $faker->numberBetween($min = 0, $max = 1);

                                // Members
                                $member_username = $fake_en_firstName . $fake_randomDigit_long;
                                $sql_sel_max = mysql_query("select max(member_id)  from " . $prefix . "_members");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_members (
  member_id,
  member_username,
  member_password,
  member_firstname,
  member_lastname,
  member_email,
  member_phone,
  member_photo,
  regdate,
  member_status,
  ipaddress,
  lastlogin,
  edit_date,
  edit_by,
  edit_from) VALUES ('$nxt_id','$member_username','$fake_randomDigit_long','$fake_ar_firstName','$fake_ar_lastName','$fake_ar_email','$fake_en_phoneNumber','','$fake_ar_date_time','1','$fake_ip','$fake_ar_date_time','$fake_ar_date_time','1','$fake_ip')");

                                // newsletter
                                $sql_sel_max = mysql_query("select max(nl_id)  from " . $prefix . "_newsletter");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_newsletter (
  nl_id,
  nl_name,
  nl_phone,
  nl_email,
  nl_date,
  ipaddress) VALUES ('$nxt_id','$fake_ar_fullname','$fake_en_phoneNumber','$fake_en_email','$fake_ar_date_time','$fake_ip')");

                                // sections
                                $fake_wm_section = $faker->numberBetween($min = 1, $max = 6);
                                $sql_sel_max = mysql_query("select max(section_id)  from " . $prefix . "_sections");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_sections (
  section_id,
  section_title_ar,
  section_title_en,
  father_id,
  row_no,
  section_status,
  visits,
  edit_date,
  edit_by,
  edit_from,
  wm_section_id) VALUES ('$nxt_id','$fake_ar_company_slogan','$fake_en_company_slogan','0','$i','1','$fake_randomDigit','$fake_en_date_time','1','$fake_ip','$fake_wm_section')");


                                // topics
                                $sql_sel_max = mysql_query("select max(topic_id)  from " . $prefix . "_topics");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_topics (
  topic_id,
  topic_title_ar,
  topic_title_en,
  topic_details_ar,
  topic_details_en,
  topic_date,
  cat_id,
  row_no,
  topic_status,
  visits,
  edit_date,
  edit_by,
  edit_from,
  wm_section_id) VALUES ('$nxt_id','$fake_ar_company_desc','$fake_en_company_desc','$fake_ar_long_text2','$fake_en_long_text2',now(),'$fake_item_id','$i','1','$fake_randomDigit','$fake_en_date_time','1','$fake_ip','$fake_wm_section')");

                                // shop_sections
                                $fthr = $faker->numberBetween($min = 0, $max = 10);
                                $sql_sel_max = mysql_query("select max(section_id)  from " . $prefix . "_shop_sections");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_shop_sections (
  section_id,
  section_title_ar,
  section_title_en,
  father_id,
  row_no,
  section_status,
  visits,
  edit_date,
  edit_by,
  edit_from) VALUES ('$nxt_id','$fake_ar_company_slogan','$fake_en_company_slogan','$fthr','$i','1','$fake_randomDigit','$fake_en_date_time','1','$fake_ip')");

                                // shop_brands
                                $sql_sel_max = mysql_query("select max(brand_id)  from " . $prefix . "_shop_brands");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_shop_brands (
  brand_id,
  brand_title_ar,
  brand_title_en,
  father_id,
  row_no,
  brand_status,
  visits,
  edit_date,
  edit_by,
  edit_from) VALUES ('$nxt_id','$fake_ar_company_slogan','$fake_en_company_slogan','0','$i','1','$fake_randomDigit','$fake_en_date_time','1','$fake_ip')");


                                // shop_items
                                $sql_sel_max = mysql_query("select max(item_id)  from " . $prefix . "_shop_items");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_shop_items (
  item_id,
  item_code,
  item_title_ar,
  item_title_en,
  item_details_ar,
  item_details_en,
  item_date,
  cat_id,
  row_no,
  item_status,
  visits,
  edit_date,
  edit_by,
  edit_from,
  item_price,
  item_first_price,
  item_type,
  item_offer_type) VALUES ('$nxt_id','$fake_randomDigit_long','$fake_ar_company_desc','$fake_en_company_desc','$fake_ar_long_text2','$fake_en_long_text2',now(),'$fake_item_id','$i','1','$fake_randomDigit','$fake_en_date_time','1','$fake_ip','$fake_price1','$fake_price2','$fake_comment_status','$fake_comment_status')");

                                // shop_comments
                                $sql_sel_max = mysql_query("select max(comment_id)  from " . $prefix . "_shop_comments");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_shop_comments (
  comment_id,
  name,
  email,
  comment,
  comment_date,
  comment_from,
  item_id,
  comment_status,
  edit_date,
  edit_by,
  edit_from) VALUES ('$nxt_id','$fake_ar_fullname','$fake_ar_email','$fake_ar_long_text','$fake_en_date_time','$fake_ip','$fake_item_id','$fake_comment_status','$fake_randomDigit','$fake_en_date_time','$fake_ip')");


                                // shop_orders
                                $order_status = $faker->numberBetween($min = 0, $max = 3);

                                $sql_sel_max = mysql_query("select max(order_id)  from " . $prefix . "_shop_orders");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1_ordr = mysql_query("INSERT INTO " . $prefix . "_shop_orders (
  order_id,
  order_no,
  order_status,
  order_pay_status,
  order_pay_method,
  order_date,
  order_total,
  ship_cost,
  discount_coupon,
  discount_total,
  member_id,
  customer_name,
  customer_phone,
  customer_phone2,
  customer_email,
  customer_state,
  customer_city,
  customer_address,
  edit_date,
  edit_by,
  edit_from) VALUES ('$nxt_id','$fake_randomDigit_long','$order_status','$fake_comment_status','$fake_ar_company_slogan','$fake_en_date_time','$fake_price2','$fake_price1','$fake_randomDigit_long','$fake_price1','$fake_item_id','$fake_ar_fullname','$fake_en_phoneNumber','$fake_ar_phoneNumber','$fake_ar_email','$fake_ar_state','$fake_ar_city','$fake_ar_streetAddress','$fake_en_date_time','1','$fake_ip')");

                                if ($sql1_ordr) {

                                    // shop_orders_items
                                    $sql_sel_max = mysql_query("select max(oitem_id)  from " . $prefix . "_shop_orders_items");
                                    $data_sel_max = mysql_fetch_array($sql_sel_max);
                                    $nxt_itm = $data_sel_max[0] + 1;
                                    $sql1 = mysql_query("INSERT INTO " . $prefix . "_shop_orders_items (
  oitem_id,
  order_id,
  item_id,
  oitem_qty,
  item_code,
  item_title_ar,
  item_title_en,
  item_price,
  item_first_price) VALUES ('$nxt_itm','$nxt_id','$fake_item_id','2','$fake_randomDigit_long','$fake_ar_company_desc','$fake_en_company_desc','$fake_price1','$fake_price2')");

                                }

                                // webmail

                                $f_cat_id = $faker->numberBetween($min = 0, $max = 3);
                                $sql_sel_max = mysql_query("select max(wm_id)  from " . $prefix . "_webmail");
                                $data_sel_max = mysql_fetch_array($sql_sel_max);
                                $nxt_id = $data_sel_max[0] + 1;
                                $sql1 = mysql_query("INSERT INTO " . $prefix . "_webmail (
  wm_id,
  cat_id,
  wm_title,
  wm_details,
  wm_date,
  wm_from,
  wm_from_name,
  wm_from_tel,
  wm_to_email,
  wm_to_name,
  wm_ip,
  wm_status,
  father_id,
  edit_date,
  edit_by,
  edit_from,
  wm_flag,
  wm_to_cc,
  wm_to_bcc) VALUES ('$nxt_id','$f_cat_id','$fake_ar_company_desc','$fake_ar_long_text','$fake_en_date_time','$fake_ar_email','$fake_en_fullname','$fake_en_phoneNumber','$fake_en_email','$fake_ar_firstName','$fake_ip','$fake_comment_status','0','$fake_en_date_time','1','$fake_ip','$fake_comment_status','$fake_ar_email','')");

                            }

                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo $lang_var_admin_418; ?>
                            </div>
                            <?php

                        }

                        ?>


                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption" style="min-width: 200px;">
                                    <i class="fa fa-sitemap"></i> <?php echo $lang_var_admin_489; ?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <br>
                                            <div class="col-md-1">
                                                <a href="sitemap.php" target="_blank">
                                                    <button type="button" class="btn green"><i
                                                            class="fa fa-sitemap"></i> <?php echo $lang_var_admin_489; ?>
                                                    </button>
                                                    <br>
                                                </a>
                                            </div>
                                            <br><br>
                                        </div>
                                    </div>

                                <!-- END FORM-->
                            </div>
                            <!-- END VALIDATION STATES-->
                        </div>


                        <?php
                        //   ----------- PAGE START

                        if ($act == "saveupdate" && $ar_box_status != "") {

                            $sql_update = mysql_query("UPDATE " . $prefix . "_webmaster_settings SET ar_box_status='$ar_box_status',en_box_status='$en_box_status',seo_status='$seo_status',analytics_status='$analytics_status',banars_status='$banars_status',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',inbox_status='$inbox_status',calendar_status='$calendar_status',settings_status='$settings_status',newsletter_status='$newsletter_status',members_status='$members_status',orders_status='$orders_status',shop_status='$shop_status',shop_settings_status='$shop_settings_status',defult_currency_id='$defult_currency_id',site_timezone='$site_timezone' WHERE set_id='1'") or
                            die(mysql_error());

                            if ($sql_update) {
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_25; ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_26; ?>
                                </div>
                                <?php
                            }
                        }

                        $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_webmaster_settings  WHERE set_id ='1' ");
                        $data_modify = mysql_fetch_array($sql_modify);
                        $ar_box_status = stripcslashes($data_modify['ar_box_status']);
                        $en_box_status = stripcslashes($data_modify['en_box_status']);
                        $seo_status = stripcslashes($data_modify['seo_status']);
                        $analytics_status = stripcslashes($data_modify['analytics_status']);
                        $banars_status = stripcslashes($data_modify['banars_status']);
                        $inbox_status = stripcslashes($data_modify['inbox_status']);
                        $calendar_status = stripcslashes($data_modify['calendar_status']);
                        $settings_status = stripcslashes($data_modify['settings_status']);
                        $newsletter_status = stripcslashes($data_modify['newsletter_status']);
                        $members_status = stripcslashes($data_modify['members_status']);
                        $orders_status = stripcslashes($data_modify['orders_status']);
                        $shop_settings_status = stripcslashes($data_modify['shop_settings_status']);
                        $shop_status = stripcslashes($data_modify['shop_status']);
                        $defult_currency_id = stripcslashes($data_modify['defult_currency_id']);
                        $site_timezone = stripcslashes($data_modify['site_timezone']);

                        $edit_date = $data_modify['edit_date'];
                        $edit_by = GetAdminUserName($data_modify['edit_by']);
                        $edit_from = $data_modify['edit_from'];
                        ?>
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-edit"></i> <?php echo $lang_var_admin_234; ?>
                                </div>

                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="?act=saveupdate" id="form_site_sections_new" method="post"
                                      class="form-horizontal form-bordered form-row-stripped"
                                      enctype="multipart/form-data">
                                    <div class="form-body">


                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_235; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="ar_box_status"
                                                                  value="1" <?php if ($ar_box_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="ar_box_status"
                                                                  value="0" <?php if ($ar_box_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_236; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="en_box_status"
                                                                  value="1" <?php if ($en_box_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="en_box_status"
                                                                  value="0" <?php if ($en_box_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_237; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="seo_status"
                                                                  value="1" <?php if ($seo_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="seo_status"
                                                                  value="0" <?php if ($seo_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_238; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="analytics_status"
                                                                  value="1" <?php if ($analytics_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="analytics_status"
                                                                  value="0" <?php if ($analytics_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_239; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="banars_status"
                                                                  value="1" <?php if ($banars_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="banars_status"
                                                                  value="0" <?php if ($banars_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_240; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="inbox_status"
                                                                  value="1" <?php if ($inbox_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="inbox_status"
                                                                  value="0" <?php if ($inbox_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_241; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="calendar_status"
                                                                  value="1" <?php if ($calendar_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="calendar_status"
                                                                  value="0" <?php if ($calendar_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_242; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="settings_status"
                                                                  value="1" <?php if ($settings_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="settings_status"
                                                                  value="0" <?php if ($settings_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_243; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="newsletter_status"
                                                                  value="1" <?php if ($newsletter_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="newsletter_status"
                                                                  value="0" <?php if ($newsletter_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_244; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="members_status"
                                                                  value="1" <?php if ($members_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="members_status"
                                                                  value="0" <?php if ($members_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_286; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="shop_status"
                                                                  value="1" <?php if ($shop_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="shop_status"
                                                                  value="0" <?php if ($shop_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_245; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="orders_status"
                                                                  value="1" <?php if ($orders_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="orders_status"
                                                                  value="0" <?php if ($orders_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_246; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="shop_settings_status"
                                                                  value="1" <?php if ($shop_settings_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                    <label><input type="radio" name="shop_settings_status"
                                                                  value="0" <?php if ($shop_settings_status == 0) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_369; ?> </label>

                                            <div class="col-md-2">
                                                <select class="form-control" name="defult_currency_id" class="select2me"
                                                        required>
                                                    <option value=""><?php echo $lang_var_admin_310; ?>...</option>
                                                    <?php
                                                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_currencies where father_id='0' order by row_no, currency_id");
                                                    while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                        if ($lang == "ar") {
                                                            $currency_title = $data_father_retrive['currency_title_ar'];
                                                        } else {
                                                            $currency_title = $data_father_retrive['currency_title_en'];
                                                        }
                                                        ?>
                                                        <option
                                                            value="<?php echo $data_father_retrive['currency_id']; ?>" <?php if ($defult_currency_id == $data_father_retrive['currency_id']) {
                                                            echo "selected='selected'";
                                                        } ?> ><?php echo $currency_title; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                class="control-label col-md-3"><?php echo $lang_var_admin_488; ?> </label>

                                            <div class="col-md-2">
                                                <select class="form-control" style="direction: ltr" id="site_timezone"
                                                        name="site_timezone" class="select2me"
                                                        required>
                                                    <option value=""><?php echo $lang_var_admin_488; ?>...</option>
                                                    <option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
                                                    <option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
                                                    <option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
                                                    <option value="US/Alaska">(UTC-09:00) Alaska</option>
                                                    <option value="America/Los_Angeles">(UTC-08:00) Pacific Time (US
                                                        &amp; Canada)
                                                    </option>
                                                    <option value="America/Tijuana">(UTC-08:00) Tijuana</option>
                                                    <option value="US/Arizona">(UTC-07:00) Arizona</option>
                                                    <option value="America/Chihuahua">(UTC-07:00) Chihuahua</option>
                                                    <option value="America/Chihuahua">(UTC-07:00) La Paz</option>
                                                    <option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
                                                    <option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp;
                                                        Canada)
                                                    </option>
                                                    <option value="America/Managua">(UTC-06:00) Central America</option>
                                                    <option value="US/Central">(UTC-06:00) Central Time (US &amp;
                                                        Canada)
                                                    </option>
                                                    <option value="America/Mexico_City">(UTC-06:00) Guadalajara</option>
                                                    <option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
                                                    <option value="America/Monterrey">(UTC-06:00) Monterrey</option>
                                                    <option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan
                                                    </option>
                                                    <option value="America/Bogota">(UTC-05:00) Bogota</option>
                                                    <option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp;
                                                        Canada)
                                                    </option>
                                                    <option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
                                                    <option value="America/Lima">(UTC-05:00) Lima</option>
                                                    <option value="America/Bogota">(UTC-05:00) Quito</option>
                                                    <option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)
                                                    </option>
                                                    <option value="America/Caracas">(UTC-04:30) Caracas</option>
                                                    <option value="America/La_Paz">(UTC-04:00) La Paz</option>
                                                    <option value="America/Santiago">(UTC-04:00) Santiago</option>
                                                    <option value="Canada/Newfoundland">(UTC-03:30) Newfoundland
                                                    </option>
                                                    <option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
                                                    <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Buenos
                                                        Aires
                                                    </option>
                                                    <option value="America/Argentina/Buenos_Aires">(UTC-03:00)
                                                        Georgetown
                                                    </option>
                                                    <option value="America/Godthab">(UTC-03:00) Greenland</option>
                                                    <option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
                                                    <option value="Atlantic/Azores">(UTC-01:00) Azores</option>
                                                    <option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.
                                                    </option>
                                                    <option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
                                                    <option value="Europe/London">(UTC+00:00) Edinburgh</option>
                                                    <option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time :
                                                        Dublin
                                                    </option>
                                                    <option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
                                                    <option value="Europe/London">(UTC+00:00) London</option>
                                                    <option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
                                                    <option value="UTC">(UTC+00:00) UTC</option>
                                                    <option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
                                                    <option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
                                                    <option value="Europe/Berlin">(UTC+01:00) Berlin</option>
                                                    <option value="Europe/Berlin">(UTC+01:00) Bern</option>
                                                    <option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
                                                    <option value="Europe/Brussels">(UTC+01:00) Brussels</option>
                                                    <option value="Europe/Budapest">(UTC+01:00) Budapest</option>
                                                    <option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
                                                    <option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
                                                    <option value="Europe/Madrid">(UTC+01:00) Madrid</option>
                                                    <option value="Europe/Paris">(UTC+01:00) Paris</option>
                                                    <option value="Europe/Prague">(UTC+01:00) Prague</option>
                                                    <option value="Europe/Rome">(UTC+01:00) Rome</option>
                                                    <option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
                                                    <option value="Europe/Skopje">(UTC+01:00) Skopje</option>
                                                    <option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
                                                    <option value="Europe/Vienna">(UTC+01:00) Vienna</option>
                                                    <option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
                                                    <option value="Africa/Lagos">(UTC+01:00) West Central Africa
                                                    </option>
                                                    <option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
                                                    <option value="Europe/Athens">(UTC+02:00) Athens</option>
                                                    <option value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
                                                    <option value="Africa/Cairo">(UTC+02:00) Cairo</option>
                                                    <option value="Africa/Harare">(UTC+02:00) Harare</option>
                                                    <option value="Europe/Helsinki">(UTC+02:00) Helsinki</option>
                                                    <option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
                                                    <option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
                                                    <option value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
                                                    <option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
                                                    <option value="Europe/Riga">(UTC+02:00) Riga</option>
                                                    <option value="Europe/Sofia">(UTC+02:00) Sofia</option>
                                                    <option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
                                                    <option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
                                                    <option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
                                                    <option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
                                                    <option value="Europe/Minsk">(UTC+03:00) Minsk</option>
                                                    <option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
                                                    <option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
                                                    <option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
                                                    <option value="Asia/Tehran">(UTC+03:30) Tehran</option>
                                                    <option value="Asia/Muscat">(UTC+04:00) Abu Dhabi</option>
                                                    <option value="Asia/Baku">(UTC+04:00) Baku</option>
                                                    <option value="Europe/Moscow">(UTC+04:00) Moscow</option>
                                                    <option value="Asia/Muscat">(UTC+04:00) Muscat</option>
                                                    <option value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
                                                    <option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
                                                    <option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
                                                    <option value="Asia/Kabul">(UTC+04:30) Kabul</option>
                                                    <option value="Asia/Karachi">(UTC+05:00) Islamabad</option>
                                                    <option value="Asia/Karachi">(UTC+05:00) Karachi</option>
                                                    <option value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
                                                    <option value="Asia/Calcutta">(UTC+05:30) Chennai</option>
                                                    <option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
                                                    <option value="Asia/Calcutta">(UTC+05:30) Mumbai</option>
                                                    <option value="Asia/Calcutta">(UTC+05:30) New Delhi</option>
                                                    <option value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura
                                                    </option>
                                                    <option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
                                                    <option value="Asia/Almaty">(UTC+06:00) Almaty</option>
                                                    <option value="Asia/Dhaka">(UTC+06:00) Astana</option>
                                                    <option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
                                                    <option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
                                                    <option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
                                                    <option value="Asia/Bangkok">(UTC+07:00) Bangkok</option>
                                                    <option value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
                                                    <option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
                                                    <option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
                                                    <option value="Asia/Hong_Kong">(UTC+08:00) Beijing</option>
                                                    <option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
                                                    <option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
                                                    <option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
                                                    <option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
                                                    <option value="Australia/Perth">(UTC+08:00) Perth</option>
                                                    <option value="Asia/Singapore">(UTC+08:00) Singapore</option>
                                                    <option value="Asia/Taipei">(UTC+08:00) Taipei</option>
                                                    <option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
                                                    <option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
                                                    <option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
                                                    <option value="Asia/Tokyo">(UTC+09:00) Osaka</option>
                                                    <option value="Asia/Tokyo">(UTC+09:00) Sapporo</option>
                                                    <option value="Asia/Seoul">(UTC+09:00) Seoul</option>
                                                    <option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
                                                    <option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
                                                    <option value="Australia/Darwin">(UTC+09:30) Darwin</option>
                                                    <option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
                                                    <option value="Australia/Canberra">(UTC+10:00) Canberra</option>
                                                    <option value="Pacific/Guam">(UTC+10:00) Guam</option>
                                                    <option value="Australia/Hobart">(UTC+10:00) Hobart</option>
                                                    <option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
                                                    <option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby
                                                    </option>
                                                    <option value="Australia/Sydney">(UTC+10:00) Sydney</option>
                                                    <option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
                                                    <option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
                                                    <option value="Pacific/Auckland">(UTC+12:00) Auckland</option>
                                                    <option value="Pacific/Fiji">(UTC+12:00) Fiji</option>
                                                    <option value="Pacific/Kwajalein">(UTC+12:00) International Date
                                                        Line West
                                                    </option>
                                                    <option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
                                                    <option value="Asia/Magadan">(UTC+12:00) Magadan</option>
                                                    <option value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
                                                    <option value="Asia/Magadan">(UTC+12:00) New Caledonia</option>
                                                    <option value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
                                                    <option value="Pacific/Auckland">(UTC+12:00) Wellington</option>
                                                    <option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit"
                                                    class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                            <a href="?">
                                                <button type="button"
                                                        class="btn default"><?php echo $lang_var_admin_22; ?></button>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                            <!-- END VALIDATION STATES-->
                        </div>


                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption" style="min-width: 200px;">
                                    <i class="fa fa-trash-o"></i> <?php echo $lang_var_admin_412; ?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="?act=clearallsite" id="form_sample_3" method="post"
                                      class="form-horizontal"
                                      enctype="multipart/form-data">
                                    <div class="form-body">

                                        <div class="form-group">
                                            <div class="col-md-2">
                                                <button id="clearallsitebtn" type="submit" class="btn red"><i
                                                        class="fa fa-trash-o"></i> <?php echo $lang_var_admin_413; ?>
                                                </button>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="?act=clearallvisitors" id="clearallvisitorsbtn"
                                                   class="btn yellow"><i
                                                        class="fa fa-users"></i> <?php echo $lang_var_admin_419; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- END FORM-->
                            </div>
                            <!-- END VALIDATION STATES-->
                        </div>

                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption" style="min-width: 200px;">
                                    <i class="fa fa-keyboard-o"></i> <?php echo $lang_var_admin_414; ?>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="?act=insertfakedata" id="form_sample_3" method="post"
                                      class="form-horizontal"
                                      enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <div class="col-md-2"><?php echo $lang_var_admin_415; ?>
                                                <input type="text" name="rows_count" required="" value="20"
                                                       class="form-control"/>
                                            </div>
                                            <div class="col-md-1"><br>
                                                <button id="insertfakedatabtn" type="submit" class="btn green"><i
                                                        class="fa fa-keyboard-o"></i> <?php echo $lang_var_admin_416; ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- END FORM-->
                            </div>
                            <!-- END VALIDATION STATES-->
                        </div>


                        <?php
                        //   ----------- PAGE END


                        ?>

                    </div>
                </div>
                <!-- END PAGE CONTENT-->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <?php require_once("template/footer.php"); ?>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <?php require_once("template/include_footer.php"); ?>
    <!-- END JAVASCRIPTS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script>

    <script type="text/javascript" src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
    <script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/lib/markdown.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>
    <script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/ui-alert-dialog-api.js"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
            UIAlertDialogApi.init();
            TableManaged.init();

        });
    </script>
    <script>
        $("#clearallsitebtn").click(function (e) {
            if (confirm('<?php echo $lang_var_admin_412; ?>')) {
            } else {
                return false;
            }
        });
        $("#clearallvisitorsbtn").click(function (e) {
            if (confirm('<?php echo $lang_var_admin_412; ?>')) {
            } else {
                return false;
            }
        });
        $("#insertfakedatabtn").click(function (e) {
            if (confirm('<?php echo $lang_var_admin_414; ?>')) {
            } else {
                return false;
            }
        });
    </script>
    <script>

        $('#site_timezone').find('option[value="<?php echo $site_timezone;?>"]').attr('selected', 'selected');

    </script>
    </body>
    <!-- END BODY -->
    </html>
    <?php
} else {
    header("Location: 404.php");
    exit();
}
require_once("template/page_end.php");
?>