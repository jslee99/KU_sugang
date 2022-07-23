<?php
function make_dropdown_year_html($semester_list){
  $year_list = array_keys($semester_list);
  //print_r($year_list);
  //Array ( [0] => 2021 [1] => 2022 )

  $select_box_html = '<select id="select_year" onchange="year_change(this)">';
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

function make_year_change_script_html(){
  $year_change_script_html .=
  '
  <script>
  function year_change(year_select_box){
    var select_semester = document.getElementById("select_semester");
    select_semester.options.length = 0;
    for(var i in j_semester_list[year_select_box.value]){
      var opt = document.createElement("option");
      opt.value = j_semester_list[year_select_box.value][i];
      opt.innerHTML = j_semester_list[year_select_box.value][i];
      select_semester.appendChild(opt);
      }
    }
  </script>';
  //getElementById("select_Semester")는 makePdropdwon_semester_html()의 <select id="select_semester">와 종속됨

  return $year_change_script_html;
}

function make_j_semester_list_script_html($semester_list){
  $j_semester_list_script_html =
  '<script>
    j_semester_list = [];';

  $year_list = array_keys($semester_list);
  foreach($year_list as $year){
    $j_semester_list_aapend_script_html = 'j_semester_list["'.$year.'"] = [];';
    foreach($semester_list[$year] as $semester){
      $j_semester_list_aapend_script_html .= 'j_semester_list["'.$year.'"].push("'.$semester.'");';
    }
    $j_semester_list_script_html .= $j_semester_list_aapend_script_html;
  }

  $j_semester_list_script_html .= '</script>';
  return $j_semester_list_script_html;
}
 ?>
