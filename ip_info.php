<?php

$Page_time_started_at = microtime(true);

function getBrowser()
{
    // check if IE 8 - 11+
    preg_match('/Trident\/(.*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if ($matches) {
        $version = intval($matches[1]) + 4;     // Trident 4 for IE8, 5 for IE9, etc
        return 'Internet Explorer ' . ($version < 11 ? $version : $version);
    }

    preg_match('/MSIE (.*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if ($matches) {
        return 'Internet Explorer ' . intval($matches[1]);
    }

    // check if Firefox, Opera, Chrome, Safari
    foreach (array('Firefox', 'OPR', 'Chrome', 'Safari') as $browser) {
        preg_match('/' . $browser . '/', $_SERVER['HTTP_USER_AGENT'], $matches);
        if ($matches) {
            return str_replace('OPR', 'Opera', $browser);   // we don't care about the version, because this is a modern browser that updates itself unlike IE
        }
    }
}


function getOS()
{

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform = "unknown";

    $os_array = array(
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }

    }

    return $os_platform;

}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
{
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city" => @$ipdat->geoplugin_city,
                        "state" => @$ipdat->geoplugin_regionName,
                        "country" => @$ipdat->geoplugin_countryName,
                        "country_code" => @$ipdat->geoplugin_countryCode,
                        "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

include("includes/global.php");

$sql_tv = mysql_query("SELECT * FROM pd_geo_pageviews order by rand() limit 20");
while ($data_tv = mysql_fetch_array($sql_tv)) {

    $ip = $data_tv['ip_address'];
//$ip=$_SERVER['REMOTE_ADDR'];

    $visitor_referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "unknown";
    $visitor_browser = getBrowser();
    $visitor_os = getOS();

    $visitor_country_code = ip_info($ip, "Country Code");
    if ($visitor_country_code == "") {
        $visitor_country_code = "unknown";
    }
    $visitor_country = ip_info($ip, "Country");
    if ($visitor_country == "") {
        $visitor_country = "unknown";
    }
    $visitor_address = ip_info($ip, "Address");
    if ($visitor_address == "") {
        $visitor_address = "unknown";
    }

    $visitor_ip_details = json_decode(@file_get_contents("http://ipinfo.io/{$ip}/json"));
    $visitor_city = @$visitor_ip_details->city;
    if ($visitor_city == "") {
        $visitor_city = "unknown";
    }
    $visitor_hostname = @$visitor_ip_details->hostname;
    if ($visitor_hostname == "") {
        $visitor_hostname = "No Hostname";
    }
    $visitor_loc = explode(',', @$visitor_ip_details->loc);
    $visitor_loc_0 = @$loc[0];
    if ($visitor_loc_0 == "") {
        $visitor_loc_0 = "unknown";
    }
    $visitor_loc_1 = @$loc[1];
    if ($visitor_loc_1 == "") {
        $visitor_loc_1 = "unknown";
    }
    $visitor_org = @$visitor_ip_details->org;
    if ($visitor_org == "") {
        $visitor_org = "unknown";
    }
    $visitor_region = @$visitor_ip_details->region;
    if ($visitor_region == "") {
        $visitor_region = "unknown";
    }

    echo "$ip<br />$visitor_city<br />$visitor_country_code<br />$visitor_country<br />$visitor_region<br />$visitor_loc_0<br />$visitor_loc_1<br />$visitor_address<br />$visitor_browser<br />$visitor_os<br />$visitor_referrer<br />$visitor_hostname<br />$visitor_org<br />";


    $visitor_screen_res = "unknown";
    if (isset($_COOKIE["device_resolution"])) {
        $visitor_screen_res = @$_COOKIE["device_resolution"];
    }
    echo @$visitor_screen_res;

    $ldtime = round((microtime(true) - $Page_time_started_at), 3);

    $query_string = $_SERVER['QUERY_STRING'];
    $currentFile = $_SERVER["PHP_SELF"];
    $web_pageparts = Explode('/', $currentFile);
    $web_page = $web_pageparts[count($web_pageparts) - 1];
    $visitor_date = date("Y-m-d");
    $visitor_time = date("H:i:s");

    echo "$query_string<br />$web_page<br />$visitor_date<br />$visitor_time";


    $d = "select max(visitor_id)  from " . $prefix . "_analytics_visitors";
    $sqlb = mysql_query($d);
    $re = mysql_fetch_array($sqlb);
    $vvv_id = $re[0] + 1;

    $sql1 = mysql_query("INSERT INTO " . $prefix . "_analytics_visitors (
  visitor_id,
  visitor_ip,
  visitor_city,
  visitor_country_code,
  visitor_country,
  visitor_region,
  visitor_full_address,
  visitor_location_cor1,
  visitor_location_cor2,
  visitor_os,
  visitor_browser,
  visitor_resolution,
  visitor_referrer,
  visitor_hostname,
  visitor_org,
  visitor_date,
  visitor_time) VALUES ('$vvv_id','$ip','$visitor_city','$visitor_country_code','$visitor_country','$visitor_region','$visitor_address','$visitor_loc_0','$visitor_loc_1','$visitor_os','$visitor_browser','$visitor_screen_res','$visitor_referrer','$visitor_hostname','$visitor_org','$data_tv[v_date]','$data_tv[v_time]')");

    if ($sql1) {
        $sql2 = mysql_query("INSERT INTO " . $prefix . "_analytics_pages (
  visitor_id,
  page_title,
  page_name,
  page_query,
  page_loadtime,
  visitor_date,
  visitor_time) VALUES ('$vvv_id','','$data_tv[page_name]','','$ldtime','$data_tv[v_date]','$data_tv[v_time]')");
    }
}


?>
