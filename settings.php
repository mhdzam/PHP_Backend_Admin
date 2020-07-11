<?php
require_once("template/page_start.php");
if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
//--------

    $site_title_ar = mysql_real_escape_string(@$_POST['site_title_ar']);
    $map = (@$_POST['map']);
    $site_title_en = mysql_real_escape_string(@$_POST['site_title_en']);
    $site_desc_ar = mysql_real_escape_string(@$_POST['site_desc_ar']);
    $site_desc_en = mysql_real_escape_string(@$_POST['site_desc_en']);
    $site_keywords_ar = mysql_real_escape_string(@$_POST['site_keywords_ar']);
    $site_keywords_en = mysql_real_escape_string(@$_POST['site_keywords_en']);
    $site_webmails = mysql_real_escape_string(@$_POST['site_webmails']);
    $site_url = mysql_real_escape_string(@$_POST['site_url']);
    $site_status = (@$_POST['site_status']);
    $close_msg = mysql_real_escape_string(@$_POST['close_msg']);

    $social_link1 = mysql_real_escape_string(@$_POST['social_link1']);
    $social_link2 = mysql_real_escape_string(@$_POST['social_link2']);
    $social_link3 = mysql_real_escape_string(@$_POST['social_link3']);
    $social_link4 = mysql_real_escape_string(@$_POST['social_link4']);
    $social_link5 = mysql_real_escape_string(@$_POST['social_link5']);
    $social_link6 = mysql_real_escape_string(@$_POST['social_link6']);
    $social_link7 = mysql_real_escape_string(@$_POST['social_link7']);
    $social_link8 = mysql_real_escape_string(@$_POST['social_link8']);
    $social_link9 = mysql_real_escape_string(@$_POST['social_link9']);
    $social_link10 = mysql_real_escape_string(@$_POST['social_link10']);

    $contact_t1_ar = mysql_real_escape_string(@$_POST['contact_t1_ar']);
    $contact_t1_en = mysql_real_escape_string(@$_POST['contact_t1_en']);
    $contact_t3 = mysql_real_escape_string(@$_POST['contact_t3']);
    $contact_t4 = mysql_real_escape_string(@$_POST['contact_t4']);
    $contact_t5 = mysql_real_escape_string(@$_POST['contact_t5']);
    $contact_t6 = mysql_real_escape_string(@$_POST['contact_t6']);

    $home_option1 = mysql_real_escape_string(@$_POST['home_option1']);
    $home_option2 = mysql_real_escape_string(@$_POST['home_option2']);
    $home_option3 = mysql_real_escape_string(@$_POST['home_option3']);
    $home_option4 = mysql_real_escape_string(@$_POST['home_option4']);
    $home_option5 = mysql_real_escape_string(@$_POST['home_option5']);
    $home_option6 = mysql_real_escape_string(@$_POST['home_option6']);
    $home_option7 = mysql_real_escape_string(@$_POST['home_option7']);
    $home_option8 = mysql_real_escape_string(@$_POST['home_option8']);
    $home_option9 = mysql_real_escape_string(@$_POST['home_option9']);
    $home_option10 = mysql_real_escape_string(@$_POST['home_option10']);

    $affiliate_status = mysql_real_escape_string(@$_POST['affiliate_status']);
    $affiliate_price1 = mysql_real_escape_string(@$_POST['affiliate_price1']);
    $affiliate_price2 = mysql_real_escape_string(@$_POST['affiliate_price2']);


    $up_dir = "../uploads/";
    $file_name = @$_FILES['myfile']['name'];
    $file_temp_name = @$_FILES['myfile']['tmp_name'];
    $file_size = $up_dir . @$_FILES['myfile']['size'];

    $file_name2 = @$_FILES['myfile2']['name'];
    $file_temp_name2 = @$_FILES['myfile2']['tmp_name'];
    $file_size2 = $up_dir . @$_FILES['myfile2']['size'];

    $file_name3 = @$_FILES['myfile3']['name'];
    $file_temp_name3 = @$_FILES['myfile3']['tmp_name'];
    $file_size3 = $up_dir . @$_FILES['myfile3']['size'];

    $file_del = mysql_real_escape_string(@$_POST['file_del']);
    $file_del2 = mysql_real_escape_string(@$_POST['file_del2']);
    $file_del3 = mysql_real_escape_string(@$_POST['file_del3']);

    $site_logo_ar = mysql_real_escape_string(@$_POST['site_logo_ar']);
    $site_logo_en = mysql_real_escape_string(@$_POST['site_logo_en']);
    $site_icon = mysql_real_escape_string(@$_POST['site_icon']);

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
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-colorpicker/css/colorpicker.css"/>

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

                        if ($act == "saveupdate" && $site_title_ar != "") {


                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$site_logo_ar");
                                $site_logo_ar = "";
                            }
                            if ($file_name != "") {
                                if ($site_logo_ar != "") {
                                    @unlink("$up_dir" . "$site_logo_ar");
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
                                            $site_logo_ar = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            // --- upload 2
                            if ($file_del2 == 1) {
                                @unlink("$up_dir" . "$site_logo_en");
                                $site_logo_en = "";
                            }
                            if ($file_name2 != "") {
                                $ext2 = strrchr($file_name2, ".");
                                $ext2 = strtolower($ext2);
                                $xrand2 = time() . rand(1111, 9999);
                                $file_name2 = $up_dir . $xrand2 . $ext2;
                                if (!in_array($ext2, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext2; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width2, $tmp_file_height2) = @getimagesize($file_temp_name2);
                                    if ($tmp_file_width2 > 0 && $tmp_file_height2 > 0) {
                                        if (move_uploaded_file($file_temp_name2, $file_name2)) {
                                            $site_logo_en = $xrand2 . $ext2;
                                        }
                                    }
                                }
                            }
                            // --- upload 3
                            if ($file_del3 == 1) {
                                @unlink("$up_dir" . "$site_icon");
                                $site_icon = "";
                            }
                            if ($file_name3 != "") {
                                $ext3 = strrchr($file_name3, ".");
                                $ext3 = strtolower($ext3);
                                $xrand3 = time() . rand(1111, 9999);
                                $file_name3 = $up_dir . $xrand3 . $ext3;
                                if (!in_array($ext3, $allowed_imgs_type)) {
                                    ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true"></button>
                                        [ <?php echo $ext3; ?> ] <?php echo $lang_var_admin_27; ?>
                                    </div>
                                    <?php
                                } else {
                                    list($tmp_file_width3, $tmp_file_height3) = @getimagesize($file_temp_name3);
                                    if ($tmp_file_width3 > 0 && $tmp_file_height3 > 0) {
                                        if (move_uploaded_file($file_temp_name3, $file_name3)) {
                                            $site_icon = $xrand3 . $ext3;
                                        }
                                    }
                                }
                            }

                            $sql_update = mysql_query("UPDATE " . $prefix . "_settings SET
    site_title_ar='$site_title_ar',
    site_title_en='$site_title_en',
    site_desc_ar='$site_desc_ar',
    site_desc_en='$site_desc_en',
	map='$map',
    site_keywords_ar='$site_keywords_ar',
    site_keywords_en='$site_keywords_en',
    site_webmails='$site_webmails',
    site_url='$site_url',
    site_status='$site_status',
    close_msg='$close_msg',
    social_link1='$social_link1',
    social_link2='$social_link2',
    social_link3='$social_link3',
    social_link4='$social_link4',
    social_link5='$social_link5',
    social_link6='$social_link6',
    social_link7='$social_link7',
    social_link8='$social_link8',
    social_link9='$social_link9',
    social_link10='$social_link10',
    contact_t1_ar='$contact_t1_ar',
    contact_t1_en='$contact_t1_en',
    contact_t3='$contact_t3',
    contact_t4='$contact_t4',
    contact_t5='$contact_t5',
    contact_t6='$contact_t6',
    affiliate_status='$affiliate_status',
    affiliate_price1='$affiliate_price1',
    affiliate_price2='$affiliate_price2',
    home_option1='$home_option1',
    home_option2='$home_option2',
    home_option8='$home_option8',
    home_option9='$home_option9',
    home_option10='$home_option10',
    site_logo_ar='$site_logo_ar',
    site_logo_en='$site_logo_en',
    site_icon='$site_icon',
    edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE settings_id='1'") or die(mysql_error());

                            if ($sql_update) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_390);
                                $note_title_en = ($lang_var_admin_389);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-danger'>
                            <i class='fa fa-cog'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("settings.php");

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
                        }

                        $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_settings  WHERE settings_id ='1' ");
                        $data_modify = mysql_fetch_array($sql_modify);
						$map = stripcslashes($data_modify['map']);
                        $site_title_ar = stripcslashes($data_modify['site_title_ar']);
                        $site_title_en = stripcslashes($data_modify['site_title_en']);
                        $site_desc_ar = stripcslashes($data_modify['site_desc_ar']);
                        $site_desc_en = stripcslashes($data_modify['site_desc_en']);
                        $site_keywords_ar = stripcslashes($data_modify['site_keywords_ar']);
                        $site_keywords_en = stripcslashes($data_modify['site_keywords_en']);
                        $site_webmails = stripcslashes($data_modify['site_webmails']);
                        $site_url = stripcslashes($data_modify['site_url']);
                        $site_status = stripcslashes($data_modify['site_status']);
                        $close_msg = stripcslashes($data_modify['close_msg']);

                        $social_link1 = stripcslashes($data_modify['social_link1']);
                        $social_link2 = stripcslashes($data_modify['social_link2']);
                        $social_link3 = stripcslashes($data_modify['social_link3']);
                        $social_link4 = stripcslashes($data_modify['social_link4']);
                        $social_link5 = stripcslashes($data_modify['social_link5']);
                        $social_link6 = stripcslashes($data_modify['social_link6']);
                        $social_link7 = stripcslashes($data_modify['social_link7']);
                        $social_link8 = stripcslashes($data_modify['social_link8']);
                        $social_link9 = stripcslashes($data_modify['social_link9']);
                        $social_link10 = stripcslashes($data_modify['social_link10']);

                        $contact_t1_ar = stripcslashes($data_modify['contact_t1_ar']);
                        $contact_t1_en = stripcslashes($data_modify['contact_t1_en']);
                        $contact_t3 = stripcslashes($data_modify['contact_t3']);
                        $contact_t4 = stripcslashes($data_modify['contact_t4']);
                        $contact_t5 = stripcslashes($data_modify['contact_t5']);
                        $contact_t6 = stripcslashes($data_modify['contact_t6']);

                        $home_option1 = stripcslashes($data_modify['home_option1']);
                        $home_option2 = stripcslashes($data_modify['home_option2']);
                        $home_option3 = stripcslashes($data_modify['home_option3']);
                        $home_option4 = stripcslashes($data_modify['home_option4']);
                        $home_option5 = stripcslashes($data_modify['home_option5']);
                        $home_option6 = stripcslashes($data_modify['home_option6']);
                        $home_option7 = stripcslashes($data_modify['home_option7']);
                        $home_option8 = stripcslashes($data_modify['home_option8']);
                        $home_option9 = stripcslashes($data_modify['home_option9']);
                        $home_option10 = stripcslashes($data_modify['home_option10']);

                        $affiliate_status = stripcslashes($data_modify['affiliate_status']);
                        $affiliate_price1 = stripcslashes($data_modify['affiliate_price1']);
                        $affiliate_price2 = stripcslashes($data_modify['affiliate_price2']);

                        $site_logo_ar = stripcslashes($data_modify['site_logo_ar']);
                        $site_logo_en = stripcslashes($data_modify['site_logo_en']);
                        $site_icon = stripcslashes($data_modify['site_icon']);

                        $edit_date = $data_modify['edit_date'];
                        $edit_by = GetAdminUserName($data_modify['edit_by']);
                        $edit_from = $data_modify['edit_from'];
                        ?>
                        <form action="?act=saveupdate" id="form_site_sections_new" name="form_site_sections_new"
                              method="post"
                              class="form-horizontal form-bordered form-row-stripped" enctype="multipart/form-data">

                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_255; ?>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">

                                        <?php if ($site_ar_box_status != 0) { ?>
                                            <div class="form-group">
                                                <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_247; ?><?php echo $ar_lang_icon; ?></label>

                                                <div class="col-md-7">
                                                    <input type="text" name="site_title_ar" dir="rtl" required=""
                                                           maxlength="65"
                                                           value="<?php echo $site_title_ar; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($site_en_box_status != 0) { ?>
                                            <div class="form-group">
                                                <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_247; ?><?php echo $en_lang_icon; ?></label>

                                                <div class="col-md-7">
                                                    <input type="text" name="site_title_en" dir="ltr" required=""
                                                           maxlength="65"
                                                           value="<?php echo $site_title_en; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($site_ar_box_status != 0) { ?>
                                            <div class="form-group">
                                                <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_248; ?><?php echo $ar_lang_icon; ?></label>

                                                <div class="col-md-7" dir="rtl">
                            <textarea name="site_desc_ar" rows="3" dir="rtl" maxlength="165"
                                      class="form-control"><?php echo $site_desc_ar; ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($site_en_box_status != 0) { ?>
                                            <div class="form-group">
                                                <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_248; ?><?php echo $en_lang_icon; ?></label>

                                                <div class="col-md-7" dir="rtl">
                            <textarea name="site_desc_en" rows="3" dir="ltr" maxlength="165"
                                      class="form-control"><?php echo $site_desc_en; ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($site_ar_box_status != 0) { ?>
                                            <div class="form-group">
                                                <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_194; ?><?php echo $ar_lang_icon; ?></label>

                                                <div class="col-md-7" dir="rtl">
                            <textarea name="site_keywords_ar" rows="3" dir="rtl"
                                      class="form-control"><?php echo $site_keywords_ar; ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($site_en_box_status != 0) { ?>
                                            <div class="form-group">
                                                <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_194; ?><?php echo $en_lang_icon; ?></label>

                                                <div class="col-md-7" dir="rtl">
                            <textarea name="site_keywords_en" rows="3" dir="ltr"
                                      class="form-control"><?php echo $site_keywords_en; ?></textarea>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_249; ?></label>

                                            <div class="col-md-7">
                                                <input type="text" name="site_url" dir="ltr" required=""
                                                       value="<?php echo $site_url; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_159; ?></label>

                                            <div class="col-md-7">
                                                <input type="text" name="site_webmails" dir="ltr" required=""
                                                       value="<?php echo $site_webmails; ?>" class="form-control"/>
                                            </div>
                                        </div>
										
										<div class="form-group">
                                                <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_421; ?></label>

                                                <div class="col-md-7" dir="rtl">
                            <textarea name="map" rows="3" dir="ltr"
                                      class="form-control"><?php echo $map; ?></textarea>
                                                </div>
                                            </div>

                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_531; ?>  <?php echo $ar_lang_icon; ?></label>

                                            <div class="col-md-4">
                                                <input type="file" name="myfile" class="form-control"/>
                                                <input type="hidden" name="site_logo_ar" id="file_hidden_var"
                                                       value="<?php echo $site_logo_ar; ?>"/>
                                                <input type="hidden" name="file_del" id="file_del_var"
                                                       value="0"/>
                                                <?php
                                                if ($site_logo_ar != "") {
                                                    ?>
                                                    <div id="file_show_div">
                                                        <div><img
                                                                    src="<?php echo "$up_dir" . "$site_logo_ar"; ?>"
                                                                    style="max-width: 100%;margin: 5px 0;"/></div>
                                                        <a href="javascript:;"
                                                           onclick="delete_file_onedit()"><span
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
                                                <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_531; ?>  <?php echo $en_lang_icon; ?></label>

                                            <div class="col-md-4">
                                                <input type="file" name="myfile2" class="form-control"/>
                                                <input type="hidden" name="site_logo_en" id="file_hidden_var2"
                                                       value="<?php echo $site_logo_en; ?>"/>
                                                <input type="hidden" name="file_del2" id="file_del_var2"
                                                       value="0"/>
                                                <?php
                                                if ($site_logo_en != "") {
                                                    ?>
                                                    <div id="file_show_div2">
                                                        <div><img
                                                                    src="<?php echo "$up_dir" . "$site_logo_en"; ?>"
                                                                    style="max-width: 100%;margin: 5px 0;"/></div>
                                                        <a href="javascript:;"
                                                           onclick="delete_file_onedit2()"><span
                                                                    class="btn default"><i
                                                                        class="fa fa-times"></i> <?php echo $lang_var_admin_19; ?> </span></a>
                                                    </div>
                                                    <div id="file_undo_div2" style="display: none;">
                                                        <a href="javascript:;"
                                                           onclick="undo_delete_file_onedit2()"><i
                                                                    class="fa fa-undo"></i> <?php echo $lang_var_admin_20; ?>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_532; ?></label>

                                            <div class="col-md-4">
                                                <input type="file" name="myfile3" class="form-control"/>
                                                <input type="hidden" name="site_icon" id="file_hidden_var3"
                                                       value="<?php echo $site_icon; ?>"/>
                                                <input type="hidden" name="file_del3" id="file_del_var3"
                                                       value="0"/>
                                                <?php
                                                if ($site_icon != "") {
                                                    ?>
                                                    <div id="file_show_div3">
                                                        <div><img
                                                                    src="<?php echo "$up_dir" . "$site_icon"; ?>"
                                                                    style="max-width: 100%;margin: 5px 0;"/></div>
                                                        <a href="javascript:;"
                                                           onclick="delete_file_onedit3()"><span
                                                                    class="btn default"><i
                                                                        class="fa fa-times"></i> <?php echo $lang_var_admin_19; ?> </span></a>
                                                    </div>
                                                    <div id="file_undo_div3" style="display: none;">
                                                        <a href="javascript:;"
                                                           onclick="undo_delete_file_onedit3()"><i
                                                                    class="fa fa-undo"></i> <?php echo $lang_var_admin_20; ?>
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit"
                                                    class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                        </div>
                                    </div>

                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>


                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_257; ?>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">


                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_256; ?> <i
                                                        class="fa fa-facebook-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link1" dir="ltr"
                                                       value="<?php echo $social_link1; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_258; ?> <i
                                                        class="fa fa-twitter-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link2" dir="ltr"
                                                       value="<?php echo $social_link2; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_259; ?> <i
                                                        class="fa fa-google-plus-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link3" dir="ltr"
                                                       value="<?php echo $social_link3; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_260; ?> <i
                                                        class="fa fa-linkedin-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link4" dir="ltr"
                                                       value="<?php echo $social_link4; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_261; ?> <i
                                                        class="fa fa-youtube-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link5" dir="ltr"
                                                       value="<?php echo $social_link5; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <?php /*
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_262; ?> <i
                                                    class="fa fa-flickr"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link6" dir="ltr"
                                                       value="<?php echo $social_link6; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_263; ?> <i
                                                    class="fa fa-pinterest-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link7" dir="ltr"
                                                       value="<?php echo $social_link7; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
 */ ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_374; ?> <i
                                                        class="fa fa-instagram"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link8" dir="ltr"
                                                       value="<?php echo $social_link8; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <?php /*
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_375; ?> <i
                                                    class="fa fa-tumblr-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link9" dir="ltr"
                                                       value="<?php echo $social_link9; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3"><?php echo $lang_var_admin_264; ?> <i
                                                    class="fa fa-phone-square"></i></label>

                                            <div class="col-md-7">
                                                <input type="text" name="social_link10" dir="ltr"
                                                       value="<?php echo $social_link10; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
  */ ?>
                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit"
                                                    class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                        </div>
                                    </div>

                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>


                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_491; ?>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">


                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_192; ?><?php echo $ar_lang_icon; ?></label>

                                            <div class="col-md-7">
                                                <input type="text" name="contact_t1_ar"
                                                       value="<?php echo $contact_t1_ar; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_192; ?><?php echo $en_lang_icon; ?></label>

                                            <div class="col-md-7">
                                                <input type="text" name="contact_t1_en" dir="ltr"
                                                       value="<?php echo $contact_t1_en; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_284; ?> </label>

                                            <div class="col-md-7">
                                                <input type="text" name="contact_t3" dir="ltr"
                                                       value="<?php echo $contact_t3; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_492; ?> </label>

                                            <div class="col-md-7">
                                                <input type="text" name="contact_t4" dir="ltr"
                                                       value="<?php echo $contact_t4; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_493; ?> </label>

                                            <div class="col-md-7">
                                                <input type="text" name="contact_t5" dir="ltr"
                                                       value="<?php echo $contact_t5; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_2; ?> </label>

                                            <div class="col-md-7">
                                                <input type="text" name="contact_t6" dir="ltr"
                                                       value="<?php echo $contact_t6; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit"
                                                    class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                        </div>
                                    </div>

                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>


                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_497; ?>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_498; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="home_option1" value="1"
                                                            <?php if ($home_option1 == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_113; ?> </label>
                                                    <label><input type="radio" name="home_option1" value="0"
                                                            <?php if ($home_option1 == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_114; ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_499; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="home_option2" value="1"
                                                            <?php if ($home_option2 == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_113; ?> </label>
                                                    <label><input type="radio" name="home_option2" value="0"
                                                            <?php if ($home_option2 == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_114; ?> </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_502; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="home_option8" value="0"
                                                            <?php if ($home_option8 == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_503; ?> </label>
                                                    <label><input type="radio" name="home_option8" value="1"
                                                            <?php if ($home_option8 == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_504; ?> </label>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_506; ?> </label>

                                            <div class="col-md-2">

                                                <div class="input-group color colorpicker-default"
                                                     data-color="<?php echo $home_option10; ?>"
                                                     data-color-format="rgba">
                                                    <input type="text" name="home_option10"
                                                           onkeyup="update_chgclr(this.value)" id="home_option10"
                                                           autocomplete="off" class="form-control"
                                                           style="direction: ltr" value="<?php echo $home_option10; ?>">
                                                    <span class="input-group-btn">
													<button class="btn default" type="button"><i id="cpbg"
                                                                                                 style="background-color: <?php echo $home_option10; ?>;"></i>&nbsp;</button>
												</span>

                                                </div>

                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:null" onclick="update_restcolor()"
                                                   style="margin: 8px;display: block"><?php echo $lang_var_admin_507; ?></a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_518; ?> </label>

                                            <div class="col-md-2">

                                                <div class="input-group color colorpicker-default"
                                                     data-color="<?php echo $home_option9; ?>" data-color-format="rgba">
                                                    <input type="text" name="home_option9"
                                                           onkeyup="update_chgclr2(this.value)" id="home_option9"
                                                           autocomplete="off" class="form-control"
                                                           style="direction: ltr" value="<?php echo $home_option9; ?>">
                                                    <span class="input-group-btn">
													<button class="btn default" type="button"><i id="cpbg2"
                                                                                                 style="background-color: <?php echo $home_option9; ?>;"></i>&nbsp;</button>
												</span>

                                                </div>

                                            </div>
                                            <div class="col-md-2">
                                                <a href="javascript:null" onclick="update_restcolor2()"
                                                   style="margin: 8px;display: block"><?php echo $lang_var_admin_507; ?></a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit"
                                                    class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                        </div>
                                    </div>

                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>


                            <div class="portlet box yellow">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_525; ?>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">


                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_526; ?> </label>

                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="affiliate_status" value="1"
                                                            <?php if ($affiliate_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_113; ?> </label>
                                                    <label><input type="radio" name="affiliate_status" value="0"
                                                            <?php if ($affiliate_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_114; ?> </label>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_527; ?>
                                                ( <?php echo $defult_currency; ?> ) </label>

                                            <div class="col-md-2">
                                                <input type="text" name="affiliate_price1" dir="ltr"
                                                       value="<?php echo $affiliate_price1; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_528; ?> (
                                                % )</label>

                                            <div class="col-md-2">
                                                <input type="text" name="affiliate_price2" dir="ltr"
                                                       value="<?php echo $affiliate_price2; ?>"
                                                       class="form-control"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit"
                                                    class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                        </div>
                                    </div>

                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>

                            <div class="portlet box red">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_254; ?>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">

                                        <div class="form-group">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_251; ?> </label>
                                            <?php
                                            $blkdis = "none";
                                            ?>
                                            <div class="col-md-4">
                                                <div class="radio-list">
                                                    <label><input type="radio" name="site_status" value="1"
                                                                  onclick="document.getElementById('close_msg').style.display='none'" <?php if ($site_status == 1) {
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_252; ?> </label>
                                                    <label><input type="radio" name="site_status" value="0"
                                                                  onclick="document.getElementById('close_msg').style.display='block'" <?php if ($site_status == 0) {
                                                            $blkdis = "block";
                                                            echo "checked";
                                                        } ?>/><?php echo $lang_var_admin_253; ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="close_msg" style="display: <?php echo $blkdis; ?>">
                                            <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_250; ?></label>

                                            <div class="col-md-7" dir="rtl">
                        <textarea name="close_msg" rows="5" dir="ltr"
                                  class="form-control"><?php echo $close_msg; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-actions fluid">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit"
                                                    class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                        </div>
                                    </div>

                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>

                        </form>
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

    <script type="text/javascript" src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>
    <script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/ui-alert-dialog-api.js"></script>
    <script>
        var ComponentsPickers = function () {

            var handleColorPicker = function () {
                if (!jQuery().colorpicker) {
                    return;
                }
                $('.colorpicker-default').colorpicker({
                    format: 'hex'
                });
                $('.colorpicker-rgba').colorpicker();
            }


            return {
                //main function to initiate the module
                init: function () {
                    handleColorPicker();
                }
            };

        }();

        jQuery(document).ready(function () {
            App.init();
            UIAlertDialogApi.init();
            TableManaged.init();
            ComponentsPickers.init();


        });

        function update_restcolor() {
            document.form_site_sections_new.home_option10.value = '#323a45';
            $("#cpbg").css("background-color", "#323a45");
        }

        function update_chgclr(d) {
            $("#cpbg").css("background-color", d);
        }

        function update_restcolor2() {
            document.form_site_sections_new.home_option9.value = '#e74c3c';
            $("#cpbg2").css("background-color", "#e74c3c");
        }

        function update_chgclr2(d) {
            $("#cpbg2").css("background-color", d);
        }
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