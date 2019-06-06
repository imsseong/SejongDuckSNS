<?php
include 'db.php';

session_start();

$curpId = $_POST['postId'];

$curuId = $_SESSION['uId'];

$like_check_query = "SELECT * FROM SejongDuckSNS.LIKE WHERE pId = $curpId AND uId = $curuId";

$like_check_result=$conn->query($like_check_query);

if($like_check_result->num_rows==1){ //좋아요가 있다.
  $like_delete_query = "DELETE FROM SejongDuckSNS.LIKE WHERE pId = $curpId AND uId = $curuId";

  $conn->query($like_delete_query);

  $like_minus_query = "UPDATE POST SET likes = likes - 1 WHERE pId = $curpId";

  $conn->query($like_minus_query);

} else { //좋아요가 없다
  $like_query = "INSERT INTO SejongDuckSNS.LIKE(pId,uId) VALUES('$curpId','$curuId')";

  $conn->query($like_query);

  $like_plus_query = "UPDATE POST SET likes = likes + 1 WHERE pId = $curpId";

  $conn->query($like_plus_query);
}

echo '<script>history.back();</script>';

 ?>
