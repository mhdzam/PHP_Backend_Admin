<?php


require_once("template/page_start.php");
if ($logged_admin_control_type == 0 || $logged_admin_control_type == 1) {
//--------
    $id = @$_GET['id'];
    $clicked_btn = @$_POST['clicked_btn'];
//-------
    $coupon_title_en = mysql_real_escape_string(@$_POST['coupon_title_en']);
    $coupon_title_ar = mysql_real_escape_string(@$_POST['coupon_title_ar']);
    $father_id = mysql_real_escape_string(@$_POST['father_id']);
    $file_del = mysql_real_escape_string(@$_POST['file_del']);
    $coupon_percent = mysql_real_escape_string(@$_POST['coupon_percent']);

    $coupon_code = mysql_real_escape_string(@$_POST['coupon_code']);
    $coupon_date_from = mysql_real_escape_string(@$_POST['coupon_date_from']);
    $coupon_date_to = mysql_real_escape_string(@$_POST['coupon_date_to']);

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
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
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
                        <h3 class="page-title"><?php echo $lang_var_admin_337; ?></h3>
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
                                <a href="#"><?php echo $lang_var_admin_337; ?></a>
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

                        if ($multichkbx != "") {
                            while (list($key, $val) = @each($multichkbx)) {
                                $all_multichkbx .= "$val,";
                            }
                            $multichkbx = substr($all_multichkbx, 0, -1);
                            //-------------
                            $actin_done = 0;
                            if ($clicked_btn == "b_active") {
                                $sql_active = mysql_query("UPDATE " . $prefix .
                                    "_shop_coupons SET coupon_status=1 WHERE coupon_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_shop_coupons SET coupon_status=0 WHERE coupon_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_shop_coupons where coupon_id in ($multichkbx)");
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

                        if ($act == "insert" && $coupon_title_en != "") {

                            $sql_slct_max = mysql_query("select max(coupon_id)  from " . $prefix .
                                "_shop_coupons");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_coupon_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_shop_coupons (
  coupon_id,
  coupon_title_ar,
  coupon_title_en,
  coupon_status,
  edit_by,  
  edit_date,
  edit_from,
  coupon_percent,
  coupon_code,
  coupon_date_from,
  coupon_date_to) VALUES ('$next_coupon_id','$coupon_title_ar','$coupon_title_en','1','$pd_admin_user_id',now(),'$pd_admin_ip','$coupon_percent','$coupon_code','$coupon_date_from','$coupon_date_to')");

                            if ($sql_insert_new) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_407 . " ($coupon_percent%) " . $coupon_title_ar);
                                $note_title_en = ($lang_var_admin_408 . " ($coupon_percent%) " . $coupon_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-warning'>
                            <i class='fa fa-bell-o'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_settings_coupons.php?id=$next_coupon_id&act=update");

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
                        if ($act == "saveupdate" && $coupon_title_en != "" && $id != "") {


                            $sql_update = mysql_query("UPDATE " . $prefix . "_shop_coupons SET coupon_code='$coupon_code',coupon_date_from='$coupon_date_from',coupon_date_to='$coupon_date_to',coupon_title_ar='$coupon_title_ar',coupon_title_en='$coupon_title_en',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',coupon_percent='$coupon_percent' WHERE coupon_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {
                                // insert notification
                                $note_title_ar = ($lang_var_admin_387 . " " . $coupon_title_ar . "  ($coupon_percent%) ");
                                $note_title_en = ($lang_var_admin_388 . " " . $coupon_title_en . "  ($coupon_percent%) ");
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-warning'>
                            <i class='fa fa-pencil-square-o'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("shop_settings_coupons.php?id=$id&act=update");

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
                                "_shop_coupons  WHERE coupon_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $coupon_title_ar = stripcslashes($data_modify['coupon_title_ar']);
                            $coupon_title_en = stripcslashes($data_modify['coupon_title_en']);
                            $coupon_percent = stripcslashes($data_modify['coupon_percent']);
                            $coupon_code = stripcslashes($data_modify['coupon_code']);
                            $coupon_date_from = stripcslashes($data_modify['coupon_date_from']);
                            $coupon_date_to = stripcslashes($data_modify['coupon_date_to']);

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-edit"></i> <?php echo $lang_var_admin_344; ?>
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
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_338; ?>  <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_title_ar" required=""
                                                           value="<?php echo $coupon_title_ar; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_338; ?>  <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_title_en" required=""
                                                           value="<?php echo $coupon_title_en; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_339; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_percent" required=""
                                                           value="<?php echo $coupon_percent; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_340; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_code" readonly required=""
                                                           value="<?php echo $coupon_code; ?>" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_341; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="input-group date date-picker"
                                                         data-date-format="yyyy-mm-dd">
                                                        <input type="text" class="form-control"
                                                               value="<?php echo $coupon_date_from; ?>"
                                                               name="coupon_date_from" readonly>
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_342; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="input-group date date-picker"
                                                         data-date-format="yyyy-mm-dd">
                                                        <input type="text" class="form-control"
                                                               value="<?php echo $coupon_date_to; ?>"
                                                               name="coupon_date_to" readonly>
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                                                    </div>
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
                            $d = "select max(coupon_id)  from " . $prefix . "_shop_coupons";
                            $sqlb = mysql_query($d);
                            $re = mysql_fetch_array($sqlb);
                            $co_id = $re[0] + 1;
                            $co_code = "pd" . rand(000, 999) . $co_id;
                            ?>

                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_343; ?>
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
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_338; ?> <?php echo $ar_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_title_ar" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="control-label col-md-3"><?php echo $lang_var_admin_338; ?> <?php echo $en_lang_icon; ?>
                                                    <span class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_title_en" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_339; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_percent" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_340; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="coupon_code" 
                                                           value="<?php echo $co_code; ?>" required=""
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_341; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="input-group date date-picker"
                                                         data-date-format="yyyy-mm-dd">
                                                        <input type="text" class="form-control"
                                                               value="<?php echo $pd_current_date; ?>"
                                                               name="coupon_date_from" readonly>
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_342; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="input-group date date-picker"
                                                         data-date-format="yyyy-mm-dd">
                                                        <input type="text" class="form-control"
                                                               value="<?php echo $pd_current_date; ?>"
                                                               name="coupon_date_to" readonly>
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                                                    </div>
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
									<?php echo $lang_var_admin_343; ?> <i class="fa fa-plus"></i>
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
                                            <th><?php echo $lang_var_admin_338; ?></th>
                                            <th style="width: 20%;text-align: center;"><?php echo $lang_var_admin_341; ?>
                                                : <?php echo $lang_var_admin_342; ?></th>
                                            <th style="width: 12%;text-align: center;"><?php echo $lang_var_admin_339; ?></th>
                                            <th style="width: 15%;text-align: center;"><?php echo $lang_var_admin_340; ?></th>
                                            <th style="width: 5%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                            "_shop_coupons order by coupon_id");
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
                                                if ($data_retrive['coupon_status'] == 1) {
                                                    $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                                } else {
                                                    $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                                }


                                                ?>
                                                <tr class="odd gradeX">
                                                    <td>
                                                        <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                               value="<?php echo
                                                               $data_retrive['coupon_id']; ?>"/>
                                                    </td>
                                                    <td>
                                                        <small>
                                                            <strong><?php echo stripslashes($data_retrive['coupon_title_' . $lang]); ?></strong>
                                                        </small>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo $data_retrive['coupon_date_from']; ?>
                                                            : <?php echo $data_retrive['coupon_date_to']; ?></small>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo stripslashes($data_retrive['coupon_percent']); ?>
                                                            %
                                                        </small>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <small><?php echo stripslashes($data_retrive['coupon_code']); ?></small>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                    <td style="text-align: center;"><a
                                                            href="?id=<?php echo $data_retrive['coupon_id']; ?>&act=update"
                                                            class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?>
                                                            <i
                                                                class="fa fa-edit"></i></a></td>
                                                </tr>
                                                <?php

                                            }

                                        }
                                        ?>
                                        </tbody>
                                    </table>

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
    <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>
    <script src="assets/scripts/custom/form-validation.js"></script>
    <script src="assets/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/ui-alert-dialog-api.js"></script>
    <script>
        //init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
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