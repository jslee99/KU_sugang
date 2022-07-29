<?php
require_once './lib_lecture/init_lecture.php';
require_once './lib_lecture/html_lecture.php';



$year = $_POST['year'];
$semester = $_POST['semester'];
$mysqli = connection();

if($_POST['is_search'] == 'false'){//처음 도착한 경우
  $body_html = '검색 조건 선택후 조회 버튼을 누르세요.';
}else{//검색하는경우
  $body_html = make_lecture_list_html($mysqli, $_POST['year'], $_POST['semester'], $_POST['esoo'], $_POST['department'], $_POST['detail_category'], $_POST['detail']);
}



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
  $form_html = make_form_html($year, $semester, $esoo_list, reset($esoo_list));
}else{
  $form_html = make_form_html($year, $semester, $esoo_list, $_POST['esoo']);
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>강의 시간표 조회</title>
    <?php
    echo make_j_department_list_script_html($department_list);
    echo make_control_department_select_by_esoo_select_script_html();
    if($_POST['is_search'] == 'false'){
      echo make_onload_script_html('not_search');
    }else{
      echo make_onload_script_html($_POST['department']);
    }
    echo make_esoo_change_script_html();
    ?>
  </head>
  <body>
    <?php
    echo $year;
    echo $semester;
    echo $form_html;

    echo $body_html; ?>
  </body>
</html>
