<?php

require_once("template/page_start.php");
//--------
$id = @$_GET['id'];
$link = @$_GET['link'];
$clicked_btn = @$_POST['clicked_btn'];
$step = @$_GET['step'];
$type = @$_GET['type'];

//-------
$topic_title_en = mysql_real_escape_string(@$_POST['topic_title_en']);
$topic_title_ar = mysql_real_escape_string(@$_POST['topic_title_ar']);

$topic_details_ar = mysql_real_escape_string(@$_POST['topic_details_ar']);
$topic_details_en = mysql_real_escape_string(@$_POST['topic_details_en']);

$cat_id = mysql_real_escape_string(@$_POST['cat_id']);
$cat2_id = mysql_real_escape_string(@$_POST['cat2_id']);
$topic_attach_file = mysql_real_escape_string(@$_POST['topic_attach_file']);
$topic_image_file = mysql_real_escape_string(@$_POST['topic_image_file']);
$file_del = mysql_real_escape_string(@$_POST['file_del']);
$topic_date = mysql_real_escape_string(@$_POST['topic_date']);
if ($topic_date == "") {
    $topic_date = $pd_current_date;
}
for ($ii = 1; $ii <= 6; $ii++) {
    $ws_extra_is = "ws_extra$ii" . "_title";
    $$ws_extra_is = mysql_real_escape_string(@$_POST[$ws_extra_is]);
}

$topic_video_file = mysql_real_escape_string(@$_POST['topic_video_file']);
$up_dir = "../uploads/topics/";
$file_name = @$_FILES['myfile']['name'];
$file_temp_name = @$_FILES['myfile']['tmp_name'];
$file_size = $up_dir . @$_FILES['myfile']['size'];

