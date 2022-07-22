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

  function make_dropdown_year_html($semester_list){
    $year_list = array_keys($semester_list);
    //print_r($year_list);
    //Array ( [0] => 2021 [1] => 2022 )

    $select_box_html = '<select id="select_year" onchange="year_change(this)">';
    $select_box_html .= '<option>년도</option>';
    foreach($year_list as $year){
      //print_r($year);
      $option_html = '<option value="';
      $option_html .= $year.'">';
      $option_html .= $year.'</option>';
      $select_box_html .= $option_html;
    }
    $select_box_html .= '</select>';
    return $select_box_html;
  }

  function make_dropdown_semester_html(){
    return '<select id="select_semester">
            </select>';
  }

  function make_yearchange_function_script_html($semester_list){
    $script_yearchange_function_html =
    '<script>
      function year_change(year_select_box){
        var j_semester_list = [];';

    $year_list = array_keys($semester_list);

    //print_r($year_list);

    foreach($year_list as $year){
      $j_semester_list_append_script_html = 'j_semester_list["'.$year.'"] = [];';
      foreach($semester_list[$year] as $semester){
        //echo $semester;
        $j_semester_list_append_script_html .= 'j_semester_list["'.$year.'"].push("'.$semester.'");';
      }
    }
    $script_yearchange_function_html .= $j_semester_list_append_script_html;

    $script_yearchange_function_html .=
      '
      var target = document.getElementById("select_semester");
      target.options.length = 0;


      for(var i in j_semester_list[year_select_box.value]){
        var opt = document.createElement("option");
        opt.value = j_semester_list[year_select_box.value][i];
        opt.innerHTML = j_semester_list[year_select_box.value][i];
        target.appendChild(opt);
        }
      }
    </script>';

    return $script_yearchange_function_html;
  }

?>
