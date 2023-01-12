<?php
// var_dump($_POST);
// exit();
include("functions.php");


if (
  !isset($_POST['series']) || $_POST['series'] === '' ||
  !isset($_POST['number']) || $_POST['number'] === '' ||
  !isset($_POST['rarelity']) || $_POST['rarelity'] === '' ||
  !isset($_POST['name']) || $_POST['name'] === '' ||
  !isset($_POST['price']) || $_POST['price'] === '' ||
  !isset($_POST['amount']) || $_POST['amount'] === ''
) {
  exit('paramError');
}

$series = $_POST["series"];
$number = $_POST["number"];
$rarelity = $_POST["rarelity"];
$name = $_POST["name"];
$price = $_POST["price"];
$amount = $_POST["amount"];

// DB接続
$pdo = connect_db();

$sql = 'INSERT INTO cards(id, series, number, rarelity, name, price, amount, updated_at) VALUES(NULL, :series, :number, :rarelity, :name, :price, :amount, now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':series', $series, PDO::PARAM_STR);
$stmt->bindValue(':number', $number, PDO::PARAM_STR);
$stmt->bindValue(':rarelity', $rarelity, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':price', $price, PDO::PARAM_STR);
$stmt->bindValue(':amount', $amount, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:cardlist_input.php");
exit();