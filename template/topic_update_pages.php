<?php
$sql_modify = mysql_query("SELECT * FROM " . $prefix . "_topics  WHERE wm_section_id ='$wm_section' AND topic_id='$id' ");
$data_modify = mysql_fetch_array($sql_modify);

$topic_title_ar = stripcslashes($data_modify['topic_title_ar']);
$topic_title_en = stripcslashes($data_modify['topic_title_en']);
$topic_details_ar = stripcslashes($data_modify['topic_details_ar']);
$topic_details_en = stripcslashes($data_modify['topic_details_en']);
$cat_id = stripcslashes($data_modify['cat_id']);
$cat2_id = stripcslashes($data_modify['cat2_id']);
$topic_image_file = stripcslashes($data_modify['topic_image_file']);
$topic_status = stripcslashes($data_modify['topic_status']);
$topic_extra1 = stripcslashes($data_modify['topic_extra1']);
$topic_extra2 = stripcslashes($data_modify['topic_extra2']);
$topic_extra3 = stripcslashes($data_modify['topic_extra3']);
$topic_extra4 = stripcslashes($data_modify['topic_extra4']);
$topic_extra5 = stripcslashes($data_modify['topic_extra5']);
$topic_extra6 = stripcslashes($data_modify['topic_extra6']);
$topic_date = stripcslashes($data_modify['topic_date']);
$topic_attach_file = stripcslashes($data_modify['topic_attach_file']);

$edit_date = $data_modify['edit_date'];
$edit_by = GetAdminUserName($data_modify['edit_by']);
$edit_from = $data_modify['edit_from'];


?>

