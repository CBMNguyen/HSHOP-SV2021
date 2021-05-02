<?php
  require_once('../../Database/config.php');
  if(!empty($_POST)){
    if(isset($_POST['productId'])){
      $productId = $_POST['productId'];

      $sql = 'delete from hanghoa where MSHH = "'.$productId.'"';
      execute($sql);
    }
  }