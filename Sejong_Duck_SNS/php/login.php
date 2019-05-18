<?php
//테스트해봐야함
error_reporting(E_ALL);
ini_set("display_errors",1);

session_start();

$conn = mysqli_connect("49.236.137.89","root","sjce-db123!@#");
mysqli_query($conn,"SET NAMES utf8");

if(!$conn){
echo "연결에 실패하였습니다 : " .mysql_connect_error();
}
else {
echo "연결이 완료되었습니다! ";
}

$id=$_POST['userid'];
$password=$_POST['userpw'];

$query="SELECT * FROM USER WHERE loginId ='$id'"

$result=$mysqli->query($query);

if($result->num_rows==1){
  $row=$result->fetch_array(MYSQLI_ASSOC); //하나의 열을 배열로 가져옴
  if($row['password']==$password) {
    $_SESSION['loginId']=$id;
    if(isset($_SESSION['loginId'])) {
      header('Location: main.php');
    } else {
      echo "실패";
    }
  } else {
    echo "잘못된 아이디나 패스워드입니다."
  }
} else {
  echo "잘못된 아이디나 패스워드입니다."
}

?>
