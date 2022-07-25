<?php
function make_dropdown_esoo_html($esoo_list){
  $dropdown_esoo_html = '<select id="esoo_select" onchange="esoo_change(this)">';
  foreach($esoo_list as $esoo){
    $option_html = '<option value="';
    $option_html .= $esoo.'">';
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
  return '<select id="department_select">
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
            function esoo_change(esoo_select){
              console.log("yes");
              var department_select = document.getElementById("department_select");
              control_department_select_by_esoo_select(esoo_select, department_select);
            }
          </script>';
  return $html;
}

function make_onload_script_html(){
  $html = '<script>
          window.onload = function(){
            var esoo_select = document.getElementById("esoo_select");
            var department_select = document.getElementById("department_select");
            control_department_select_by_esoo_select(esoo_select, department_select);
          }
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
              department_select.disabled = true;
            }
          }
          </script>';
  return $html;
}
?>
