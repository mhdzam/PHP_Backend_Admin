<?php

$seoact_act = @$_GET['seoact'];

$seo_title_ar = mysql_real_escape_string(@$_POST['seo_title_ar']);
$seo_title_en = mysql_real_escape_string(@$_POST['seo_title_en']);
$seo_details_ar = mysql_real_escape_string(@$_POST['seo_details_ar']);
$seo_details_en = mysql_real_escape_string(@$_POST['seo_details_en']);
$seo_keywords_ar = mysql_real_escape_string(@$_POST['seo_keywords_ar']);
$seo_keywords_en = mysql_real_escape_string(@$_POST['seo_keywords_en']);

if ($seoact_act == "save" && $seo_title_ar != "" && $id != "") {

    $sql_update = mysql_query("UPDATE " . $prefix . "_shop_items SET seo_title_ar='$seo_title_ar',seo_title_en='$seo_title_en',seo_details_ar='$seo_details_ar',seo_details_en='$seo_details_en',seo_keywords_ar='$seo_keywords_ar',seo_keywords_en='$seo_keywords_en'  WHERE item_id='$id'") or
    die(mysql_error());

    if ($sql_update) {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <?php echo $lang_var_admin_25; ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <?php echo $lang_var_admin_26; ?>
        </div>
        <?php
    }

}

$sql_modify_seo = mysql_query("SELECT * FROM " . $prefix . "_shop_items  WHERE item_id='$id' ");
$data_modify_seo = mysql_fetch_array($sql_modify_seo);

$seo_title_ar = stripcslashes($data_modify_seo['seo_title_ar']);
$seo_title_en = stripcslashes($data_modify_seo['seo_title_en']);
$seo_details_ar = stripcslashes($data_modify_seo['seo_details_ar']);
$seo_details_en = stripcslashes($data_modify_seo['seo_details_en']);
$seo_keywords_ar = stripcslashes($data_modify_seo['seo_keywords_ar']);
$seo_keywords_en = stripcslashes($data_modify_seo['seo_keywords_en']);
?>

<div>
    <!-- BEGIN FORM-->
    <form action="?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=update&seoact=save#portlet_tab4"
          method="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="form-body">
            <?php if ($site_ar_box_status != 0) { ?>
            <div class="form-group">
                <label
                    class="control-label col-md-2"><?php echo $lang_var_admin_192; ?> <?php echo $ar_lang_icon; ?></label>

                <div class="col-md-9" dir="rtl">
                    <input type="text" name="seo_title_ar"  maxlength="65" class="form-control" value="<?php echo $seo_title_ar; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label
                    class="control-label col-md-2"><?php echo $lang_var_admin_193; ?> <?php echo $ar_lang_icon; ?></label>

                <div class="col-md-9" dir="rtl">
                    <textarea name="seo_details_ar" rows="3"  maxlength="165"
                              class="form-control"><?php echo $seo_details_ar; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label
                    class="control-label col-md-2"><?php echo $lang_var_admin_194; ?> <?php echo $ar_lang_icon; ?></label>

                <div class="col-md-9" dir="rtl">
                    <textarea name="seo_keywords_ar" rows="4"
                              class="form-control"><?php echo $seo_keywords_ar; ?></textarea>
                </div>
            </div>

                <?php
            }
            ?>
            <?php if ($site_en_box_status != 0) { ?>
            <div class="form-group">
                <label
                    class="control-label col-md-2"><?php echo $lang_var_admin_192; ?> <?php echo $en_lang_icon; ?></label>

                <div class="col-md-9" dir="ltr">
                    <input type="text" name="seo_title_en" maxlength="65" class="form-control" value="<?php echo $seo_title_en; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label
                    class="control-label col-md-2"><?php echo $lang_var_admin_193; ?> <?php echo $en_lang_icon; ?></label>

                <div class="col-md-9" dir="ltr">
                    <textarea name="seo_details_en" rows="3"  maxlength="165"
                              class="form-control"><?php echo $seo_details_en; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label
                    class="control-label col-md-2"><?php echo $lang_var_admin_194; ?> <?php echo $en_lang_icon; ?></label>

                <div class="col-md-9" dir="ltr">
                    <textarea name="seo_keywords_en" rows="4"
                              class="form-control"><?php echo $seo_keywords_en; ?></textarea>
                </div>
            </div>
                <?php
            }
            ?>
            <div class="form-actions fluid">
                <div class="col-md-offset-2 col-md-9">
                    <button type="submit" class="btn green"><?php echo $lang_var_admin_21; ?></button>
                    &nbsp;
                </div>
            </div>

            <!-- END FORM-->
        </div>
    </form>

</div>