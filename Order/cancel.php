<?php
  require_once('../Database/config.php');
  if(!empty($_POST)){
    if(isset($_POST['data'])){
      $findAmountSql = 'select * from chitietdathang where SoDonDH = '.$_POST['data'].'';
      $result = executeResult($findAmountSql);
      
      foreach($result as $amount){
        $currentGoodsSql = 'select * from hanghoa where MSHH = "'.$amount['MSHH'].'"';
        $currentGoods = executeResultOne($currentGoodsSql);
        $updateAmount = 'update hanghoa set SoLuongHang = '.(int)$currentGoods['SoLuongHang'] + (int)$amount['SoLuong'].' where MSHH = "'.$amount['MSHH'].'"';
        execute($updateAmount);
      }

      $sql = 'delete from chitietdathang where SoDonDH = '.$_POST['data'].'';
      execute($sql);
      $sql = 'delete from dathang where SoDonDH = '.$_POST['data'].'';
      execute($sql);
    }
  }