<div class="portlet box blue tabbable">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-plus"></i> <?php echo $lang_var_admin_6 . " " . $ws_title_var; ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class=" portlet-tabs">
            <ul class="nav nav-tabs">
                <?php if ($site_seo_status == 1) { ?>
                    <li class="">
                        <a href="#portlet_tab4" data-toggle="tab">
                            <i class="fa fa-search"></i> <?php echo $lang_var_admin_189; ?>
                        </a>
                    </li>
                <?php }
                if ($ws_maps_status == 1) { ?>
                    <li class="">
                        <a href="#portlet_tab3" data-toggle="tab">
                            <i class="fa fa-map-marker"></i> <?php echo $lang_var_admin_188; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($ws_multiimages_status == 1) { ?>
                    <li class="">
                        <a href="#portlet_tab2" data-toggle="tab">
                            <i class="fa fa-picture-o"></i> <?php echo $lang_var_admin_187; ?>
                        </a>
                    </li>
                <?php } ?>

                <li class="active">
                    <a href="#portlet_tab1" data-toggle="tab">
                        <i class="fa fa-pencil-square-o"></i> <?php echo $lang_var_admin_186; ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="portlet_tab1">

                    <div>
                        <!-- BEGIN FORM-->
                        <form action="?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=saveupdate"
                              method="post" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-body">

                                <?php if ($ws_sections_st != 0) { ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-2"><?php echo $lang_var_admin_99; ?> <span
                                                class="required">*</span></label>

                                        <div class="col-md-10">
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
                                                        value="<?php echo $data_father_retrive['section_id']; ?>" <?php if ($cat_id == $data_father_retrive['section_id']) {
                                                        echo "selected='selected'";
                                                    } ?> ><?php echo $section_title; ?></option>
                                                    <?php
                                                    while ($data_subsection_retrive = mysql_fetch_array($sql_subsection_retrive)) {
                                                        if ($lang == "ar") {
                                                            $section_title = $data_subsection_retrive['section_title_ar'];
                                                        } else {
                                                            $section_title = $data_subsection_retrive['section_title_en'];
                                                        }
                                                        ?>
                                                        <option
                                                            value="<?php echo $data_subsection_retrive['section_id']; ?>" <?php if ($cat_id == $data_subsection_retrive['section_id']) {
                                                            echo "selected='selected'";
                                                        } ?>> &nbsp; &nbsp; - <?php echo $section_title; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>


                                <?php if ($wm_section == 2) { ?>
                                    <div class="form-group">
									<?php /*/ ?>
                                        <label class="control-label col-md-2"><?php echo $lang_var_admin_510; ?> <span
                                                class="required">*</span></label>

                                        <div class="col-md-10">
										
                                            <select class="form-control" name="cat2_id" class="select2me" required>
                                                <?php
                                                $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_places order by row_no, place_id");
                                                while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                                    if ($lang == "ar") {
                                                        $section_title = $data_father_retrive['place_title_ar'];
                                                    } else {
                                                        $section_title = $data_father_retrive['place_title_en'];
                                                    }
                                                    ?>
                                                    <option <?php if ($cat2_id == $data_father_retrive['place_id']) {
                                                        echo "selected='selected'";
                                                    } ?>
                                                        value="<?php echo $data_father_retrive['place_id']; ?>"><?php echo $section_title; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
											
                                        </div>
										<?php /*/ ?>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($ws_date_status == 1) {
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-2"><?php echo $lang_var_admin_101; ?> <span
                                                class="required">*</span></label>

                                        <div class="col-md-10">
                                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control"
                                                       value="<?php echo $topic_date; ?>" name="topic_date" readonly>
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

                                        <div class="col-md-10">
                                            <input type="text" name="topic_title_ar" dir="rtl" class="form-control"
                                                   value="<?php echo $topic_title_ar; ?>" required=""/>
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

                                            <div class="col-md-10" dir="ltr">
                                                <textarea name="topic_details_ar" dir="rtl"
                                                          rows="<?php echo $ws_editor_rws; ?>"
                                                          class="form-control <?php echo $ws_editor_cls; ?>"><?php echo $topic_details_ar; ?></textarea>
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

                                        <div class="col-md-10">
                                            <input type="text" name="topic_title_en" dir="ltr" class="form-control"
                                                   value="<?php echo $topic_title_en; ?>" required=""/>
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

                                            <div class="col-md-10" dir="ltr">
                                                <textarea name="topic_details_en" dir="ltr"
                                                          rows="<?php echo $ws_editor_rws; ?>"
                                                          class="form-control <?php echo $ws_editor_cls; ?>"><?php echo $topic_details_en; ?></textarea>
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
                                    $ws_extra_dta = "topic_extra$ii";
                                    if ($ws_extra_is != "" && $ws_extra_is != "0" && $ws_extra_is != " ") { ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-2"><?php echo @$$ws_extra_is; ?> </label>

                                            <div class="col-md-10">
                                                <input type="text" name="ws_extra<?php echo $ii; ?>_title"
                                                       value="<?php echo @$$ws_extra_dta; ?>" class="form-control"/>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>


                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo $lang_var_admin_104; ?> </label>

                                    <div class="col-md-4">
                                        <input type="file" name="myfile" class="form-control"/>
                                        <input type="hidden" name="topic_image_file" id="file_hidden_var"
                                               value="<?php echo $topic_image_file; ?>"/>
                                        <input type="hidden" name="file_del" id="file_del_var" value="0"/>
                                        <?php
                                        if ($topic_image_file != "") {
                                            $dir = dirname($_SERVER["PHP_SELF"]);
                                            $parts = explode('/', $dir);
                                            array_pop($parts);
                                            $newpath = implode('/', $parts) . "/" . substr($up_dir, 3);

                                            ?>
                                            <div id="file_show_div">
                                                <div><img src="<?php echo "$up_dir" . "$topic_image_file"; ?>"
                                                          style="max-width: 100%;margin: 5px 0;"/></div>

                                                <a class="mix-preview fancybox-button btn default"
                                                   href="<?php echo "$up_dir" . "$topic_image_file"; ?>"
                                                   data-rel="fancybox-button2">
                                                    <i class="fa fa-search-plus"></i> <?php echo $lang_var_admin_175; ?>
                                                </a>

                                                <?php
                                                if ($ws_type != 1) {
                                                    ?>
                                                    <a href="javascript:;" onclick="delete_file_onedit()"><span
                                                            id="sample_editable_1_new" class="btn default"><i
                                                                class="fa fa-times"></i> <?php echo $lang_var_admin_19; ?> </span></a>
                                                    <?php
                                                }
                                                ?>

                                            </div>

                                            <div id="file_undo_div" style="display: none;">
                                                <a href="javascript:;" onclick="undo_delete_file_onedit()"><i
                                                        class="fa fa-undo"></i> <?php echo $lang_var_admin_20; ?> </a>
                                            </div>

                                            <?php
                                        }
                                        ?>
                                        <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>
                                    </div>
                                </div>
                                <?php
                                if ($ws_attachfile_status == 1) {
                                    ?>
                                    <div class="form-group">
                                        <label
                                            class="control-label col-md-2"><?php echo $lang_var_admin_105; ?> </label>

                                        <div class="col-md-10">
                                            <div class="input-group input-medium">
                                                <input name="topic_attach_file" readonly type="text" id="url" dir="ltr"
                                                       value="<?php echo $topic_attach_file; ?>"
                                                       class="form-control input-medium">

				<span class="input-group-btn">
					<a href="javascript:;"
                       onclick="moxman.browse({view: 'thumbs', fields: 'url', extensions:'jpg,gif,png', no_host: true});"
                       class="btn default"><?php echo $lang_var_admin_206; ?></a>
				</span>
                <span class="input-group-btn">
                <a href="javascript:;" onclick="document.getElementById('url').value=''" class="btn default">&nbsp;<i
                        class="fa fa-times"></i>&nbsp;</a>
                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                            <div class="form-actions fluid">
                                <div class="col-md-offset-2 col-md-10">
                                    <button type="submit" class="btn green"><?php echo $lang_var_admin_21; ?></button>
                                    &nbsp;
                                    <a href="?wm_section=<?php echo $wm_section; ?>">
                                        <button type="button"
                                                class="btn default"><?php echo $lang_var_admin_22; ?></button>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>

                </div>
                <?php if ($ws_multiimages_status == 1) { ?>
                    <div class="tab-pane" id="portlet_tab2">
                        <?php @ require_once("template/topic_update_pages_multiimages.php"); ?>
                    </div>
                <?php } ?>
                <?php if ($ws_maps_status == 1) { ?>
                    <div class="tab-pane" id="portlet_tab3">
                        <?php @ require_once("template/topic_update_pages_maps.php"); ?>
                    </div>
                <?php } ?>
                <?php if ($site_seo_status == 1) { ?>
                    <div class="tab-pane" id="portlet_tab4">
                        <?php @ require_once("template/topic_update_pages_seo.php"); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
