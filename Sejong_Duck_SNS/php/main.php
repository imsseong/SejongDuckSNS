<?php
session_start();

if(!isset($_SESSION['loginId'])) {
  header('Location: ../main.html');
}

?>
