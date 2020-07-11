<?php

require_once("../../includes/connection.php");
require_once("functions.php");
require_once("lang.php");

$wm_section = @$_GET['ws_id'];

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Smart for Design")
    ->setLastModifiedBy("Smart for Design")
    ->setTitle("Sections")
    ->setSubject("Smart for Design")
    ->setDescription("Smart for Design")
    ->setKeywords("Smart for Design")
    ->setCategory("Smart for Design");

if ($act == "sections" && $wm_section != "") {

// Add some data
    $ixc = 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setRightToLeft(true)
        ->setCellValue('A' . $ixc, "ID")
        ->setCellValue('B' . $ixc, "$lang_var_admin_88")
        ->setCellValue('C' . $ixc, "$lang_var_admin_88")
        ->setCellValue('D' . $ixc, "$lang_var_admin_89")
        ->setCellValue('E' . $ixc, "$lang_var_admin_212")
        ->setCellValue('F' . $ixc, "$lang_var_admin_208")
        ->setCellValue('G' . $ixc, "$lang_var_admin_209");
    $ixc++;

    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_sections where wm_section_id='$wm_section' order by section_id");
    while ($data_retrive = mysql_fetch_array($sql_retrive)) {

        $sql_topics_count = mysql_query("SELECT * FROM " . $prefix . "_topics where wm_section_id='$wm_section' and  ( cat_id='$data_retrive[section_id]' OR cat_id in (SELECT section_id FROM " . $prefix . "_sections where wm_section_id='$wm_section' and father_id='$data_retrive[section_id]') )");
        $records_topics_count = mysql_num_rows($sql_topics_count);

        $edit_date = $data_retrive['edit_date'];
        $edit_by = GetAdminUserName($data_retrive['edit_by']);
        $edit_from = $data_retrive['edit_from'];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $ixc, $data_retrive['section_id'])
            ->setCellValue('B' . $ixc, stripcslashes($data_retrive['section_title_en']))
            ->setCellValue('C' . $ixc, stripcslashes($data_retrive['section_title_ar']))
            ->setCellValue('D' . $ixc, stripcslashes($data_retrive['visits']))
            ->setCellValue('E' . $ixc, $records_topics_count)
            ->setCellValue('F' . $ixc, $edit_date)
            ->setCellValue('G' . $ixc, $edit_by);

        $ixc++;;
    }

} elseif ($act == "topics" && $wm_section != "") {

// Add some data
    $ixc = 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setRightToLeft(true)
        ->setCellValue('A' . $ixc, "ID")
        ->setCellValue('B' . $ixc, "$lang_var_admin_102")
        ->setCellValue('C' . $ixc, "$lang_var_admin_102")
        ->setCellValue('D' . $ixc, "$lang_var_admin_99")
        ->setCellValue('E' . $ixc, "$lang_var_admin_89")
        ->setCellValue('F' . $ixc, "$lang_var_admin_208")
        ->setCellValue('G' . $ixc, "$lang_var_admin_209");
    $ixc++;

    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_topics where wm_section_id='$wm_section' order by topic_id");
    while ($data_retrive = mysql_fetch_array($sql_retrive)) {

        $sql_get_sections = mysql_query("SELECT * FROM " . $prefix . "_sections  WHERE section_id ='$data_retrive[cat_id]'");
        $data_get_sections = mysql_fetch_array($sql_get_sections);
        $section_title_is = stripcslashes($data_get_sections['section_title_' . $lang]);

        $edit_date = $data_retrive['edit_date'];
        $edit_by = GetAdminUserName($data_retrive['edit_by']);
        $edit_from = $data_retrive['edit_from'];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $ixc, stripcslashes($data_retrive['topic_id']))
            ->setCellValue('B' . $ixc, stripcslashes($data_retrive['topic_title_ar']))
            ->setCellValue('C' . $ixc, stripcslashes($data_retrive['topic_title_en']))
            ->setCellValue('D' . $ixc, $section_title_is)
            ->setCellValue('E' . $ixc, stripcslashes($data_retrive['visits']))
            ->setCellValue('F' . $ixc, $edit_date)
            ->setCellValue('G' . $ixc, $edit_by);
        $ixc++;;
    }


} elseif ($act == "comments" && $wm_section != "") {

// Add some data
    $ixc = 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setRightToLeft(true)
        ->setCellValue('A' . $ixc, "ID")
        ->setCellValue('B' . $ixc, "$lang_var_admin_102")
        ->setCellValue('C' . $ixc, "$lang_var_admin_209")
        ->setCellValue('D' . $ixc, "$lang_var_admin_15")
        ->setCellValue('E' . $ixc, "$lang_var_admin_127")
        ->setCellValue('F' . $ixc, "$lang_var_admin_208")
        ->setCellValue('G' . $ixc, "$lang_var_admin_209");
    $ixc++;

    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_topics_comments where wm_section_id='$wm_section' order by comment_id");
    while ($data_retrive = mysql_fetch_array($sql_retrive)) {

        $sql_get_sections = mysql_query("SELECT * FROM " . $prefix . "_topics  WHERE topic_id ='$data_retrive[topic_id]'");
        $data_get_sections = mysql_fetch_array($sql_get_sections);
        $topic_title_is = stripcslashes($data_get_sections['topic_title_' . $lang]);

        $edit_date = $data_retrive['edit_date'];
        $edit_by = GetAdminUserName($data_retrive['edit_by']);
        $edit_from = $data_retrive['edit_from'];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $ixc, $data_retrive['comment_id'])
            ->setCellValue('B' . $ixc, $topic_title_is)
            ->setCellValue('C' . $ixc, stripcslashes($data_retrive['name']))
            ->setCellValue('D' . $ixc, stripcslashes($data_retrive['email']))
            ->setCellValue('E' . $ixc, stripcslashes($data_retrive['comment']))
            ->setCellValue('F' . $ixc, $edit_date)
            ->setCellValue('G' . $ixc, $edit_by);

        $ixc++;;
    }

} elseif ($act == "inbox") {

// Add some data
    $ixc = 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setRightToLeft(true)
        ->setCellValue('A' . $ixc, "ID")
        ->setCellValue('B' . $ixc, "$lang_var_admin_161")
        ->setCellValue('C' . $ixc, "$lang_var_admin_179")
        ->setCellValue('D' . $ixc, "$lang_var_admin_182")
        ->setCellValue('E' . $ixc, "$lang_var_admin_99")
        ->setCellValue('F' . $ixc, "$lang_var_admin_208")
        ->setCellValue('G' . $ixc, "$lang_var_admin_209");
    $ixc++;

    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_webmail order by cat_id, wm_date");
    while ($data_retrive = mysql_fetch_array($sql_retrive)) {

        if ($data_retrive['cat_id'] == 3) {
            $cat_sttxt = "$lang_var_admin_163";
        } elseif ($data_retrive['cat_id'] == 2) {
            $cat_sttxt = "$lang_var_admin_162";
        } elseif ($data_retrive['cat_id'] == 1) {
            $cat_sttxt = "$lang_var_admin_161";
        } else {
            $cat_sttxt = "$lang_var_admin_160";
        }

        $edit_date = $data_retrive['edit_date'];
        $edit_by = GetAdminUserName($data_retrive['edit_by']);
        $edit_from = $data_retrive['edit_from'];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $ixc, $data_retrive['wm_id'])
            ->setCellValue('B' . $ixc, stripcslashes($data_retrive['wm_from']))
            ->setCellValue('C' . $ixc, stripcslashes($data_retrive['wm_to_email']))
            ->setCellValue('D' . $ixc, stripcslashes($data_retrive['wm_title']))
            ->setCellValue('E' . $ixc, $cat_sttxt)
            ->setCellValue('F' . $ixc, $edit_date)
            ->setCellValue('G' . $ixc, $edit_by);

        $ixc++;;
    }


} elseif ($act == "newsletter") {

// Add some data
    $ixc = 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setRightToLeft(true)
        ->setCellValue('A' . $ixc, "ID")
        ->setCellValue('B' . $ixc, "$lang_var_admin_283")
        ->setCellValue('C' . $ixc, "$lang_var_admin_15")
        ->setCellValue('D' . $ixc, "$lang_var_admin_284");
    $ixc++;

    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_newsletter order by nl_id");
    while ($data_retrive = mysql_fetch_array($sql_retrive)) {


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $ixc, $data_retrive['nl_id'])
            ->setCellValue('B' . $ixc, stripcslashes($data_retrive['nl_name']))
            ->setCellValue('C' . $ixc, stripcslashes($data_retrive['nl_email']))
            ->setCellValue('D' . $ixc, stripcslashes($data_retrive['nl_phone']));

        $ixc++;;
    }


} elseif ($act == "banars") {

// Add some data
    $ixc = 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setRightToLeft(true)
        ->setCellValue('A' . $ixc, "ID")
        ->setCellValue('B' . $ixc, "$lang_var_admin_213")
        ->setCellValue('C' . $ixc, "$lang_var_admin_213")
        ->setCellValue('D' . $ixc, "$lang_var_admin_144")
        ->setCellValue('E' . $ixc, "$lang_var_admin_145")
        ->setCellValue('F' . $ixc, "$lang_var_admin_208")
        ->setCellValue('G' . $ixc, "$lang_var_admin_209");
    $ixc++;

    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_banars order by banar_id");
    while ($data_retrive = mysql_fetch_array($sql_retrive)) {

        $sql_get_sections = mysql_query("SELECT * FROM " . $prefix . "_banars_sections  WHERE bs_status=1 and bs_id ='$data_retrive[bs_id]'");
        $data_get_sections = mysql_fetch_array($sql_get_sections);
        $bs_name_var = stripcslashes($data_get_sections['bs_name_var']);
        $bs_name_var = @$$bs_name_var;
        $bs_height = stripcslashes($data_get_sections['bs_height']);
        $bs_width = stripcslashes($data_get_sections['bs_width']);
        $bs_period = stripcslashes($data_get_sections['bs_period']);
        $bs_desc_status = stripcslashes($data_get_sections['bs_desc_status']);
        $bs_link_status = stripcslashes($data_get_sections['bs_link_status']);
        $bs_type = stripcslashes($data_get_sections['bs_type']);


        $edit_date = $data_retrive['edit_date'];
        $edit_by = GetAdminUserName($data_retrive['edit_by']);
        $edit_from = $data_retrive['edit_from'];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $ixc, $data_retrive['banar_id'])
            ->setCellValue('B' . $ixc, stripcslashes($data_retrive['banar_title_ar']))
            ->setCellValue('C' . $ixc, stripcslashes($data_retrive['banar_title_en']))
            ->setCellValue('D' . $ixc, $bs_name_var)
            ->setCellValue('E' . $ixc, $bs_width . " X " . $bs_height)
            ->setCellValue('F' . $ixc, $edit_date)
            ->setCellValue('G' . $ixc, $edit_by);

        $ixc++;;
    }


} elseif ($act == "calendar") {


// Add some data
    $ixc = 1;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setRightToLeft(true)
        ->setCellValue('A' . $ixc, "ID")
        ->setCellValue('B' . $ixc, "$lang_var_admin_197")
        ->setCellValue('C' . $ixc, "$lang_var_admin_198")
        ->setCellValue('D' . $ixc, "$lang_var_admin_201")
        ->setCellValue('E' . $ixc, "$lang_var_admin_103")
        ->setCellValue('F' . $ixc, "$lang_var_admin_208")
        ->setCellValue('G' . $ixc, "$lang_var_admin_209");
    $ixc++;

    $sql_retrive = mysql_query("SELECT * FROM " . $prefix . "_calendar order by from_date");
    while ($data_retrive = mysql_fetch_array($sql_retrive)) {

        $event_date_from = "";
        if ($data_retrive['from_date'] != "") {
            $event_date_from = date('d-m-Y h:i A', strtotime($data_retrive['from_date']));
        }
        $event_date_to = "";
        if ($data_retrive['to_date'] != "") {
            $event_date_to = date('d-m-Y h:i A', strtotime($data_retrive['to_date']));
        }

        $edit_date = $data_retrive['edit_date'];
        $edit_by = GetAdminUserName($data_retrive['edit_by']);
        $edit_from = $data_retrive['edit_from'];

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $ixc, $data_retrive['cal_id'])
            ->setCellValue('B' . $ixc, $event_date_from)
            ->setCellValue('C' . $ixc, $event_date_to)
            ->setCellValue('D' . $ixc, stripcslashes($data_retrive['cal_title']))
            ->setCellValue('E' . $ixc, stripcslashes($data_retrive['cal_details']))
            ->setCellValue('F' . $ixc, $edit_date)
            ->setCellValue('G' . $ixc, $edit_by);

        $ixc++;;
    }


}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="export.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


?>