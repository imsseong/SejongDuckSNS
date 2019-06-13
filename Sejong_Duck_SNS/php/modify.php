<html>

<head>
  <meta charset="utf-8">
  <title>꽥꽥이</title>
</head>
<link rel="stylesheet" href="../css/basicstyle.css">
<link rel="stylesheet" href="../css/post.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

<body>
  <div id="page-wrapper">
    <header id="main-header">
      <div class="header-item">
        <a href="../home.html"><img src="../img/duck.jpg" alt="mark" class="main-mark"></a>
        <div class="search">
          <form method="post" action="search.php">
            <input type="text" placeholder="검색" name="name" required>
            <button type="submit" class="search-button">검색</button>
          </form>
        </div>
        <div class="top-navigation">
          <a href="my.php">
            <p class="top-navigation-item">My</p>
          </a>
          <a href="logincheck.php">
            <p class="top-navigation-item">Log in/out</p>
          </a>
        </div>
      </div>
    </header>

    <div id="section-area">
      <div class="section-text">

        <?php
        include 'db.php';

        session_start();

        $curpId = $_POST['postId'];

        $selectquery = "SELECT * FROM POST_CONTENT WHERE pId = $curpId";

        $result=$conn->query($selectquery);
        $row_num = $result->num_rows;
        $row=$result->fetch_array(MYSQLI_ASSOC);

        echo $row['content'];

        ?>

        <table id=radio-table>
          <caption>글 수정 하기 - 사진 추가 가능 / 기존 사진 변경 삭제 불가</caption>
          <tr>
            <td class="radio-td"><input type="radio" name="post" value="1" onclick="radioOnOff('text')" class="radio-event"> 텍스트</td>
            <td class="radio-td"><input type="radio" name="post" value="2" onclick="radioOnOff('image')" class="radio-event"> 이미지</td>
          </tr>
        </table>

        <br>
        <br>
        <br>

        <div id="textPost" style="display:none">
          <p>글을 입력해주새요</p><br>
          <form method="post" action="textpost.php">
            <textarea name="message1" rows="8" cols="80"><?php echo $row['content'];?></textarea>
            <button type="submit" name="button">작성하기</button>
            <button type="reset" name="button">다시작성</button>
          </form>

        </div>
        <div id="imagePost" style="display:none">
          <p>사진을 선택해주세요</p>
          <form method="post" action="imagepost.php" enctype="multipart/form-data">
            <textarea name="message2" rows="8" cols="80" placeholder="내용을 입력하세요."></textarea>
            <input type="file" name="upload_image" accept="image/*">
            <button type="submit" name="button">업로드 하기</button>
          </form>
        </div>

        <script>
          function radioOnOff(id) {
            if (id == "text") {
              document.all["textPost"].style.display = "";
              document.all["imagePost"].style.display = "none";
            } else {
              document.all["imagePost"].style.display = "";
              document.all["textPost"].style.display = "none";
            }
          }
        </script>
        <br><br><br><br>
      </div>
    </div>

    <div class="right-navigation">
      <a href="../home.html">
        <p>타임라인</p>
      </a>
      <a href="../post.html">
        <p>POST</p>
      </a>
      <a href="friendsList.php">
        <p>친구 목록</p>
      </a>
      <a href="../setting.html">
        <p>설정</p>
      </a>
    </div>



    <footer id="main-footer">
      here is footer <br>
    </footer>

  </div>
</body>

</html>
