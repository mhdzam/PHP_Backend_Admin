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
        <form action="?act=insert" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">

                <?php if ($ws_sections_st != 0) { ?>
                    <div class="form-group">
                        <label class="control-label col-md-2"><?php echo $lang_var_admin_99; ?> <span
                                class="required">*</span></label>

                        <div class="col-md-10">
                            <select class="form-control" name="cat_id" class="select2me" required>
                                <option value=""><?php echo $lang_var_admin_100; ?>...</option>
                                <?php
                                $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_sections where father_id='0' order by row_no, section_id");
                                while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                    if ($lang == "ar") {
                                        $section_title = $data_father_retrive['section_title_ar'];
                                    } else {
                                        $section_title = $data_father_retrive['section_title_en'];
                                    }
                                    $sql_subsection_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_sections where father_id='$data_father_retrive[section_id]' order by row_no, section_id");
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
                                        <option value="<?php echo $data_subsection_retrive['section_id']; ?>"> &nbsp;
                                            &nbsp; - <?php echo $section_title; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>


                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_307; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-10">
                        <select class="form-control" name="brand_id" class="select2me" required>
                            <option value=""><?php echo $lang_var_admin_511; ?>...</option>
                            <?php
                            $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_brands where father_id='0' order by row_no, brand_id");
                            while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {
                                if ($lang == "ar") {
                                    $brand_title = $data_father_retrive['brand_title_ar'];
                                } else {
                                    $brand_title = $data_father_retrive['brand_title_en'];
                                }
                                ?>
                                <option
                                    value="<?php echo $data_father_retrive['brand_id']; ?>" ><?php echo $brand_title; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_368; ?> </label>

                    <div class="col-md-10">
                        <input type="text" name="item_code" value="" class="form-control"/>
                    </div>
                </div>

                <?php
                if ($ws_date_status == 1) {
                    ?>
                    <div class="form-group">
                        <label class="control-label col-md-2"><?php echo $lang_var_admin_101; ?> <span class="required">*</span></label>

                        <div class="col-md-10">
                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control" value="<?php echo $pd_current_date; ?>"
                                       name="item_date" readonly>
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
                            class="control-label col-md-2"><?php echo $lang_var_admin_317; ?>  <?php echo $ar_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-10">
                            <input type="text" name="item_title_ar" dir="rtl" class="form-control" required=""/>
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
                                <textarea name="item_details_ar" dir="rtl" rows="<?php echo $ws_editor_rws; ?>"
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
                            class="control-label col-md-2"><?php echo $lang_var_admin_317; ?>  <?php echo $en_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-10">
                            <input type="text" name="item_title_en" dir="ltr" class="form-control" required=""/>
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
                                <textarea name="item_details_en" dir="ltr" rows="<?php echo $ws_editor_rws; ?>"
                                          class="form-control <?php echo $ws_editor_cls; ?>"></textarea>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>

                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_318; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-2">
                        <input type="text" name="item_price" required="" value="0" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_319; ?> </label>

                    <div class="col-md-2">
                        <input type="text" name="item_first_price" value="" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_320; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-2">
                        <div class="radio-list">
                            <label><input type="radio" name="item_type"
                                          value="0" checked/><?php echo $lang_var_admin_321; ?> </label>
                            <label><input type="radio" name="item_type"
                                          value="1"/><?php echo $lang_var_admin_322; ?> </label>
                            <label><input type="radio" name="item_type"
                                          value="2"/><?php echo $lang_var_admin_508; ?> </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_327; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-2">
                        <div class="radio-list">
                            <label><input type="radio" name="item_offer_type" value="0" checked/><span
                                    class="label label-sm label-default"><?php echo $lang_var_admin_323; ?> </span>
                            </label>
                            <label><input type="radio" name="item_offer_type" value="1"/><span
                                    class="label label-sm label-info"><?php echo $lang_var_admin_324; ?></span></label>
                            <label><input type="radio" name="item_offer_type" value="2"/><span
                                    class="label label-sm label-success"><?php echo $lang_var_admin_325; ?></span></label>
                            <label><input type="radio" name="item_offer_type" value="3"/><span
                                    class="label label-sm label-danger"><?php echo $lang_var_admin_326; ?></span></label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_512; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-4">
                        <div class="radio-list">
                            <label><input type="radio" name="item_rate"
                                          value="0"  /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_513; ?> </span> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                            </label>
                            <label><input type="radio" name="item_rate"
                                          value="1" /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_514; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i></label>
                            <label><input type="radio" name="item_rate"
                                          value="2" checked /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_515; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i></label>
                            <label><input type="radio" name="item_rate"
                                          value="3" /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_516; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i></label>
                            <label><input type="radio" name="item_rate"
                                          value="4" /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_517; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_104; ?> </label>

                    <div class="col-md-4">
                        <input type="file" name="myfile" class="form-control"/>
                        <span class="help-block">e.g: .png, .jpeg, .jpg, .gif</span>

                    </div>
                </div>
<div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_533; ?> </label>

                    <div class="col-md-4" style="margin-top: 31px;">
                         <div class="radio-list">
                            <label><input type="radio" name="chome"
                                          value="1" checked  /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_75; ?> </span>
                            </label>
                            <label><input type="radio" name="chome"
                                          value="0" /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_76; ?></span></label>
                                          </div>
                    </div>
                </div>

            </div>
            <div class="form-actions fluid">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" class="btn green"><?php echo $lang_var_admin_23; ?></button>
                    &nbsp;
                    <a href="?">
                        <button type="button" class="btn default"><?php echo $lang_var_admin_22; ?></button>
                    </a>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
    <!-- END VALIDATION STATES-->
</div>