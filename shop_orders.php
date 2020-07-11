<?php
require_once("template/page_start.php");
if ($site_calendar_status == 1) {
//--------

    $id = @$_GET['id'];
    $affiliate = @$_GET['affiliate'];
    $member_username = mysql_real_escape_string(@$_POST['member_username']);
    $member_password = mysql_real_escape_string(@$_POST['member_password']);
    $member_firstname = mysql_real_escape_string(@$_POST['member_firstname']);
    $member_lastname = mysql_real_escape_string(@$_POST['member_lastname']);
    $member_photo = mysql_real_escape_string(@$_POST['member_photo']);
    $member_phone = mysql_real_escape_string(@$_POST['member_phone']);
    $member_email = mysql_real_escape_string(@$_POST['member_email']);

    $file_del = mysql_real_escape_string(@$_POST['file_del']);
    $up_dir = "../uploads/orders/";
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
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css"/>


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
                <div class="row hidden-print">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title"><?php echo $lang_var_admin_303; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">

                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_303; ?></a>
                            </li>
                            <?php
                            if ($act == "update") {
                                ?>
                                <li class="btn-group">
                                    <a href="?act=invoice&id=<?php echo $id; ?>"><span id="sample_editable_1_new"
                                                                                       class="btn green">
    	<?php echo $lang_var_admin_358; ?> <i class="fa fa-print"></i>
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

                        if ($act == "invoice") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix . "_shop_orders  WHERE order_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);

                            $order_no = stripcslashes($data_modify['order_no']);
                            $order_total = ($data_modify['order_total']);
                            $discount_coupon = stripcslashes($data_modify['discount_coupon']);
                            $discount_total = ($data_modify['discount_total']);
                            $ship_cost = ($data_modify['ship_cost']);

                            $customer_name = stripcslashes($data_modify['customer_name']);
                            $customer_phone = stripcslashes($data_modify['customer_phone']);
                            $customer_phone2 = stripcslashes($data_modify['customer_phone2']);
                            if ($customer_phone2 != "") {
                                $customer_phone2 = " - " . $customer_phone2;
                            }
                            $customer_email = stripcslashes($data_modify['customer_email']);
                            $customer_state = stripcslashes($data_modify['customer_state']);
                            $customer_city = stripcslashes($data_modify['customer_city']);
                            $customer_address = stripcslashes($data_modify['customer_address']);
                            $order_pay_method = stripcslashes($data_modify['order_pay_method']);

                            $order_date = date('d-m-Y h:i A', strtotime($data_modify['order_date']));
                            $order_details = stripcslashes($data_modify['order_details']);

                            $status_list = array(
                                array("danger" => "<i class='fa fa-clock-o'></i> $lang_var_admin_351"),
                                array("warning" => "<i class='fa fa-star-o'></i> $lang_var_admin_352"),
                                array("info" => "<i class='fa fa-plane'></i> $lang_var_admin_353"),
                                array("success" => "<i class='fa fa-check'></i> $lang_var_admin_354")
                            );
                            $status = $status_list[$data_modify['order_status']];

                            $status_list2 = array(
                                array("default" => "<i class='fa fa-times'></i> $lang_var_admin_357"),
                                array("info" => "<i class='fa fa-check'></i> $lang_var_admin_356")
                            );
                            $status2 = $status_list2[$data_modify['order_pay_status']];

                            $member_id = $data_modify['member_id'];

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];


                            ?>
                            <div class="invoice">
                                <style>
                                @media print {
                                    .footer{
                                        display:none;
                                    }
                                }
                                </style>
                                <div class="row invoice-logo">
                                    <div class="col-xs-6 invoice-logo-space">
                                        <?php
                                            $sql_get_site_settings = mysql_query("SELECT * FROM " . $prefix . "_settings  WHERE settings_id ='1' ");
    $data_get_site_settings = mysql_fetch_array($sql_get_site_settings);
        $site_logo = stripcslashes($data_get_site_settings['site_logo_'.$lang]);
                        if($site_logo !="") {
                            ?>
                            <img
                                    src="../uploads/<?php echo $site_logo; ?>" style="max-height:120px"
                                    alt="<?php echo $site_title; ?>">
                            <?php
                        }else{
                            ?>
                            <img
                                    src="../assets/images/logo-<?php echo $site_lang_dir; ?>.png" style="max-height:120px"
                                    alt="<?php echo $site_title; ?>">
                            <?php
                        }
                        ?>
                                    </div>
                                    <div class="col-xs-6">
                                        <br><br>

                                        <p>
                                            <strong><?php echo $order_no; ?></strong><br>
							<span class="muted">
								 <?php echo $order_date; ?>
							</span>
                                        </p>
                                    </div>
                                </div>
                                <hr/>

                                <div class="row">
                                    <div class="col-xs-3">
                                        <h4><?php echo $lang_var_admin_360; ?>:</h4>
                                        <ul class="list-unstyled">
                                            <li>
                                                <?php echo $lang_var_admin_283; ?>:
                                            </li>
                                            <li>
                                                <?php echo $lang_var_admin_284; ?>:
                                            </li>
                                            <li>
                                                <?php echo $lang_var_admin_15; ?>:
                                            </li>
                                            <li>
                                                <?php echo $lang_var_admin_217; ?>:
                                            </li>
                                            <li>
                                                <?php echo $lang_var_admin_304; ?>:
                                            </li>
                                            <li>
                                                <?php echo $lang_var_admin_192; ?>:
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-4">
                                        <h4>&nbsp;</h4>
                                        <ul class="list-unstyled">
                                            <li>
                                                <?php echo $customer_name; ?>
                                            </li>
                                            <li>
                                                <?php echo $customer_phone; ?><?php echo $customer_phone2; ?>
                                            </li>
                                            <li>
                                                <?php echo $customer_email; ?>
                                            </li>
                                            <li>
                                                <?php echo $customer_state; ?>
                                            </li>
                                            <li>
                                                <?php echo $customer_city; ?>
                                            </li>
                                            <li>
                                                <?php echo $customer_address; ?>
                                            </li>
                                        </ul>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <br>
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <?php echo $lang_var_admin_317; ?>
                                                </th>
                                                <th>
                                                    <?php echo $lang_var_admin_368; ?>
                                                </th>
                                                <th>
                                                    <?php echo $lang_var_admin_319; ?>
                                                </th>
                                                <th>
                                                    <?php echo $lang_var_admin_318; ?>
                                                </th>
                                                <th>
                                                    <?php echo $lang_var_admin_367; ?>
                                                </th>
                                                <th>
                                                    <?php echo $lang_var_admin_347; ?>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $oitems_total = 0;
                                            $sql_retrive_items = mysql_query("SELECT * FROM " . $prefix . "_shop_orders_items where order_id='$id' order by oitem_id");
                                            while ($data_retrive_items = mysql_fetch_array($sql_retrive_items)) {
                                                $o_item_total = $data_retrive_items['oitem_qty'] * $data_retrive_items['item_price'];
                                                $oitems_total += $o_item_total;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo stripslashes($data_retrive_items['item_title_' . $lang]); ?>
                                                        <div>
                                                            <?php echo stripslashes($data_retrive_items['size_title_' . $lang]); ?>
                                                            -
                                                            <?php echo stripslashes($data_retrive_items['color_title_' . $lang]); ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php echo stripslashes($data_retrive_items['item_code']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo($data_retrive_items['item_first_price']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo($data_retrive_items['item_price']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo($data_retrive_items['oitem_qty']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($o_item_total, 2); ?><?php echo $defult_currency; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>


                                            </tbody>
                                        </table>

                                        <?php echo nl2br($order_details); ?>
                                        <br><br>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-xs-8 invoice-block ">
                                        <div class="well">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <ul class="list-unstyled amounts">
                                                        <li>
                                                            <strong><?php echo $lang_var_admin_347; ?> :</strong>
                                                        </li>
                                                        <li>
                                                            <strong><?php echo $lang_var_admin_313; ?> :</strong>
                                                        </li>
                                                        <li>
                                                            <strong><?php echo $lang_var_admin_326; ?> :</strong>
                                                        </li>
                                                        <li>
                                                            <strong><?php echo $lang_var_admin_347; ?> :</strong>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xs-4">
                                                    <ul class="list-unstyled amounts">
                                                        <li>
                                                            <?php echo number_format($oitems_total, 2); ?><?php echo $defult_currency; ?>
                                                        </li>
                                                        <li>
                                                            <?php echo $ship_cost; ?><?php echo $defult_currency; ?>
                                                        </li>
                                                        <li>
                                                            <?php echo $discount_total; ?><?php echo $defult_currency; ?>
                                                        </li>
                                                        <li>
                                                            <?php echo $order_total; ?><?php echo $defult_currency; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <a class="btn btn-lg blue hidden-print" onclick="javascript:window.print();">
                                            Print <i class="fa fa-print"></i>
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <?php
                        } elseif ($act == "update") {
                            $sql_modify = mysql_query("SELECT * FROM " . $prefix .
                                "_shop_orders  WHERE order_id ='$id' ");
                            $data_modify = mysql_fetch_array($sql_modify);

                            $order_no = stripcslashes($data_modify['order_no']);
                            $order_total = ($data_modify['order_total']);
                            $discount_coupon = stripcslashes($data_modify['discount_coupon']);
                            $discount_total = ($data_modify['discount_total']);
                            $ship_cost = ($data_modify['ship_cost']);

                            $customer_name = stripcslashes($data_modify['customer_name']);
                            $customer_phone = stripcslashes($data_modify['customer_phone']);
                            $customer_phone2 = stripcslashes($data_modify['customer_phone2']);
                            if ($customer_phone2 != "") {
                                $customer_phone2 = " - " . $customer_phone2;
                            }
                            $customer_email = stripcslashes($data_modify['customer_email']);
                            $customer_state = stripcslashes($data_modify['customer_state']);
                            $customer_city = stripcslashes($data_modify['customer_city']);
                            $customer_address = stripcslashes($data_modify['customer_address']);
                            $order_pay_method = stripcslashes($data_modify['order_pay_method']);

                            $order_date = date('d-m-Y h:i A', strtotime($data_modify['order_date']));
                            $order_details = stripcslashes($data_modify['order_details']);

                            $status_list = array(
                                array("danger" => "<i class='fa fa-clock-o'></i> $lang_var_admin_351"),
                                array("warning" => "<i class='fa fa-star-o'></i> $lang_var_admin_352"),
                                array("info" => "<i class='fa fa-plane'></i> $lang_var_admin_353"),
                                array("success" => "<i class='fa fa-check'></i> $lang_var_admin_354")
                            );
                            $status = $status_list[$data_modify['order_status']];

                            $status_list2 = array(
                                array("default" => "<i class='fa fa-times'></i> $lang_var_admin_357"),
                                array("info" => "<i class='fa fa-check'></i> $lang_var_admin_356")
                            );
                            $status2 = $status_list2[$data_modify['order_pay_status']];

                            $member_id = $data_modify['member_id'];

                            $edit_date = $data_modify['edit_date'];
                            $edit_by = GetAdminUserName($data_modify['edit_by']);
                            $edit_from = $data_modify['edit_from'];
                            ?>
                            <div>

                                <div>
                                    <!-- BEGIN FORM-->
                                    <div style="padding: 20px">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet yellow box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-qrcode"></i><?php echo $lang_var_admin_359; ?>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_362; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $order_no; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_363; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $order_date; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_364; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                <span
                                    class="label label-sm label-<?php echo(key($status)); ?>">&nbsp;<?php echo(current($status)); ?>
                                    &nbsp;</span>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_365; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                <span
                                    class="label label-sm label-<?php echo(key($status2)); ?>">&nbsp;<?php echo(current($status2)); ?>
                                    &nbsp;</span>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_366; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $order_pay_method; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_347; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $order_total; ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet blue box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-user"></i><?php echo $lang_var_admin_360; ?>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_283; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $customer_name; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_284; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $customer_phone; ?><?php echo $customer_phone2; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_15; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $customer_email; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_217; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $customer_state; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_304; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $customer_city; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name">
                                                                <?php echo $lang_var_admin_192; ?>:
                                                            </div>
                                                            <div class="col-md-7 value">
                                                                <?php echo $customer_address; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="portlet purple box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-shopping-cart"></i><?php echo $lang_var_admin_361; ?>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-hover table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>
                                                                        <?php echo $lang_var_admin_317; ?>
                                                                    </th>
                                                                    <th>
                                                                        <?php echo $lang_var_admin_368; ?>
                                                                    </th>
                                                                    <th>
                                                                        <?php echo $lang_var_admin_319; ?>
                                                                    </th>
                                                                    <th>
                                                                        <?php echo $lang_var_admin_318; ?>
                                                                    </th>
                                                                    <th>
                                                                        <?php echo $lang_var_admin_367; ?>
                                                                    </th>
                                                                    <th>
                                                                        <?php echo $lang_var_admin_347; ?>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $oitems_total = 0;
                                                                $sql_retrive_items = mysql_query("SELECT * FROM " . $prefix . "_shop_orders_items where order_id='$id' order by oitem_id");
                                                                while ($data_retrive_items = mysql_fetch_array($sql_retrive_items)) {
                                                                    $o_item_total = $data_retrive_items['oitem_qty'] * $data_retrive_items['item_price'];
                                                                    $oitems_total += $o_item_total;


                                                                    $total_size_id = $data_retrive_items['size_id'];
                                                                    $total_color_id = $data_retrive_items['color_id'];

                                                                    $sql_quantities = mysql_query("SELECT sum(quantity_amount) quantity_amount FROM " . $prefix . "_shop_items_quantities where item_id='$data_retrive_items[item_id]' and size_id ='$total_size_id' and color_id='$total_color_id'");
                                                                    $data_quantities = mysql_fetch_array($sql_quantities);
                                                                    $item_quantity_amount = $data_quantities['quantity_amount'];
                                                                    if ($item_quantity_amount < 1) {
                                                                        $item_quantity_amount = 0;
                                                                    }

                                                                    $sql_total_sold = mysql_query("SELECT sum(oitem_qty) as totl_sold FROM " . $prefix . "_shop_orders_items  where item_id='$data_retrive_items[item_id]' and size_id ='$total_size_id' and color_id='$total_color_id' and order_id in (SELECT order_id FROM " . $prefix . "_shop_orders where order_status !=0 and temp_status !=0)");
                                                                    $data_total_sold = mysql_fetch_array($sql_total_sold);
                                                                    $item_totl_sold = $data_total_sold['totl_sold'];
                                                                    if ($item_totl_sold < 1) {
                                                                        $item_totl_sold = 0;
                                                                    }

                                                                    $avilable_st="";
                                                                    $sub_is = $item_quantity_amount - $item_totl_sold;
                                                                    if ($sub_is < 1) {
                                                                        $avilable_st="<div class='pull-right' style='color: #ff0000'>$lang_var_admin_522</div>";
                                                                    }
                                                                    if($item_quantity_amount==0){
                                                                        $avilable_st="";
                                                                    }

                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $avilable_st; ?>
                                                                            <a href="shop_items.php?id=<?php echo $data_retrive_items['item_id'] ?>&act=update"
                                                                               target="_blank">
                                                                                <?php echo stripslashes($data_retrive_items['item_title_' . $lang]); ?>
                                                                            </a>
                                                                            <div>
                                                                                <?php echo stripslashes($data_retrive_items['size_title_' . $lang]); ?>
                                                                                -
                                                                                <?php echo stripslashes($data_retrive_items['color_title_' . $lang]); ?>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo stripslashes($data_retrive_items['item_code']); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo($data_retrive_items['item_first_price']); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo($data_retrive_items['item_price']); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo($data_retrive_items['oitem_qty']); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo number_format($o_item_total, 2); ?><?php echo $defult_currency; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>


                                                                </tbody>
                                                            </table>
                                                            <?php echo nl2br($order_details); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                            </div>
                                            <div class="col-md-5">
                                                <div class="well">
                                                    <div class="row static-info align-reverse">
                                                        <div class="col-md-6 name">
                                                            <?php echo $lang_var_admin_347; ?>:
                                                        </div>
                                                        <div class="col-md-5 value">
                                                            <?php echo number_format($oitems_total, 2); ?><?php echo $defult_currency; ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info align-reverse">
                                                        <div class="col-md-6 name">
                                                            <?php echo $lang_var_admin_313; ?>:
                                                        </div>
                                                        <div class="col-md-5 value">
                                                            <?php echo $ship_cost; ?><?php echo $defult_currency; ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info align-reverse">
                                                        <div class="col-md-6 name">
                                                            <?php echo $lang_var_admin_326; ?>:
                                                        </div>
                                                        <div class="col-md-5 value">
                                                            <?php echo $discount_total; ?><?php echo $defult_currency; ?>
                                                        </div>
                                                    </div>
                                                    <div class="row static-info align-reverse">
                                                        <div class="col-md-6 name">
                                                            <?php echo $lang_var_admin_347; ?>:
                                                        </div>
                                                        <div class="col-md-5 value">
                                                            <?php echo $order_total; ?><?php echo $defult_currency; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END FORM-->
                                </div>

                                <!-- END VALIDATION STATES-->
                            </div>
                            <?php
                        } else {

                            @ require_once("template/orders_view.php");
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
    <!-- END PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

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
                        "sAjaxSource": "template/orders_view_ajax.php?lang=<?php echo $lang; ?>&var_admin_6=<?php echo $lang_var_admin_103; ?>&var_admin_25=<?php echo $lang_var_admin_25; ?>&var_admin_351=<?php echo $lang_var_admin_351; ?>&var_admin_352=<?php echo $lang_var_admin_352; ?>&var_admin_353=<?php echo $lang_var_admin_353; ?>&var_admin_354=<?php echo $lang_var_admin_354; ?>&logged_allow_edit_status=<?php echo $logged_allow_edit_status; ?>&affiliate=<?php echo $affiliate; ?>", // ajax source
                        "aaSorting": [[1, "desc"]], // set first column as a default sort by asc
                        "aoColumnDefs": [{
                            'bSortable': false,
                            'aTargets': [0, 8]
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
            UIAlertDialogApi.init();
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