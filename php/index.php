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
$b = make_year_change_script_html();
echo $b;
$c = make_dropdown_year_html($semester_list);
echo $c;
$d = make_dropdown_semester_html($semester_list);
echo $d;



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
