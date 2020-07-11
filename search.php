<?php
require_once("template/page_start.php");
$q_search_word = mysql_real_escape_string(@$_POST['q']);
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
                        <h3 class="page-title"><?php echo $lang_var_admin_280; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $lang_var_admin_280; ?></a>
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
                        <div>
                            <div class="row search-form-default">
                                <div class="col-md-12">
                                    <form class="form-inline" action="search.php" method="POST">
                                        <div class="input-group">
                                            <div class="input-cont">
                                                <input type="text" name="q"
                                                       placeholder="<?php echo $lang_var_admin_111; ?>..."
                                                       value="<?php echo $q_search_word; ?>" class="form-control"/>
                                            </div>
												<span class="input-group-btn">
													<button type="submit" class="btn green">
                                                        <?php echo $lang_var_admin_111; ?> &nbsp; <i
                                                            class="m-icon-swap<?php echo $site_lang_align_left; ?> m-icon-white"></i>
                                                    </button>
												</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br/>

                            <?php
                            if ($q_search_word != "" && $q_search_word != "%") {
                                $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
                                    "_topics where
    ( topic_id='$q_search_word' OR topic_title_ar like '%$q_search_word%' OR  topic_title_en like '%$q_search_word%' OR topic_details_ar like '%$q_search_word%' OR topic_details_en like '%$q_search_word%' OR topic_extra1 like '%$q_search_word%'  OR topic_extra2 like '%$q_search_word%' OR topic_extra3 like '%$q_search_word%' OR topic_extra4 like '%$q_search_word%' OR topic_extra5 like '%$q_search_word%' OR topic_extra6 like '%$q_search_word%')
    order by edit_date desc");
                                $page_records_count = mysql_num_rows($sql_retrive);
                                if ($page_records_count > 0) {
                                    while ($data_retrive = mysql_fetch_array($sql_retrive)) {
                                        $sub_desc = substr(strip_tags(stripcslashes($data_retrive['topic_details_' . $lang])), 0, 400);
                                        ?>

                                        <div class="search-classic">

                                            <h4>
                                                <a href="topics.php?wm_section=<?php echo $data_retrive['wm_section_id']; ?>&id=<?php echo $data_retrive['topic_id']; ?>&act=update">
                                                    <?php echo stripcslashes($data_retrive['topic_title_' . $lang]); ?>
                                                </a>
                                            </h4>
                                            <?php if ($sub_desc != "") { ?>
                                                <p><?php echo $sub_desc; ?>..</p>
                                            <?php } ?>
                                        </div>
                                        <hr/>
                                        <?php
                                    }
                                }
                            }
                            ?>

                        </div>

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
    <script src="assets/scripts/core/app.js"></script>
    <script>
        jQuery(document).ready(function () {
            App.init();
        });
    </script>
    </body>
    <!-- END BODY -->
    </html>
<?php
require_once("template/page_end.php");
?>