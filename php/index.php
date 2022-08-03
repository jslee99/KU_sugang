<?php
require_once './lib_index/init_index.php';
require_once './lib_index/html_index.php';


$mysqli = connection();

$semester_list = make_semester_list($mysqli);
//print_r($semester_list);
//Array ( [2021] => Array ( [0] => 2nd ) [2022] => Array ( [0] => 1st [1] => 2nd ) )

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>강의 시간표 조회</title>
    <?php echo make_entire_script_html($semester_list); ?>
  </head>
  <body>
    <?php echo make_form_html($semester_list); ?>
  </body>
</html>
