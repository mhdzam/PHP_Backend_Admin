<?php

if (!empty($_FILES)) {
    require_once("../../includes/connection.php");
    require_once("functions.php");
    require_once("lang.php");

    $wm_section = @$_GET['wm_section'];
//--------
    $topic_title_en = mysql_real_escape_string(@$_POST['topic_title_en']);
    $topic_title_ar = mysql_real_escape_string(@$_POST['topic_title_ar']);

    $cat_id = mysql_real_escape_string(@$_POST['cat_id']);

    $topic_date = mysql_real_escape_string(@$_POST['topic_date']);
    if ($topic_date == "") {
        $topic_date = $pd_current_date;
    }
    $up_dir = "../../uploads/topics/";
    $file_name = @$_FILES['file']['name'];
    $file_temp_name = @$_FILES['file']['tmp_name'];
    $file_size = $up_dir . @$_FILES['file']['size'];

    $topic_image_file = "";
    if ($file_name != "") {
        $ext = strrchr($file_name, ".");
        $ext = strtolower($ext);
        $xrand = time() . rand(11, 99);
        $file_name = $up_dir . $xrand . $ext;
        if (in_array($ext, $allowed_imgs_type)) {

            list($tmp_file_width, $tmp_file_height) = @getimagesize($file_temp_name);
            if ($tmp_file_width > 0 && $tmp_file_height > 0) {
                if (move_uploaded_file($file_temp_name, $file_name)) {
                    $topic_image_file = $xrand . $ext;


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
  topic_date) VALUES ('$next_topic_id','$topic_title_ar','$topic_title_en','$cat_id','$topic_image_file','1','$pd_admin_user_id',now(),'$pd_admin_ip','$wm_section','$topic_date')");

                }
            }
        }
    }
}
?>