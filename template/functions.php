<?php
$pd_admin_ip = $_SERVER['REMOTE_ADDR']; 
$currentFile = $_SERVER["PHP_SELF"]; 
$parts = Explode('/', $currentFile); 
$pd_current_page_php = $parts[count($parts) - 1]; 
$pd_current_date = date('Y-m-d', $_SERVER['REQUEST_TIME']); 
$pd_before_29day_date = date('Y-m-d', strtotime('-29 day')); 
$pd_current_date_long = date('Y-m-d h:i A', $_SERVER['REQUEST_TIME']); 
$allowed_imgs_type = array(".gif", ".jpeg", ".png", ".jpg"); 
$allowed_attachfile_type = array(".gif", ".jpeg", ".png", ".jpg", ".rar", ".zip", ".txt", ".psd", ".doc", ".docx", ".pdf"); 
function GetAdminUserName($user_id) { 
	global $prefix; 
	$sql_user = mysql_query("SELECT * FROM " . $prefix . "_users where user_id ='$user_id'"); 
	$data_user = mysql_fetch_array($sql_user); 
	return stripcslashes($data_user['user_name']); 
} 
// to get the YouTube video ID from page link 
Function getYouTubeID($URL) { 
	$YouTubeCheck = preg_match('![?&]{1}v=([^&]+)!', $URL . '&', $Data); 
	If ($YouTubeCheck) { $VideoID = $Data[1]; } 
	Return $VideoID;
} 
// to get any file size 
Function GetFileSize($path) { 
	$bytes = sprintf('%u', filesize($path)); 
	if ($bytes > 0) { $unit = intval(log($bytes, 1024)); 
		$units = array('B', 'KB', 'MB', 'GB'); 
		if (array_key_exists($unit, $units) === true) {
			return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]); 
		} 
	} 
	return $bytes; 
	} 
// Format DateTime 
Function FormatDateTime($datetime) {
	global $pd_current_date; 
	$dtformated = ""; 
	if ($datetime != "") { 
		$day_mm = date('Y-m-d', strtotime($datetime)); 
		if ($day_mm == $pd_current_date) { 
		$dtformated = date('h:i A', strtotime($datetime)); 
		} else { 
		$dtformated = date('d-m-Y', strtotime($datetime)); 
		} 
	} 
	return $dtformated; 
} 
// Format DateTime Long 
Function FormatDateTimeLong($datetime) {
	global $pd_current_date; $dtformated = ""; 
	if ($datetime != "") { 
		$day_mm = date('Y-m-d', strtotime($datetime)); 
		if ($day_mm == $pd_current_date) {
			$dtformated = 'Today ' . date('h:i A', strtotime($datetime));
			} else {
			$dtformated = date('d-m-Y h:i A', strtotime($datetime));
			}
	}
		return $dtformated;
} 
/* backup the db OR just a table */ 
function backup_tables($host, $user, $pass, $name, $tables = '*') {
	global $up_dir; $handle = opendir($up_dir); 
	$files_count = 0; 
	while (($file0 = readdir($handle)) !== false) {
		if ($file0 != "." && $file0 != "..") {
			$files_count++; 
		}
	}
	closedir($handle); 
	$files_count++; 
	$link = mysql_connect($host, $user, $pass); 
	mysql_select_db($name, $link); 
	//get all of the tables 
	if ($tables == '*') {
		$tables = array(); 
		$result = mysql_query('SHOW TABLES'); 
		while ($row = mysql_fetch_row($result)) {
			$tables[] = $row[0];
		}
	} else {
		$tables = is_array($tables) ? $tables : explode(',', $tables); 
	} 
	$return = ""; 
	//cycle through 
	foreach ($tables as $table) {
		$result = mysql_query('SELECT * FROM ' . $table); 
		$num_fields = mysql_num_fields($result); 
		$return .= 'DROP TABLE IF EXISTS ' . $table . ';'; 
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE ' . $table)); 
		$return .= "\n\n" . $row2[1] . ";\n\n"; 
		for ($i = 0; $i < $num_fields; $i++) {
			while ($row = mysql_fetch_row($result)) {
				$return .= 'INSERT INTO ' . $table . ' VALUES('; 
				for ($j = 0; $j < $num_fields; $j++) {
					$row[$j] = addslashes($row[$j]); 
					$row[$j] = str_replace("\n", "\\n", $row[$j]); 
					if (isset($row[$j])) {
						$return .= '"' . $row[$j] . '"';
						} else {
							$return .= '""';
					}
					if ($j < ($num_fields - 1)) {
						$return .= ',';
					}
				}
				$return .= ");\n";
			}
		}
		$return .= "\n\n\n";
	}
	//save file 
	$f_name = "$up_dir" . 'backup-' . time() . '-(' . $files_count . ').sql'; 
	$handle = fopen($f_name, 'w+'); 
	fwrite($handle, $return); 
	fclose($handle); 
	return $f_name;
}
function get_youtube($url) {
	$youtube = "http://www.youtube.com/oembed?url=" . $url . "&format=json"; 
	$curl = curl_init($youtube); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
	$return = curl_exec($curl); 
	curl_close($curl); 
	return json_decode($return, true);
} 
function get_url_contents($url) {
	$crl = curl_init(); curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)'); 
	curl_setopt($crl, CURLOPT_URL, $url); 
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5); 
	$ret = curl_exec($crl); 
	curl_close($crl); 
	return $ret;
}

?>