<?php
session_start();

if(!isset($_SESSION['loginId'])) { //세션이없을때 = 로그인상태가 아닐때
  header('Location: ../login.html');
} else {
  $res=session_destroy();
  if($res){
    echo "<script>alert('로그아웃 성공!');</script>";
    echo "<script>location.replace('../home.html');</script>";
  }
}
?>
