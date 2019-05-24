<?php

include 'dbconn.php';

error_reporting(E_ALL);
ini_set("display_errors",1);

session_start();

if(!isset($_SESSION['loginId'])) {
  header("location: ../login.html");
  echo "로그인이 필요합니다";
  exit();
}

$id = $_SESSION['loginId'];
$query = "SELECT uId FROM USER WHERE loginId = '$id'";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
//$row = mysqli_fetch_array($result);

if($num) { //select row 있으면
  $uId = $row['uId']; //$row['uId'];
}

//echo "S".$_SESSION['loginId']."E";

//echo history.go(-1); // 전 페이지로 돌아가기

$school = $_POST['school'];
$company = $_POST['company'];
$residence = $_POST['residence'];
$password = $_POST['password'];


$profileDir = "../img/profile/";
$fileName = basename($_FILES['profile']['name']);
$profilePath = $profileDir . $fileName;
$fileType = pathinfo($profilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["profile"]["name"])){
  $allowTypes = array('jpg','png','jpeg','gif');
  if(in_array($fileType, $allowTypes)){
    if(!move_uploaded_file($_FILES["profile"]["tmp_name"], $profilePath)) {
      //profile 폴더로 파일 업로드 실패
      echo "파일 업로드 에러";
    }
  } else {
    echo "only JPG, JPEG, PNG, GIF files are allowed to upload";
  }
}

$query = "UPDATE PROFILE
SET school = '$school', company = '$company', residence = '$residence', profile = '$fileName'
WHERE uId = $uId";

if(!mysqli_query($conn, $query)) {
  die("프로필 수정 에러 : " .mysqli_error($conn));
} else {
  echo "프로필 수정이 완료되었습니다.";
}

if(!empty($_POST["password"])) {
  $query = "UPDATE USER
  SET password = '$password' WHERE uId = $uId";

  if(!mysqli_query($conn, $query)) {
    die("비밀번호 수정 에러 : " .mysqli_error($conn));
  } else {
    echo "비밀번호 수정이 완료되었습니다.";
  }
}

echo "<script>location.replace('../home.html');</script>";

mysqli_close($conn);

?>
