<?php
function make_dropdown_esoo_html($esoo_list, $selected_esoo){
  $dropdown_esoo_html = '<select id="esoo_select" name="esoo" onchange="esoo_change(this,document.getElementById(\'department_select\').value)">';
  foreach($esoo_list as $esoo){
    $option_html = '<option value="';
    $option_html .= $esoo.'"';
    if($esoo == $selected_esoo){
      $option_html .= ' selected>';
    }else{
      $option_html .= '>';
    }
    $option_html .= $esoo.'</option>';
    $dropdown_esoo_html .= $option_html;
  }
  $dropdown_esoo_html .= '</select>';
  return $dropdown_esoo_html;
}

// function make_dropdown_department_html($department_list){
//   $dropdown_department_html = '<select id="department_select">';
//   foreach($department_list as $department){
//     $option_html = '<option value="';
//     $option_html .= $department.'">';
//     $option_html .= $department.'</option>';
//     $dropdown_department_html .= $option_html;
//   }
//   $dropdown_department_html .= '</select>';
//   return $dropdown_department_html;
// }

function make_dropdown_department_html(){
  return '<select id="department_select" name="department">
          </select>';
}

function make_j_department_list_script_html($department_list){
  $html = '<script>
            j_department_list = [];';
  foreach($department_list as $department){
    $append_html = 'j_department_list.push("'.$department.'");';
    $html .= $append_html;
  }

  $html .= '</script>';

  return $html;
}

function make_esoo_change_script_html(){
  $html = '<script>
            function esoo_change(esoo_select, selected_department){
              var department_select = document.getElementById("department_select");
              control_department_select_by_esoo_select(esoo_select, department_select);

              if(department_select.value != "전체학과" && selected_department != "전체학과"){
                department_select.value = selected_department;
              }
              // 똑같은 기능이지만 비효율적임
              // for(var i = 0; i < department_select.options.length; i++){
              //   if(department_select.options[i].value == selected_department){
              //     department_select.options[i].selected = true;
              //   }
              // }
            }
          </script>';
  return $html;
}

function make_onload_script_html($selected_department){
  $html = '<script>
          window.onload = function(){
            var selected_department = "'.$selected_department.'";
            var esoo_select = document.getElementById("esoo_select");
            var department_select = document.getElementById("department_select");
            control_department_select_by_esoo_select(esoo_select, department_select);
            if(selected_department != "not_search"){
              department_select.value = selected_department;
            }
          };
          </script>';
  return $html;
}

function make_control_department_select_by_esoo_select_script_html(){
  $html = '<script>
          function control_department_select_by_esoo_select(esoo_select, department_select){
            department_select.options.length = 0;
            if(esoo_select.value == "전필" || esoo_select.value == "전선" || esoo_select.value == "지교" || esoo_select.value == "지필"){
              for(var i in j_department_list){
                var opt = document.createElement("option");
                opt.value = j_department_list[i];
                opt.innerHTML = j_department_list[i];
                department_select.appendChild(opt);
              }
              department_select.disabled = false;
            }else{
              var opt = document.createElement("option");
              opt.value = "전체학과";
              opt.innerHTML = "전체학과";
              department_select.appendChild(opt);
              //department_select.disabled = true;
            }
          }
          </script>';
  return $html;
}

function make_dropdown_detail_category(){
  $html = '<select id="detail_category_select" name="detail_category">
            <option value="과목명">과목명</option>
            <option value="과목번호">과목번호</option>
            <option value="교강사">교강사</option>
          </select>';
  return $html;
}

function make_text_detail(){
  $html = '<textarea id="detail_text" name="detail" style="height:18px"></textarea>';
  return $html;
}

function make_form_html($year, $semester, $esoo_list, $selected_esoo){
  $html = '<form action="lecture.php" accept-charset="utf-8" name="all_search_info" method="post">';
  $html .= '<input type="hidden" name="is_search" value="true">';
  $html .= '<input type="hidden" name="year" value="'.$year.'">';
  $html .= '<input type="hidden" name="semester" value="'.$semester.'">';
  $html .= make_dropdown_esoo_html($esoo_list, $selected_esoo);
  $html .= make_dropdown_department_html();
  $html .= make_dropdown_detail_category();
  $html .= make_text_detail();
  $html .= '<input type="submit" value="조회">
            </form>';
  return $html;
}

function make_lecture_list_html($mysqli, $year, $semester, $esoo, $department, $detail_category, $detail){
  $sql = "select * from ".$year."_".$semester." where category = '".$esoo."' ";
  // if($esoo == '전선' || $esoo == '전필' || $esoo == '지교' || $esoo == '지필
  if($department != '전체학과'){
    $sql .= "and department = '".$department."' ";
  }
  if($detail != ''){
    if($detail_category == '과목명'){
      $sql .= "and title = '".$detail."' ";
    }elseif ($detail_category == '과목번호') {
      $sql .= "and id = ".$detail." ";
    }else{//교강사
      $sql .= "and professor like '%".$detail."%' ";
    }
  }
  $sql .= ";";

  $html = '<table border=1>';
  $html .= make_thead_html();
  $html .= '<tbody>';

  // echo $sql;
  $result = $mysqli->query($sql);
  while($row = $result->fetch_assoc()){
    // print_r($row);
    //Array ( [haksu_id] => BKSA11087 [category] => 기교 [id] => 1200 [title] => 사회봉사1 [credit] => 1 [hours] => 2 [how] => e-러닝(녹화) [_language] =>   [note] => [실습 과목 비대면 운영 사유] 1주차 OT가 방역 상황으로 인해 비대면(녹화 동영상)으로 전환됨에 따라 이러닝 수업으로 수정됨. 학생들의 현장봉사활동이므로 대면으로 진행하지 않음 [category_of_elective] => 인성 [grade] => 9 [department] => 상허교양대학 [professor] => 송지호 [summary] => 월17-19(온라인(녹화))(e-러닝) )
    $tr_html = '<tr>';
    $tr_html .= '<td>'.$row['haksu_id'].'</td>';
    $tr_html .= '<td>'.$row['category'].'</td>';
    $tr_html .= '<td>'.$row['id'].'</td>';
    $tr_html .= '<td>'.$row['title'].'</td>';
    $tr_html .= '<td>'.$row['credit'].'</td>';
    $tr_html .= '<td>'.$row['hours'].'</td>';
    $tr_html .= '<td>'.$row['how'].'</td>';
    $tr_html .= '<td>'.$row['_language'].'</td>';
    $tr_html .= '<td>'.$row['note'].'</td>';
    $tr_html .= '<td>'.$row['category_of_elective'].'</td>';
    $tr_html .= '<td>'.$row['grade'].'</td>';
    $tr_html .= '<td>'.$row['department'].'</td>';
    $tr_html .= '<td>'.$row['professor'].'</td>';
    $tr_html .= '<td>'.$row['summary'].'</td>';
    $tr_html .= '</tr>';
    $html .= $tr_html;
  }
  $html .= '</tbody>';
  $html .= '</table>';


  return $html;
}

function make_thead_html(){
  return '<thead>
            <tr>
              <th>학수번호</th>
              <th>이수구분</th>
              <th>과목번호</th>
              <th>과목명</th>
              <th>학점</th>
              <th>시간</th>
              <th>강의종류</th>
              <th>원어유형</th>
              <th>비고</th>
              <th>교양영역</th>
              <th>개설학년</th>
              <th>개설학과</th>
              <th>교강사</th>
              <th>강의요시</th>
            </tr>
          </thead>';
}
?>
