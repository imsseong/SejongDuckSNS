<html>

<head>
  <meta charset='utf-8'>
  <title>꽥꽥이</title>
</head>
<link rel='stylesheet' type='text/css' href='../css/basicstyle.css?alter'>
<link rel='stylesheet' type='text/css' href='../css/search.css?alter'>
<link rel='stylesheet' type='text/css' href='../css/my.css?alter'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.8.2/css/all.css' integrity='sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay' crossorigin='anonymous'>
<script type="text/javascript" src="http://code.jquery.com/jquery-3.2.0.min.js"></script>

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
        <br>

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
$query = "SELECT u.uId, u.name, u.loginId, p.* FROM USER AS u LEFT JOIN PROFILE AS p USING(uId) WHERE uId = $uId";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
if($num) { //select row 있으면
$loginId = $row['loginId']; //post부분에서 보여질 글쓴이 아이디
$profile = $row['profile'];
?>

<table align='center'> <!-- user의 프로필 사진, 게시물 수, 친구 수, 프로필 수정으로 이동 버튼, 프로필 정보 보여주기 -->
  <thead align='center'>
    <tr>
      <td rowspan='2' id='td_photo'><?php echo "<img src = '../img/profile/".$row['profile']."' style='border-radius: 50%;'>" ?></td>
      <td><h3><?php echo "$cntP"; ?></h3><p>게시물</p></td>
      <td><a href='friendsList.php?id=<?php echo $uId ?>'><h3><?php echo "$cntF"; ?></h3><p>친구</p></a></td>
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

<table align='center'> <!-- 게시물을 보는 형식, 두가지 중 하나를 선택할 수 있도록 -->
  <thead align='center'>
    <tr>
      <td style='width:50%;'><input type='button' id='btn_1' value='' style='background: url("../img/view1.jpg") no-repeat; width:32px; height:32px;' onclick='change1();'/></td>
      <td><input type='button' id='btn_2' value='' style='background: url("../img/view2.jpg") no-repeat; width:32px; height:32px;' onclick='change2();'/></td>
    </tr>
  </thead>
</table>

<?php

/* post 정보 뿌리기 */
$query = "SELECT p.uId, p.type, p.likes, c.* FROM POST AS p
INNER JOIN POST_CONTENT AS c USING(pId) WHERE p.uId = $uId";
$result = mysqli_query($conn, $query);
$num = mysqli_num_rows($result);

if($num) { //select row 있으면

?>
<!-- 게시물 보는 형식 첫번째 : 사진만 보이도록 -->
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
          if($row['type'] == 1) {
      ?>

        <td id='td_content'><?php echo "<img src = '../img/upload/".$row['url']."' >" ?></td>
      <?php
          $cnt ++;
          if($cnt == 3) {
            break;
          }
        } else {
          continue;
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

<!-- 게시물 보는 형식 두번째 : 사진과 글 모두 보이도록(타임라인처럼) -->
  <div id='my2' style='display:none;'>
    <?php mysqli_data_seek($result, 0)?><!-- select한 포스트 결과의 인덱스를 0으로 -->
    <table align='center'>
    <thead align='center'>

    <?php
    while($row = mysqli_fetch_assoc($result)) {
      $pId = $row['pId']; //REPLY에서 댓글 내용 select 할 때 필요한 변수
    ?>
      <tr><!-- my페이지, post 글쓴이 -->
        <td style='border-top:2px solid teal;'>
          <b style='float:left; display:inline;'><?php echo "<img src='../img/profile/".$profile."' id='mini_profile'>".$loginId ?></b>
          <form class="edit-form" action="../modify.html" method="post">
            <input type="hidden" name="postId" value="<?php echo $row['pId'];?>">
            <input type="submit" class="modify-button" value="">
          </form>
          <form class="edit-form" action="delete.php" method="post">
            <input type="hidden" name="postId" value="<?php echo $row['pId'];?>">
            <input type="submit" class="delete-button" value="">
          </form>
        </td>
      </tr>
      <?php
      if($row['type'] == 1) { // 이미지 포스팅이면

      ?>
      <tr><!-- post 이미지 -->
        <td>
          <?php echo "<img src = '../img/upload/".$row['url']."' style='width:70%; height:auto;'>" ?>
        </td>
      </tr>
      <?php
      }
      ?>

      <tr><!-- 좋아요버튼, 댓글창버튼 -->
        <td>
          <form class="like-form" action="like.php" method="post" style="display:inline; float:left; width:40px;">
            <input type="hidden" name="postId" value="<?php echo $row['pId'];?>">
            <input type="submit" class="like-button" value="" style='text-align:left; background: url("../img/like.jpg") no-repeat; width:32px; height:32px' >
          </form>
          <form action="reply.php" method="post" style="display:inline; float:left; width:40px;">
            <input type="hidden" name="postId" value="<?php echo $row['pId'];?>">
            <input id="reply_id" type="submit" value="" style='text-align:left; background: url("../img/reply.jpg") no-repeat; width:32px; height:32px' >
          </form>
        </td>
      </tr>
      <tr><!-- 좋아요 수 -->
        <td>
          <b style='float:left; text-align:left; margin-left:0;'><?php echo $row['likes'] ?> 명이 좋아합니다.</b>
        </td>
      </tr>
      <tr><!-- post 내용 -->
        <td style='text-align:left;'>
          <?php echo $row['content'] ?>
        </td>
      </tr>
      <tr> <!-- 댓글 내용 -->
        <td>
          <hr/>
          <form id='reply_form'>
          <input type='text' name='reply' placeholder='댓글 달기'>
          <input type='hidden' id='pId' name='postId' value='<?php echo $row["pId"];?>'>
          <input type='submit' id='reply_btn' value='게시' style='color:blue; width:10%; floar:right;'>
          <div id='replies'>
          <?php
          $select = "SELECT r.*, u.loginId FROM REPLY AS r INNER JOIN USER as u USING (uId) WHERE pId=$pId";
          $res = mysqli_query($conn, $select);
          $nums = mysqli_num_rows($res);

          if($nums) { //select row 있으면

            while($rows = mysqli_fetch_assoc($res)) {
              if($rows['reple'] == "") {
                continue;
              }else {
              echo "<div style='text-align:left;'><b>".$rows['loginId']."</b> ".$rows['reple']."</div>";
              }
            }
          } else {
            continue;
          }


          ?>
          </div>
        </form>
        </td>
      </tr>

    <?php
    }
    ?>

    </thead>
    </table>
  </div>
<?php
}
mysqli_close($conn);
?>

      </div>
    </div>

    <div class='right-navigation'>
      <a href='../home.html'>
        <p>홈</p>
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



    <footer id="main-footer">
      copyright 2019. 홍성임, 이호진. All rights reserved<br>
    </footer>

  </div>
</body>

</html>

<script type="text/javascript">

function change1() { //게시물 보는 형식 첫번째 버튼 클릭시
  document.getElementById("my1").style.display="block";
  document.getElementById("my2").style.display="none";
}

function change2() { //게시물 보는 형식 두번째 버튼 클릭시
  document.getElementById("my1").style.display="none";
  document.getElementById("my2").style.display="block";
}

$(document).ready(function(){
		showReply();
});

var str="";
function showReply(){
		var pId = $("#pId").val();
		$.getJSON("reply_list.php?pId="+pId, function(data){
			console.log(data);

			$(data).each(function(){
				console.log(data);

				str += "writer : "+this.writer+"<br>" +
					"content : " +
					this.content + "<br>";
			});


			$("#replies").html(str);
		});
}


$(document).on("click", "#reply_btn", function() {

    var formData = $("#reply_form").serialize();

    $.ajax({
      type : 'POST',
      url : 'reply.php',
      data : formData,
      success : function(response) {
        alert("성공~~~~~~~~~~~~");
        alert(response);
      }
    });

});


</script>
