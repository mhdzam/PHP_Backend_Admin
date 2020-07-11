<?php



require_once("template/page_start.php");

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
        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="assets/css/flags.css"/>
        <!-- END PAGE LEVEL PLUGIN STYLES -->
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
                        <h3 class="page-title">
                            <?php echo $lang_var_admin_56; ?>
                        </h3>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->

                <?php

                // delete old temp orders
                $pd_before_3days_date = date('Y-m-d', strtotime('-7 day'));
                $sql_delete_ords_itms = mysql_query("DELETE FROM  " . $prefix . "_shop_orders_items WHERE (order_id in (SELECT order_id FROM " . $prefix . "_shop_orders where temp_status ='0' and order_date < '$pd_before_3days_date') OR order_id not in (SELECT order_id FROM " . $prefix . "_shop_orders))");
                $sql_delete_ords = mysql_query("DELETE FROM " . $prefix . "_shop_orders where temp_status ='0' and order_date < '$pd_before_3days_date'");

                //
                $sql_count_newoders = mysql_query("SELECT * FROM " . $prefix . "_shop_orders where order_status='0' and temp_status ='1' ");
                $orders_new_records_count = mysql_num_rows($sql_count_newoders);

                $sql_count_calendar = mysql_query("SELECT * FROM " . $prefix . "_calendar");
                $calendar_records_count = mysql_num_rows($sql_count_newoders);

                $sql_count_maillist = mysql_query("SELECT * FROM " . $prefix . "_newsletter ");
                $mail_list_records_count = mysql_num_rows($sql_count_maillist);

                $sql_count_site_visitors = mysql_query("SELECT *  FROM " . $prefix . "_analytics_visitors where visitor_date = '$pd_current_date'");
                $site_visitors_records_count = mysql_num_rows($sql_count_site_visitors);

                ?>
                <!-- BEGIN PAGE CONTENT-->
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat blue">
                            <div class="visual">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?php echo $inbox_new_records_count; ?>
                                </div>
                                <div class="desc">
                                    <?php echo $lang_var_admin_267; ?>
                                </div>
                            </div>
                            <a class="more" href="inbox.php"><?php echo $lang_var_admin_371; ?><i
                                    class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat green">
                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?php echo $orders_new_records_count; ?>
                                </div>
                                <div class="desc">
                                    <?php echo $lang_var_admin_372; ?>
                                </div>
                            </div>
                            <a class="more" href="shop_orders.php"><?php echo $lang_var_admin_371; ?><i
                                    class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat purple">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?php echo $mail_list_records_count; ?>
                                </div>
                                <div class="desc">
                                    <?php echo $lang_var_admin_373; ?>
                                </div>
                            </div>
                            <a class="more" href="news_letter.php"><?php echo $lang_var_admin_371; ?><i
                                    class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard-stat yellow">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <?php echo $site_visitors_records_count; ?>
                                </div>
                                <div class="desc">
                                    <?php echo $lang_var_admin_370; ?>
                                </div>
                            </div>
                            <a class="more" href="analytics.php"><?php echo $lang_var_admin_371; ?><i
                                    class="m-icon-swapright m-icon-white"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="clearfix">
                </div>


                <div class="row">


                    <div class="col-md-6 col-sm-6">
                        <!-- BEGIN PORTLET-->
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-bar-chart-o"></i><?php echo $lang_var_admin_376; ?>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div id="site_statistics_loading">
                                    <img src="assets/img/loading.gif" alt="loading"/>
                                </div>
                                <div id="site_statistics_content" class="display-none">
                                    <div id="site_statistics" class="chart">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET-->
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-tasks"></i><?php echo $lang_var_admin_377; ?>
                                </div>
                            </div>

                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="sparkline-chart">
                                            <div class="number" id="sparkline_line">
                                            </div>
                                            <a class="title" href="analytics.php?stat=date">
                                                <?php echo $pd_current_date; ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="margin-bottom-10 visible-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sparkline-chart">
                                            <div class="number" id="sparkline_bar2">
                                            </div>
                                            <a class="title" href="analytics.php?stat=date">
                                                <?php echo $day_date = date('Y-m-d', strtotime('-1 day')); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="margin-bottom-10 visible-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="sparkline-chart">
                                            <div class="number" id="sparkline_bar">
                                            </div>
                                            <a class="title" href="analytics.php?stat=date">
                                                <?php echo $day_date = date('Y-m-d', strtotime('-2 day')); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-calendar"></i><?php echo $lang_var_admin_378; ?>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <?php
                                    $country_1_name = "";
                                    $country_1_shotid = "";
                                    $country_1_value = 0;
                                    $country_1_percent = 0;

                                    $country_2_name = "";
                                    $country_2_shotid = "";
                                    $country_2_value = 0;
                                    $country_2_percent = 0;

                                    $country_3_name = "Other";
                                    $country_3_shotid = "";
                                    $country_3_value = 0;
                                    $country_3_percent = 0;

                                    $i_stp = 1;

                                    $sql_tv = mysql_query("SELECT * FROM " . $prefix . "_analytics_visitors where visitor_date = '$pd_current_date' GROUP BY visitor_country ORDER BY COUNT(visitor_country) desc");
                                    while ($data_tv = mysql_fetch_array($sql_tv)) {
                                        $sql_vis = mysql_query("SELECT COUNT(visitor_id) as vvcccnnt  FROM " . $prefix . "_analytics_visitors where visitor_country='$data_tv[visitor_country]' and (visitor_date = '$pd_current_date') ");
                                        $data_vis = mysql_fetch_array($sql_vis);

                                        if ($i_stp == 1) {
                                            $country_1_name = stripcslashes($data_tv['visitor_country']);
                                            $country_1_shotid = strtolower(stripcslashes($data_tv['visitor_country_code']));
                                            $country_1_value = $data_vis['vvcccnnt'];
                                        } elseif ($i_stp == 2) {
                                            $country_2_name = stripcslashes($data_tv['visitor_country']);
                                            $country_2_shotid = strtolower(stripcslashes($data_tv['visitor_country_code']));
                                            $country_2_value = $data_vis['vvcccnnt'];
                                        } else {
                                            $country_3_value += $data_vis['vvcccnnt'];
                                        }

                                        $i_stp++;
                                    }
                                    $country_total = round($country_1_value + $country_2_value + $country_3_value);
                                    if ($country_total <= 0) {
                                        $country_total = 1;
                                    }
                                    $country_1_percent = round(($country_1_value * 100) / $country_total);
                                    $country_2_percent = round(($country_2_value * 100) / $country_total);
                                    $country_3_percent = round(($country_3_value * 100) / $country_total);
                                    ?>
                                    <div class="col-md-4">
                                        <div class="easy-pie-chart">
                                            <div class="number transactions"
                                                 data-percent="<?php echo $country_1_percent; ?>">
											<span>
												 <?php echo $country_1_percent; ?>
											</span>
                                                %
                                            </div>
                                            <div style="text-align: center">
                                                <div style="display: inline-block"
                                                     class='flag flag-<?php echo $country_1_shotid; ?>'></div>
                                            </div>
                                            <a class="title" href="analytics.php?stat=country">
                                                <small><?php echo $country_1_name; ?></small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="margin-bottom-10 visible-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="easy-pie-chart">
                                            <div class="number visits" data-percent="<?php echo $country_2_percent; ?>">
											<span>
												 <?php echo $country_2_percent; ?>
											</span>
                                                %
                                            </div>
                                            <div style="text-align: center">
                                                <div style="display: inline-block"
                                                     class='flag flag-<?php echo $country_2_shotid; ?>'></div>
                                            </div>
                                            <a class="title" href="analytics.php?stat=country">
                                                <small><?php echo $country_2_name; ?></small>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="margin-bottom-10 visible-sm">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="easy-pie-chart">
                                            <div class="number bounce" data-percent="<?php echo $country_3_percent; ?>">
											<span>
												 <?php echo $country_3_percent; ?>
											</span>
                                                %
                                            </div>
                                            <div style="text-align: center">
                                                <br>
                                            </div>
                                            <a class="title" href="analytics.php?stat=country">
                                                <small><?php echo $country_3_name; ?></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix">
                </div>
                <div class="row ">
                    <div class="col-md-6">
                        <!-- Begin: life time stats -->
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-bell-o"></i> <?php echo $lang_var_admin_379; ?>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div class="scroller" style="height: 340px;" data-always-visible="1"
                                     data-rail-visible="0">
                                    <ul class="feeds">
                                        <?php
                                        $sql_retrive_notifications = mysql_query("SELECT * FROM " . $prefix . "_notifications order by note_date desc, note_id desc limit 15");
                                        while ($data_retrive_notifications = mysql_fetch_array($sql_retrive_notifications)) {
                                            $note_title = stripslashes($data_retrive_notifications['note_title_' . $lang]);
                                            $note_icon = stripslashes($data_retrive_notifications['note_icon']);
                                            $note_url = stripslashes($data_retrive_notifications['note_url']);
                                            $lnk_prt1 = "";
                                            $lnk_prt2 = "";
                                            if ($note_url != "") {
                                                $lnk_prt1 = "<a href='$note_url'>";
                                                $lnk_prt2 = "</a>";
                                            }

                                            ?>

                                            <li>
                                                <?php echo $lnk_prt1; ?>
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <?php echo $note_icon; ?>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc">
                                                                <?php echo $note_title; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date"
                                                         title="<?php echo FormatDateTimeLong(stripslashes($data_retrive_notifications['note_date'])); ?>">
                                                        <?php echo FormatDateTime(stripslashes($data_retrive_notifications['note_date'])); ?>
                                                    </div>
                                                </div>
                                                <?php echo $lnk_prt2; ?>
                                            </li>

                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="scroller-footer">
                                    <div class="pull-right">
                                        <a href="notifications.php">
                                            <small><?php echo $lang_var_admin_269; ?></small>
                                            <i class="m-icon-swap<?php echo $site_lang_align_left; ?>"></i>
                                        </a>
                                        &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: life time stats -->
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <!-- BEGIN PORTLET-->
                        <?php
                        $sql_delete_oldchat = mysql_query("DELETE FROM  " . $prefix .
                            "_users_chats where chat_date < '$pd_before_29day_date' ");
                        ?>
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-comments"></i> <?php echo $lang_var_admin_380; ?>
                                </div>
                            </div>
                            <div class="portlet-body" id="chats">
                                <div class="scroller" style="height: 300px;" data-always-visible="1"
                                     data-rail-visible1="1">
                                    <ul class="chats">

                                    </ul>
                                </div>
                                <div class="chat-form">
                                    <div class="input-cont">
                                        <input class="form-control" id="chat_text" type="text"
                                               placeholder="Type a message here..."/>
                                    </div>
                                    <div class="btn-cont">
									<span class="arrow">
									</span>
                                        <a href="" class="btn blue icn-only">
                                            <i class="fa fa-check icon-white"></i>
                                        </a>
                                    </div>
                                    <div id="chat_jsdiv">

                                    </div>
                                    <input type="hidden" id="lastloadfld" value="0">
                                </div>
                            </div>
                        </div>
                        <!-- END PORTLET-->
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

    <script src="assets/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
    <script src="assets/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
    <script src="assets/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap-daterangepicker/daterangepicker_<?php echo $site_lang_dir; ?>.js"
            type="text/javascript"></script>
    <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
    <script src="assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->

    <script>
        var visitors = [
            <?php
            // LAST 10 Days Visitors


            $pd_before_10day_date= date('Y-m-d',strtotime('-8 day'));
            for($ii=0;$ii<9;$ii++) {
                $dy= date('Y-m-d',date(strtotime("+$ii day", strtotime($pd_before_10day_date))));
                $dys= date('m/d',date(strtotime("+$ii day", strtotime($pd_before_10day_date))));
                $sql_count_site_visitors = mysql_query("SELECT *  FROM " . $prefix . "_analytics_visitors where visitor_date = '$dy'");
                $dyv = mysql_num_rows($sql_count_site_visitors);
            echo "['$dys',$dyv],";
            }
            ?>
        ];

        $("#sparkline_bar").sparkline([
                <?php
    // today per 2 hours Visitors

    $day_date=date('Y-m-d',strtotime('-2 day'));
    for($ii=0;$ii<=24;$ii++) {
        $stepis=$ii+1;
        $timeis1= "$ii:00:00";
        $timeis2= "$stepis:00:00";
        $dys= date('m/d',date(strtotime("+$ii day", strtotime($pd_before_10day_date))));
        $sql_count_site_visitors = mysql_query("SELECT count(visitor_id)  VisitorsCount FROM " . $prefix . "_analytics_visitors where visitor_date = '$day_date' and ( (visitor_time = '$timeis1' || visitor_time > '$timeis1') && (visitor_time = '$timeis2' || visitor_time < '$timeis2') )");
         $data_site_visitors=mysql_fetch_array($sql_count_site_visitors);
        $VisitorsCount = $data_site_visitors['VisitorsCount'];
    echo "$VisitorsCount,";
    }
    ?>
            ], {
                type: 'bar',
                width: '100',
                barWidth: 5,
                height: '55',
                barColor: '#35aa47',
                negBarColor: '#e02222'
            }
        );

        $("#sparkline_bar2").sparkline([
                <?php
    // today per 2 hours Visitors

    $day_date=date('Y-m-d',strtotime('-1 day'));
    for($ii=0;$ii<=24;$ii++) {
    $stepis=$ii+1;
    $timeis1= "$ii:00:00";
    $timeis2= "$stepis:00:00";
    $dys= date('m/d',date(strtotime("+$ii day", strtotime($pd_before_10day_date))));
    $sql_count_site_visitors = mysql_query("SELECT count(visitor_id)  VisitorsCount FROM " . $prefix . "_analytics_visitors where visitor_date = '$day_date' and ( (visitor_time = '$timeis1' || visitor_time > '$timeis1') && (visitor_time = '$timeis2' || visitor_time < '$timeis2') )");
    $data_site_visitors=mysql_fetch_array($sql_count_site_visitors);
    $VisitorsCount = $data_site_visitors['VisitorsCount'];
    echo "$VisitorsCount,";
    }
    ?>
            ], {
                type: 'bar',
                width: '100',
                barWidth: 5,
                height: '55',
                barColor: '#4b8df8',
                negBarColor: '#e02222'
            }
        );

        $("#sparkline_line").sparkline([
            <?php
    // today per 2 hours Visitors

    $day_date=$pd_current_date;
    for($ii=0;$ii<=24;$ii++) {
    $stepis=$ii+1;
    $timeis1= "$ii:00:00";
    $timeis2= "$stepis:00:00";
    $dys= date('m/d',date(strtotime("+$ii day", strtotime($pd_before_10day_date))));
    $sql_count_site_visitors = mysql_query("SELECT count(visitor_id)  VisitorsCount FROM " . $prefix . "_analytics_visitors where visitor_date = '$day_date' and ( (visitor_time = '$timeis1' || visitor_time > '$timeis1') && (visitor_time = '$timeis2' || visitor_time < '$timeis2') )");
    $data_site_visitors=mysql_fetch_array($sql_count_site_visitors);
    $VisitorsCount = $data_site_visitors['VisitorsCount'];
    echo "$VisitorsCount,";
    }
    ?>
        ], {
            type: 'bar',
            width: '100',
            barWidth: 5,
            height: '55',
            barColor: '#ffb848',
            negBarColor: '#e02222'
        });

        function updatechat() {
            $('#chat_jsdiv').load("template/chat_ajax.php?act=updatechat&lastload=" + $("#lastloadfld").val());
        }

        $(function () {
            updatechat(); //to run on page load
            setInterval(updatechat, 1000);
        });

    </script>
    <script src="assets/scripts/core/app.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/index.js" type="text/javascript"></script>
    <script src="assets/scripts/custom/tasks.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function () {
            App.init(); // initlayout and core plugins
            Index.init();
            Index.initCharts(); // init index page's custom scripts
            Index.initChat();
            Index.initMiniCharts();
            Index.initIntro();
            Tasks.initDashboardWidget();
        });
    </script>
    </body>
    <!-- END BODY -->
    </html>
<?php
require_once("template/page_end.php");
?>