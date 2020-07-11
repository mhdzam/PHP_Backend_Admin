<?php
if ($step != 2) {
    ?>

    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-plus"></i> <?php echo $lang_var_admin_23 . " " . $ws_title_var; ?>
            </div>
            <div class="tools">
                <a href="?wm_section=<?php echo $wm_section; ?>" class="close"></a>

            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="?wm_section=<?php echo $wm_section; ?>&act=new&step=2" method="post" class="form-horizontal"
                  enctype="multipart/form-data">
                <div class="form-body">

                    <?php if ($ws_sections_st != 0) { ?>
                        <div class="form-group">
                            <label class="control-label col-md-2"><?php echo $lang_var_admin_99; ?> <span
                                    class="required">*</span></label>

                            <div class="col-md-9">
                                <select class="form-control" name="cat_id" class="select2me" required>
                                    <option value=""><?php echo $lang_var_admin_100; ?>...</option>
                                    <?php
                                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_sections where wm_section_id='$wm_section' and father_id='0' order by row_no, section_id");
                                    while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                        if ($lang == "ar") {
                                            $section_title = $data_father_retrive['section_title_ar'];
                                        } else {
                                            $section_title = $data_father_retrive['section_title_en'];
                                        }
                                        $sql_subsection_retrive = mysql_query("SELECT * FROM " . $prefix . "_sections where wm_section_id='$wm_section' and father_id='$data_father_retrive[section_id]' order by row_no, section_id");
                                        $subsection_count = mysql_num_rows($sql_subsection_retrive);
                                        $disabld_sec = "";
                                        if ($subsection_count > 0) {
                                            $disabld_sec = "disabled";
                                        }
                                        ?>
                                        <option <?php echo $disabld_sec; ?>
                                            value="<?php echo $data_father_retrive['section_id']; ?>"><?php echo $section_title; ?></option>
                                        <?php
                                        while ($data_subsection_retrive = mysql_fetch_array($sql_subsection_retrive)) {
                                            if ($lang == "ar") {
                                                $section_title = $data_subsection_retrive['section_title_ar'];
                                            } else {
                                                $section_title = $data_subsection_retrive['section_title_en'];
                                            }
                                            ?>
                                            <option value="<?php echo $data_subsection_retrive['section_id']; ?>">
                                                &nbsp; &nbsp; - <?php echo $section_title; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($site_ar_box_status != 0) { ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-2"><?php echo $lang_var_admin_102; ?>  <?php echo $ar_lang_icon; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <input type="text" name="topic_title_ar" dir="rtl" class="form-control" required=""/>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($site_en_box_status != 0) { ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-2"><?php echo $lang_var_admin_102; ?>  <?php echo $en_lang_icon; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <input type="text" name="topic_title_en" dir="ltr" class="form-control" required=""/>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="form-actions fluid">
                    <div class="col-md-offset-2 col-md-9">
                        <button type="submit" class="btn green"><?php echo $lang_var_admin_141; ?></button>
                        &nbsp;
                        <a href="?wm_section=<?php echo $wm_section; ?>">
                            <button type="button" class="btn default"><?php echo $lang_var_admin_22; ?></button>
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

    $topic_section_is = "";
    if ($ws_sections_st != 0) {
        $sql_section = mysql_query("SELECT * FROM " . $prefix . "_sections where wm_section_id='$wm_section' and section_id ='$cat_id'");
        $data_section = mysql_fetch_array($sql_section);
        $sc_nme = stripcslashes($data_section['section_title_' . $lang]);
        $topic_section_is = "$sc_nme";
    }

    ?>
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-plus"></i> <?php echo $lang_var_admin_23 . " " . $ws_title_var; ?>
            </div>
            <div class="tools">
                <a href="?wm_section=<?php echo $wm_section; ?>" class="close"></a>

            </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->

            <div style="padding: 5px;">
                <?php if ($ws_sections_st != 0) { ?>
                    <span class="required"><?php echo $lang_var_admin_99; ?></span> &nbsp; :&nbsp;
                    <strong><?php echo $topic_section_is; ?></strong>
                    <br/>
                <?php } ?>
                <span class="required"><?php echo $lang_var_admin_102; ?></span> :&nbsp;
                <strong><?php echo $topic_title_ar; ?></strong>
                <br/>
                <span class="required"><?php echo $lang_var_admin_102; ?></span> :&nbsp;
                <strong><?php echo $topic_title_en; ?></strong>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="template/topic_new_images_upload.php?wm_section=<?php echo $wm_section; ?>"
                          class="dropzone" id="my-dropzone">
                        <?php if ($ws_sections_st != 0) { ?>
                            <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>"/>
                        <?php } ?>
                        <input type="hidden" name="topic_title_ar" value="<?php echo $topic_title_ar; ?>"/>
                        <input type="hidden" name="topic_title_en" value="<?php echo $topic_title_en; ?>"/>
                    </form>
                </div>
            </div>

        </div>
    </div> <a href="?wm_section=<?php echo $wm_section; ?>">
        <button type="button" class="btn green"><?php echo $lang_var_admin_142; ?></button>
    </a>
    <a href="?wm_section=<?php echo $wm_section; ?>">
        <button type="button" class="btn default"><?php echo $lang_var_admin_22; ?></button>
    </a>
    <?php
}
?>                        