<?php
  require_once('../../Database/config.php');
  if(!empty($_POST)){
    if(isset($_POST['MSKH'])){
      $MSKH = $_POST['MSKH'];

      $sql = 'delete from khachhang where MSKH = "'.$MSKH.'"';
      execute($sql);
    }
  }