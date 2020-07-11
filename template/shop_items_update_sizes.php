<h4><?php echo $lang_var_admin_331; ?></h4>
<hr>
<?php
$size_act = @$_GET['sizeact'];
$size_id = @$_GET['size_id'];

$size_title_ar = mysql_real_escape_string(@$_POST['size_title_ar']);
$size_title_en = mysql_real_escape_string(@$_POST['size_title_en']);


if ($size_act == "del" && $size_id != "") {

    $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_shop_items_sizes where size_id = '$size_id'");
}


if ($size_act == "insert" && ($size_title_ar != "" || $size_title_en != "")) {


    $sql_slct_max = mysql_query("select max(size_id)  from " . $prefix . "_shop_items_sizes");
    $data_slct_max = mysql_fetch_array($sql_slct_max);
    $next_size_id = $data_slct_max[0] + 1;
    $size_sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_shop_items_sizes (
  size_id,
  item_id,
  size_title_ar,
  size_title_en) VALUES ('$next_size_id','$id','$size_title_ar' ,'$size_title_en')");

    if ($size_sql_insert_new) {
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

if ($size_act == "save" && ($size_title_ar != "" || $size_title_en != "")) {

    $size_sql_update = mysql_query("UPDATE " . $prefix . "_shop_items_sizes SET size_title_ar='$size_title_ar',size_title_en='$size_title_en'  WHERE size_id='$size_id'") or
    die(mysql_error());

    if ($size_sql_update) {
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
    function del_size_confirmation(ID, Name) {
        var answer = confirm("<?php echo $lang_var_admin_190; ?> " + Name + " ?")
        if (answer) {
            window.location = "shop_items.php?id=<?php echo $id; ?>&act=update&sizeact=del&size_id=" + ID + "#portlet_tab3";
        }
        else {
        }
    }
</script>
<div class="row">
    <div class="col-md-6">
        <?php
        if ($size_act == "edit") {
            $size_sql_modify = mysql_query("SELECT * FROM " . $prefix . "_shop_items_sizes WHERE size_id ='$size_id' ");
            $size_data_modify = mysql_fetch_array($size_sql_modify);

            $size_title_ar = stripcslashes($size_data_modify['size_title_ar']);
            $size_title_en = stripcslashes($size_data_modify['size_title_en']);

            ?>
            <form
                action="shop_items.php?id=<?php echo $id; ?>&size_id=<?php echo $size_id; ?>&act=update&sizeact=save#portlet_tab3"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">


                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_332; ?> <?php echo $ar_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="size_title_ar" value="<?php echo $size_title_ar; ?>"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_332; ?> <?php echo $en_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="size_title_en" value="<?php echo $size_title_en; ?>"
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
                action="shop_items.php?id=<?php echo $id; ?>&act=update&sizeact=insert#portlet_tab3"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">


                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_332; ?> <?php echo $ar_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="size_title_ar" value="" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_332; ?> <?php echo $en_lang_icon; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="size_title_en" value="" class="form-control"/>
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
            $sql_sizes_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_sizes where item_id='$id' order by size_id");
            $sizes_records_count = mysql_num_rows($sql_sizes_retrive);
            if ($sizes_records_count == 0) {
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
                <th><?php echo $lang_var_admin_332; ?></th>
                <th width="40%" style="text-align: center;"><?php echo $lang_var_admin_5; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($data_sizes_retrive = mysql_fetch_array($sql_sizes_retrive)) {
                ?>
                <tr>
                    <td>
                        <?php echo stripcslashes($data_sizes_retrive['size_title_' . $lang]); ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="shop_items.php?id=<?php echo $id; ?>&act=update&sizeact=edit&size_id=<?php echo $data_sizes_retrive['size_id']; ?>#portlet_tab3"
                           class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?> <i
                                class="fa fa-edit"></i></a>
                        &nbsp;
                        <a href="javascript:del_size_confirmation(<?php echo $data_sizes_retrive['size_id']; ?>,'<?php echo stripcslashes($data_sizes_retrive['size_title_' . $lang]); ?>')"
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
