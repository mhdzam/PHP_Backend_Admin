<?php

require_once("template/page_start.php");
if ($site_members_status == 1) {
//--------

    $id = @$_GET['id'];
    $affiliate = @$_GET['affiliate'];
    $member_username = mysql_real_escape_string(@$_POST['member_username']);
    $member_password = @base64_encode(mysql_real_escape_string(@$_POST['member_password']));
    $member_firstname = mysql_real_escape_string(@$_POST['member_firstname']);
    $member_lastname = mysql_real_escape_string(@$_POST['member_lastname']);
    $member_photo = mysql_real_escape_string(@$_POST['member_photo']);
    $member_phone = mysql_real_escape_string(@$_POST['member_phone']);
    $member_city = mysql_real_escape_string(@$_POST['member_city']);
    $member_country_id = mysql_real_escape_string(@$_POST['member_country_id']);
    $member_email = mysql_real_escape_string(@$_POST['member_email']);
    $affiliate_paid = mysql_real_escape_string(@$_POST['affiliate_paid']);

    $file_del = mysql_real_escape_string(@$_POST['file_del']);
    $up_dir = "../uploads/members/";
    $file_name = @$_FILES['myfile']['name'];
    $file_temp_name = @$_FILES['myfile']['tmp_name'];
    $file_size = $up_dir . @$_FILES['myfile']['size'];


    $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_settings  WHERE settings_id ='1' ");
    $data_modify = mysql_fetch_array($sql_modify);
    $affiliate_status = stripcslashes($data_modify['affiliate_status']);
    $affiliate_price1 = stripcslashes($data_modify['affiliate_price1']);
    $affiliate_price2 = stripcslashes($data_modify['affiliate_price2']);

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
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
        <link rel="stylesheet" type="text/css" href="assets/css/flags.css"/>

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
                        <h3 class="page-title"><?php echo $lang_var_admin_287; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">

                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_287; ?></a>
                            </li>
                            <?php
							
                            if ($logged_allow_add_status == 1) {
                                ?>
                                <li class="btn-group">
                                    <a href="?act=new"><span id="sample_editable_1_new"
                                                             class="btn green">
    	<?php echo $lang_var_admin_292; ?> <i class="fa fa-plus"></i>
</span></a>
                                </li>
                                <?php
                            }
                            ?>
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

                        if ($act == "insert" && $member_email != "") {

                            // --- upload
                            $member_photo = "";
                            if ($file_name != "") {
                                if ($member_photo != "") {
                                    @unlink("$up_dir" . "$member_photo");
                                }
                                $ext = strrchr($file_name, ".");
                                $ext = strtolower($ext);
                                $xrand = time() . rand(1111, 9999);
                                $file_name = $up_dir . $xrand . $ext;
                                if (!in_array($ext, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width, $tmp_file_height) = @getimagesize($file_temp_name);
                                    if ($tmp_file_width > 0 && $tmp_file_height > 0) {
                                        if (move_uploaded_file($file_temp_name, $file_name)) {
                                            $member_photo = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $r = "select member_id from " . $prefix . "_members where member_username='$member_username'";
                            $sqlr = mysql_query($r);
                            $rr_count = mysql_num_rows($sqlr);
                            if ($rr_count == 0) {

                                $r2 = "select member_id from " . $prefix . "_members where member_email='$member_email'";
                                $sqlr2 = mysql_query($r2);
                                $rr_count2 = mysql_num_rows($sqlr2);
                                if ($rr_count2 == 0) {

                                    $sql_slct_max = mysql_query("select max(member_id)  from " . $prefix .
                                        "_members");
                                    $data_slct_max = mysql_fetch_array($sql_slct_max);
                                    $next_member_id = $data_slct_max[0] + 1;
                                    $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_members (
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
  edit_by,
  edit_date,
  edit_from,
  member_city,
  member_country_id) VALUES ('$next_member_id','$member_username','$member_password','$member_firstname','$member_lastname','$member_email','$member_phone','$member_photo',now(),'1','$pd_admin_user_id',now(),'$pd_admin_ip','$member_city','$member_country_id')");


                                    if ($sql_insert_new) {

                                        // insert notification
                                        $note_title_ar = ($lang_var_admin_401 . " " . $member_username);
                                        $note_title_en = ($lang_var_admin_402 . " " . $member_username);
                                        $note_icon = mysql_real_escape_string("<div class='label label-sm label-success'>
                            <i class='fa fa-user'></i>
                        </div>");
                                        $note_url = mysql_real_escape_string("members.php?id=$next_member_id&act=update");

                                        require_once("template/notifications_insert.php");
                                        // end of insert notification

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
                                } else {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        <?php echo $lang_var_admin_294; ?>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_293; ?>
                                </div>
                                <?php
                            }
                        }

                        if ($act == "saveupdate" && $member_email != "" && $id != "") {

                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$member_photo");
                                $member_photo = "";
                            }
                            if ($file_name != "") {
                                if ($member_photo != "") {
                                    @unlink("$up_dir" . "$member_photo");
                                }
                                $ext = strrchr($file_name, ".");
                                $ext = strtolower($ext);
                                $xrand = time() . rand(1111, 9999);
                                $file_name = $up_dir . $xrand . $ext;
                                if (!in_array($ext, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width, $tmp_file_height) = @getimagesize($file_temp_name);
                                    if ($tmp_file_width > 0 && $tmp_file_height > 0) {
                                        if (move_uploaded_file($file_temp_name, $file_name)) {
                                            $member_photo = $xrand . $ext;
                                        }
                                    }
                                }
                            }
                            $affiliate_update = "";
                            if ($affiliate_status == 1) {
                                $affiliate_update = " , affiliate_paid='$affiliate_paid'";
                            }
                            $sql_update = mysql_query("UPDATE " . $prefix . "_members SET member_username='$member_username',member_password='$member_password',member_firstname='$member_firstname',member_lastname='$member_lastname',member_photo='$member_photo',member_phone='$member_phone',member_email='$member_email',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',member_city='$member_city',member_country_id='$member_country_id' $affiliate_update WHERE member_id='$id'") or
                            die(mysql_error());
                            if ($sql_update) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_403 . " " . $member_username);
                                $note_title_en = ($lang_var_admin_404 . " " . $member_username);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-info'>
                            <i class='fa fa-user'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("members.php?id=$id&act=update");

                                require_once("template/notifications_insert.php");
                                // end of insert notification

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

                            $act = "update";
                        }
                        if ($act == "update") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                                "_members  WHERE member_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);

                            $member_username = stripcslashes($data_modify['member_username']);
                            $member_password = @base64_decode(stripcslashes($data_modify['member_password']));
                            $member_firstname = stripcslashes($data_modify['member_firstname']);
                            $member_lastname = stripcslashes($data_modify['member_lastname']);
                            $member_photo = stripcslashes($data_modify['member_photo']);
                            $member_phone = stripcslashes($data_modify['member_phone']);
                            $member_city = stripcslashes($data_modify['member_city']);
                            $member_country_id = stripcslashes($data_modify['member_country_id']);
                            $member_email = stripcslashes($data_modify['member_email']);
                            $affiliate_paid = stripcslashes($data_modify['affiliate_paid']);

                            $member_regdate = $data_modify['regdate'];
                            $member_ipaddress = $data_modify['ipaddress'];
                            $member_lastlogin = $data_modify['lastlogin'];

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];

                            $av_usr_img = "assets/img/profile.jpg";
                            if ($member_photo != "") {
                                $av_usr_img = "../uploads/members/$member_photo";
                            }


                            $facebook = "";
                            if ($data_modify['facebook_id'] != "") {
                                $facebook = "<a href='https://www.facebook.com/app_scoped_user_id/$data_modify[facebook_id]' target='_blank'><i class='fa fa-facebook-square'></i></a>";
                            }

                            $sql_gc = mysql_query("SELECT * FROM " . $prefix . "_countries  WHERE cnt_id ='$member_country_id' limit 1 ");
                            $data_gc = mysql_fetch_array($sql_gc);
                            $member_country_code = strtolower($data_gc['country_code']);
                            $member_country_title = $data_gc['country_' . $lang];
                            $flag = "";
                            if ($member_country_code != "") {
                                $flag = "<div class='pull-left flag flag-$member_country_code' title='$member_country_title' style='margin: 5px;'></div>";
                            }


                            // notices
                            $sql_notice_count = mysql_query("SELECT count(notice_id) as notice_count FROM " . $prefix . "_members_notices  WHERE member_id ='$id'");
                            $data_notice_count = mysql_fetch_array($sql_notice_count);
                            $notice_count = $data_notice_count['notice_count'];

                            // orders
                            $sql_order_count = mysql_query("SELECT count(order_id) as order_count FROM " . $prefix . "_shop_orders where  (member_id ='$id'  || customer_email = '$member_email')");
                            $data_order_count = mysql_fetch_array($sql_order_count);
                            $order_count = $data_order_count['order_count'];
                            // inbox
                            $sql_webmail_count = mysql_query("SELECT count(wm_id) as webmail_count FROM " . $prefix . "_webmail where cat_id=0 and (wm_from='$member_email' OR member_id='$id' )");
                            $data_webmail_count = mysql_fetch_array($sql_webmail_count);
                            $sent_count  = $data_webmail_count['webmail_count'];
                            // sent
                            $sql_webmail_count = mysql_query("SELECT count(wm_id) as webmail_count FROM " . $prefix . "_webmail where cat_id=1 and (wm_to_email='$member_email' OR member_id='$id' )");
                            $data_webmail_count = mysql_fetch_array($sql_webmail_count);
                            $inbox_count = $data_webmail_count['webmail_count'];


                            $sql_get_site_settings = mysql_query("SELECT * FROM " . $prefix . "_settings  WHERE settings_id ='1' ");
                            $data_get_site_settings = mysql_fetch_array($sql_get_site_settings);
                            $site_url = stripcslashes($data_get_site_settings['site_url']);

                            ?>

                            <div class="note" style="background-color: #f5f5f5 ">
                                <div class="pull-right"><img src="<?php echo $av_usr_img; ?>"
                                                             style="max-height:70px;margin:5px;border-radius: 50% !important;">
                                </div>
                                <br>
                                <h4> &nbsp;<?php echo $member_firstname; ?> <?php echo $member_lastname; ?>
                                    &nbsp; <?php echo $facebook; ?></h4>

                                <ul class="list-inline">
                                    <li>
                                        <?php echo $flag; ?> <?php echo $member_country_title; ?>
                                        - <?php echo $member_city; ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i> <span dir="ltr"><?php echo $member_phone; ?></span>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope"></i> <?php echo $member_email; ?>
                                    </li>

                                </ul>
                                <span dir="ltr"> <?php echo $lang_var_admin_523; ?> : <br> <?php echo $site_url; ?>
                                    ?affiliate=<?php echo $id; ?></span>

                            </div>

                            <div class="tabbable-custom ">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#info" data-toggle="tab">
                                            <i class="fa fa-user"></i> <?php echo $lang_var_admin_446; ?>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#orders" data-toggle="tab">
                                            <i class="fa fa-shopping-cart"></i> <?php echo $lang_var_admin_303; ?>
                                            <small style="color: #aaa">(<?php echo $order_count; ?>)</small>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#inbox" data-toggle="tab">
                                            <i class="fa fa-inbox"></i> <?php echo $lang_var_admin_451; ?>
                                            <small style="color: #aaa">(<?php echo $inbox_count; ?>)</small>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#sent" data-toggle="tab">
                                            <i class="fa fa-envelope-o"></i> <?php echo $lang_var_admin_452; ?>
                                            <small style="color: #aaa">(<?php echo $sent_count; ?>)</small>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="#remarks" data-toggle="tab">
                                            <i class="fa fa-comments-o"></i> <?php echo $lang_var_admin_450; ?>
                                            <small style="color: #aaa">(<?php echo $notice_count; ?>)</small>
                                        </a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="info">
                                        <div>

                                            <div>

                                                <!-- BEGIN FORM-->
                                                <form action="?id=<?php echo $id; ?>&act=saveupdate"
                                                      id="form_site_sections_new"
                                                      method="post" class="form-horizontal"
                                                      enctype="multipart/form-data">
                                                    <div class="form-body">
                                                        <div class="alert alert-danger display-hide">
                                                            <?php echo $lang_var_admin_12; ?>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_289; ?>
                                                                <span
                                                                    class="required">*</span></label>

                                                            <div class="col-md-4">
                                                                <input type="text" name="member_firstname" required=""
                                                                       value="<?php echo $member_firstname; ?>"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_288; ?>
                                                                <span
                                                                    class="required">*</span></label>

                                                            <div class="col-md-4">
                                                                <input type="text" name="member_lastname" required=""
                                                                       value="<?php echo $member_lastname; ?>"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_13; ?>
                                                                <span
                                                                    class="required">*</span></label>

                                                            <div class="col-md-4">
                                                                <input type="text" name="member_username" required=""
                                                                       value="<?php echo $member_username; ?>"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_14; ?>
                                                                <span
                                                                    class="required">*</span></label>

                                                            <div class="col-md-4">
                                                                <input type="text" name="member_password" required=""
                                                                       value="<?php echo $member_password; ?>"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_284; ?> </label>

                                                            <div class="col-md-4">
                                                                <input type="text" name="member_phone"
                                                                       value="<?php echo $member_phone; ?>"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_216; ?>
                                                                <span
                                                                    class="required">*</span></label>

                                                            <div class="col-md-4">
                                                                <input type="text" name="member_city" required
                                                                       value="<?php echo $member_city; ?>"
                                                                       class="form-control"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_217; ?>
                                                                <span
                                                                    class="required">*</span></label>

                                                            <div class="col-md-4">
                                                                <select class="form-control" name="member_country_id"
                                                                        class="select2me"
                                                                        required>
                                                                    <option value=""><?php echo $lang_var_admin_217; ?>
                                                                        ...
                                                                    </option>
                                                                    <?php
                                                                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_countries order by country_$lang");
                                                                    while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {

                                                                        $country_title = $data_father_retrive['country_' . $lang];

                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $data_father_retrive['cnt_id']; ?>" <?php if ($member_country_id == $data_father_retrive['cnt_id']) {
                                                                            echo "selected='selected'";
                                                                        } ?> ><?php echo $country_title; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_15; ?>
                                                                <span
                                                                    class="required">*</span></label>

                                                            <div class="col-md-4">
                                                                <input type="email" name="member_email"
                                                                       value="<?php echo $member_email; ?>"
                                                                       required="" class="form-control"/>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"><?php echo $lang_var_admin_18; ?> </label>

                                                            <div class="col-md-4">
                                                                <input type="file" name="myfile" class="form-control"/>
                                                                <input type="hidden" name="member_photo"
                                                                       id="file_hidden_var"
                                                                       value="<?php echo $member_photo; ?>"/>
                                                                <input type="hidden" name="file_del" id="file_del_var"
                                                                       value="0"/>
                                                                <?php
                                                                if ($member_photo != "") {
                                                                    ?>
                                                                    <div id="file_show_div">
                                                                        <div><img
                                                                                src="<?php echo "$up_dir" . "$member_photo"; ?>"
                                                                                style="max-width: 100%;margin: 5px 0;"/>
                                                                        </div>
                                                                        <a href="javascript:;"
                                                                           onclick="delete_file_onedit()"><span
                                                                                id="sample_editable_1_new"
                                                                                class="btn default"><i
                                                                                    class="fa fa-times"></i> <?php echo $lang_var_admin_19; ?> </span></a>
                                                                    </div>
                                                                    <div id="file_undo_div" style="display: none;">
                                                                        <a href="javascript:;"
                                                                           onclick="undo_delete_file_onedit()"><i
                                                                                class="fa fa-undo"></i> <?php echo $lang_var_admin_20; ?>
                                                                        </a>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <span class="help-block">e.g: .png, .jpeg, .jpg, .gif &nbsp; Size: 200x200 px</span>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label
                                                                class="control-label col-md-3"> </label>

                                                            <div class="col-md-4">
                                                                <?php echo $lang_var_admin_290; ?>
                                                                : <?php echo FormatDateTimeLong($member_regdate); ?>
                                                                <br>
                                                                <?php echo $lang_var_admin_291; ?>
                                                                : <?php echo FormatDateTimeLong($member_lastlogin); ?>
                                                                <br>
                                                                IP : <a
                                                                    href="ip.php?ip=<?php echo $member_ipaddress; ?>"><?php echo $member_ipaddress; ?></a>

                                                            </div>
                                                        </div>


                                                        <?php
                                                        if ($affiliate_status == 1) {
                                                            $sql_af1 = mysql_query("SELECT * FROM " . $prefix . "_members  WHERE affiliate ='$id' and member_status=1 ");
                                                            $affiliate_users = mysql_num_rows($sql_af1);

                                                            $sql_af2 = mysql_query("SELECT * FROM " . $prefix . "_shop_orders  WHERE affiliate ='$id' and order_pay_status=1");
                                                            $affiliate_orders = mysql_num_rows($sql_af2);

                                                            $sql_af3 = mysql_query("SELECT sum(order_total) as ttl, sum(ship_cost) as sttl FROM " . $prefix . "_shop_orders  WHERE affiliate ='$id'");
                                                            $data_ttls = mysql_fetch_array($sql_af3);
                                                            $ttl_cost = stripcslashes($data_ttls['ttl']);
                                                            $ttl_ship = stripcslashes($data_ttls['sttl']);
                                                            $all_cost = $ttl_cost - $ttl_ship;
                                                            $affiliate_order_cost = round($all_cost * ($affiliate_price2/100));
                                                            $affiliate_member_cost = $affiliate_users * $affiliate_price1;
                                                            $affiliate_total_cost = $affiliate_order_cost + $affiliate_member_cost;
                                                            $affiliate_total_cost_notpaid = $affiliate_total_cost - $affiliate_paid;
                                                            ?>

                                                            <h3>Affiliates</h3>
                                                            <hr>
                                                            <div class="form-group">
                                                                <label
                                                                    class="control-label col-md-3"><?php echo $lang_var_admin_529; ?>
                                                                    ( <?php echo $defult_currency; ?> )
                                                                </label>

                                                                <div class="col-md-4">
                                                                    <input type="text" name="affiliate_v" readonly
                                                                           value="<?php echo $affiliate_total_cost; ?>"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label
                                                                    class="control-label col-md-3"><?php echo $lang_var_admin_530; ?>
                                                                    ( <?php echo $defult_currency; ?> )
                                                                </label>

                                                                <div class="col-md-4">
                                                                    <input type="text" name="affiliate_paid"
                                                                           value="<?php echo $affiliate_paid; ?>"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label
                                                                    class="control-label col-md-3"><?php echo $lang_var_admin_472; ?>
                                                                    ( <?php echo $defult_currency; ?> )
                                                                </label>

                                                                <div class="col-md-4">
                                                                    <input type="text" name="affiliate_v2" readonly
                                                                           value="<?php echo $affiliate_total_cost_notpaid; ?>"
                                                                           class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <hr>

                                                            <?php
                                                        }
                                                        ?>

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
                                    </div>
                                    <div class="tab-pane" id="orders">
                                        <p>
                                            <?php
                                            @ require_once("template/members_orders.php");
                                            ?>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="inbox">
                                        <p>
                                            <?php
                                            @ require_once("template/members_inbox.php");
                                            ?>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="sent">
                                        <p>
                                            <?php
                                            @ require_once("template/members_sent.php");
                                            ?>
                                        </p>
                                    </div>
                                    <div class="tab-pane" id="remarks">
                                        <p>
                                            <?php
                                            @ require_once("template/members_remarks.php");
                                            ?>
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
                                <div class="page-loading page-loading-boxed">
                                    <img src="assets/img/loading-spinner-grey.gif" alt="" class="loading">
		<span>
			&nbsp;&nbsp;Loading...
		</span>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    </div>
                                </div>
                            </div>

                            <?php
                        } else {
                            if ($act == "new") {
                                ?>
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-edit"></i> <?php echo $lang_var_admin_292; ?>
                                        </div>
                                        <div class="tools">
                                            <a href="?" class="close"></a>

                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <!-- BEGIN FORM-->
                                        <form action="?act=insert" id="form_site_sections_new"
                                              method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="form-body">
                                                <div class="alert alert-danger display-hide">
                                                    <?php echo $lang_var_admin_12; ?>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_289; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="member_firstname" required=""
                                                               value="" class="form-control"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_288; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="member_lastname" required=""
                                                               value="" class="form-control"/>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_13; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="member_username" required=""
                                                               value="" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_14; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="member_password" required=""
                                                               value="" class="form-control"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_284; ?> </label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="member_phone" value=""
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_216; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="member_city"
                                                               value="" required
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_217; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <select class="form-control" name="member_country_id"
                                                                class="select2me"
                                                                required>
                                                            <option value=""
                                                                    selected='selected'><?php echo $lang_var_admin_217; ?>
                                                                ...
                                                            </option>
                                                            <?php
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_countries order by country_$lang");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {

                                                                $country_title = $data_father_retrive['country_' . $lang];

                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['cnt_id']; ?>"><?php echo $country_title; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_15; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="email" name="member_email" value=""
                                                               required="" class="form-control"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_18; ?> </label>

                                                    <div class="col-md-4">
                                                        <input type="file" name="myfile" class="form-control"/>
                                                        <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-actions fluid">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit"
                                                            class="btn green"><?php echo $lang_var_admin_23; ?></button>
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
                                <?php
                            } else {

                                @ require_once("template/members_view.php");
                            }
                        }
                        ?>

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

    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/lib/markdown.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>

    <script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/ui-alert-dialog-api.js"></script>
    <script src="assets/scripts/core/datatable_<?php echo $site_lang_dir; ?>.js"></script>
    <script src="assets/scripts/custom/table-ajax.js"></script>
    <script>
        var TableAjax = function () {

            var initPickers = function () {
                //init date pickers
                $('.date-picker').datepicker({
                    rtl: App.isRTL(),
                    autoclose: true
                });
            }

            var handleRecords = function () {

                var grid = new Datatable();
                grid.init({
                    src: $("#datatable_ajax"),
                    onSuccess: function (grid) {
                        // execute some code after table records loaded
                    },
                    onError: function (grid) {
                        // execute some code on network or other general error
                    },
                    dataTable: {  // here you can define a typical datatable settings from http://datatables.net/usage/options
                        /*
                         By default the ajax datatable's layout is horizontally scrollable and this can cause an issue of dropdown menu is used in the table rows which.
                         Use below "sDom" value for the datatable layout if you want to have a dropdown menu for each row in the datatable. But this disables the horizontal scroll.
                         */
                        //"sDom" : "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>r>>",

                        "aLengthMenu": [
                            [10, 30, 50, 100, 150, -1],
                            [10, 30, 50, 100, 150, "All"] // change per page values here
                        ],
                        "iDisplayLength": 30, // default record count per page
                        "bServerSide": true, // server side processing
                        "sAjaxSource": "template/members_view_ajax.php?lang=<?php echo $lang; ?>&var_admin_6=<?php echo $lang_var_admin_6; ?>&var_admin_25=<?php echo $lang_var_admin_25; ?>&logged_allow_edit_status=<?php echo $logged_allow_edit_status; ?>&affiliate=<?php echo $affiliate; ?>", // ajax source
                        "aaSorting": [[1, "desc"]], // set first column as a default sort by asc
                        "aoColumnDefs": [{
                            'bSortable': false,
                            'aTargets': [0, 5]
                        }]
                    }
                });

                // handle group actionsubmit button click
                grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                    e.preventDefault();
                    var action = $(".table-group-action-input", grid.getTableWrapper());
                    if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                        if (action.val() == "b_delete") {
                            if (confirm('<?php echo $lang_var_admin_109; ?>')) {
                                // Save it!
                                grid.addAjaxParam("sAction", "group_action");
                                grid.addAjaxParam("sGroupActionName", action.val());
                                var records = grid.getSelectedRows();
                                for (var i in records) {
                                    grid.addAjaxParam(records[i]["name"], records[i]["value"]);
                                }
                                grid.getDataTable().fnDraw();
                                grid.clearAjaxParams();
                            }
                        } else {
                            grid.addAjaxParam("sAction", "group_action");
                            grid.addAjaxParam("sGroupActionName", action.val());
                            var records = grid.getSelectedRows();
                            for (var i in records) {
                             grid.addAjaxParam(records[i]["name"], records[i]["value"]);
                            }
                            grid.getDataTable().fnDraw();
                            grid.clearAjaxParams();
                        }
                    } else if (action.val() == "") {
                        App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: '<?php echo $lang_var_admin_107; ?>',
                            container: grid.getTableWrapper(),
                            place: 'prepend'
                        });
                    } else if (grid.getSelectedRowsCount() === 0) {
                        App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: '<?php echo $lang_var_admin_108; ?>',
                            container: grid.getTableWrapper(),
                            place: 'prepend'
                        });
                    }
                });

            }

            return {

                //main function to initiate the module
                init: function () {

                    initPickers();
                    handleRecords();
                }

            };

        }();

        jQuery(document).ready(function () {
            App.init();
            TableManaged.init();

            TableAjax.init();

        });
    </script>
    </body>
    <!-- END BODY -->
    </html>
    <?php
} else {
    header("Location: index.php");
}
require_once("template/page_end.php");
?>