<?php
//테스트해봐야함
//error_reporting(E_ALL);
//ini_set("display_error",1);

include "db.php";

session_start();
/*
if(!$conn){
echo "연결에 실패하였습니다 : " .mysql_connect_error();
}
else {
echo "연결이 완료되었습니다! ";
}
*/

$id=$_POST['userid'];
$password=$_POST['userpw'];

$query="SELECT * FROM USER WHERE loginId ='$id'";

$result=$conn->query($query);

if($result->num_rows==1){
  $row=$result->fetch_array(MYSQLI_ASSOC); //하나의 열을 배열로 가져옴
  if($row['password'] == $password) {
    $_SESSION['loginId']=$id;
    if(isset($_SESSION['loginId'])) {
      $query2 = "SELECT * FROM USER WHERE loginId = '$id'";
      $result2 = mysqli_query($conn, $query2);
      $row = mysqli_fetch_array($result2);
      $_SESSION['uId'] = $row['uId'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['state'] = 0;
      header('Location: main.php');
    } else {
      echo "실패";
    }
  } else {
    echo "<script>alert('잘못된 아이디거나 패스워드입니다.');</script>";
    echo "<script>history.back();</script>";
  }
} else {
  echo "<script>alert('잘못된 아이디거나 패스워드입니다.');</script>";
  echo "<script>history.back();</script>";
}

?>
