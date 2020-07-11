<?php
require_once("template/page_start.php");
if ($logged_full_control_status == 1) {
//--------
    $id = @$_GET['id'];
    $clicked_btn = @$_POST['clicked_btn'];
//-------
    $bs_name_var = mysql_real_escape_string(@$_POST['bs_name_var']);
    $bs_type = mysql_real_escape_string(@$_POST['bs_type']);
    $bs_height = mysql_real_escape_string(@$_POST['bs_height']);
    $bs_width = mysql_real_escape_string(@$_POST['bs_width']);

    $bs_period = mysql_real_escape_string(@$_POST['bs_period']);
    $bs_desc_status = mysql_real_escape_string(@$_POST['bs_desc_status']);
    $bs_link_status = mysql_real_escape_string(@$_POST['bs_link_status']);
    $ws_attachfile_status = mysql_real_escape_string(@$_POST['ws_attachfile_status']);


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
                        <h3 class="page-title"><?php echo $lang_var_admin_143; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_37; ?></a>
                                <i class="fa fa-angle-<?php echo $site_lang_align_right; ?>"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_143; ?></a>
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
                                    "_banars_sections SET bs_status=1 WHERE bs_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_active) {
                                    $actin_done = 1;
                                }


                            } elseif ($clicked_btn == "b_block") {

                                $sql_block = mysql_query("UPDATE " . $prefix .
                                    "_banars_sections SET bs_status=0 WHERE bs_id in ($multichkbx)") or die(mysql_error
                                ());
                                if ($sql_block) {
                                    $actin_done = 1;
                                }

                            } elseif ($clicked_btn == "b_delete") {
                                $sql_delete = mysql_query("DELETE FROM  " . $prefix .
                                    "_banars_sections where bs_id in ($multichkbx)");
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

                        if ($act == "insert" && $bs_name_var != "") {


                            $sql_slct_max = mysql_query("select max(bs_id)  from " . $prefix .
                                "_banars_sections");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_bs_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_banars_sections (
  bs_id,
  bs_type,
  bs_name_var,
  bs_height,
  bs_width,
  bs_status,
  edit_by,  
  edit_date,
  edit_from,
  bs_period,
  bs_desc_status,
  bs_link_status) VALUES ('$next_bs_id','$bs_type','$bs_name_var','$bs_height','$bs_width','1','$pd_admin_user_id',now(),'$pd_admin_ip','$bs_period','$bs_desc_status','$bs_link_status')");

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
                        if ($act == "saveupdate" && $bs_name_var != "" && $id != "") {

                            $sql_update = mysql_query("UPDATE " . $prefix . "_banars_sections SET bs_type='$bs_type',bs_name_var='$bs_name_var',bs_height='$bs_height',bs_width='$bs_width',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',bs_period='$bs_period',bs_desc_status='$bs_desc_status',bs_link_status='$bs_link_status' WHERE bs_id='$id'") or
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
                                "_banars_sections  WHERE bs_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);
                            $bs_type = stripcslashes($data_modify['bs_type']);
                            $bs_name_var = stripcslashes($data_modify['bs_name_var']);
                            $bs_height = stripcslashes($data_modify['bs_height']);
                            $bs_width = stripcslashes($data_modify['bs_width']);


                            $bs_period = stripcslashes($data_modify['bs_period']);
                            $bs_desc_status = stripcslashes($data_modify['bs_desc_status']);
                            $bs_link_status = stripcslashes($data_modify['bs_link_status']);

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
                                    <form action="?id=<?php echo $id; ?>&act=saveupdate" id="form_site_sections_new"
                                          method="post"
                                          class="form-horizontal" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_62; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="bs_name_var"
                                                           value="<?php echo $bs_name_var; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_63; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list" data-error-container="#bs_type_error">
                                                        <label><input type="radio" name="bs_type"
                                                                      value="0" <?php if ($bs_type == 0) {
                                                                echo "checked";
                                                            } ?>/><span
                                                                class="label label-sm label-default">&nbsp; <?php echo $lang_var_admin_148; ?>
                                                                &nbsp;  </span> </label>
                                                        <label><input type="radio" name="bs_type"
                                                                      value="1" <?php if ($bs_type == 1) {
                                                                echo "checked";
                                                            } ?>/><span
                                                                class="label label-sm label-info">&nbsp; <?php echo $lang_var_admin_146; ?>
                                                                &nbsp; </span> </label>
                                                        <label><input type="radio" name="bs_type"
                                                                      value="2" <?php if ($bs_type == 2) {
                                                                echo "checked";
                                                            } ?>/><span
                                                                class="label label-sm label-danger">&nbsp; <?php echo $lang_var_admin_147; ?>
                                                                &nbsp; </span> </label>
                                                    </div>
                                                    <div id="bs_type_error"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_145; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="bs_width" class="form-control"
                                                           value="<?php echo $bs_width; ?>"
                                                           style="width:100px;display: inline;" required=""/> *
                                                    <input type="text" name="bs_height" class="form-control"
                                                           value="<?php echo $bs_height; ?>"
                                                           style="width:100px;display: inline;"
                                                           required=""/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_149; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="bs_period" class="form-control"
                                                           value="<?php echo $bs_period; ?>"
                                                           style="width:100px;display: inline;"
                                                           required=""/> 0 = &infin; &nbsp;Seconds
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_150; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="bs_desc_status"
                                                                      value="1" <?php if ($bs_desc_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="bs_desc_status"
                                                                      value="0" <?php if ($bs_desc_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_151; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="bs_link_status"
                                                                      value="1" <?php if ($bs_link_status == 1) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_75; ?> </label>
                                                        <label><input type="radio" name="bs_link_status"
                                                                      value="0" <?php if ($bs_link_status == 0) {
                                                                echo "checked";
                                                            } ?>/><?php echo $lang_var_admin_76; ?> </label>
                                                    </div>
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

                            <?php
                        } elseif ($act == "new") {
                            ?>

                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-plus"></i> <?php echo $lang_var_admin_65; ?>
                                    </div>
                                    <div class="tools">
                                        <a href="?" class="close"></a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <form action="?act=insert" id="form_site_sections_new" method="post"
                                          class="form-horizontal"
                                          enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="alert alert-danger display-hide">
                                                <?php echo $lang_var_admin_12; ?>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_62; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="bs_name_var" class="form-control"
                                                           required=""/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_63; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list" data-error-container="#bs_type_error">
                                                        <label><input type="radio" name="bs_type" value="0"/><span
                                                                class="label label-sm label-default">&nbsp; <?php echo $lang_var_admin_148; ?>
                                                                &nbsp; </span> </label>
                                                        <label><input type="radio" name="bs_type" value="1"
                                                                      checked="checked"/><span
                                                                class="label label-sm label-info">&nbsp; <?php echo $lang_var_admin_146; ?>
                                                                &nbsp; </span> </label>
                                                        <label><input type="radio" name="bs_type" value="2"/><span
                                                                class="label label-sm label-danger">&nbsp;<?php echo $lang_var_admin_147; ?>
                                                                &nbsp; </span> </label>
                                                    </div>
                                                    <div id="bs_type_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_145; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="bs_width" placeholder="Width"
                                                           class="form-control" required=""
                                                           style="width:100px;display: inline;"/> *
                                                    <input type="text" name="bs_height" placeholder="Height"
                                                           class="form-control"
                                                           required="" style="width:100px;display: inline;"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_149; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="bs_period" class="form-control small"
                                                           required="" value="0"
                                                           style="width:100px;display: inline;"/> 0 = &infin; &nbsp;Seconds
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_150; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="bs_desc_status"
                                                                      value="1"/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="bs_desc_status" value="0"
                                                                      checked/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $lang_var_admin_151; ?>
                                                    <span
                                                        class="required">*</span></label>

                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label><input type="radio" name="bs_link_status" value="1"
                                                                      checked/><?php echo $lang_var_admin_75; ?>
                                                        </label>
                                                        <label><input type="radio" name="bs_link_status"
                                                                      value="0"/><?php echo $lang_var_admin_76; ?>
                                                        </label>
                                                    </div>
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
                            ?>
                            <div>
                                <form name="multicheckfrm" id="multicheckfrm" method="post" action="?">
                                    <div class="table-toolbar">
                                        <div class="btn-group">
                                            <a href="?act=new"><span id="sample_editable_1_new" class="btn green">
									<?php echo $lang_var_admin_65; ?> <i class="fa fa-plus"></i>
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
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                        <tr>
                                            <th class="table-checkbox">
                                                <input type="checkbox" class="group-checkable"
                                                       data-set="#sample_1 .checkboxes"/>
                                            </th>
                                            <th><?php echo $lang_var_admin_144; ?></th>
                                            <th><?php echo $lang_var_admin_63; ?></th>
                                            <th><?php echo $lang_var_admin_145; ?></th>
                                            <th style="width: 10%;text-align: center;"><?php echo $lang_var_admin_4; ?></th>
                                            <th style="width: 10%;"><?php echo $lang_var_admin_5; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_banars_sections order by bs_status desc,  bs_id");
                                        while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                            if ($data_retrive['bs_status'] == 1) {
                                                $active_icn = "<span class='label label-sm label-info'><i class='fa fa-check'></i></span>";
                                            } else {
                                                $active_icn = "<span class='label label-default'><i class='fa fa-times'></i></span>";
                                            }

                                            if ($data_retrive['bs_type'] == 2) {
                                                $section_type_icn = "<span class='label label-sm label-danger'>&nbsp; $lang_var_admin_147&nbsp; </span>";
                                            } elseif ($data_retrive['bs_type'] == 1) {
                                                $section_type_icn = "<span class='label label-sm label-info'>&nbsp; $lang_var_admin_146&nbsp; </span>";
                                            } else {
                                                $section_type_icn = "<span class='label label-sm label-default'>&nbsp; $lang_var_admin_148&nbsp; </span>";
                                            }


                                            ?>
                                            <tr class="odd gradeX">
                                                <td>
                                                    <input type="checkbox" name="multichkbx[]" class="checkboxes"
                                                           value="<?php echo
                                                           $data_retrive['bs_id']; ?>"/>
                                                </td>
                                                <td><?php echo $$data_retrive['bs_name_var']; ?></td>
                                                <td>
                                                    <small><?php echo $section_type_icn; ?></small>
                                                </td>
                                                <td>
                                                    <small dir="ltr"><?php echo $data_retrive['bs_width']; ?>
                                                        X <?php echo $data_retrive['bs_height']; ?></small>
                                                </td>
                                                <td style="text-align: center;"><?php echo $active_icn; ?></td>
                                                <td style="text-align: center;"><a
                                                        href="?id=<?php echo $data_retrive['bs_id']; ?>&act=update"
                                                        class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?> <i
                                                            class="fa fa-edit"></i></a></td>
                                            </tr>
                                            <?php
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
            FormValidation.init();

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