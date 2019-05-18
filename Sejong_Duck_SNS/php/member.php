<?php
//테스트해봐야함
error_reporting(E_ALL);
ini_set("display_errors",1);

$conn = mysqli_connect("49.236.137.89","root","sjce-db123!@#");
mysqli_query($conn,"SET NAMES utf8");

if(!$conn){
echo "연결에 실패하였습니다 : " .mysql_connect_error();
}
else {
echo "연결이 완료되었습니다! ";
}

$loginId=$_POST['loginId'];
$email=$_POST['email'];
$password=$_POST['password'];
$name=$_POST['name'];
$joinDate=date("Y-m-d");

$selectquery = "SELECT * from USER where loginId = '$loginId'";
$result=$mysqli->qeury($selectquery);
if($result->num_rows==1){
  echo "<script>alert('중복된 아이디가 존재합니다.');</script>";
}

$insertquery = "INSERT INTO
USER(loginId,email,password,name,joinDate,state)
VALUES ('$loginId','$email','$password','$name','$joinDate',0)";

if(!mysqli_query($conn, $insertquery)) {
die("가입 에러 : " .mysqli_error($conn));
}
else {
echo "회원가입이 완료되었습니다.";
}

mysqli_close($conn);

?>
