<?php
$quantity_act = @$_GET['quantityact'];
$quantity_id = @$_GET['quantity_id'];

$quantity_title = mysql_real_escape_string(@$_POST['quantity_title']);
$quantity_amount = mysql_real_escape_string(@$_POST['quantity_amount']);
$color_id = mysql_real_escape_string(@$_POST['color_id']);
$size_id = mysql_real_escape_string(@$_POST['size_id']);

if ($quantity_act == "del" && $quantity_id != "") {

    $sql_delete0 = mysql_query("DELETE FROM  " . $prefix . "_shop_items_quantities where quantity_id = '$quantity_id'");
}


if ($quantity_act == "insert") {


    $sql_slct_max = mysql_query("select max(quantity_id)  from " . $prefix . "_shop_items_quantities");
    $data_slct_max = mysql_fetch_array($sql_slct_max);
    $next_quantity_id = $data_slct_max[0] + 1;
    $quantity_sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_shop_items_quantities (
  quantity_id,
  item_id,
  quantity_title,
  quantity_date,
  quantity_amount,
  color_id,
  size_id) VALUES ('$next_quantity_id','$id','$quantity_title',now(),'$quantity_amount','$color_id','$size_id')");

    if ($quantity_sql_insert_new) {
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

if ($quantity_act == "save") {

    $quantity_sql_update = mysql_query("UPDATE " . $prefix . "_shop_items_quantities SET quantity_title='$quantity_title',quantity_amount='$quantity_amount', color_id='$color_id', size_id='$size_id'   WHERE quantity_id='$quantity_id'") or
    die(mysql_error());

    if ($quantity_sql_update) {
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
    function del_quantity_confirmation(ID, Name) {
        var answer = confirm("<?php echo $lang_var_admin_190; ?> " + Name + " ?")
        if (answer) {
            window.location = "shop_items.php?id=<?php echo $id; ?>&act=update&quantityact=del&quantity_id=" + ID + "#portlet_tab5";
        }
        else {
        }
    }
</script>
<div class="row">
    <div class="col-md-4">
        <?php
        if ($quantity_act == "edit") {
            $quantity_sql_modify = mysql_query("SELECT * FROM " . $prefix . "_shop_items_quantities WHERE quantity_id ='$quantity_id' ");
            $quantity_data_modify = mysql_fetch_array($quantity_sql_modify);

            $quantity_title = stripcslashes($quantity_data_modify['quantity_title']);
            $quantity_amount = stripcslashes($quantity_data_modify['quantity_amount']);
            $color_id = stripcslashes($quantity_data_modify['color_id']);
            $size_id = stripcslashes($quantity_data_modify['size_id']);

            ?>
            <form
                action="shop_items.php?id=<?php echo $id; ?>&quantity_id=<?php echo $quantity_id; ?>&act=update&quantityact=save#portlet_tab5"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">
                    <?php
                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_sizes where item_id='$id' order by size_title_$lang");
                    $sizes_count = mysql_num_rows($sql_father_retrive);
                    if ($sizes_count > 0) {
                        ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-3"><?php echo $lang_var_admin_332; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <select class="form-control" name="size_id" class="select2me">
                                    <option value="">...</option>
                                    <?php
                                    while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {

                                        $section_title = $data_father_retrive['size_title_' . $lang];

                                        ?>
                                        <option
                                            value="<?php echo $data_father_retrive['size_id']; ?>" <?php if ($size_id == $data_father_retrive['size_id']) {
                                            echo "selected='selected'";
                                        } ?> ><?php echo $section_title; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_colors where item_id='$id' order by color_title_$lang");
                    $colors_count = mysql_num_rows($sql_father_retrive);
                    if ($colors_count > 0) {
                        ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-3"><?php echo $lang_var_admin_329; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <select class="form-control" name="color_id" class="select2me">
                                    <option value="">...</option>
                                    <?php
                                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_colors where item_id='$id' order by color_title_$lang");
                                    while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {

                                        $section_title = $data_father_retrive['color_title_' . $lang];

                                        ?>
                                        <option
                                            value="<?php echo $data_father_retrive['color_id']; ?>" <?php if ($color_id == $data_father_retrive['color_id']) {
                                            echo "selected='selected'";
                                        } ?> ><?php echo $section_title; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_367; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="quantity_amount" value="<?php echo $quantity_amount; ?>"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_457; ?>
                        </label>

                        <div class="col-md-9">
                            <input type="text" name="quantity_title" value="<?php echo $quantity_title; ?>"
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
            <strong><i class="fa fa-plus"></i> &nbsp; <?php echo $lang_var_admin_520; ?></strong>
            <hr>
            <form
                action="shop_items.php?id=<?php echo $id; ?>&act=update&quantityact=insert#portlet_tab5"
                method="post"
                class="form-horizontal" enctype="multipart/form-data">
                <div class="form-body">
                    <?php
                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_sizes where item_id='$id' order by size_title_$lang");
                    $sizes_count = mysql_num_rows($sql_father_retrive);
                    if ($sizes_count > 0) {
                        ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-3"><?php echo $lang_var_admin_332; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <select class="form-control" name="size_id" class="select2me">
                                    <option value="">...</option>
                                    <?php
                                    while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {

                                        $section_title = $data_father_retrive['size_title_' . $lang];

                                        ?>
                                        <option
                                            value="<?php echo $data_father_retrive['size_id']; ?>"><?php echo $section_title; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    $sql_father_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_colors where item_id='$id' order by color_title_$lang");
                    $colors_count = mysql_num_rows($sql_father_retrive);
                    if ($colors_count > 0) {
                        ?>
                        <div class="form-group">
                            <label
                                class="control-label col-md-3"><?php echo $lang_var_admin_329; ?>
                                <span class="required">*</span></label>

                            <div class="col-md-9">
                                <select class="form-control" name="color_id" class="select2me">
                                    <option value="">...</option>
                                    <?php

                                    while ($data_father_retrive = mysql_fetch_array($sql_father_retrive)) {

                                        $section_title = $data_father_retrive['color_title_' . $lang];

                                        ?>
                                        <option
                                            value="<?php echo $data_father_retrive['color_id']; ?>"><?php echo $section_title; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_367; ?>
                            <span class="required">*</span></label>

                        <div class="col-md-9">
                            <input type="text" name="quantity_amount" value=""
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label
                            class="control-label col-md-3"><?php echo $lang_var_admin_457; ?>
                        </label>

                        <div class="col-md-9">
                            <input type="text" name="quantity_title" value="" class="form-control"/>
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
    <div class="col-md-8">
        <table class="table table-striped table-hover">
            <?php
            $total_qty_old = 0;
            $total_qty = 0;
            $total_size_id = 0;
            $total_color_id = 0;
            $start = 0;
            $show_sum = false;
            $sql_quantities_retrive = mysql_query("SELECT * FROM " . $prefix . "_shop_items_quantities where item_id='$id' order by size_id,color_id, quantity_id");
            $quantitys_records_count = mysql_num_rows($sql_quantities_retrive);
            ?>
            <thead>
            <tr>
                <?php
                if ($sizes_count > 0) {
                    ?>
                    <th><?php echo $lang_var_admin_332; ?></th>
                    <?php
                }
                if ($colors_count > 0) {
                    ?>
                    <th><?php echo $lang_var_admin_329; ?></th>
                    <?php
                }
                ?>
                <th style="text-align: center;"><?php echo $lang_var_admin_367; ?></th>
                <th><?php echo $lang_var_admin_457; ?></th>
                <th width="25%" style="text-align: center;"><?php echo $lang_var_admin_5; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($quantitys_records_count == 0) {
                ?>
                <tr class="odd gradeX">
                    <td colspan="5" style="text-align: center;">
                        <small><?php echo $lang_var_admin_93; ?></small>
                    </td>

                </tr>
                <?php
            } else {

                while ($data_quantities_retrive = mysql_fetch_array($sql_quantities_retrive)) {
                    $sql_get_size = mysql_query("SELECT * FROM " . $prefix . "_shop_items_sizes  where item_id='$id' and size_id='$data_quantities_retrive[size_id]'");
                    $data_get_size = mysql_fetch_array($sql_get_size);
                    $item_size = $data_get_size['size_id'];
                    $size_title = $data_get_size['size_title_' . $lang];

                    $sql_get_color = mysql_query("SELECT * FROM " . $prefix . "_shop_items_colors  where item_id='$id' and color_id='$data_quantities_retrive[color_id]'");
                    $data_get_color = mysql_fetch_array($sql_get_color);
                    $item_color = $data_get_color['color_id'];
                    $color_title = $data_get_color['color_title_' . $lang];


                    if ($item_size == $total_size_id && $item_color == $total_color_id) {
                        $show_sum = false;
                    } else {
                        $total_qty_old = $total_qty;
                        $total_qty = 0;
                        $show_sum = true;
                    }
                    $total_qty += $data_quantities_retrive['quantity_amount'];

                    $sql_total_sold = mysql_query("SELECT sum(oitem_qty) as totl_sold FROM " . $prefix . "_shop_orders_items  where item_id='$id' and size_id ='$total_size_id' and color_id='$total_color_id' and order_id in (SELECT order_id FROM " . $prefix . "_shop_orders where order_status !=0 and temp_status !=0)");
                    $data_total_sold = mysql_fetch_array($sql_total_sold);
                    $item_totl_sold = $data_total_sold['totl_sold'];
                    if($item_totl_sold<1){
                        $item_totl_sold = 0;
                    }

                    $total_size_id = $item_size;
                    $total_color_id = $item_color;

                    if ($start != 0 && $show_sum) {
                        ?>
                        <tr>
                            <?php
                            if ($sizes_count > 0) {
                                ?>
                                <td style="background: #b4e0bc;">

                                </td>
                                <?php
                            }
                            if ($colors_count > 0) {
                                ?>
                                <td style="background: #b4e0bc;">
                                    <?php echo $lang_var_admin_347; ?>
                                </td>
                                <?php
                            }
                            ?>
                            <td style="text-align: center;background: #b4e0bc;">
                                <strong><?php echo $total_qty_old; ?></strong>
                            </td>
                            <td style="text-align: center;background: #b4e0bc;color: #118425">
                                <?php echo $lang_var_admin_521; ?> : <strong><?php echo $item_totl_sold; ?></strong>
                            </td>
                            <td style="text-align: center;background: #b4e0bc;color: #c40000">
                                <?php echo $lang_var_admin_472; ?> : <strong><?php echo $xx0 = $total_qty_old - $item_totl_sold; ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><br></td>
                        </tr>
                        <tr>
                            <?php
                            if ($sizes_count > 0) {
                                ?>
                                <th><?php echo $lang_var_admin_332; ?></th>
                                <?php
                            }
                            if ($colors_count > 0) {
                                ?>
                                <th><?php echo $lang_var_admin_329; ?></th>
                                <?php
                            }
                            ?>
                            <th style="text-align: center;"><?php echo $lang_var_admin_367; ?></th>
                            <th><?php echo $lang_var_admin_457; ?></th>
                            <th width="25%" style="text-align: center;"><?php echo $lang_var_admin_5; ?></th>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <?php
                        if ($sizes_count > 0) {
                            ?>
                            <td>
                                <?php echo $size_title; ?>
                            </td>
                            <?php
                        }
                        if ($colors_count > 0) {
                            ?>
                            <td>
                                <?php echo $color_title; ?>
                            </td>
                            <?php
                        }
                        ?>
                        <td style="text-align: center;">
                            <?php echo stripcslashes($data_quantities_retrive['quantity_amount']); ?>
                        </td>
                        <td>
                            <?php echo stripcslashes($data_quantities_retrive['quantity_title']); ?>
                        </td>
                        <td style="text-align: center;">
                            <a href="shop_items.php?id=<?php echo $id; ?>&act=update&quantityact=edit&quantity_id=<?php echo $data_quantities_retrive['quantity_id']; ?>#portlet_tab5"
                               class="btn btn-sm default"> <?php echo $lang_var_admin_6; ?> <i
                                    class="fa fa-edit"></i></a>
                            &nbsp;
                            <a href="javascript:del_quantity_confirmation(<?php echo $data_quantities_retrive['quantity_id']; ?>,'<?php echo stripcslashes($data_quantities_retrive['quantity_title']); ?>')"
                               class="btn btn-sm default"> <?php echo $lang_var_admin_19; ?> <i
                                    class="fa fa-trash-o"></i></a>

                        </td>
                    </tr>
                    <?php
                    $start++;
                }
            }

            // last total
            $sql_total_sold = mysql_query("SELECT sum(oitem_qty) as totl_sold FROM " . $prefix . "_shop_orders_items  where item_id='$id' and size_id ='$total_size_id' and color_id='$total_color_id' and order_id in (SELECT order_id FROM " . $prefix . "_shop_orders where order_status !=0 and temp_status !=0)");
            $data_total_sold = mysql_fetch_array($sql_total_sold);
            $item_totl_sold = $data_total_sold['totl_sold'];
            if($item_totl_sold<1){
                $item_totl_sold = 0;
            }

            ?>
            <tr>
                <?php
                if ($sizes_count > 0) {
                    ?>
                    <td style="background: #b4e0bc;">

                    </td>
                    <?php
                }
                if ($colors_count > 0) {
                    ?>
                    <td style="background: #b4e0bc;">
                        <?php echo $lang_var_admin_347; ?>
                    </td>
                    <?php
                }
                ?>
                <td style="text-align: center;background: #b4e0bc;">
                    <strong><?php echo $total_qty; ?></strong>
                </td>
                <td style="text-align: center;background: #b4e0bc;color: #118425">
                    <?php echo $lang_var_admin_521; ?> : <strong><?php echo $item_totl_sold; ?></strong>
                </td>
                <td style="text-align: center;background: #b4e0bc;color: #c40000">
                    <?php echo $lang_var_admin_472; ?> : <strong><?php echo $xx0 = $total_qty - $item_totl_sold; ?></strong>
                </td>
            </tr>

            </tbody>
        </table>
    </div>


</div>

<br/>
