<?php

include "db.php";

$username=$_POST['name'];
$email=$_POST['email'].'@'.$_POST['emaddress'];


$select = "SELECT loginId FROM USER WHERE name = '$username' AND email = '$email'";
$result=$conn->query($select);
$row_num = $result->num_rows;
if($row_num == 0){
  echo "<script>alert('아이디가 존재하지 않습니다.');</script>";
  echo '<script>history.back();</script>';
  exit;
} else {
  $row=$result->fetch_array(MYSQLI_ASSOC);
  $id = $row['loginId'];
  echo "<script>alert('$username 님의 아이디는 $id 입니다');</script>";
  echo "<script>location.replace('../login.html');</script>";
}

mysqli_close($conn);

?>
