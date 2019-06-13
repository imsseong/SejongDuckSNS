<?php
//error_reporting(E_ALL);
//ini_set("display_error",1);

include "db.php";

session_start();
//$type = '0';
$uId = $_SESSION['uId'];
$postDate=date("Y-m-d H:i:s");
$view = 0; //타임라인과 연동
$like = 0; //타임라인과 연동
$content = $_POST["message2"];

$uploadDir = "../img/upload/";
$fileName = basename($_FILES['upload_image']['name']);
$uploadPath = $uploadDir . $fileName;
$fileType = pathinfo($uploadPath,PATHINFO_EXTENSION);

if(!empty($_FILES["upload_image"]["name"])){
  $allowTypes = array('jpg','png','jpeg','gif');
  if(in_array($fileType, $allowTypes)){
    if(!move_uploaded_file($_FILES["upload_image"]["tmp_name"], $uploadPath)) {
      //profile 폴더로 파일 업로드 실패
      echo "파일 업로드 에러";
    }
  } else {
    echo "only JPG, JPEG, PNG, GIF files are allowed to upload";
  }
}

$query1 = "INSERT INTO POST(type,uId,postDate,likes) VALUES (1,'$uId','$postDate','$like')";
//선. POST테이블에 글 정보 넣고
//후. POST_WRITING 테이블로 pId 값 가져가고... content 삽입

if ($conn->query($query1) === TRUE) {
    $last_id = $conn->insert_id;  //최근에 Auto로 증가된 pId 값 가져오기
    $query2 = "INSERT INTO POST_CONTENT(pId, content, url) VALUES ('$last_id','$content','$fileName')";
    if(!mysqli_query($conn,$query2)) {
      die("작성 에러 : " .mysqli_error($conn));
    } else {
    echo "<script>alert('글 작성이 완료되었습니다.');</script>";
    echo "<script>location.replace('../home.html');</script>";
  }
    //echo "New record created successfully. Last inserted ID is: " . $last_id;
    //var_dump($_SESSION);
} else {
    echo "Error: " . $query1 . "<br>" . $conn->error;
}

$conn->close();
//삽입된 pId 판별 및 POST_WRITING테이블에 삽입되는 pId 와 image포스트 테이블 차이주기


//printf("Last inserted record has id %d\n", mysql_insert_id());

//echo "<script>alert('포스팅 성공');</script>";
//echo "<script>location.replace('../home.html');</script>";

?>
