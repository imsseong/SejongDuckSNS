<?php

include 'dbconn.php';

error_reporting(E_ALL);
ini_set("display_errors",1);

session_start();

/* 로그인 체크 */
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

/* 회원 상태 변경 */
$select = $_POST['select'];
if($select == '활성화') { //state=0 활성화``
  $query = "UPDATE USER SET state=0 WHERE uId = $uId";
  if(!mysqli_query($conn, $query)) {
    die("활성화 에러 : " .mysqli_error($conn));
  } else {
    $_SESSION['state'] = 0;
    echo "활성화가 완료되었습니다.";
  }
} else if($select == '비활성화') { //state=1 비활성화
  $query = "UPDATE USER SET state=1 WHERE uId = $uId";
  if(!mysqli_query($conn, $query)) {
    die("비활성화 에러 : " .mysqli_error($conn));
  } else {
    $_SESSION['state'] = 1;
    echo "비활성화가 완료되었습니다.";
  }
} else if($select == '탈퇴') { //탈퇴
  $selectquery = "SELECT * FROM SejongDuckSNS.LIKE WHERE uId = $uId";

  if(mysqli_query($conn, $selectquery)) {
    $result2 = $conn->query($selectquery);
    $row_num = $result2->num_rows;

    while($row_num > 0) {
      $row2=$result2->fetch_array(MYSQLI_ASSOC);
      $curpId = $row2['pId'];
      $updatequery = "UPDATE POST SET likes = likes - 1 WHERE pId = $curpId";
      mysqli_query($conn, $updatequery);
      $row_num--;
    }

    $deletequery = "DELETE U, P, PC, L, R FROM USER U
    LEFT JOIN POST P ON U.uId = P.uId
    LEFT JOIN SejongDuckSNS.LIKE L ON U.uId = L.uId
    LEFT JOIN REPLY R ON U.uId = R.uId
    LEFT JOIN POST_CONTENT PC ON P.pId = PC.pId
    WHERE U.uId = $uId";

    if(mysqli_query($conn, $deletequery)){

      $res=session_destroy();
      echo "<script>alert('탈퇴 성공!');</script>";
      echo "<script>location.replace('../home.html');</script>";
    }
  }
}

/* 학교, 회사, 거주지, 비밀번호를 POST로 받아오기 */
$school = $_POST['school'];
$company = $_POST['company'];
$residence = $_POST['residence'];
$password = $_POST['password'];

/* 프로필사진 urL 받아오기 */
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

/* 학교, 회사, 거주지, 비밀번호, 프로필 사진 변경 */
if($fileName == "") {
  $fileName = 'duck.jpg';
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
