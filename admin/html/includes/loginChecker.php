<?php
  session_start();
  if(!isset($_SESSION['login']) or $_SESSION['login'] != true){
    header('location: login.php');
    die();
  }
