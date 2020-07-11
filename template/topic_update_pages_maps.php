<?php

$gmap_latitude = '25.379705';
$gmap_longitude = '55.46017882009892';

$map_act = @$_GET['mapact'];
$map_id = @$_GET['map_id'];
$tm_long = mysql_real_escape_string(@$_POST['tm_long']);
$tm_alti = mysql_real_escape_string(@$_POST['tm_alti']);
$tm_details_ar = mysql_real_escape_string(@$_POST['tm_details_ar']);
$tm_details_en = mysql_real_escape_string(@$_POST['tm_details_en']);


if ($map_act == "del" && $map_id != "") {

    $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_topics_maps where tm_id = '$map_id'");
}


if ($map_act == "insert" && $tm_long != "" && $tm_alti != "") {


    $sql_slct_max = mysql_query("select max(tm_id)  from " . $prefix . "_topics_maps");
    $data_slct_max = mysql_fetch_array($sql_slct_max);
    $next_tm_id = $data_slct_max[0] + 1;
    $map_sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_topics_maps (
  tm_id,
  tm_long,
  tm_alti,
  topic_id,
  tm_details_ar,
  tm_details_en) VALUES ('$next_tm_id','$tm_long','$tm_alti','$id','$tm_details_ar' ,'$tm_details_en')");

    if ($map_sql_insert_new) {
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

if ($map_act == "save" && $tm_long != "" && $tm_alti != "") {

    $map_sql_update = mysql_query("UPDATE " . $prefix . "_topics_maps SET tm_details_ar='$tm_details_ar',tm_details_en='$tm_details_en' $toosave,tm_alti='$tm_alti',tm_long='$tm_long'  WHERE tm_id='$map_id'") or
    die(mysql_error());

    if ($map_sql_update) {
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
?>

<script type="text/javascript">
    function del_map_confirmation(ID, Name) {
        var answer = confirm("<?php echo $lang_var_admin_190; ?> " + Name + " ?")
        if (answer) {
            window.location = "topics.php?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=update&mapact=del&map_id=" + ID + "#portlet_tab3";
        }
        else {
        }
    }
</script>
<div class="row">
    <div class="col-md-6">
        <?php
        if ($map_act == "edit") {
            $map_sql_modify = mysql_query("SELECT * FROM " . $prefix . "_topics_maps WHERE tm_id ='$map_id' ");
            $map_data_modify = mysql_fetch_array($map_sql_modify);

            $tm_details_ar = stripcslashes($map_data_modify['tm_details_ar']);
            $tm_details_en = stripcslashes($map_data_modify['tm_details_en']);

            $gmap_latitude = stripcslashes($map_data_modify['tm_long']);
            $gmap_longitude = stripcslashes($map_data_modify['tm_alti']);
            ?>
            <form
                action="topics.php?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&map_id=<?php echo $map_id; ?>&act=update&mapact=save#portlet_tab3"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">

                    <?php if ($site_ar_box_status != 0) { ?>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?> <?php echo $ar_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <textarea name="tm_details_ar" required="" rows="3"
                                      class="form-control"><?php echo $tm_details_ar; ?></textarea>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                    <?php if ($site_en_box_status != 0) { ?>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?> <?php echo $en_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <textarea name="tm_details_en" required="" rows="3"
                                      class="form-control"><?php echo $tm_details_en; ?></textarea>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                    <div id="submit-map" class="gmaps"></div>
                    <input type="hidden" name="tm_long" id="map_latitude"
                           value="<?php echo $gmap_latitude; ?>"/>
                    <input type="hidden" name="tm_alti" id="map_longitude"
                           value="<?php echo $gmap_longitude; ?>"/>
                </div>
                <div>
                    <div class="col-md-12">
                        <button type="submit" class="btn green"><?php echo $lang_var_admin_21; ?></button>
                    </div>

                </div>
            </form>

            <?php
        } else {
            ?>
            <form
                action="topics.php?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=update&mapact=insert#portlet_tab3"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">

                    <?php if ($site_ar_box_status != 0) { ?>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?> <?php echo $ar_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <textarea name="tm_details_ar" required="" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                    <?php if ($site_en_box_status != 0) { ?>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_103; ?> <?php echo $en_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <textarea name="tm_details_en" required="" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                        <?php
                    }
                    ?>
                    <div id="submit-map" class="gmaps"></div>
                    <input type="hidden" name="tm_long" id="map_latitude"
                           value="<?php echo @$_POST['map_latitude']; ?>"/>
                    <input type="hidden" name="tm_alti" id="map_longitude"
                           value="<?php echo @$_POST['map_longitude']; ?>"/>
                </div>
                <div>
                    <div class="col-md-12">
                        <button type="submit" class="btn green"><?php echo $lang_var_admin_21; ?></button>
                    </div>

                </div>
            </form>

            <?php
        }
        ?>
    </div>
    <div class="col-md-6">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th><?php echo $lang_var_admin_103; ?></th>
                <th style="text-align: center;"><?php echo $lang_var_admin_5; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql_maps_retrive = mysql_query("SELECT * FROM " . $prefix . "_topics_maps where topic_id='$id' order by tm_id");
            $maps_records_count = mysql_num_rows($sql_maps_retrive);
            if ($maps_records_count == 0) {
                ?>
                <tr class="odd gradeX">
                    <td colspan="3" style="text-align: center;">
                        <small><?php echo $lang_var_admin_93; ?></small>
                    </td>

                </tr>
                <?php
            } else {
                while ($data_maps_retrive = mysql_fetch_array($sql_maps_retrive)) {
                    ?>
                    <tr>
                        <td>
                            <div>
                                <small>
                                    <small><i class="fa fa-map-marker"></i> <?php echo $lang_var_admin_191; ?>: <span
                                            dir="ltr"><?php echo $data_maps_retrive['tm_long']; ?>
                                            , <?php echo $data_maps_retrive['tm_alti']; ?></span></small>
                                </small>
                            </div>
                            <small><?php echo str_replace("\r\n", "<br>", stripcslashes($data_maps_retrive['tm_details_' . $lang])); ?></small>
                        </td>
                        <td style="text-align: center;">
                            <a href="topics.php?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=update&mapact=edit&map_id=<?php echo $data_maps_retrive['tm_id']; ?>#portlet_tab3"
                               class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?> <i
                                    class="fa fa-edit"></i></a>
                            &nbsp;
                            <a href="javascript:del_map_confirmation(<?php echo $data_maps_retrive['tm_id']; ?>,'<?php echo stripcslashes($data_maps_retrive['tm_long']); ?>')"
                               class="btn btn-sm default"> <?php echo $lang_var_admin_19; ?> <i
                                    class="fa fa-trash-o"></i></a>

                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

            </tbody>
        </table>
    </div>


</div>

<br/>
