<?php

include "db.php";

$loginId=$_POST['loginId'];
$email=$_POST['email'].'@'.$_POST['emaddress'];
$password=$_POST['password'];
include "password.php";
$hash = password_hash($password,PASSWORD_DEFAULT);
$name=$_POST['name'];
$joinDate=date("Y-m-d");

$select = "SELECT * FROM USER WHERE loginId = '$loginId'";
$result=$conn->query($select);
$row_num = $result->num_rows;
if($result > 0){
  echo "<script>alert('중복된 아이디가 존재합니다.');</script>";
  echo '<script>history.back();</script>';
  exit;
}

$insert = "INSERT INTO
USER(loginId,email,password,name,joinDate,state)
VALUES ('$loginId','$email','$hash','$name','$joinDate',0)";

if(!mysqli_query($conn, $insert)) {
die("가입 에러 : " .mysqli_error($conn));
}
else {
  $query = "SELECT uId from USER WHERE loginId = '$loginId'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $uId = $row['uId'];
  $query = "INSERT INTO PROFILE VALUES ($uId, '', '', '', 'duck.jpg')";
  $result = mysqli_query($conn, $query);
echo "<script>alert('회원가입을 축하드립니다~ 짝짝짝~');</script>";
echo "<script>location.replace('../login.html');</script>";
}

mysqli_close($conn);

?>
