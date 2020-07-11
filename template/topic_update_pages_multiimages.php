<div>
    <!-- BEGIN FORM-->

    <div class="row">
        <div class="col-md-12">
            <form action="template/topic_update_pages_multiimages_upload.php?topic_id=<?php echo $id; ?>"
                  class="dropzone" id="my-dropzone">

            </form>
        </div>
    </div>

    <?php
    /*
?>
<a href="topics.php?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=update"><button type="button" class="btn green"><?php echo $lang_var_admin_142; ?></button></a> */

    ?>
</div>


<?php

$del_act = @$_GET['del'];
$img_id = @$_GET['img_id'];
if ($del_act == "true" && $img_id != "") {
    $sql_delete_who = mysql_query("SELECT * FROM " . $prefix . "_topics_files where tf_id = '$img_id'");
    while ($data_delete_who = @mysql_fetch_array($sql_delete_who)) {
        if ($data_delete_who['tf_file'] != "") {
            @unlink("$up_dir" . "$data_delete_who[tf_file]");
        }
    }
    $sql_delete_mltiimgs = mysql_query("DELETE FROM  " . $prefix . "_topics_files where tf_id = '$img_id'");

    if ($sql_delete_mltiimgs) {
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

$sql_retrive_multiimages = mysql_query("SELECT * FROM " . $prefix . "_topics_files where topic_id='$id' order by tf_id");
$page_multiimages_count = mysql_num_rows($sql_retrive_multiimages);
if ($page_multiimages_count > 0) {
    ?>
    <script type="text/javascript">
        function del_imgs_confirmation(ID, Name) {
            var answer = confirm("<?php echo $lang_var_admin_190; ?> " + Name + " ?")
            if (answer) {
                window.location = "topics.php?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=update&del=true&img_id=" + ID + "#portlet_tab2";
            }
            else {
            }
        }
    </script>
    <div class="margin-top-10">
        <div class="row mix-grid">
            <?php
            while ($data_multiimages_retrive = mysql_fetch_array($sql_retrive_multiimages)) {
                $tf_file = stripcslashes($data_multiimages_retrive['tf_file']);
                ?>
                <div class="col-md-3 col-sm-4 mix">
                    <div class="mix-inner">
                        <img class="img-responsive" src="<?php echo "$up_dir" . "$tf_file"; ?>"
                             alt="<?php echo stripcslashes($data_multiimages_retrive['tf_title']); ?>"
                             title="<?php echo stripcslashes($data_multiimages_retrive['tf_title']); ?>">

                        <div class="mix-details" dir="ltr">
                            <br/>
                            <?php echo stripcslashes($data_multiimages_retrive['tf_title']); ?><br/>
                            <a href="javascript:del_imgs_confirmation(<?php echo $data_multiimages_retrive['tf_id']; ?>,'<?php echo stripcslashes($data_multiimages_retrive['tf_title']); ?>')"
                               class="mix-link">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <a class="mix-preview fancybox-button" href="<?php echo "$up_dir" . "$tf_file"; ?>"
                               title="<?php echo stripcslashes($data_multiimages_retrive['tf_title']); ?>"
                               data-rel="fancybox-button">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
    <?php
}
?>
                    