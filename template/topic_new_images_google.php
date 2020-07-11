
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
        <div id="hidtoload">
            <!-- BEGIN FORM-->
            <form action="?wm_section=<?php echo $wm_section; ?>&act=insert&link=google"
                  onsubmit="document.getElementById('hidtoload').style.display='none';document.getElementById('looddiv').style.display='block'"
                  method="post" class="form-horizontal" enctype="multipart/form-data">
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


                    <div class="form-group">
                        <label class="control-label col-md-2"><?php echo $lang_var_admin_426; ?> <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="google_search_for" class="form-control" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2"><?php echo $lang_var_admin_427; ?> <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="google_images_count" class="form-control" value="8" required=""/>
                        </div>
                    </div>


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
        <div id="looddiv" style="padding: 20px;display: none">
            <img src="assets/img/input-spinner.gif"> <?php echo $lang_var_admin_428; ?>...
        </div>
    </div>
    <!-- END VALIDATION STATES-->
</div>
