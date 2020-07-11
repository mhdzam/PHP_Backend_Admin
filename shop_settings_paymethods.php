<?php



require_once("template/page_start.php");
if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
//--------
    $id = @$_GET['id'];
    $clicked_btn = @$_POST['clicked_btn'];
//-------
    $paymethod_title_en = mysql_real_escape_string(@$_POST['paymethod_title_en']);
    $paymethod_title_ar = mysql_real_escape_string(@$_POST['paymethod_title_ar']);
    $paymethod_details_ar = mysql_real_escape_string(@$_POST['paymethod_details_ar']);
    $paymethod_details_en = mysql_real_escape_string(@$_POST['paymethod_details_en']);
    $father_id = mysql_real_escape_string(@$_POST['father_id']);
    $paymethod_icon = mysql_real_escape_string(@$_POST['paymethod_icon']);
    $file_del = mysql_real_escape_string(@$_POST['file_del']);
    $paymethod_settings = mysql_real_escape_string(@$_POST['paymethod_settings']);

    $up_dir = "../uploads/sections/";
    $file_name = @$_FILES['myfile']['name'];
    $file_temp_name = @$_FILES['myfile']['tmp_name'];
    $file_size = $up_dir . @$_FILES['myfile']['size'];

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
                        <h3 class="page-title"><?php echo $lang_var_admin_333; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_300; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_333; ?></a>
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


                        ?>

                        <?php
                        $multichkbx = @$_POST['multichkbx'];
                        $all_multichkbx = "";
                        if ($clicked_btn == "b_saveorder") {
                            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_shop_paymethods");
                            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                $inm = "row_no" . "$data_delete_who[paymethod_id]";
                                $row_no = @$_POST[$inm];
                                $sql_sveorder = mysql_query("UPDATE " . $prefix . "_shop_paymethods SET row_no='$row_no' WHERE paymethod_id='$data_delete_who[paymethod_id]'") or die (mysql_error());
                                if ($sql_sveorder) {
                                    $actin_done = 1;
                                }
                            }


                        }
                        if ($multichkbx != "") {
                            while (list($key, $val) = @each($multichkbx)) {
                                $all_multichkbx .= "$val,";
                            }
                            $multichkbx = substr($all_multichkbx, 0, -1);
                            //-------------
                            $actin_done = 0;
                            if ($clicked_btn == "b_active") {
                                $sql_active = mysql_query("UPDATE " . $prefix .
                                    "_shop_paymethods SET paymethod_status=1 WHERE paymethod_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_shop_paymethods SET paymethod_status=0 WHERE paymethod_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix .
                                    "_shop_paymethods where paymethod_id  in ($multichkbx)");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['paymethod_icon'] != "") {
                                        @unlink("$up_dir" . "$data_delete_who[paymethod_icon]");
                                    }
                                }
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_shop_paymethods where paymethod_id in ($multichkbx)");
                                if ($sql_delete) {
                                    $actin_done = 1;
                                }

                            }
                            if ($actin_done == 1) {
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true"></button>
                                    <?php echo $lang_var_admin_25; ?>
                                </div>
                                <?php
                            }

                        }

                        if ($act == "insert" && $paymethod_title_en != "") {

                            // --- upload
                            $paymethod_icon = "";
                            if ($file_name != "") {
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
                                            $paymethod_icon = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $r = "select max(row_no)  from " . $prefix . "_shop_paymethods where father_id='$father_id'";
                            $sqlr = mysql_query($r);
                            $rr = mysql_fetch_array($sqlr);
                            $row = $rr[0] + 1;

                            $sql_slct_max = mysql_query("select max(paymethod_id)  from " . $prefix .
                                "_shop_paymethods");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_paymethod_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_shop_paymethods (
  paymethod_id,
  paymethod_title_ar,
  paymethod_title_en,
  paymethod_details_ar,
  paymethod_details_en,
  father_id,
  paymethod_icon,
  paymethod_status,
  edit_by,  
  edit_date,
  edit_from,
  row_no,
  paymethod_settings) VALUES ('$next_paymethod_id','$paymethod_title_ar','$paymethod_title_en','$paymethod_details_ar','$paymethod_details_en','$father_id','$paymethod_icon','1','$pd_admin_user_id',now(),'$pd_admin_ip','$row','$paymethod_settings')");

                            if ($sql_insert_new) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_409 . " " . $paymethod_title_ar);
                                $note_title_en = ($lang_var_admin_410 . " " . $paymethod_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-default'>
                            <i class='fa fa-briefcase'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_settings_paymethods.php?id=$next_paymethod_id&act=update");

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
                        if ($act == "saveupdate" && $paymethod_title_en != "" && $id != "") {

                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$paymethod_icon");
                                $paymethod_icon = "";
                            }
                            if ($file_name != "") {
                                if ($paymethod_icon != "") {
                                    @unlink("$up_dir" . "$paymethod_icon");
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
                                            $paymethod_icon = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $sql_update = mysql_query("UPDATE " . $prefix . "_shop_paymethods SET paymethod_title_ar='$paymethod_title_ar',paymethod_title_en='$paymethod_title_en',paymethod_details_ar='$paymethod_details_ar',paymethod_details_en='$paymethod_details_en',father_id='$father_id',paymethod_icon='$paymethod_icon',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',paymethod_settings='$paymethod_settings' WHERE paymethod_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_387 . " " . $paymethod_title_ar);
                                $note_title_en = ($lang_var_admin_388 . " " . $paymethod_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-default'>
                            <i class='fa fa-pencil-square-o'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_settings_paymethods.php?id=$id&act=update");

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

                        if ($act == "update") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                                "_shop_paymethods  WHERE paymethod_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $paymethod_title_ar = stripcslashes($data_modify['paymethod_title_ar']);
                            $paymethod_title_en = stripcslashes($data_modify['paymethod_title_en']);
                            $paymethod_details_ar = stripcslashes($data_modify['paymethod_details_ar']);
                            $paymethod_details_en = stripcslashes($data_modify['paymethod_details_en']);
                            $father_id = stripcslashes($data_modify['father_id']);
                            $paymethod_icon = stripcslashes($data_modify['paymethod_icon']);
                            $paymethod_settings = stripcslashes($data_modify['paymethod_settings']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_345; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?id=<?php echo $id; ?>&act=saveupdate" method="post"
                                          class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">

                                            <?php
                                            $ws_shop_paymethod_st = 1;
                                            if ($ws_shop_paymethod_st == 2) {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_90; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-6">
                                                        <select class="form-control" name="father_id" class="select2me">
                                                            <option value=""><?php echo $lang_var_admin_91; ?>...
                                                            </option>
                                                            <?php
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_paymethods where father_id='0' and paymethod_id !='$id' order by row_no, paymethod_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                if ($lang == "ar") {
                                                                    $section_title = $data_father_retrive['paymethod_title_ar'];
                                                                } else {
                                                                    $section_title = $data_father_retrive['paymethod_title_en'];
                                                                }


                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['paymethod_id']; ?>" <?php if ($father_id == $data_father_retrive['paymethod_id']) {
                                                                    echo "selected='selected'";
                                                                } ?> ><?php echo $section_title; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php if ($site_ar_box_status != 0) { ?>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_334; ?>  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-6">
                                                    <input type="text" name="paymethod_title_ar" required=""
                                                           value="<?php echo $paymethod_title_ar; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>  <?php echo $ar_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-6" dir="ltr">
                                                <textarea name="paymethod_details_ar" dir="rtl"
                                                          rows="5"
                                                          class="form-control"><?php echo $paymethod_details_ar; ?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php if ($site_en_box_status != 0) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_334; ?>  <?php echo $en_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-6">
                                                        <input type="text" name="paymethod_title_en" required=""
                                                               value="<?php echo $paymethod_title_en; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>  <?php echo $ar_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-6" dir="ltr">
                                                <textarea name="paymethod_details_en" dir="rtl"
                                                          rows="5"
                                                          class="form-control"><?php echo $paymethod_details_en; ?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_336; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-6">
                                                    <input type="text" name="paymethod_settings" required=""
                                                           value="<?php echo $paymethod_settings; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_46; ?> </label>

                                                <div class="col-md-6">
                                                    <input type="file" name="myfile" class="form-control"/>
                                                    <input type="hidden" name="paymethod_icon" id="file_hidden_var"
                                                           value="<?php echo $paymethod_icon; ?>"/>
                                                    <input type="hidden" name="file_del" id="file_del_var" value="0"/>
                                                    <?php
                                                    if ($paymethod_icon != "") {
                                                        ?>
                                                        <div id="file_show_div">
                                                            <div><img src="<?php echo "$up_dir" . "$paymethod_icon"; ?>"
                                                                      style="max-width: 100%;margin: 5px 0;"/></div>
                                                            <a href="javascript:;" onclick="delete_file_onedit()"><span
                                                                    id="sample_editable_1_new" class="btn default"><i
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

                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                                &nbsp;
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
                        } elseif ($act == "new") {
                            ?>

                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_335; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?act=insert" method="post" class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">

                                            <?php
                                            $ws_shop_paymethod_st = 1;
                                            if ($ws_shop_paymethod_st == 2) {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_90; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-6">
                                                        <select class="form-control" name="father_id" class="select2me">
                                                            <option value=""><?php echo $lang_var_admin_91; ?>...
                                                            </option>
                                                            <?php
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_paymethods where father_id='0' order by row_no, paymethod_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                if ($lang == "ar") {
                                                                    $section_title = $data_father_retrive['paymethod_title_ar'];
                                                                } else {
                                                                    $section_title = $data_father_retrive['paymethod_title_en'];
                                                                }
                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['paymethod_id']; ?>"><?php echo $section_title; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php if ($site_ar_box_status != 0) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_334; ?>  <?php echo $ar_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-6">
                                                        <input type="text" name="paymethod_title_ar" required=""
                                                               value="<?php echo $paymethod_title_ar; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>  <?php echo $ar_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-6" dir="ltr">
                                                <textarea name="paymethod_details_ar" dir="rtl"
                                                          rows="5"
                                                          class="form-control"><?php echo $paymethod_details_ar; ?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php if ($site_en_box_status != 0) { ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_334; ?>  <?php echo $en_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-6">
                                                        <input type="text" name="paymethod_title_en" required=""
                                                               value="<?php echo $paymethod_title_en; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_103; ?>  <?php echo $ar_lang_icon; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-6" dir="ltr">
                                                <textarea name="paymethod_details_en" dir="rtl"
                                                          rows="5"
                                                          class="form-control"><?php echo $paymethod_details_en; ?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_336; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-6">
                                                    <input type="text" name="paymethod_settings" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_46; ?> </label>

                                                <div class="col-md-6">
                                                    <input type="file" name="myfile" class="form-control"/>
                                                    <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-actions fluid">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit"
                                                        class="btn green"><?php echo $lang_var_admin_23; ?></button>
                                                &nbsp;
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
                            ?>
                            <div>
                                <form name="multicheckfrm" id="multicheckfrm" method="post" action="?">
                                    <div class="table-toolbar">
                                        <div class="btn-group">
                                            <a href="?act=new"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_335; ?> <i class="fa fa-plus"></i>
									</span></a>
                                        </div>
                                        <div class="btn-group pull-right">
                                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-th-large"></i> <?php echo $lang_var_admin_29; ?> <i
                                                    class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="javascript:;"
                                                       onclick="multicheckfrm.clicked_btn.value='b_active';document.getElementById('multicheckfrm').submit();"><i
                                                            class="fa fa-check"></i> <?php echo $lang_var_admin_30; ?>
                                                    </a></li>
                                                <li><a href="javascript:;"
                                                       onclick="multicheckfrm.clicked_btn.value='b_block';document.getElementById('multicheckfrm').submit();"><i
                                                            class="fa fa-times"></i> <?php echo $lang_var_admin_31; ?>
                                                    </a></li>
                                               <li><a href="javascript:;" id="confirmation_box_for_delete"
                                                      onclick="multicheckfrm.clicked_btn.value='b_delete';"><i
                                                           class="fa fa-trash-o"></i> <?php echo $lang_var_admin_32; ?>
                                                   </a></li>
                                                <input type="hidden" name="clicked_btn" size="78" value=""/>
                                            </ul>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th class="table-checkbox" style="width: 3%;">
                                                <input type="checkbox" class="checkall"/>
                                            </th>
                                            <th><?php echo $lang_var_admin_334; ?></th>
                                            <th style="width: 7%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                            "_shop_paymethods where father_id=0 order by row_no, paymethod_id");
                                        $page_records_count = mysql_num_rows($sql_retrive);
                                        if ($page_records_count == 0) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td colspan="6" style="text-align: center;">
                                                    <small><?php echo $lang_var_admin_93; ?></small>
                                                </td>

                                            </tr>
                                            <?php
                                        } else {

                                            while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                                if ($data_retrive['paymethod_status'] == 1) {
                                                    $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                } else {
                                                    $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                }
                                                $paymethod_icon = "";
                                                if ($data_retrive['paymethod_icon'] != "") {
                                                    $paymethod_icon = "<div class='pull-left'><img src='$up_dir" . "$data_retrive[paymethod_icon]' style='width:25px;height:15px;margin:5px'></div>";
                                                }

                                                ?>
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                               value="<?php echo
                                                               $data_retrive['paymethod_id']; ?>"/>
                                                    </td>
                                                    <td><input type="text"
                                                               name="row_no<?php echo $data_retrive['paymethod_id'] ?>"
                                                               style="width: 30px;text-align: center;font-size: 11px;"
                                                               value="<?php echo $data_retrive['row_no'] ?>"> &nbsp;
                                                        <small>
                                                            <strong><?php echo $paymethod_icon . stripslashes($data_retrive['paymethod_title_' . $lang]); ?></strong>
                                                        </small>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                    <td style="text-align: center;"><a
                                                            href="?id=<?php echo $data_retrive['paymethod_id']; ?>&act=update"
                                                            class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                                            <i
                                                                class="fa fa-edit"></i></a></td>
                                                </tr>
                                                <?php
// ---- sub sections
                                                $sql_sub_retrive = mysql_query("SELECT * FROM " . $prefix .
                                                    "_shop_paymethods where father_id='$data_retrive[paymethod_id]' order by row_no, paymethod_id");
                                                while ($data_sub_retrive = mysql_fetch_array($sql_sub_retrive)) {
                                                    if ($data_sub_retrive['paymethod_status'] == 1) {
                                                        $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                    } else {
                                                        $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                    }
                                                    $paymethod_icon = "";
                                                    if ($data_sub_retrive['paymethod_icon'] != "") {
                                                        $paymethod_icon = "<div class='pull-right'><img src='$up_dir" . "$data_sub_retrive[paymethod_icon]' style='width:25px;height:20px;margin:5px'></div>";
                                                    }


                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <input type="checkbox" name="multichkbx[]"
                                                                   class="checkboxes" value="<?php echo
                                                            $data_sub_retrive['paymethod_id']; ?>"/>
                                                        </td>
                                                        <td style="color: gray;"><img
                                                                src="assets/img/treepart_<?php echo $site_lang_dir; ?>.png"
                                                                class="submenu_img"/><input type="text"
                                                                                            name="row_no<?php echo $data_sub_retrive['paymethod_id'] ?>"
                                                                                            style="width: 30px;text-align: center;font-size: 11px;"
                                                                                            value="<?php echo $data_sub_retrive['row_no'] ?>">
                                                            &nbsp;<?php echo stripslashes($data_sub_retrive['paymethod_title_' . $lang]); ?></small>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                        <td style="text-align: center;"><a
                                                                href="?id=<?php echo $data_sub_retrive['paymethod_id']; ?>&act=update"
                                                                class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                                                <i
                                                                    class="fa fa-edit"></i></a></td>
                                                    </tr>
                                                    <?php
                                                }

                                            }

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    if ($page_records_count > 0) {
                                        ?>
                                        <a href="javascript:;" class="btn btn-sm default"
                                           onclick="multicheckfrm.clicked_btn.value='b_saveorder';document.getElementById('multicheckfrm').submit();"><?php echo $lang_var_admin_92; ?></a>
                                        <?php
                                    }
                                    ?>
                                </form>
                            </div>
                            <?php
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
    <script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-markdown/lib/markdown.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>
    <script src="assets/scripts/custom/form-validation.js"></script>
    <script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/ui-alert-dialog-api.js"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
            UIAlertDialogApi.init();
            TableManaged.init();

        });
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