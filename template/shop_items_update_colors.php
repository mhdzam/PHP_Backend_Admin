<h4><?php echo $lang_var_admin_330; ?></h4>
<hr>
<?php
$color_act = @$_GET['coloract'];
$color_id = @$_GET['color_id'];

$color_title_ar = mysql_real_escape_string(@$_POST['color_title_ar']);
$color_title_en = mysql_real_escape_string(@$_POST['color_title_en']);


if ($color_act == "del" && $color_id != "") {

    $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_shop_items_colors where color_id = '$color_id'");
}


if ($color_act == "insert" && ($color_title_ar != "" || $color_title_en != "")) {


    $sql_slct_max = mysql_query("select max(color_id)  from " . $prefix . "_shop_items_colors");
    $data_slct_max = mysql_fetch_array($sql_slct_max);
    $next_color_id = $data_slct_max[0] + 1;
    $color_sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_shop_items_colors (
  color_id,
  item_id,
  color_title_ar,
  color_title_en) VALUES ('$next_color_id','$id','$color_title_ar' ,'$color_title_en')");

    if ($color_sql_insert_new) {
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

if ($color_act == "save" && ($color_title_ar != "" || $color_title_en != "")) {

    $color_sql_update = mysql_query("UPDATE " . $prefix . "_shop_items_colors SET color_title_ar='$color_title_ar',color_title_en='$color_title_en'  WHERE color_id='$color_id'") or
    die(mysql_error());

    if ($color_sql_update) {
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
    function del_color_confirmation(ID, Name) {
        var answer = confirm("<?php echo $lang_var_admin_190; ?> " + Name + " ?")
        if (answer) {
            window.location = "shop_items.php?id=<?php echo $id; ?>&act=update&coloract=del&color_id=" + ID + "#portlet_tab3";
        }
        else {
        }
    }
</script>
<div class="row">
    <div class="col-md-6">
        <?php
        if ($color_act == "edit") {
            $color_sql_modify = mysql_query("SELECT * FROM " . $prefix . "_shop_items_colors WHERE color_id ='$color_id' ");
            $color_data_modify = mysql_fetch_array($color_sql_modify);

            $color_title_ar = stripcslashes($color_data_modify['color_title_ar']);
            $color_title_en = stripcslashes($color_data_modify['color_title_en']);

            ?>
            <form
                action="shop_items.php?id=<?php echo $id; ?>&color_id=<?php echo $color_id; ?>&act=update&coloract=save#portlet_tab3"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">


                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_329; ?> <?php echo $ar_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="color_title_ar" value="<?php echo $color_title_ar; ?>"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_329; ?> <?php echo $en_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="color_title_en" value="<?php echo $color_title_en; ?>"
                                   class="form-control"/>
                        </div>
                    </div>
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
                action="shop_items.php?id=<?php echo $id; ?>&act=update&coloract=insert#portlet_tab3"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">


                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_329; ?> <?php echo $ar_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="color_title_ar" value="" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_329; ?> <?php echo $en_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="color_title_en" value="" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green"><?php echo $lang_var_admin_23; ?></button>
                    </div>

                </div>
            </form>

            <?php
        }
        ?>
    </div>
    <div class="col-md-6">
        <table class="table table-striped table-hover">
            <?php
            $sql_colors_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_colors where item_id='$id' order by color_id");
            $colors_records_count = mysql_num_rows($sql_colors_retrive);
            if ($colors_records_count == 0) {
                ?>
                <tr class="odd gradeX">
                    <td colspan="2" style="text-align: center;">
                        <small><?php echo $lang_var_admin_93; ?></small>
                    </td>

                </tr>
                <?php
            } else {
            ?>
            <thead>
            <tr>
                <th><?php echo $lang_var_admin_329; ?></th>
                <th width="40%" style="text-align: center;"><?php echo $lang_var_admin_5; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($data_colors_retrive = mysql_fetch_array($sql_colors_retrive)) {
                ?>
                <tr>
                    <td>
                        <?php echo stripcslashes($data_colors_retrive['color_title_' . $lang]); ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="shop_items.php?id=<?php echo $id; ?>&act=update&coloract=edit&color_id=<?php echo $data_colors_retrive['color_id']; ?>#portlet_tab3"
                           class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?> <i
                                class="fa fa-edit"></i></a>
                        &nbsp;
                        <a href="javascript:del_color_confirmation(<?php echo $data_colors_retrive['color_id']; ?>,'<?php echo stripcslashes($data_colors_retrive['color_title_' . $lang]); ?>')"
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
