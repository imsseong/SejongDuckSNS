<?php

  error_reporting(E_ALL);
  ini_set("display_errors",1);

  $conn = mysqli_connect("49.236.137.89","root","sjce-db123!@#","SejongDuckSNS");
  mysqli_query($conn,"SET NAMES utf8");

  if(!$conn){
  echo "연결에 실패하였습니다 : " .mysql_connect_error();
  }
  else {
  echo "연결이 완료되었습니다! ";
  }
  session_start();
  if(!isset($_SESSION['loginId'])) {
    header("location:https://imsseong.github.io/SejongDuckSNS/Sejong_Duck_SNS/login.html");
    echo "로그인이 필요합니다";
    exit;
  }

    $uId = "SELECT uId FROM USER WHERE loginId = '$_SESSION['loginId']'";
    $password = $_POST['password'];
    $school = $_POST['school'];
    $company = $_POST['company'];
    $residence = $_POST['residence'];

    $profileDir = "profile/";
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

  mysqli_close($conn);

?>
