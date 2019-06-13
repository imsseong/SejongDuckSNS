<?php

include 'dbconn.php';

error_reporting(E_ALL);
ini_set("display_errors",1);

$query1 = "SELECT * FROM POST_CONTENT ORDER BY pId DESC LIMIT 3";

$result=$conn->query($query1);
$row_num = $result->num_rows;


while($row_num > 0) {
  $row=$result->fetch_array(MYSQLI_ASSOC);
  echo "row_num : ".$row_num;
  echo "pId : ".$row['pId'];
  echo "content : ".$row['content'];
  echo "url : ".$row['url'];
  echo "<br>";
  $row_num--;
}

?>
