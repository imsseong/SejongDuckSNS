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
    header("location: my.php?id=$uId");
} else if ($submit == "친구") {
  header("location: my.php?id=$frId");
} else if ($submit == "친구추가") {
  $query = "SELECT * FROM FRIENDS WHERE uId=$uId AND frId=$frId";
  $result = mysqli_query($conn, $query);
  $num = mysqli_num_rows($result);
  if($num) { //select row 있으면
    $query = "UPDATE FRIENDS SET relation = 1 WHERE uId=$uId AND frId=$frId";
  } else {
    $query = "INSERT INTO FRIENDS (uId, frId, relation) VALUES ($uId, $frId, 1)";
  }

  $prevPage = $_SERVER['HTTP_REFERER'];

  if(!mysqli_query($conn, $query)) {
    die("친구 추가 에러 : " .mysqli_error($conn));
  } else {
    echo "<script>alert('친구 추가가 완료되었습니다~~ 친구 페이지로 이동합니다!!!');</script>";
    echo "<script>location.replace('my.php?id=$frId');</script>";
  }
}

mysqli_close($conn);
?>
