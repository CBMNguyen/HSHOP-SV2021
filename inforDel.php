<?php
  session_start();
  $index = 0;
  if(!empty($_POST)){
    if(count($_SESSION['product']) === 1){
      $_SESSION['product'] = [];
    }
    if(isset($_POST['data'])){
      foreach($_SESSION['product'] as $product){
        if($product[0] === $_POST['data']){
          array_splice($_SESSION['product'], $index, 1);
        }
        $index++;
      }
    }
  }