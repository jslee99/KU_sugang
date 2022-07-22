<?php
require_once('lib/library.php');

$mysqli = connection();

$semester_list = make_semester_list($mysqli);
//print_r($semester_list);
//Array ( [2021] => Array ( [0] => 2nd ) [2022] => Array ( [0] => 1st [1] => 2nd ) )

//end

$script_html = make_yearchange_function_script_html($semester_list);
echo $script_html;
$select_box_year_html = make_dropdown_year_html($semester_list);
echo $select_box_year_html;
$select_box_semester_html = make_dropdown_semester_html();
echo $select_box_semester_html;



echo "yes";
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
