<?php



require_once("template/page_start.php");
//--------

$invoice_id = @$_GET['invoice_id'];
$member_id = @$_GET['id'];
$stat = @$_GET['stat'];
$sve_in = "#invoices";


$sql_modify = mysql_query("SELECT * FROM " . $prefix . "_members_invoices WHERE invoice_id ='$invoice_id' ");
$data_modify = mysql_fetch_array($sql_modify);
$invoice_title = stripcslashes($data_modify['invoice_title']);
$invoice_date = stripcslashes($data_modify['invoice_date']);
$create_date = stripcslashes($data_modify['create_date']);
$invoice_price = stripcslashes($data_modify['invoice_price']);
$invoice_sub = stripcslashes($data_modify['invoice_sub']);

$invoice_canceled = stripcslashes($data_modify['invoice_canceled']);
$invoice_free = stripcslashes($data_modify['invoice_free']);
$invoice_father = stripcslashes($data_modify['invoice_father']);

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

    <script>
        function showstat(val) {
            if (val == 0) {
                document.getElementById("invoice_title").value = '';
                document.getElementById("invoice_price").value = '';
                document.getElementById("allfilds").style.display = 'block';

            } else {
                document.getElementById("invoice_title").value = ' ';
                document.getElementById("invoice_price").value = '0';
                document.getElementById("allfilds").style.display = 'none';
            }
        }
    </script>
    <?php
    $allfilds_display = "";
    if ($invoice_sub == 1) {
        $allfilds_display = "style='display:none'";
    }
    ?>
    <?php
    if ($stat == "update"){
    ?>
    <div class="modelTitle">
        <h4><i class="fa fa-edit"></i> <?php echo $lang_var_admin_466; ?> </h4>
    </div>
    <br>

    <form
        action="members.php?id=<?php echo $member_id; ?>&act=update&invoice_id=<?php echo $invoice_id; ?>&invoiceact=save<?php echo $sve_in; ?>"
        method="post"
        class="form-horizontal" enctype="multipart/form-data">

        <?php
        }else{

        $invoice_date = $pd_current_date;
        ?>
        <div class="modelTitle">
            <h4><i class="fa fa-edit"></i> <?php echo $lang_var_admin_465; ?> </h4>
        </div>
    <br>

        <form
            action="members.php?id=<?php echo $member_id; ?>&act=update&invoiceact=insert<?php echo $sve_in; ?>"
            method="post"
            class="form-horizontal" enctype="multipart/form-data">
            <?php
            }
            ?>
            <div class="form-body">
                <div class="form-group">
                    <label
                        class="control-label col-md-3"><?php echo $lang_var_admin_473; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-8">
                        <div class="radio-list">
                            <label style="display: inline-block;"><input type="radio" onclick="showstat(this.value)"
                                                                         name="invoice_sub"
                                                                         value="0" <?php if ($invoice_sub == 0) {
                                    echo "checked";
                                } ?>/><?php echo $lang_var_admin_475; ?> </label> &nbsp; &nbsp;
                            <label style="display: inline-block;"><input type="radio" onclick="showstat(this.value)"
                                                                         name="invoice_sub"
                                                                         value="1" <?php if ($invoice_sub == 1) {
                                    echo "checked";
                                } ?>/><?php echo $lang_var_admin_474; ?> </label>

                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-3"><?php echo $lang_var_admin_101; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-8">
                        <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control"
                                   value="<?php echo $invoice_date; ?>" name="invoice_date" readonly>
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>

                <div id="allfilds" <?php echo $allfilds_display; ?>>

                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_476; ?>
                            <span
                                class="required">*</span></label>

                        <div class="col-md-8">
                            <select class="form-control" name="invoice_father" class="select2me">
                                <option value="0"><?php echo $lang_var_admin_475; ?>...
                                </option>
                                <?php
                                $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_members_invoices where member_id='$member_id' and invoice_type=0 and invoice_sub=1 and invoice_father=0 order by create_date");
                                while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {

                                    ?>
                                    <option
                                        value="<?php echo $data_father_retrive['invoice_id']; ?>"><?php echo $lang_var_admin_474; ?> # <?php echo $data_father_retrive['invoice_id']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"><?php echo $lang_var_admin_103; ?> <span
                                class="required">*</span></label>

                        <div class="col-md-8">
                            <input type="text" name="invoice_title" id="invoice_title" required=""
                                   value="<?php echo $invoice_title; ?>"
                                   class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3"><?php echo $lang_var_admin_316; ?>
                            <small>(<?php echo $defult_currency; ?>)</small> <span
                                class="required">*</span></label>

                        <div class="col-md-3">
                            <input type="text" name="invoice_price" id="invoice_price" required=""
                                   value="<?php echo $invoice_price; ?>"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_467; ?> <span
                                class="required">*</span></label>

                        <div class="col-md-8">
                            <div class="radio-list">
                                <label style="display: inline-block;"><input type="radio" name="invoice_free"
                                                                             value="0" <?php if ($invoice_free == 0) {
                                        echo "checked";
                                    } ?>/><?php echo $lang_var_admin_76; ?> </label> &nbsp; &nbsp;
                                <label style="display: inline-block;"><input type="radio" name="invoice_free"
                                                                             value="1" <?php if ($invoice_free == 1) {
                                        echo "checked";
                                    } ?>/><?php echo $lang_var_admin_75; ?> </label>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_468; ?> <span
                                class="required">*</span></label>

                        <div class="col-md-8">
                            <div class="radio-list">
                                <label style="display: inline-block;"><input type="radio" name="invoice_canceled"
                                                                             value="0" <?php if ($invoice_canceled == 0) {
                                        echo "checked";
                                    } ?>/><?php echo $lang_var_admin_76; ?> </label> &nbsp; &nbsp;
                                <label style="display: inline-block;"><input type="radio" name="invoice_canceled"
                                                                             value="1" <?php if ($invoice_canceled == 1) {
                                        echo "checked";
                                    } ?>/><?php echo $lang_var_admin_75; ?> </label>

                            </div>
                        </div>
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