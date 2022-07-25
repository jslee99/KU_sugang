<?php
  function connection(){
    $mysqli = new mysqli("localhost", "js1", "jgtmapm3876", "ku_sugang");
    if($mysqli -> connect_errno){
      echo "Falied to connection" . $mysqli -> connect_errno;
      exit();
    }
    return $mysqli;
  }

  function make_semester_list($mysqli){
    $table_list_obj = $mysqli->query("SHOW TABLES");
    //print_r($result);
    //mysqli_result Object ( [current_field] => 0 [field_count] => 1 [lengths] => [num_rows] => 2 [type] => 0 )
    $semester_list = array();
    //2차원 배열
    // 2022 => {1st, 2nd....}  2021 => {1st, 2nd.....}
    while($table_name = mysqli_fetch_row($table_list_obj)){
      //print_r($table_name);
      //Array ( [0] => 2022_1 )
      // echo $table_name[0];
      // 2022_1
      $year_semester = explode('_', $table_name[0]);// 0 => 2022, 1 => 1
      if(!array_key_exists($year_semester[0], $semester_list)){
        $semester_list[$year_semester[0]] = array();
        array_push($semester_list[$year_semester[0]], $year_semester[1]);
      }else{
        array_push($semester_list[$year_semester[0]], $year_semester[1]);
      }
    }

    //sorting
    ksort($semester_list);//key값 기준 sorting
    foreach($semester_list as $year){
      asort($year);
    }
    return $semester_list;
  }

?>
