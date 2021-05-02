<?php
  require_once('../../Database/config.php');
  if(!empty($_POST)){
    if(isset($_POST['MSNV'])){
      $MSNV = $_POST['MSNV'];

      $sql = 'delete from nhanvien where MSNV = "'.$MSNV.'"';
      execute($sql);
    }
  }