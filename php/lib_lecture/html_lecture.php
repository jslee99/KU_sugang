<?php
function make_dropdown_esoo_html($esoo_list){
  $dropdown_esoo_html = '<select id="esoo_select">';
  foreach($esoo_list as $esoo){
    $option_html = '<option value="';
    $option_html .= $esoo.'">';
    $option_html .= $esoo.'</option>';
    $dropdown_esoo_html .= $option_html;
  }
  $dropdown_esoo_html .= '</select>';
  return $dropdown_esoo_html;
}

function make_dropdown_department_html($department_list){
  $dropdown_department_html = '<select id="department_select">';
  foreach($department_list as $department){
    $option_html = '<option value="';
    $option_html .= $department.'">';
    $option_html .= $department.'</option>';
    $dropdown_department_html .= $option_html;
  }
  $dropdown_department_html .= '</select>';
  return $dropdown_department_html;
}


?>
