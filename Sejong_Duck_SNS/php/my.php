<html>

<head>
  <meta charset='utf-8'>
  <title>꽥꽥이</title>
</head>
<link rel='stylesheet' href='../css/basicstyle.css'>
<link rel='stylesheet' href='../css/search.css'>
<link rel='stylesheet' href='../css/my.css'>
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
        <h1>마이페이지 만들거야야야냠얌냐</h1>

<?php
include 'dbconn.php';
session_start();

/* 로그인 체크 */
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

/* 친구 count 세기 */
$query = "SELECT relation, count(*) AS cnt FROM FRIENDS WHERE uId=$uId GROUP BY relation";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
if($num) { //select row 있으면
  while($row = mysqli_fetch_assoc($result)) {
    if($row['relation'] == 1) {
      $cntF = $row['cnt'];
      break;
    }
    $cntF = 0;
  }
} else {
  $cntF = 0;
}

/* post count 세기 */
$query = "SELECT count(*) as cnt FROM POST WHERE uId = $uId";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);

if($num) { //select row 있으면
  $row = mysqli_fetch_assoc($result);
  $cntP = $row['cnt'];
}

/* 상단 my 정보 뿌리기 */
$query = "SELECT u.uId, u.name, p.* FROM USER AS u LEFT JOIN PROFILE AS p USING(uId) WHERE uId = $uId";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if($num) { //select row 있으면

?>

<table align='center'>
  <thead align='center'>
    <tr>
      <td rowspan='2' id='td_photo'><?php echo "<img src = '../img/profile/".$row['profile']."' style='border-radius: 50%;'>" ?></td>
      <td><h3><?php echo "$cntP"; ?></h3><p>게시물</p></td>
      <td><a href='friendsList.php'><h3><?php echo "$cntF"; ?></h3><p>친구</p></a></td>
    </tr>
    <tr>
      <td colspan='2'><a href='../setting.html'><div style='border:1px solid #808080; border-radius:10px'><h4>프로필 수정</h4></dvi></a></td>
    </tr>
    <tr style='text-align:left;'>
      <td colspan='3'><?php echo $row['name']; ?></td>
    </tr>
    <tr style='text-align:left;'>
      <td colspan='3'>
        <?php if($row['school'] != "") {
          echo $row['school']." 입학<br>";
        }  ?>
        <?php if($row['company'] != "") {
          echo $row['company']." 근무<br>";
        } ?>
        <?php if($row['residence'] != "") {
          echo $row['residence']." 거주";
        } ?>
      </td>
    </tr>
  </thead>
</table>


<?php
}
$postingType = 0;
?>

<table align='center'>
  <thead align='center'>
    <tr>
      <td style='width:50%;'><input type='button' id='btn_1' value='사진만' onclick='change1();'/></td>
      <td><input type='button' id='btn_2' value='타임라인처럼' onclick='change2();'/></td>

      <script type="text/javascript" src="http://code.jquery.com/jquery-3.2.0.min.js"></script>


    </tr>
  </thead>
</table>

<?php

/* post 정보 뿌리기 */
$query = "SELECT p.uId, p.type, p.views, p.likes, c.* FROM POST AS p
INNER JOIN POST_CONTENT AS c USING(pId) WHERE p.uId = $uId";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);

if($num) { //select row 있으면

?>
  <div id='my1' style='display:block;'>
    <table align='center'>
      <thead align='center'>


<?php
      for($i = 0; $i < ceil($num/3); $i++) {
        $cnt = 0;
?>
        <tr>
<?php
        while($row = mysqli_fetch_assoc($result)) {
?>

        <td id='td_content'><?php echo "<img src = '../img/upload/".$row['url']."' >" ?></td>
<?php
          $cnt ++;
          if($cnt == 3) {
            break;
          }
        }
?>
      </tr>
<?php
      }
?>


      </thead>
      </table>
    </div>
<?php

?>
  <div id='my2' style='display:none;'>
    <table align='center'>
    <thead align='center'>

<?php
    while($row = mysqli_fetch_assoc($result)) {
?>
      <tr>
      <td>타임라인 그거 뿌리기!!!!!!!!!!!!!!11</td>
      </tr>

<?php
    }
?>
    </thead>
    </table>
  </div>
<?php
}
?>

<?php

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

<script type="text/javascript">
function change1() {
  document.getElementById("my1").style.display="block";
  document.getElementById("my2").style.display="none";
}

function change2() {
  document.getElementById("my1").style.display="none";
  document.getElementById("my2").style.display="block";
}
</script>
