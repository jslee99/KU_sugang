<?php
require_once './lib/init.php';
require_once './lib/make_html.php';


$mysqli = connection();

$semester_list = make_semester_list($mysqli);
//print_r($semester_list);
//Array ( [2021] => Array ( [0] => 2nd ) [2022] => Array ( [0] => 1st [1] => 2nd ) )

//end



$a = make_j_semester_list_script_html($semester_list);
echo $a;
$b = make_year_change_script_html($semester_list);
echo $b;
$c = make_form_html($semester_list);
echo $c;
echo make_onload_script_html();
//뒤로가기 눌렀을시 어떡해야하는가?


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
