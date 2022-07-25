<?php
require_once './lib_index/init_index.php';
require_once './lib_index/html_index.php';


$mysqli = connection();

$semester_list = make_semester_list($mysqli);
//print_r($semester_list);
//Array ( [2021] => Array ( [0] => 2nd ) [2022] => Array ( [0] => 1st [1] => 2nd ) )

//end



$a = make_j_semester_list_script_html($semester_list);
echo $a;
$b = make_year_change_script_html($semester_list);
echo $b;
echo make_control_semester_select_by_year_select_script_html();
echo make_onload_script_html();
//뒤로가기 눌렀을시 어떡해야하는가

$c = make_form_html($semester_list);
echo $c;



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>강의 시간표 조회</title>
  </head>
  <body>
  </body>
</html>
