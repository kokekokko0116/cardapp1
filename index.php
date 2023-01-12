<?php
include("functions.php");

$pdo = connect_db();

$sql = 'SELECT * FROM cards ORDER BY price ASC';

$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  $output .= "
    <tr>
      <td>{$record["rarelity"]}</td>
      <td>{$record["name"]}</td>
      <td>{$record["price"]}</td>
      <td>{$record["amount"]}</td>
      <td>
      <a href='cardlist_edit.php?id={$record["id"]}'>編集</a>
      </td>
    </tr>
  ";
}
$sum = 0;
foreach($result as $record) {
  $sum += (int)$record["price"] * (int)$record["amount"];
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <a href="cardlist_input.php">入力画面</a>
  <legend>所有カード一覧</legend>
  <table>
    <thead>
      <tr>
        <th>rarelity</th>
        <th>name</th>
        <th>price</th>
        <th>amount</th>
      </tr>
    </thead>
    <tbody>
      <?= $output ?>
    </tbody>
  </table>
  <div>合計:<?= $sum ?></div>
  </fieldset>
</body>
<script>
const down = document.getElementById("down");
const up = document.getElementById("up");
const amount = document.getElementById("amount");

down.addEventListener("click", (event) => {
  if(text.value >= 1){
    text.value--;
  }
});
up.addEventListener("click", (event)=>{
  text.value++;
});
</script>

</html>