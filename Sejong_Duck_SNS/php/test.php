<?php
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

mysqli_select_db($conn,"SejongDuckSNS");

$loginId=$_POST['u1'];
$email=$_POST['u2'];
$password=$_POST['u3'];
$name=$_POST['u4'];
$joinDate=date("Y-m-d");

$query = "INSERT INTO 
USER(loginId,email,password,name,joinDate,state) 
VALUES ('$loginId','$email','$password','$name','$joinDate',0)";


if(!mysqli_query($conn, $query)) {
die("가입 에러 : " .mysqli_error($conn));
}
else {
echo "회원가입이 완료되었습니다.";
}

mysqli_close($conn);
?>
