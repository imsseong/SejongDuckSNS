<?php
include 'db.php';

session_start();

$curpId = $_POST['postId'];

$deletequery = "DELETE P, PC, L, R FROM
POST P LEFT JOIN POST_CONTENT PC ON P.pId = PC.pId
LEFT JOIN SejongDuckSNS.LIKE L ON P.pId = L.pId
LEFT JOIN REPLY R ON P.pId = R.pId
WHERE P.pId = $curpId";

if ($conn->query($deletequery) === TRUE) {
  echo '<script>history.back();</script>';
} else {
  echo "실패";
}

$conn->close();

?>
