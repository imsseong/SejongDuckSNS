<?php
//테스트해봐야함
//error_reporting(E_ALL);
//ini_set("display_errors",1);

include "db.php";

$loginId=$_POST['loginId'];
$email=$_POST['email'].'@'.$_POST['emaddress'];
$password=$_POST['password'];
$name=$_POST['name'];
$joinDate=date("Y-m-d");

$select = "SELECT * FROM USER WHERE loginId = '$loginId'";
$result=$conn->query($select);
if($result->num_rows==1){
  echo "<script>alert('중복된 아이디가 존재합니다.');</script>";
  //중복계정 생성 예외합니다.
}

$insert = "INSERT INTO
USER(loginId,email,password,name,joinDate,state)
VALUES ('$loginId','$email','$password','$name','$joinDate',0)";

if(!mysqli_query($conn, $insert)) {
die("가입 에러 : " .mysqli_error($conn));
}
else {
echo "<script>alert('회원가입을 축하드립니다~ 짝짝짝~');</script>";
echo "<script>location.replace('../login.html');</script>";
}

mysqli_close($conn);

?>
