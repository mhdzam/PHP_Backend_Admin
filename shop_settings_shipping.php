<?php

require_once("template/page_start.php");
if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
//--------
    $id = @$_GET['id'];
    $clicked_btn = @$_POST['clicked_btn'];
//-------
    $shipping_title_en = mysql_real_escape_string(@$_POST['shipping_title_en']);
    $shipping_title_ar = mysql_real_escape_string(@$_POST['shipping_title_ar']);
    $cnt_id = mysql_real_escape_string(@$_POST['cnt_id']);
    $father_id = mysql_real_escape_string(@$_POST['father_id']);
    $shipping_icon = mysql_real_escape_string(@$_POST['shipping_icon']);
    $file_del = mysql_real_escape_string(@$_POST['file_del']);
    $shipping_cost = mysql_real_escape_string(@$_POST['shipping_cost']);

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
                        <h3 class="page-title"><?php echo $lang_var_admin_302; ?></h3>
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
                                <a href="#"><?php echo $lang_var_admin_302; ?></a>
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
                            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_shop_shipping");
                            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                $inm = "row_no" . "$data_delete_who[shipping_id]";
                                $row_no = @$_POST[$inm];
                                $sql_sveorder = mysql_query("UPDATE " . $prefix . "_shop_shipping SET row_no='$row_no' WHERE shipping_id='$data_delete_who[shipping_id]'") or die (mysql_error());
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
                                    "_shop_shipping SET shipping_status=1 WHERE shipping_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_shop_shipping SET shipping_status=0 WHERE shipping_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix .
                                    "_shop_shipping where shipping_id  in ($multichkbx)");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['shipping_icon'] != "") {
                                        @unlink("$up_dir" . "$data_delete_who[shipping_icon]");
                                    }
                                }
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_shop_shipping where shipping_id in ($multichkbx)");
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

                        if ($act == "insert" && $shipping_title_en != "") {

                            // --- upload
                            $shipping_icon = "";
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
                                            $shipping_icon = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $r = "select max(row_no)  from " . $prefix . "_shop_shipping where father_id='$father_id'";
                            $sqlr = mysql_query($r);
                            $rr = mysql_fetch_array($sqlr);
                            $row = $rr[0] + 1;

                            $sql_slct_max = mysql_query("select max(shipping_id)  from " . $prefix .
                                "_shop_shipping");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_shipping_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_shop_shipping (
  shipping_id,
  shipping_title_ar,
  shipping_title_en,
  cnt_id,
  father_id,
  shipping_icon,
  shipping_status,
  edit_by,  
  edit_date,
  edit_from,
  row_no,
  shipping_cost) VALUES ('$next_shipping_id','$shipping_title_ar','$shipping_title_en','$cnt_id','$father_id','$shipping_icon','1','$pd_admin_user_id',now(),'$pd_admin_ip','$row','$shipping_cost')");

                            if ($sql_insert_new) {
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
                        if ($act == "saveupdate" && $shipping_title_en != "" && $id != "") {

                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$shipping_icon");
                                $shipping_icon = "";
                            }
                            if ($file_name != "") {
                                if ($shipping_icon != "") {
                                    @unlink("$up_dir" . "$shipping_icon");
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
                                            $shipping_icon = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $sql_update = mysql_query("UPDATE " . $prefix . "_shop_shipping SET shipping_title_ar='$shipping_title_ar',shipping_title_en='$shipping_title_en',cnt_id='$cnt_id',father_id='$father_id',shipping_icon='$shipping_icon',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',shipping_cost='$shipping_cost' WHERE shipping_id='$id'") or
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

                        if ($act == "update") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                                "_shop_shipping  WHERE shipping_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $shipping_title_ar = stripcslashes($data_modify['shipping_title_ar']);
                            $shipping_title_en = stripcslashes($data_modify['shipping_title_en']);
                            $cnt_id = stripcslashes($data_modify['cnt_id']);
                            $father_id = stripcslashes($data_modify['father_id']);
                            $shipping_icon = stripcslashes($data_modify['shipping_icon']);
                            $shipping_cost = stripcslashes($data_modify['shipping_cost']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_306; ?>
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

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_90; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <select class="form-control" name="cnt_id" class="select2me">
                                                        <option value=""><?php echo $lang_var_admin_91; ?>...
                                                        </option>
                                                        <?php
                                                        $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_countries  order by country_$lang");
                                                        while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                            if ($lang == "ar") {
                                                                $section_title = $data_father_retrive['country_ar'];
                                                            } else {
                                                                $section_title = $data_father_retrive['country_en'];
                                                            }


                                                            ?>
                                                            <option
                                                                value="<?php echo $data_father_retrive['cnt_id']; ?>" <?php if ($cnt_id == $data_father_retrive['cnt_id']) {
                                                                echo "selected='selected'";
                                                            } ?> ><?php echo $section_title; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php
                                            $ws_shop_shipping_st = 1;
                                            if ($ws_shop_shipping_st == 2) {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_90; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <select class="form-control" name="father_id" class="select2me">
                                                            <option value=""><?php echo $lang_var_admin_91; ?>...
                                                            </option>
                                                            <?php
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_shipping where father_id='0' and shipping_id !='$id' order by row_no, shipping_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                if ($lang == "ar") {
                                                                    $section_title = $data_father_retrive['shipping_title_ar'];
                                                                } else {
                                                                    $section_title = $data_father_retrive['shipping_title_en'];
                                                                }


                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['shipping_id']; ?>" <?php if ($father_id == $data_father_retrive['shipping_id']) {
                                                                    echo "selected='selected'";
                                                                } ?> ><?php echo $section_title; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_304; ?>  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="shipping_title_ar" required=""
                                                           value="<?php echo $shipping_title_ar; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_304; ?>  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="shipping_title_en" required=""
                                                           value="<?php echo $shipping_title_en; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_313; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="shipping_cost" required=""
                                                           value="<?php echo $shipping_cost; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_46; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="file" name="myfile" class="form-control"/>
                                                    <input type="hidden" name="shipping_icon" id="file_hidden_var"
                                                           value="<?php echo $shipping_icon; ?>"/>
                                                    <input type="hidden" name="file_del" id="file_del_var" value="0"/>
                                                    <?php
                                                    if ($shipping_icon != "") {
                                                        ?>
                                                        <div id="file_show_div">
                                                            <div><img src="<?php echo "$up_dir" . "$shipping_icon"; ?>"
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
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_305; ?>
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

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_90; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <select class="form-control" name="cnt_id" class="select2me">
                                                        <option value=""><?php echo $lang_var_admin_91; ?>...
                                                        </option>
                                                        <?php
                                                        $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_countries  order by country_$lang");
                                                        while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                            if ($lang == "ar") {
                                                                $section_title = $data_father_retrive['country_ar'];
                                                            } else {
                                                                $section_title = $data_father_retrive['country_en'];
                                                            }

                                                            ?>
                                                            <option
                                                                value="<?php echo $data_father_retrive['cnt_id']; ?>" ><?php echo $section_title; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php
                                            $ws_shop_shipping_st = 1;
                                            if ($ws_shop_shipping_st == 2) {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_90; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <select class="form-control" name="father_id" class="select2me">
                                                            <option value=""><?php echo $lang_var_admin_91; ?>...
                                                            </option>
                                                            <?php
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_shipping where father_id='0' order by row_no, shipping_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                if ($lang == "ar") {
                                                                    $section_title = $data_father_retrive['shipping_title_ar'];
                                                                } else {
                                                                    $section_title = $data_father_retrive['shipping_title_en'];
                                                                }
                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['shipping_id']; ?>"><?php echo $section_title; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_304; ?> <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="shipping_title_ar" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_304; ?> <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="shipping_title_en" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_313; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="shipping_cost" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_46; ?> </label>

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
									<?php echo $lang_var_admin_305; ?> <i class="fa fa-plus"></i>
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
                                            <th><?php echo $lang_var_admin_304; ?></th>
                                            <th style="width: 22%;text-align: center;"><?php echo $lang_var_admin_217; ?></th>
                                            <th style="width: 12%;text-align: center;"><?php echo $lang_var_admin_313; ?></th>
                                            <th style="width: 5%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                            "_shop_shipping where father_id=0 order by row_no, shipping_id");
                                        $page_records_count = mysql_num_rows($sql_retrive);
                                        if ($page_records_count == 0) {
                                            ?>
                                            <tr class="odd gradeX">
                                                <td colspan="7" style="text-align: center;">
                                                    <small><?php echo $lang_var_admin_93; ?></small>
                                                </td>

                                            </tr>
                                            <?php
                                        } else {

                                            while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                                if ($data_retrive['shipping_status'] == 1) {
                                                    $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                } else {
                                                    $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                }
                                                $shipping_icon = "";
                                                if ($data_retrive['shipping_icon'] != "") {
                                                    $shipping_icon = "<div class='pull-left'><img src='$up_dir" . "$data_retrive[shipping_icon]' style='width:25px;height:15px;margin:5px'></div>";
                                                }

                                                $sql_section = mysql_query("SELECT * FROM " . $prefix . "_countries where cnt_id ='$data_retrive[cnt_id]'");
                                                $data_section = mysql_fetch_array($sql_section);
                                                $country = stripcslashes($data_section['country_' . $lang]);

                                                ?>
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                               value="<?php echo
                                                               $data_retrive['shipping_id']; ?>"/>
                                                    </td>
                                                    <td><input type="text"
                                                               name="row_no<?php echo $data_retrive['shipping_id'] ?>"
                                                               style="width: 30px;text-align: center;font-size: 11px;"
                                                               value="<?php echo $data_retrive['row_no'] ?>"> &nbsp;
                                                        <small>
                                                            <strong><?php echo $shipping_icon . stripslashes($data_retrive['shipping_title_' . $lang]); ?></strong>
                                                        </small>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo $country; ?></td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo stripslashes($data_retrive['shipping_cost']); ?></small>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                    <td style="text-align: center;"><a
                                                            href="?id=<?php echo $data_retrive['shipping_id']; ?>&act=update"
                                                            class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                                            <i
                                                                class="fa fa-edit"></i></a></td>
                                                </tr>
                                                <?php
// ---- sub sections
                                                $sql_sub_retrive = mysql_query("SELECT * FROM " . $prefix .
                                                    "_shop_shipping where father_id='$data_retrive[shipping_id]' order by cnt_id, row_no, shipping_id");
                                                while ($data_sub_retrive = mysql_fetch_array($sql_sub_retrive)) {
                                                    if ($data_sub_retrive['shipping_status'] == 1) {
                                                        $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                    } else {
                                                        $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                    }
                                                    $shipping_icon = "";
                                                    if ($data_sub_retrive['shipping_icon'] != "") {
                                                        $shipping_icon = "<div class='pull-right'><img src='$up_dir" . "$data_sub_retrive[shipping_icon]' style='width:25px;height:20px;margin:5px'></div>";
                                                    }

                                                    $sql_section = mysql_query("SELECT * FROM " . $prefix . "_countries where cnt_id ='$data_sub_retrive[cnt_id]'");
                                                    $data_section = mysql_fetch_array($sql_section);
                                                    $country = stripcslashes($data_section['country_' . $lang]);

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <input type="checkbox" name="multichkbx[]"
                                                                   class="checkboxes" value="<?php echo
                                                            $data_sub_retrive['shipping_id']; ?>"/>
                                                        </td>
                                                        <td style="color: gray;"><img
                                                                src="assets/img/treepart_<?php echo $site_lang_dir; ?>.png"
                                                                class="submenu_img"/><input type="text"
                                                                                            name="row_no<?php echo $data_sub_retrive['shipping_id'] ?>"
                                                                                            style="width: 30px;text-align: center;font-size: 11px;"
                                                                                            value="<?php echo $data_sub_retrive['row_no'] ?>">
                                                            &nbsp;<?php echo stripslashes($data_sub_retrive['shipping_title_' . $lang]); ?></small>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo $country; ?></td>
                                                        <td style="text-align: center;">
                                                            <small><?php echo stripslashes($data_sub_retrive['shipping_cost']); ?></small>
                                                        </td>

                                                        <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                        <td style="text-align: center;"><a
                                                                href="?id=<?php echo $data_sub_retrive['shipping_id']; ?>&act=update"
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