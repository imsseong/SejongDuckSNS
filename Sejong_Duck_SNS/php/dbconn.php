<?php

$conn = mysqli_connect("49.236.137.89","root","sjce-db123!@#","SejongDuckSNS");
mysqli_query($conn,"SET NAMES utf8");

if(!$conn){
  echo "연결에 실패하였습니다 : " .mysql_connect_error();
} else {
  echo "연결이 완료되었습니다! ";
}

?>
