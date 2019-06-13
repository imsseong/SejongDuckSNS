<?php
include 'dbconn.php';
session_start();

if(!isset($_SESSION['loginId'])) {
  header("location: ../login.html");
  echo "로그인이 필요합니다";
  exit();
}

if(isset($_POST['select'])) {
  $uId = $_POST['uId'];
  $frId = $_POST['frId'];
  $select = $_POST['select'];
  $prevPage = $_SERVER['HTTP_REFERER'];
  if($select == "친구") {
    header("location: $prevPage");
  } else if ($select == "친구끊기") {
    $query = "UPDATE FRIENDS SET relation=0 WHERE uId=$uId AND frId=$frId";
    if(!mysqli_query($conn, $query)) {
      die("친구 끊기 에러 : " .mysqli_error($conn));
    } else {
      echo "친구 끊기가 완료되었습니다.";
      header("location: $prevPage");
    }
  } else if ($select == "차단") {
    $query = "UPDATE FRIENDS SET relation=2 WHERE uId=$uId AND frId=$frId";
    if(!mysqli_query($conn, $query)) {
      die("친구 차단 에러 : " .mysqli_error($conn));
    } else {
      echo "친구 차단 완료되었습니다.";
      header("location: $prevPage");
    }
  }
}

if(isset($_POST['block'])) {
  $uId = $_POST['uId'];
  $frId = $_POST['frId'];
  $block = $_POST['block'];
  $prevPage = $_SERVER['HTTP_REFERER'];
  if($block == "차단") {
    echo"차단한다";
    header("location: $prevPage");
  } else if ($block == "차단풀기") {
      $query = "UPDATE FRIENDS SET relation=1 WHERE uId=$uId AND frId=$frId";
      if(!mysqli_query($conn, $query)) {
        die("차단 풀기 에러 : " .mysqli_error($conn));
      } else {
        echo "차단 풀기가 완료되었습니다.";
        header("location: $prevPage");
      }
  }
}

mysqli_close($conn);

?>
