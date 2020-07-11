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
        <?php if ($link == "youtube") { ?>
            <form action="?wm_section=<?php echo $wm_section; ?>&act=insert&link=youtube" method="post"
                  class="form-horizontal" enctype="multipart/form-data">
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
                        <label class="control-label col-md-2"><?php echo $lang_var_admin_122; ?> <span class="required">*</span></label>

                        <div class="col-md-9">
                            <textarea name="youtube_links" rows="10" dir="ltr" class="form-control"></textarea>
                            <span class="help-block"><?php echo $lang_var_admin_123; ?></span>
                        </div>
                    </div>
                    <div class="form-actions fluid">
                        <div class="col-md-offset-2 col-md-9">
                            <button type="submit" class="btn green"><?php echo $lang_var_admin_23; ?></button>
                            &nbsp;
                            <a href="?wm_section=<?php echo $wm_section; ?>">
                                <button type="button" class="btn default"><?php echo $lang_var_admin_22; ?></button>
                            </a>
                        </div>
                    </div>
            </form>

        <?php } else { ?>
            <form action="?wm_section=<?php echo $wm_section; ?>&act=insert" method="post" class="form-horizontal"
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

                    <?php
                    if ($ws_date_status == 1) {
                        ?>
                        <div class="form-group">
                            <label class="control-label col-md-2"><?php echo $lang_var_admin_101; ?> <span
                                    class="required">*</span></label>

                            <div class="col-md-9">
                                <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control" value="<?php echo $pd_current_date; ?>"
                                           name="topic_date" readonly>
				<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
				</span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <?php if ($site_ar_box_status != 0) { ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-2"><?php echo $lang_var_admin_102; ?>  <?php echo $ar_lang_icon; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <input type="text" name="topic_title_ar" dir="rtl" class="form-control" required=""/>
                            </div>
                        </div>
                        <?php
                        if ($ws_longtext_status == 1) {
                            $ws_editor_cls = "";
                            $ws_editor_rws = 5;
                            if ($ws_editor_status == 1) {
                                $ws_editor_cls = "tinymce_rtl";
                                $ws_editor_rws = 15;
                            }
                            ?>
                            <div class="form-group">
                                <label
                                    class="control-label col-md-2"><?php echo $lang_var_admin_103; ?>  <?php echo $ar_lang_icon; ?>
                                    <span class="required">*</span></label>

                                <div class="col-md-9" dir="ltr">
                                    <textarea name="topic_details_ar" dir="rtl" rows="<?php echo $ws_editor_rws; ?>"
                                              class="form-control <?php echo $ws_editor_cls; ?>"></textarea>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                    }
                    ?>
                    <?php if ($site_en_box_status != 0) { ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-2"><?php echo $lang_var_admin_102; ?>  <?php echo $en_lang_icon; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <input type="text" name="topic_title_en" dir="ltr" class="form-control" required=""/>
                            </div>
                        </div>
                        <?php
                        if ($ws_longtext_status == 1) {
                            $ws_editor_cls = "";
                            $ws_editor_rws = 5;
                            if ($ws_editor_status == 1) {
                                $ws_editor_cls = "tinymce_ltr";
                                $ws_editor_rws = 15;
                            }
                            ?>
                            <div class="form-group">
                                <label
                                    class="control-label col-md-2"><?php echo $lang_var_admin_103; ?>  <?php echo $en_lang_icon; ?>
                                    <span class="required">*</span></label>

                                <div class="col-md-9" dir="ltr">
                                    <textarea name="topic_details_en" dir="ltr" rows="<?php echo $ws_editor_rws; ?>"
                                              class="form-control <?php echo $ws_editor_cls; ?>"></textarea>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                    }
                    ?>

                    <?php
                    for ($ii = 1; $ii <= 6; $ii++) {
                        $ws_extra_is = "ws_extra$ii" . "_title_var";
                        $ws_extra_is = $$ws_extra_is;
                        if ($ws_extra_is != "" && $ws_extra_is != "0" && $ws_extra_is != " ") { ?>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo @$$ws_extra_is; ?> </label>

                                <div class="col-md-9">
                                    <input type="text" name="ws_extra1_title" class="form-control"/>
                                </div>
                            </div>
                        <?php }
                    } ?>

                    <div class="form-group">
                        <label class="control-label col-md-2"><?php echo $lang_var_admin_117; ?> <span class="required">*</span></label>

                        <div class="col-md-9">

                            <div class="input-group input-medium">
                                <input name="topic_video_file" readonly type="text" id="topic_video_file" dir="ltr"
                                       class="form-control input-large" required="">
                
				<span class="input-group-btn">
					<a href="javascript:;"
                       onclick="moxman.browse({fields: 'topic_video_file', extensions:'mp4,ogv,webm', no_host: true});"
                       class="btn default"><?php echo $lang_var_admin_206; ?></a>
				</span>
                <span class="input-group-btn">
                <a href="javascript:;" onclick="document.getElementById('topic_video_file').value=''"
                   class="btn default">&nbsp;<i class="fa fa-times"></i>&nbsp;</a>
                </span>
                            </div>
                            <span class="help-block">e.g: .mp4, .ogv, .webm</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2"><?php echo $lang_var_admin_118; ?> </label>

                        <div class="col-md-9">
                            <input type="file" name="myfile" class="form-control"/>
                            <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>

                        </div>
                    </div>


                </div>
                <div class="form-actions fluid">
                    <div class="col-md-offset-2 col-md-9">
                        <button type="submit" class="btn green"><?php echo $lang_var_admin_23; ?></button>
                        &nbsp;
                        <a href="?wm_section=<?php echo $wm_section; ?>">
                            <button type="button" class="btn default"><?php echo $lang_var_admin_22; ?></button>
                        </a>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
        <!-- END FORM-->
    </div>
    <!-- END VALIDATION STATES-->
</div>