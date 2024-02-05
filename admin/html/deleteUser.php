<?php
  include_once('includes/loginChecker.php');
  if(isset($_GET['id'])){
    include_once('../../includes/conn.php');
    try{
        $id = $_GET['id'];
        $sql = "DELETE FROM `users` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        header('location: users.php');
    }catch(PDOEXCEPTION $e){
        echo $e->getMessage();
    }
  }else{
    header('location: users.php');
    die();
  }
