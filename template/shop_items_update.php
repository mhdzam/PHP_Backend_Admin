<?php

$sql_modify = mysql_query("SELECT * FROM " . $prefix . "_shop_items  WHERE  item_id='$id' ");
$data_modify = mysql_fetch_array($sql_modify);

$item_code = stripcslashes($data_modify['item_code']);
$item_title_ar = stripcslashes($data_modify['item_title_ar']);
$item_title_en = stripcslashes($data_modify['item_title_en']);
$item_details_ar = stripcslashes($data_modify['item_details_ar']);
$item_details_en = stripcslashes($data_modify['item_details_en']);
$cat_id = stripcslashes($data_modify['cat_id']);
$brand_id = stripcslashes($data_modify['brand_id']);
$item_rate = stripcslashes($data_modify['item_rate']);
$item_image_file = stripcslashes($data_modify['item_image_file']);

$item_price = stripcslashes($data_modify['item_price']);
$item_first_price = stripcslashes($data_modify['item_first_price']);
$item_type = stripcslashes($data_modify['item_type']);
$item_offer_type = stripcslashes($data_modify['item_offer_type']);

$item_date = stripcslashes($data_modify['item_date']);
$edit_date = $data_modify['edit_date'];
$edit_by = GetAdminUserName($data_modify['edit_by']);
$edit_from = $data_modify['edit_from'];
$chome = stripcslashes($data_modify['chome']);

?>

