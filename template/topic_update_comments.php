<?php
$sql_modify = mysql_query("SELECT * FROM " . $prefix . "_topics_comments  WHERE wm_section_id ='$wm_section' AND comment_id='$id' ");
$data_modify = mysql_fetch_array($sql_modify);

$name = stripcslashes($data_modify['name']);
$email = stripcslashes($data_modify['email']);
$comment = stripcslashes($data_modify['comment']);
$comment_date = stripcslashes($data_modify['comment_date']);
$comment_from = stripcslashes($data_modify['comment_from']);
$topic_id = stripcslashes($data_modify['topic_id']);
$comment_status = stripcslashes($data_modify['comment_status']);

$edit_date = $data_modify['edit_date'];
$edit_by = GetAdminUserName($data_modify['edit_by']);
$edit_from = $data_modify['edit_from'];

$topic_section_is = "";

$sql_section = mysql_query("SELECT * FROM " . $prefix . "_topics where wm_section_id='$wm_section' and topic_id ='$topic_id'");
$data_section = mysql_fetch_array($sql_section);
$sc_nme = stripcslashes($data_section['topic_title_' . $lang]);
$topic_section_is = "<div style='padding-top: 7px;'>$sc_nme</div>";

?>

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-plus"></i> <?php echo $lang_var_admin_6 . " " . $lang_var_admin_86 . " " . $ws_title_var; ?>
        </div>
        <div class="tools">
            <a href="?wm_section=<?php echo $wm_section; ?>" class="close"></a>

        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form action="?wm_section=<?php echo $wm_section; ?>&id=<?php echo $id; ?>&act=saveupdate" method="post"
              class="form-horizontal" enctype="multipart/form-data">
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_102; ?> :</label>

                    <div class="col-md-9">
                        <a href="topics.php?wm_section=<?php echo $wm_section; ?>&id=<?php echo $topic_id; ?>&act=update"><?php echo $topic_section_is; ?></a>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_126; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-9">
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_15; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-9">
                        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" required=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo $lang_var_admin_127; ?> <span
                            class="required">*</span></label>

                    <div class="col-md-9">
                        <textarea name="comment" rows="8" class="form-control"
                                  required=""><?php echo $comment; ?></textarea>
                        <span class="help-block pull-left"><?php echo $comment_date; ?></span>
                        <span class="help-block pull-right">IP: <?php echo $comment_from; ?></span>
                    </div>
                </div>


            </div>
            <div class="form-actions fluid">
                <div class="col-md-offset-2 col-md-9">
                    <button type="submit" class="btn green"><?php echo $lang_var_admin_21; ?></button>
                    &nbsp;
                    <a href="?wm_section=<?php echo $wm_section; ?>">
                        <button type="button" class="btn default"><?php echo $lang_var_admin_22; ?></button>
                    </a>
                </div>
            </div>
        </form>
        <!-- END FORM-->
    </div>
    <!-- END VALIDATION STATES-->
</div>