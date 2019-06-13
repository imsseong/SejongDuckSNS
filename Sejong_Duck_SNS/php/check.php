<?php

//error_reporting(E_ALL);
//ini_set("display_errors",1);
session_start();

if(!isset($_SESSION['loginId'])) { //세션이없을때 = 로그인상태가 아닐때
  echo "<script>alert('로그인 해야합니다!');</script>";
  echo "<script>location.replace('../login.html');</script>";
  exit;
}
?>
