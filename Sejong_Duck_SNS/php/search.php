<html>

<head>
  <meta charset='utf-8'>
  <title>꽥꽥이</title>
</head>
<link rel='stylesheet' href='../css/basicstyle.css'>
<link rel='stylesheet' href='../css/search.css'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.2/css/all.css' integrity='sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay' crossorigin='anonymous'>

<body>
  <div id='page-wrapper'>
    <header id='main-header'>
      <div class='header-item'>
        <a href='../home.html'><img src='../img/duck.jpg' alt='mark' class='main-mark'></a>
        <div class='search'>
          <form method='post' action='http://49.236.137.89/php/search.php'>
            <input type='text' placeholder='검색' name='name' value='이름을 입력하세요' required>
            <button type='submit' class='search-button'>검색</button>
          </form>
        </div>
        <div class='top-navigation'>
          <a href='../my.html'>
            <p class='top-navigation-item'>My</p>
          </a>
          <a href='http://49.236.137.89/php/logincheck.php'>
            <p class='top-navigation-item'>Log in/out</p>
          </a>
        </div>
      </div>
    </header>

    <div id='section-area'>
      <div class='section-text' style='overflow-y:scroll;'>
        <br>

<?php

include 'dbconn.php';
session_start();

if(isset($_SESSION['loginId'])) {
  $id = $_SESSION['loginId'];
  $query = "SELECT uId FROM USER WHERE loginId = '$id'";
  $result = mysqli_query($conn, $query);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);

  if($num) { //select row 있으면
    $uId = $row['uId'];
  }
}

$name = $_POST['name'];
$query = "CREATE VIEW search_view AS
SELECT u.name, p.* FROM USER AS u
INNER JOIN PROFILE AS p USING (uId) WHERE u.name LIKE '%$name%'";


//$query = "SELECT u.name, p.* FROM USER AS u INNER JOIN PROFILE AS p USING (uId) WHERE u.name LIKE '%$name%'";
//$query = "SELECT uId, loginId, name  FROM USER WHERE name like '%$name%'";
$result = mysqli_query($conn, $query);

$query = "SELECT v.*, f.uId AS 친구uId, f.frId, f.relation FROM search_view AS v
LEFT JOIN FRIENDS AS f ON v.uId=f.frId";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
//$row = mysqli_fetch_assoc($result);

if($num) { //select row 있으면
?>
        <table align='center'>
          <thead align='center'>
            <tr>
              <td style='width:30%;'>프로필사진</td>
              <td>친구정보</td>
              <td>친구맺기버튼</td>
            </tr>
          </thead>
          <tbody>

<?php
  while($row = mysqli_fetch_assoc($result)) {
    if($uId == $row['친구uId']) {
      if($row['relation'] == 2) { //차단한 친구를 검색한 경우
        continue; // 현재 부분 건너뛰고 다음 검색결과로
      }
    }

?>

            <tr>
              <form action = 'makeFriends.php' method = 'post'>
              <td><a href = '../my.html?id=<?php $row['uId'] ?>'><?php echo "<img src = '../img/profile/".$row['profile']."' style='position:relative; width:100%;vertical-align: bottom;'>" ?></a></td>
              <td><div style="width:100%; text-align:center;"><a href = '../my.html?id=<?php $row['uId'] ?>'><h3><?php echo $row['name'] ?></a></h3><br>
                <?php if($row['school'] != "") {
                  echo $row['school']." 입학";
                }  ?><br>
                <?php if($row['company'] != "") {
                  echo $row['company']." 근무";
                } ?><br>
                <?php if($row['residence'] != "") {
                  echo $row['residence']." 거주";
                } ?></div>
                <?php echo "<input type='hidden' name='uId' value='".$uId."'>" ?>
                <?php echo "<input type='hidden' name='frId' value='".$row['uId']."'>" ?>
              </td>
              <td>
                <?php
                if($uId == $row['uId']) { // 본인 아이디일 경우
                  echo "<input type='submit' name='submit' value='MY' style='width:80%;'>";
                } else {
                    if($uId == $row['친구uId']) {
                      if($row['relation'] == 1) { // 검색한 사람이 친구 상태이면
                        echo "<input type='submit' name='submit' value='친구' style='width:80%;'>";
                      } else if($row['relation'] == 0) { // 검색한 사람이 친구 상태가 아니면
                        echo "<input type='submit' name='submit' value='친구추가' style='width:80%;' onclick='alert('친구추가완료!')'>";
                    }
                  } else { // 검색한 사람이 친구 상태가 아니면
                      echo "<input type='submit' name='submit' value='친구추가' style='width:80%;' onclick='alert('친구추가완료!')'>";
                  }
                }
                 ?>
              </td>
              </form>
            </tr>

<?php
}
?>
          </tbody>
        </table>


<?php

$query = "drop view search_view";
$result = mysqli_query($conn, $query);
} else {
  $query = "drop view search_view";
  $result = mysqli_query($conn, $query);
  echo "검색한 내용을 찾을 수 없습니다.";
}


mysqli_close($conn);

?>

      </div>
    </div>

    <div class='right-navigation'>
      <a href='../timeline.html'>
        <p>타임라인</p>
      </a>
      <a href='../post.html'>
        <p>POST</p>
      </a>
      <a href='friendsList.php'>
        <p>친구 목록</p>
      </a>
      <a href='../setting.html'>
        <p>설정</p>
      </a>
    </div>



    <footer id='main-footer'>
      here is footer <br>
    </footer>

  </div>
</body>

</html>
