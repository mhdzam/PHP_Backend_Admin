<?php


require_once("template/page_start.php");
//--------

$notice_id = @$_GET['notice_id'];
$member_id = @$_GET['id'];
$stat = @$_GET['stat'];
$sve_in = "#remarks";


$sql_modify = mysql_query("SELECT * FROM " . $prefix . "_members_notices WHERE notice_id ='$notice_id' ");
$data_modify = mysql_fetch_array($sql_modify);
$notice_date = stripcslashes($data_modify['notice_date']);
$notice_details = stripcslashes($data_modify['notice_details']);
$create_date = stripcslashes($data_modify['create_date']);

$edit_date = $data_modify['edit_date'];
$edit_by = GetAdminUserName($data_modify['edit_by']);
$edit_from = $data_modify['edit_from'];


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
        <link rel="stylesheet" type="text/css" href="assets/plugins/clockface/css/clockface.css"/>
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css"/>

    </head>
    <!-- END HEAD -->
    <!-- BEGIN BODY -->
    <body style="background: #fff !important;">
    <!-- BEGIN HEADER -->
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <?php
    if ($stat == "update"){
    ?>
    <div class="modelTitle">
        <h4><i class="fa fa-edit"></i> <?php echo $lang_var_admin_463; ?> </h4>
    </div>
    <br>

    <form
        action="members.php?id=<?php echo $member_id; ?>&act=update&notice_id=<?php echo $notice_id; ?>&noticeact=save<?php echo $sve_in; ?>"
        method="post"
        class="form-horizontal" enctype="multipart/form-data">

        <?php
        }else{

        $notice_date = $pd_current_date;
        ?>
        <div class="modelTitle">
            <h4><i class="fa fa-edit"></i> <?php echo $lang_var_admin_462; ?> </h4>
        </div>
    <br>
        <form
            action="members.php?id=<?php echo $member_id; ?>&act=update&noticeact=insert<?php echo $sve_in; ?>"
            method="post"
            class="form-horizontal" enctype="multipart/form-data">
            <?php
            }
            ?>
            <div class="form-body">


                <div class="form-group">
                    <label class="control-label col-md-3"><?php echo $lang_var_admin_101; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-8">
                        <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control"
                                   value="<?php echo $notice_date; ?>" name="notice_date" readonly>
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3"><?php echo $lang_var_admin_450; ?> </label>

                    <div class="col-md-8">
                        <textarea name="notice_details" rows="8"
                                  class="form-control"><?php echo $notice_details; ?></textarea>
                    </div>
                </div>

                <?php
                if ($stat == "update") {
                    ?>
                    <div class="form-group" style="margin: 0;">
                        <label
                            class="control-label col-md-3"> </label>

                        <div class="col-md-8">
                            <small>
                                <?php echo $lang_var_admin_290; ?>
                                : <?php echo FormatDateTimeLong($create_date); ?>
                                <br>
                                <?php echo $lang_var_admin_464; ?>
                                : <?php echo FormatDateTimeLong($edit_date); ?>
                                <span class="pull-right">
                        IP : <a
                                        href="ip.php?ip=<?php echo $edit_from; ?>"><?php echo $edit_from; ?></a>
                            </span>
                            </small>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="form-actions fluid">
                <div class="col-md-offset-3 col-md-6">
                    <button type="submit" class="btn green"><?php echo $lang_var_admin_21; ?></button>
                    &nbsp;
                    <a href="?">
                        <button type="button" data-dismiss="modal"
                                class="btn default"><?php echo $lang_var_admin_22; ?></button>
                    </a>
                </div>
            </div>
        </form>


        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
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

        <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

        <script src="assets/scripts/custom/components-pickers.js"></script>

        <script src="assets/scripts/core/app.js"></script>
        <script>
            jQuery(document).ready(function () {
                App.init();
                ComponentsPickers.init();
            });
        </script>
    </body>
    <!-- END BODY -->
    </html>
<?php

require_once("template/page_end.php");
?>