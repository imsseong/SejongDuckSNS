<?php
session_start();
$res=session_destroy();
if($res){
  echo "로그아웃 단계";
  //header('Location: ../home.html');
}
 ?>
