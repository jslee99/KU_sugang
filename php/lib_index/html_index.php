<?php
function make_dropdown_year_html($semester_list){
  $year_list = array_keys($semester_list);
  //print_r($year_list);
  //Array ( [0] => 2021 [1] => 2022 )

  $select_box_html = '<select name="year" id="select_year" onchange="year_change(this)">';
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

function make_dropdown_semester_html($semester_list){
  // $year_list = array_keys($semester_list);

  $dropdown_semester_html = '<select name="semester" id="select_semester">';
  // foreach($semester_list[$year_list[0]] as $semester){
  //   $option_html = '<option value="';
  //   $option_html .= $semester.'">';
  //   $option_html .= $semester.'</option>';
  //   $dropdown_semester_html .= $option_html;
  // }
  $dropdown_semester_html .= '</select>';
  return $dropdown_semester_html;
}

function make_year_change_script_html(){
  $year_change_script_html .=
  '
  <script>
  function year_change(year_select_box){
    var select_semester = document.getElementById("select_semester");
    control_semester_select_by_year_select(year_select_box, select_semester);
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

function make_form_html($semester_list){
    $form_html = '<form action="lecture.php" accept-charset="utf-8" name="year_semester_info" method="post">';
    $form_html .= '<input type="hidden" name="is_search" value="false">';
    $form_html .= make_dropdown_year_html($semester_list);
    $form_html .= make_dropdown_semester_html($semester_list);
    $form_html .= '<input type="submit">
                  </form>';
    return $form_html;
}

function make_onload_script_html(){
  return '<script>
          window.onload = function(){
            var select_year = document.getElementById("select_year");
            var select_semester = document.getElementById("select_semester");
            control_semester_select_by_year_select(select_year, select_semester);
          }

          window.onpageshow = function(event) {
            if ( event.persisted || (window.performance && window.performance.navigation.type == 2)) {
              // Back Forward Cache로 브라우저가 로딩될 경우 혹은 브라우저 뒤로가기 했을 경우
              //현재 페이지에서 다른 페이지로 간후, 또다시 현재 페이지로 뒤로가기 누른경우에 이 함수 실행
              var select_year = document.getElementById("select_year");
              var select_semester = document.getElementById("select_semester");
              control_semester_select_by_year_select(select_year, select_semester);
            }
          }
        </script>';
}

function make_control_semester_select_by_year_select_script_html(){
  $html = '<script>
            function control_semester_select_by_year_select(year_select, semester_select){
              semester_select.options.length = 0;
              for(var i in j_semester_list[year_select.value]){
                var opt = document.createElement("option");
                opt.value = j_semester_list[year_select.value][i];
                opt.innerHTML = j_semester_list[year_select.value][i];
                semester_select.appendChild(opt);
              }
            }
          </script>';

  return $html;
}
 ?>
