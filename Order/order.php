<?php
session_start();
require_once('../Database/config.php');

if(!empty($_POST)){
  if(!empty($_SESSION)){
    if(isset($_SESSION['product']) && isset($_SESSION['email'])){
      $UserSql = 'select * from khachhang where Email = "'.$_SESSION['email'].'"';
      $User =  executeResultOne($UserSql);

      $amountOrderSql = 'select count(SoDonDH) as amount from dathang';
      $amountOrder = executeResultOne($amountOrderSql);
      $orderSql = 'insert into dathang values ("'.$amountOrder['amount'].'", "'.$User['MSKH'].'", "19", "'.date("Y-m-d").'", "'.date("Y-m-d",mktime(0,0,0,date('m'),date('d')+2,date('Y'))).'", "Đợi xác nhận")';
      execute($orderSql);
      foreach($_SESSION['product'] as $product){
        $priceSql = 'select * from hanghoa where MSHH = "'.$product[0].'"';
        $price = executeResultOne($priceSql);
        $orderDetail = 'insert into chitietdathang values ("'.$amountOrder['amount'].'", "'.$product[0].'", "'.$product[1].'", "'.$price['GiamGia']*(int)$product[1].'", "0")';
        $updateAmount = 'update hanghoa set SoLuongHang = '.(int)$price['SoLuongHang'] - (int)$product[1] .' where MSHH = "'.$product[0].'"';
        execute($updateAmount);
        execute($orderDetail);
      }
    }
    $_SESSION['product'] = [];
  }
}
?>

