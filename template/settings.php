
<form action="" id="form_save_settings" method="post" class="form-horizontal" enctype="multipart/form-data">
    <div class="theme-panel hidden-xs hidden-sm">
        <div class="toggler">
        </div>
        <div class="toggler-close">
        </div>

        <div class="theme-options">
            <div class="theme-option theme-colors clearfix">
						<span>
							 THEME COLOR
						</span>
                <ul>
                    <li onclick="document.getElementById('settings_color').value='0';"
                        class="color-black current color-default" data-style="default"></li>
                    <li onclick="document.getElementById('settings_color').value='1';" class="color-blue"
                        data-style="blue"></li>
                    <li onclick="document.getElementById('settings_color').value='2';" class="color-brown"
                        data-style="brown"></li>
                    <li onclick="document.getElementById('settings_color').value='3';" class="color-purple"
                        data-style="purple"></li>
                    <li onclick="document.getElementById('settings_color').value='4';" class="color-grey"
                        data-style="grey"></li>
                    <li onclick="document.getElementById('settings_color').value='5';" class="color-white color-light"
                        data-style="light"></li>
                </ul>
                <input type="hidden" id="settings_color" name="settings_color"/>
            </div>

            <div class="theme-option">
						<span>
							 <?php echo $lang_var_admin_281; ?>
						</span>
                <select name="settings_lang" class="form-control input-small">
                    <?php
                    $sql_settngs_lang = mysql_query("SELECT * FROM " . $prefix . "_languages where lang_status=1 order by lang_id");
                    while ($data_settngs_lang = mysql_fetch_array($sql_settngs_lang)) {
                        $selctlng = "";
                        if ($data_settngs_lang['lang_id'] == $site_lang_id) {
                            $selctlng = "selected";
                        }
                        ?>
                        <option value="<?php echo
                        $data_settngs_lang['lang_id']; ?>" <?php echo $selctlng; ?>><?php echo stripslashes($data_settngs_lang['lang_title']); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="theme-option">

                <button type="submit" class="btn green">Save</button>
                <button type="button" class="btn default toggler-close">Cancel</button>


            </div>
        </div>
    </div>
</form>