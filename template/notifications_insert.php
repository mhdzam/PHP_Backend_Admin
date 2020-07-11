<?php

$sql_slct_max_noti = mysql_query("select max(note_id)  from " . $prefix . "_notifications");
$data_slct_max_noti = mysql_fetch_array($sql_slct_max_noti);
$next_note_id = $data_slct_max_noti[0] + 1;
$sql_insert_new = mysql_query("INSERT INTO " . $prefix . "_notifications (
  note_id,
  note_type,
  note_title_ar,
  note_title_en,
  note_icon,
  note_url,
  note_date,
  note_status,
  edit_by,
  edit_from) VALUES ('$next_note_id','0','$note_title_ar','$note_title_en','$note_icon','$note_url',now(),'0','$pd_admin_user_id','$pd_admin_ip')");

?>