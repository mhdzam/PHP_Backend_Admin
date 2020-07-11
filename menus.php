<?php

require_once("template/page_start.php");
//--------
$id = @$_GET['id'];
$clicked_btn = @$_POST['clicked_btn'];
//-------
$menu_title_en = mysql_real_escape_string(@$_POST['menu_title_en']);
$menu_title_ar = mysql_real_escape_string(@$_POST['menu_title_ar']);
$father_id = mysql_real_escape_string(@$_POST['father_id']);
$menu_icon = mysql_real_escape_string(@$_POST['menu_icon']);
$file_del = mysql_real_escape_string(@$_POST['file_del']);

$menu_type = mysql_real_escape_string(@$_POST['menu_type']);
$menu_cat = mysql_real_escape_string(@$_POST['menu_cat']);
$menu_url = mysql_real_escape_string(@$_POST['menu_url']);

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
                        <h3 class="page-title"><?php echo $lang_var_admin_434; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_58; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_434; ?></a>
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
                            $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_menus");
                            while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                $inm = "row_no" . "$data_delete_who[menu_id]";
                                $row_no = @$_POST[$inm];
                                $sql_sveorder = mysql_query("UPDATE " . $prefix . "_menus SET row_no='$row_no' WHERE menu_id='$data_delete_who[menu_id]'") or die (mysql_error());
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
                                    "_menus SET menu_status=1 WHERE menu_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_menus SET menu_status=0 WHERE menu_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_factive") {
                                $sql_active = mysql_query("UPDATE " . $prefix .
                                    "_menus SET onfooter_status=1 WHERE menu_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_fblock") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_menus SET onfooter_status=0 WHERE menu_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete_who = mysql_query("SELECT * FROM " . $prefix .
                                    "_menus where menu_id  in ($multichkbx)");
                                while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
                                    if ($data_delete_who['menu_icon'] != "") {
                                        @unlink("$up_dir" . "$data_delete_who[menu_icon]");
                                    }
                                }
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_menus where menu_id in ($multichkbx)");
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

                        if ($act == "insert" && $menu_title_en != "") {

                            // --- upload
                            $menu_icon = "";
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
                                            $menu_icon = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $r = "select max(row_no)  from " . $prefix . "_menus where father_id='$father_id'";
                            $sqlr = mysql_query($r);
                            $rr = mysql_fetch_array($sqlr);
                            $row = $rr[0] + 1;

                            $sql_slct_max = mysql_query("select max(menu_id)  from " . $prefix .
                                "_menus");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_menu_id = $data_slct_max[0] + 1;
							if($father_id==""){$father_id = 0;}
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_menus (
  menu_id,
  menu_title_ar,
  menu_title_en,
  father_id,
  menu_type,
  menu_cat,
  menu_url,
  menu_icon,
  menu_status,
  edit_by,  
  edit_date,
  edit_from,
  row_no) VALUES ('$next_menu_id','$menu_title_ar','$menu_title_en','$father_id','$menu_type','$menu_cat','$menu_url','$menu_icon','1','$pd_admin_user_id',now(),'$pd_admin_ip','$row')");

                            if ($sql_insert_new) {


                                // insert notification
                                $note_title_ar = ($lang_var_admin_384 . " " . $menu_title_ar);
                                $note_title_en = ($lang_var_admin_383 . " " . $menu_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-success'>
                            <i class='fa fa-sitemap'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_sections.php?id=$next_menu_id&act=update");

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
                        if ($act == "saveupdate" && $menu_title_en != "" && $id != "") {

                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$menu_icon");
                                $menu_icon = "";
                            }
                            if ($file_name != "") {
                                if ($menu_icon != "") {
                                    @unlink("$up_dir" . "$menu_icon");
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
                                            $menu_icon = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $sql_update = mysql_query("UPDATE " . $prefix . "_menus SET menu_title_ar='$menu_title_ar',menu_title_en='$menu_title_en',father_id='$father_id',menu_type='$menu_type',menu_cat='$menu_cat',menu_url='$menu_url',menu_icon='$menu_icon',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip' WHERE menu_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {


                                // insert notification
                                $note_title_ar = ($lang_var_admin_385 . " " . $menu_title_ar);
                                $note_title_en = ($lang_var_admin_386 . " " . $menu_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-info'>
                            <i class='fa fa-pencil'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_sections.php?id=$id&act=update");

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
                                "_menus  WHERE menu_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $menu_title_ar = stripcslashes($data_modify['menu_title_ar']);
                            $menu_title_en = stripcslashes($data_modify['menu_title_en']);
                            $father_id = stripcslashes($data_modify['father_id']);

                            $menu_type = stripcslashes($data_modify['menu_type']);
                            $menu_cat = stripcslashes($data_modify['menu_cat']);
                            $menu_url = stripcslashes($data_modify['menu_url']);

                            $menu_icon = stripcslashes($data_modify['menu_icon']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_152; ?>
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
                                            $ws_shop_sections_st = 2;
                                            if ($ws_shop_sections_st == 2) {
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
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_menus where father_id='0' and menu_id !='$id' and menu_type='0' order by row_no, menu_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                if ($lang == "ar") {
                                                                    $menu_title = $data_father_retrive['menu_title_ar'];
                                                                } else {
                                                                    $menu_title = $data_father_retrive['menu_title_en'];
                                                                }


                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['menu_id']; ?>" <?php if ($father_id == $data_father_retrive['menu_id']) {
                                                                    echo "selected='selected'";
                                                                } ?> ><?php echo $menu_title; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_192; ?>  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="menu_title_ar" required=""
                                                           value="<?php echo $menu_title_ar; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_192; ?>  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="menu_title_en" required=""
                                                           value="<?php echo $menu_title_en; ?>" class="form-control"/>
                                                </div>
                                            </div>

                                            <?php
                                            $dis1 = "none";
                                            $dis2 = "none";
                                            ?>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_327; ?> </label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input
                                                                onclick="document.getElementById('fld_1').style.display='none';document.getElementById('fld_2').style.display='none'"
                                                                type="radio" name="menu_type"
                                                                value="0" <?php if ($menu_type == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_436; ?> </label>
                                                        <label><input
                                                                onclick="document.getElementById('fld_1').style.display='block';document.getElementById('fld_2').style.display='none';"
                                                                type="radio" name="menu_type"
                                                                value="1" <?php if ($menu_type == 1) {
                                                                echo "checked";
                                                                $dis1 = "block";
                                                            } ?>/><?php echo $lang_var_admin_435; ?> </label>
                                                        <label><input
                                                                onclick="document.getElementById('fld_2').style.display='block';document.getElementById('fld_1').style.display='none';"
                                                                type="radio" name="menu_type"
                                                                value="2" <?php if ($menu_type == 2) {
                                                                echo "checked";
                                                                $dis2 = "block";
                                                            } ?>/><?php echo $lang_var_admin_437; ?> </label>
                                                        <label><input
                                                                onclick="document.getElementById('fld_2').style.display='block';document.getElementById('fld_1').style.display='none';"
                                                                type="radio" name="menu_type"
                                                                value="3" <?php if ($menu_type == 3) {
                                                                echo "checked";
                                                                $dis2 = "block";
                                                            } ?>/><?php echo $lang_var_admin_438; ?> </label>

                                                    </div>
                                                </div>
                                            </div>

                                            <div id="fld_1" style="display: <?php echo $dis1; ?>">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_435; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="menu_url" dir="ltr"
                                                               value="<?php echo $menu_url; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="fld_2" style="display: <?php echo $dis2; ?>">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_439; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <select class="form-control" name="menu_cat"
                                                                class="select2me">
                                                            <option
                                                                value=""><?php echo $lang_var_admin_100; ?></option>
                                                            <?php
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections where ws_status=1 order by ws_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['ws_id']; ?>" <?php if ($menu_cat == $data_father_retrive['ws_id']) {
                                                                    echo "selected='selected'";
                                                                } ?> ><?php echo $$data_father_retrive['ws_title_var']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_46; ?> </label>

                                                <div class="col-md-4">
                                                    <input type="file" name="myfile" class="form-control"/>
                                                    <input type="hidden" name="menu_icon" id="file_hidden_var"
                                                           value="<?php echo $menu_icon; ?>"/>
                                                    <input type="hidden" name="file_del" id="file_del_var"
                                                           value="0"/>
                                                    <?php
                                                    if ($menu_icon != "") {
                                                        ?>
                                                        <div id="file_show_div">
                                                            <div><img src="<?php echo "$up_dir" . "$menu_icon"; ?>"
                                                                      style="max-width: 100%;margin: 5px 0;"/></div>
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
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_440; ?>
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
                                            $ws_shop_sections_st = 2;
                                            if ($ws_shop_sections_st == 2) {
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
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_menus where father_id='0' and menu_type='0'  order by row_no, menu_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                if ($lang == "ar") {
                                                                    $menu_title = $data_father_retrive['menu_title_ar'];
                                                                } else {
                                                                    $menu_title = $data_father_retrive['menu_title_en'];
                                                                }
                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['menu_id']; ?>"><?php echo $menu_title; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_192; ?> <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="menu_title_ar" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_192; ?> <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="menu_title_en" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_327; ?> </label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input
                                                                onclick="document.getElementById('fld_1').style.display='none';document.getElementById('fld_2').style.display='none'"
                                                                type="radio" name="menu_type"
                                                                value="0" <?php if ($menu_type == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_436; ?> </label>
                                                        <label><input
                                                                onclick="document.getElementById('fld_1').style.display='block';document.getElementById('fld_2').style.display='none';"
                                                                type="radio" name="menu_type"
                                                                value="1" <?php if ($menu_type == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_435; ?> </label>
                                                        <label><input
                                                                onclick="document.getElementById('fld_2').style.display='block';document.getElementById('fld_1').style.display='none';"
                                                                type="radio" name="menu_type"
                                                                value="2" <?php if ($menu_type == 2) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_437; ?> </label>
                                                        <label><input
                                                                onclick="document.getElementById('fld_2').style.display='block';document.getElementById('fld_1').style.display='none';"
                                                                type="radio" name="menu_type"
                                                                value="3" <?php if ($menu_type == 3) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_438; ?> </label>

                                                    </div>
                                                </div>
                                            </div>

                                            <div id="fld_1" style="display: none">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_435; ?>
                                                        <span class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <input type="text" name="menu_url" dir="ltr"
                                                               value="<?php echo $menu_url; ?>"
                                                               class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="fld_2" style="display: none">
                                                <div class="form-group">
                                                    <label
                                                        class="control-label col-md-3"><?php echo $lang_var_admin_439; ?>
                                                        <span
                                                            class="required">*</span></label>

                                                    <div class="col-md-4">
                                                        <select class="form-control" name="menu_cat"
                                                                class="select2me">
                                                            <option
                                                                value=""><?php echo $lang_var_admin_100; ?></option>
                                                            <?php
                                                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections where ws_status=1 order by ws_id");
                                                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $data_father_retrive['ws_id']; ?>" <?php if ($menu_cat == $data_father_retrive['ws_id']) {
                                                                    echo "selected='selected'";
                                                                } ?> ><?php echo $$data_father_retrive['ws_title_var']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
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
                                        <?php
                                        if ($logged_allow_add_status == 1) {
                                            ?>
                                            <div class="btn-group">
                                                <a href="?act=new"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_440; ?> <i class="fa fa-plus"></i>
									</span></a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($logged_allow_edit_status == 1) {
                                            ?>
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

                                                    <li><a href="javascript:;"
                                                           onclick="multicheckfrm.clicked_btn.value='b_factive';document.getElementById('multicheckfrm').submit();"><i
                                                                class="fa fa-check"></i> <?php echo $lang_var_admin_494; ?>
                                                        </a></li>
                                                    <li><a href="javascript:;"
                                                           onclick="multicheckfrm.clicked_btn.value='b_fblock';document.getElementById('multicheckfrm').submit();"><i
                                                                class="fa fa-times"></i> <?php echo $lang_var_admin_495; ?>
                                                        </a></li>

                                                    <?php
                                                    if ($logged_allow_delete_status == 1) {
                                                        ?>
                                                        <li><a href="javascript:;" id="confirmation_box_for_delete"
                                                               onclick="multicheckfrm.clicked_btn.value='b_delete';"><i
                                                                    class="fa fa-trash-o"></i> <?php echo $lang_var_admin_32; ?>
                                                            </a></li>
                                                        <?php
                                                    }
                                                    ?>
                                                    <input type="hidden" name="clicked_btn" size="78" value=""/>
                                                </ul>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th class="table-checkbox" style="width: 3%;">
                                                <input type="checkbox" class="checkall"/>
                                            </th>
                                            <th><?php echo $lang_var_admin_88; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_494; ?></th>
                                            <?php
                                            if ($logged_allow_edit_status == 1) {
                                                ?>
                                                <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                            "_menus where father_id=0 order by row_no, menu_id");
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
                                                if ($data_retrive['menu_status'] == 1) {
                                                    $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                } else {
                                                    $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                }
                                                if ($data_retrive['onfooter_status'] == 1) {
                                                    $footer_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                } else {
                                                    $footer_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                }
                                                $menu_icon = "";
                                                if ($data_retrive['menu_icon'] != "") {
                                                    $menu_icon = "<div class='pull-left'><img src='$up_dir" . "$data_retrive[menu_icon]' style='width:25px;height:15px;margin:5px'></div>";
                                                }

                                                $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_topics where  ( cat_id='$data_retrive[menu_id]' OR cat_id in (SELECT menu_id FROM " . $prefix . "_menus where father_id='$data_retrive[menu_id]') )");
                                                $records_topics_count = mysql_num_rows($sql_topics_count);

                                                ?>
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                               value="<?php echo
                                                               $data_retrive['menu_id']; ?>"/>
                                                    </td>
                                                    <td><input type="text"
                                                               name="row_no<?php echo $data_retrive['menu_id'] ?>"
                                                               style="width: 30px;text-align: center;font-size: 11px;"
                                                               value="<?php echo $data_retrive['row_no'] ?>"> &nbsp;
                                                        <small>
                                                            <strong><?php echo $menu_icon . stripslashes($data_retrive['menu_title_' . $lang]); ?></strong>
                                                        </small>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                    <td style="text-align: center;"><?php echo $footer_icn; ?></td>
                                                    <?php
                                                    if ($logged_allow_edit_status == 1) {
                                                        ?>
                                                        <td style="text-align: center;"><a
                                                                href="?id=<?php echo $data_retrive['menu_id']; ?>&act=update"
                                                                class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                                                <i
                                                                    class="fa fa-edit"></i></a></td>
                                                        <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
// ---- sub sections
                                                $sql_sub_retrive = mysql_query("SELECT * FROM " . $prefix .
                                                    "_menus where father_id='$data_retrive[menu_id]' order by row_no, menu_id");
                                                while ($data_sub_retrive = mysql_fetch_array($sql_sub_retrive)) {
                                                    if ($data_sub_retrive['menu_status'] == 1) {
                                                        $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                    } else {
                                                        $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                    }
                                                    if ($data_sub_retrive['onfooter_status'] == 1) {
                                                        $footer_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                    } else {
                                                        $footer_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                    }
                                                    $menu_icon = "";
                                                    if ($data_sub_retrive['menu_icon'] != "") {
                                                        $menu_icon = "<div class='pull-right'><img src='$up_dir" . "$data_sub_retrive[menu_icon]' style='width:25px;height:20px;margin:5px'></div>";
                                                    }


                                                    $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_topics where ( cat_id='$data_sub_retrive[menu_id]' OR cat_id in (SELECT menu_id FROM " . $prefix . "_menus where father_id='$data_sub_retrive[menu_id]') )");
                                                    $records_topics_count = mysql_num_rows($sql_topics_count);

                                                    ?>
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <input type="checkbox" name="multichkbx[]"
                                                                   class="checkboxes" value="<?php echo
                                                            $data_sub_retrive['menu_id']; ?>"/>
                                                        </td>
                                                        <td style="color: gray;"><img
                                                                src="assets/img/treepart_<?php echo $site_lang_dir; ?>.png"
                                                                class="submenu_img"/><input type="text"
                                                                                            name="row_no<?php echo $data_sub_retrive['menu_id'] ?>"
                                                                                            style="width: 30px;text-align: center;font-size: 11px;"
                                                                                            value="<?php echo $data_sub_retrive['row_no'] ?>">
                                                            &nbsp;<?php echo stripslashes($data_sub_retrive['menu_title_' . $lang]); ?></small>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                        <td style="text-align: center;"><?php echo $footer_icn; ?></td>
                                                        <?php
                                                        if ($logged_allow_edit_status == 1) {
                                                            ?>
                                                            <td style="text-align: center;"><a
                                                                    href="?id=<?php echo $data_sub_retrive['menu_id']; ?>&act=update"
                                                                    class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                                                    <i
                                                                        class="fa fa-edit"></i></a></td>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                    <?php
                                                }

                                            }

                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    if ($logged_allow_edit_status == 1) {
                                        ?>
                                        <?php
                                        if ($page_records_count > 0) {
                                            ?>
                                            <a href="javascript:;" class="btn btn-sm default"
                                               onclick="multicheckfrm.clicked_btn.value='b_saveorder';document.getElementById('multicheckfrm').submit();"><?php echo $lang_var_admin_92; ?></a>
                                            <?php
                                        }
                                        ?>
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
require_once("template/page_end.php");
?>