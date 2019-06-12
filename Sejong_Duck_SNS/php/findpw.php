<?php

include "db.php";

$username=$_POST['name'];
$loginId=$_POST['id'];
$email=$_POST['email'].'@'.$_POST['emaddress'];


$select = "SELECT password FROM USER WHERE name = '$username' AND email = '$email' AND loginId = '$loginId'";
$result=$conn->query($select);
$row_num = $result->num_rows;
if($row_num == 0){
  echo "<script>alert('존재하지 않는 정보입니다.');</script>";
  echo '<script>history.back();</script>';
  exit;
} else {
  $row=$result->fetch_array(MYSQLI_ASSOC);
  $password = base64_decode($row['password']);

  echo "<script>alert('$username 님의 비밀번호는 $password 입니다');</script>";
  echo "<script>location.replace('../login.html');</script>";
}

mysqli_close($conn);

?>
