<?php
session_start();
include("functions.php");
check_session_id();
$username = $_SESSION["username"];

$pdo = connect_db();

$sql = "";
if (isset($_GET["series_select"])) {
  $series_select = $_GET["series_select"];
  if ($series_select === "series") {
    $sql = "SELECT * FROM cards WHERE username='$username' AND WHERE series=$series_select ORDER BY price DESC";
  } else $sql = "SELECT * FROM cards WHERE series='$series_select' ORDER BY price DESC";
} else {
  $sql = "SELECT * FROM cards WHERE username='$username' ORDER BY price DESC";
}

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
      <td>
      <a href='cardlist_edit.php?id={$record["id"]}'>
      {$record["name"]}</td>
      </a>
      <td>{$record["price"]}</td>
      <td>{$record["amount"]}</td>
      
    </tr>
    
  ";
}
$sum = 0;
foreach ($result as $record) {
  $sum += (int)$record["price"] * (int)$record["amount"];
}
$series_select = "";
$series_box = [];
foreach ($result as $record) {
  if (!in_array($record["series"], $series_box)) {
    $series_select .= "
    <option value={$record["series"]}>{$record["series"]}</option>
    ";
    array_push($series_box, $record["series"]);
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<header ><h2><?= $username ?>のカードフォルダ</h2></header>
<body>
  <a href="cardlist_input.php">入力画面</a>
  <a href="cardlist_logout.php">logout</a>

  <form action="index.php" method="$_GET">
    <fieldset>
      <div>
      <select name="series_select">
        <option value="series">全て</option>
        <?= $series_select ?>
      </select>
      <button>検索</button>
      </div>
    </fieldset>
  </form>
  <fieldset>
    <legend>所有カード一覧</legend>
    <table class="table table-striped table-hover">
      <thead>
        <tr class="table-primary">
          <th scope="col">rarelity</th>
          <th scope="col">name</th>
          <th scope="col">price</th>
          <th scope="col">amount</th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
        <tr>
          <td></td>
          <td></td>
          <td>合計額</td>
          <td><?= $sum ?></td>
        </tr>
      </tbody>
    </table>
  </fieldset>



</body>
<script>
</script>

</html>