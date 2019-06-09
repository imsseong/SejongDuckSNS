<?php

include "db.php";

session_start();

$curpId = $_POST['postId'];
$uId = $_SESSION['uId'];
$reply = $_POST["reply"];
$replyDate=date("Y-m-d H:i:s");

$query1 = "INSERT INTO REPLY(pId,uId,reple,reDate) VALUES ('$curpId','$uId','$reply','$replyDate')";

if ($conn->query($query1) === TRUE) {
  echo '<script>history.back();</script>';
} else {
  echo "실패";
}

$conn->close();

 ?>
