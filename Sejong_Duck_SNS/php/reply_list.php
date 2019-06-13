<?
	include 'dbconn.php';
  session_start();

	$pId = $_GET['pId'];

	$query = "SELECT r.*, u.loginId FROM REPLY AS r INNER JOIN USER AS u USING (uId) WHERE pId = $pId";

	$result = mysql_query($query) or die("Error :	" . mysql_error());

	$resultArray = array();

	while($row = mysql_fetch_array($result)){
	     array_push($resultArray,
		array('writer' => $row['loginId'], 'content' => $row['reple']));
	}

	echo json_encode($resultArray);

?>
