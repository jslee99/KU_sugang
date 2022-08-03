<?php
require_once './lib_lecture/init_lecture.php';
require_once './lib_lecture/html_lecture.php';



$year = $_POST['year'];
$semester = $_POST['semester'];
$mysqli = connection();
$esoo_list = make_esoo_list($mysqli, $year, $semester);
//print_r($esoo_list);
//Array ( [3] => 교직 [5] => 기교 [6] => 심교 [2] => 일선 [4] => 전선 [7] => 전필 [0] => 지교 [1] => 지필 )
// echo array_values($esoo_list)[0];
$department_list =  make_department_list($mysqli, $year, $semester);
//print_r($department_list);


// echo make_dropdown_esoo_html($esoo_list);
// //echo $dropdown_esoo_html;
// echo make_dropdown_department_html();
// //echo $dropdown_department_html;
// echo make_dropdown_detail_category();
// echo make_text_detail();
if($_POST['is_search'] == 'false'){
  $body_html = '검색 조건 선택후 조회 버튼을 누르세요.';
  $form_html = make_form_html($year, $semester, $esoo_list, reset($esoo_list));
  $script_html = make_entire_script_html($department_list, 'not_search');
}else{
  $body_html = make_lecture_list_html($mysqli, $_POST['year'], $_POST['semester'], $_POST['esoo'], $_POST['department'], $_POST['detail_category'], $_POST['detail']);
  $form_html = make_form_html($year, $semester, $esoo_list, $_POST['esoo']);
  $script_html = make_entire_script_html($department_list, $_POST['department']);
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>강의 시간표 조회</title>
    <?php echo $script_html; ?>
  </head>
  <body>
    <?php
    echo $form_html;

    echo $body_html; ?>
  </body>
</html>