<div class="portlet box blue tabbable">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-plus"></i> <?php echo $lang_var_admin_6 . " " . $ws_title_var; ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="portlet-tabs">
            <ul class="nav nav-tabs">
                <?php if ($site_seo_status == 1) { ?>
                    <li class="">
                        <a href="#portlet_tab4" data-toggle="tab">
                            <i class="fa fa-search"></i> <?php echo $lang_var_admin_189; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($ws_quantities_status == 1) { ?>
                    <li class="">
                        <a href="#portlet_tab5" data-toggle="tab">
                            <i class="fa fa-signal"></i> <?php echo $lang_var_admin_519; ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if ($ws_sizesandcolors_status == 1) { ?>
                    <li class="">
                        <a href="#portlet_tab3" data-toggle="tab">
                            <i class="fa fa-list-ul"></i> <?php echo $lang_var_admin_328; ?>
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
                        <form action="?id=<?php echo $id; ?>&act=saveupdate" method="post" class="form-horizontal"
                              enctype="multipart/form-data">
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
                                                        value="<?php echo $data_father_retrive['brand_id']; ?>" <?php if ($brand_id == $data_father_retrive['brand_id']) {
                                                        echo "selected='selected'";
                                                    } ?> ><?php echo $brand_title; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo $lang_var_admin_368; ?> </label>

                                    <div class="col-md-10">
                                        <input type="text" name="item_code"
                                               value="<?php echo $item_code; ?>"  class="form-control"/>
                                    </div>
                                </div>
                                <?php
                                if ($ws_date_status == 1) {
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-2"><?php echo $lang_var_admin_101; ?> <span
                                                class="required">*</span></label>

                                        <div class="col-md-10">
                                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control"
                                                       value="<?php echo $item_date; ?>" name="item_date" readonly>
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
                                            <input type="text" name="item_title_ar" dir="rtl" class="form-control"
                                                   value="<?php echo $item_title_ar; ?>" required=""/>
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
                                                <textarea name="item_details_ar" dir="rtl"
                                                          rows="<?php echo $ws_editor_rws; ?>"
                                                          class="form-control <?php echo $ws_editor_cls; ?>"><?php echo $item_details_ar; ?></textarea>
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
                                            <input type="text" name="item_title_en" dir="ltr" class="form-control"
                                                   value="<?php echo $item_title_en; ?>" required=""/>
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
                                                <textarea name="item_details_en" dir="ltr"
                                                          rows="<?php echo $ws_editor_rws; ?>"
                                                          class="form-control <?php echo $ws_editor_cls; ?>"><?php echo $item_details_en; ?></textarea>
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
                                        <input type="text" name="item_price" required=""
                                               value="<?php echo $item_price; ?>" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo $lang_var_admin_319; ?> </label>

                                    <div class="col-md-2">
                                        <input type="text" name="item_first_price"
                                               value="<?php echo $item_first_price; ?>" class="form-control"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo $lang_var_admin_320; ?> <span
                                            class="required">*</span></label>

                                    <div class="col-md-2">
                                        <div class="radio-list">
                                            <label><input type="radio" name="item_type"
                                                          value="0" <?php if ($item_type == 0) {
                                                    echo "checked";
                                                } ?>/><?php echo $lang_var_admin_321; ?> </label>
                                            <label><input type="radio" name="item_type"
                                                          value="1" <?php if ($item_type == 1) {
                                                    echo "checked";
                                                } ?>/><?php echo $lang_var_admin_322; ?> </label>
                                            <label><input type="radio" name="item_type"
                                                          value="2" <?php if ($item_type == 2) {
                                                    echo "checked";
                                                } ?>/><?php echo $lang_var_admin_508; ?> </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo $lang_var_admin_327; ?> <span
                                            class="required">*</span></label>

                                    <div class="col-md-2">
                                        <div class="radio-list">
                                            <label><input type="radio" name="item_offer_type"
                                                          value="0" <?php if ($item_offer_type == "0") {
                                                    echo "checked";
                                                } ?>/><span
                                                    class="label label-sm label-default"><?php echo $lang_var_admin_323; ?> </span>
                                            </label>
                                            <label><input type="radio" name="item_offer_type"
                                                          value="1" <?php if ($item_offer_type == "1") {
                                                    echo "checked";
                                                } ?>/><span
                                                    class="label label-sm label-info"><?php echo $lang_var_admin_324; ?></span></label>
                                            <label><input type="radio" name="item_offer_type"
                                                          value="2" <?php if ($item_offer_type == "2") {
                                                    echo "checked";
                                                } ?>/><span
                                                    class="label label-sm label-success"><?php echo $lang_var_admin_325; ?></span></label>
                                            <label><input type="radio" name="item_offer_type"
                                                          value="3" <?php if ($item_offer_type == "3") {
                                                    echo "checked";
                                                } ?>/><span
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
                                                          value="0" <?php if ($item_rate == "0") {
                                                    echo "checked";
                                                } ?>/><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_513; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                                            </label>
                                            <label><input type="radio" name="item_rate"
                                                          value="1" <?php if ($item_rate == "1") {
                                                    echo "checked";
                                                } ?>/><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_514; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i></label>
                                            <label><input type="radio" name="item_rate"
                                                          value="2" <?php if ($item_rate == "2") {
                                                    echo "checked";
                                                } ?>/><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_515; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i></label>
                                            <label><input type="radio" name="item_rate"
                                                          value="3" <?php if ($item_rate == "3") {
                                                    echo "checked";
                                                } ?>/><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_516; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i></label>
                                            <label><input type="radio" name="item_rate"
                                                          value="4" <?php if ($item_rate == "4") {
                                                    echo "checked";
                                                } ?>/><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_517; ?></span> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <dhiv class="form-group">
                                    <label class="control-label col-md-2"><?php echo $lang_var_admin_104; ?> </label>

                                    <div class="col-md-4">
                                        <input type="file" name="myfile" class="form-control"/>
                                        <input type="hidden" name="item_image_file" id="file_hidden_var"
                                               value="<?php echo $item_image_file; ?>"/>
                                        <input type="hidden" name="file_del" id="file_del_var" value="0"/>
                                        <?php
                                        if ($item_image_file != "") {
                                            $dir = dirname($_SERVER["PHP_SELF"]);
                                            $parts = explode('/', $dir);
                                            array_pop($parts);
                                            $newpath = implode('/', $parts) . "/" . substr($up_dir, 3);

                                            ?>
                                            <div id="file_show_div">
                                                <div><img src="<?php echo "$up_dir" . "$item_image_file"; ?>"
                                                          style="max-width: 100%;margin: 5px 0;"/></div>

                                                <a class="mix-preview fancybox-button btn default"
                                                   href="<?php echo "$up_dir" . "$item_image_file"; ?>"
                                                   data-rel="fancybox-button2">
                                                    <i class="fa fa-search-plus"></i> <?php echo $lang_var_admin_175; ?>
                                                </a>


                                                <a href="javascript:;" onclick="delete_file_onedit()"><span
                                                        id="sample_editable_1_new" class="btn default"><i
                                                            class="fa fa-times"></i> <?php echo $lang_var_admin_19; ?> </span></a>


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

                                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_533; ?> </label>

                    <div class="col-md-4" style="margin-top: 31px;">
                         <div class="radio-list">
                            <label><input type="radio" name="chome"
                                          value="1" <?php if ($chome == "1") {
                                                    echo "checked";
                                                } ?>  /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_75; ?> </span>
                            </label>
                            <label><input type="radio" name="chome"
                                          value="0" <?php if ($chome == "0") {
                                                    echo "checked";
                                                } ?>  /><span style="min-width: 60px;display: inline-block"><?php echo $lang_var_admin_76; ?></span></label>
                                          </div>
                    </div>
                </div>

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

                
                <?php if ($ws_multiimages_status == 1) { ?>
                    <div class="tab-pane" id="portlet_tab2">
                        <?php @ require_once("template/shop_items_update_multiimages.php"); ?>
                    </div>
                <?php } ?>
                <?php if ($ws_sizesandcolors_status == 1) { ?>
                    <div class="tab-pane" id="portlet_tab3">
                        <?php @ require_once("template/shop_items_update_sizes.php"); ?>
                        <?php @ require_once("template/shop_items_update_colors.php"); ?>
                    </div>
                <?php } ?>
                <?php if ($ws_quantities_status == 1) { ?>
                    <div class="tab-pane" id="portlet_tab5">
                        <?php @ require_once("template/shop_items_update_quantities.php"); ?>
                    </div>
                <?php } ?>
                <?php if ($site_seo_status == 1) { ?>
                    <div class="tab-pane" id="portlet_tab4">
                        <?php @ require_once("template/shop_items_update_seo.php"); ?>
                    </div>
                <?php } ?>
			</div>
            </div>
        </div>
    </div>
</div>
