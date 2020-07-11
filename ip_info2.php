<?php

include("includes/global.php");

$state = @$_GET['state'];

$srchbystate = "";
if ($state == "city") {
    $srchbystate = "visitor_city";
} elseif ($state == "country") {
    $srchbystate = "visitor_country";
} elseif ($state == "region") {
    $srchbystate = "visitor_region";
} elseif ($state == "os") {
    $srchbystate = "visitor_os";
} elseif ($state == "browser") {
    $srchbystate = "visitor_browser";
} elseif ($state == "resolution") {
    $srchbystate = "visitor_resolution";
} elseif ($state == "referrer") {
    $srchbystate = "visitor_referrer";
} elseif ($state == "hostname") {
    $srchbystate = "visitor_hostname";
} elseif ($state == "org") {
    $srchbystate = "visitor_org";
} else {
    $srchbystate = "visitor_date";
}
$sql_tv = mysql_query("SELECT *,COUNT($srchbystate) as vvcccnnt FROM " . $prefix . "_analytics_visitors GROUP BY $srchbystate ORDER BY COUNT($srchbystate) desc");
while ($data_tv = mysql_fetch_array($sql_tv)) {

    $sql_pgs = mysql_query("SELECT COUNT($srchbystate) as ppcccnnt FROM " . $prefix . "_analytics_visitors where visitor_id='$data_tv[visitor_id]' ");
    $data_pgs = mysql_fetch_array($sql_pgs);

    echo "$data_tv[$srchbystate] : $data_tv[vvcccnnt] , $data_pgs[ppcccnnt]<br />";
}

?>
