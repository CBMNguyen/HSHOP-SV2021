<?php
session_start();
if(!empty($_POST)){
  if(isset($_POST['message'])){
    if(isset($_SESSION['email'])){
      unset($_SESSION['email']);
    }

    if(isset($_SESSION['product'])){
      unset($_SESSION['product']);
    }
    session_destroy();
  }
}