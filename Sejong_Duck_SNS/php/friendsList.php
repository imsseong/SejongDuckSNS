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
          <a href='../my.html'>
            <p class='top-navigation-item'>My</p>
          </a>
          <a href='logincheck.php'>
            <p class='top-navigation-item'>Log in/out</p>
          </a>
        </div>
      </div>
    </header>

    <div id='section-area'>
      <div class='section-text'>
        <h1>검색결과</h1>

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
$query = "SELECT f.*, p.* FROM FRIENDS AS f INNER JOIN PROFILE AS p ON f.frId = p.uId WHERE f.uId = $uId";
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
              <td>친구끊기버튼</td>
            </tr>
          </thead>
          <tbody>

<?php
  while($row = mysqli_fetch_assoc($result)) {
?>

            <tr>
              <form action = 'delFriends.php' method = 'post'>
              <td><a href = '../my.html?id=<?php $row['frId'] ?>'><?php echo "<img src = '../img/profile/".$row['profile']."' style='position:relative; width:100%;vertical-align: bottom;'>" ?></a></td>
              <td><div style="width:100%; text-align:center;"><a href = '../my.html?id=<?php $row['uId'] ?>'><h3><?php echo $row['name'] ?></a></h3><br>
                <?php echo $row['school']." 입학" ?><br>
                <?php echo $row['company']." 근무" ?><br>
                <?php echo $row['residence']." 거주" ?></div>
                <?php echo "<input type='hidden' name='uId' value='".$uId."'>" ?>
                <?php echo "<input type='hidden' name='frId' value='".$row['uId']."'>" ?>
              </td>
              <td>
                <input type='submit' name='submit' value='친구끊기' style='width:80%;' onclick='alert('친구끊기완료!')'>
              </td>
              </form>
            </tr>

<?php

    }

?>
          </tbody>
        </table>


<?php


} else {
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
