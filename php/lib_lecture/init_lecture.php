<?php
function connection(){
  $mysqli = new mysqli("localhost", "js1", "jgtmapm3876", "ku_sugang");
  if($mysqli -> connect_errno){
    echo "Falied to connection" . $mysqli -> connect_errno;
    exit();
  }
  return $mysqli;
}

function make_esoo_list($mysqli, $year, $semester){
  $esoo_list = array();
  $sql = 'select distinct(category) from '.$year.'_'.$semester;
  $result = $mysqli->query($sql);
  while($row = mysqli_fetch_row($result)){
    array_push($esoo_list, $row[0]);
  }
  asort($esoo_list);
  return $esoo_list;
}

function make_department_list($mysqli, $year, $semester){
  $department_list = array();
  $sql = 'select distinct(department) from '.$year.'_'.$semester;
  $result = $mysqli->query($sql);
  while($row = mysqli_fetch_row($result)){
    array_push($department_list, $row[0]);
  }
  asort($department_list);
  return $department_list;
}
?>
