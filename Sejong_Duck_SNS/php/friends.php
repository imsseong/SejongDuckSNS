<?php
include 'dbconn.php';

$uId = $_POST['uId'];
$frId = $_POST['frId'];

$query = "INSERT INTO FRIENDS (uId, frId, relation) VALUES ($uId, $frId, 1)";

if(!mysqli_query($conn, $query)) {
  die("친구 추가 에러 : " .mysqli_error($conn));
} else {
  echo "친구 추가가 완료되었습니다.";
}
//echo "<script>location.replace('search.php');</script>";
mysqli_close($conn);
?>
