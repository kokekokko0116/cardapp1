<?php
$id = $_GET["id"];

// id受け取り
include("functions.php");
session_start();
check_session_id();
$pdo = connect_db();

// DB接続
$sql = "SELECT * FROM cards WHERE id=:id";


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

// SQL実行
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カードリスト詳細</title>
</head>

<body>
  <form action="cardlist_update.php" method="POST">
    <fieldset>
      <legend>カードリスト詳細</legend>
      <a href="index.php">一覧画面</a>
      <div>
        シリーズ:<?= $result["series"] ?>
      </div>
      <div>
        ナンバー:<?= $result["number"] ?>
      </div>
      <div>
        レアリティ:<?= $result["rarelity"] ?>
      </div>
      <div>
        カード名:<?= $result["name"] ?>
      </div>
      <div>
        <input type="number" name="price" value="<?= $result["price"] ?>">
      </div>
      <div>
        <input type="number" name="amount" value="<?= $result["amount"] ?>">
      </div>
      <div>
        <input type="hidden" name="id" value="<?= $result["id"] ?>">
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>