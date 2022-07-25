<?php
require_once './lib_lecture/init_lecture.php';
require_once './lib_lecture/html_lecture.php';

$year = $_POST['year'];
$semester = $_POST['semester'];
$mysqli = connection();

echo $year;
echo $semester;

;

$esoo_list = make_esoo_list($mysqli, $year, $semester);
//print_r($esoo_list);
//Array ( [3] => 교직 [5] => 기교 [6] => 심교 [2] => 일선 [4] => 전선 [7] => 전필 [0] => 지교 [1] => 지필 )
// echo array_values($esoo_list)[0];
$department_list =  make_department_list($mysqli, $year, $semester);
//print_r($department_list);

echo make_j_department_list_script_html($department_list);
echo make_control_department_select_by_esoo_select_script_html();
echo make_onload_script_html();

echo make_esoo_change_script_html();
echo make_dropdown_esoo_html($esoo_list);
//echo $dropdown_esoo_html;
echo make_dropdown_department_html();
//echo $dropdown_department_html;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
