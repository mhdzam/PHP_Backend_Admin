<?php


require_once("../../includes/configuration.php");
//db connect
$conn = @mysql_connect($dbhost, $dbuname, $dbpass);
$db = @mysql_select_db($dbname, $conn) or die (mysql_error());
//---------------
mysql_query("SET NAMES 'utf8'");
mysql_query('SET CHARACTER SET utf8');
mysql_set_charset('utf8', $conn);

// Timezone
$sql_get_tz = mysql_query("SELECT * FROM " . $prefix . "_webmaster_settings  WHERE set_id ='1' ");
$data_get_site_tz = mysql_fetch_array($sql_get_tz);
$site_timezone = stripcslashes($data_get_site_tz['site_timezone']);
if($site_timezone!="") {
// Update PHP Timezone
    date_default_timezone_set($site_timezone);
// Update Mysql
    $now = new DateTime();
    $mins = $now->getOffset() / 60;
    $sgn = ($mins < 0 ? -1 : 1);
    $mins = abs($mins);
    $hrs = floor($mins / 60);
    $mins -= $hrs * 60;
    $offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);
    mysql_query("SET time_zone = '$offset'");
}

$lang = @$_GET['lang'];
$act = @$_GET['act'];
$chat = @$_POST['chat'];
$lastload = @$_GET['lastload'];
$pd_admin_user_id = @base64_decode( base64_decode($_COOKIE["pd_admin_user_id"]));

if ($pd_admin_user_id != "") {

    if ($act == "updatechat") {

        $lastlod = "";
        if ($lastload > 0) {
            $lastlod = " where chat_id > $lastload";
        }
        $sql_retrive = mysql_query("SELECT * FROM " . $prefix .
            "_users_chats $lastlod order by chat_date");

        ?>
        <script type="text/javascript">

            var cont = $('#chats');
            var list = $('.chats', cont);
            var form = $('.chat-form', cont);
            var input = $('input', form);
            var btn = $('.btn', form);


            <?php
            while ($data_retrive = mysql_fetch_array($sql_retrive)) {

                $clsnam="in";
                if($data_retrive['user_id']==$pd_admin_user_id){
                    $clsnam="out";
                }
                $sql_adminlog_check2 = mysql_query("SELECT * FROM " . $prefix .
                    "_users  where user_id='$data_retrive[user_id]'");

                $data_adminlog_check = mysql_fetch_array($sql_adminlog_check2);
                $logged_admin_user_name = stripcslashes($data_adminlog_check['user_name']);
                $logged_admin_control_type = stripcslashes($data_adminlog_check['control_type']);
                $logged_admin_user_photo = stripcslashes($data_adminlog_check['user_photo']);
                $logged_admin_user_fullname = stripcslashes($data_adminlog_check['user_fullname']);
                if($logged_admin_user_fullname==""){$logged_admin_user_fullname=$logged_admin_user_name;}
                $logged_admin_user_email = stripcslashes($data_adminlog_check['user_email']);

                $pd_current_date=date('Y-m-d', $_SERVER['REQUEST_TIME']);
                $day_mm=date('Y-m-d', strtotime($data_retrive['chat_date']));
                if($day_mm==$pd_current_date){
                    $chat_date=date('h:i:s A', strtotime($data_retrive['chat_date']));
                }else{
                    $chat_date=date('d-m-Y h:i:s A', strtotime($data_retrive['chat_date']));
                }
                $av_usr_img="assets/img/avatar.png";
                if($logged_admin_user_photo!=""){
                    $av_usr_img="../uploads/$logged_admin_user_photo";
                }

                $cht_is=str_replace("'","\'",stripcslashes($data_retrive['chat_text']));
                $cht_is=str_replace('"',"\"",$cht_is);
                ?>


            var tpl = '';
            tpl += '<li class="<?php echo $clsnam; ?>">';
            tpl += '<img class="avatar" src="<?php echo $av_usr_img; ?>"/>';
            tpl += '<div class="message">';
            tpl += '<span class="arrow"></span>';
            tpl += '<a href="#" class="name"><?php echo $logged_admin_user_fullname; ?></a>&nbsp;';
            tpl += '<span class="datetime"><small><small><?php echo $chat_date; ?></small></small></span>';
            tpl += '<span class="body">';
            tpl += '<?php echo $cht_is; ?>';
            tpl += '</span>';
            tpl += '</div>';
            tpl += '</li>';

            var msg = list.append(tpl);


            <?php
            $lastidis=$data_retrive['chat_id'];
            }

            if($lastidis>0){
            ?>
            $("#lastloadfld").val("<?php echo $lastidis; ?>");

            $('.scroller', cont).slimScroll({
                scrollTo: list.height()
            });
            <?php
            }
                    ?>


        </script>
        <?php
    } else {
        if ($chat != "") {
            $sql_slct_max = mysql_query("select max(chat_id)  from " . $prefix .
                "_users_chats");
            $data_slct_max = mysql_fetch_array($sql_slct_max);
            $next_chat_id = $data_slct_max[0] + 1;
            $sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_users_chats (
  chat_id,
  user_id,
  chat_date,
  read_status,
  chat_text) VALUES ('$next_chat_id','$pd_admin_user_id',now(),'0','$chat')");
        }
    }
}

?>