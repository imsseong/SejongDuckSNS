<?php
include 'dbconn.php';
session_start();

if(!isset($_SESSION['loginId'])) {
  header("location: ../login.html");
  echo "로그인이 필요합니다";
  exit();
}

$uId = $_POST['uId'];
$frId = $_POST['frId'];
$submit = $_POST['submit'];
if($submit == "MY") {
    header("location: ../my.html?id=$uId");
} else if ($submit == "친구") {
  header("location: ../my.html?id=$frId");
} else if ($submit == "친구추가") {
  $query = "INSERT INTO FRIENDS (uId, frId, relation) VALUES ($uId, $frId, 1)";
  $prevPage = $_SERVER['HTTP_REFERER'];

  if(!mysqli_query($conn, $query)) {
    die("친구 추가 에러 : " .mysqli_error($conn));
  } else {
    echo "친구 추가가 완료되었습니다.";
    header("location: $prevPage");
  }
}

mysqli_close($conn);
?>
