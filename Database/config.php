<?php

const HOST = 'localhost';
const USERNAME = 'root';
const PASSWORD = '';
const DATABASE = 'Quanlydathang';

// const HOST = 'remotemysql.com';
// const USERNAME = 'nRZCFRiu5m';
// const PASSWORD = '7LRGaFg8wg';
// const DATABASE = 'nRZCFRiu5m';

//insert update delete

function execute($sql){
  $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
  mysqli_set_charset($conn, 'utf8');

  //query data
  mysqli_query($conn, $sql);

  if($conn->connect_error){
    var_dump($conn->connect_error);
    die();
  }

  mysqli_close($conn);
}

// select rows

function executeResult($sql){
  $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
  mysqli_set_charset($conn, 'utf8');

  if($conn->connect_error){
    var_dump($conn->connect_error);
    die();
  }

  $result = mysqli_query($conn, $sql);
  $data = [];
  while($row = mysqli_fetch_array($result, 1)){
    $data[] = $row;
  }

  mysqli_close($conn);
  return $data;
}

function executeResultOne($sql){
  $conn = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
  mysqli_set_charset($conn, 'utf8');

  if($conn->connect_error){
    var_dump($conn->connect_error);
    die();
  }

  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result, 1);

  mysqli_close($conn);
  return $row;
}
