<html>

<head>
  <meta charset='utf-8'>
  <title>꽥꽥이</title>
</head>
<link rel='stylesheet' href='../css/basicstyle.css'>
<link rel='stylesheet' href='../css/search.css'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.2/css/all.css' integrity='sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay' crossorigin='anonymous'>

<body>
  <?php include("check.php")?>
  <div id='page-wrapper'>
    <header id='main-header'>
      <div class='header-item'>
        <a href='../home.html'><img src='../img/duck.jpg' alt='mark' class='main-mark'></a>
        <div class='search'>
          <form method='post' action='search.php'>
            <input type='text' placeholder='검색' name='name' required>
            <button type='submit' class='search-button'>검색</button>
          </form>
        </div>
        <div class='top-navigation'>
          <a href='my.php'>
            <p class='top-navigation-item'>My</p>
          </a>
          <a href='logincheck.php'>
            <p class='top-navigation-item'>Log in/out</p>
          </a>
        </div>
      </div>
    </header>

    <div id='section-area'>
      <div class='section-text' style='overflow-y:scroll;'>
        <h1>&nbsp</h1>

<?php

include 'dbconn.php';
session_start();

/* 로그인 체크 */
if(isset($_SESSION['loginId'])) {
  $id = $_SESSION['loginId'];
  $query = "SELECT uId, loginId FROM USER WHERE loginId = '$id'";
  $result = mysqli_query($conn, $query);
  $num = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);

  if($num) { //select row 있으면
    $temp = $row['uId']; //로그인된 회원의 친구목록인지 확인을 위한 임시 변수
    $uId = $row['uId'];
  }
}

/* url id 파라미터 받기 */
if(isset($_GET['id'])) {
  $uId = $_GET['id'];
}

/* 친구 count 세기 */
$query = "SELECT relation, count(*) AS cnt FROM FRIENDS WHERE uId=$uId GROUP BY relation";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
if($num) { //select row 있으면
  while($row = mysqli_fetch_assoc($result)) {
    if($row['relation'] == 1) {
      $cnt = $row['cnt'];
      break;
    }
    $cnt = 0;
  }
} else {
  $cnt = 0;
}

/* 친구목록 view 만들기 */
$query = "CREATE VIEW friends_view AS
SELECT f.*, p.uId AS 친구uId, p.school, p.company, p.residence, p.profile
FROM FRIENDS AS f
INNER JOIN PROFILE AS p
ON f.frId = p.uId WHERE f.uId = $uId";
$result = mysqli_query($conn, $query);

/* 친구목록view와 user 테이블 join */
$query = "SELECT v.*, u.name FROM friends_view AS v INNER JOIN USER AS u ON v.frId = u.uId";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);

if($num) { //select row 있으면

?>
        <table align='center'>
          <thead align='center'>
            <tr>
              <td colspan='3' style='text-align:left; '><h2>친구 <?php echo "$cnt"; ?>명</h2></td>
            </tr>
          </thead>
          <tbody>

<?php
  while($row = mysqli_fetch_assoc($result)) {
    if($row['relation'] != 1) { // 친구가 아니라면
      continue; // 현재 부분 건너뛰고 다음 친구결과로
    }
?>

            <tr>
              <form action = 'delFriends.php' method = 'post'>
              <td style='width:30%;'><a href = 'my.php?id=<?php echo $row['frId'] ?>'><?php echo "<img src = '../img/profile/".$row['profile']."' style='position:relative; width:100%;vertical-align: bottom;'>" ?></a></td>
              <td style='width:55%;'><div style="width:100%; text-align:center;"><a href = 'my.php?id=<?php echo $row['frId'] ?>'><h3><?php echo $row['name'] ?></a></h3><br>
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
                <?php echo "<input type='hidden' name='frId' value='".$row['frId']."'>" ?>
              </td>
              <td>
                <?php
                if($uId == $temp) {
                ?>
                <select autofocus name="select" onchange="this.form.submit()">
                  <option selected value="친구">친구</option>
                  <option value="친구끊기">친구끊기</option>
                  <option value="차단">차단</option>
                </select>
                <?php
              } else {
                ?>
                <p>친구</p>
                <?php
              }
                ?>
              </td>
              </form>
            </tr>

<?php

    }
?>

            <tr>
              <td colspan=3 style='text-align:right;'>
                <?php
                if($uId == $temp) {
                ?>
                <a href='blockList.php'>
                  <p>차단친구관리</p>
                </a>
                <?php
                }
                ?>
              </td>
            </tr>
          </tbody>
        </table>


<?php
$query = "drop view friends_view";
$result = mysqli_query($conn, $query);

} else {
  $query = "drop view friends_view";
  $result = mysqli_query($conn, $query);
  echo "친구가 없습니다.";
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
