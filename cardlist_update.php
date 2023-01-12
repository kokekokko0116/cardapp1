<?php
// var_dump($_POST);
// exit();
include("functions.php");



if (
  !isset($_POST['price']) || $_POST['price'] === '' ||
  !isset($_POST['amount']) || $_POST['amount'] === ''
) {
  exit('paramError');
}

$id = $_POST["id"];
$price = $_POST["price"];
$amount = $_POST["amount"];

// DB接続
$pdo = connect_db();

if((int)$amount === 0){
  // 削除
  $sql = 'DELETE FROM cards WHERE id=:id';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_STR);
  
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
}else{
  // 更新
  $sql = 'UPDATE cards SET price=:price, amount=:amount, updated_at=now() WHERE id=:id';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':price', $price, PDO::PARAM_STR);
  $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
  $stmt->bindValue(':id', $id, PDO::PARAM_STR);
  
  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
}

header("Location:index.php");
exit();