if ($wm_section != "" && $wm_section != 0 && is_numeric($wm_section)) {

    $sql_get_webmaster_sections = mysql_query("SELECT * FROM " . $prefix . "_webmaster_sections  WHERE ws_id ='$wm_section'");
    $data_get_webmaster_sections = mysql_fetch_array($sql_get_webmaster_sections);
    $ws_title_var = stripcslashes($data_get_webmaster_sections['ws_title_var']);
    $ws_title_var = $$ws_title_var;
    $ws_sections_st = stripcslashes($data_get_webmaster_sections['ws_sections_st']);
    $ws_comments_st = stripcslashes($data_get_webmaster_sections['ws_comments_st']);
    $ws_type = stripcslashes($data_get_webmaster_sections['ws_type']);
    $ws_extra1_title_var = stripcslashes($data_get_webmaster_sections['ws_extra1_title_var']);
    $ws_extra2_title_var = stripcslashes($data_get_webmaster_sections['ws_extra2_title_var']);
    $ws_extra3_title_var = stripcslashes($data_get_webmaster_sections['ws_extra3_title_var']);
    $ws_extra4_title_var = stripcslashes($data_get_webmaster_sections['ws_extra4_title_var']);
    $ws_extra5_title_var = stripcslashes($data_get_webmaster_sections['ws_extra5_title_var']);
    $ws_extra6_title_var = stripcslashes($data_get_webmaster_sections['ws_extra6_title_var']);
    $ws_date_status = stripcslashes($data_get_webmaster_sections['ws_date_status']);
    $ws_longtext_status = stripcslashes($data_get_webmaster_sections['ws_longtext_status']);
    $ws_editor_status = stripcslashes($data_get_webmaster_sections['ws_editor_status']);
    $ws_attachfile_status = stripcslashes($data_get_webmaster_sections['ws_attachfile_status']);
    $ws_multiimages_status = stripcslashes($data_get_webmaster_sections['ws_multiimages_status']);
    $ws_maps_status = stripcslashes($data_get_webmaster_sections['ws_maps_status']);

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
        <link href="assets/plugins/dropzone/css/dropzone.css" rel="stylesheet"/>
        <link href="assets/css/pages/portfolio.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
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
                        <h3 class="page-title"><?php echo $ws_title_var; ?></h3>
                        <ul class="page-breadcrumb breadcrumb">
                            <?php
                            if ($logged_allow_add_status == 1) {
                                ?>
                                <?php
                                if ($act != "new" && $act != "update") {
                                    if ($ws_type == 2) {
                                        ?>
                                        <li class="btn-group">
                                            <button class="btn dropdown-toggle green" data-toggle="dropdown"
                                                    style="min-width: 182px;">
                                                <i class="fa fa-plus"></i> <?php echo $lang_var_admin_94; ?> <i
                                                    class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right" style="min-width: 182px;">
                                                <li>
                                                    <a href="?wm_section=<?php echo $wm_section; ?>&act=new&link=youtube"><i
                                                            class="fa fa-youtube-play"></i> <?php echo $lang_var_admin_120; ?>
                                                    </a>
                                                </li>
                                                <li><a href="?wm_section=<?php echo $wm_section; ?>&act=new"><i
                                                            class="fa fa-upload"></i> <?php echo $lang_var_admin_121; ?>
                                                    </a></li>
                                            </ul>
                                        </li>
                                        <?php

                                    } elseif ($ws_type == 1) {
                                        ?>
                                        <li class="btn-group">
                                            <button class="btn dropdown-toggle green" data-toggle="dropdown"
                                                    style="min-width: 182px;">
                                                <i class="fa fa-plus"></i> <?php echo $lang_var_admin_94; ?> <i
                                                    class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right" style="min-width: 182px;">
                                                <li>
                                                    <a href="?wm_section=<?php echo $wm_section; ?>&act=new&type=single"><i
                                                            class="fa fa-picture-o"></i> <?php echo $lang_var_admin_139; ?>
                                                    </a></li>
                                                <li><a href="?wm_section=<?php echo $wm_section; ?>&act=new"><i
                                                            class="fa fa-upload"></i> <?php echo $lang_var_admin_140; ?>
                                                    </a></li>
													<?php /*/?>
                                                <li>
                                                    <a href="?wm_section=<?php echo $wm_section; ?>&act=new&type=google"><i
                                                            class="fa fa-upload"></i> <?php echo $lang_var_admin_425; ?>
                                                    </a></li>
													<?php /*/?>
                                            </ul>
                                        </li>
                                        <?php

                                    } else {
                                        ?>
                                        <li class="btn-group">
                                            <a href="?wm_section=<?php echo $wm_section; ?>&act=new"><span
                                                    id="sample_editable_1_new"
                                                    class="btn green">
    	<?php echo $lang_var_admin_94; ?> <i class="fa fa-plus"></i>
</span></a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                <?php
                            }
                            ?>
                            <li>
                                <i class="fa fa-home"></i>
                                <a href="index.php"><?php echo $lang_var_admin_35; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="#"><?php echo $ws_title_var; ?></a>
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

                        if ($act == "insert" && $link == "google") {
							/*
							//sa sa
                            $google_search_for = urlencode(mysql_real_escape_string(@$_POST['google_search_for']));
                            $google_images_count = mysql_real_escape_string(@$_POST['google_images_count']);
                            if ($google_images_count < 1) {
                                $google_images_count = 1;
                            }

                            $iinseted = 0;
                            if ($google_images_count <= 8) {
                                $google_size = $google_images_count;
                                $loopi = 1;
                            } else {
                                $google_size = 8;
                                $loopi = round($google_images_count / 8);
                            }

                            for ($i = 0; $i < $loopi; $i++) {
                                $json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=' . $google_search_for . '&start=' . $iinseted . '&rsz=' . $google_size);

                                $data = json_decode($json);
                                foreach ($data->responseData->results as $result) {

                                    $xrand = time() . rand(11, 99);
                                    $f_n = $up_dir . $xrand . $xrand . substr($result->url, -5);

                                    $upload = @file_put_contents("$f_n", file_get_contents($result->url));
                                    if ($upload) {
                                        $topic_image_file = $xrand . $xrand . substr($result->url, -5);
                                        $file_name = mysql_real_escape_string(strip_tags($result->title));

                                        $imgsize = getimagesize($f_n);
                                        $imgwidth = $imgsize[0];
                                        if ($imgwidth > 0) {

                                            $sql_slct_max = mysql_query("select max(topic_id)  from " . $prefix .
                                                "_topics");
                                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                                            $next_topic_id = $data_slct_max[0] + 1;
                                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_topics (
  topic_id,
  topic_title_ar,
  topic_title_en,
  cat_id,
  topic_image_file,
  topic_status,
  edit_by,
  edit_date,
  edit_from,
  wm_section_id,
  topic_date) VALUES ('$next_topic_id','$file_name','$file_name','$cat_id','$topic_image_file','1','$pd_admin_user_id',now(),'$pd_admin_ip','$wm_section','$topic_date')");


                                        } else {
                                            @unlink($f_n);
                                        }
                                    }
                                    $iinseted++;
                                }

                            }
//sa sa
*/
                        } elseif ($act == "insert" && $link == "youtube") {
                            $youtube_links = @$_POST['youtube_links'];
                            $youtube_links = explode("\n", $youtube_links);
                            $youtube_links = array_filter($youtube_links, 'trim'); // remove any extra \r characters left behind
                            foreach ($youtube_links as $line) {

                                if (preg_match('@^(?:https://(?:www\.)?youtube.com/)(watch\?v=|v/)([a-zA-Z0-9_]*)@', $line, $match)) {


                                    $ylink = trim(getYouTubeID($line));
                                    $url = "https://www.youtube.com/watch?v=$ylink";// youtube video url
                                    $yytt = (get_youtube($url));
                                    $vv_title = $yytt['title'];
                                    $video_length = "";


                                    $this_img = "http://img.youtube.com/vi/$ylink/0.jpg";
                                    $xrand = time() . rand(11, 99);
                                    $f_n = $up_dir . $xrand . ".jpg";
                                    $topic_image_file = "";
                                    $upload = file_put_contents("$f_n", file_get_contents($this_img));
                                    if ($upload) {
                                        $topic_image_file = $xrand . ".jpg";
                                    }


                                    $sql_slct_max = mysql_query("select max(topic_id)  from " . $prefix .
                                        "_topics");
                                    $data_slct_max = mysql_fetch_array($sql_slct_max);
                                    $next_topic_id = $data_slct_max[0] + 1;
									$video_description ="";
                                    $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_topics (
  topic_id,
  topic_title_ar,
  topic_title_en, 
  topic_details_ar,
  topic_details_en,   
  cat_id,
  topic_image_file,
  topic_status,
  edit_by,  
  edit_date,
  edit_from,
  wm_section_id,
  topic_date,
  topic_video_file,
  topic_video_length,
  topic_video_type,
  topic_attach_file) VALUES ('$next_topic_id','$vv_title','$vv_title','$video_description','$video_description','$cat_id','$topic_image_file','1','$pd_admin_user_id',now(),'$pd_admin_ip','$wm_section','$topic_date','$ylink','$video_length','1','$topic_attach_file')");

                                    // insert notification
                                    $note_title_ar = ($lang_var_admin_381 . " " . $vv_title);
                                    $note_title_en = ($lang_var_admin_382 . " " . $vv_title);
                                    $note_icon = mysql_real_escape_string("<div class='label label-sm label-danger'>
                            <i class='fa fa-youtube'></i>
                        </div>");
                                    $note_url = mysql_real_escape_string("topics.php?wm_section=$wm_section&id=$next_topic_id&act=update");

                                    require_once("template/notifications_insert.php");
                                    // end of insert notification

                                }
                            }
                        } elseif ($act == "insert" && ($topic_title_ar != "" || $topic_title_en != "")) {
                            // --- upload
                            $topic_image_file = "";
                            if ($file_name != "") {
                                $ext = strrchr($file_name, ".");
                                $ext = strtolower($ext);
                                $xrand = time() . rand(11, 99);
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
                                            $topic_image_file = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $sql_slct_max = mysql_query("select max(topic_id)  from " . $prefix .
                                "_topics");
                            $data_slct_max = mysql_fetch_array($sql_slct_max);
                            $next_topic_id = $data_slct_max[0] + 1;
                            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_topics (
  topic_id,
  topic_title_ar,
  topic_title_en,
  topic_details_ar,
  topic_details_en,  
  cat_id,
  topic_image_file,
  topic_status,
  edit_by,  
  edit_date,
  edit_from,
  wm_section_id,
  topic_extra1,
  topic_extra2,
  topic_extra3,
  topic_extra4,
  topic_extra5,
  topic_extra6,
  topic_date,
  topic_video_file,
  topic_attach_file,
  cat2_id) VALUES ('$next_topic_id','$topic_title_ar','$topic_title_en','$topic_details_ar','$topic_details_en','$cat_id','$topic_image_file','1','$pd_admin_user_id',now(),'$pd_admin_ip','$wm_section','$ws_extra1_title','$ws_extra2_title','$ws_extra3_title','$ws_extra4_title','$ws_extra5_title','$ws_extra6_title','$topic_date','$topic_video_file','$topic_attach_file','$cat2_id')");

                            if ($sql_insert_new) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_381 . " " . $topic_title_ar);
                                $note_title_en = ($lang_var_admin_382 . " " . $topic_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-success'>
                            <i class='fa fa-plus'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("topics.php?wm_section=$wm_section&id=$next_topic_id&act=update");

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
                        if ($act == "saveupdate" && ($topic_title_ar != "" || $topic_title_en != "") && $id != "") {

                            // --- upload
                            if ($file_del == 1) {
                                @unlink("$up_dir" . "$topic_image_file");
                                $topic_image_file = "";
                            }
                            if ($file_name != "") {
                                if ($topic_image_file != "") {
                                    @unlink("$up_dir" . "$topic_image_file");
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
                                            $topic_image_file = $xrand . $ext;
                                        }
                                    }
                                }
                            }

                            $sql_update = mysql_query("UPDATE " . $prefix . "_topics SET topic_title_ar='$topic_title_ar',topic_title_en='$topic_title_en',cat_id='$cat_id',topic_image_file='$topic_image_file',edit_by='$pd_admin_user_id',edit_date=now(),edit_from='$pd_admin_ip',topic_details_ar='$topic_details_ar',topic_details_en='$topic_details_en',topic_extra1='$ws_extra1_title',topic_extra2='$ws_extra2_title',topic_extra3='$ws_extra3_title',topic_extra4='$ws_extra4_title',topic_extra5='$ws_extra5_title',topic_extra6='$ws_extra6_title',topic_date='$topic_date',topic_video_file='$topic_video_file',topic_attach_file='$topic_attach_file', cat2_id='$cat2_id' WHERE topic_id='$id'") or
                            die(mysql_error());

                            if ($sql_update) {

                                // insert notification
                                $note_title_ar = ($lang_var_admin_387 . " " . $topic_title_ar);
                                $note_title_en = ($lang_var_admin_388 . " " . $topic_title_en);
                                $note_icon = mysql_real_escape_string("<div class='label label-sm label-info'>
                            <i class='fa fa-pencil-square-o'></i>
                        </div>");
                                $note_url = mysql_real_escape_string("topics.php?wm_section=$wm_section&id=$id&act=update");

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

                            $act = "update";
                        }

                        if ($act == "update") {
                            if ($ws_type == 3) {
                                @ require_once("template/topic_update_audio.php");
                            } elseif ($ws_type == 2) {
                                @ require_once("template/topic_update_videos.php");
                            } elseif ($ws_type == 1) {
                                @ require_once("template/topic_update_pages.php");
                            } else {
                                @ require_once("template/topic_update_pages.php");
                            }
                        } elseif ($act == "new") {
							
                            if ($ws_type == 3) {
                                @ require_once("template/topic_new_audio.php");
                            } elseif ($ws_type == 2) {
                                @ require_once("template/topic_new_videos.php");
                            } elseif ($ws_type == 1) {
                                if ($type == "single") {
                                    @ require_once("template/topic_new_pages.php");
                                } else if ($type == "google") {
                                   // @ require_once("template/topic_new_images_google.php");
                                } else {
                                    @ require_once("template/topic_new_images.php");
                                }
                            } else {
                                @ require_once("template/topic_new_pages.php");
                            }

                        } else {

                            /*if($ws_type==3){
                                @ require_once ("template/topic_view_audio.php");
                            }elseif($ws_type==2){
                                @ require_once ("template/topic_view_videos.php");
                            }elseif($ws_type==1){
                                @ require_once ("template/topic_view_images.php");
                            }else{*/
                            @ require_once("template/topic_view_pages.php");
//}  
                            ?>
                            <a class="mix-preview fancybox-button" data-rel="fancybox-button"></a>
                            <?php
                        }
                        ?>

                        <?php
                        //   ----------- PAGE END


                        $nosrtt_clmn = "5";
                        if ($ws_date_status == 1) {
                            $nosrtt_clmn = "6";
                        }

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
    <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="assets/plugins/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="assets/scripts/custom/tinymce.js"></script>

    <link type="text/css" rel="stylesheet"
          href="assets/plugins/tinymce/plugins/moxiemanager/skins/lightgray/skin.min.css"/>
    <script src="assets/plugins/tinymce/plugins/moxiemanager/js/moxman.api.min.js"></script>
    <script src="assets/plugins/tinymce/plugins/moxiemanager/api.php?action=PluginJs"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/scripts/core/app.js"></script>
    <script src="assets/scripts/custom/table-managed.js"></script>

    <script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
            type="text/javascript"></script>
    <script src="assets/plugins/dropzone/dropzone.js"></script>
    <script src="assets/scripts/custom/form-dropzone.js"></script>

    <script type="text/javascript" src="assets/plugins/jquery-mixitup/jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="assets/scripts/custom/portfolio.js"></script>

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
                        "sAjaxSource": "template/topic_view_pages_ajax.php?wm_section=<?php echo $wm_section; ?>&lang=<?php echo $lang; ?>&var_admin_6=<?php echo $lang_var_admin_6; ?>&var_admin_25=<?php echo $lang_var_admin_25; ?>&logged_allow_edit_status=<?php echo $logged_allow_edit_status; ?>", // ajax source
                        "aaSorting": [[1, "desc"]], // set first column as a default sort by asc
                        "aoColumnDefs": [{
                            'bSortable': false,
                            'aTargets': [0, <?php echo $nosrtt_clmn; ?>]
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
            FormDropzone.init();
            TableAjax.init();
            Portfolio.init();
            UIAlertDialogApi.init();

        });
    </script>

    <?php
    if ($act == "update" && $ws_maps_status == 1) {
        ?>
        <script type="text/javascript" src="//maps.google.com/maps/api/js?key=AIzaSyAgzruFTTvea0LEmw_jAqknqskKDuJK7dM&sensor=false"></script>
        <script type="text/javascript" src="assets/scripts/custom/markerwithlabel_packed.js"></script>
        <script type="text/javascript" src="assets/scripts/custom/markerclusterer_packed.js"></script>
        <script type="text/javascript" src="assets/scripts/custom/custom-map.js"></script>

        <script>
            var _latitude = <?php echo $gmap_latitude; ?>;
            var _longitude = <?php echo $gmap_longitude; ?>;
            google.maps.event.addDomListener(window, 'load', initSubmitMap(_latitude, _longitude));
            function initSubmitMap(_latitude, _longitude) {
                var mapCenter = new google.maps.LatLng(_latitude, _longitude);
                var mapOptions = {
                    zoom: 11,
                    center: mapCenter,
                    disableDefaultUI: false
                };
                var mapElement = document.getElementById('submit-map');
                var map = new google.maps.Map(mapElement, mapOptions);
                var marker = new MarkerWithLabel({
                    position: mapCenter,
                    map: map,
                    icon: 'assets/img/marker.png',
                    labelAnchor: new google.maps.Point(50, 0),
                    draggable: true
                });
                google.maps.event.addListener(marker, 'drag', function (event) {
                    document.getElementById("map_latitude").value = event.latLng.lat();
                    document.getElementById("map_longitude").value = event.latLng.lng();
                });
                $('#submit-map').removeClass('fade-map');


            }

            function success(position) {
                initSubmitMap(position.coords.latitude, position.coords.longitude);
                document.getElementById("map_latitude").value = position.coords.latitude;
                document.getElementById("map_longitude").value = position.coords.longitude;
            }

            $('.geo-location').on("click", function () {
                if (navigator.geolocation) {
                    $('#submit-map').addClass('fade-map');
                    navigator.geolocation.getCurrentPosition(success);
                } else {
                    error('Geo Location is not supported');
                }
            });


            <?php
            if (@$map_act != "edit") {
            ?>
            if (navigator.geolocation) {
                $('#submit-map').addClass('fade-map');
                navigator.geolocation.getCurrentPosition(success);
            } else {
                error('Geo Location is not supported');
            }
            <?php } ?>

        </script>
        <?php
    }
    ?>
    </body>
    <!-- END BODY -->
    </html>
    <?php
} else {
    header("Location: index.php");
    exit();
}
require_once("template/page_end.php");
?>